<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\TaSetoranPotongan */

$this->title = $model->no_setoran;
$this->params['breadcrumbs'][] = 'Penatausahaan';
$this->params['breadcrumbs'][] = ['label' => 'Setoran Potongan', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-setoran-potongan-view">
    <?= DetailView::widget([
        'model' => $model,
        'condensed'=>true,
        'hover'=>true,
        'mode'=>DetailView::MODE_VIEW,
        'enableEditMode' => true,
        'hideIfEmpty' => false, //sembunyikan row ketika kosong
        'panel'=>[
            'heading'=>'<i class="fa fa-tag"></i> Setoran Potongan</h3>',
            'type'=>'danger',
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
                'attribute' => 'no_setoran',
                'displayOnly' => true,
            ],
            [
                'attribute' => 'tgl_setoran',
                'format' => 'date',
                'displayOnly' => true,
            ],
            [
                'attribute' => 'keterangan',
                'displayOnly' => true,
            ],            
        ],
    ]);?>

    <?php
        echo $this->render('/potonganrinc/index', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    ?>

</div>
<?php
/*
$this->registerCss(<<<CSS
.panel-danger .panel-heading {
    color: white !important;
    background-color: red !important;
    border-color: red !important;
CSS
);
*/
?>