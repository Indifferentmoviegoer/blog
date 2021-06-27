<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<div class="site-error">

    <?php if($exception->statusCode == '404'): ?>
        <h1>404 (Страница не найдена)</h1>
        <div class="alert alert-danger">
            Данной страницы не существует. Пожалуйста, проверьте правильность введенной ссылки.
        </div>
    <?php elseif($exception->statusCode == '403'): ?>
        <h1>403 (Доступ запрещен)</h1>
        <div class="alert alert-danger">
            Доступ запрещен. Некоторые новости могут просматривать только авторизованные пользователи. Пожалуйста, авторизуйтесь на сайте для просмотра данной новости.
        </div>
    <?php else: ?>
        <h1><?= Html::encode($this->title) ?></h1>

        <div class="alert alert-danger">
            <?= nl2br(Html::encode($message)) ?>
        </div>
        <p>
            Вышеуказанная ошибка произошла во время обработки веб-сервером вашего запроса.
        </p>
    <?php endif; ?>
</div>