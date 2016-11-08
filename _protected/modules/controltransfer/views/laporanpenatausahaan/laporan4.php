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
        [
            'attribute'=>'Kd_Trans_2', 
            'width'=>'250px',
            'value'=>function ($model, $key, $index, $widget) { 
                return $model->Kd_Trans_1.'.'.$model->Kd_Trans_2.' '.$model->taTrans2->Nm_Bidang;
            },
            'group'=>true,  // enable grouping
            // 'groupedRow'=>true,                    // move grouped column to a single grouped row
            'groupHeader'=>function ($model, $key, $index, $widget) { // Closure method
                return [
                    'mergeColumns'=>[[0,2]], // columns to merge in summary
                    'content'=>[             // content to show in each summary cell
                        1=> $model->taTrans2->Nm_Bidang,
                        3=>GridView::F_SUM,
                        4=>GridView::F_SUM,
                    ],
                    'contentFormats'=>[      // content reformatting for each summary cell
                        3=>['format'=>'decimal', 'decimals'=>0, 'thousandSep' => '.'],
                        4=>['format'=>'decimal', 'decimals'=>0, 'thousandSep' => '.'],
                    ],
                    'contentOptions'=>[      // content html attributes for each summary cell
                        1=>['style'=>'font-variant:small-caps'],
                        3=>['style'=>'text-align:right'],
                        4=>['style'=>'text-align:right'],
                    ],
                    // html attributes for group summary row
                    'options'=>['class'=>'danger','style'=>'font-weight:bold;']
                ];
            }
        ],
		'taTrans3.Nm_Sub_Bidang',
		'No_Kontrak',
        [
            'attribute'=>'taKontrak.Nilai',
            'width'=>'150px',
            'hAlign'=>'right',
            'format'=>['decimal', 0],
            'pageSummary'=>true
        ],
        [
            'attribute'=>'Pagu',
            'width'=>'150px',
            'hAlign'=>'right',
            'format'=>['decimal', 0],
            'pageSummary'=>true
        ],		
	],
]); 
 ?>