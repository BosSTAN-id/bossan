<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\kasharian\models\TaKasHarianSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kas Harian';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
    $connection = \Yii::$app->db;           
    $skpd = $connection->createCommand('SELECT Kd_Bank, Nm_Bank +\' - \'+ No_Rekening AS No_Rekening FROM Ref_Bank');
    $query = $skpd->queryAll();
?>  
<div class="ta-kas-harian-index">

    <?php echo $this->render('_form', ['model' => $model]); ?>

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
        'panel'=>['type'=>'primary', 'heading'=>'Daftar Kas Harian'],         
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'Kd_Bank',
                'label' => 'Rekening',
                'filter' => Select2::widget([
                        'model' => $searchModel,
                        'attribute' => 'Kd_Bank',
                        'data' => ArrayHelper::map($query,'Kd_Bank','No_Rekening'),
                        'pluginOptions' => [
                            'allowClear' => true
                        ],                        
                        'options' => [
                            'placeholder' => 'Nm_Bank...',
                        ]
                    ]),
                'value' => function ($model) {
                    return $model->kdBank->Nm_Bank.' - '.$model->kdBank->No_Rekening;
                }
            ],
            'Tanggal:date',
            'Jumlah:currency',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
