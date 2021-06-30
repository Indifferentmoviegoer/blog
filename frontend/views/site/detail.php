<?php

use common\models\News;
use common\widgets\CommentWidget;

/* @var $news News */

$this->title = $news->name;
?>
<div class="news-detail">
    <h1><?= $news->name ?></h1>
    <p><?= $news->published_at ?></p>
    <br>
    <img src="<?= $news->picture->name ?>" width="600px" alt="">
    <p><img src="/img/eye.png" width="50px" alt=""> <?= $news->count_views ?></p>
    <br>

    <?= $news->text ?>
</div>
<?= CommentWidget::widget(['id' => $news->id, 'type' => 1]) ?>

