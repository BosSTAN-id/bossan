<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TaSPJRinc */
?>
<div class="ta-spjrinc-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'tahun',
            'no_bukti',
            'tgl_bukti',
            'no_spj',
            'no_urut',
            'sekolah_id',
            'kd_program',
            'kd_sub_program',
            'kd_kegiatan',
            'Kd_Rek_1',
            'Kd_Rek_2',
            'Kd_Rek_3',
            'Kd_Rek_4',
            'Kd_Rek_5',
            'komponen_id',
            'pembayaran',
            'nilai',
            'nm_penerima',
            'alamat_penerima',
            'uraian',
            'bank_id',
        ],
    ]) ?>

</div>
