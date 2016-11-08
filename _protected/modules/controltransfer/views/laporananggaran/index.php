<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\controlhutang\models\RekananSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pelaporan';
$this->params['breadcrumbs'][] = 'Anggaran';
$this->params['breadcrumbs'][] = 'Transfer';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php echo $this->render('_search', ['model' => $get]); ?>

<?php IF($Kd_Laporan <> NULL) : ?>

                <?php 
	                switch ($Kd_Laporan) {
	                    case 1:
	                        $heading = 'Rekapitulasi Pagu Dana Transfer';
	                        break;
	                    case 2:
	                        $heading = 'Rekapitulasi Control Anggaran Transfer';
	                        break;
                        case 3:
                            $heading = 'Posisi Saldo Dana Transfer';
                            break;
	                    case 4:
	                        $heading = 'Rekapitulasi daftar Kontrak Dana Transfer';
	                        break;
                        case 5:
                            $heading = 'Rekapitulasi Realisasi Pembayaran Kontrak Dana Transfer';
                            break;
	                    default:
	                        # code...
	                        break;
	                }
                ?>
   
                <?php echo $this->render($render, ['data' => $data, 'heading' => $heading]); ?>

<?php endif; ?>
