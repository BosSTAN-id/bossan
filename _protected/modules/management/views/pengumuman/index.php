<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\management\models\TaPengumumanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pengumuman';
$this->params['breadcrumbs'][] = 'Management';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-pengumuman-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Tambah Pengumuman', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
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
                // 'content' => $this->render('_search', ['model' => $searchModel]),
            ],
        ],       
        'pager' => [
            'firstPageLabel' => 'Awal',
            'lastPageLabel'  => 'Akhir'
        ],
        'pjax'=>true,
        'pjaxSettings'=>[
            'options' => ['id' => 'sphawal-pjax', 'timeout' => 5000],
        ],  
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            'diumumkan_di',
            'sticky',
            'published',
            // 'user_id',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
