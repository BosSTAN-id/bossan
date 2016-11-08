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
	    // [
	    //     'content' => Html::button('<i class="glyphicon glyphicon-plus"></i>', [
     //                'type'=>'button', 
     //                'title'=> 'Add Book', 
     //                'class'=>'btn btn-success'
     //            ]),
	    // ],
	    '{export}',
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
		'Tahun',
        'Kd_Trans_1',
        // [
        //     'attribute' => 'No SPM',
        //     'value' => function ($model){
        //         return $model->No_SPM ? $model->No_SPM : '-';
        //     }
        // ],        
        // 'Tgl_RPH:date',
        // [
        //     'label' => 'Jatuh Tempo',
        //     'format' => 'date',
        //     'value' => function ($model){
        //         return $model->Jatuh_Tempo;
        //     }
        // ],
		// 'noSPH.Nm_Perusahaan',
        [
            'attribute'=>'Nilai',
            'width'=>'150px',
            'hAlign'=>'right',
            'format'=>['decimal', 0],
            'pageSummary'=>true
        ],		
	],
]); 
 ?>