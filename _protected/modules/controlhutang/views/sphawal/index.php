<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use yii\bootstrap\Modal;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\controlhutang\models\TaSPHSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Surat Pengakuan Hutang - Saldo Awal';
$this->params['breadcrumbs'][] = 'Akuntansi';
$this->params['breadcrumbs'][] = 'Utang';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-sph-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('<i class="fa fa-plus bg-white"></i> Buat SPH', ['create'],  [
                                                    'class' => 'btn btn-xs btn-success',
                                                    'data-toggle'=>"modal",
                                                    'data-target'=>"#myModal",
                                                    'data-title'=>"Tambah Program RPJMD",
                                                    ]) ?>
        <?= Html::a('<i class="glyphicon glyphicon-print bg-white"></i> Cetak Rekap', ['rekap'], ['class' => 'btn btn-xs btn-default', 'onClick' => "return !window.open(this.href, 'SPH', 'width=1024,height=768')"]) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'export' => false, 
        'responsive'=>true,
        'hover'=>true,     
        'resizableColumns'=>false,
        'panel'=>['type'=>'primary', 'heading'=>'Daftar Surat Pengakuan Hutang'],
        'responsiveWrap' => false,        
        'toolbar' => [
            [
                'content' => $this->render('_search', ['model' => $searchModel]),
            ],
        ],       
        'pager' => [
            'firstPageLabel' => 'Awal',
            'lastPageLabel'  => 'Akhir'
        ],
        'pjax'=>true,
        'pjaxSettings'=>[
            'options' => ['id' => 'sphawal-pjax', 'timeout' => 5000],
        ],               
        'columns' => [
            [
                'class' => 'kartik\grid\SerialColumn',
                'header'=>'No',
                'vAlign'=>'Top'
            ],
            [
                'attribute'=>'No_SPH',
                'header'=>'Nomor SPH'
            ],
            [
                'attribute'=>'Tgl_SPH',
                'header'=>'Tanggal <br> SPH',
                'format'=>['Date','php:d-m-Y'],
                'hAlign' => 'center'
            ],
            [
                'attribute'=>'No_Kontrak',
                'header'=>'Nomor Kontrak',
            ],
            [
                'attribute'=>'Tgl_Kontrak',
                'header' => 'Tanggal <br> Kontrak',
                'format'=>['Date','php:d-m-Y'],
                'hAlign' => 'center'
            ],
            [
                'attribute'=>'Nm_Perusahaan',
                'header'=>'Nama Perusahaan'
            ],
            [
                'header'=>'Pekerjaan',
                'attribute'=>'Pekerjaan',
                'class' => 'kartik\grid\DataColumn',
                'format' => 'raw',
                'noWrap' => false,
                'contentOptions' => 
                ['style'=>'max-width: 350px; overflow: auto; word-wrap: break-word;']
                
                //'value' => function($model) 

                //    {
                //       return Html::tag('span',wordwrap($model->Pekerjaan,30, "<br />\n"), ['style'=>'max-width: 400px; min-height:100px; overflow: auto; word-wrap: break-word;']);
                        //return " span " style = 'max-width: 400px; min-height:100px; 
                        //overflow: auto; word-wrap: break-word;'. $model->decription'</span>'
                //   },
            ],

            //'Nm_Kepala_SKPD',
            //'NIP',
            //'Jabatan',
            // 'Alamat',
            //'Kd_Rekanan',
            //'Nm_Rekanan',
            // 'Jab_Rekanan',
            // 'Alamat_Rekanan',
            [
                'header'=>'Nilai',
                'attribute' => 'Nilai',
                'format' => ['decimal',2],
                'hAlign' => 'right'
            ],
            
            //['terima', 'id' => $model->id]
            /*
            [
                'label' => 'Aksi',
                'format'=>'raw',
                'value' => function($model){
                    return 
                    Html::a('<i class="glyphicon glyphicon-print bg-white"></i> Cetak', ['sph', 'No_SPH' => $model->No_SPH], ['class' => 'btn btn-xs btn-default', 'onClick' => "return !window.open(this.href, 'SPH', 'width=1024,height=768')"]);
                },
            ],
            */
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{print} {update} {delete}',
                'vAlign'=>'top',
                'buttons' => [
                        'update' => function ($url, $model) {
                          return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url,
                              [  
                                 'title' => Yii::t('yii', 'hapus'),
                                 'data-toggle'=>"modal",
                                 'data-target'=>"#myModalUbah",
                                 'data-title'=> "Ubah Unit",                                 
                                 // 'data-confirm' => "Yakin menghapus sasaran ini?",
                                 // 'data-method' => 'POST',
                                 // 'data-pjax' => 1
                              ]);
                        },                
                        'print' => function($url, $model){
                            return  Html::a('<i class="glyphicon glyphicon-print bg-white"></i>', ['sph', 'No_SPH' => $model->No_SPH], ['onClick' => "return !window.open(this.href, 'SPH', 'width=1024,height=768')"]);
                        }
                ]
            ],
        ],
    ]); ?>
</div>
<?php 
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
?>
<?php 
    Modal::begin([
        'id' => 'myModalUbah',
        'header' => '<h4 class="modal-title">Lihat lebih...</h4>',
        'options' => [
            'tabindex' => false // important for Select2 to work properly
        ],         
    ]);
     
    echo '...';
     
    Modal::end();

$this->registerJs("
    $('#myModalUbah').on('show.bs.modal', function (event) {
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