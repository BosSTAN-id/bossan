<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TaAsetTetap */

$this->title = 'Update Ta Aset Tetap: ' . $model->no_register;
$this->params['breadcrumbs'][] = ['label' => 'Ta Aset Tetaps', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->no_register, 'url' => ['view', 'id' => $model->no_register]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ta-aset-tetap-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
