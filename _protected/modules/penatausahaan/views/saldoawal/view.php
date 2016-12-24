<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TaSaldoAwal */

$this->title = $model->tahun;
$this->params['breadcrumbs'][] = ['label' => 'Ta Saldo Awals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-saldo-awal-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'tahun' => $model->tahun, 'sekolah_id' => $model->sekolah_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'tahun' => $model->tahun, 'sekolah_id' => $model->sekolah_id], [
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
            'keterangan',
            'nilai',
            'Kd_Rek_1',
            'Kd_Rek_2',
            'Kd_Rek_3',
            'Kd_Rek_4',
            'Kd_Rek_5',
            'kd_penerimaan_1',
            'kd_penerimaan_2',
        ],
    ]) ?>

</div>
