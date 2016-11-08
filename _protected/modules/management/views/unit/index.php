<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\detail\DetailView;
use kartik\select2\Select2;
use yii\bootstrap\Modal;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\management\models\TaSubUnitSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Unit Organisasi');
$this->params['breadcrumbs'][] = 'Management';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-sub-unit-index">

    <p>
        <?php IF($model == NULL )  echo Html::a(Yii::t('app', 'Buat Data Unit'), ['add'], ['class' => 'btn btn-xs btn-info', 'data' => ['method' => 'POST']]) ?>
    </p>

    <?php IF(isset($model)){
        echo DetailView::widget([
            'model' => $model,
            'condensed'=>true,
            'hover'=>true,
            'mode'=>DetailView::MODE_VIEW,
            'enableEditMode' => true,
            'hideIfEmpty' => false, //sembunyikan row ketika kosong
            'panel'=>[
                'heading'=>'<i class="fa fa-tag"></i> Rincian Program</h3>',
                'type'=>'warning',
                'headingOptions' => [
                    'tag' => 'h3', //tag untuk heading
                ],
            ],
            'buttons1' => '{update}', // tombol mode default, default '{update} {delete}'
            'buttons2' => '{save} {view}', // tombol mode kedua, default '{view} {reset} {save}'
            'viewOptions' => [
                'label' => '<span class="glyphicon glyphicon-remove-circle"></span>',
            ],        
            'attributes' => [
                [
                    'attribute' => 'Tahun',
                    'displayOnly' => true,
                ],
                [
                    'attribute' => 'Kd_Sub',
                    'value' => $model->kdUrusan->Nm_Sub_Unit,
                    'displayOnly' => true,
                ],
                'Nm_Pimpinan',
                'Nip_Pimpinan',
                'Jbt_Pimpinan',
                'Alamat',
                'Ur_Visi',
            ],
        ]);
    }
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'responsive'=>true,
        'hover'=>true,     
        'panel'=>['type'=>'primary', 'heading'=>'Jabatan '],
        'pager' => [
            'firstPageLabel' => 'First',
            'lastPageLabel'  => 'Last'
        ],
        'toolbar' => [
            [
                'content' =>  Html::a(Yii::t('app', 'Tambah Jabatan'), ['subunitjab/create'], ['class' => 'btn btn-xs btn-info', 'data-toggle'=>"modal", 'data-target'=>"#myModal", 'data-title'=>"Tambah Jabatan",]),
                //'options' => ['class' => 'btn btn-xs btn-info']
            ],
        ],
        'responsiveWrap' => false,
        'pager' => [
            'firstPageLabel' => 'Awal',
            'lastPageLabel'  => 'Akhir'
        ],
        'pjax'=>true,
        'pjaxSettings'=>[
            'options' => ['id' => 'jabatan-pjax', 'timeout' => 5000],
        ],                
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'No_Urut',
                'width' => '30px'
            ],
            'kdJab.Nm_Jab',
            'Nama',
            'Nip',
            'Jabatan',

            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{update} {delete}',
                'vAlign'=>'top',
                'controller' => 'subunitjab',
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
