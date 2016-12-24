<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TaSaldoAwal */

$this->title = 'Update Ta Saldo Awal: ' . $model->tahun;
$this->params['breadcrumbs'][] = ['label' => 'Ta Saldo Awals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->tahun, 'url' => ['view', 'tahun' => $model->tahun, 'sekolah_id' => $model->sekolah_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ta-saldo-awal-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
