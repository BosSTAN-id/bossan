<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\kasharian\models\TaDepositoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Input Deposito';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-deposito-index">
    <div class="row">
        <div class="col-lg-4">
            <?php echo $this->render('_form', ['model' => $model]); ?>
        </div>
        <div class="col-lg-8">
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
                'panel'=>['type'=>'primary', 'heading'=>'Daftar Deposito'],         
                'columns' => [
                    'Nm_Bank',
                    'No_Dokumen',
                    'Tgl_Penempatan',
                    'Tgl_Jatuh_Tempo',
                    'Suku_Bunga:decimal',
                    'Nilai:currency',
                    'Keterangan',
                    ['class' => 'kartik\grid\ActionColumn'],
                ],
            ]); ?>
        <?php Pjax::end(); ?>
        </div>
    </div>
</div>
