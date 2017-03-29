<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\controlhutang\models\RekananSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pelaporan Pemda';
$this->params['breadcrumbs'][] = 'Pelaporan';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
<?php echo $this->render('_search', ['model' => $get, 'Tahun' => $Tahun]); ?>
</div>
<?php IF($Kd_Laporan <> NULL) : ?>

                <?php 
	                switch ($Kd_Laporan) {
	                    case 1:
	                        $heading = 'Rekapitulasi Penetapan RKAS-APBS Tahun Anggaran '.$Tahun;
	                        break;
	                    case 2:
	                        $heading = 'Rekapitulasi RKAS-APBS Tahun Anggaran '.$Tahun;
	                        break;	                	
	                    case 3:
	                        $heading = 'Rekapitulasi Pembuatan SPJ '.$Tahun;
	                        break;
	                    case 4:
	                        $heading = 'Rekapitulasi Realisasi Pendapatan dan Belanja '.$Tahun;
	                        break;
                        case 5:
                            $heading = 'Rekapitulasi SP3B dan SP2B '.$Tahun;
                            break;
                        case 6:
                            $heading = 'Rekapitulasi Sisa dana BOS '.$Tahun;
                            break;
                        case 7:
                            $heading = 'BOS-K7A Realisasi Penggunaan Dana Tiap Komponen BOS '.$Tahun;
                            break;
	                    default:
	                        # code...
	                        break;
	                }
                ?>
   
                <?php echo $this->render($render, [
                	'data' => $data, 
		            'data1' => $data1,
		            'data2' => $data2,
		            'data3' => $data3,
		            'data4' => $data4,
		            'data5' => $data5,
		            'data6' => $data6,
                	'heading' => $heading, 
                	'getparam' => $getparam]); ?>

<?php endif; ?>
