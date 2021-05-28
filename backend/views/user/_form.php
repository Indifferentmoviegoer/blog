<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Редактирование пользователя';
$this->params['breadcrumbs'][] = ['label' => 'Управление пользователями', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

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
                    <?= $form->field($model, 'status')->dropDownList(
                        ['9' => 'Неактивный', '10' => 'Активный'],
                        $param
                    ) ?>
                    <?= $form->field($model, 'roles')->checkboxList($checkboxItems, ['value' => $model->roles]) ?>
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
