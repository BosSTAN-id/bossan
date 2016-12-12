<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TaSPJRinc */

$this->title = 'Update Ta Spjrinc: ' . $model->tahun;
$this->params['breadcrumbs'][] = ['label' => 'Ta Spjrincs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->tahun, 'url' => ['view', 'tahun' => $model->tahun, 'no_bukti' => $model->no_bukti, 'tgl_bukti' => $model->tgl_bukti]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ta-spjrinc-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
