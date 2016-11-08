<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TaDeposito */

$this->title = 'Update Ta Deposito: ' . $model->Kd_Deposito;
$this->params['breadcrumbs'][] = ['label' => 'Ta Depositos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Kd_Deposito, 'url' => ['view', 'id' => $model->Kd_Deposito]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ta-deposito-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
