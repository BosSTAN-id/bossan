<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RefPotongan */

$this->title = 'Update Ref Potongan: ' . $model->kd_potongan;
$this->params['breadcrumbs'][] = ['label' => 'Ref Potongans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->kd_potongan, 'url' => ['view', 'id' => $model->kd_potongan]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ref-potongan-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
