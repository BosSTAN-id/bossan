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
        'Nm_Bidang',
        [
            'label' => 'Kode',
            'value' => function ($model){
                return $model['Kd_Trans_1'].'.'.$model['Kd_Trans_2'].'.'.$model['Kd_Trans_3'];
            }
        ],
        'Nm_Sub_Bidang',  
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
            'attribute'=>'Saldo',
            'width'=>'150px',
            'hAlign'=>'right',
            'format'=>['decimal', 0],
            'pageSummary'=>true
        ],		
	],
]); 
 ?>