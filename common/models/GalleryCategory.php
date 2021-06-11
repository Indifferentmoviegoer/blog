<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class GalleryCategory
 * @package common\models
 *
 * @property int $id
 * @property string $name
 */
class GalleryCategory extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'gallery_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id'], 'integer'],
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
            'name' => 'Наименование',
        ];
    }
}