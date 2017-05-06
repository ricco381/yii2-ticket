<?php

namespace ricco\ticket\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use ricco\ticket\Module;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFiles;
    public $nameFile;

    /** @var  Module */
    private $module;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->module = Module::getInstance();
        parent::init();
    }

    public function rules()
    {
        return [
            [['imageFiles'], 'file',
                'skipOnEmpty' => true,
                'extensions' => $this->module->uploadFilesExtensions,
                'maxFiles' => $this->module->uploadFilesMaxFiles,
                'maxSize' => $this->module->uploadFilesMaxSize
            ],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $dir = $this->module->uploadFilesDirectory;
            $dirReduced = $this->module->uploadFilesDirectory.'/reduced';

            if (!file_exists(Yii::getAlias($dir))) {
                mkdir(Yii::getAlias($dir));
                mkdir(Yii::getAlias($dirReduced));
            }

            foreach ($this->imageFiles as $file) {
                $hashName = md5($file->baseName . time()) . '.' . $file->extension;
                $fullHashName = Yii::getAlias($dir) . '/'. $hashName;
                $fullReducedHashName = Yii::getAlias($dirReduced) . '/'. $hashName;
                $this->nameFile[] = ['real' => $hashName, 'document' => $file->baseName . '.' . $file->extension];
                $file->saveAs($fullHashName);
                $this->resice($fullHashName, 1024);
                copy($fullHashName, $fullReducedHashName);
                $this->resice($fullReducedHashName, 100);
            }
            return true;
        } else {
            return false;
        }
    }

    public function getName()
    {
        return $this->nameFile;
    }

    public function resice($src, $widthNew)
    {
        if (!$this->isImage($src)) {
            return false;
        }
		
        $size = getimagesize($src);

        $format = strtolower(substr($size['mime'], strpos($size['mime'], '/')+1));
        $icfunc = "imagecreatefrom" . $format;

        $width = $size[0];
        $height = $size[1];

        if( $height > $width ) {
            // коэффициент
            $k = $widthNew / $height;
            $new_w = round( $width * $k );
            $new_h = $widthNew;

        } elseif( $width >= $height ) {
            // коэффициент
            $k = $widthNew / $width;
            $new_w = $widthNew;
            $new_h = round( $height * $k );
        }

        $isrc = $icfunc($src);
        $idest = imagecreatetruecolor($new_w, $new_h);

        imagecopyresampled($idest, $isrc, 0, 0, 0, 0,
            $new_w, $new_h, $width, $height);

        imagejpeg($idest, $src, 100);
    }

	    protected function isImage($src)
    {
        $mimeType = mime_content_type($src);
        return substr($mimeType, 0, 5) == 'image';
    }
	
}
