<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use yii\bootstrap\Modal;
use yii\helpers\Url;
function akses($id, $menu){
	$akses = \app\models\RefUserMenu::find()->where(['kd_user' => $id, 'menu' => $menu])->one();
	IF($akses) return true;
}
?> 
<table class="table table-hover">
	<tbody>
		<tr>
			<th>Main Menu</th>
			<th>Sub Menu</th>
			<th>Sub Sub Menu</th>
			<th>Akses</th>
		</tr>
		<!--Menu 1 -->
		<tr>
			<td rowspan="11">Pengaturan</td>
			<td>Pengaturan Global</td>
			<td>-</td>
			<td>
			<?php
				$menu = 405;
				IF(akses($model->id, $menu) === true){
					echo Html::a('<span class = "label label-success"><i class="fa  fa-sign-in bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 0 ],
                            [
                             'id' => 'access-'.$menu,
                          ]);							
				}ELSE{
					echo Html::a('<span class = "label label-danger"><i class="fa  fa-lock bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 1 ],
                            [  
                             'id' => 'access-'.$menu,
                          ]);
				}

			?>
			</td>
		</tr>
		<tr>
			<td>User Management</td>
			<td>-</td>
			<td>
			<?php
				$menu = 102;
				IF(akses($model->id, $menu) === true){
					echo Html::a('<span class = "label label-success"><i class="fa  fa-sign-in bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 0 ],
                            [
                             'id' => 'access-'.$menu,
                          ]);							
				}ELSE{
					echo Html::a('<span class = "label label-danger"><i class="fa  fa-lock bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 1 ],
                            [  
                             'id' => 'access-'.$menu,
                          ]);
				}

			?>
			</td>
		</tr>		
		<tr>
			<td>Grup User dan Akses</td>
			<td>-</td>
			<td>
			<?php
				$menu = 401;
				IF(akses($model->id, $menu) === true){
					echo Html::a('<span class = "label label-success"><i class="fa  fa-sign-in bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 0 ],
                            [  
                             'id' => 'access-'.$menu,
                          ]);							
				}ELSE{
					echo Html::a('<span class = "label label-danger"><i class="fa  fa-lock bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 1 ],
                            [  
                             'id' => 'access-'.$menu,
                          ]);
				}

			?>
			</td>
		</tr>
		<tr>
			<td>Mapping Komponen BOS</td>
			<td>-</td>
			<td>
			<?php
				$menu = 104;
				IF(akses($model->id, $menu) === true){
					echo Html::a('<span class = "label label-success"><i class="fa  fa-sign-in bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 0 ],
                            [  
                             'id' => 'access-'.$menu,
                          ]);							
				}ELSE{
					echo Html::a('<span class = "label label-danger"><i class="fa  fa-lock bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 1 ],
                            [  
                             'id' => 'access-'.$menu,
                          ]);
				}

			?>
			</td>
		</tr>
		<tr>
			<td>Mapping Pendapatan</td>
			<td>-</td>
			<td>
			<?php
				$menu = 105;
				IF(akses($model->id, $menu) === true){
					echo Html::a('<span class = "label label-success"><i class="fa  fa-sign-in bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 0 ],
                            [  
                             'id' => 'access-'.$menu,
                          ]);							
				}ELSE{
					echo Html::a('<span class = "label label-danger"><i class="fa  fa-lock bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 1 ],
                            [  
                             'id' => 'access-'.$menu,
                          ]);
				}

			?>
			</td>
		</tr>
		<tr>
			<td>Mapping Sisa Kas</td>
			<td>-</td>
			<td>
			<?php
				$menu = 109;
				IF(akses($model->id, $menu) === true){
					echo Html::a('<span class = "label label-success"><i class="fa  fa-sign-in bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 0 ],
                            [  
                             'id' => 'access-'.$menu,
                          ]);							
				}ELSE{
					echo Html::a('<span class = "label label-danger"><i class="fa  fa-lock bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 1 ],
                            [  
                             'id' => 'access-'.$menu,
                          ]);
				}

			?>
			</td>
		</tr>		
		<tr>
			<td>Pengumuman</td>
			<td>-</td>
			<td>
			<?php
				$menu = 106;
				IF(akses($model->id, $menu) === true){
					echo Html::a('<span class = "label label-success"><i class="fa  fa-sign-in bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 0 ],
                            [  
                             'id' => 'access-'.$menu,
                          ]);							
				}ELSE{
					echo Html::a('<span class = "label label-danger"><i class="fa  fa-lock bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 1 ],
                            [  
                             'id' => 'access-'.$menu,
                          ]);
				}

			?>
			</td>
		</tr>
		<tr>
			<td>Seleksi Rekening</td>
			<td>-</td>
			<td>
			<?php
				$menu = 107;
				IF(akses($model->id, $menu) === true){
					echo Html::a('<span class = "label label-success"><i class="fa  fa-sign-in bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 0 ],
                            [  
                             'id' => 'access-'.$menu,
                          ]);							
				}ELSE{
					echo Html::a('<span class = "label label-danger"><i class="fa  fa-lock bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 1 ],
                            [  
                             'id' => 'access-'.$menu,
                          ]);
				}

			?>
			</td>
		</tr>
		<tr>
			<td>Program dan Kegiatan</td>
			<td>-</td>
			<td>
			<?php
				$menu = 108;
				IF(akses($model->id, $menu) === true){
					echo Html::a('<span class = "label label-success"><i class="fa  fa-sign-in bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 0 ],
                            [  
                             'id' => 'access-'.$menu,
                          ]);							
				}ELSE{
					echo Html::a('<span class = "label label-danger"><i class="fa  fa-lock bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 1 ],
                            [  
                             'id' => 'access-'.$menu,
                          ]);
				}

			?>
			</td>
		</tr>
		<tr>
			<td>Komponen BOS</td>
			<td>-</td>
			<td>
			<?php
				$menu = 206;
				IF(akses($model->id, $menu) === true){
					echo Html::a('<span class = "label label-success"><i class="fa  fa-sign-in bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 0 ],
                            [  
                             'id' => 'access-'.$menu,
                          ]);							
				}ELSE{
					echo Html::a('<span class = "label label-danger"><i class="fa  fa-lock bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 1 ],
                            [  
                             'id' => 'access-'.$menu,
                          ]);
				}

			?>
			</td>
		</tr>
		<tr>
			<td>Potongan Belanja</td>
			<td>-</td>
			<td>
			<?php
				$menu = 207;
				IF(akses($model->id, $menu) === true){
					echo Html::a('<span class = "label label-success"><i class="fa  fa-sign-in bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 0 ],
                            [  
                             'id' => 'access-'.$menu,
                          ]);							
				}ELSE{
					echo Html::a('<span class = "label label-danger"><i class="fa  fa-lock bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 1 ],
                            [  
                             'id' => 'access-'.$menu,
                          ]);
				}

			?>
			</td>
		</tr>

		<!--end of menu-->
		<!--Menu 2 -->
		<tr>
			<td rowspan="4">Parameter</td>
			<td>Sekolah</td>
			<td>-</td>
			<td>
			<?php
				$menu = 201;
				IF(akses($model->id, $menu) === true){
					echo Html::a('<span class = "label label-success"><i class="fa  fa-sign-in bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 0 ],
                            [
                             // 'class' => 'ajaxAkses',
                             'id' => 'access-'.$menu,
                          ]);							
				}ELSE{
					echo Html::a('<span class = "label label-danger"><i class="fa  fa-lock bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 1 ],
                            [  
                             'id' => 'access-'.$menu,
                          ]);
				}

			?>
			</td>
		</tr>
		<tr>
			<td>Data Sekolah</td>
			<td>-</td>
			<td>
			<?php
				$menu = 202;
				IF(akses($model->id, $menu) === true){
					echo Html::a('<span class = "label label-success"><i class="fa  fa-sign-in bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 0 ],
                            [
                             // 'class' => 'ajaxAkses',
                             'id' => 'access-'.$menu,
                          ]);							
				}ELSE{
					echo Html::a('<span class = "label label-danger"><i class="fa  fa-lock bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 1 ],
                            [  
                             'id' => 'access-'.$menu,
                          ]);
				}

			?>
			</td>		
		</tr>
		<tr>
			<td>Kecamatan-Desa/Kelurahan</td>
			<td>-</td>
			<td>
			<?php
				$menu = 204;
				IF(akses($model->id, $menu) === true){
					echo Html::a('<span class = "label label-success"><i class="fa  fa-sign-in bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 0 ],
                            [
                             // 'class' => 'ajaxAkses',
                             'id' => 'access-'.$menu,
                          ]);							
				}ELSE{
					echo Html::a('<span class = "label label-danger"><i class="fa  fa-lock bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 1 ],
                            [  
                             'id' => 'access-'.$menu,
                          ]);
				}

			?>
			</td>		
		</tr>
		<tr>
			<td>Rekening Aset Tetap</td>
			<td>-</td>
			<td>
			<?php
				$menu = 205;
				IF(akses($model->id, $menu) === true){
					echo Html::a('<span class = "label label-success"><i class="fa  fa-sign-in bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 0 ],
                            [
                             // 'class' => 'ajaxAkses',
                             'id' => 'access-'.$menu,
                          ]);							
				}ELSE{
					echo Html::a('<span class = "label label-danger"><i class="fa  fa-lock bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 1 ],
                            [  
                             'id' => 'access-'.$menu,
                          ]);
				}

			?>
			</td>		
		</tr>				
		<!--end of menu-->
		<tr>
			<td rowspan="1">Data Management</td>
			<td>Batch Process</td>
			<td>-</td>
			<td>
			<?php
				$menu = 301;
				IF(akses($model->id, $menu) === true){
					echo Html::a('<span class = "label label-success"><i class="fa  fa-sign-in bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 0 ],
                            [
                             // 'class' => 'ajaxAkses',
                             'id' => 'access-'.$menu,
                          ]);							
				}ELSE{
					echo Html::a('<span class = "label label-danger"><i class="fa  fa-lock bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 1 ],
                            [  
                             'id' => 'access-'.$menu,
                          ]);
				}

			?>
			</td>
		</tr>
		<!--Menu 4 -->
		<tr>
			<td rowspan="4">Anggaran</td>
			<td>RKAS</td>
			<td>-</td>
			<td>
			<?php
				$menu = 402;
				IF(akses($model->id, $menu) === true){
					echo Html::a('<span class = "label label-success"><i class="fa  fa-sign-in bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 0 ],
                            [
                             // 'class' => 'ajaxAkses',
                             'id' => 'access-'.$menu,
                          ]);							
				}ELSE{
					echo Html::a('<span class = "label label-danger"><i class="fa  fa-lock bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 1 ],
                            [  
                             'id' => 'access-'.$menu,
                          ]);
				}

			?>
			</td>
		</tr>
		<tr>
			<td>Anggaran Kas</td>
			<td>-</td>
			<td>
			<?php
				$menu = 404;
				IF(akses($model->id, $menu) === true){
					echo Html::a('<span class = "label label-success"><i class="fa  fa-sign-in bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 0 ],
                            [
                             // 'class' => 'ajaxAkses',
                             'id' => 'access-'.$menu,
                          ]);							
				}ELSE{
					echo Html::a('<span class = "label label-danger"><i class="fa  fa-lock bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 1 ],
                            [  
                             'id' => 'access-'.$menu,
                          ]);
				}

			?>
			</td>
		</tr>		
		<tr>
			<td>Posting</td>
			<td>-</td>
			<td>
			<?php
				$menu = 403;
				IF(akses($model->id, $menu) === true){
					echo Html::a('<span class = "label label-success"><i class="fa  fa-sign-in bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 0 ],
                            [
                             // 'class' => 'ajaxAkses',
                             'id' => 'access-'.$menu,
                          ]);							
				}ELSE{
					echo Html::a('<span class = "label label-danger"><i class="fa  fa-lock bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 1 ],
                            [  
                             'id' => 'access-'.$menu,
                          ]);
				}

			?>
			</td>
		</tr>
		<tr>
			<td>Verifikasi Anggaran</td>
			<td>-</td>
			<td>
			<?php
				$menu = 406;
				IF(akses($model->id, $menu) === true){
					echo Html::a('<span class = "label label-success"><i class="fa  fa-sign-in bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 0 ],
                            [
                             // 'class' => 'ajaxAkses',
                             'id' => 'access-'.$menu,
                          ]);							
				}ELSE{
					echo Html::a('<span class = "label label-danger"><i class="fa  fa-lock bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 1 ],
                            [  
                             'id' => 'access-'.$menu,
                          ]);
				}

			?>
			</td>
		</tr>
		<!--end of menu-->
		<!--Menu 5 -->
		<tr>
			<td rowspan="6">Penatausahaan</td>
			<td>Penerimaan</td>
			<td>-</td>
			<td>
			<?php
				$menu = 501;
				IF(akses($model->id, $menu) === true){
					echo Html::a('<span class = "label label-success"><i class="fa  fa-sign-in bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 0 ],
                            [
                             // 'class' => 'ajaxAkses',
                             'id' => 'access-'.$menu,
                          ]);							
				}ELSE{
					echo Html::a('<span class = "label label-danger"><i class="fa  fa-lock bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 1 ],
                            [  
                             'id' => 'access-'.$menu,
                          ]);
				}

			?>
			</td>
		</tr>
		<tr>
			<td>Mutasi Kas</td>
			<td>-</td>
			<td>
			<?php
				$menu = 508;
				IF(akses($model->id, $menu) === true){
					echo Html::a('<span class = "label label-success"><i class="fa  fa-sign-in bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 0 ],
                            [
                             // 'class' => 'ajaxAkses',
                             'id' => 'access-'.$menu,
                          ]);							
				}ELSE{
					echo Html::a('<span class = "label label-danger"><i class="fa  fa-lock bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 1 ],
                            [  
                             'id' => 'access-'.$menu,
                          ]);
				}

			?>
			</td>
		</tr>
		<tr>
			<td>Belanja</td>
			<td>-</td>
			<td>
			<?php
				$menu = 506;
				IF(akses($model->id, $menu) === true){
					echo Html::a('<span class = "label label-success"><i class="fa  fa-sign-in bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 0 ],
                            [
                             // 'class' => 'ajaxAkses',
                             'id' => 'access-'.$menu,
                          ]);							
				}ELSE{
					echo Html::a('<span class = "label label-danger"><i class="fa  fa-lock bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 1 ],
                            [  
                             'id' => 'access-'.$menu,
                          ]);
				}

			?>
			</td>
		</tr>		
		<tr>
			<td>SPJ</td>
			<td>-</td>
			<td>
			<?php
				$menu = 502;
				IF(akses($model->id, $menu) === true){
					echo Html::a('<span class = "label label-success"><i class="fa  fa-sign-in bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 0 ],
                            [
                             // 'class' => 'ajaxAkses',
                             'id' => 'access-'.$menu,
                          ]);							
				}ELSE{
					echo Html::a('<span class = "label label-danger"><i class="fa  fa-lock bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 1 ],
                            [  
                             'id' => 'access-'.$menu,
                          ]);
				}

			?>
			</td>
		</tr>
		<tr>
			<td>Setoran Potongan</td>
			<td>-</td>
			<td>
			<?php
				$menu = 509;
				IF(akses($model->id, $menu) === true){
					echo Html::a('<span class = "label label-success"><i class="fa  fa-sign-in bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 0 ],
                            [
                             // 'class' => 'ajaxAkses',
                             'id' => 'access-'.$menu,
                          ]);							
				}ELSE{
					echo Html::a('<span class = "label label-danger"><i class="fa  fa-lock bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 1 ],
                            [  
                             'id' => 'access-'.$menu,
                          ]);
				}

			?>
			</td>
		</tr>		
		<tr>
			<td>Verifikasi SPJ (TU)</td>
			<td>-</td>
			<td>
			<?php
				$menu = 503;
				IF(akses($model->id, $menu) === true){
					echo Html::a('<span class = "label label-success"><i class="fa  fa-sign-in bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 0 ],
                            [  
                             'id' => 'access-'.$menu,
                          ]);							
				}ELSE{
					echo Html::a('<span class = "label label-danger"><i class="fa  fa-lock bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 1 ],
                            [  
                             'id' => 'access-'.$menu,
                          ]);
				}

			?>
			</td>
		</tr>					
		<!--end of menu-->
		<!--Menu 7 -->
		<tr>
			<td rowspan="3">Aset Tetap</td>
			<td>Inventarisasi</td>
			<td>-</td>
			<td>
			<?php
				$menu = 701;
				IF(akses($model->id, $menu) === true){
					echo Html::a('<span class = "label label-success"><i class="fa  fa-sign-in bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 0 ],
                            [
                             // 'class' => 'ajaxAkses',
                             'id' => 'access-'.$menu,
                          ]);							
				}ELSE{
					echo Html::a('<span class = "label label-danger"><i class="fa  fa-lock bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 1 ],
                            [  
                             'id' => 'access-'.$menu,
                          ]);
				}

			?>
			</td>
		</tr>
		<tr>
			<td>Kondisi</td>
			<td>-</td>
			<td>
			<?php
				$menu = 702;
				IF(akses($model->id, $menu) === true){
					echo Html::a('<span class = "label label-success"><i class="fa  fa-sign-in bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 0 ],
                            [
                             // 'class' => 'ajaxAkses',
                             'id' => 'access-'.$menu,
                          ]);							
				}ELSE{
					echo Html::a('<span class = "label label-danger"><i class="fa  fa-lock bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 1 ],
                            [  
                             'id' => 'access-'.$menu,
                          ]);
				}

			?>
			</td>		
		</tr>
		<tr>
			<td>Rekonsiliasi</td>
			<td>-</td>
			<td>
			<?php
				$menu = 703;
				IF(akses($model->id, $menu) === true){
					echo Html::a('<span class = "label label-success"><i class="fa  fa-sign-in bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 0 ],
                            [
                             // 'class' => 'ajaxAkses',
                             'id' => 'access-'.$menu,
                          ]);							
				}ELSE{
					echo Html::a('<span class = "label label-danger"><i class="fa  fa-lock bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 1 ],
                            [  
                             'id' => 'access-'.$menu,
                          ]);
				}

			?>
			</td>		
		</tr>				
		<!--end of menu-->		
		<!--Menu 6 -->
		<tr>
			<td rowspan="5">Pelaporan</td>
			<td>Pelaporan Sekolah</td>
			<td>-</td>
			<td>
			<?php
				$menu = 601;
				IF(akses($model->id, $menu) === true){
					echo Html::a('<span class = "label label-success"><i class="fa  fa-sign-in bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 0 ],
                            [
                             // 'class' => 'ajaxAkses',
                             'id' => 'access-'.$menu,
                          ]);							
				}ELSE{
					echo Html::a('<span class = "label label-danger"><i class="fa  fa-lock bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 1 ],
                            [  
                             'id' => 'access-'.$menu,
                          ]);
				}

			?>
			</td>
		</tr>
		<tr>
			<td>SP3B (Pemda)</td>
			<td>-</td>
			<td>
			<?php
				$menu = 604;
				IF(akses($model->id, $menu) === true){
					echo Html::a('<span class = "label label-success"><i class="fa  fa-sign-in bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 0 ],
                            [  
                             'id' => 'access-'.$menu,
                          ]);							
				}ELSE{
					echo Html::a('<span class = "label label-danger"><i class="fa  fa-lock bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 1 ],
                            [  
                             'id' => 'access-'.$menu,
                          ]);
				}

			?>
			</td>
		</tr>
		<tr>
			<td>SP2B (Pemda)</td>
			<td>-</td>
			<td>
			<?php
				$menu = 605;
				IF(akses($model->id, $menu) === true){
					echo Html::a('<span class = "label label-success"><i class="fa  fa-sign-in bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 0 ],
                            [  
                             'id' => 'access-'.$menu,
                          ]);							
				}ELSE{
					echo Html::a('<span class = "label label-danger"><i class="fa  fa-lock bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 1 ],
                            [  
                             'id' => 'access-'.$menu,
                          ]);
				}

			?>
			</td>
		</tr>				
		<tr>
			<td>Pelaporan Kabupaten</td>
			<td>-</td>
			<td>
			<?php
				$menu = 602;
				IF(akses($model->id, $menu) === true){
					echo Html::a('<span class = "label label-success"><i class="fa  fa-sign-in bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 0 ],
                            [
                             // 'class' => 'ajaxAkses',
                             'id' => 'access-'.$menu,
                          ]);							
				}ELSE{
					echo Html::a('<span class = "label label-danger"><i class="fa  fa-lock bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 1 ],
                            [  
                             'id' => 'access-'.$menu,
                          ]);
				}

			?>
			</td>
		</tr>		
		<tr>
			<td>Verifikasi SPJ (Pemda)</td>
			<td>-</td>
			<td>
			<?php
				$menu = 603;
				IF(akses($model->id, $menu) === true){
					echo Html::a('<span class = "label label-success"><i class="fa  fa-sign-in bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 0 ],
                            [  
                             'id' => 'access-'.$menu,
                          ]);							
				}ELSE{
					echo Html::a('<span class = "label label-danger"><i class="fa  fa-lock bg-white"></i></span>', ['give', 'id' => $model->id, 'menu' => $menu, 'akses' => 1 ],
                            [  
                             'id' => 'access-'.$menu,
                          ]);
				}

			?>
			</td>
		</tr>
		<!--end of menu-->		
	</tbody>
