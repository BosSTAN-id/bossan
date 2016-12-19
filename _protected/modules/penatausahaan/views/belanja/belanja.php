<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\widgets\DetailView;
use yii\bootstrap\Collapse;

function totalbelanja($tahun, $sekolah_id, $kd_program, $kd_sub_program, $kd_kegiatan, $Kd_Rek_1, $Kd_Rek_2, $Kd_Rek_3, $Kd_Rek_4, $Kd_Rek_5){
    $belanja = \app\models\TaRkasBelanjaRinc::find()
                ->where(['tahun' => $tahun, 'sekolah_id' => $sekolah_id, 'kd_program' => $kd_program, 'kd_sub_program' => $kd_sub_program, 'kd_kegiatan' => $kd_kegiatan , 'Kd_Rek_1' => $Kd_Rek_1, 'Kd_Rek_2' => $Kd_Rek_2, 'Kd_Rek_3' => $Kd_Rek_3, 'Kd_Rek_4' => $Kd_Rek_4, 'Kd_Rek_5' => $Kd_Rek_5])
                ->sum('total');
    return  $belanja ? $belanja : 0;
}
/* @var $this yii\web\View */
/* @var $searchModel app\modules\anggaran\models\TaRkasKegiatan */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Belanja';
$this->params['breadcrumbs'][] = 'Penatausahaan';
$this->params['breadcrumbs'][] = ['label' => 'Belanja', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Belanja Langsung', 'url' => ['bl']];
$this->params['breadcrumbs'][] = $kegiatan->refKegiatan->uraian_kegiatan;
?>
<div class="ta-rkas-kegiatan-index">
<div class="row">
<div class="col-md-9">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?= $kegiatan->kd_program.'.'.$kegiatan->kd_sub_program.'.'.$kegiatan->kd_kegiatan.' '.$kegiatan->refKegiatan->uraian_kegiatan ?></h3>
        </div><!-- /.box-header -->
        <div class="box-body">

        <?= DetailView::widget([
            'model' => $kegiatan,
            'attributes' => [
                [
                    'label' => 'Sumber Dana',
                    'value' => $kegiatan['penerimaan2']['uraian'],
                ],
                'pagu_anggaran:decimal',
            ],
        ]) ?>
        </div><!-- /.box-body -->
    </div>        

    <p>
        <?= Html::a('Tambah Bukti Belanja', [
            'createbl',
                'tahun' => $kegiatan->tahun,
                'sekolah_id' => $kegiatan->sekolah_id,
                'kd_program' => $kegiatan->kd_program,
                'kd_sub_program' => $kegiatan->kd_sub_program,
                'kd_kegiatan' => $kegiatan->kd_kegiatan,
            ], [
                'class' => 'btn btn-xs btn-success',
                'data-toggle'=>"modal",
                'data-target'=>"#myModal",
                'data-title'=>"Tambah Belanja",
            ]) ?>
    </p>
    <?= GridView::widget([
        'id' => 'ta-rkas-kegiatan',    
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
            'options' => ['id' => 'belanja-pjax', 'timeout' => 5000],
        ],        
        // 'filterModel' => $searchModel,
        'showPageSummary'=>true,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            [
                'label' => 'Jenis Belanja',
                'value' => function($model){
                    return $model->refRek5->Nm_Rek_5;
                }
            ],
            'no_bukti',
            'tgl_bukti',            
            'uraian',
            'nilai:decimal',
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{view} {updatebl} {delete}',
                'noWrap' => true,
                'vAlign'=>'top',
                'buttons' => [
                        'updatebl' => function ($url, $model) {
                          IF($model->no_spj == NULL)
                          return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url,
                              [  
                                 'title' => Yii::t('yii', 'ubah'),
                                 'data-toggle'=>"modal",
                                 'data-target'=>"#myModal",
                                 'data-title'=> "Ubah Bukti",                                 
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
                                 'data-target'=>"#myModal",
                                 'data-title'=> "Bukti".$model->no_bukti,                                 
                                 // 'data-confirm' => "Yakin menghapus sasaran ini?",
                                 // 'data-method' => 'POST',
                                 // 'data-pjax' => 1
                              ]);
                      }
                ]
            ],
        ],
    ]); ?>
