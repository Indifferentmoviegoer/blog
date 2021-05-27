<?php

namespace backend\models;

/**
 * Class ProductCategories
 * @package backend\models
 */
class ProductCategories extends \common\models\ProductCategories
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