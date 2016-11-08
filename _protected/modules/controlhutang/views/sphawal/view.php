<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TaSPH */

$this->title = 'SPH: '.$model->No_SPH;
$this->params['breadcrumbs'][] = 'Control Hutang';
$this->params['breadcrumbs'][] = ['label' => 'Surat Pengakuan Hutan', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-sph-view">

    <p>
        <?= Html::a('Update', ['update', 'Kd_Bidang' => $model->Kd_Bidang, 'Kd_Sub' => $model->Kd_Sub, 'Kd_Unit' => $model->Kd_Unit, 'Kd_Urusan' => $model->Kd_Urusan, 'No_SPH' => $model->No_SPH, 'Tahun' => $model->Tahun], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'Kd_Bidang' => $model->Kd_Bidang, 'Kd_Sub' => $model->Kd_Sub, 'Kd_Unit' => $model->Kd_Unit, 'Kd_Urusan' => $model->Kd_Urusan, 'No_SPH' => $model->No_SPH, 'Tahun' => $model->Tahun], [
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
            'subunit.Nm_Sub_Unit',
            'No_SPH',
            'Tgl_SPH',
            'Nm_Kepala_SKPD',
            'NIP',
            'Jabatan',
            'Alamat',
            'Kd_Rekanan',
            'Nm_Rekanan',
            'Jab_Rekanan',
            'Alamat_Rekanan',
            'Nilai',
            'Pekerjaan',
            'No_Kontrak',
            'Tgl_Kontrak',
            'Nm_Perusahaan',
        ],
    ]) ?>

</div>
