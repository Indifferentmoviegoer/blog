<?php

/* @var $this yii\web\View */
/* @var $news frontend\models\News */
/* @var $pages LinkPager */

use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'My Yii Application';
$i = 1;
$path = env('APP_URL') . "/img/uploads/";
?>
<div class="site-index">

    <div class="container">
        <div class="col-lg-6">
        <div id="myCarousel" class="carousel slide gallery-carousel" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                <?php foreach ($news as $item): ?>
                <?php if ($i == 1): ?>
                    <div class="item active">
                        <img src="<?= $path . $item->picture->name ?>" alt="">
                    </div>
                <?php endif;?>

                <?php if ($i != 1): ?>
                <div class="item">
                    <img src="<?= $path . $item->picture->name ?>" alt="">
                </div>
                    <?php endif;?>
                    <?php
                $i++;
                endforeach; ?>
            </div>

            <!-- Left and right controls -->
            <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    </div>
    <div class="body-content">


        <?php foreach ($news as $item): ?>
            <?php if (!(($i % 2) == 0)): ?>
        <div class="news news-block">
                <div class="row">
                    <div class="col-lg-6">
                        <img src="<?= $path . $item->picture->name ?>"
                             width="100%"
                             height="400px"
                             alt="">
                    </div>
                    <div class="col-lg-6">
                        <div class="news-content">
                            <p class="publication"><?= $item->published_at ?></p>
                            <h3 class="title"><?= $item->name ?></h3>
                            <p class="description"><?= $item->desc ?></p>
                            <a href="<?= Url::to(['site/detail', 'id' => $item->id]) ?>">Подробнее...
                                <svg width="18px" height="7px" viewBox="0 0 27 12" version="1.1"
                                     xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <g transform="translate(-1291.000000, -306.000000)" fill="#353535"
                                           fill-rule="nonzero" id="Footer---Light">
                                            <g transform="translate(0.000000, 120.000000)">
                                                <g id="Email-input" transform="translate(940.000000, 168.000000)">
                                                    <path id="Line-2"
                                                          d="M368.309343,18.8190816 L377.519864,24 L368.309343,29.1809184 L367.819082,28.3093429 L374.589,24.5 L351.5,24.5 L351.5,23.5 L374.593,23.5 L367.819082,19.6906571 L368.309343,18.8190816 Z"></path>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </a>

                        </div>
                    </div>
                </div>


                        </div>
            <?php endif; ?>

            <?php if (($i % 2) == 0): ?>
                        <div class="news news-block">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="news-content">
                            <p><?= $item->published_at ?></p>
                            <h3><?= $item->name ?></h3>
                            <p><?= $item->desc ?></p>
                            <a href="<?= Url::to(['site/detail', 'id' => $item->id]) ?>">Подробнее...
                                <svg width="18px" height="7px" viewBox="0 0 27 12" version="1.1"
                                     xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <g transform="translate(-1291.000000, -306.000000)" fill="#353535"
                                           fill-rule="nonzero" id="Footer---Light">
                                            <g transform="translate(0.000000, 120.000000)">
                                                <g id="Email-input" transform="translate(940.000000, 168.000000)">
                                                    <path id="Line-2"
                                                          d="M368.309343,18.8190816 L377.519864,24 L368.309343,29.1809184 L367.819082,28.3093429 L374.589,24.5 L351.5,24.5 L351.5,23.5 L374.593,23.5 L367.819082,19.6906571 L368.309343,18.8190816 Z"></path>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <img src="<?= $path . $item->picture->name ?>"
                             width="100%"
                             height="400px"
                             alt="">
                    </div>
                </div>
                        </div>
            <?php endif; ?>

        <?php
        $i++;
        endforeach; ?>
        <?= LinkPager::widget(['pagination' => $pages]) ?>
    </div>
</div>
