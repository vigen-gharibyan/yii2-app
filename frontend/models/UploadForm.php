<?php
namespace frontend\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $file;

    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false, /*'extensions' => 'png, jpg'*/],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $ext = pathinfo($this->file->name, PATHINFO_EXTENSION);
            $this->file->name = uniqid() .'.'. $ext;
            $this->file->saveAs('uploads/' . $this->file->baseName . '.' . /*$this->file->extension*/ 'jpg');
            return true;
        } else {
            return false;
        }
    }
}