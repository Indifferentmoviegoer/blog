<?php

namespace frontend\modules\v1\traits;

/**
 * Trait ControllerTrait
 * @package frontend\modules\v1\traits
 */
trait ControllerTrait
{
    /**
     * @param array $body
     *
     * @return false|string[]
     */
    public function getError(array $body)
    {
        if (empty($body['picture_id']) && empty($body['news_id']) || empty($body['length'])) {
            return ['error' => 'Ошибка! Отсутствуют необходимые параметры'];
        }

        return false;
    }

    /**
     * @param $items
     *
     * @return array|string[]
     */
    public function arrayListNews($items): array
    {
        if (!empty($items)) {
            foreach ($items as $item) {
                $arrayList[] = $item->news_id;
            }
            return $arrayList;
        } else {
            return ['error' => 'Ничего не найдено!'];
        }
    }
}
