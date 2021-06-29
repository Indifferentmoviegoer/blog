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
 * @property string $created_at
 * @property int $user_id
 * @property double $rating
 * @property boolean $moderation
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
            [['id', 'category_id', 'user_id'], 'integer'],
            [['name', 'created_at'], 'string'],
            ['name', 'image', 'extensions' => 'jpg, png, jpeg', 'minWidth' => 450, 'minHeight' => 450],
            ['moderation', 'boolean'],
            ['rating', 'double'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Изображение',
            'category_id' => 'Категория',
            'user_id' => 'Пользователь',
            'rating' => 'Рейтинг',
            'moderation' => 'Пре-модерация',
            'created_at' => 'Загружено',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(GalleryCategory::class, ['id' => 'category_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}