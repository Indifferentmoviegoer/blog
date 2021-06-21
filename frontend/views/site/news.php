<?php

/* @var $this yii\web\View */
/* @var $news common\models\News */
/* @var $pages LinkPager */

use common\models\Category;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\Menu;

$this->title = 'Новости';
$path = env('APP_URL') . "/img/uploads/";
?>
<p>Категории</p>
<?php
echo Menu::widget([
                         'options' => ['class' => 'clearfix', 'id'=>'main-menu'],
                         'encodeLabels'=>false,
                         'activateParents'=>true,
                         'activeCssClass'=>'current-menu-item',
                         'items' => Category::viewMenuItems(),
                     ]);?>
<div class="body-content">
        <?php for ($i = 0; $i < count($news); $i++): ?>
            <?php if (!(($i % 2) == 0)): ?>
                <div class="news news-block right-news">
                    <div class="row">
                        <div class="col-lg-6">
                            <img src="<?= $path . $news[$i]->picture->name ?>"
                                 width="100%"
                                 height="400px"
                                 alt="">
                        </div>
                        <div class="col-lg-6">
                            <div class="news-content">
                                <p class="publication"><?= $news[$i]->published_at ?></p>
                                <h3 class="title"><?= $news[$i]->name ?></h3>
                                <p class="category"><?= $news[$i]->categoryList() ?></p>
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
                    </div>


                </div>
            <?php endif; ?>

            <?php if (($i % 2) == 0): ?>
                <div class="news news-block left-news">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="news-content">
                                <p><?= $news[$i]->published_at ?></p>
                                <h3><?= $news[$i]->name ?></h3>
                                <p class="category"><?= $news[$i]->categoryList() ?></p>
                                <p><?= $news[$i]->desc ?></p>
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
                        <div class="col-lg-6">
                            <img src="<?= $path . $news[$i]->picture->name ?>"
                                 width="100%"
                                 height="400px"
                                 alt="">
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endfor; ?>
        <?= LinkPager::widget(['pagination' => $pages]) ?>
    </div>