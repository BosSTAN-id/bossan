<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use dosamigos\chartjs\ChartJs;
use yii\bootstrap\ActiveForm;
use kartik\widgets\DatePicker;
/* @var $this yii\web\View */
/* @var $searchrencana app\modules\anggaran\rencanas\TaRkasKegiatan */
/* @var $dataProvider yii\data\ActiveDataProvider */
function angka($n) {
    // first strip any formatting;
    // $n = (0+str_replace(",","",$n));
    
    // is this a number?
    if(!is_numeric($n)) return false;
    
    // now filter it;
    if($n>1000000000000) return round(($n/1000000000000),1).' T';
    else if($n>1000000000) return round(($n/1000000000),1).' M';
    else if($n>1000000) return round(($n/1000000),1).' juta';
    else if($n>1000) return round(($n/1000),1).' ribu';
    
    return number_format($n);
}

function getBaRinc($no_peraturan, $sekolah_id){
	$data = \app\models\TaBaverRinc::findOne(['no_peraturan' => $no_peraturan, 'sekolah_id' => $sekolah_id]);
	return $data;
}
function getStatusBa($no_peraturan, $sekolah_id){
	$ba = getBaRinc($no_peraturan, $sekolah_id);
	if($ba != NULL){
		$data = \app\models\TaBaver::findOne(['no_ba' => $ba->no_ba])->status;
		if($data == 1) return true;
	}
	return false;
}

