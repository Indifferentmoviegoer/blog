<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class Picture
 * @package common\models
 *
* @property int $id
* @property string $name
 */
class Picture extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'picture';
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [['id'], 'integer'],
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
            'name' => 'Наименование',
        ];
    }
}