<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\controlhutang\models\RekananSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pelaporan Sekolah';
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
	                        $heading = 'BOS-K1 Rencana Kegiatan dan Anggaran Sekolah (RKAS) Tahun Anggaran '.$Tahun;
	                        break;
	                    case 2:
	                        $heading = 'BOS-K2 Rencana Kegiatan dan Anggaran '.$Tahun;
	                        break;	                	
	                    case 3:
	                        $heading = 'BOS-K3 Buku Kas Umum '.$Tahun;
	                        break;
	                    case 4:
	                        $heading = 'BOS-K4 Buku Pembantu Kas Tunai '.$Tahun;
	                        break;
                        case 5:
                            $heading = 'BOS-K5 Buku Pembantu Kas Bank '.$Tahun;
                            break;
                        case 6:
                            $heading = 'BOS-K7 Realisasi Penggunaan Dana Tiap Jenis Anggaran '.$Tahun;
                            break;
                        case 7:
                            $heading = 'BOS-K7A Realisasi Penggunaan Dana Tiap Komponen BOS '.$Tahun;
                            break;
                        case 8:
                            $heading = 'RENCANA PENGGUNAAN DANA BOS PERIODE '.$Tahun;
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
