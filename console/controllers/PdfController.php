<?php


namespace console\controllers;

use DWLeague\PDF\ChromiumAdapter;
use yii\console\Controller;


class PdfController extends Controller
{

    public function actionInit()
    {
        $adapter = new ChromiumAdapter('/usr/bin/chromium');
        $adapter->do("http://i.voloschenko.study.dev0.ddemo.ru/contact", __DIR__ . "/my-output.pdf");
    }


}