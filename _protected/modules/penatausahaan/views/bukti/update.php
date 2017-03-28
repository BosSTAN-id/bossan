<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TaSPJRinc */
$this->title = 'Ubah Bukti: '.$model->no_bukti;
$this->params['breadcrumbs'][] = 'Penatausahaan';
$this->params['breadcrumbs'][] = ['label' => 'Belanja', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Ubah';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-spjrinc-update">

    <?= $this->render('_form', [
        'model' => $model,
        'Tahun' => $Tahun,
    ]) ?>

</div>
