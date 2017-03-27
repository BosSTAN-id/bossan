<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TaSPJRinc */

$this->title = 'Tambah Bukti';
$this->params['breadcrumbs'][] = 'Penatausahaan';
$this->params['breadcrumbs'][] = ['label' => 'Belanja', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="ta-spjrinc-create">
    <?= $this->render('_form', [
        'model' => $model,
        'Tahun' => $Tahun,
    ]) ?>
</div>
