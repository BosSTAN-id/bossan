<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use xj\bootbox\BootboxAsset;
use yii\bootstrap\Modal;
use yii\web\Controller;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\controlhutang\models\BelanjakontrolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Realisasi Kontrak';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box">
  <div class="box-header">
      <h3>Realisasi Pembayaran Kontrak</h3>
  </div>
  <div class="box-body">
    <table class="table table-bordered">
      <tbody><tr>
        <th style="width: 10px">#</th>
        <th>Dana Transfer</th>
        <th>SKPD Pelaksana</th>
        <th>No_Kontrak</th>
        <th>No_SP2D</th>
        <th>Anggaran</th>
        <th>Realisasi</th>
        <th style="width: 40px">%</th>
      </tr>
      <?php $i = 1; foreach ($dataProvider AS $data): ?>
      <tr>
        <td><?= $i ?></td>
        <td><?= $data['Nm_Sub_Bidang'] ?></td>
        <td><?= $data['Nm_Sub_Unit'] ?></td>
        <td><?= $data['No_Kontrak'] ?></td>
        <td><?= $data['No_SP2D'] ?></td>
        <td><?= number_format($data['Pagu'], 0, ',', '.') ?></td>
        <td><?= number_format($data['Nilai_SP2D'], 0, ',', '.') ?></td>
        <?php  
        $persen = 100*$data['Nilai_SP2D']/$data['Pagu']; 
        IF($persen < 50){
          $class = "badge bg-green";
        }ELSEIF($persen > 50 && $persen < 80){
          $class = "badge bg-yellow";
        }ELSE{
          $class = "badge bg-red";
        }
        $persen = (INT) ($persen); 
        ?>
        <td><span class=<?= $class ?> ><?php echo $persen." %" ?></span></td>
      </tr>
    <?php endforeach;?>
    </tbody>
    </table>
  </div>
</div>
