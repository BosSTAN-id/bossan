<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TaMutasiKas */

$this->title = 'Update Ta Mutasi Kas: ' . $model->tahun;
$this->params['breadcrumbs'][] = ['label' => 'Ta Mutasi Kas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->tahun, 'url' => ['view', 'tahun' => $model->tahun, 'no_bukti' => $model->no_bukti]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ta-mutasi-kas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
