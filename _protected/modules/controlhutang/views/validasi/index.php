<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\controlhutang\models\TaSPMSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Validasi SPM Hutang';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-spm-index">
<div class = "row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Validasi SPM</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">    
                <?php echo $this->render('_search', ['model' => $searchModel]); ?>

                <p>
                    <?php // echo Html::a('Create Ta Spm', ['create'], ['class' => 'btn btn-success']) ?>
                </p>

            <?php Pjax::begin(); ?>
            <?php IF(Yii::$app->request->queryParams): ?>
                <div class="col-md-9">
                    <h3>Informasi SPM</h3>
                    <?php 
                    echo  DetailView::widget([
                        'model' => $spm,
                        'attributes' => [
                            'Tahun',
                            'refSubUnit.Nm_Sub_Unit',                        
                            'No_SPM',
                            //'No_SPP',
                            //'Jn_SPM',
                            'Tgl_SPM',
                            'Uraian',
                            [
                                'label' => 'Nilai SPM',
                                'value' => number_format($sumspm, 0, ',', '.')
                            ],
                            //'Nm_Penerima',
                            //'Bank_Penerima',
                            //'Rek_Penerima',
                            //'NPWP',
                            //'Bank_Pembayar',
                            //'Nm_Verifikator',
                            //'Nm_Penandatangan',
                            //'Nip_Penandatangan',
                            //'Jbt_Penandatangan',
                            //'Kd_Edit',
                        ],
                    ]) ?>
                </div>
                <div class="col-md-3">
                    <?php IF($validasi):?>
                        <h3>Info Validasi </h3>
                        <?php 
                        echo  DetailView::widget([
                            'model' => $validasi,
                            'attributes' => [
                                'No_Validasi',
                                'No_RPH',
                                'Tgl_Validasi',
                                'Nm_Penandatangan'
                            ],
                        ]) ?>                    
                    <?php ELSE: ?>

                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'No_Validasi')->input('No_Validasi', ['class' => 'form-control input-sm','placeholder' => "No Validasi..."])->label(false) ?>   

                    <?= $form->field($model, 'Tgl_Validasi')->widget(
                        DatePicker::className(), [
                            // inline too, not bad
                             'inline' => false, 
                             // modify template for custom rendering
                            //'template' => '<div class="well well-sm" style="background-color: #fff; width:250px">{input}</div>',
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-m-d'
                            ]
                    ])->label(false);?>  

                    <?php
                    $rph = \app\models\TaRPH::find()
                            ->where([
                                     'tahun'    => DATE('Y'),
                                     'Kd_Urusan'=> $spm->Kd_Urusan,
                                     'Kd_Bidang'=> $spm->Kd_Bidang,
                                     'Kd_Unit'=> $spm->Kd_Unit,
                                     'Kd_Sub'=> $spm->Kd_Sub,
                                     ])
                            ->all();
                    echo $form->field($model, 'No_RPH')->widget(Select2::classname(), [
                                'data' => ArrayHelper::map($rph,'No_RPH','No_RPH'),
                                'options' => ['placeholder' => 'Pilih RPH ...'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ])->label(false); ?>                      


                    <?= $form->field($model, 'Nm_Penandatangan')->input('Nm_Penandatangan', ['class' => 'form-control input-sm','placeholder' => "Penandatangan..."])->label(false) ?>

                    <?= $form->field($model, 'Jabatan_Penandatangan')->input('Jabatan_Penandatangan', ['class' => 'form-control input-sm','placeholder' => "Jabatan..."])->label(false) ?>

                    <?= $form->field($model, 'NIP_Penandatangan')->input('NIP_Penandatangan', ['class' => 'form-control input-sm','placeholder' => "NIP..."])->label(false) ?>

                    <div class="form-group">
                        <?= Html::submitButton($model->isNewRecord ? 'Validasi' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-xs btn-success' : 'btn btn-xs btn-primary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                    <?php endif;?>             
                </div>
            <?php endif;?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
</div>
