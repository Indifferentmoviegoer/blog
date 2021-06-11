<?php

namespace frontend\models;

/**
 * Class Gallery
 * @package frontend\models
 */
class Gallery extends \common\models\Gallery
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