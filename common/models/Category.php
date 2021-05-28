<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Category
 * @package common\models
 *
 * @property int $id
 * @property int $parent_id
 * @property string $name
 */
class Category extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'parent_id'], 'integer'],
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
            'parent_id' => 'Родительская категория',
            'name' => 'Наименование',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'parent_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCategoryProducts(): ActiveQuery
    {
        return $this->hasMany(NewsCategories::class, ['id' => 'category_id']);
    }

    /**
     * @param int $parent
     * @param int $level
     * @param int $exclude
     *
     * @return array
     */
    public static function getAllCategories($parent = 0, $level = 0, $exclude = 0): array
    {
        $children = self::find()
            ->where(['parent_id' => $parent])
            ->asArray()
            ->all();
        $result = [];
        foreach ($children as $category) {
            // при выборе родителя категории нельзя допустить
            // чтобы она размещалась внутри самой себя
            if ($category['id'] == $exclude) {
                continue;
            }
            if ($level) {
                $category['name'] = str_repeat('— ', $level) . $category['name'];
            }
            $result[] = $category;
            $result = array_merge(
                $result,
                self::getAllCategories($category['id'], $level + 1, $exclude)
            );
        }
        return $result;
    }



    /**
     * Возвращает массив всех категорий каталога для возможности
     * выбора родителя при добавлении или редактировании товара
     * или категории
     *
     * @param int $exclude
     * @param false $root
     *
     * @return array
     */
    public static function getTree($exclude = 0, $root = false): array
    {
        $data = self::getAllCategories(0, 0, $exclude);
        $tree = [];
        // при выборе родителя категории можно выбрать значение «Без родителя»,
        // т.е. создать категорию верхнего уровня, у которой не будет родителя
        if ($root) {
            $tree[0] = 'Категория без родителя';
        }
        foreach ($data as $item) {
            $tree[$item['id']] = $item['name'];
        }
        return $tree;
    }
}