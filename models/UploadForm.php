<?php

namespace ricco\ticket\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFiles;
    
    public $nameFile;

    public function rules()
    {
        return [
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxFiles' => 5],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            foreach ($this->imageFiles as $file) {
                $this->nameFile[] = md5($file->baseName . time()) . '.' . $file->extension;
                $file->saveAs('fileTicket/' . md5($file->baseName . time()) . '.' . $file->extension);
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
    
    
}