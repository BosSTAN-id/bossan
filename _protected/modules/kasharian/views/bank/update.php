<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RefBank */

$this->title = 'Ubah Bank: ' . $model->Kd_Bank;
$this->params['breadcrumbs'][] = ['label' => 'Input Bank', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Kd_Bank, 'url' => ['view', 'id' => $model->Kd_Bank]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ref-bank-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
