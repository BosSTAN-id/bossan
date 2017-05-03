<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TaSetoranPotonganRinc */

$this->title = $model->tahun;
$this->params['breadcrumbs'][] = ['label' => 'Ta Setoran Potongan Rincs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-setoran-potongan-rinc-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'tahun' => $model->tahun, 'sekolah_id' => $model->sekolah_id, 'no_setoran' => $model->no_setoran, 'kd_potongan' => $model->kd_potongan], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'tahun' => $model->tahun, 'sekolah_id' => $model->sekolah_id, 'no_setoran' => $model->no_setoran, 'kd_potongan' => $model->kd_potongan], [
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
            'kd_potongan',
            'nilai',
            'pembayaran',
            'keterangan',
        ],
    ]) ?>

</div>
