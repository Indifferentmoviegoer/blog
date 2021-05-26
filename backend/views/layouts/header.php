<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $content string */
?>

<header class="main-header">

    <?php echo Html::a(
        '<span class="logo-mini">Блог</span><span class="logo-lg">' . Yii::$app->name . '</span>',
        Yii::$app->homeUrl,
        ['class' => 'logo']
    ); ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>


        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li>
                    <?= Html::a('Открыть сайт', Url::to('/'),
                                ['target' => '_blank', 'class' => 'nav-link', 'title' => 'Открыть сайт в новой вкладке']
                    ) ?>
                </li>
                <li>
                    <?= Html::a('<b><span class="fa fa-user-circle"></span> ' . Yii::$app->user->identity->username . '</b>') ?>
                </li>
                <li>
                    <?= Html::a('<span class="fa fa-sign-out"></span>', Url::toRoute('/site/logout'),
                                ['data' => ['method' => 'post'], 'title' => 'Выйти']
                    ) ?>
                </li>
            </ul>
        </div>
    </nav>
</header>
