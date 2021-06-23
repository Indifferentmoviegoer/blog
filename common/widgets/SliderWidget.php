<?php

namespace common\widgets;

use common\repositories\GalleryRepository;
use yii\base\Widget;

/**
 * Class SliderWidget
 * @package common\widgets
 */
class SliderWidget extends Widget
{

    /**
     *{@inheritDoc}
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @return string
     */
    public function run(): string
    {
        $galleryRepository = new GalleryRepository();
        $slider = $galleryRepository->mostPopularMonth();

        return $this->render('slider', ['slider' => $slider]);
    }
}
