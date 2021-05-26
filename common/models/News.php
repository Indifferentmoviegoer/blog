<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class News
 * @package common\models
 *
 * @property int id
 * @property int picture_id
 * @property string name
 * @property string desc
 * @property string text
 */
class News extends ActiveRecord
{
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
            [['id', 'picture_id'], 'integer'],
            [['name', 'desc', 'text'], 'string'],
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
        ];
    }
}