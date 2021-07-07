<?php

namespace frontend\modules\v1;

use Yii;

/**
 * Class Module
 * @package frontend\modules\v1
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        Yii::$app->response->format = Yii::$app->response::FORMAT_JSON;
        Yii::$app->user->enableSession = false;
    }
}
