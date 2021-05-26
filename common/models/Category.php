<?php

namespace common\models;

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
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [['id', 'parent_id'], 'integer'],
            ['name', 'string'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Родительская категория',
            'name' => 'Наименование',
        ];
    }
}