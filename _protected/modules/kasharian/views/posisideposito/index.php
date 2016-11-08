<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\kasharian\models\TaDepositoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posisi Deposito';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-deposito-index">
    <div class="row">
        <div class="col-lg-12">
        <?php Pjax::begin(); ?>    <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'export' => false, 
                'responsive'=>true,
                'hover'=>true,   
                'bordered' => true,
                'striped' => false,
                'condensed' => false,
                'responsive' => true,
                //'page_summary' => true,
                'panel'=>['type'=>'primary', 'heading'=>'Daftar Deposito'],         
                'columns' => [
                    'Nm_Bank',
                    'No_Dokumen',
                    'Tgl_Penempatan',
                    'Tgl_Jatuh_Tempo',
                    'Suku_Bunga:decimal',
                    'Nilai:currency',
                    'Keterangan',
                    [
                        'label' => 'Nominal Bunga Saat Ini',
                        'value' => function ($model){
                            return number_format( ($model->Nilai * ($model->Suku_Bunga*0.01/12) * (DATE('m') - DATE('m', strtotime($model->Tgl_Penempatan)) )), 2,',','.');
                        }
                    ]
                ],
            ]); ?>
        <?php Pjax::end(); ?>
        </div>
    </div>
</div>
