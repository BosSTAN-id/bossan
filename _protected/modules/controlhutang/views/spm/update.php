<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TaSPM */

$this->title = 'Update Ta Spm: ' . $model->No_SPM;
$this->params['breadcrumbs'][] = ['label' => 'Ta Spms', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->No_SPM, 'url' => ['view', 'No_SPM' => $model->No_SPM, 'Tahun' => $model->Tahun]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ta-spm-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
