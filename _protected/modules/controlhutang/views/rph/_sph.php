 <?php

use yii\helpers\Html;
use yii\widgets\DetailView;

?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'Tahun',
            'No_SPH',
            'Nm_Kepala_SKPD',
            'NIP',
            'Jabatan',
            'Alamat',
            'Kd_Rekanan',
            'Nm_Rekanan',
            'Jab_Rekanan',
            'Alamat_Rekanan',
            'Nilai:currency',
            'Pekerjaan',
            'No_Kontrak',
            'Tgl_Kontrak',
            'Nm_Perusahaan',
        ],
    ]) ?>