<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TaTransSts */

$this->title = $model->Tahun;
$this->params['breadcrumbs'][] = ['label' => 'Ta Trans Sts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-trans-sts-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'Tahun' => $model->Tahun, 'Kd_Trans_1' => $model->Kd_Trans_1, 'Kd_Trans_2' => $model->Kd_Trans_2, 'Kd_Trans_3' => $model->Kd_Trans_3, 'No_STS' => $model->No_STS], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'Tahun' => $model->Tahun, 'Kd_Trans_1' => $model->Kd_Trans_1, 'Kd_Trans_2' => $model->Kd_Trans_2, 'Kd_Trans_3' => $model->Kd_Trans_3, 'No_STS' => $model->No_STS], [
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
            'Tahun',
            'Kd_Trans_1',
            'Kd_Trans_2',
            'Kd_Trans_3',
            'No_STS',
            'Tgl_STS',
            'Nilai',
            'Rek_Penerima',
            'Bank_Penerima',
        ],
    ]) ?>

</div>
