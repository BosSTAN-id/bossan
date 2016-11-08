<?php
use yii\helpers\Html;
use dosamigos\chartjs\ChartJs;
/* @var $this yii\web\View */

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

function cekperubahan($Tahun, $Kd_Trans_1, $Kd_Trans_2, $Kd_Trans_3) {
    // Fungsi memeriksa adakah perubahan pada pagutransfer;
  $cek = \app\models\TaTransSkpdPerubahan::find()->where(['Tahun' => $Tahun, 'Kd_Trans_1' => $Kd_Trans_1, 'Kd_Trans_2' => $Kd_Trans_2, 'Kd_Trans_3' => $Kd_Trans_3])->select('MAX(No_Perubahan) AS No_Perubahan')->one();

  IF($cek->No_Perubahan > 1){
    $tanggal = \app\models\TaTransSkpdPerubahan::find()->where(['Tahun' => $Tahun, 'Kd_Trans_1' => $Kd_Trans_1, 'Kd_Trans_2' => $Kd_Trans_2, 'Kd_Trans_3' => $Kd_Trans_3, 'No_Perubahan' => $cek->No_Perubahan])->one();
    return '<span class="label label-default">Pagu diubah pada '.DATE('d-m-y', $tanggal->updated_at).'</span>';
  }ELSE{
    return 'Posisi kas saat ini';
  }

}

$this->title = Yii::t('app', Yii::$app->name);
?>
<div class="site-index">

    <div class="well">
        <h3>Selamat Datang di <?= $this->title ?>!</h3>

        <p class="lead">Tulis Disini ya...</p>

    </div> 
    <div class="body-content">

    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <?php echo Html::a('<span class="info-box-icon bg-aqua"><i class="fa fa-tasks"></i></span></a>', ['controlhutang/rph'])?>

            <div class="info-box-content">
              <span class="info-box-text">Management Utang</span>
              <span class="info-box-number">90<small>%</small> Terlunasi</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <?php echo Html::a('<span class="info-box-icon bg-red"><i class="fa fa-university"></i></span>', ['controltransfer/belanja'])?>

            <div class="info-box-content">
              <span class="info-box-text">Management Transfer</span>
              <span class="info-box-number">90<small>%</small> Realisasi</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <?php echo Html::a('<span class="info-box-icon bg-green"><i class="fa fa-bitcoin"></i></span>', ['controltransfer/transferkontrak'])?>
            <?php $total = 0 ;foreach($saldotrf AS $sld) $total = $sld['Saldo'] + $total; ?>
            <div class="info-box-content">
              <span class="info-box-text">Saldo Transfer (SKPD ini)</span>
              <span class="info-box-number"><?= angka($total) ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <?php echo Html::a('<span class="info-box-icon bg-yellow"><i class="glyphicon glyphicon-user"></i></span>', ['management/unit'])?>

            <div class="info-box-content">
              <span class="info-box-text"><?= $unitorg <> NULL ? "Data Organisasi" : "Data Org Kosong" ?></span>
              <span class="info-box-number"><?= $unitorg <> NULL ? $jabatan." Jabatan" : "Data harus terisi" ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </div><!-- row --> 

    <div class ="row">
        <div class ="col-md-8">
            <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Grafik Sebaran Saldo Utang (Dalam Jutaan Rupiah)</h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <div class="box-body">
                  <div class="chart">
                    <?php
                        foreach($chartsph AS $chartsph){
                            $labels[] = $chartsph['Tahun'];
                            $data[] = $chartsph['Saldo']/1000000;
                        }
                    ?>
                    <?= ChartJs::widget([
                        'type' => 'bar',
                        /*'options' => [
                            'height' => 400,
                            'width' => 400
                        ],*/
                        'data' => [
                            'labels' => isset($labels) ? $labels : 'kosong',
                            'datasets' => [
                                [
                                    'label' => 'Saldo',
                                    'backgroundColor' => "#3B56BF",
                                    'data' => isset($data) ? $data : NULL 
                                ],
                                // [
                                //     'label' => 'Realisasi',
                                //     'fillColor' => "rgba(151,187,205,0.5)",
                                //     'strokeColor' => "rgba(151,187,205,1)",
                                //     'pointColor' => "rgba(151,187,205,1)",
                                //     'pointStrokeColor' => "#fff",
                                //     'data' => [28, 48, 40, 19, 96, 27, 100]
                                // ]
                            ]
                        ]
                    ]);
                    ?>
                  </div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>    
        <!-- /.box -->
        <div class="col-md-4">
          <?php foreach($saldotrf AS $saldotrf): ?>
          <?php 
          IF($saldotrf['Saldo'] > 0){
            $color = 'bg-green';
            $icon = 'fa fa-check-circle';
          }ELSE{
            $color = 'bg-red';
            $icon = 'fa fa-times-circle';
          } ?>
          <!-- Info Boxes Style 2 -->
          <div class="info-box <?= $color ?>">
            <span class="info-box-icon"><i class="<?= $icon ?>"></i></span>

            <div class="info-box-content">
              <span class="info-box-text"><?= $saldotrf['Nm_Sub_Bidang'] ?></span>
              <span class="info-box-number"><?= angka($saldotrf['Saldo']) ?></span>

              <div class="progress">
                <div style="width: 50%" class="progress-bar"></div>
              </div>
                  <span class="progress-description">
                    <?= cekperubahan($saldotrf['Tahun'], $saldotrf['Kd_Trans_1'], $saldotrf['Kd_Trans_2'], $saldotrf['Kd_Trans_3']) ?>
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
          <?php endforeach;?>
        </div>
    </div><!--row-->
    </div>
</div>

