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
* @property int $user_id
* @property int $rating
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
            [['id', 'rating', 'category_id', 'user_id'], 'integer'],
            ['name', 'string'],
            ['moderation', 'boolean'],
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
            'user_id' => 'Пользователь',
            'rating' => 'Рейтинг',
            'moderation' => 'Пре-модерация',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(\backend\models\GalleryCategory::class, ['id' => 'category_id']);
    }

//    /**
//     * @return ActiveQuery
//     */
//    public function getRating(): ActiveQuery
//    {
//        return $this->hasOne(Rating::class, ['picture_id' => 'id']);
//    }
}