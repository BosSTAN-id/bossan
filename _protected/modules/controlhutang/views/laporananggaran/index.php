<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\controlhutang\models\RekananSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pelaporan';
$this->params['breadcrumbs'][] = 'Anggaran';
$this->params['breadcrumbs'][] = 'Utang';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php echo $this->render('_search', ['model' => $get]); ?>

<?php IF($Kd_Laporan <> NULL) : ?>
<div class = "row">
    <div class="col-xs-12">
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">
                <?php 
	                switch ($Kd_Laporan) {
	                    case 1:
	                        echo 'Rekapitulasi Data Saldo SPH dan Sebaran Utang';
	                        break;
	                    case 2:
	                        echo 'Rekapitulasi Kontrol Anggaran Utang';
	                        break;
	                    default:
	                        # code...
	                        break;
	                }
                ?>
                </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">    
                <?php echo $this->render($render, ['data' => $data]); ?>
        </div>
    </div>
</div>
<?php endif; ?>
