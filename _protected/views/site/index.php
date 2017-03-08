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
                // }ELSE{
                //   return '
                //     <div class="panel panel-success">
                //         <div class="panel-heading">
                //             <h3 class="panel-title">'.Html::a($model->title, ['view', 'id' => $model->id], ['class' => '']).'</h3>
                //         </div>
                //         <div class="panel-body">
                //         '.substr($model->content, 0, 1000).Html::a('read more...', ['view', 'id' => $model->id], ['class' => 'btn btn-xs btn-default']).'
                //         </div>
                      
                //     </div>
                //   ';                  
                // }
              },
          ]);
        ?> 
    </div>
<?php /*
    <div class="body-content">
    <div class ="row">
    <div class ="col-md-6">
        <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Grafik Posisi Kas Harian 10 Hari Terakhir</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <?php
                // $connection = \Yii::$app->db;           
                // $skpd = $connection->createCommand('SELECT Tanggal, SUM(Jumlah) AS Saldo
                // FROM Ta_Kas_Harian 
                // GROUP BY Tanggal
                // ORDER BY Tanggal ASC
                // LIMIT 0, 10
                // ');
                // $query = $skpd->queryAll();
                // foreach($query AS $query){
                //     $labels[] = DATE('d-m', strtotime($query['Tanggal']));
                //     $data[] = $query['Saldo'];
                // }

                // echo ChartJs::widget([
                //     'type' => 'line',
                //     'options' => [
                //         'height' => 400,
                //         'width' => 400
                //     ],
                //     'data' => [
                //         'labels' => $labels,
                //         'datasets' => [
                //             [
                //                 'label' => 'Realisasi',
                //                 'fillColor' => "rgba(151,187,205,0.5)",
                //                 'strokeColor' => "rgba(151,187,205,1)",
                //                 'pointColor' => "rgba(151,187,205,1)",
                //                 'pointStrokeColor' => "#fff",
                //                 'data' => $data
                //             ]
                //         ]
                //     ]
                // ]);
                ?>
              </div>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
    <div class ="col-md-6">
        <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Grafik Pelunasan Utang (Dalam Jutaan Rupiah)</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <?php 
                // echo ChartJs::widget([
                //     'type' => 'bar',
                //     'options' => [
                //         'height' => 400,
                //         'width' => 400
                //     ],
                //     'data' => [
                //         'labels' => ["January", "February", "March", "April", "May", "June", "July"],
                //         'datasets' => [
                //             [
                //                 'label' => 'Anggaran',
                //                 'fillColor' => "rgba(220,220,220,0.5)",
                //                 'strokeColor' => "rgba(220,220,220,1)",
                //                 'pointColor' => "rgba(220,220,220,1)",
                //                 'pointStrokeColor' => "#fff",
                //                 'data' => [65, 59, 90, 81, 56, 55, 40]
                //             ],
                //             [
                //                 'label' => 'Realisasi',
                //                 'fillColor' => "rgba(151,187,205,0.5)",
                //                 'strokeColor' => "rgba(151,187,205,1)",
                //                 'pointColor' => "rgba(151,187,205,1)",
                //                 'pointStrokeColor' => "#fff",
                //                 'data' => [28, 48, 40, 19, 96, 27, 100]
                //             ]
                //         ]
                //     ]
                // ]);
                ?>
              </div>
            </div>
            <!-- /.box-body -->
        </div>
    </div>    
    <!-- /.box -->

    </div>
    </div>
*/ ?>
</div>

