<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\controlhutang\models\TaValidasiPembayaranSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ta Validasi Pembayarans';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-validasi-pembayaran-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Ta Validasi Pembayaran', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'Tahun',
            'Kd_Urusan',
            'Kd_Bidang',
            'Kd_Unit',
            'Kd_Sub',
            // 'No_Validasi',
            // 'Tgl_Validasi',
            // 'No_SPM',
            // 'No_RPH',
            // 'Kd_Trans_1',
            // 'Kd_Trans_2',
            // 'Kd_Trans_3',
            // 'Nm_Penandatangan',
            // 'Jabatan_Penandatangan',
            // 'NIP_Penandatangan',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
