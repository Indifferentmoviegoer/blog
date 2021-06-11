<?php

namespace backend\models;

/**
 * Class GalleryCategory
 * @package backend\models
 */
class GalleryCategory extends \common\models\GalleryCategory
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return parent::tableName();
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return parent::rules();
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return parent::attributeLabels();
    }
}