<?php

use backend\models\UserForm;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model UserForm */
/* @var $form ActiveForm */

$param = ['options' => [$model->status => ['Selected' => true]]];
$checkboxItems = ['admin' => 'Админ', 'redactor' => 'Редактор', 'user' => 'Пользователь'];
?>

<div class="user-form">
    <div class="box">
        <div class="box-body">
            <div class="container-fluid">
                <div class="row">
                    <?php $form = ActiveForm::begin(); ?>
                    <div class="form-group">
                        <?= $form->field($model, 'username')->textInput() ?>
                        <?= $form->field($model, 'email')->textInput() ?>
                        <?= $form->field($model, 'password')->textInput() ?>

                        <?php
                        echo $form->field($model, 'status')->dropDownList(
                            [
                                '9' => 'Неактивный',
                                '10' => 'Активный'
                            ],
                            $param
                        ); ?>
                        <?php
                        echo $form->field($model, 'roles')->checkboxList(
                            $checkboxItems,
                            ['value' => $model->roles]
                        ); ?>
                    </div>
                    <div class="form-group">
                        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