</div><!--col-->
<div class="col-md-3">
    <div class="box box-solid">
        <div class="box-header with-border bg-aqua">
            <h3 class="box-title"><i class="fa fa-clipboard"></i>Program - Kegiatan</h3>
        </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div id="accordion" class="box-group">
            <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
            <?php $i = 1; foreach($treeprogram AS $treeprogram): ?>
            <div class="panel box box-<?= $treeprogram->kd_program == $kegiatan->kd_program ? 'danger' : 'primary' ?>">
                <div class="box-header with-border">
                    <h5 class="box-title">
                    <a href="#collapse<?= $i ?>" data-parent="#accordion" data-toggle="collapse" class="<?= $treeprogram->kd_program == $kegiatan->kd_program ? '' : 'collapsed' ?>" aria-expanded="<?= $treeprogram->kd_program == $kegiatan->kd_program ? 'true' : 'false' ?>">
                    <?= $treeprogram->refProgram->uraian_program ?>
                    </a>
                    </h5>
                </div>
                <div class="panel-collapse <?= $treeprogram->kd_program == $kegiatan->kd_program ? 'collapse in' : 'collapse' ?>" id="collapse<?= $i ?>" aria-expanded="<?= $treeprogram->kd_program == $kegiatan->kd_program ? 'true' : 'false' ?>" style="<?= $treeprogram->kd_program == $kegiatan->kd_program ? '' : 'height: 0px;' ?>">
                    <div class="box-body">
                    <?php 
                    $subprogramawal = NULL;
                    $listkegiatan = \app\models\TaRkasKegiatan::find()
                        // ->select('tahun, sekolah_id, kd_program, kd_sub_program, kd_kegiatan')
                        ->where(['tahun' => $Tahun, 'sekolah_id' => $kegiatan->sekolah_id, 'kd_program' => $treeprogram->kd_program])
                        // ->groupBy('tahun, sekolah_id, kd_program, kd_sub_program,)
                        ->all();
                        foreach($listkegiatan as $listkegiatan){
                            $subprogram = $listkegiatan->refSubProgram->uraian_sub_program;
                            IF($subprogramawal != $subprogram){
                                echo $subprogram;
                                echo '<ol>';
                                echo Html::a('<li>'.$listkegiatan->refKegiatan->uraian_kegiatan.'</li>', 
                                    [
                                        'blbelanja',
                                        'tahun' => $listkegiatan->tahun,
                                        'sekolah_id' => $listkegiatan->sekolah_id,
                                        'kd_program' => $listkegiatan->kd_program,
                                        'kd_sub_program' => $listkegiatan->kd_sub_program,
                                        'kd_kegiatan' => $listkegiatan->kd_kegiatan,
                                    ],
                                    [
                                        'class' => $listkegiatan->kd_sub_program.'.'.$listkegiatan->kd_kegiatan == $kegiatan->kd_sub_program.'.'.$kegiatan->kd_kegiatan ? 'text-bold' : '',
                                    ]
                                );
                            }ELSE{
                                echo Html::a('<li>'.$listkegiatan->refKegiatan->uraian_kegiatan.'</li>', 
                                    [
                                        'rkasbelanja',
                                        'tahun' => $listkegiatan->tahun,
                                        'sekolah_id' => $listkegiatan->sekolah_id,
                                        'kd_program' => $listkegiatan->kd_program,
                                        'kd_sub_program' => $listkegiatan->kd_sub_program,
                                        'kd_kegiatan' => $listkegiatan->kd_kegiatan,
                                    ],
                                    [
                                        'class' => $listkegiatan->kd_sub_program.'.'.$listkegiatan->kd_kegiatan == $kegiatan->kd_sub_program.'.'.$kegiatan->kd_kegiatan ? 'text-bold' : '',
                                    ]
                                );
                            }
                        }
                    ?>
<!--                     Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid.
                    <ol>
                        <li>Lorem ipsum dolor sit amet</li>
                        <li>Consectetur adipiscing elit</li>
                        <li>Integer molestie lorem at massa</li>
                        <li>Facilisis in pretium nisl aliquet</li>
                        <li>Faucibus porta lacus fringilla vel</li>
                        <li>Aenean sit amet erat nunc</li>
                        <li>Eget porttitor lorem</li> -->
                    </ol>                    
                    </div>
                </div>
            </div>
            <?php $i++; endforeach; ?>
        </div>
    </div>
    <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div><!--col-->
</div><!--row-->
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

Modal::begin([
    'id' => 'myModalrinci',
    'header' => '<h4 class="modal-title">Lihat lebih...</h4>',
        'options' => [
            'tabindex' => false // important for Select2 to work properly
        ], 
]);
 
echo '...';
 
Modal::end();

$this->registerJs("
    $('#myModalrinci').on('show.bs.modal', function (event) {
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

Modal::begin([
    'id' => 'myModalrinciubah',
    'header' => '<h4 class="modal-title">Lihat lebih...</h4>',
        'options' => [
            'tabindex' => false // important for Select2 to work properly
        ], 
]);
 
echo '...';
 
Modal::end();
$this->registerJs("
    $('#myModalrinciubah').on('show.bs.modal', function (event) {
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