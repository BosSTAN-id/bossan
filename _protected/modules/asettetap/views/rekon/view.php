<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TaAsetTetapBa */

$this->title = $model->tahun;
$this->params['breadcrumbs'][] = ['label' => 'Ta Aset Tetap Bas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-aset-tetap-ba-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'tahun' => $model->tahun, 'sekolah_id' => $model->sekolah_id, 'no_ba' => $model->no_ba], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'tahun' => $model->tahun, 'sekolah_id' => $model->sekolah_id, 'no_ba' => $model->no_ba], [
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
            'no_ba',
            'tgl_ba:date',
            'nm_penandatangan',
            'nip_penandatangan',
            'jbt_penandatangan',
        ],
    ]) ?>

</div>
