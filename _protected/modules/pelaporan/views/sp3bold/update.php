<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TaSP3B */

$this->title = 'Update Ta Sp3 B: ' . $model->tahun;
$this->params['breadcrumbs'][] = ['label' => 'Ta Sp3 Bs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->tahun, 'url' => ['view', 'tahun' => $model->tahun, 'no_sp3b' => $model->no_sp3b]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ta-sp3-b-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
