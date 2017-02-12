<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TaSP2B */

$this->title = $model->tahun;
$this->params['breadcrumbs'][] = ['label' => 'Ta Sp2 Bs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-sp2-b-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'tahun' => $model->tahun, 'no_sp2b' => $model->no_sp2b, 'no_sp3b' => $model->no_sp3b], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'tahun' => $model->tahun, 'no_sp2b' => $model->no_sp2b, 'no_sp3b' => $model->no_sp3b], [
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
            'tahun',
            'no_sp2b',
            'no_sp3b',
            'tgl_sp2b',
            'saldo_awal',
            'pendapatan',
            'belanja',
            'saldo_akhir',
            'penandatangan',
            'jbt_penandatangan',
            'nip_penandatangan',
            'jumlah_sekolah',
            'status',
        ],
    ]) ?>

</div>
