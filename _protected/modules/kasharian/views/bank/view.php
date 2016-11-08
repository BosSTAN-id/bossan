<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RefBank */

$this->title = $model->Kd_Bank;
$this->params['breadcrumbs'][] = ['label' => 'Input Bank', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-bank-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->Kd_Bank], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->Kd_Bank], [
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
            'Kd_Bank',
            'Nm_Bank',
            'No_Rekening',
        ],
    ]) ?>

</div>
