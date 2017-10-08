<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\asettetap\models\TaAsetTetapBaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rekonsiliasi Aset';
$this->params['breadcrumbs'][] = 'Aset Tetap';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-aset-tetap-ba-index">

    <p>
        <?= Html::a('Tambah BA Rekonsiliasi', ['create'], [
                                                    'class' => 'btn btn-xs btn-success',
                                                    'data-toggle'=>"modal",
                                                    'data-target'=>"#myModal",
                                                    'data-title'=>"Tambah Berita Acara Rekonsiliasi",
                                                    ]) ?>
    </p>
    <?= GridView::widget([
        'id' => 'ta-aset-tetap-ba',    
        'dataProvider' => $dataProvider,
        'export' => false, 
        'responsive'=>true,
        'hover'=>true,     
        'resizableColumns'=>true,
        'panel'=>['type'=>'primary', 'heading'=>$this->title],
        'responsiveWrap' => false,        
        'toolbar' => [
            [
                // 'content' => $this->render('_search', ['model' => $searchModel, 'Tahun' => $Tahun]),
            ],
        ],       
        'pager' => [
            'firstPageLabel' => 'Awal',
            'lastPageLabel'  => 'Akhir'
        ],
        'pjax'=>true,
        'pjaxSettings'=>[
            'options' => ['id' => 'ta-aset-tetap-ba-pjax', 'timeout' => 5000],
        ],        
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            'no_ba',
            'tgl_ba:date',
            'nm_penandatangan',
            // 'nip_penandatangan',
            // 'jbt_penandatangan',
            // 'created_at',
            // 'updated_at',
            // 'created_by',
            // 'updated_by',

            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{print-ba} {dump-balance} {dump-aset} {view} {update} {delete}',
                'noWrap' => true,
                'vAlign'=>'top',
                // 'dropdown' => true,
                // 'dropdownOptions' => ['class' => 'pull-right'],
                'visibleButtons'=> [
                    'dump-balance' => function($model){
                        if($model->balance_status == 0) return true;
                        return false;
                    },
                    'dump-aset' => function($model){
                        if($model->snapshot_status == 0) return true;
                        return false;
                    },
                    'print-ba' => function($model){
                        if($model->balance_status == 1) return true;
                        return false;
                    }
                ],
                'buttons' => [
                        'dump-balance' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-send"></span>', $url,
                                [  
                                'title' => Yii::t('yii', 'Dump Balance'),
                                'class' => 'btn btn-xs btn-default',
                                // 'data-toggle'=>"modal",
                                // 'data-target'=>"#myModal",
                                // 'data-title'=> "Ubah",                                 
                                'data-confirm' => "Akan melakukan pengambilan data saldo, mungkin memakan waktu lama. Yakin Proses?",
                                'data-method' => 'POST',
                                // 'data-pjax' => 1
                                ]);
                        },  
                        'dump-aset' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-save"></span>', $url,
                                [  
                                'title' => Yii::t('yii', 'Dump Snapshot'),
                                'class' => 'btn btn-xs btn-danger',
                                // 'data-toggle'=>"modal",
                                // 'data-target'=>"#myModal",
                                // 'data-title'=> "Ubah",                                 
                                'data-confirm' => "Akan melakukan pengambilan snapshot data rincian aset, akan memakan waktu lama. Sebaiknya hanya dilakukan pada BA akhir tahun saja. Yakin Proses?",
                                'data-method' => 'POST',
                                // 'data-pjax' => 1
                                ]);
                        },                        
                        'update' => function ($url, $model) {
                          return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url,
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
                        'print-ba' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-print"></span>', $url,
                                [  
                                   'title' => Yii::t('yii', 'Cetak'),
                                   'onClick' => "return !window.open(this.href, 'SPJ', 'width=1024,height=768')"
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
                ]
            ],
        ],
    ]); ?>
</div>
<?php Modal::begin([
    'id' => 'myModal',
    'header' => '<h4 class="modal-title">Lihat lebih...</h4>',
    'options' => [
        'tabindex' => false // important for Select2 to work properly
    ], 
    'size' => 'modal-lg'
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
?>