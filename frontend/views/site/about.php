<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;

//// A массив челых чисел.найти  (i, j), где i <= j,  A[j] - A[i] -> max


//$arr = [40, 1, 0, 6, 9, 2, 12, 8, 9, 3, 9, 10, 10, 0];

$range = range(1, 200);
shuffle($range);
$random = array_slice($range, 0, 40);
$arr = $random;

$masiv = [];
$count = 0;
$s = count($arr);
$arrK = [];
$mask = [];
for ($i = 0; $i < $s; $i++) {
    $arrK = array_slice($arr, 0, $i + 1);
    $min = array_keys($arrK, min($arrK))[0];
    $mask[] = $min;
    $masiv[] = $arr[$i] - min($arrK);
    $count++;
}

var_dump('MAx:' . max($masiv));
$maxM = array_keys($masiv, max($masiv))[0];
var_dump('i:' . $mask[$maxM]);
$max = array_keys($masiv, max($masiv))[0];
var_dump('j:' . $max);
var_dump($count);
var_dump(memory_get_usage());
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>This is the About page. You may modify the following file to customize its content:</p>

    <code><?= __FILE__ ?></code>
</div>
