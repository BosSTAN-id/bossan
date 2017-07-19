<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\bootstrap\Button;
use yii\helpers\Url;
use yii\bootstrap\ButtonDropdown;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\anggaran\models\TaBaverSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Berita Acara Verifikasi';
$this->params['breadcrumbs'][] = 'Anggaran';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-baver-index">

    <p>
        <?= Html::a('Tambah Berita Acara', ['create'], [
                                                    'class' => 'btn btn-xs btn-success',
                                                    'data-toggle'=>"modal",
                                                    'data-target'=>"#myModal",
                                                    'data-title'=>"Tambah Berita Acara",
                                                    ]) ?>
    </p>
    <?= GridView::widget([
        'id' => 'ta-baver',    
        'dataProvider' => $dataProvider,
        'export' => false, 
        'responsive'=>true,
        'hover'=>true,     
        'resizableColumns'=>true,
        'panel'=>['type'=>'primary', 'heading'=>$this->title],
        'responsiveWrap' => false,        
        'toolbar' => [
            [
                'content' => $this->render('_search', ['model' => $searchModel, 'Tahun' => $Tahun]),
            ],
        ],       
        'pager' => [
            'firstPageLabel' => 'Awal',
            'lastPageLabel'  => 'Akhir'
        ],
        'rowOptions'   => function ($model, $key, $index, $grid) {
            return ['data-id' => $model->tahun.'^'.$model->no_ba.'^abc'];
        },
        'pjax'=>true,
        'pjaxSettings'=>[
            'options' => ['id' => 'ta-baver-pjax', 'timeout' => 5000],
        ],        
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            'tahun',
            'no_ba',
            'tgl_ba',
            // 'verifikatur',
            // 'nip_verifikatur',
            // 'penandatangan',
            // 'jabatan_penandatangan',
            // 'nip_penandatangan',
            // 'status',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function($model){
                    // '<i class="fa fa-refresh fa-spin"></i>' untuk spin loading
                    if($model->status == 1){
                        $status = 'Final';
                    }else{
                        $status = 'Draft';
                    }
                    // return Button::widget([
                    //     'id' => 'status^'.$model->no_ba,
                    //     'label' => $status,
                    //     'encodeLabel' => false,
                    //     'options' => [
                    //         'class' => 'btn-primary btn-xs',
                    //         'data-url' => Url::to(['baper/status', 'no_ba' => $model->no_ba], true),
                    //     ],
                    // ]);
                    return Html::a($status, ['status', 'tahun' => $model->tahun, 'no_ba' => $model->no_ba],
                    [
                        'class' => 'btn btn-xs btn-primary',
                        'title' => Yii::t('yii', 'Ubah Status'),           
                        'data-confirm' => "Yakin mengubah status dari berita acara ini?",
                        'data-method' => 'POST',
                        'data-pjax' => 1
                    ]);
                }
            ],

            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{print} {view} {update} {delete} {rincian}',
                'noWrap' => true,
                'vAlign'=>'top',
                'visibleButtons' => [
                    'delete' => function ($model, $key, $index) {
                        return $model->status == 1 ? false : true;
                    }
                ],                
                'buttons' => [
                        'print' => function($url, $key, $model){
                          return Html::a('<span class="glyphicon glyphicon-print"></span>', ['printrka1', 'tahun' => $model['tahun'], 'no_ba' => $model['no_ba']],
                              [  
                                 'title' => Yii::t('yii', 'RKA 1'),
                                 'onClick' => "return !window.open(this.href, 'RKA 1', 'width=1024,height=768')"
                              ]).' '.
                              Html::a('<span class="glyphicon glyphicon-print"></span>', ['printrka221', 'tahun' => $model['tahun'], 'no_ba' => $model['no_ba']],
                              [  
                                 'title' => Yii::t('yii', 'RKA 2.2.1'),
                                 'onClick' => "return !window.open(this.href, 'RKA 2.2.1', 'width=1024,height=768')"
                              ]);
                            // return ButtonDropdown::widget([
                            //     'encodeLabel' => false, // if you're going to use html on the button label
                            //     'label' => '<i class="fa fa-print"></i>',
                            //     'dropdown' => [
                            //         'encodeLabels' => false, // if you're going to use html on the items' labels
                            //         'items' => [
                            //             [
                            //                 'label' => 'RKA 1',
                            //                 'url' => ['view', 'id' => $key],
                            //             ],
                            //             [
                            //                 'label' => 'RKA 2.2.1',
                            //                 'url' => ['update', 'id' => $key],
                            //                 // 'visible' => true,  // if you want to hide an item based on a condition, use this
                            //             ],
                            //             // [
                            //             //     'label' => \Yii::t('yii', 'Delete'),
                            //             //     'linkOptions' => [
                            //             //         'data' => [
                            //             //             'method' => 'post',
                            //             //             'confirm' => \Yii::t('yii', 'Are you sure you want to delete this item?'),
                            //             //         ],
                            //             //     ],
                            //             //     'url' => ['delete', 'id' => $key],
                            //             //     'visible' => true,   // same as above
                            //             // ],
                            //         ],
                            //         'options' => [
                            //             'class' => 'dropdown-menu-right', // right dropdown
                            //         ],
                            //     ],
                            //     'options' => [
                            //         'class' => ' btn-xs btn-default',   // btn-success, btn-info, et cetera
                            //     ],
                            //     'split' => true,    // if you want a split button
                            // ]);
                        },
                        'update' => function ($url, $model) {
                            if($model->status != 1) return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url,
                                [  
                                    'title' => Yii::t('yii', 'ubah'),
                                    'data-toggle'=>"modal",
                                    'data-target'=>"#myModal",
                                    'data-title'=> "Ubah",                                 
                                    // 'data-confirm' => "Yakin menghapus ini?",
                                    // 'data-method' => 'POST',
                                    // 'data-pjax' => 1
                                ]);
                        },
                        'view' => function ($url, $model) {
                          return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url,
                              [  
                                 'title' => Yii::t('yii', 'lihat'),
                                 'data-toggle'=>"modal",
                                 'data-target'=>"#myModal",
                                 'data-title'=> "Lihat",
                              ]);
                        },
                        'rincian' => function ($url, $model) {
                          return Html::a('Lampiran RKAS <i class="glyphicon glyphicon-menu-right"></i>', $url,
                              [  
                                 'title' => Yii::t('yii', 'Daftar RKAS Terlampir'),
                                 'class'=>"btn btn-xs btn-default",                                 
                                 // 'data-confirm' => "Yakin menghapus sasaran ini?",
                                 // 'data-method' => 'POST',
                                 'data-pjax' => 0
                              ]);
                        },
                ]
            ],
        ],
    ]); ?>
</div>
<?php 
//row click link
$this->registerJs("
    $('td').click(function (e) {
        var id = $(this).closest('tr').data('id').split('^');
        if(e.target == this)
            location.href = '" . \Yii\helpers\Url::to(['rincian']) . "?tahun=' + id[0] +'&no_ba=' + id[1];
    });
");
Modal::begin([
    'id' => 'myModal',
    'header' => '<h4 class="modal-title">Lihat lebih...</h4>',
        'options' => [
            'tabindex' => false // important for Select2 to work properly
        ], 
]);
 
echo '...';
 
Modal::end();
$this->registerJs("
    $('#myModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var modal = $(this)
        var title = button.data('title') 
        var href = button.attr('href') 
        modal.find('.modal-title').html(title)
        modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
        $.post(href)
            .done(function( data ) {
                modal.find('.modal-body').html(data)
            });
        })
");
$this->registerJs(<<<JS
    $("[id^='status^']").on('click', function () {
        var btn = $(this).button('loading')
        console.log('clicked')
        // business logic...
        btn.button('reset')
    })    
JS
);
?>