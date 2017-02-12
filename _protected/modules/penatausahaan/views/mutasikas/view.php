<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TaMutasiKas */

$this->title = $model->tahun;
$this->params['breadcrumbs'][] = ['label' => 'Ta Mutasi Kas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-mutasi-kas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'tahun' => $model->tahun, 'no_bukti' => $model->no_bukti], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'tahun' => $model->tahun, 'no_bukti' => $model->no_bukti], [
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
            'no_bukti',
            'sekolah_id',
            'tgl_bukti',
            'no_bku',
            'kd_mutasi',
            'nilai',
            'uraian',
            'created_at',
            'updated_at',
            'user_id',
        ],
    ]) ?>

</div>
