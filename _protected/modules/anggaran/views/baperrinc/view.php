<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TaBaverRinc */
?>
<div class="ta-baver-rinc-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'tahun',
            'no_ba',
            'sekolah_id',
            'no_peraturan',
            'keterangan',
        ],
    ]) ?>

</div>
