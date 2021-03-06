<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class News
 * @package common\models
 *
 * @property int id
 * @property int picture_id
 * @property int count_views
 * @property string name
 * @property string desc
 * @property string text
 * @property string published_at
 * @property bool $forbidden
 */
class News extends ActiveRecord
{
    public $rel;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'news';
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [['id', 'picture_id', 'count_views'], 'integer'],
            [['forbidden'], 'boolean'],
            [['name', 'desc', 'text', 'published_at'], 'string'],
            [['name', 'desc', 'text', 'published_at'], 'required'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'picture_id' => 'Изображение',
            'name' => 'Заголовок',
            'desc' => 'Краткое описание',
            'text' => 'Текст',
            'published_at' => 'Дата публикации',
            'rel' => 'Категория',
            'forbidden' => 'Доступ',
            'count_views' => 'Кол-во просмотров',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getPicture(): ActiveQuery
    {
        return $this->hasOne(Picture::class, ['id' => 'picture_id']);
    }

    /**
     * @return mixed
     */
    public function getRel()
    {
        return $this->rel;
    }

    /**
     * @return ActiveQuery
     */
    public function getCategories(): ActiveQuery
    {
        return $this->hasMany(NewsCategories::class, ['news_id' => 'id']);
    }
}