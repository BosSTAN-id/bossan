<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TaRkasKegiatan */

$this->title = $model->tahun;
$this->params['breadcrumbs'][] = ['label' => 'Ta Rkas Kegiatans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-rkas-kegiatan-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'tahun' => $model->tahun, 'sekolah_id' => $model->sekolah_id, 'kd_program' => $model->kd_program, 'kd_sub_program' => $model->kd_sub_program, 'kd_kegiatan' => $model->kd_kegiatan], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'tahun' => $model->tahun, 'sekolah_id' => $model->sekolah_id, 'kd_program' => $model->kd_program, 'kd_sub_program' => $model->kd_sub_program, 'kd_kegiatan' => $model->kd_kegiatan], [
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
            'sekolah_id',
            'kd_program',
            'kd_sub_program',
            'kd_kegiatan',
            'pagu_anggaran',
            'kd_penerimaan_1',
            'kd_penerimaan_2',
        ],
    ]) ?>

</div>
