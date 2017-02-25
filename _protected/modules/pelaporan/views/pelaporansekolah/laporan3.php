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
            'label' => 'Tanggal',
            'width'=>'10%',
            'format' => 'date',
            'value' =>function($model){
                return $model['tgl_bukti'];
            },
            'group'=>true,  // enable grouping,
            // 'groupedRow'=>true,                    // move grouped column to a single grouped row
            // 'groupOddCssClass'=>'kv-grouped-row',  // configure odd group cell css class
            // 'groupEvenCssClass'=>'kv-grouped-row', // configure even group cell css class
        ],
        [
            'label' => 'No Kode',
            'width'=>'10%',
            'value' =>function($model){
                return $model['kode'];
            },
            // 'group'=>true,  // enable grouping,
            // 'groupedRow'=>true,                    // move grouped column to a single grouped row
            // 'groupOddCssClass'=>'kv-grouped-row',  // configure odd group cell css class
            // 'groupEvenCssClass'=>'kv-grouped-row', // configure even group cell css class
        ],
        [
            'label' => 'No Bukti',
            'width'=>'20%',
            'value' =>function($model){
                return $model['no_bukti'];
            },
            // 'group'=>true,  // enable grouping,
            // 'groupedRow'=>true,                    // move grouped column to a single grouped row
            // 'groupOddCssClass'=>'kv-grouped-row',  // configure odd group cell css class
            // 'groupEvenCssClass'=>'kv-grouped-row', // configure even group cell css class
        ],        
        [
            'label' => 'Urian',
            // 'width'=>'20%',
            'value' =>function($model){
                return $model['keterangan'];
            },
            // 'group'=>true,  // enable grouping,
            // 'groupedRow'=>true,                    // move grouped column to a single grouped row
            // 'groupOddCssClass'=>'kv-grouped-row',  // configure odd group cell css class
            // 'groupEvenCssClass'=>'kv-grouped-row', // configure even group cell css class
        ],
        [
            'label'=>'Penerimaan (Debit)',
            // 'width'=>'150px',
            'hAlign'=>'right',
            'format'=>['decimal', 0],
            'pageSummary'=>true,
            'value' => function($model){
                IF($model['nilai'] >= 0 ){
                    return $model['nilai'];
                }ELSE{
                    return '';
                }
            }
        ],           
        [
            'label'=>'Pengeluaran (Kredit)',
            // 'width'=>'150px',
            'hAlign'=>'right',
            'format'=>['decimal', 0],
            'pageSummary'=>true,
            'value' => function($model){
                IF($model['nilai'] < 0 ){
                    return -$model['nilai'];
                }ELSE{
                    return '';
                }
            }
        ],                   
  //       [
  //           'attribute' => 'No SPM',
  //           'value' => function ($model){
  //               return $model->No_SPM ? $model->No_SPM : '-';
  //           }
  //       ],        
  //       'Tgl_RPH:date',
  //       [
  //           'label' => 'Jatuh Tempo',
  //           'format' => 'date',
  //           'value' => function ($model){
  //               return $model->Jatuh_Tempo;
  //           }
  //       ],
		// 'noSPH.Nm_Perusahaan',
  //       [
  //           'attribute'=>'Nilai_Bayar',
  //           'width'=>'150px',
  //           'hAlign'=>'right',
  //           'format'=>['decimal', 0],
  //           'pageSummary'=>true
  //       ],		
	],
]); 
 ?>