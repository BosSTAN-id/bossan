<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TaRkasKegiatan */

$this->title = 'Update Ta Rkas Kegiatan: ' . $model->tahun;
$this->params['breadcrumbs'][] = ['label' => 'Ta Rkas Kegiatans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->tahun, 'url' => ['view', 'tahun' => $model->tahun, 'sekolah_id' => $model->sekolah_id, 'kd_program' => $model->kd_program, 'kd_sub_program' => $model->kd_sub_program, 'kd_kegiatan' => $model->kd_kegiatan]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ta-rkas-kegiatan-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
