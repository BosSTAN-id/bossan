<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\globalsetting\models\RefRek5Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bagan Akun Standar';
$this->params['breadcrumbs'][] = 'Pengaturan';
$this->params['breadcrumbs'][] = ['label' => 'Seleksi Rekening', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-rek5-index">
    <div class="alert-warning alert fade in" id="w1-success">
        <button class="close" aria-hidden="true" type="button" data-dismiss="alert">×</button>

        <i class="icon fa fa-info-circle"></i> Anda akan menyeleksi rekening yang dapat dipilih oleh sekolah untuk penyusunan anggaran. Rekening mengacu pada Bagan Akun Standar yang tertuang dalam Kebijakan Akuntansi dan Sistem Akuntansi Pemerintah Daerah berkaitan dengan Kode Rekening Anggaran (Rekening Permendagri 13/2006).

    </div>
    <?= GridView::widget([
        'id' => 'ref-rek5',    
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
            'options' => ['id' => 'ref-rek5-pjax', 'timeout' => 5000],
        ],        
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'Kd_Rek_1',
            'Kd_Rek_2',
            'Kd_Rek_3',
            'Kd_Rek_4',
            'Kd_Rek_5',
            'Nm_Rek_5',
            [
                'attribute' => 'Sekolah',
                'label' => '',
                'hAlign' => 'center',
                'format' => 'raw',
                'value' => function($model, $url, $key){
                    IF($model->Sekolah == 1){
                        return Html::a('<span class="glyphicon glyphicon-ok"></span>', '#',
                              [  
                                 'class' => 'btn btn-xs btn-success', 
                                //  'title' => Yii::t('yii', 'ubah'),
                                //  'data-toggle'=>"modal",
                                //  'data-target'=>"#myModalubah",
                                //  'data-title'=> "Ubah",                                 
                                 // 'data-confirm' => "Yakin menghapus sasaran ini?",
                                 // 'data-method' => 'POST',
                                 // 'data-pjax' => 1
                              ]);
                    }ELSE{
                        return Html::a('<span class="glyphicon glyphicon-remove"></span>', '#',
                              [  
                                 'class' => 'btn btn-xs btn-danger', 
                                //  'title' => Yii::t('yii', 'ubah'),
                                //  'data-toggle'=>"modal",
                                //  'data-target'=>"#myModalubah",
                                //  'data-title'=> "Ubah",                                 
                                 // 'data-confirm' => "Yakin menghapus sasaran ini?",
                                 // 'data-method' => 'POST',
                                 // 'data-pjax' => 1
                              ]);
                    }
                }
            ],

            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{assign}',
                'noWrap' => true,
                'vAlign'=>'top',
                'buttons' => [
                        'assign' => function ($url, $model) {
                          return Html::a('<span class="glyphicon glyphicon-refresh"></span>', $url,
                              [  
                                 'title' => Yii::t('yii', 'Ubah Seleksi'),
                                //  'data-toggle'=>"modal",
                                //  'data-target'=>"#myModalubah",
                                //  'data-title'=> "Ubah",                                 
                                 'data-confirm' => "Ubah seleksi akun ini?",
                                 // 'data-method' => 'POST',
                                 'data-pjax' => 1
                              ]);
                        },
                        'update' => function ($url, $model) {
                          return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url,
                              [  
                                 'title' => Yii::t('yii', 'ubah'),
                                 'data-toggle'=>"modal",
                                 'data-target'=>"#myModalubah",
                                 'data-title'=> "Ubah",                                 
                                 // 'data-confirm' => "Yakin menghapus sasaran ini?",
                                 // 'data-method' => 'POST',
                                 // 'data-pjax' => 1
                              ]);
                        },
                        'view' => function ($url, $model) {
                          return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url,
                              [  
                                 'title' => Yii::t('yii', 'lihat'),
                                 'data-toggle'=>"modal",
                                 'data-target'=>"#myModalubah",
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
]);
 
echo '...';
 
Modal::end();

Modal::begin([
    'id' => 'myModalubah',
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
$this->registerJs("
    $('#myModalubah').on('show.bs.modal', function (event) {
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