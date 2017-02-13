<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RefRek5 */

$this->title = 'Update Ref Rek5: ' . $model->Kd_Rek_1;
$this->params['breadcrumbs'][] = ['label' => 'Ref Rek5s', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Kd_Rek_1, 'url' => ['view', 'Kd_Rek_1' => $model->Kd_Rek_1, 'Kd_Rek_2' => $model->Kd_Rek_2, 'Kd_Rek_3' => $model->Kd_Rek_3, 'Kd_Rek_4' => $model->Kd_Rek_4, 'Kd_Rek_5' => $model->Kd_Rek_5]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ref-rek5-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
