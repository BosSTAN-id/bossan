<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TaKasHarian */

$this->title = $model->Kd_Bank;
$this->params['breadcrumbs'][] = ['label' => 'Ta Kas Harians', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-kas-harian-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'Kd_Bank' => $model->Kd_Bank, 'Tanggal' => $model->Tanggal], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'Kd_Bank' => $model->Kd_Bank, 'Tanggal' => $model->Tanggal], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'Kd_Bank',
            'Tanggal',
            'Jumlah',
        ],
    ]) ?>

</div>
