<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TaRPH */

$this->title = $model->Kd_Bidang;
$this->params['breadcrumbs'][] = ['label' => 'Ta Rphs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-rph-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'Kd_Bidang' => $model->Kd_Bidang, 'Kd_Sub' => $model->Kd_Sub, 'Kd_Unit' => $model->Kd_Unit, 'Kd_Urusan' => $model->Kd_Urusan, 'No_RPH' => $model->No_RPH, 'No_SPH' => $model->No_SPH, 'No_SPM' => $model->No_SPM, 'Tahun' => $model->Tahun], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'Kd_Bidang' => $model->Kd_Bidang, 'Kd_Sub' => $model->Kd_Sub, 'Kd_Unit' => $model->Kd_Unit, 'Kd_Urusan' => $model->Kd_Urusan, 'No_RPH' => $model->No_RPH, 'No_SPH' => $model->No_SPH, 'No_SPM' => $model->No_SPM, 'Tahun' => $model->Tahun], [
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
            'No_SPH',
            'No_SPM',
            'No_RPH',
            'Tgl_RPH',
            'Nm_Kepala_SKPD',
            'NIP',
            'Jabatan',
            'Jatuh_Tempo',
            'Nilai_Bayar',
            'Rekening_Tujuan',
            'Bank',
            'Cabang',
            'Nama_Rekening',
            'PPh',
            'PPn',
            'Denda',
            'Lampiran_RPH',
        ],
    ]) ?>

</div>
