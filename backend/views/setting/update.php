<?php

use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var mixed $setting
 */

$this->title = 'Редактирование настройки';
$this->params['breadcrumbs'][] = ['label' => 'Настройки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="setting-form">
    <div class="box">
        <div class="box-body">
            <div class="container-fluid">
                <div class="row">

                    <?= Html::beginForm() ?>
                    <div class="form-group">
                        <?= Html::label($setting->label, 'value') ?>
                        <?= Html::textInput(
                            'value',
                            $setting->value,
                            ['type' => $setting->type, 'class' => 'form-control']
                        ) ?>
                    </div>
                    <div class="form-group">
                        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                    </div>
                    <?= Html::endForm() ?>
                </div>
            </div>
        </div>
    </div>
</div>