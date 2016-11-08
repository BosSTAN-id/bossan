<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Rekanan */

$this->title = $model->Kd_Rekanan;
$this->params['breadcrumbs'][] = ['label' => 'Rekanans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rekanan-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->Kd_Rekanan], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->Kd_Rekanan], [
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
            'Kd_Rekanan',
            'Nm_Perusahaan',
            'Alamat',
            'Nm_Pemilik',
            'NPWP',
        ],
    ]) ?>

</div>
