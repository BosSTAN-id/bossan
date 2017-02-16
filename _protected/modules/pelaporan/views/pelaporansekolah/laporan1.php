<?php 
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\db\Expression;

 ?>
         <div class="panel panel-primary filterable">
            <div class="panel-heading">
                <h3 class="panel-title"><?= $heading.
                Html::a('<i class="glyphicon glyphicon-print"></i> Cetak', ['cetak', 'Laporan' => [
                        'Kd_Laporan' => $getparam['Laporan']['Kd_Laporan'], 
                        'Kd_Sumber' => $getparam['Laporan']['Kd_Sumber'],
                        'Tgl_1' => $getparam['Laporan']['Tgl_1'],
                        'Tgl_2' => $getparam['Laporan']['Tgl_2'],
                        'Tgl_Laporan' => $getparam['Laporan']['Tgl_Laporan'],
                        'perubahan_id' => $getparam['Laporan']['perubahan_id']
                    ] ], [
                        'class' => 'btn btn-xs btn-warning pull-right',
                        'onClick' => "return !window.open(this.href, 'SPH', 'width=1024,height=600,scrollbars=1')"
                            ]) 
                            ?></h3>
            </div>
            <div class="panel-body">
                <!-- <h3 class="text-center"><?= strtoupper($heading) ?></h3> -->
                <div class="col-md-6">
                    <table class="table table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th colspan="3" class="text-center">PENERIMAAN/PENDAPATAN</th>
                            </tr>
                            <tr>
                                <th width="5%" class="text-center">Kode</th>
                                <th width="70%" class="text-center">Uraian</th>
                                <th width="25%" class="text-center">Jumlah</th>
                            </tr>                            
                        </thead>
                        <tbody>
                            <tr>
                                <?php $saldoawal = 
                                                $data1
                                                ->select(['tahun', 'sekolah_id', 'Kd_Rek_1', 'Kd_Rek_2', 'Kd_Rek_3', 'Kd_Rek_4', 'Kd_Rek_5', 'kd_penerimaan_1', 'kd_penerimaan_2', new Expression('SUM(nilai) as nilai')])
                                                ->groupBy('tahun, sekolah_id, Kd_Rek_1, Kd_Rek_2, Kd_Rek_3, Kd_Rek_4, Kd_Rek_5, kd_penerimaan_1, kd_penerimaan_2')
                                                ->all(); ?>
                                <td class="text-left">1</td>
                                <td><b>Sisa Tahun Lalu</b></td>
                                <td class="text-right"><?php $jumlah_saldoawal = $data1->sum('nilai'); echo number_format($jumlah_saldoawal, 0, '.', '.') ?></td>
                            </tr>
                            <?php foreach ($saldoawal as $value): ?>
                            <tr>
                                <td class="text-left"><?= $value->kd_penerimaan_1.'.'.$value->kd_penerimaan_2 ?></td>
                                <td><?= $value->penerimaan2->uraian ?></td>
                                <td class="text-right"><?= number_format($value->nilai, 0, '.', '.') ?></td>
                            </tr> 
                            <?php endforeach; ?>
                            <tr>
                                <?php $rutin = $data2->andWhere(['kd_penerimaan_1' => 2]); ?>
                                <td class="text-left">2</td>
                                <td><b>Pendapatan Rutin</b></td>
                                <td class="text-right"><?php $jumlah_rutin = $rutin->sum('total'); echo number_format($jumlah_rutin, 0, '.', '.') ?></td>
                            </tr>
                            <?php $rutin = $rutin->all(); foreach ($rutin as $value): ?>
                            <tr>
                                <td class="text-left"><?= $value->kd_penerimaan_1.'.'.$value->kd_penerimaan_2 ?></td>
                                <td><?= $value->penerimaan2->uraian ?></td>
                                <td class="text-right"><?= number_format($value->total, 0, '.', '.') ?></td>
                            </tr> 
                            <?php endforeach; ?>
                            <tr>
                                <?php $bos = $data3->andWhere(['kd_penerimaan_1' => 3]); ?>
                                <td class="text-left">3</td>
                                <td><b>Bantuan Operasional Sekolah</b></td>
                                <td class="text-right"><?php $jumlah_bos = $bos->sum('total'); echo number_format($jumlah_bos, 0, '.', '.') ?></td>
                            </tr>
                            <?php $bos = $bos->all(); foreach ($bos as $value): ?>
                            <tr>
                                <td class="text-left"><?= $value->kd_penerimaan_1.'.'.$value->kd_penerimaan_2 ?></td>
                                <td><?= $value->penerimaan2->uraian ?></td>
                                <td class="text-right"><?= number_format($value->total, 0, '.', '.') ?></td>
                            </tr> 
                            <?php endforeach; ?> 
                            <tr>
                                <?php $bantuan = $data4->andWhere(['kd_penerimaan_1' => 4]); ?>
                                <td class="text-left">4</td>
                                <td><b>Bantuan</b></td>
                                <td class="text-right"><?php $jumlah_bantuan = $bantuan->sum('total'); echo number_format($jumlah_bantuan, 0, '.', '.') ?></td>
                            </tr>
                            <?php $bantuan = $bantuan->all(); foreach ($bantuan as $value): ?>
                            <tr>
                                <td class="text-left"><?= $value->kd_penerimaan_1.'.'.$value->kd_penerimaan_2 ?></td>
                                <td><?= $value->penerimaan2->uraian ?></td>
                                <td class="text-right"><?= number_format($value->total, 0, '.', '.') ?></td>
                            </tr> 
                            <?php endforeach; ?>
                            <tr>
                                <?php $lain = $data5->andWhere('kd_penerimaan_1 NOT IN (1,2,3,4)'); ?>
                                <td class="text-left">5</td>
                                <td><b>Pendapatan Lainnya</b></td>
                                <td class="text-right"><?php $jumlah_lain = $lain->sum('total'); echo number_format($jumlah_lain, 0, '.', '.') ?></td>
                            </tr>
                            <?php $lain = $lain->all(); foreach ($lain as $value): ?>
                            <tr>
                                <td class="text-left"><?= $value->kd_penerimaan_1.'.'.$value->kd_penerimaan_2 ?></td>
                                <td><?= $value->penerimaan2->uraian ?></td>
                                <td class="text-right"><?= number_format($value->total, 0, '.', '.') ?></td>
                            </tr> 
                            <?php endforeach; ?>                                                                                                                                      
                            <tr>
                                <td colspan="2" class="text-right"><b>Jumlah Penerimaan</b></td>
                                <td class="text-right"><?= number_format($jumlah_saldoawal+$jumlah_rutin+$jumlah_bos+$jumlah_bantuan+$jumlah_lain, 0, ',', '.') ?></td>
                            </tr>                        
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th colspan="3" class="text-center">PENGELUARAN/BELANJA</th>
                            </tr>
                            <tr>
                                <th width="5%" class="text-center">Kode</th>
                                <th width="70%" class="text-center">Uraian</th>
                                <th width="25%" class="text-center">Jumlah</th>
                            </tr>                            
                        </thead>
                        <tbody>
                            <?php $jumlah_belanja = 0; foreach ($data as $value): ?>
                            <tr>
                                <td class="text-left"><?= $value->kd_program ?></td>
                                <td><?= $value->refprogram->uraian_program ?></td>
                                <td class="text-right"><?= number_format($value->total, 0, '.', '.') ?></td>
                                <?php $jumlah_belanja = $jumlah_belanja+$value->total; ?>
                            </tr> 
                            <?php endforeach; ?>
                            <tr>
                                <td colspan="2" class="text-right"><b>Jumlah Pengeluaran</b></td>
                                <td class="text-right"><?= number_format($jumlah_belanja, 0, ',', '.') ?></td>
                            </tr>                       
                        </tbody>
                    </table>
                </div>                
            </div>
        </div>