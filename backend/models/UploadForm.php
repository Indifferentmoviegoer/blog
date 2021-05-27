<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Class UploadForm
 * @package backend\models
 */
class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'imageFile' => 'Изображение'
        ];
    }

    /**
     * @return bool
     */
    public function upload(): bool
    {
        $path = Yii::getAlias("@frontend/web/img/uploads/");
        if ($this->validate()) {
            $this->imageFile->saveAs($path . $this->imageFile->baseName . "." . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }
}