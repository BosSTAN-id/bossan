<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\kasharian\models\RefBankSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Input Bank';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-bank-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Tambah Bank', ['create'], ['class' => 'btn btn-sm btn-success']) ?>
    </p>
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
        'panel'=>['type'=>'primary', 'heading'=>'Daftar Bank'],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            'Nm_Bank',
            'No_Rekening',

            ['class' => 'kartik\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
