<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TaKontrak */

$this->title = $model->ID_Prog;
$this->params['breadcrumbs'][] = ['label' => 'Ta Kontraks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-kontrak-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'ID_Prog' => $model->ID_Prog, 'Kd_Bidang' => $model->Kd_Bidang, 'Kd_Keg' => $model->Kd_Keg, 'Kd_Prog' => $model->Kd_Prog, 'Kd_Sub' => $model->Kd_Sub, 'Kd_Unit' => $model->Kd_Unit, 'Kd_Urusan' => $model->Kd_Urusan, 'No_Kontrak' => $model->No_Kontrak, 'Tahun' => $model->Tahun], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'ID_Prog' => $model->ID_Prog, 'Kd_Bidang' => $model->Kd_Bidang, 'Kd_Keg' => $model->Kd_Keg, 'Kd_Prog' => $model->Kd_Prog, 'Kd_Sub' => $model->Kd_Sub, 'Kd_Unit' => $model->Kd_Unit, 'Kd_Urusan' => $model->Kd_Urusan, 'No_Kontrak' => $model->No_Kontrak, 'Tahun' => $model->Tahun], [
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
            'No_Kontrak',
            'Kd_Urusan',
            'Kd_Bidang',
            'Kd_Unit',
            'Kd_Sub',
            'Kd_Prog',
            'ID_Prog',
            'Kd_Keg',
            'Tgl_Kontrak',
            'Keperluan',
            'Waktu',
            'Nilai',
            'Nm_Perusahaan',
            'Bentuk',
            'Alamat',
            'Nm_Pemilik',
            'NPWP',
            'Nm_Bank',
            'Nm_Rekening',
            'No_Rekening',
        ],
    ]) ?>

</div>
