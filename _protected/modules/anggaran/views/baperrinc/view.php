<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TaRkasPeraturan */
?>
<div class="ta-rkas-peraturan-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'tahun',
            'sekolah_id',
            'perubahan_id',
            'no_peraturan',
            'tgl_peraturan',
            'penandatangan',
            'nip',
            'jabatan',
            'komite_sekolah',
            'jabatan_komite',
            'verifikasi',
        ],
    ]) ?>

</div>
