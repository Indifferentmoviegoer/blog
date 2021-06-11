<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Gallery
 * @package common\models
 *
* @property int $id
* @property string $name
* @property string $category_id
 */
class Gallery extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'gallery';
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [['id'], 'integer'],
            ['name', 'string'],
            ['category_id', 'string'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'category_id' => 'Категория',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(\backend\models\GalleryCategory::class, ['id' => 'category_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getRating(): ActiveQuery
    {
        return $this->hasOne(Rating::class, ['picture_id' => 'id']);
    }
}