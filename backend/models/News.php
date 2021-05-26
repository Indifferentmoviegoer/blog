<?php

namespace backend\models;

/**
 * Class News
 * @package backend\models
 */
class News extends \common\models\News
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