<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TaTransSts */

$this->title = 'Update Ta Trans Sts: ' . $model->Tahun;
$this->params['breadcrumbs'][] = ['label' => 'Ta Trans Sts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Tahun, 'url' => ['view', 'Tahun' => $model->Tahun, 'Kd_Trans_1' => $model->Kd_Trans_1, 'Kd_Trans_2' => $model->Kd_Trans_2, 'Kd_Trans_3' => $model->Kd_Trans_3, 'No_STS' => $model->No_STS]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ta-trans-sts-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
