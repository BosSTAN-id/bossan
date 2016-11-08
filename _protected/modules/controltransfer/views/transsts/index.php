<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\web\Controller;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\controltransfer\models\TaTransStsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Penerimaan Transfer';
$this->params['breadcrumbs'][] = 'Penatausahaan';
$this->params['breadcrumbs'][] = 'Dana Transfer';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class = "row">
<div class = "col-md-3">
    <?php echo $this->render('_form', ['model' => $input, 'Tahun' => $Tahun]); ?>
</div>
<div class = "col-md-9">
    <?php Pjax::begin(['id' => 'posisi-pjax']); ?>
    <div class = "row">
        <?php $i =1; foreach($posisikas AS $posisikas): ?>
        <?php IF(($i % 6) == 0) echo '<div class = "row">' ;?>
        <div class = "col-md-2">
            <div class="box">
                <div class="box-header">
                <h3 class="box-title"><?= $posisikas['Nm_Sub_Bidang'] ?></h3>
                </div>
                <div class="box-body no-padding">  
                    <div class= "text-center">      
                    <?php
                        $percentage = (($posisikas['Realisasi']*100)/$posisikas['Anggaran']); 
                        echo softcommerce\knob\Knob::widget([
                                //'id' => $posisikas['Nm_Sub_Bidang'],
                                'name' => $posisikas['Nm_Sub_Bidang'],
                                'value' => intval($percentage),
                                // 'icon' => '<span class="glyphicon glyphicon-flash"></span>',
                                'options' => [
                                    'data-min' => '0',
                                    'data-max' => '100',
                                    'data-width' => '100',
                                    'data-height' => '100',
                                ],
                                'knobOptions' => [
                                    'readOnly' => true,
                                    'thickness' => '.25',
                                    'dynamicDraw' => true,
                                    'fgColor' => $percentage <= 100 ?  '#9fc569' : '#CC0000',
                                ],
                            ]
                        ); 
                    ?>
                    </div>      
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>
                                <?= number_format($posisikas['Realisasi'], 0, ',', '.') ?>
                                </td>
                            </tr>                        
                            <tr>
                                <td>
                                <?= number_format($posisikas['Anggaran'], 0, ',', '.') ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                   
                </div>
            </div>              
        </div><!--md-2-->
        <?php IF(($i % 6) == 0) echo '</div>' ;?>
        <?php $i++; endforeach;?>        
    </div>
    <?php Pjax::end(); ?>
    <div class = "row">
    <div class="ta-trans-sts-index">

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'export' => false, 
            'responsive'=>true,
            'hover'=>true,     
            'resizableColumns'=>true,
            'panel'=>['type'=>'primary', 'heading'=>$this->title],
            'responsiveWrap' => false,        
            'toolbar' => [
                [
                    //'content' => $this->render('_search', ['model' => $searchModel]),
                ],
            ],       
            'pager' => [
                'firstPageLabel' => 'Awal',
                'lastPageLabel'  => 'Akhir'
            ],
            'pjax'=>true,
            'pjaxSettings'=>[
                'options' => ['id' => 'sts-pjax', 'timeout' => 5000],
            ],
            'columns' => [
                [
                    'label' => 'Kode',
                    'width' => '20px',
                    'value' => function($model){
                        return $model->Kd_Trans_1.'.'.$model->Kd_Trans_2.'.'.$model->Kd_Trans_3;
                    }
                ],
                [
                    'label' => 'Sub Bidang',
                    'width' => '400px',
                    'value' => function($model){
                        return $model->taTrans1->Jns_Transfer.' - '.$model->taTrans2->Nm_Bidang.' - '.$model->taTrans3->Nm_Sub_Bidang;
                    }
                ],
                [
                    'attribute' => 'No_STS',
                    'width' => '200px',
                ],
                [
                    'attribute' => 'Tgl_STS',
                    'format' => 'date',
                    'width' => '100px',
                ],
                [
                    'label' => 'Rekening',
                    'width' => '200px',
                    'value' => function($model){
                        return $model->Bank_Penerima.' - '.substr($model->Rek_Penerima, 0,5).'...';
                    }
                ],
                [
                    'attribute' => 'Nilai',
                    'format' => 'decimal',
                    'width' => '200px',
                ],

                // ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
    </div>
</div>
</div>
