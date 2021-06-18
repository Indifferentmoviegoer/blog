<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class Comment
 * @package common\models
 *
* @property int $id
* @property int $user_id
* @property int $news_id
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
            [['id', 'user_id', 'news_id'], 'integer'],
            [['text', 'created_at'], 'string'],
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
            'text' => 'Текст комментария',
            'moderation' => 'Пре-модерация',
            'created_at' => 'Создан',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}