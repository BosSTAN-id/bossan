<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\anggaran\models\TaRkasKegiatan */
/* @var $dataProvider yii\data\ActiveDataProvider */
function angka($n) {
    // first strip any formatting;
    $n = (0+str_replace(",","",$n));
    
    // is this a number?
    if(!is_numeric($n)) return false;
    
    // now filter it;
    if($n>1000000000000) return round(($n/1000000000000),1).' T';
    else if($n>1000000000) return round(($n/1000000000),1).' M';
    else if($n>1000000) return round(($n/1000000),1).' juta';
    else if($n>1000) return round(($n/1000),1).' ribu';
    
    return number_format($n);
}

$this->title = 'Belanja';
$this->params['breadcrumbs'][] = 'Penatausahaan';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-rkas-kegiatan-index">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Bukti Pengeluaran Belanja <?= $Tahun ?></h3>
            <span class="label label-primary pull-right"><i class="fa fa-html5"></i></span>
        </div><!-- /.box-header -->
        <div class="box-body bg-info">

           <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="info-box">
                    <a href="">
                        <span class="info-box-icon bg-aqua"><i class="fa fa-external-link"></i></span>
                    </a> 
                    <div class="info-box-content">
                        <?= Html::a('<span class="info-box-text">BELANJA LANGSUNG</span>', ['bl'], []) ?>
                        Belanja langsung berkaitan dengan program dan kegiatan. Belanja langsung hanya dapat dikeluarkan sesuai dengan rencana pengeluaran.
                    </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->
            </div>

           <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="info-box">
                    <a href="">
                        <span class="info-box-icon bg-aqua"><i class="fa fa-credit-card"></i></span>
                    </a> 
                    <div class="info-box-content">
                        <?= Html::a('<span class="info-box-text">BELANJA TIDAK LANGSUNG</span>', ['btl'], []) ?>
                        Belanja tidak langsung berkaitan dengan program dan kegiatan. Belanja tidak langsung hanya dapat dikeluarkan sesuai dengan rencana pengeluaran.
                    </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->
            </div>
                                    
        </div><!-- /.box-body -->
    </div>

</div>