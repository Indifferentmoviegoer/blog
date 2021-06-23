<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Category
 * @package common\models
 *
 * @property int $id
 * @property int $parent_id
 * @property string $name
 */
class Category extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'parent_id'], 'integer'],
            [['name'], 'string'],
            ['name', 'required', 'message' => 'Поле не должно быть пустым'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Родительская категория',
            'name' => 'Наименование',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'parent_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCategoryProducts(): ActiveQuery
    {
        return $this->hasMany(NewsCategories::class, ['id' => 'category_id']);
    }
}