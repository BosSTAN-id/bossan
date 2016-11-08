<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

function cekbatch($Tahun, $tabel, $kd_perubahan){
    IF($tabel == 12){
        $batch = \app\models\TaBatchProcess::find()->where(['Tahun' => $Tahun, 'tabel_id' => $tabel, 'kd_perubahan' =>$kd_perubahan])
        // ->andWhere(['id' => "(SELECT MAX(id) FROM ta_batch_process WHERE Tahun = $Tahun AND tabel_id = $tabel AND kd_perubahan = $kd_perubahan)"])
        ->orderBy('id DESC')
        ->one();
    }ELSE{
        $batch = \app\models\TaBatchProcess::find()->where(['Tahun' => $Tahun, 'tabel_id' => $tabel])
        // ->andWhere(['id' => "(SELECT MAX(id) FROM ta_batch_process WHERE Tahun = $Tahun AND tabel_id = $tabel)"])
        ->orderBy('id DESC')
        ->one();
    }
    IF($batch <> NULL){
        return $batch->sukses_pada;
    }ELSE{
        return false;
    }
}
?>
<div class="ta-th-view">
    <div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Data Global</h3>
    </div>
        <div class="box-body">
            <table class="table table-hover">
                <tbody>
                    <tr>
                        <th>Data</th>
                        <th>Mutakhir</th>
                        <th>Aksi</th>
                    </tr>
                    <tr>
                        <td>Referensi Jabatan</td>
                        <td><?= cekbatch($model->tahun, 1, 0) ?></td>
                        <td><?= Html::a('<i class="glyphicon glyphicon-refresh bg-white"></i>', ['load', 'id' => $model->id, 'ref' => 1, 'riwayat' => 0], ['class' => 'btn btn-xs btn-info','onClick' => "return !window.open(this.href, 'SPH', 'width=400,height=200')"]) ?></td>
                    </tr>                                        
                    <tr>
                        <td>Unit Organisasi</td>
                        <td><?= cekbatch($model->tahun, 2, 0) ?></td>
                        <td><?= Html::a('<i class="glyphicon glyphicon-refresh bg-white"></i>', ['load', 'id' => $model->id, 'ref' => 2, 'riwayat' => 0], ['class' => 'btn btn-xs btn-info','onClick' => "return !window.open(this.href, 'SPH', 'width=400,height=200')"]) ?></td>
                    </tr>
                    <tr>
                        <td>Referensi Program</td>
                        <td><?= cekbatch($model->tahun, 3, 0) ?></td>
                        <td><?= Html::a('<i class="glyphicon glyphicon-refresh bg-white"></i>', ['load', 'id' => $model->id, 'ref' => 3, 'riwayat' => 0], ['class' => 'btn btn-xs btn-info','onClick' => "return !window.open(this.href, 'SPH', 'width=400,height=200')"]) ?></td>
                    </tr> 
                    <tr>
                        <td>Referensi Kegiatan</td>
                        <td><?= cekbatch($model->tahun, 4, 0) ?></td>
                        <td><?= Html::a('<i class="glyphicon glyphicon-refresh bg-white"></i>', ['load', 'id' => $model->id, 'ref' => 4, 'riwayat' => 0], ['class' => 'btn btn-xs btn-info','onClick' => "return !window.open(this.href, 'SPH', 'width=400,height=200')"]) ?></td>
                    </tr>
                    <tr>
                        <td>Data Unit dan Jabatan</td>
                        <td><?= cekbatch($model->tahun, 16, 0) ?></td>
                        <td><?= Html::a('<i class="glyphicon glyphicon-refresh bg-white"></i>', ['load', 'id' => $model->id, 'ref' => 16, 'riwayat' => 0], ['class' => 'btn btn-xs btn-info','onClick' => "return !window.open(this.href, 'SPH', 'width=400,height=200')"]) ?></td>
                    </tr>                                                                                                    
                </tbody>
            </table>
            <hr>
        </div>
    </div>


    <div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Data BAS dan Belanja</h3>
    </div>
        <div class="box-body">
            <table class="table table-hover">
                <tbody>
                    <tr>
                        <th>Data</th>
                        <th>Mutakhir</th>
                        <th>Aksi</th>
                    </tr>
                    <tr>
                        <td>Rekening 1-3</td>
                        <td><?= cekbatch($model->tahun, 5, 0) ?></td>
                        <td><?= Html::a('<i class="glyphicon glyphicon-refresh bg-white"></i>', ['load', 'id' => $model->id, 'ref' => 5, 'riwayat' => 0], ['class' => 'btn btn-xs btn-info','onClick' => "return !window.open(this.href, 'SPH', 'width=400,height=200')"]) ?></td>
                    </tr>                                        
                    <tr>
                        <td>Rekening 4-5</td>
                        <td><?= cekbatch($model->tahun, 5, 0) ?></td>
                        <td><?= Html::a('<i class="glyphicon glyphicon-refresh bg-white"></i>', ['load', 'id' => $model->id, 'ref' => 5.5, 'riwayat' => 0], ['class' => 'btn btn-xs btn-info','onClick' => "return !window.open(this.href, 'SPH', 'width=400,height=200')"]) ?></td>
                    </tr> 
                    <tr>
                        <td>Program Berjalan</td>
                        <td><?= cekbatch($model->tahun, 11, 0) ?></td>
                        <td><?= Html::a('<i class="glyphicon glyphicon-refresh bg-white"></i>', ['load', 'id' => $model->id, 'ref' => 11, 'riwayat' => 0], ['class' => 'btn btn-xs btn-info','onClick' => "return !window.open(this.href, 'SPH', 'width=400,height=200')"]) ?></td>
                    </tr> 
                    <tr>
                        <td>Kegiatan Berjalan</td>
                        <td><?= cekbatch($model->tahun, 9, 0) ?></td>
                        <td><?= Html::a('<i class="glyphicon glyphicon-refresh bg-white"></i>', ['load', 'id' => $model->id, 'ref' => 9, 'riwayat' => 0], ['class' => 'btn btn-xs btn-info','onClick' => "return !window.open(this.href, 'SPH', 'width=400,height=200')"]) ?></td>
                    </tr>                                         
                    <tr>
                        <td>Belanja</td>
                        <td><?= cekbatch($model->tahun, 6, 0) ?></td>
                        <td><?= Html::a('<i class="glyphicon glyphicon-refresh bg-white"></i>', ['load', 'id' => $model->id, 'ref' => 6, 'riwayat' => 0], ['class' => 'btn btn-xs btn-info','onClick' => "return !window.open(this.href, 'SPH', 'width=400,height=200')"]) ?></td>
                    </tr>
                    <tr>
                        <td>Rincian Belanja</td>
                        <td><?= cekbatch($model->tahun, 7, 0) ?></td>
                        <td><?= Html::a('<i class="glyphicon glyphicon-refresh bg-white"></i>', ['load', 'id' => $model->id, 'ref' => 7, 'riwayat' => 0], ['class' => 'btn btn-xs btn-info','onClick' => "return !window.open(this.href, 'SPH', 'width=400,height=200')"]) ?></td>
                    </tr>
                    <tr>
                        <td>Sub Rincian Belanja</td>
                        <td><?= cekbatch($model->tahun, 8, 0) ?></td>
                        <td><?= Html::a('<i class="glyphicon glyphicon-refresh bg-white"></i>', ['load', 'id' => $model->id, 'ref' => 8, 'riwayat' => 0], ['class' => 'btn btn-xs btn-info','onClick' => "return !window.open(this.href, 'SPH', 'width=400,height=200')"]) ?></td>
                    </tr>                                                                                                                                             
                </tbody>
            </table>
            <hr>
        </div>
    </div>    

    <div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Anggaran</h3>
    </div>
        <div class="box-body">
            <table class="table table-hover">
                <tbody>
                    <tr>
                        <th>Perubahan</th>
                        <th>Mutakhir</th>
                        <th>Aksi</th>
                    </tr>
                    <?php
                        $stmt = $data->prepare("SELECT a.Kd_Perubahan, b.Uraian FROM Ta_RASK_Arsip a INNER JOIN Ref_Perubahan B ON a.Kd_Perubahan = b.Kd_Perubahan WHERE a.Tahun = ".$model->tahun." GROUP BY a.Kd_Perubahan, b.Uraian");
                          $stmt->execute();
                          while ($row = $stmt->fetch()):      
                    ?>                    
                    <tr>
                        <td><?= $row['Uraian'] ?></td>
                        <td><?= cekbatch($model->tahun, 12, $row['Kd_Perubahan']) ?></td>
                        <td><?= Html::a('<i class="glyphicon glyphicon-refresh bg-white"></i>', ['load', 'id' => $model->id, 'ref' => 12, 'riwayat' => $row['Kd_Perubahan']], ['class' => 'btn btn-xs btn-info','onClick' => "return !window.open(this.href, 'SPH', 'width=400,height=200')"]) ?></td>
                    </tr>
                    <?php  
                        endwhile;                            
                          unset($data); unset($stmt);        
                    ?>                      
                </tbody>
            </table>
            <hr>
        </div>
    </div>

    <div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Data Penatausahaan</h3>
    </div>
        <div class="box-body">
            <table class="table table-hover">
                <tbody>
                    <tr>
                        <th>Data</th>
                        <th>Mutakhir</th>
                        <th>Aksi</th>
                    </tr>
                    <tr>
                        <td>Data Kontrak</td>
                        <td><?= cekbatch($model->tahun, 10, 0) ?></td>
                        <td><?= Html::a('<i class="glyphicon glyphicon-refresh bg-white"></i>', ['load', 'id' => $model->id, 'ref' => 10, 'riwayat' => 0], ['class' => 'btn btn-xs btn-info','onClick' => "return !window.open(this.href, 'SPH', 'width=400,height=200')"]) ?></td>
                    </tr>                                        
                    <tr>
                        <td>Data SPP</td>
                        <td><?= cekbatch($model->tahun, 13, 0) ?></td>
                        <td><?= Html::a('<i class="glyphicon glyphicon-refresh bg-white"></i>', ['load', 'id' => $model->id, 'ref' => 13, 'riwayat' => 0], ['class' => 'btn btn-xs btn-info','onClick' => "return !window.open(this.href, 'SPH', 'width=400,height=200')"]) ?></td>
                    </tr> 
                    <tr>
                        <td>Data SPM</td>
                        <td><?= cekbatch($model->tahun, 14, 0) ?></td>
                        <td><?= Html::a('<i class="glyphicon glyphicon-refresh bg-white"></i>', ['load', 'id' => $model->id, 'ref' => 14, 'riwayat' => 0], ['class' => 'btn btn-xs btn-info','onClick' => "return !window.open(this.href, 'SPH', 'width=400,height=200')"]) ?></td>
                    </tr> 
                    <tr>
                        <td>Data SP2D</td>
                        <td><?= cekbatch($model->tahun, 15, 0) ?></td>
                        <td><?= Html::a('<i class="glyphicon glyphicon-refresh bg-white"></i>', ['load', 'id' => $model->id, 'ref' => 15, 'riwayat' => 0], ['class' => 'btn btn-xs btn-info','onClick' => "return !window.open(this.href, 'SPH', 'width=400,height=200')"]) ?></td>
                    </tr> 
                                                                                                                                             
                </tbody>
            </table>
            <hr>
        </div>
    </div> 
</div>
