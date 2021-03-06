<?php

use frontend\models\ContactForm;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model ContactForm */

$this->title = 'Контакты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        Если у вас есть деловые запросы или другие вопросы, заполните следующую форму, чтобы связаться с нами. Спасибо.
    </p>


    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

            <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'email') ?>

            <?= $form->field($model, 'subject') ?>

            <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

            <?= $form->field($model, 'verifyCode')->widget(
                Captcha::class,
                [
                    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                ]
            ) ?>

            <div class="form-group">
                <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <div class="news-detail">
        <h1>Также вы можете связаться с нами через:</h1>
        <h3>Контактный телефон:</h3>
        <p><?= Yii::$app->settings->get('phone')->value ?></p>
        <h3>E-mail:</h3>
        <p><?= Yii::$app->settings->get('email')->value ?></p>
    </div>

</div>