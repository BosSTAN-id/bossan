<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RefRekAset1 */

$this->title = 'Update Ref Rek Aset1: ' . $model->Kd_Aset1;
$this->params['breadcrumbs'][] = ['label' => 'Ref Rek Aset1s', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Kd_Aset1, 'url' => ['view', 'id' => $model->Kd_Aset1]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ref-rek-aset1-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
