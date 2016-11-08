<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\kasharian\models\RefBankSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dashboard Aset Mutasi';
$this->params['breadcrumbs'][] = 'Control Asset';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-bank-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php 
        IF($koneksi == NULL){
        	echo Html::a('Tambah Koneksi', ['koneksi'], ['class' => 'btn btn-sm btn-success']) ;
        }ELSE{
        	echo $koneksi->adi.'-'.\app\models\RefKoneksiBMD::dokudoku('bulat', $koneksi->adi).'<br>';
        	echo $koneksi->erzo.'-'.\app\models\RefKoneksiBMD::dokudoku('bulat', $koneksi->erzo).'<br>';
        	echo $koneksi->isbandi.'-'.\app\models\RefKoneksiBMD::dokudoku('bulat', $koneksi->isbandi).'<br>';
        	echo $koneksi->bram.'-'.\app\models\RefKoneksiBMD::dokudoku('bulat', $koneksi->bram);
        }
         ?>
    </p>
<?php Pjax::begin(); ?>    
<?php 
IF($koneksi <> NULL){
    echo GridView::widget([
            'dataProvider' => $model,
            //'filterModel' => $searchModel,
            'export' => false, 
            'hover'=>false,   
            'bordered' => true,
            'striped' => false,
            'condensed' => false,
            'responsive' => true,  
            'panel'=>['type'=>'primary', 'heading'=>'MUTASI ASET'],
            'columns' => [
                //['class' => 'kartik\grid\SerialColumn'],
                [
                    'label' => 'SKPD',
                    'attribute' => 'Nm_Sub_Unit'
                ],
                [
                    'label' => '-',
                    'format' => 'raw',
                    'value'=> function($model){
                        return 'Mutasi (BMD)<br /><hr />Belanja Modal (Keu)';
                    }
                    
                ],                            
                [
                    'label' => 'KIB A',
                    'format' => 'raw',
                    'value'=> function($model){
                        IF($model['MUTASI_KIB_A'] == $model['BELANJA_MODAL_KIB_A'])
                        {
                            return number_format($model['MUTASI_KIB_A'], 0, ',' ,'.').'<br /><hr />'.number_format($model['BELANJA_MODAL_KIB_A'], 0, ',' ,'.');
                        }ELSE{
                            return Html::tag('span', number_format($model['MUTASI_KIB_A'], 0, ',' ,'.').'<br /><hr />'.number_format($model['BELANJA_MODAL_KIB_A'], 0, ',' ,'.'), ['style'=>'background-color:red']);
                        }
                    }
                    
                ],
                [
                    'label' => 'KIB B',
                    'format' => 'raw',
                    'options' => function($model){
                        IF($model['MUTASI_KIB_B'] <> $model['BELANJA_MODAL_KIB_B']){
                            return [ 'style' => 'background-color:red' ];
                        }ELSE{
                            return ['style' => ''];
                        }
                    },
                    'value'=> function($model){
                        IF($model['MUTASI_KIB_B'] == $model['BELANJA_MODAL_KIB_B'])
                        {
                            return number_format($model['MUTASI_KIB_B'], 0, ',' ,'.').'<br /><hr />'.number_format($model['BELANJA_MODAL_KIB_B'], 0, ',' ,'.');
                        }ELSE{
                            return Html::tag('span', number_format($model['MUTASI_KIB_B'], 0, ',' ,'.').'<br /><hr />'.number_format($model['BELANJA_MODAL_KIB_B'], 0, ',' ,'.'), ['style'=>'background-color:red']);
                        }
                    }
                    
                ],
                [
                    'label' => 'KIB C',
                    'format' => 'raw',
                    'value'=> function($model){
                        IF($model['MUTASI_KIB_C'] == $model['BELANJA_MODAL_KIB_C'])
                        {
                            return number_format($model['MUTASI_KIB_C'], 0, ',' ,'.').'<br /><hr />'.number_format($model['BELANJA_MODAL_KIB_C'], 0, ',' ,'.');
                        }ELSE{
                            return Html::tag('span', number_format($model['MUTASI_KIB_C'], 0, ',' ,'.').'<br /><hr />'.number_format($model['BELANJA_MODAL_KIB_C'], 0, ',' ,'.'), ['style'=>'background-color:red']);
                        }
                    }
                    
                ],
                [
                    'label' => 'KIB D',
                    'format' => 'raw',
                    'value'=> function($model){
                        IF($model['MUTASI_KIB_D'] == $model['BELANJA_MODAL_KIB_D'])
                        {
                            return number_format($model['MUTASI_KIB_D'], 0, ',' ,'.').'<br /><hr />'.number_format($model['BELANJA_MODAL_KIB_D'], 0, ',' ,'.');
                        }ELSE{
                            return Html::tag('span', number_format($model['MUTASI_KIB_D'], 0, ',' ,'.').'<br /><hr />'.number_format($model['BELANJA_MODAL_KIB_D'], 0, ',' ,'.'), ['style'=>'background-color:red']);
                        }
                    }
                    
                ],
                [
                    'label' => 'KIB E',
                    'format' => 'raw',
                    'value'=> function($model){
                        IF($model['MUTASI_KIB_E'] == $model['BELANJA_MODAL_KIB_E'])
                        {
                            return number_format($model['MUTASI_KIB_E'], 0, ',' ,'.').'<br /><hr />'.number_format($model['BELANJA_MODAL_KIB_E'], 0, ',' ,'.');
                        }ELSE{
                            return Html::tag('span', number_format($model['MUTASI_KIB_E'], 0, ',' ,'.').'<br /><hr />'.number_format($model['BELANJA_MODAL_KIB_E'], 0, ',' ,'.'), ['style'=>'background-color:red']);
                        }
                    }
                    
                ],                                               
            ],
        ]);    
} ?>
<?php Pjax::end(); ?></div>
