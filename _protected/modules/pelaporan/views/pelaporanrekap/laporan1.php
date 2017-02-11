<?php 
use yii\helpers\Html;
use kartik\grid\GridView;
echo GridView::widget([
	'dataProvider' => $data,
	//'filterModel' => $searchModel,
	// 'export' => true, 
	'responsive'=>true,
	'hover'=>true,     
	'resizableColumns'=>false,
	'panel'=>['type'=>'primary', 'heading'=>$heading],
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
            'label' => 'Tingkat',
            'value' =>function($model){
                return $model['jenis'];
            },
            'group'=>true,  // enable grouping,
            // 'groupedRow'=>true,                    // move grouped column to a single grouped row
            // 'groupOddCssClass'=>'kv-grouped-row',  // configure odd group cell css class
            // 'groupEvenCssClass'=>'kv-grouped-row', // configure even group cell css class
        ],
        [
            'label' => 'Sekolah',
            'value' =>function($model){
                return $model['nama_sekolah'];
            },
            // 'group'=>true,  // enable grouping,
            // 'groupedRow'=>true,                    // move grouped column to a single grouped row
            // 'groupOddCssClass'=>'kv-grouped-row',  // configure odd group cell css class
            // 'groupEvenCssClass'=>'kv-grouped-row', // configure even group cell css class
        ],
        [
            'label' => 'No Peraturan',
            'width'=>'20%',
            'value' =>function($model){
                return $model['no_peraturan'];
            },
            // 'group'=>true,  // enable grouping,
            // 'groupedRow'=>true,                    // move grouped column to a single grouped row
            // 'groupOddCssClass'=>'kv-grouped-row',  // configure odd group cell css class
            // 'groupEvenCssClass'=>'kv-grouped-row', // configure even group cell css class
        ],        
        [
            'label' => 'Tgl Peraturan',
            // 'width'=>'20%',
            'format' => 'date',
            'value' =>function($model){
                return $model['tgl_peraturan'];
            },
            // 'group'=>true,  // enable grouping,
            // 'groupedRow'=>true,                    // move grouped column to a single grouped row
            // 'groupOddCssClass'=>'kv-grouped-row',  // configure odd group cell css class
            // 'groupEvenCssClass'=>'kv-grouped-row', // configure even group cell css class
        ],	
	],
]); 
 ?>