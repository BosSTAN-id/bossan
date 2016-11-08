<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TaDeposito */

$this->title = $model->Kd_Deposito;
$this->params['breadcrumbs'][] = ['label' => 'Ta Depositos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-deposito-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->Kd_Deposito], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->Kd_Deposito], [
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
            'Kd_Deposito',
            'Nm_Bank',
            'No_Dokumen',
            'Tgl_Penempatan',
            'Tgl_Jatuh_Tempo',
            'Suku_Bunga',
            'Nilai',
            'Keterangan',
        ],
    ]) ?>

</div>
