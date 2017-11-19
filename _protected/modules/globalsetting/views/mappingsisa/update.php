<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RefPenerimaanSekolah2 */

$this->title = 'Update Ref Penerimaan Sekolah2: ' . $model->kd_penerimaan_1;
$this->params['breadcrumbs'][] = ['label' => 'Ref Penerimaan Sekolah2s', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->kd_penerimaan_1, 'url' => ['view', 'kd_penerimaan_1' => $model->kd_penerimaan_1, 'kd_penerimaan_2' => $model->kd_penerimaan_2]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ref-penerimaan-sekolah2-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
