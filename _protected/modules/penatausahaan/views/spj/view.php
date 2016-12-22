<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TaSPJ */

$this->title = $model->tahun;
$this->params['breadcrumbs'][] = ['label' => 'Ta Spjs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-spj-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'tahun',
            'no_spj',
            'sekolah_id',
            'tgl_spj',
            'no_bku',
            'keterangan',
            'kd_sah',
            'no_pengesahan',
            'disahkan_oleh',
            'nip_pengesahan',
            'created_at',
            'updated_at',
            'user_id',
            'nm_bendahara',
            'nip_bendahara',
            'jbt_bendahara',
            'jbt_pengesahan',
            'tgl_pengesahan',
            'kd_verifikasi',
        ],
    ]) ?>

</div>
