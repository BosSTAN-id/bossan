<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\widgets\DatePicker;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\controlhutang\models\TaRPHSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rekomendasi Pelunasan Hutang';
$this->params['breadcrumbs'][] = 'Control Hutang';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-rph-index">
    <p>
        <?= Html::a('<i class="fa fa-plus bg-white"></i> Buat RPH', ['create'], [
                                                    'class' => 'btn btn-xs btn-success',
                                                    'data-toggle'=>"modal",
                                                    'data-target'=>"#myModal",
                                                    'data-title'=>"Tambah RPH",
                                                    ]) ?>
        <?= Html::a('<i class="glyphicon glyphicon-print bg-white"></i> Cetak Rekap', ['rekap'], ['class' => 'btn btn-sm btn-default', 'onClick' => "return !window.open(this.href, 'SPH', 'width=1024,height=768')"]) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'export' => false, 
        'responsive'=>true,
        'hover'=>true,     
        'resizableColumns'=>false,
        'panel'=>['type'=>'primary', 'heading'=>'Daftar Rekomendasi Pelunasan Hutang'],
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
            'options' => ['id' => 'rph-pjax', 'timeout' => 5000],
        ],              
        'columns' => [
            [
                'class' => 'kartik\grid\ExpandRowColumn',
                'value' => function ($model, $key, $index, $column) {

                    return GridView::ROW_COLLAPSED;
                },

                'allowBatchToggle'=>true,
               'detail'=>function ($model, $key, $index, $column) {
                $model = \app\models\TaSPH::findOne(['Kd_Bidang' => $model->Kd_Bidang, 'Kd_Sub' => $model->Kd_Sub, 'Kd_Unit' => $model->Kd_Unit, 'Kd_Urusan' => $model->Kd_Urusan, 'No_SPH' => $model->No_SPH, 'Tahun' => $model->Tahun]);                               
                    return Yii::$app->controller->renderPartial('_sph', [
                        'model'=>$model,
                        ]);
                },
                'detailOptions'=>[
                    'class'=> 'kv-state-enable',
                ],

            ],        
            ['class' => 'kartik\grid\SerialColumn'],
            //'Tahun',
            'No_RPH',
            'No_SPH',
            'No_SPM',
            'Jatuh_Tempo:date',
            'Nilai_Bayar:decimal',
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{print} {view}{update}{delete}',
                'buttons' => [
                        'print' => function($url, $model){
                            return  Html::a('<i class="glyphicon glyphicon-print bg-white"></i>', ['rph', 'No_RPH' => $model->No_RPH], ['onClick' => "return !window.open(this.href, 'RPH', 'width=1024,height=768')"]);
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