<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use xj\bootbox\BootboxAsset;
use yii\bootstrap\Modal;
use yii\web\Controller;
?>
<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?php 
    echo GridView::widget([
        'dataProvider' => $data,
        //'filterModel' => $searchModel,
        // 'export' => true, 
        'responsive'=>true,
        'hover'=>true,     
        'resizableColumns'=>false,
        'panel'=>['type'=>'primary', 'heading'=> $heading],
        'responsiveWrap' => false,        
        'toolbar' => [
            '{toggleData}',
            '{export}',
            [
                'content' =>    Html::a('<i class="glyphicon glyphicon-print"></i> Cetak', ['cetak', 'Laporan' => [
                                    'Kd_Laporan' => $getparam['Laporan']['Kd_Laporan'], 
                                    'Kd_Sumber' => $getparam['Laporan']['Kd_Sumber'],
                                    'Tgl_1' => $getparam['Laporan']['Tgl_1'],
                                    'Tgl_2' => $getparam['Laporan']['Tgl_2'],
                                    'Tgl_Laporan' => $getparam['Laporan']['Tgl_Laporan'],
                                    'perubahan_id' => $getparam['Laporan']['perubahan_id']
                                ] ], [
                                    'class' => 'btn btn btn-default pull-right',
                                    'onClick' => "return !window.open(this.href, 'SPH', 'width=1024,height=600,scrollbars=1')"
                                        ]) 
            ],
        ],       
        'pager' => [
            'firstPageLabel' => 'Awal',
            'lastPageLabel'  => 'Akhir'
        ],
        'pjax'=>true,
        'pjaxSettings'=>[
            'options' => ['id' => 'laporan1-pjax', 'timeout' => 5000],
        ],
        'showPageSummary'=>true,         
        'columns' => [
            [
                'label' => 'Kode',
                'width'=>'3%',
                'value' =>function($model){
                    return $model['kd_program'];
                },
                // 'group'=>true,  // enable grouping,
                // 'groupedRow'=>true,                    // move grouped column to a single grouped row
                // 'groupOddCssClass'=>'kv-grouped-row',  // configure odd group cell css class
                // 'groupEvenCssClass'=>'kv-grouped-row', // configure even group cell css class
            ],            
            [
                'label' => 'Program',
                'width'=>'20%',
                'value' =>function($model){
                    return $model['uraian_program'];
                },
                // 'group'=>true,  // enable grouping,
                // 'groupedRow'=>true,                    // move grouped column to a single grouped row
                // 'groupOddCssClass'=>'kv-grouped-row',  // configure odd group cell css class
                // 'groupEvenCssClass'=>'kv-grouped-row', // configure even group cell css class
            ],
            [
                'attribute'=>'anggaran',
                'width'=>'5%',
                'noWrap' => true,
                'hAlign'=>'right',
                'format'=>['decimal', 0],
                'pageSummary'=>true
            ],
            [
                'label' => 'Pengembangan Perpustakaan',
                'attribute'=>'komponen1',
                'width'=>'5%',
                //'noWrap' => true,
                'hAlign'=>'right',
                'format'=>['decimal', 0],
                'pageSummary'=>true
            ],
            [
                'label' => 'Penerimaan Siswa Baru',
                'attribute'=>'komponen2',
                'width'=>'5%',
                //'noWrap' => true,
                'hAlign'=>'right',
                'format'=>['decimal', 0],
                'pageSummary'=>true
            ],
            [
                'label' => 'Pembelajaran dan Eskul',
                'attribute'=>'komponen3',
                'width'=>'5%',
                //'noWrap' => true,
                'hAlign'=>'right',
                'format'=>['decimal', 0],
                'pageSummary'=>true
            ],
            [
                'label' => 'Kegiatan Ulangan dan Ujian',
                'attribute'=>'komponen4',
                'width'=>'5%',
                //'noWrap' => true,
                'hAlign'=>'right',
                'format'=>['decimal', 0],
                'pageSummary'=>true
            ],
            [
                'label' => 'Pembelian Bahan Pakai Habis',
                'attribute'=>'komponen5',
                'width'=>'5%',
                //'noWrap' => true,
                'hAlign'=>'right',
                'format'=>['decimal', 0],
                'pageSummary'=>true
            ],
            [
                'label' => 'Langganan Daya dan Jasa',
                'attribute'=>'komponen6',
                'width'=>'5%',
                //'noWrap' => true,
                'hAlign'=>'right',
                'format'=>['decimal', 0],
                'pageSummary'=>true
            ],
            [
                'label' => 'Perawatan Sekolah',
                'attribute'=>'komponen7',
                'width'=>'5%',
                //'noWrap' => true,
                'hAlign'=>'right',
                'format'=>['decimal', 0],
                'pageSummary'=>true
            ],
            [
                'label' => 'Honor',
                'attribute'=>'komponen8',
                'width'=>'5%',
                //'noWrap' => true,
                'hAlign'=>'right',
                'format'=>['decimal', 0],
                'pageSummary'=>true
            ],
            [
                'label' => 'Pengembangan Profesi Guru',
                'attribute'=>'komponen9',
                'width'=>'5%',
                //'noWrap' => true,
                'hAlign'=>'right',
                'format'=>['decimal', 0],
                'pageSummary'=>true
            ],
            [
                'label' => 'Membantu Siswa Miskin',
                'attribute'=>'komponen10',
                'width'=>'5%',
                //'noWrap' => true,
                'hAlign'=>'right',
                'format'=>['decimal', 0],
                'pageSummary'=>true
            ],
            [
                'label' => 'Pengelolaan BOS',
                'attribute'=>'komponen11',
                'width'=>'5%',
                //'noWrap' => true,
                'hAlign'=>'right',
                'format'=>['decimal', 0],
                'pageSummary'=>true
            ],
            [
                'label' => 'Perangkat Komputer',
                'attribute'=>'komponen12',
                'width'=>'5%',
                //'noWrap' => true,
                'hAlign'=>'right',
                'format'=>['decimal', 0],
                'pageSummary'=>true
            ],
            [
                'label' => 'Biaya Lain',
                'attribute'=>'komponen13',
                'width'=>'5%',
                //'noWrap' => true,
                'hAlign'=>'right',
                'format'=>['decimal', 0],
                'pageSummary'=>true
            ],
            [
                'label' => 'Tak Berkategori',
                'attribute'=>'komponenlain',
                'width'=>'5%',
                //'noWrap' => true,
                'hAlign'=>'right',
                'format'=>['decimal', 0],
                'pageSummary'=>true
            ],
            [
                'label' => 'Jumlah Realisasi',
                'width'=>'5%',
                'value' => function($model){
                    return (
                            $model['komponen1']+
                            $model['komponen2']+
                            $model['komponen3']+
                            $model['komponen4']+
                            $model['komponen5']+
                            $model['komponen6']+
                            $model['komponen7']+
                            $model['komponen8']+
                            $model['komponen9']+
                            $model['komponen10']+
                            $model['komponen11']+
                            $model['komponen12']+
                            $model['komponen13']+
                            $model['komponenlain']
                        );
                },
                //'noWrap' => true,
                'hAlign'=>'right',
                'format'=>['decimal', 0],
                'pageSummary'=>true
            ],
        ],
    ]); 
?>
