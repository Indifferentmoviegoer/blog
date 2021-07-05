<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use function OpenApi\scan;

/**
 * Class SwaggerController
 * @package console\controllers
 */
class SwaggerController extends Controller
{
    public function actionInit()
    {
        $alias = Yii::getAlias('@frontend/modules/v1/controllers');
        $openApi = scan($alias);
        $file = Yii::getAlias('@frontend/web/documentation/swagger.yaml');
        $handle = fopen($file, 'wb');
        fwrite($handle, $openApi->toYaml());
        fclose($handle);
    }
}