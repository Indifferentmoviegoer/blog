<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Class UploadGalleryForm
 * @package common\models
 */
class UploadGalleryForm extends Model
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
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
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
        $path = Yii::getAlias("@frontend/web/img/uploads/gallery/");
        if ($this->validate() && !empty($this->imageFile)) {
            $this->imageFile->saveAs($path . $this->imageFile->baseName . "." . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }
}