$this->title = 'Posting Anggaran';
$this->params['breadcrumbs'][] = 'Anggaran';
$this->params['breadcrumbs'][] = $this->title;
?>
<!--form posting -->
	<div class="box box-primary">
	<div class="box-header with-border">
	  <h3 class="box-title">Riwayat Posting</h3>
	</div>
	<!-- /.box-header -->
	<div class="box-body no-padding">
	  <div class="table-responsive">
		    <?php 
		    $form = ActiveForm::begin(['id' => $rencana->formName()]);
		    IF( $rencana->isNewRecord ): ?>
		    <?php echo $form->field($rencana, 'perubahan_id')->hiddenInput(['value' => 3])->label(false); ?>
		    <div class="col-md-11">          
			    <div class="col-md-2">
				    <i class="fa fa-star-o text-yellow"></i> Rencana
				</div>
				<div class="col-md-2">
		        	<?= $form->field($rencana, 'no_peraturan')->textInput(['class' => 'form-control input-sm','placeholder' => 'No Peraturan'])->label(false) ?>
		        </div>
				<div class="col-md-2">
			        <?= DatePicker::widget([
			        	'model' => $rencana,
			            'attribute' => 'tgl_peraturan',
			            'id' => 'daterencana',
			            'size' => 'sm',
			            'removeButton' => false,
			            'options' => ['placeholder' => 'Tgl Peraturan'],
			            'pluginOptions' => [
			                'autoclose'=>true,
			                'format' => 'yyyy-m-d',
			            ]
			        ]); ?> 		        	
		        </div>
				<div class="col-md-2">
		        	<?= $form->field($rencana, 'penandatangan')->textInput(['class' => 'form-control input-sm','placeholder' => 'Penandantangan'])->label(false) ?>
					<?= $form->field($rencana, 'komite_sekolah')->textInput(['class' => 'form-control input-sm','placeholder' => 'Penandatangan Komite'])->label(false) ?>
		        </div>
				<div class="col-md-2">
		        	<?= $form->field($rencana, 'nip')->textInput(['class' => 'form-control input-sm','placeholder' => 'NIP'])->label(false) ?>
		        </div>
				<div class="col-md-2">
		        	<?= $form->field($rencana, 'jabatan')->textInput(['class' => 'form-control input-sm','placeholder' => 'Jabatan'])->label(false) ?>
					<?= $form->field($rencana, 'jabatan_komite')->textInput(['class' => 'form-control input-sm','placeholder' => 'Jabatan Komite'])->label(false) ?>
		        </div>
	        </div>
			<div class="col-md-1">
	        	<?= Html::submitButton('Posting', ['class' => 'btn btn-xs btn-success']) ?>
	        </div>
	    	<?php else: ?>
		    <div class="col-md-12">          
			    <div class="col-md-2">
				    <i class="fa fa-star text-yellow"></i> Rencana
				</div>
				<div class="col-md-5">
		        	<?= $rencana->no_peraturan ?>
		        </div>
				<div class="col-md-5">
		        	<?= date('d-m-Y', strtotime($rencana->tgl_peraturan)) ?>
					<div class="pull-right">
						<?php
							if(getStatusBa($rencana->no_peraturan, $rencana->sekolah_id) == false) echo Html::a('<i class="fa fa-trash fa-fw"></i>', ['repost', 'no_peraturan' => $rencana->no_peraturan, 'sekolah_id' => $rencana->sekolah_id],
                              [  
                                 'title' => Yii::t('yii', 'Hapus Posting'),
								 'class' => 'btn btn-xs btn-danger',                       
                                 'data-confirm' => "Yakin mengubah anggaran yang sudah di posting?",
                                 'data-method' => 'POST',
                              ]);						
						?>
					</div>
		        </div>
	        </div>
	    	<?php endif; ?>
	        <?php ActiveForm::end(); ?>	
	    </div>
		<div class="progress progress-xxs">
		  <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
		    <span class="sr-only">45% Complete</span>
		  </div>
		</div>    

	  <div class="table-responsive">
		    <?php 
		    $form = ActiveForm::begin(['id' => $induk->formName()]);
		    IF( $induk->isNewRecord ): ?>
		    <?php echo $form->field($induk, 'perubahan_id')->hiddenInput(['value' => 4])->label(false); ?>
		    <div class="col-md-11">          
			    <div class="col-md-2">
				    <i class="fa fa-star-o text-yellow"></i> RKAS
				</div>
				<div class="col-md-2">
		        	<?= $form->field($induk, 'no_peraturan')->textInput(['class' => 'form-control input-sm','placeholder' => 'No Peraturan'])->label(false) ?>
		        </div>
				<div class="col-md-2">
			        <?= DatePicker::widget([
			        	'model' => $induk,
			            'attribute' => 'tgl_peraturan',
			            'id' => 'dateinduk',
			            'size' => 'sm',
			            'removeButton' => false,
			            'options' => ['placeholder' => 'Tgl Peraturan'],
			            'pluginOptions' => [
			                'autoclose'=>true,
			                'format' => 'yyyy-m-d',
			            ]
			        ]); ?>  		        	
		        </div>
				<div class="col-md-2">
		        	<?= $form->field($induk, 'penandatangan')->textInput(['class' => 'form-control input-sm','placeholder' => 'Penandantangan'])->label(false) ?>
					<?= $form->field($induk, 'komite_sekolah')->textInput(['class' => 'form-control input-sm','placeholder' => 'Penandatangan Komite'])->label(false) ?>
		        </div>
				<div class="col-md-2">
		        	<?= $form->field($induk, 'nip')->textInput(['class' => 'form-control input-sm','placeholder' => 'NIP'])->label(false) ?>
		        </div>
				<div class="col-md-2">
		        	<?= $form->field($induk, 'jabatan')->textInput(['class' => 'form-control input-sm','placeholder' => 'Jabatan'])->label(false) ?>
					<?= $form->field($induk, 'jabatan_komite')->textInput(['class' => 'form-control input-sm','placeholder' => 'Jabatan Komite'])->label(false) ?>
		        </div>
	        </div>
			<div class="col-md-1">
	        	<?= Html::submitButton('Posting', ['class' => 'btn btn-xs btn-success']) ?>
	        </div>
	    	<?php else: ?>
		    <div class="col-md-12">          
			    <div class="col-md-2">
				    <i class="fa fa-star text-yellow"></i> RKAS
				</div>
				<div class="col-md-5">
		        	<?= $induk->no_peraturan ?>
		        </div>
				<div class="col-md-5">
		        	<?= date('d-m-Y', strtotime($induk->tgl_peraturan)) ?>
					<div class="pull-right">
						<?php
							if(getStatusBa($induk->no_peraturan, $induk->sekolah_id) == false) echo Html::a('<i class="fa fa-trash fa-fw"></i>', ['repost', 'no_peraturan' => $induk->no_peraturan, 'sekolah_id' => $induk->sekolah_id],
                              [  
                                 'title' => Yii::t('yii', 'Hapus Posting'),
								 'class' => 'btn btn-xs btn-danger',                       
                                 'data-confirm' => "Yakin mengubah anggaran yang sudah di posting?",
                                 'data-method' => 'POST',
                              ]);						
						?>
					</div>					
		        </div>
	        </div>
	    	<?php endif; ?>
	        <?php ActiveForm::end(); ?>	
	    </div>
		<div class="progress progress-xxs">
		  <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
		    <span class="sr-only">45% Complete</span>
		  </div>
		</div>        

	  <div class="table-responsive">
		    <?php 
		    $form = ActiveForm::begin(['id' => $perubahan1->formName()]);
		    IF( $perubahan1->isNewRecord ): ?>
		    <?php echo $form->field($perubahan1, 'perubahan_id')->hiddenInput(['value' => 6])->label(false); ?>
		    <div class="col-md-11">          
			    <div class="col-md-2">
				    <i class="fa fa-star-o text-yellow"></i> RKAS Perubahan
				</div>
				<div class="col-md-2">
		        	<?= $form->field($perubahan1, 'no_peraturan')->textInput(['class' => 'form-control input-sm','placeholder' => 'No Peraturan'])->label(false) ?>
		        </div>
				<div class="col-md-2">
			        <?= DatePicker::widget([
			        	'model' => $perubahan1,
			            'attribute' => 'tgl_peraturan',
			            'id' => 'dateperubahan',
			            'size' => 'sm',
			            'removeButton' => false,
			            'options' => ['placeholder' => 'Tgl Peraturan'],
			            'pluginOptions' => [
			                'autoclose'=>true,
			                'format' => 'yyyy-m-d',
			            ]
			        ]); ?> 		        	
		        </div>
				<div class="col-md-2">
		        	<?= $form->field($perubahan1, 'penandatangan')->textInput(['class' => 'form-control input-sm','placeholder' => 'Penandantangan'])->label(false) ?>
					<?= $form->field($perubahan1, 'komite_sekolah')->textInput(['class' => 'form-control input-sm','placeholder' => 'Penandatangan Komite'])->label(false) ?>
		        </div>
				<div class="col-md-2">
		        	<?= $form->field($perubahan1, 'nip')->textInput(['class' => 'form-control input-sm','placeholder' => 'NIP'])->label(false) ?>
		        </div>
				<div class="col-md-2">
		        	<?= $form->field($perubahan1, 'jabatan')->textInput(['class' => 'form-control input-sm','placeholder' => 'Jabatan'])->label(false) ?>
					<?= $form->field($perubahan1, 'jabatan_komite')->textInput(['class' => 'form-control input-sm','placeholder' => 'Jabatan Komite'])->label(false) ?>
		        </div>
	        </div>
			<div class="col-md-1">
	        	<?= Html::submitButton('Posting', ['class' => 'btn btn-xs btn-success']) ?>
	        </div>
	    	<?php else: ?>
		    <div class="col-md-12">          
			    <div class="col-md-2">
				    <i class="fa fa-star text-yellow"></i> RKAS Perubahan
				</div>
				<div class="col-md-5">
		        	<?= $perubahan1->no_peraturan ?>
		        </div>
				<div class="col-md-5">
		        	<?= date('d-m-Y', strtotime($perubahan1->tgl_peraturan)) ?>
					<div class="pull-right">
						<?php 
							if(getStatusBa($perubahan1->no_peraturan, $perubahan1->sekolah_id) == false) echo Html::a('<i class="fa fa-trash fa-fw"></i>', ['repost', 'no_peraturan' => $perubahan1->no_peraturan, 'sekolah_id' => $perubahan1->sekolah_id],
                              [  
                                 'title' => Yii::t('yii', 'Hapus Posting'),
								 'class' => 'btn btn-xs btn-danger',                       
                                 'data-confirm' => "Yakin mengubah anggaran yang sudah di posting?",
                                 'data-method' => 'POST',
                              ]);						
						?>
					</div>					
		        </div>
	        </div>
	    	<?php endif; ?>
	        <?php ActiveForm::end(); ?>	
	    </div>       		

	  </div>      
	  <!-- /.mail-box-messages> -->
	</div>
	<!-- /.box-body -->
