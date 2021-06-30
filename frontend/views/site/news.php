<?php

use common\repositories\NewsRepository;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\Menu;

/* @var $this yii\web\View */
/* @var $news common\models\News */
/* @var $pages LinkPager */
/* @var $newsRepository NewsRepository */
/* @var $menu array */

$this->title = 'Новости';
?>
<div class="body-content">
    <h1>Категории</h1>
    <?php
    echo Menu::widget(
        [
            'options' => ['class' => 'clearfix', 'id' => 'main-menu'],
            'encodeLabels' => false,
            'activateParents' => true,
            'activeCssClass' => 'current-menu-item',
            'items' => $menu,
        ]
    ); ?>
    <h1>Новости</h1>
    <?php for ($i = 0; $i < count($news); $i++): ?>
        <div class="news news-block <?= !(($i % 2) == 0) ? "right-news" : "left-news" ?>">
            <div class="row">
                <?php if (!(($i % 2) == 0)): ?>
                    <div class="col-lg-6">
                        <img src="<?= $news[$i]->picture->name ?>"
                             width="100%"
                             height="400px"
                             alt="">
                    </div>
                <?php endif; ?>
                <div class="col-lg-6">
                    <div class="news-content">
                        <p class="publication"><?= $news[$i]->published_at ?></p>
                        <h3 class="title"><?= $news[$i]->name ?></h3>
                        <p class="category"><?= $newsRepository->categoryList($news[$i]) ?></p>
                        <p class="description"><?= $news[$i]->desc ?></p>
                        <a href="<?= Url::to(['site/detail', 'id' => $news[$i]->id]) ?>">Подробнее...
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
                <?php if (($i % 2) == 0): ?>
                    <div class="col-lg-6">
                        <img src="<?= $news[$i]->picture->name ?>"
                             width="100%"
                             height="400px"
                             alt="">
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endfor; ?>
    <?= LinkPager::widget(['pagination' => $pages]) ?>
</div>