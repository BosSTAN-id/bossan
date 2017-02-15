<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RefKegiatanSekolah */

$this->title = 'Update Ref Kegiatan Sekolah: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Ref Kegiatan Sekolahs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ref-kegiatan-sekolah-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
