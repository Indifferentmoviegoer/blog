<?php

namespace backend\controllers;

use Throwable;
use Yii;
use yii\base\Exception;
use yii\db\Query;

/**
 * Class SettingController
 * @package backend\controllers
 */
class SettingController extends BaseController
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $query = (new Query())->select('*')->from('settings');
        $dataProvider=$this->createDataProvider($query);

        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    /**
     * @param string $name
     *
     * @return string
     *
     */
    public function actionUpdate(string $name): string
    {
        try {
            if (Yii::$app->request->isPost) {

                $value = Yii::$app->request->post();

                if (!Yii::$app->settings->set($name, $value)) {
                    throw new Exception();
                }

                Yii::$app->session->setFlash('success', 'Настройки успешно изменены.');
            }
        } catch (Throwable $e) {
            Yii::$app->session->setFlash('error', 'Ошибка при редактировании настройки.');
        }

        $setting = Yii::$app->settings->get($name);
        $this->checkEmpty($setting);

        return $this->render('update', ['name' => $name, 'setting' => $setting]);
    }
}