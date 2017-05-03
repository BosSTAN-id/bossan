<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TaSetoranPotongan */

$this->title = 'Update Ta Setoran Potongan: ' . $model->tahun;
$this->params['breadcrumbs'][] = ['label' => 'Ta Setoran Potongans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->tahun, 'url' => ['view', 'tahun' => $model->tahun, 'sekolah_id' => $model->sekolah_id, 'no_setoran' => $model->no_setoran]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ta-setoran-potongan-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
