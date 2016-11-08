<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TaKasHarian */

$this->title = 'Update Ta Kas Harian: ' . $model->Kd_Bank;
$this->params['breadcrumbs'][] = ['label' => 'Ta Kas Harians', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Kd_Bank, 'url' => ['view', 'Kd_Bank' => $model->Kd_Bank, 'Tanggal' => $model->Tanggal]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ta-kas-harian-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
