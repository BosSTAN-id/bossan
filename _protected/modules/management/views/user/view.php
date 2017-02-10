<?php
use app\helpers\CssHelper;
use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <?php 
        echo DetailView::widget([
            'model' => $model,
            'condensed'=>true,
            'hover'=>true,
            'mode'=>DetailView::MODE_VIEW,
            'enableEditMode' => true,
            'hideIfEmpty' => false, //sembunyikan row ketika kosong
            'panel'=>[
                'heading'=>'<i class="fa fa-tag"></i> Rincian Program</h3>',
                'type'=>'warning',
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
                [
                    'attribute' => 'username',
                    'displayOnly' => true,
                ],
                [
                    'attribute' => 'email',
                    'displayOnly' => true,
                ],
                'password',
            ],
        ]);
    ?>

</div>
