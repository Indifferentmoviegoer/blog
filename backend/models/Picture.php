<?php

namespace backend\models;

/**
 * Class Picture
 * @package backend\models
 */
class Picture extends \common\models\Picture
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