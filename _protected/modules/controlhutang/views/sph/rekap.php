<?php
Use app\itbz\fpdf\src\fpdf\fpdf;

//menugaskan variabel $pdf pada function fpdf().
$pdf = new \fpdf\FPDF('L','mm',array(216,330));

//Menambahkan halaman, untuk menambahkan halaman tambahkan command ini. 
//P artinya potrait dan L artinya Landscape
function bulan($bulan){
	Switch ($bulan){
	    case 1 : $bulan="Januari";
	        Break;
	    case 2 : $bulan="Februari";
	        Break;
	    case 3 : $bulan="Maret";
	        Break;
	    case 4 : $bulan="April";
	        Break;
	    case 5 : $bulan="Mei";
	        Break;
	    case 6 : $bulan="Juni";
	        Break;
	    case 7 : $bulan="Juli";
	        Break;
	    case 8 : $bulan="Agustus";
	        Break;
	    case 9 : $bulan="September";
	        Break;
	    case 10 : $bulan="Oktober";
	        Break;
	    case 11 : $bulan="November";
	        Break;
	    case 12 : $bulan="Desember";
	        Break;
	    }
	return $bulan;
}


function kekata($x) {
    $x = abs($x);
    $angka = array("", "satu", "dua", "tiga", "empat", "lima",
    "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($x <12) {
        $temp = " ". $angka[$x];
    } else if ($x <20) {
        $temp = kekata($x - 10). " belas";
    } else if ($x <100) {
        $temp = kekata($x/10)." puluh". kekata($x % 10);
    } else if ($x <200) {
        $temp = " seratus" . kekata($x - 100);
    } else if ($x <1000) {
        $temp = kekata($x/100) . " ratus" . kekata($x % 100);
    } else if ($x <2000) {
        $temp = " seribu" . kekata($x - 1000);
    } else if ($x <1000000) {
        $temp = kekata($x/1000) . " ribu" . kekata($x % 1000);
    } else if ($x <1000000000) {
        $temp = kekata($x/1000000) . " juta" . kekata($x % 1000000);
    } else if ($x <1000000000000) {
        $temp = kekata($x/1000000000) . " milyar" . kekata(fmod($x,1000000000));
    } else if ($x <1000000000000000) {
        $temp = kekata($x/1000000000000) . " trilyun" . kekata(fmod($x,1000000000000));
    }     
        return $temp;
}
 
 
function terbilang($x, $style=4) {
    if($x<0) {
        $hasil = "minus ". trim(kekata($x));
    } else {
        $hasil = trim(kekata($x));
    }     
    switch ($style) {
        case 1:
            $hasil = strtoupper($hasil);
            break;
        case 2:
            $hasil = strtolower($hasil);
            break;
        case 3:
            $hasil = ucwords($hasil);
            break;
        default:
            $hasil = ucfirst($hasil);
            break;
    }     
    return $hasil;
}

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
$pdf->MultiCell(150,5,ISSET(Yii::$app->user->identity->refSubUnit->Nm_Sub_Unit) ? 'REKAPITULASI SURAT PENGAKUAN HUTANG '.strtoupper(Yii::$app->user->identity->refSubUnit->Nm_Sub_Unit) : 'REKAPITULASI SURAT PENGAKUAN HUTANG
SKPD '.strtoupper('Semua'), '', 'C', 0);
$pdf->SetX(100);
$pdf->MultiCell(150,5, 'TAHUN '.$ttd->Tahun, '', 'C', 0);

$w = [10,50,55,25,80,50,30]; // Tentukan width masing-masing kolom
 
$pdf->SetFont('Arial','B',10);
$pdf->SetXY(15,35);
$pdf->Cell($w['0'],11,'NO','LT',0,'C');
$pdf->Cell($w['1'],11,'NOMOR SPH','LTR',0,'C');
$pdf->Cell($w['2'],11,'NOMOR KONTRAK','LTR',0,'C');
$pdf->Cell($w['3'],11,'TANGGAL','LTR',0,'C');
$pdf->Cell($w['4'],11,'PEKERJAAN','LTR',0,'C');
$pdf->Cell($w['5'],11,'NAMA REKANAN','LTR',0,'C');
$pdf->Cell($w['6'],11,'JUMLAH','LTR',0,'C');
$pdf->ln();

$pdf->SetFont('Arial','B',10);
$pdf->SetXY(15,41);
$pdf->Cell($w['0'],6,'','L',0,'C');
$pdf->Cell($w['1'],6,'','LR',0,'C');
$pdf->Cell($w['2'],6,'','LR',0,'C');
$pdf->Cell($w['3'],6,'','LR',0,'C');
$pdf->Cell($w['4'],6,'','LR',0,'C');
$pdf->Cell($w['5'],6,'','LR',0,'C');
$pdf->Cell($w['6'],6,'','LR',0,'C');
$pdf->ln();

$pdf->SetFont('Arial','B',10);
$pdf->SetXY(15,46);
$pdf->Cell($w['0'],6,'1','LTB',0,'C');
$pdf->Cell($w['1'],6,'2','LTRB',0,'C');
$pdf->Cell($w['2'],6,'3','LTRB',0,'C');
$pdf->Cell($w['3'],6,'4','LTRB',0,'C');
$pdf->Cell($w['4'],6,'5','LTRB',0,'C');
$pdf->Cell($w['5'],6,'6','LTRB',0,'C');
$pdf->Cell($w['6'],6,'8','LTRB',0,'C');
$pdf->ln();

$y1 = $pdf->GetY(); // Untuk baris berikutnya
$y2 = $pdf->GetY(); //untuk baris berikutnya
$yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
$x = 15;
$kegiatan = NULL;
$i = 1;

$ysisa = $y1;

$totalhutang = 0;


foreach($model as $model){

	IF($y2 > 196 || $y1 + (5*(strlen($model['Nm_Rekanan'])/35)) > 196 ){ //cek pagebreak
		$ylst = 207 - $yst; //207 batas margin bawah dikurang dengan y pertama
		//setiap selesai page maka buat rectangle
		$pdf->Rect($x, $yst, $w['0'] ,$ylst);
		$pdf->Rect($x+$w['0'], $yst, $w['1'] ,$ylst);
		$pdf->Rect($x+$w['0']+$w['1'], $yst, $w['2'] ,$ylst);
		$pdf->Rect($x+$w['0']+$w['1']+$w['2'], $yst, $w['3'] ,$ylst);
		$pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3'], $yst, $w['4'] ,$ylst);
		$pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4'], $yst, $w['5'] ,$ylst);
		$pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4']+$w['5'], $yst ,$w['6'],$ylst);
		
		//setelah buat rectangle baru kemudian addPage
		$pdf->AddPage();
		$pdf->SetAutoPageBreak(true,10);
		$pdf->AliasNbPages();
		$left = 25;

		$pdf->SetFont('Arial','B',10);
		$pdf->SetXY(15,20);
		$pdf->Cell($w['0'],11,'NO','LT',0,'C');
		$pdf->Cell($w['1'],11,'NOMOR SPH','LTR',0,'C');
		$pdf->Cell($w['2'],11,'NOMOR KONTRAK','LTR',0,'C');
		$pdf->Cell($w['3'],11,'TANGGAL','LTR',0,'C');
		$pdf->Cell($w['4'],11,'PEKERJAAN','LTR',0,'C');
		$pdf->Cell($w['5'],11,'NAMA REKANAN','LTR',0,'C');
		$pdf->Cell($w['6'],11,'NILAI KONTRAK','LTR',0,'C');
		$pdf->ln();

		$pdf->SetFont('Arial','B',10);
		$pdf->SetXY(15,26);
		$pdf->Cell($w['0'],6,'','L',0,'C');
		$pdf->Cell($w['1'],6,'','LR',0,'C');
		$pdf->Cell($w['2'],6,'','LR',0,'C');
		$pdf->Cell($w['3'],6,'','LR',0,'C');
		$pdf->Cell($w['4'],6,'','LR',0,'C');
		$pdf->Cell($w['5'],6,'','LR',0,'C');
		$pdf->Cell($w['6'],6,'','LR',0,'C');
		$pdf->ln();

		$pdf->SetFont('Arial','B',10);
		$pdf->SetXY(15,32);
		$pdf->Cell($w['0'],6,'1','LTB',0,'C');
		$pdf->Cell($w['1'],6,'2','LTRB',0,'C');
		$pdf->Cell($w['2'],6,'3','LTRB',0,'C');
		$pdf->Cell($w['3'],6,'4','LTRB',0,'C');
		$pdf->Cell($w['4'],6,'5','LTRB',0,'C');
		$pdf->Cell($w['5'],6,'6','LTRB',0,'C');
		$pdf->Cell($w['6'],6,'8','LTRB',0,'C');
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
	$pdf->MultiCell($w['1'],6,$model['No_SPH'],'T','L');
	$xcurrent = $xcurrent+$w['1'];
 	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['2'],6,$model['No_Kontrak'],'T','L');
	$xcurrent = $xcurrent+$w['2'];
	$y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['3'],6,date('d-m-Y', strtotime($model['Tgl_Kontrak'])),'T','C');
	$xcurrent = $xcurrent+$w['3'];
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['4'],6,$model['Pekerjaan'],'T','L');
	$y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
	$xcurrent = $xcurrent+$w['4'];
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['5'],6,$model['Nm_Perusahaan'],'T','L');
	$xcurrent = $xcurrent+$w['5'];
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['6'],6,number_format($model['Nilai'],0,',','.'),'T','R');
	$xcurrent = $xcurrent+$w['6'];
	$pdf->SetXY($xcurrent, $y);

	
	$totalhutang = $totalhutang+$model['Nilai'];
	
	$ysisa = $y;

	$i++; //Untuk urutan nomor
	$pdf->ln();
	$kepala = $model['Nm_Kepala_SKPD'];


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
$pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4']+$w['5'],$yst, $w['6'],$ylst);