</table>
<script>
    $('a[id^="access-"]').on("click", function(event) {
        event.preventDefault();
        var href = $(this).attr('href');
        var id = $(this).attr('id');
		var status = href.slice(-1);
		status = parseInt(status);
		status == 1 ? confirmMessage = 'Berikan akses?' : confirmMessage = 'Hapus Akses?'
		var confirmation = confirm(confirmMessage);
        object = $(this);
		if(confirmation == true){
			$(this).html('<i class=\"fa fa-spinner fa-spin\"></i>');
			$.ajax({
			    url: href,
			    type: 'post',
			    data: $(this).serialize(),
			    beforeSend: function(){
			            // create before send here
			        },
			        complete: function(){
			            // create complete here
			        },
			    success: function(data) {
					if(data == 1)
					{
						if(status == 1){
							$(object).html('<span class = "label label-success"><i class="fa  fa-sign-in bg-white"></i></span>');
							href = href.replace('akses=1', 'akses=0');
							$(object).attr('href', href);
						}else{
							$(object).html('<span class = "label label-danger"><i class="fa  fa-lock bg-white"></i></span>');
							href = href.replace('akses=0', 'akses=1');
							$(object).attr('href', href);
						}
					}else{
						$(object).html('<span class = "label label-danger">Gagal!</span>');
					}
			    }
			});
		}
    });   
</script>