<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Comment
 * @package common\models
 *
* @property int $id
* @property int $user_id
* @property int $news_id
* @property int $picture_id
* @property string $text
* @property boolean $moderation
* @property string $created_at
 */
class Comment extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'comment';
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [['id', 'user_id', 'news_id', 'picture_id'], 'integer'],
            ['created_at', 'string'],
            ['text', 'string', 'min' => 5],
            ['text', 'string', 'max' => 255],
            ['text', 'required'],
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
            'user_id' => 'Пользователь',
            'news_id' => 'Новость',
            'picture_id' => 'Изображение',
            'text' => 'Текст комментария',
            'moderation' => 'Пре-модерация',
            'created_at' => 'Создан',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getNews(): ActiveQuery
    {
        return $this->hasOne(News::class, ['id' => 'news_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getPicture(): ActiveQuery
    {
        return $this->hasOne(Gallery::class, ['id' => 'picture_id']);
    }
}