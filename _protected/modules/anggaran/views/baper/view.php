<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TaBaver */

$this->title = $model->tahun;
$this->params['breadcrumbs'][] = ['label' => 'Ta Bavers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-baver-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'tahun' => $model->tahun, 'no_ba' => $model->no_ba], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'tahun' => $model->tahun, 'no_ba' => $model->no_ba], [
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
            'tahun',
            'no_ba',
            'tgl_ba',
            'verifikatur',
            'nip_verifikatur',
            'penandatangan',
            'jabatan_penandatangan',
            'nip_penandatangan',
            'status',
        ],
    ]) ?>

</div>
