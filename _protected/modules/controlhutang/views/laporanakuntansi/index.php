<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\controlhutang\models\RekananSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pelaporan';
$this->params['breadcrumbs'][] = 'Penatausahaan';
$this->params['breadcrumbs'][] = 'Utang';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php echo $this->render('_search', ['model' => $get]); ?>

<?php IF($Kd_Laporan <> NULL) : ?>

                <?php 
	                switch ($Kd_Laporan) {
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
   
                <?php echo $this->render($render, ['data' => $data, 'heading' => $heading]); ?>

<?php endif; ?>
