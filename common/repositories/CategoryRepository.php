<?php

namespace common\repositories;

use common\models\Category;
use yii\helpers\Url;

class CategoryRepository
{
    /**
     * @param int $parent
     * @param int $level
     * @param int $exclude
     *
     * @return array
     */
    public static function getAllCategories(int $parent = 0, int $level = 0, int $exclude = 0): array
    {
        $children = Category::find()
            ->where(['parent_id' => $parent])
            ->asArray()
            ->all();
        $result = [];
        foreach ($children as $category) {
            if ($category['id'] == $exclude) {
                continue;
            }
            if ($level) {
                $category['name'] = str_repeat('— ', $level) . $category['name'];
            }
            $result[] = $category;
            $result = array_merge(
                $result,
                static::getAllCategories($category['id'], $level + 1, $exclude)
            );
        }
        return $result;
    }


    /**
     * @param int $exclude
     * @param bool $root
     *
     * @return array
     */
    public static function getTree(int $exclude = 0, bool $root = false): array
    {
        $data = static::getAllCategories(0, 0, $exclude);
        $tree = [];
        if ($root) {
            $tree[0] = 'Категория без родителя';
        }
        foreach ($data as $item) {
            $tree[$item['id']] = $item['name'];
        }
        return $tree;
    }

    /**
     * @param int $parent
     *
     * @return array
     */
    public static function getAllParents(int $parent): array
    {
        $category = Category::find()->where(['id' => $parent])->one();
        $result = [];
        $result[] = $category;
        if ($category->parent_id != 0) {
            $result = array_merge(
                $result,
                static::getAllParents($category->parent_id)
            );
        }
        return $result;
    }

    /**
     * @return array
     */
    private static function getMenuItems(): array
    {
        $items = array();
        $resultAll = Category::find()->all();

        foreach ($resultAll as $result) {
            if (empty($items[$result->parent_id])) {
                $items[$result->parent_id] = array();
            }
            $items[$result->parent_id][] = $result->attributes;
        }
        return $items;
    }

    /**
     * @param int $parentId
     *
     * @return array|void
     */
    public static function viewMenuItems(int $parentId = 0)
    {
        $arrItems = static::getMenuItems();
        if (empty($arrItems[$parentId])) {
            return;
        }
        for ($i = 0; $i < count($arrItems[$parentId]); $i++) {
            $result[] = [
                'label' => $arrItems[$parentId][$i]['name'],
                'url' => Url::to(['category', 'id' => $arrItems[$parentId][$i]['id']]),
                'items' => static::viewMenuItems($arrItems[$parentId][$i]['id']),
            ];
        }
        return $result;
    }

}