<?php
?>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Anggaran Kas Rencana Kegiatan Anggaran Sekolah Tahun Anggaran <?= $Tahun?></h3>
            <span class="label label-primary pull-right"><i class="fa fa-html5"></i></span>
        </div><!-- /.box-header -->
        <div class="box-body bg-info">
            <p style="margin-top: 10px;" class="text-muted well well-sm no-shadow">
                Berikut posisi penginputan RKAS yang akan diposting. Periksa kembali dan pastikan data sudah benar.
            </p>
			<div class="col-md-12 well">
				<?= $this->render('_search', [
					'model' => $laporan,
				]) ?>
			</div>
            <div class="col-md-6">      
	            <div class="col-md-12 col-sm-12 col-xs-12">
	                <div class="info-box">
	                    <a href="">
	                        <span class="info-box-icon bg-aqua"><i class="fa fa-download"></i></span>
	                    </a> 
	                    <div class="info-box-content">
	                        <?= Html::a('<span class="info-box-text">PENDAPATAN</span>', ['/anggaran/rkas/rkaspendapatan'], []) ?>
	                        <span class="info-box-number"><?= angka($pdt) ?></span>
	                    </div><!-- /.info-box-content -->
	                </div><!-- /.info-box -->
	            </div>

	            <div class="col-md-12 col-sm-12 col-xs-12">
	                <div class="info-box">
	                    <a href="">
	                        <span class="info-box-icon bg-aqua"><i class="fa fa-external-link"></i></span>
	                    </a> 
	                    <div class="info-box-content">
	                        <?= Html::a('<span class="info-box-text">BELANJA LANGSUNG</span>', ['/anggaran/rkas/rkaskegiatan'], []) ?>
	                        <span class="info-box-number"><?= angka($belanja) ?></span>
	                    </div><!-- /.info-box-content -->
	                </div><!-- /.info-box -->
	            </div>

	            <div class="col-md-12 col-sm-12 col-xs-12">
	                <div class="info-box">
	                    <a href="">
	                        <span class="info-box-icon bg-aqua"><i class="fa fa-credit-card"></i></span>
	                    </a> 
	                    <div class="info-box-content">
	                        <?= Html::a('<span class="info-box-text">BELANJA TIDAK LANGSUNG</span>', ['/anggaran/rkas/rkasbtl'], []) ?>
	                        <span class="info-box-number"><?= angka($btl) ?></span>
	                    </div><!-- /.info-box-content -->
	                </div><!-- /.info-box -->
	            </div>
	        </div>
            <div class="col-md-6">
                <?php 
                echo ChartJs::widget([
                    'type' => 'doughnut',
                    // 'options' => [
                    //     'height' => 400,
                    //     'width' => 400
                    // ],
                    'data' => [
                        'labels' => ["Pendapatan", "Belanja Langsung", "Belanja Tidak Langsung"],
                        'datasets' => [
                            [
                                'label' => 'Anggaran',
                                'fillColor' => "rgba(220,220,220,0.5)",
                                'strokeColor' => "rgba(220,220,220,1)",
                                'pointColor' => "rgba(220,220,220,1)",
                                'pointStrokeColor' => "#fff",
                                'backgroundColor' => ["#FF6384", "#36A2EB", "#FFCE56"],
                                'hoverBackgroundColor' =>["#FF6384", "#36A2EB", "#FFCE56"],
                                'data' => [$pdt, $belanja, $btl]
                            ],
                        ]
                    ]
                ]);
                ?>
            </div>	             
        </div><!-- /.box-body -->
    </div>
