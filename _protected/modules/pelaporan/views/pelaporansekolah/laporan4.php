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
                'content' => Yii::$app->user->identity->Kd_Urusan ? '' : $this->render('_skpd'),
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
        // [
        //     'attribute'=>'No_SPH', 
        //     'width'=>'250px',
        //     'value'=>function ($model, $key, $index, $widget) { 
        //         return $model->No_SPH;
        //     },
        //     'group'=>true,  // enable grouping
        //     // 'groupedRow'=>true,                    // move grouped column to a single grouped row
        //     'groupHeader'=>function ($model, $key, $index, $widget) { // Closure method
        //         return [
        //             'mergeColumns'=>[[0,2]], // columns to merge in summary
        //             'content'=>[             // content to show in each summary cell
        //                 1=>'Tahun (' . $model->Tahun . ')',
        //                 3=>GridView::F_SUM,
        //             ],
        //             'contentFormats'=>[      // content reformatting for each summary cell
        //                 3=>['format'=>'decimal', 'decimals'=>0, 'thousandSep' => '.'],
        //             ],
        //             'contentOptions'=>[      // content html attributes for each summary cell
        //                 1=>['style'=>'font-variant:small-caps'],
        //                 3=>['style'=>'text-align:right'],
        //             ],
        //             // html attributes for group summary row
        //             'options'=>['class'=>'danger','style'=>'font-weight:bold;']
        //         ];
        //     }
        // ],
		[
            'label' => 'Tahun',
            'attribute' => 'Tahun',
            'group' => true
        ],
        [
            'label' => 'No SPH',
            'attribute' => 'No_SPH',
            'group' => true
        ],
		'Nilai:decimal',
        [
            'label' => 'No RPH',
            'attribute' => 'No_RPH'
        ],
        [
            'label' => 'No SP2D',
            'attribute' => 'No_SP2D'
        ],
        [
            'attribute'=>'Nilai_Bayar',
            'width'=>'150px',
            'hAlign'=>'right',
            'format'=>['decimal', 0],
            'pageSummary'=>true
        ],
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