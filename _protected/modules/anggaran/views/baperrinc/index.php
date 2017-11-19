<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;
use yii\widgets\DetailView;
use yii\bootstrap\Collapse;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\anggaran\models\TaRkasPeraturanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Lampiran BA '.$model->no_ba;
$this->params['breadcrumbs'][] = 'Anggaran';
$this->params['breadcrumbs'][] = ['label' => 'Berita Acara Verifikasi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);
switch ($model->status) {
    case 1:
        $status = 'Final';
        break;
    default:
        $status = 'Usulan/Draft';
        break;
}
?>
<div class="ta-rkas-peraturan-index">
    <div class="row">
        <div class="col-md-8">
            <div class="box box-primary collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">Daftar Lampiran BA: <?= $model->no_ba ?> <small>(klik untuk rincian)</small></h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="glyphicon glyphicon-chevron-down"></i>
                        </button>
                    </div>            
                </div><!-- /.box-header -->
                <div class="box-body">

                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        [
                            'label' => 'No Berita Acara',
                            'value' => $model['no_ba'],
                        ],
                        'tgl_ba:date',
                        [
                            'label' => 'Status',
                            'value' =>  $status
                        ]
                    ],
                ]) ?>
                </div><!-- /.box-body -->
            </div>
        </div>   
    </div>

    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'bootstrap' => true,
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columns.php'),
            'toolbar'=> [
                ['content'=>
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                    ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Reset Grid']).
                    '{toggleData}'.
                    '{export}'
                ],
            ],          
            'striped' => true,
            'condensed' => true,
            'responsive' => true, 
            'responsiveWrap' => false,            
            'panel' => [
                'type' => 'primary', 
                'heading' => '<i class="glyphicon glyphicon-list"></i> Daftar RKAS/P',
                // 'before'=>'<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
                'after'=>
                        Html::hiddenInput('no_ba', $model->no_ba).
                        BulkButtonWidget::widget([
                            'buttons'=>Html::a('<i class="glyphicon glyphicon-pencil"></i>&nbsp; Lampirkan pada BA ini',
                                ["bulk-update"] ,
                                [
                                    "class"=>"btn btn-danger btn-xs",
                                    'role'=>'modal-remote-bulk',
                                    'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                                    'data-request-method'=>'post',
                                    'data-confirm-title'=>'Lampirkan pada BA ini?',
                                    'data-confirm-message'=>'Yakin melampirkan?'
                                ]),
                        ]).                        
                        '<div class="clearfix"></div>',
            ]
        ])?>
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
<?php 
$this->registerJs(<<<JS
    $("form[id^='preview-form-']").on("submit", function(e){
        window.open('', 'formpopup', 'width=1024,height=768,resizeable,scrollbars');
        this.target = 'formpopup';
    });
JS
);