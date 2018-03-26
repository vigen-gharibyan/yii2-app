<?php

namespace common\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public $excelFile;

    public function rules()
    {
        return [
        //  [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
            [['excelFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xls, xlsx'],
        ];
    }

    public function upload($file = 'imageFile', $sub_folder = '')
    {
        $dir = 'uploads/';
        if (!empty($sub_folder)) {
            $dir .= $sub_folder . '/';
        }

        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        if ($this->validate()) {
            $path = $dir . $this->$file->baseName . '.' . $this->$file->extension;
            $this->$file->saveAs($path);
            return $path;
        } else {
            return false;
        }
    }

    public function uploadImage($folder = 'images')
    {
        return $this->upload('imageFile', $folder);
    }

    public function uploadExcel($folder = 'tmp')
    {
        return $this->upload('excelFile', $folder);
    }

}