//Menampilkan jumlah halaman terakhir
$pdf->setxy($x,$y);
$pdf->Cell($w['0'],6,'','LB');
$pdf->Cell($w['1'],6,'','B',0,'C');
$pdf->Cell($w['2'],6,'TOTAL','B',0,'C');
$pdf->Cell($w['3'],6,'','B',0,'C');
$pdf->Cell($w['4'],6,'','B',0,'C');
$pdf->Cell($w['5'],6,'','B',0,'C');
$pdf->Cell($w['6'],6,number_format($totalhutang,0,',','.'),1,0,'R');

$pdf->ln();

//Menampilkan tanda tangan
$pdf->SetXY(255,$pdf->gety()+16);
$pdf->SetFont('Arial','B',10);
$pdf->MultiCell(255,5,'Pangkalan Balai, '.DATE('j').' '.bulan(DATE('m')).' '.DATE('Y'), '', 'J', 0);
$pdf->SetXY(255,$pdf->gety());
$pdf->SetFont('Arial','B',10);
$pdf->MultiCell(255,5,$ttd['Jbt_Pimpinan'], '', 'j', 0);
$pdf->SetXY(255,$pdf->gety()+20);
$pdf->SetFont('Arial','B',10);
$pdf->MultiCell(255,5,$ttd['Nm_Pimpinan'], '', 'j', 0);
$pdf->SetX(255);
$pdf->MultiCell(255,5,'NIP '.$ttd['Nip_Pimpinan'], '', 'j', 0);
 
//Untuk mengakhiri dokumen pdf, dan mengirip dokumen ke output
$pdf->Output();
exit;
?>