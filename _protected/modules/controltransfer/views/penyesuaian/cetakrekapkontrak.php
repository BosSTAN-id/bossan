<?php

Use app\itbz\fpdf\src\fpdf\fpdf;

//menugaskan variabel $pdf pada function fpdf().
$pdf = new \fpdf\FPDF('L','mm',array(216,330));

//Menambahkan halaman, untuk menambahkan halaman tambahkan command ini. 
//P artinya potrait dan L artinya Landscape

//cara menambahkan image dalam dokumen. 
//Urutan data-> alamat file-posisi X- posisi Y-ukuran width - ukuran high -  
//menambahkan link bila perlu

// $pdf->SetRightMargin(180)

$border = 0;
$pdf->AddPage();
$pdf->SetAutoPageBreak(true,10);
$pdf->AliasNbPages();
$left = 25;


$pdf->SetXY(100,20);
$pdf->SetFont('Arial','B',12);
$pdf->MultiCell(160,5,'REKAPITULASI KONTRAK DANA TRANSFER
SKPD '.Yii::$app->user->identity['refSubUnit']['Nm_Sub_Unit'],'', 'C', 0);

$w = [8,50,30,15,50,20,70,30,30]; // Tentukan width masing-masing kolom
 
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(15,35);
$pdf->Cell($w['0'],12,'NO','LT',0,'C');
$pdf->Cell($w['1']+$w['2'],6,'DANA TRANSFER','BLTR',0,'C');
$pdf->Cell($w['3'],6,'KODE','LT',0,'C');
$pdf->Cell($w['4']+$w['5']+$w['6']+$w['7'],6,'KONTRAK','BLTR',0,'C');
$pdf->Cell($w['8'],12,'SISA PAGU','LTR',0,'C');
$pdf->ln();

$pdf->SetXY(15,41);
$pdf->Cell($w['0'],6,'','L',0,'C');
$pdf->Cell($w['1'],6,'JENIS','LR',0,'C');
$pdf->Cell($w['2'],6,'PAGU','LR',0,'C');
$pdf->Cell($w['3'],6,'KEG','LR',0,'C');
$pdf->Cell($w['4'],6,'NOMOR','LR',0,'C');
$pdf->Cell($w['5'],6,'TANGGAL','LR',0,'C');
$pdf->Cell($w['6'],6,'PEKERJAAN','LR',0,'C');
$pdf->Cell($w['7'],6,'NILAI','LR',0,'C');
$pdf->Cell($w['8'],6,'','LR',0,'C');
$pdf->ln();

$pdf->SetXY(15,46);
$pdf->Cell($w['0'],6,'1','LTB',0,'C');
$pdf->Cell($w['1'],6,'2','LTRB',0,'C');
$pdf->Cell($w['2'],6,'3','LTRB',0,'C');
$pdf->Cell($w['3'],6,'4','LTRB',0,'C');
$pdf->Cell($w['4'],6,'5','LTRB',0,'C');
$pdf->Cell($w['5'],6,'6','LTRB',0,'C');
$pdf->Cell($w['6'],6,'7','LTRB',0,'C');
$pdf->Cell($w['7'],6,'8','LTRB',0,'C');
$pdf->Cell($w['8'],6,'9','LTRB',0,'C');
$pdf->ln();

$y1 = $pdf->GetY(); // Untuk baris berikutnya
$y2 = $pdf->GetY(); //untuk baris berikutnya
$yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
$x = 15;
$kegiatan = NULL;
$i = 1;

$ysisa = $y1;

$total_pagu = 0;
$total_kontrak = 0;
$total_sisa = 0;

foreach($data as $data){

	IF($y2 > 196 || $y1 + (5*(strlen($data['Nm_Sub_Bidang'])/35)) > 196 ){ //cek pagebreak
		$ylst = 207 - $yst; //207 batas margin bawah dikurang dengan y pertama
		//setiap selesai page maka buat rectangle
		$pdf->Rect($x, $yst, $w['0'] ,$ylst);
		$pdf->Rect($x+$w['0'], $yst, $w['1'] ,$ylst);
		$pdf->Rect($x+$w['0']+$w['1'], $yst, $w['2'] ,$ylst);
		$pdf->Rect($x+$w['0']+$w['1']+$w['2'], $yst, $w['3'] ,$ylst);
		$pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3'], $yst, $w['4'] ,$ylst);
		$pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4'], $yst, $w['5'] ,$ylst);
		$pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4']+$w['5'], $yst ,$w['6'],$ylst);
		$pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4']+$w['5']+$w['6'], $yst, $w['7'],$ylst);
		$pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4']+$w['5']+$w['6']+$w['7'], $yst, $w['8'],$ylst);
	

		//setelah buat rectangle baru kemudian addPage
		$pdf->AddPage();
		$pdf->SetAutoPageBreak(true,10);
		$pdf->AliasNbPages();
		$left = 25;

		$pdf->SetFont('Arial','B',8);
		$pdf->SetXY(15,20);
		$pdf->Cell($w['0'],12,'NO','LT',0,'C');
		$pdf->Cell($w['1']+$w['2'],6,'DANA TRANSFER','BLTR',0,'C');
		$pdf->Cell($w['3'],6,'KODE','LT',0,'C');
		$pdf->Cell($w['4']+$w['5']+$w['6']+$w['7'],6,'KONTRAK','BLTR',0,'C');
		$pdf->Cell($w['8'],12,'SISA PAGU','LTR',0,'C');
		$pdf->ln();

		$pdf->Cell($w['0'],6,'','L',0,'C');
		$pdf->Cell($w['1'],6,'JENIS','LR',0,'C');
		$pdf->Cell($w['2'],6,'PAGU','LR',0,'C');
		$pdf->Cell($w['3'],6,'KEG','LR',0,'C');
		$pdf->Cell($w['4'],6,'NOMOR','LR',0,'C');
		$pdf->Cell($w['5'],6,'TANGGAL','LR',0,'C');
		$pdf->Cell($w['6'],6,'PEKERJAAN','LR',0,'C');
		$pdf->Cell($w['7'],6,'NILAI','LR',0,'C');
		$pdf->Cell($w['8'],6,'','LR',0,'C');
		$pdf->ln();

		$pdf->Cell($w['0'],6,'1','LTB',0,'C');
		$pdf->Cell($w['1'],6,'2','LTRB',0,'C');
		$pdf->Cell($w['2'],6,'3','LTRB',0,'C');
		$pdf->Cell($w['3'],6,'4','LTRB',0,'C');
		$pdf->Cell($w['4'],6,'5','LTRB',0,'C');
		$pdf->Cell($w['5'],6,'6','LTRB',0,'C');
		$pdf->Cell($w['6'],6,'7','LTRB',0,'C');
		$pdf->Cell($w['7'],6,'8','LTRB',0,'C');
		$pdf->Cell($w['8'],6,'9','LTRB',0,'C');
		$pdf->ln();

		$y1 = $pdf->GetY(); // Untuk baris berikutnya
		$y2 = $pdf->GetY(); //untuk baris berikutnya
		$yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
		$x = 15;
		$ysisa = $y1;

	}


	IF($y1>=$y2){
		$y = $y1;
	}ELSE{
		$y = $y2;
	}


	//new data		
	$pdf->SetXY($x, $y);
	$xcurrent= $x;
	$pdf->MultiCell($w['0'],6,$i,'T','C');
	$xcurrent = $xcurrent+$w['0'];
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['1'],6,$data['Nm_Sub_Bidang'],'T','L');
	$xcurrent = $xcurrent+$w['1'];
 	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['2'],6,number_format($data['Pagu'],0,',','.'),'T','R');
	$xcurrent = $xcurrent+$w['2'];
	$y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['3'],6,'','T','L');
	$xcurrent = $xcurrent+$w['3'];
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['4'],6,$data['No_Kontrak'],'T','L');
	$xcurrent = $xcurrent+$w['4'];
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['5'],6,'','T','L');
	$xcurrent = $xcurrent+$w['5'];
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['6'],6,'','T','L');
	$xcurrent = $xcurrent+$w['6'];
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['7'],6,number_format($data['Pagu_Kontrak'],0,',','.'),'T','R');
	$xcurrent = $xcurrent+$w['7'];
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['8'],6,number_format($data['Selisih_Pagu'],0,',','.'),'T','R');
	$xcurrent = $xcurrent+$w['8'];
	$pdf->SetXY($xcurrent, $y);
	
		
	$total_pagu = $total_pagu+$data['Pagu'];
	$total_kontrak = $total_kontrak+$data['Pagu_Kontrak'];
	$total_sisa = $total_sisa+$data['Selisih_Pagu'];
	$ysisa = $y;

	$i++; //Untuk urutan nomor
	$pdf->ln();


}

