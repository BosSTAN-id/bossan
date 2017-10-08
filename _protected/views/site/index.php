<?php
use dosamigos\chartjs\ChartJs;
use yii\widgets\ListView;
use yii\helpers\Html;
/* @var $this yii\web\View */

function angka($n) {
    // first strip any formatting;
    $n = (0+str_replace(",","",$n));
    
    // is this a number?
    if(!is_numeric($n)) return false;
    
    // now filter it;
    if($n>1000000000000) return round(($n/1000000000000),1);
    else if($n>1000000000) return round(($n/1000000000),1);
    else if($n>1000000) return round(($n/1000000),1);
    else if($n>1000) return round(($n/1000),1);
    
    return number_format($n);
}

$this->title = Yii::t('app', Yii::$app->name);
?>
<div class="site-index">
    <?php if($infoBos): ?>
    <section>
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-xs-6">
            <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3><?= $infoBos->jumlah_siswa ?></h3>

                        <p>Jumlah Siswa</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user"></i>
                    </div>
                    <?= Html::a('More info <i class="fa fa-arrow-circle-right"></i>', ['/parameter/datasekolah'], [
                        'class' => 'small-box-footer'
                    ]) ?> 
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
            <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3><?= $infoBos->jumlah_guru ?></h3>

                        <p>Jumlah Guru</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-graduation-cap"></i>
                    </div>
                    <?= Html::a('More info <i class="fa fa-arrow-circle-right"></i>', ['/parameter/datasekolah'], [
                        'class' => 'small-box-footer'
                    ]) ?> 
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
            <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>
                            <?= number_format((\app\models\TaRkasBelanjaRinc::find()->where([
                                'tahun' => $infoBos->tahun_ajaran, 
                                'sekolah_id' => $infoBos->sekolah_id,
                                'Kd_Rek_1' => 5
                            ])->sum('total')/1000000), 1, ',', '.').' Jt' ?>
                        </h3>

                        <p>Total Anggaran</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-pie-chart"></i>
                    </div>
                    <?= Html::a('More info <i class="fa fa-arrow-circle-right"></i>', ['/anggaran/rkas'], [
                        'class' => 'small-box-footer'
                    ]) ?> 
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
            <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>
                            <?= number_format((\app\models\TaSpjRinc::find()->where([
                                'tahun' => $infoBos->tahun_ajaran, 
                                'sekolah_id' => $infoBos->sekolah_id,
                                'Kd_Rek_1' => 5
                            ])->sum('nilai')/1000000), 1, ',', '.').' Jt' ?>
                        </h3>

                        <p>Total Realisasi</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                    <?= Html::a('More info <i class="fa fa-arrow-circle-right"></i>', ['/penatausahaan/bukti'], [
                        'class' => 'small-box-footer'
                    ]) ?> 
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->
        <?= ChartJs::widget([
            'type' => 'bar',
            'options' => [
                'height' => 60,
                'width' => 400
            ],
            'data' => [
                'labels' => ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember" ],
                'datasets' => [
                    [
                        'label' => "Sebaran Realisasi Pendapatan",
                        'backgroundColor' => "rgba(179,181,198,0.2)",
                        'borderColor' => "rgba(179,181,198,1)",
                        'pointBackgroundColor' => "rgba(179,181,198,1)",
                        'pointBorderColor' => "#fff",
                        'pointHoverBackgroundColor' => "#fff",
                        'pointHoverBorderColor' => "rgba(179,181,198,1)",
                        'data' => $realisasiPendapatanGraph
                    ],                    
                    [
                        'label' => "Sebaran Realisasi Belanja",
                        'backgroundColor' => "rgba(255,99,132,0.2)",
                        'borderColor' => "rgba(255,99,132,1)",
                        'pointBackgroundColor' => "rgba(255,99,132,1)",
                        'pointBorderColor' => "#fff",
                        'pointHoverBackgroundColor' => "#fff",
                        'pointHoverBorderColor' => "rgba(255,99,132,1)",
                        'data' => $realisasiBelanjaGraph
                    ]
                ]
            ]
        ]);
        ?>    
    </section>
    <?php endif; ?>
    <div class="well">
        <?php
          echo ListView::widget([
              'dataProvider' => $dataProvider,
              'itemView' => function ($model, $key, $index, $widget) {
                // IF(strlen($model->content) <= 1000){
                    return '
                      <div class="panel panel-success">
                          <div class="panel-heading">
                              <h3 class="panel-title">'.Html::a($model->title, ['view', 'id' => $model->id], ['class' => '']).'</h3>
                          </div>
                          <div class="panel-body">
                          '.$model->content.'
                          </div>
                        
                      </div>
                    ';
              },
          ]);
        ?> 
    </div>
</div>

