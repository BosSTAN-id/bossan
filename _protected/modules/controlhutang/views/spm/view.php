<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TaSPM */

$this->title = $model->No_SPM;
$this->params['breadcrumbs'][] = ['label' => 'Ta Spms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-spm-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'No_SPM' => $model->No_SPM, 'Tahun' => $model->Tahun], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'No_SPM' => $model->No_SPM, 'Tahun' => $model->Tahun], [
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
            'No_SPM',
            'Kd_Urusan',
            'Kd_Bidang',
            'Kd_Unit',
            'Kd_Sub',
            'No_SPP',
            'Jn_SPM',
            'Tgl_SPM',
            'Uraian',
            'Nm_Penerima',
            'Bank_Penerima',
            'Rek_Penerima',
            'NPWP',
            'Bank_Pembayar',
            'Nm_Verifikator',
            'Nm_Penandatangan',
            'Nip_Penandatangan',
            'Jbt_Penandatangan',
            'Kd_Edit',
        ],
    ]) ?>

</div>
