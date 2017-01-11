<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TaSPJ */

$this->title = 'Update Ta Spj: ' . $model->tahun;
$this->params['breadcrumbs'][] = ['label' => 'Ta Spjs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->tahun, 'url' => ['view', 'tahun' => $model->tahun, 'no_spj' => $model->no_spj]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ta-spj-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
