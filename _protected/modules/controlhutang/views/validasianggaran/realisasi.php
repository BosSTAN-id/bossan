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

$this->title = 'Realisasi Utang';
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
        'panel'=>['type'=>'primary', 'heading'=>'Realisasi Utang '],   
        //'floatHeader'=>true,
        //'floatHeaderOptions'=>['scrollingTop'=>'50'],        
        'columns' => [
            [
                'class' => 'kartik\grid\ExpandRowColumn',
                'value' => function ($model, $key, $index, $column) {

                    return GridView::ROW_COLLAPSED;
                },

                'allowBatchToggle'=>true,
               'detail'=>function ($model, $key, $index, $column) {
                    $connection = \Yii::$app->db;           
                   $query = $connection->createCommand("
                            SELECT 
                            a.Tahun, a.Kd_Urusan, a.Kd_Bidang, a.Kd_Unit, a.Kd_Sub, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5,
                            a.Keterangan_Rinc, a.Keterangan, a.No_SPH,
                            a.Total, b.Nilai, c.No_SP2D
                            FROM Ta_RASK_Arsip_Hutang a
                            LEFT JOIN Ta_SPM_Rinc b 
                            ON a.Tahun = b.Tahun AND a.Kd_Urusan = b.Kd_Urusan AND a.Kd_Bidang = b.Kd_Bidang AND a.Kd_Unit = b.Kd_Unit AND a.Kd_Sub = b.Kd_Sub AND 
                            a.Kd_Prog = b.Kd_Prog AND a.ID_Prog = b.ID_Prog AND a.Kd_Keg = b.Kd_Keg AND 
                            A.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                            LEFT JOIN Ta_SP2D c ON b.No_SPM = c.No_SPM
                            WHERE a.Kd_Urusan LIKE :Kd_Urusan AND a.Kd_Bidang LIKE :Kd_Bidang AND a.Kd_Unit LIKE :Kd_Unit AND a.Kd_Sub LIKE :Kd_Sub AND a.Kd_Prog LIKE :Kd_Prog AND a.ID_Prog LIKE :ID_Prog AND a.Kd_Keg LIKE :Kd_Keg AND a.Kd_Rek_1 LIKE :Kd_Rek_1 AND a.Kd_Rek_2 LIKE :Kd_Rek_2 AND a.Kd_Rek_3 LIKE :Kd_Rek_3 AND a.Kd_Rek_4 LIKE :Kd_Rek_4 AND a.Kd_Rek_5 LIKE :Kd_Rek_5
                    ");
                   $query->bindValue(':Kd_Urusan', $model->Kd_Urusan)
                        ->bindValue(':Kd_Bidang' , $model->Kd_Bidang)
                        ->bindValue(':Kd_Unit' , $model->Kd_Unit)
                        ->bindValue(':Kd_Sub' , $model->Kd_Sub)
                        ->bindValue(':Kd_Prog' , $model->Kd_Prog)
                        ->bindValue(':ID_Prog' , $model->ID_Prog)
                        ->bindValue(':Kd_Keg' , $model->Kd_Keg)
                        ->bindValue(':Kd_Rek_1' , $model->Kd_Rek_1)
                        ->bindValue(':Kd_Rek_2' , $model->Kd_Rek_2)
                        ->bindValue(':Kd_Rek_3' , $model->Kd_Rek_3)
                        ->bindValue(':Kd_Rek_4' , $model->Kd_Rek_4)
                        ->bindValue(':Kd_Rek_5' , $model->Kd_Rek_5);
                    $dataProvider = $query->queryAll();        
                    return Yii::$app->controller->renderPartial('realisasi_detail', [
                        'model'=>$model,
                        'dataProvider' => $dataProvider,
                        ]);
                },
                'detailOptions'=>[
                    'class'=> 'kv-state-enable',
                ],

            ],          
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
