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
            [['id', 'picture_id'], 'integer'],
            [['forbidden'], 'boolean'],
            [['name', 'desc', 'text', 'published_at'], 'string'],
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

    /**
     * @return false|string
     */
    public function categoryList()
    {
        $categories = $this->categories;

        if (empty($categories)) {
            return 'Новость без категории';
        }

        $categoryItems = [];
        foreach ($categories as $category) {
            $categoryItems[] = $category->category_id;
        }

        $index = 0;
        foreach ($categories as $category) {
            if ($category->category->parent_id != 0 && !in_array($category->category->parent_id, $categoryItems)) {
                $parents = $category->category->getAllParents($category->category->parent_id);
                foreach ($parents as $parent) {
                    array_splice(
                        $categoryItems,
                        $index + $index,
                        0,
                        $parent->id
                    );
                }
                $index++;
            }
        }

        $categories = '';
        for ($i = 0; $i < count($categoryItems); $i++) {
            $category = Category::findOne(['id' => $categoryItems[$i]]);
            $categories .= $category->name . ' - ';
        }

        return substr($categories, 0, -3);
    }

    /**
     * @return string
     */
    public function getShortText(): string
    {
        $text = strip_tags($this->text);
        $lengthText = mb_strlen($text);
        $text = mb_substr($text, 0, 220);
        $prob = mb_strripos($text, ' ');
        $text = mb_substr($text, 0, $prob);

        if ($lengthText >= 220) {
            $text = $text . '...';
        }

        return $text;
    }

}