<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\controlhutang\models\TaSPMSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ta Spms';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-spm-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Ta Spm', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'Tahun',
            'No_SPM',
            'Kd_Urusan',
            'Kd_Bidang',
            'Kd_Unit',
            // 'Kd_Sub',
            // 'No_SPP',
            // 'Jn_SPM',
            // 'Tgl_SPM',
            // 'Uraian',
            // 'Nm_Penerima',
            // 'Bank_Penerima',
            // 'Rek_Penerima',
            // 'NPWP',
            // 'Bank_Pembayar',
            // 'Nm_Verifikator',
            // 'Nm_Penandatangan',
            // 'Nip_Penandatangan',
            // 'Jbt_Penandatangan',
            // 'Kd_Edit',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
