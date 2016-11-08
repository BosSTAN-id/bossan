<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use xj\bootbox\BootboxAsset;
use yii\bootstrap\Modal;
use yii\web\Controller;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\controlhutang\models\BelanjakontrolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rekapitulasi Kontrol Utang';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-raskarsip-hutang-index">

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        //'export' => false, 
        'responsive'=>true,
        'hover'=>true,     
        'panel'=>['type'=>'primary', 'heading'=>'Rekapitulasi Kontrol Utang '],
        'pager' => [
            'firstPageLabel' => 'First',
            'lastPageLabel'  => 'Last'
        ],        
        //'floatHeader'=>true,
        //'floatHeaderOptions'=>['scrollingTop'=>'50'],        
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],


            //'Tahun',
            //'Kd_Perubahan',
            //'Kd_Urusan',
            //'Kd_Bidang',
            //'Kd_Unit',
            // 'Kd_Sub',
            //'refSubUnit.Nm_Sub_Unit',
            // 'Kd_Prog',
            // 'ID_Prog',
            // 'Kd_Keg',
            //'taKegiatan.Ket_Kegiatan',            
            [
                'attribute'=>'kd_keg', 
                'width'=>'310px',
                /*'value'=>function ($model, $key, $index, $widget) { 
                    return $model->renjaKegiatan->sub->Nm_Sub_Unit;
                },*/
                //'value' => 'taKegiatan.Ket_Kegiatan',
                'value' =>function($model){
                    return 'Kegiatan :'.$model->taKegiatan->Ket_Kegiatan;
                    //return print_r(cekSPH($model->Tahun, $model->Kd_Urusan, $model->Kd_Bidang, $model->Kd_Unit, $model->Kd_Sub, $model->Kd_Prog, $model->ID_Prog, $model->Kd_Keg, $model->Kd_Rek_1, $model->Kd_Rek_2, $model->Kd_Rek_3, $model->Kd_Rek_4, $model->Kd_Rek_5, $model->No_Rinc, $model->No_ID));
                },
                'group'=>true,  // enable grouping,
                'groupedRow'=>true,                    // move grouped column to a single grouped row
                'groupOddCssClass'=>'kv-grouped-row',  // configure odd group cell css class
                'groupEvenCssClass'=>'kv-grouped-row', // configure even group cell css class
            ],                       
            // 'Kd_Rek_1',
            // 'Kd_Rek_2',
            // 'Kd_Rek_3',
            // 'Kd_Rek_4',
            // 'Kd_Rek_5',
            //'refRek5.Nm_Rek_5',
            [
                'attribute'=>'Kd_Rek_5', 
                'width'=>'310px',
                //'value' => 'refRek5.Nm_Rek_5',
                'value' =>function($model){
                    return 'Belanja :'.$model->refRek5->Nm_Rek_5;
                },
                'group'=>true,  // enable grouping,
                'groupedRow'=>true,                    // move grouped column to a single grouped row
                'groupOddCssClass'=>'kv-grouped-row',  // configure odd group cell css class
                'groupEvenCssClass'=>'kv-grouped-row', // configure even group cell css class
            ],             
            // 'No_Rinc',
            //'taBelanjaRinc.Keterangan',
            [
                'attribute'=>'No_Rinc', 
                'width'=>'310px',
                'value' => 'taBelanjaRinc.Keterangan',
                /*
                'value' =>function($model){
                    return 'Rincian Belanja :'.$model->taBelanjaRinc->Keterangan;
                },
                */                
                'group'=>true,  // enable grouping,
                'groupedRow'=>true,                    // move grouped column to a single grouped row
                'groupOddCssClass'=>'kv-grouped-row',  // configure odd group cell css class
                'groupEvenCssClass'=>'kv-grouped-row', // configure even group cell css class
            ],            
            // 'No_ID',
            'taBelanjaRincSub.Keterangan',
            'Keterangan_Rinc',
            // 'Sat_1',
            // 'Nilai_1',
            // 'Sat_2',
            // 'Nilai_2',
            // 'Sat_3',
            // 'Nilai_3',
            // 'Satuan123',
            // 'Jml_Satuan',
            // 'Nilai_Rp',
            'Total:decimal',
            // 'Keterangan',
            // 'Kd_Ap_Pub',
            // 'Kd_Sumber',
            // 'DateCreate',
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
