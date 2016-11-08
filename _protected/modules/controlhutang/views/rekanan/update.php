<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Rekanan */

$this->title = 'Update Rekanan: ' . $model->Kd_Rekanan;
$this->params['breadcrumbs'][] = ['label' => 'Rekanans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Kd_Rekanan, 'url' => ['view', 'id' => $model->Kd_Rekanan]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="rekanan-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
