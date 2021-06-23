<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Rating
 * @package common\models
 *
 * @property int id
 * @property int picture_id
 * @property string ip
 * @property int value
 */
class Rating extends ActiveRecord
{

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'rating';
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [['id', 'picture_id', 'value'], 'integer'],
            [['ip'], 'string'],
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
            'ip' => 'Пользователь',
            'value' => 'Значение',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getPicture(): ActiveQuery
    {
        return $this->hasOne(Picture::class, ['id' => 'picture_id']);
    }

}