<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TaBaver */

$this->title = 'Update Ta Baver: ' . $model->tahun;
$this->params['breadcrumbs'][] = ['label' => 'Ta Bavers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->tahun, 'url' => ['view', 'tahun' => $model->tahun, 'no_ba' => $model->no_ba]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ta-baver-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
