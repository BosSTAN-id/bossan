<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TaSaldoAwalPotongan */

$this->title = 'Update Ta Saldo Awal Potongan: ' . $model->tahun;
$this->params['breadcrumbs'][] = ['label' => 'Ta Saldo Awal Potongans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->tahun, 'url' => ['view', 'tahun' => $model->tahun, 'sekolah_id' => $model->sekolah_id, 'kd_potongan' => $model->kd_potongan]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ta-saldo-awal-potongan-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
