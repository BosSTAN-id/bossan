<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TaAsetTetapBa */

$this->title = 'Update Ta Aset Tetap Ba: ' . $model->tahun;
$this->params['breadcrumbs'][] = ['label' => 'Ta Aset Tetap Bas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->tahun, 'url' => ['view', 'tahun' => $model->tahun, 'sekolah_id' => $model->sekolah_id, 'no_ba' => $model->no_ba]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ta-aset-tetap-ba-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
