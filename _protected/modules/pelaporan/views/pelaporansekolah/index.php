<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\controlhutang\models\RekananSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pelaporan';
$this->params['breadcrumbs'][] = 'Akuntansi';
$this->params['breadcrumbs'][] = 'Utang';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
<?php echo $this->render('_search', ['model' => $get]); ?>
</div>
<?php IF($Kd_Laporan <> NULL) : ?>

                <?php 
	                switch ($Kd_Laporan) {
	                    case 1:
	                        $heading = 'Rencana Kegiatan dan Anggaran Sekolah (RKAS) Tahun Anggaran '.$Tahun;
	                        break;
	                    case 2:
	                        $heading = 'Rekapitulasi Kontrol Anggaran Utang';
	                        break;	                	
	                    case 3:
	                        $heading = 'Rekapitulasi RPH';
	                        break;
	                    case 4:
	                        $heading = 'Rekapitulasi Saldo Utang Berjalan';
	                        break;
                        case 5:
                            $heading = 'Rekapitulasi Realisasi Utang';
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
