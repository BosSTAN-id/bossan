<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RefBank */

$this->title = 'Tambah Daftar Bank';
$this->params['breadcrumbs'][] = ['label' => 'Input Bank', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-bank-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
