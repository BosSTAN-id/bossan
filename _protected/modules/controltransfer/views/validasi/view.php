<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TaValidasiPembayaran */

$this->title = $model->Kd_Bidang;
$this->params['breadcrumbs'][] = ['label' => 'Ta Validasi Pembayarans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-validasi-pembayaran-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'Kd_Bidang' => $model->Kd_Bidang, 'Kd_Sub' => $model->Kd_Sub, 'Kd_Unit' => $model->Kd_Unit, 'Kd_Urusan' => $model->Kd_Urusan, 'No_Validasi' => $model->No_Validasi, 'Tahun' => $model->Tahun], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'Kd_Bidang' => $model->Kd_Bidang, 'Kd_Sub' => $model->Kd_Sub, 'Kd_Unit' => $model->Kd_Unit, 'Kd_Urusan' => $model->Kd_Urusan, 'No_Validasi' => $model->No_Validasi, 'Tahun' => $model->Tahun], [
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
            'Tahun',
            'Kd_Urusan',
            'Kd_Bidang',
            'Kd_Unit',
            'Kd_Sub',
            'No_Validasi',
            'Tgl_Validasi',
            'No_SPM',
            'No_RPH',
            'Kd_Trans_1',
            'Kd_Trans_2',
            'Kd_Trans_3',
            'Nm_Penandatangan',
            'Jabatan_Penandatangan',
            'NIP_Penandatangan',
        ],
    ]) ?>

</div>
