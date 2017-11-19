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
    <div class="row">
        <div class="col-md-8">
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
                'pjaxSettings'=>[
                    'options' => ['id' => 'aset-datatable-pjax', 'timeout' => 5000],
                ],
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
        <div class="col-md-4">
            <div id="calculator">
                <!-- Screen and clear key -->
                <div class="top">
                    <span class="clear">C</span>
                    <div class="screen"></div>
                </div>
                
                <div class="keys">
                    <!-- operators and other keys -->
                    <span>7</span>
                    <span>8</span>
                    <span>9</span>
                    <span class="operator">+</span>
                    <span>4</span>
                    <span>5</span>
                    <span>6</span>
                    <span class="operator">-</span>
                    <span>1</span>
                    <span>2</span>
                    <span>3</span>
                    <span class="operator">÷</span>
                    <span>0</span>
                    <span>.</span>
                    <span class="eval">=</span>
                    <span class="operator">x</span>
                </div>
            </div>                
        </div>
    </div>
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
$('form#TaAsetTetap').on('beforeSubmit',function(e)
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
                $.pjax.reload({container:'#aset-datatable-pjax'});
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
$this->registerJs(<<<JS
    // Get all the keys from document
    var keys = document.querySelectorAll('#calculator span');
    var operators = ['+', '-', 'x', '÷'];
    var decimalAdded = false;

    // Add onclick event to all the keys and perform operations
    for(var i = 0; i < keys.length; i++) {
        keys[i].onclick = function(e) {
            // Get the input and button values
            var input = document.querySelector('.screen');
            var inputVal = input.innerHTML;
            var btnVal = this.innerHTML;
            
            // Now, just append the key values (btnValue) to the input string and finally use javascript's eval function to get the result
            // If clear key is pressed, erase everything
            if(btnVal == 'C') {
                input.innerHTML = '';
                decimalAdded = false;
            }
            
            // If eval key is pressed, calculate and display the result
            else if(btnVal == '=') {
                var equation = inputVal;
                var lastChar = equation[equation.length - 1];
                
                // Replace all instances of x and ÷ with * and / respectively. This can be done easily using regex and the 'g' tag which will replace all instances of the matched character/substring
                equation = equation.replace(/x/g, '*').replace(/÷/g, '/');
                
                // Final thing left to do is checking the last character of the equation. If it's an operator or a decimal, remove it
                if(operators.indexOf(lastChar) > -1 || lastChar == '.')
                    equation = equation.replace(/.$/, '');
                
                if(equation)
                    input.innerHTML = eval(equation);
                    
                decimalAdded = false;
            }
            
            // Basic functionality of the calculator is complete. But there are some problems like 
            // 1. No two operators should be added consecutively.
            // 2. The equation shouldn't start from an operator except minus
            // 3. not more than 1 decimal should be there in a number
            
            // We'll fix these issues using some simple checks
            
            // indexOf works only in IE9+
            else if(operators.indexOf(btnVal) > -1) {
                // Operator is clicked
                // Get the last character from the equation
                var lastChar = inputVal[inputVal.length - 1];
                
                // Only add operator if input is not empty and there is no operator at the last
                if(inputVal != '' && operators.indexOf(lastChar) == -1) 
                    input.innerHTML += btnVal;
                
                // Allow minus if the string is empty
                else if(inputVal == '' && btnVal == '-') 
                    input.innerHTML += btnVal;
                
                // Replace the last operator (if exists) with the newly pressed operator
                if(operators.indexOf(lastChar) > -1 && inputVal.length > 1) {
                    // Here, '.' matches any character while $ denotes the end of string, so anything (will be an operator in this case) at the end of string will get replaced by new operator
                    input.innerHTML = inputVal.replace(/.$/, btnVal);
                }
                
                decimalAdded =false;
            }
            
            // Now only the decimal problem is left. We can solve it easily using a flag 'decimalAdded' which we'll set once the decimal is added and prevent more decimals to be added once it's set. It will be reset when an operator, eval or clear key is pressed.
            else if(btnVal == '.') {
                if(!decimalAdded) {
                    input.innerHTML += btnVal;
                    decimalAdded = true;
                }
            }
            
            // if any other key is pressed, just append it
            else {
                input.innerHTML += btnVal;
            }
            
            // prevent page jumps
            e.preventDefault();
        } 
    }
JS
);
$this->registerCss(<<<CSS
    /* Basic reset */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        
        /* Better text styling */
        font: bold 14px Arial, sans-serif;
    }

    /* Finally adding some IE9 fallbacks for gradients to finish things up */

    /* A nice BG gradient */
    html {
        height: 100%;
        background: white;
        background: radial-gradient(circle, #fff 20%, #ccc);
        background-size: cover;
    }

    /* Using box shadows to create 3D effects */
    #calculator {
        width: 325px;
        height: auto;
        
        margin: 100px auto;
        padding: 20px 20px 9px;
        
        background: #9dd2ea;
        background: linear-gradient(#9dd2ea, #8bceec);
        border-radius: 3px;
        box-shadow: 0px 4px #009de4, 0px 10px 15px rgba(0, 0, 0, 0.2);
    }

    /* Top portion */
    .top span.clear {
        float: left;
    }

    /* Inset shadow on the screen to create indent */
    .top .screen {
        height: 40px;
        width: 212px;
        
        float: right;
        
        padding: 0 10px;
        
        background: rgba(0, 0, 0, 0.2);
        border-radius: 3px;
        box-shadow: inset 0px 4px rgba(0, 0, 0, 0.2);
        
        /* Typography */
        font-size: 17px;
        line-height: 40px;
        color: white;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        text-align: right;
        letter-spacing: 1px;
    }

    /* Clear floats */
    .keys, .top {overflow: hidden;}

    /* Applying same to the keys */
    .keys span, .top span.clear {
        float: left;
        position: relative;
        top: 0;
        
        cursor: pointer;
        
        width: 66px;
        height: 36px;
        
        background: white;
        border-radius: 3px;
        box-shadow: 0px 4px rgba(0, 0, 0, 0.2);
        
        margin: 0 7px 11px 0;
        
        color: #888;
        line-height: 36px;
        text-align: center;
        
        /* prevent selection of text inside keys */
        user-select: none;
        
        /* Smoothing out hover and active states using css3 transitions */
        transition: all 0.2s ease;
    }

    /* Remove right margins from operator keys */
    /* style different type of keys (operators/evaluate/clear) differently */
    .keys span.operator {
        background: #FFF0F5;
        margin-right: 0;
    }

    .keys span.eval {
        background: #f1ff92;
        box-shadow: 0px 4px #9da853;
        color: #888e5f;
    }

    .top span.clear {
        background: #ff9fa8;
        box-shadow: 0px 4px #ff7c87;
        color: white;
    }

    /* Some hover effects */
    .keys span:hover {
        background: #9c89f6;
        box-shadow: 0px 4px #6b54d3;
        color: white;
    }

    .keys span.eval:hover {
        background: #abb850;
        box-shadow: 0px 4px #717a33;
        color: #ffffff;
    }

    .top span.clear:hover {
        background: #f68991;
        box-shadow: 0px 4px #d3545d;
        color: white;
    }

    /* Simulating "pressed" effect on active state of the keys by removing the box-shadow and moving the keys down a bit */
    .keys span:active {
        box-shadow: 0px 0px #6b54d3;
        top: 4px;
    }

    .keys span.eval:active {
        box-shadow: 0px 0px #717a33;
        top: 4px;
    }

    .top span.clear:active {
        top: 4px;
        box-shadow: 0px 0px #d3545d;
    }

CSS
);
?>