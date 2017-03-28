<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TaSPJRinc */
?>
<div class="ta-spjrinc-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'no_bukti',
            'tgl_bukti:date',
            'uraian',
            // 'no_spj',
            'refProgram.uraian_program',
            'refSubProgram.uraian_sub_program',
            'refKegiatan.uraian_kegiatan',
            'refRek3.Nm_Rek_3',
            'refRek5.Nm_Rek_5',
            'komponen.komponen',
            [
                'attribute' => 'pembayaran',
                'value' => $model['pembayaran'] == 1 ? 'Bank' : 'Tunai'
            ],
            'nilai:decimal',
            'nm_penerima',
            'alamat_penerima',
        ],
    ]) ?>

</div>
