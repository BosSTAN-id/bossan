<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TaSetoranPotongan */

$this->title = $model->tahun;
$this->params['breadcrumbs'][] = ['label' => 'Ta Setoran Potongans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-setoran-potongan-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'tahun' => $model->tahun, 'sekolah_id' => $model->sekolah_id, 'no_setoran' => $model->no_setoran], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'tahun' => $model->tahun, 'sekolah_id' => $model->sekolah_id, 'no_setoran' => $model->no_setoran], [
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
            'sekolah_id',
            'no_setoran',
            'tgl_setoran',
            'keterangan',
        ],
    ]) ?>

</div>
