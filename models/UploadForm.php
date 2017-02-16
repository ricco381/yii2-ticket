<?php

namespace ricco\ticket\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFiles;
    public $nameFile;

    const DIR = 'fileTicket/';
    const DIR_REDUCED = 'fileTicket/reduced/';

    public function rules()
    {
        return [
            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxFiles' => 5],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            if (!file_exists(Yii::getAlias('@webroot') . "/fileTicket")) {
                mkdir(Yii::getAlias('@webroot') . "/fileTicket");
                mkdir(Yii::getAlias('@webroot') . "/fileTicket/reduced");
            }
            
            foreach ($this->imageFiles as $file) {
                $this->nameFile[] = md5($file->baseName . time()) . '.' . $file->extension;
                $file->saveAs(Yii::getAlias('@webroot') . self::DIR . md5($file->baseName . time()) . '.' . $file->extension);
                $this->resice(Yii::getAlias('@webroot') . self::DIR . md5($file->baseName . time()) . '.' . $file->extension, 1024);
                copy(Yii::getAlias('@webroot') .self::DIR . md5($file->baseName . time()) . '.' . $file->extension, Yii::getAlias('@webroot') . '/fileTicket/reduced/' . md5($file->baseName . time()) . '.' . $file->extension);
                $this->resice(Yii::getAlias('@webroot') . self::DIR_REDUCED . md5($file->baseName . time()) . '.' . $file->extension, 100);
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
    
}
