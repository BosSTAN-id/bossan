<?php

use kartik\detail\DetailView;
use yii\helpers\Html;
use kartik\tabs\TabsX;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\widgets\MaskedInput;
use yii\bootstrap\Collapse;
use kartik\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\TaSPJRinc */

$this->title = 'Bukti No: '.$model->no_bukti;
$this->params['breadcrumbs'][] = 'Penatausahaan';
$this->params['breadcrumbs'][] = ['label' => 'Belanja', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-spjrinc-view">
 
    <?php
    // Grid Bukti
    $buktiContent = DetailView::widget([
        'model' => $model,
        'condensed'=>true,
        'hover'=>true,
        'mode'=>DetailView::MODE_VIEW,
        'enableEditMode' => false,
        'hideIfEmpty' => false, //sembunyikan row ketika kosong
        'panel'=>[
            'heading'=> $model->no_spj == NULL ? Html::a('<i class="glyphicon glyphicon-pencil"></i> Ubah Bukti', ['update', 'tahun' => $model->tahun, 'no_bukti' => $model->no_bukti, 'tgl_bukti' => $model->tgl_bukti], [
                                'class' => 'btn btn-xs btn-success pull-right',
                                ]).'<i class="fa fa-tag"></i> '.$this->title.'</h3>'
                        : '<i class="fa fa-tag"></i> '.$this->title.'</h3>',
            'type'=>'primary',
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
            [ 'attribute' => 'no_bukti', 'displayOnly' => true],
            [ 'attribute' => 'tgl_bukti', 'format'=> 'date', 'displayOnly' => true],
            [ 'attribute' => 'uraian', 'displayOnly' => true],
            [ 
                'attribute' => 'kd_program', 
                'value' => $model->refProgram['uraian_program'],
                'displayOnly' => true
            ],
            [ 
                'attribute' => 'kd_sub_program', 
                'value' => $model->refSubProgram['uraian_sub_program'],
                'displayOnly' => true
            ],
            [ 
                'attribute' => 'kd_kegiatan', 
                'value' => $model->refKegiatan['uraian_kegiatan'],
                'displayOnly' => true
            ],
            [ 
                'attribute' => 'Kd_Rek_3', 
                'value' => $model->refRek3['Nm_Rek_3'],
                'displayOnly' => true
            ],
            [ 
                'attribute' => 'Kd_Rek_5', 
                'value' => $model->refRek5['Nm_Rek_5'],
                'displayOnly' => true
            ],
            [ 
                'attribute' => 'komponen_id', 
                'value' => $model->komponen['komponen'],
                'displayOnly' => true
            ],
            [ 
                'attribute' => 'pembayaran', 
                'value' => $model['pembayaran'] == 1 ? 'Bank' : 'Tunai',
                'displayOnly' => true
            ],
            [ 'attribute' => 'nilai', 'format' => 'decimal', 'displayOnly' => true],
            [ 'attribute' => 'nm_penerima', 'displayOnly' => true],
            [ 'attribute' => 'alamat_penerima', 'displayOnly' => true],
        ],
    ]);

    // Form Potongan object
    $formPotongan = '';
    ob_start();
    $form = ActiveForm::begin(['id' => $modelPotongan->formName()]);
    echo $form->field($modelPotongan, 'kd_potongan')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(
                \app\models\RefPotongan::find()
                // ->select(['Kd_Rek_3', 'CONCAT(Kd_Rek_3,\' \',Nm_Rek_3) AS Nm_Rek_3'])
                // ->where(['Kd_Rek_1' => $model->Kd_Rek_1, 'Kd_Rek_2' => $model->Kd_Rek_2])
                ->all()
                ,'kd_potongan','nm_potongan'),
            'options' => ['placeholder' => 'Pilih Jenis Potongan ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    echo $form->field($modelPotongan, 'nilai', ['enableClientValidation' => false])->widget(MaskedInput::classname(), [
                'clientOptions' => [
                    'alias' =>  'decimal',
                    // 'groupSeparator' => ',',
                    'groupSeparator' => '.',
                    'radixPoint'=>',',                
                    'autoGroup' => true,
                    'removeMaskOnSubmit' => true,
                ],
        ]);
    echo Html::submitButton($modelPotongan->isNewRecord ? 'Simpan' : 'Simpan', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end();
    if($model->no_spj == NULL) $formPotongan = ob_get_contents();
    ob_end_clean();

    // grid potongan
    $gridPotongan = GridView::widget([
        'id'=>'potongan-datatable',
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'pjax'=>true,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            'kdPotongan.nm_potongan',
            'nilai:decimal',
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{delete}',
                'noWrap' => true,
                'vAlign'=>'top',
                'buttons' => [
                        'update' => function ($url, $model) {
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
                        'delete' => function ($url, $model) {
                          if ($model->bukti->no_spj == NULL) return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['deletepotongan', 'tahun' => $model->tahun, 'no_bukti' => $model->no_bukti, 'tgl_bukti' => $model->bukti->tgl_bukti, 'kd_potongan' => $model->kd_potongan],
                              [  
                                 'title' => Yii::t('yii', 'hapus'),
                                //  'data-toggle'=>"modal",
                                //  'data-target'=>"#myModal",
                                //  'data-title'=> "Bukti".$model->no_bukti,                                 
                                 'data-confirm' => "Yakin menghapus potongan ini?",
                                 'data-method' => 'POST',
                                 'data-pjax' => 1
                              ]);
                      }
                ]
            ],            
        ],          
        'striped' => true,
        'condensed' => true,
        'responsive' => true,          
        'panel' => [
            'type' => 'primary', 
            'heading' => '<i class="glyphicon glyphicon-list"></i> Daftar Potongan',
        ]
    ]);
    
    // tab potongan
    $potonganContent = 
    Collapse::widget([
        'items' => [
            [
                'label' => '<i class="glyphicon glyphicon-plus"></i> Tambah Potongan',
                'encode' => false,
                'content' => $formPotongan,
                'options' => ['class' => 'panel panel-danger'],
            ],
        ]
    ]).$gridPotongan;


    // Form Aset object
    $formAset = '';
    ob_start();
    echo $this->render('_aset-tetap-form', ['model' => $asetTetap, 'bukti' => $model]);
    if($model->no_spj == NULL) $formAset = ob_get_contents();
    ob_end_clean();
    
    $bukti = clone $model;
    // grid Aset
    $gridAset = GridView::widget([
        'id'=>'aset-datatable',
        'dataProvider' => $dataProviderAset,
        'pjax'=>true,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            'kdAset5.Nm_Aset5',
            'nilai_perolehan:decimal',
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{delete}', //
                'controller' => '/asettetap/inventarisasi',
                'noWrap' => true,
                'visibleButtons' => [
                    'delete' => function($model) use ($bukti){
                        if($bukti->no_spj == null) return true;
                        return false;
                    }
                ],
                'vAlign'=>'top',
                'buttons' => [
                        'update' => function ($url, $model) {
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
                ]
            ],            
        ],          
        'striped' => true,
        'condensed' => true,
        'responsive' => true,          
        'panel' => [
            'type' => 'primary', 
            'heading' => '<i class="glyphicon glyphicon-list"></i> Daftar Aset',
        ]
    ]);
    
    // tab potongan
    $asetContent = 
    Collapse::widget([
        'items' => [
            [
                'label' => '<i class="glyphicon glyphicon-plus"></i> Tambah Aset',
                'encode' => false,
                'content' => $formAset,
                'options' => ['class' => 'panel panel-danger'],
            ],
        ]
    ]).$gridAset;    

    // tab navigation
    echo TabsX::widget([
        'items'=>[
            [
                'label'=>'<i class="glyphicon glyphicon-folder-open"></i> Bukti',
                'content'=> $buktiContent,
                'active'=>true,
                'linkOptions'=>['id'=>'linkKecamatan'],
                'headerOptions' => ['id' => 'kecamatan']
            ],
            [
                'label'=>'<i class="glyphicon glyphicon-align-left"></i> Potongan',
                'content'=> $potonganContent,
                'linkOptions'=>['id'=>'linkKelurahan'],
                'headerOptions' => [
                    // 'class'=>'disabled', 
                    'id' => 'kelurahan'
                ]
            ], 
            [
                'label'=>'<i class="glyphicon glyphicon-home"></i> Aset Tetap',
                'content'=> $asetContent,
                'linkOptions'=>['id'=>'linkAset'],
                'headerOptions' => [
                    // 'class'=>'disabled', 
                    'id' => 'asettetap'
                ]
            ],            
        ],
        'position'=>TabsX::POS_ABOVE,
        'bordered'=>true,
        'sideways'=>true,
        'encodeLabels'=>false
    ]);         
     ?>

</div>
<?php
$script = <<<JS
$('form#{$modelPotongan->formName()}').on('beforeSubmit',function(e)
{
    var \$form = $(this);
    $.post(
        \$form.attr("action"), //serialize Yii2 form 
        \$form.serialize()
    )
        .done(function(result){
            if(result == 1)
            {
                $(\$form).trigger("reset"); //reset form to reuse it to input
                $.pjax.reload({container:'#potongan-datatable-pjax'});
            }else
            {
                $("#message").html(result);
            }
        }).fail(function(){
            console.log("server error");
        });
    return false;
});

JS;
$this->registerJs($script);
?>
<?php 
Modal::begin([
    'id' => 'modalAset',
    'header' => '<h4 class="modal-title">Daftar Klasifikasi Aset Tetap...</h4>',
    'options' => [
        'tabindex' => false // important for Select2 to work properly
    ], 
    'size' => 'modal-lg',
]);
 
echo '...';
 
Modal::end();
$this->registerJs(<<<JS
    $('#modalAset').on('show.bs.modal', function (event) {
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

JS
);
?>