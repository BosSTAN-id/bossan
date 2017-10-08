<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TaAsetTetap */

$this->title = $model->no_register;
$this->params['breadcrumbs'][] = ['label' => 'Ta Aset Tetaps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-aset-tetap-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->no_register], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->no_register], [
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
            [
                'label' => 'Jenis Aset',
                'value' => function($model){
                    return $model->Kd_Aset1.'.'.$model->Kd_Aset2.'.'.$model->Kd_Aset3.'.'.substr('0'.$model->Kd_Aset4, -2).'.'.substr('0'.$model->Kd_Aset5, -2).' '.$model->kdAset5->Nm_Aset5;
                }
            ],
            'no_urut',
            'no_register',
            'kepemilikan',
            'sumber_perolehan',
            'referensi_bukti',
            'tgl_perolehan',
            'nilai_perolehan',
            'masa_manfaat',
            'nilai_sisa',
            'kondisi',
            'keterangan',
            'attr1',
            'attr2',
            'attr3',
            'attr4',
            'attr5',
            'attr6',
            'attr7',
            'attr8',
            'attr9',
            'attr10',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
