<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TaSubUnit */

$this->title = $model->Tahun;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ta Sub Units'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-sub-unit-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php IF(isset($model)){
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
                'Tahun',
                'Kd_Urusan',
                'Kd_Bidang',
                'Kd_Unit',
                'Kd_Sub',
                'Nm_Pimpinan',
                'Nip_Pimpinan',
                'Jbt_Pimpinan',
                'Alamat',
                'Ur_Visi',
            ],
        ]);
    }
    ?>


</div>