//membuat kotak di halaman terakhir
$y=$pdf->gety();
$ylst = $y - $yst;  //$y batas marjin bawah dikurangi dengan y pertama
$pdf->Rect($x, $yst, $w['0'] ,$ylst);
$pdf->Rect($x+$w['0'], $yst, $w['1'] ,$ylst);
$pdf->Rect($x+$w['0']+$w['1'], $yst, $w['2'] ,$ylst);
$pdf->Rect($x+$w['0']+$w['1']+$w['2'], $yst, $w['3'] ,$ylst);
$pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3'], $yst, $w['4'] ,$ylst);
$pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4'], $yst, $w['5'] ,$ylst);
$pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4']+$w['5'], $yst ,$w['6'],$ylst);
$pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4']+$w['5']+$w['6'], $yst, $w['7'],$ylst);
$pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4']+$w['5']+$w['6']+$w['7'], $yst, $w['8'],$ylst);




//Menampilkan jumlah halaman terakhir
$pdf->setxy($x,$y);
$pdf->Cell($w['0'],6,'',1);
$pdf->Cell($w['1'],6,'TOTAL',1,0,'C');
$pdf->Cell($w['2'],6,number_format($total_pagu,0,',','.'),1,0,'R');
$pdf->Cell($w['3'],6,'',1,0,'C');
$pdf->Cell($w['4'],6,'',1,0,'C');
$pdf->Cell($w['5'],6,'',1,0,'C');
$pdf->Cell($w['6'],6,'',1,0,'C');
$pdf->Cell($w['7'],6,number_format($total_kontrak,0,',','.'),1,0,'R');
$pdf->Cell($w['8'],6,number_format($total_sisa,0,',','.'),1,0,'R');
$pdf->ln();

//Menampilkan tanda tangan
$pdf->SetXY(255,$pdf->gety()+16);
$pdf->SetFont('Arial','B',10);
$pdf->MultiCell(255,5,'Pangkalan Balai, .... Januari 2016.', '', 'J', 0);
$pdf->SetXY(255,$pdf->gety());
$pdf->SetFont('Arial','B',10);
$pdf->MultiCell(255,5,'BUPATI BANYUASIN', '', 'j', 0);
$pdf->SetXY(255,$pdf->gety()+20);
$pdf->SetFont('Arial','B',10);
$pdf->MultiCell(255,5,'YAN ANTON FERDIAN', '', 'j', 0);
 
$pdf->Output();
exit;
?>