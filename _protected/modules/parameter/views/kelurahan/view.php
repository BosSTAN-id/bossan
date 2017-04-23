<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RefDesa */

$this->title = $model->Kd_Prov;
$this->params['breadcrumbs'][] = ['label' => 'Ref Desas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-desa-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'Kd_Prov' => $model->Kd_Prov, 'Kd_Kab_Kota' => $model->Kd_Kab_Kota, 'Kd_Kecamatan' => $model->Kd_Kecamatan, 'Kd_Desa' => $model->Kd_Desa], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'Kd_Prov' => $model->Kd_Prov, 'Kd_Kab_Kota' => $model->Kd_Kab_Kota, 'Kd_Kecamatan' => $model->Kd_Kecamatan, 'Kd_Desa' => $model->Kd_Desa], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'Kd_Prov',
            'Kd_Kab_Kota',
            'Kd_Kecamatan',
            'Kd_Desa',
            'Nm_Desa',
        ],
    ]) ?>

</div>
