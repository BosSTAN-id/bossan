<?php
Use app\itbz\fpdf\src\fpdf\fpdf;


class PDF extends \fpdf\FPDF
{
	function Footer()
	{
		//ambil link
		$link = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];		
		// $this->Image("http://api.qrserver.com/v1/create-qr-code/?size=150x150&data=$link", 280, 203 ,5,0,'PNG');		
	    // Go to 1.5 cm from bottom
	    $this->SetY(-15);
	    // Select Times italic 8
	    $this->SetFont('Times','I',8);
	    // Print centered page number
	    $this->Cell(0,10,'Printed By BosSTAN | '.$this->PageNo().'/{nb}',0,0,'R');
	}

}

//menugaskan variabel $pdf pada function fpdf().
$pdf = new PDF('P','mm',array(216,330));
$link = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
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
$left = 15;


$pdf->SetXY($left,20);
$pdf->SetFont('Times','B',12);
switch ($getparam['Laporan']['Kd_Laporan']) {
	case 3:
		$pdf->MultiCell(215-(2*$left),5,'BUKU KAS UMUM', '', 'C', 0);
		break;
	case 4:
		$pdf->MultiCell(215-(2*$left),5,'BUKU PEMBANTU KAS', '', 'C', 0);
		break;
	case 5:
		$pdf->MultiCell(215-(2*$left),5,'BUKU PEMBANTU BANK', '', 'C', 0);
		break;
	default:
		$pdf->MultiCell(215-(2*$left),5,'BUKU KAS UMUM', '', 'C', 0);
		break;
}
$pdf->SetX($left);
$pdf->MultiCell(215-(2*$left),5, date('d/m/Y', strtotime($getparam['Laporan']['Tgl_1'])).' s.d. '.date('d/m/Y', strtotime($getparam['Laporan']['Tgl_2'])), '', 'C', 0);

$pdf->SetFont('Times','',10);
$pdf->SetXY($left,$pdf->GetY()+10);
$pdf->Cell(33,5,'Nama Sekolah','',0,'L');
$pdf->Cell(60,5,': '.$peraturan->sekolah->nama_sekolah,'',0,'L');
$pdf->SetFont('Times','B',10);
switch ($getparam['Laporan']['Kd_Laporan']) {
	case 3:
		$pdf->Cell(92,5,'Formulir BOS-K3',1,0,'C');
		break;
	case 4:
		$pdf->Cell(92,5,'Formulir BOS-K4',1,0,'C');
		break;
	case 5:
		$pdf->Cell(92,5,'Formulir BOS-K5',1,0,'C');
		break;
	default:
		$pdf->Cell(92,5,'Formulir BOS-K3',1,0,'C');
		break;
}
$pdf->ln();

$pdf->SetFont('Times','',10);
$pdf->SetXY(15,$pdf->GetY());
$pdf->Cell(33,5,'Desa/Kelurahan','',0,'L');
$pdf->Cell(60,5,': '.$peraturan->sekolah->refDesa->Nm_Desa,'',0,'L');
$pdf->Cell(92,5,'Diisi Oleh Sekolah','LR',0,'C');
$pdf->ln();

$pdf->SetFont('Times','',10);
$pdf->SetXY(15,$pdf->GetY());
$pdf->Cell(33,5,'Provinsi/Kabupaten','',0,'L');
$pdf->Cell(60,5,': '.\app\models\TaTh::dokudoku('bulat', $ref['set_8']),'',0,'L');
$pdf->Cell(92,5,'Dikirim ke Tim Manajemen BOS','LRB',0,'C');
$pdf->ln();


$w = [16, 20, 34, 55, 20, 20, 20]; // Tentukan width masing-masing kolom
 

// $pdf->SetFont('Times','B',10);
// $pdf->SetXY(15,$pdf->GetY()+6);
// $pdf->Cell($w['0'],5,'No.','LT',0,'C');
// $pdf->Cell($w['1'],5,'Uraian','LTR',0,'C');
// $pdf->Cell($w['2'],5,'Jumlah','LTR',0,'C');
// $pdf->Cell($w['3']+$w['4']+$w['5']+$w['6'],5,'TRIWULAN','LTR',0,'C');
// $pdf->ln();

$pdf->SetFont('Times','B',10);
$pdf->SetXY(15,$pdf->GetY()+6);
$pdf->Cell($w['0'],5,'Tanggal','LT',0,'C');
$pdf->Cell($w['1'],5,'No. Kode','LTR',0,'C');
$pdf->Cell($w['2'],5,'No Bukti','LTR',0,'C');
$pdf->Cell($w['3'],5,'Uraian','LTR',0,'C');
$pdf->Cell($w['4'],5,'Debet','LTR',0,'C');
$pdf->Cell($w['5'],5,'Kredit','LTR',0,'C');
$pdf->Cell($w['6'],5,'Saldo','LTR',0,'C');
$pdf->ln();

$pdf->SetFont('Times','B',10);
$pdf->SetXY(15,$pdf->GetY());
$pdf->Cell($w['0'],5,'1','LTB',0,'C');
$pdf->Cell($w['1'],5,'2','LTRB',0,'C');
$pdf->Cell($w['2'],5,'3','LTRB',0,'C');
$pdf->Cell($w['3'],5,'4','LTRB',0,'C');
$pdf->Cell($w['4'],5,'5','LTRB',0,'C');
$pdf->Cell($w['5'],5,'6','LTRB',0,'C');
$pdf->Cell($w['6'],5,'7','LTRB',0,'C');
$pdf->ln();


$baris1 = $y1 = $pdf->GetY(); // Untuk baris berikutnya
$y2 = $pdf->GetY(); //untuk baris berikutnya
$y3 = $pdf->GetY(); //untuk baris berikutnya
$yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
$x = $left;
$program = NULL;
$subprogram = NULL;
$kegiatan = NULL;
$rek1 = NULL;
$i = 1;

$ysisa = $y1;

$totaldb = 0;
$totalkr = 0;
$totalsaldo = 0;

foreach($data as $model){

    $totalsaldo = $totalsaldo + $model['nilai'];

	$y = MAX($y1, $y2, $y3);

	IF($y2 > 196 || $y1 + (5*(strlen($model['keterangan'])/35)) > 180 ){ //cek pagebreak
		$ylst = 190 - $yst; //207 batas margin bawah dikurang dengan y pertama
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

        $pdf->SetFont('Times','B',10);
        $pdf->SetXY(15,$pdf->GetY()+6);
        $pdf->Cell($w['0'],5,'Tanggal','LT',0,'C');
        $pdf->Cell($w['1'],5,'No. Kode','LTR',0,'C');
        $pdf->Cell($w['2'],5,'No Bukti','LTR',0,'C');
        $pdf->Cell($w['3'],5,'Uraian','LTR',0,'C');
        $pdf->Cell($w['4'],5,'Debet','LTR',0,'C');
        $pdf->Cell($w['5'],5,'Kredit','LTR',0,'C');
        $pdf->Cell($w['6'],5,'Saldo','LTR',0,'C');
        $pdf->ln();

        $pdf->SetFont('Times','B',10);
        $pdf->SetXY(15,$pdf->GetY());
        $pdf->Cell($w['0'],5,'1','LTB',0,'C');
        $pdf->Cell($w['1'],5,'2','LTRB',0,'C');
        $pdf->Cell($w['2'],5,'3','LTRB',0,'C');
        $pdf->Cell($w['3'],5,'4','LTRB',0,'C');
        $pdf->Cell($w['4'],5,'5','LTRB',0,'C');
        $pdf->Cell($w['5'],5,'6','LTRB',0,'C');
        $pdf->Cell($w['6'],5,'7','LTRB',0,'C');
        $pdf->ln();


		$y1 = $pdf->GetY(); // Untuk baris berikutnya
		$y2 = $pdf->GetY(); //untuk baris berikutnya
		$y3 = $pdf->GetY(); //untuk baris berikutnya
		$yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
		$x = 15;
		$ysisa = $y1;

	}



    $pdf->SetFont('Times','',8);
	//new data		
	$pdf->SetXY($x, $y);
	$xcurrent= $x;
    $pdf->MultiCell($w['0'],5,date('d-m-Y', strtotime($model['tgl_bukti'])),'','R');
	$xcurrent = $xcurrent+$w['0'];
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['1'],5,$model['kode'],'','C');
    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
	$xcurrent = $xcurrent+$w['1'];
 	$pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w['2'],5,$model['no_bukti'],'','L');
    $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
	$xcurrent = $xcurrent+$w['2'];
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['3'],5,$model['keterangan'] ,'','L');
    $y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
	$xcurrent = $xcurrent+$w['3'];
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['4'],5,$model['nilai'] >= 0 ? number_format($model['nilai'],0,',','.') : '','','R');
	$xcurrent = $xcurrent+$w['4'];
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['5'],5,$model['nilai'] < 0 ? number_format(-$model['nilai'],0,',','.') : '','','R');
	$xcurrent = $xcurrent+$w['5'];
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['6'],5,number_format($totalsaldo,0,',','.'),'','R');
	$xcurrent = $xcurrent+$w['6'];
	$pdf->SetXY($xcurrent, $y);
	
	$ysisa = $y;

	$i++; //Untuk urutan nomor
	$pdf->ln();

    IF($model['nilai'] > 0){
        $totaldb = $totaldb + $model['nilai'];
    }ELSE{
        $totalkr = $totalkr - $model['nilai'];
    }

}

$y = max($y1, $y2);
// //subtotal
// $pdf->SetFont('Times','U',10);
// //new data		
// $pdf->SetXY($x, $y);
// $xcurrent= $x;
// $pdf->MultiCell($w['0'],6, '','BLT','R');
// $xcurrent = $xcurrent+$w['0'];
// $pdf->SetXY($xcurrent, $y);
// $pdf->MultiCell($w['1'],6,'Subtotal','BT','L');
// $xcurrent = $xcurrent+$w['1'];
// $pdf->SetXY($xcurrent, $y);
// $pdf->MultiCell($w['2'],6,'','BT','R');
// $xcurrent = $xcurrent+$w['2'];
// $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
// $pdf->SetXY($xcurrent, $y);
// $pdf->MultiCell($w['3'],6,'','BT','R');
// $xcurrent = $xcurrent+$w['3'];
// $pdf->SetXY($xcurrent, $y);
// $pdf->MultiCell($w['4'],6,number_format($totaldb,0,',','.'),'BT','R');
// $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
// $xcurrent = $xcurrent+$w['4'];
// $pdf->SetXY($xcurrent, $y);
// $pdf->MultiCell($w['5'],6,number_format($totalkr,0,',','.'),'BT','R');
// $xcurrent = $xcurrent+$w['5'];
// $pdf->SetXY($xcurrent, $y);
// $pdf->MultiCell($w['6'],6,number_format($totalsaldo,0,',','.'),'BTR','R');
// $xcurrent = $xcurrent+$w['6'];
// $pdf->SetXY($xcurrent, $y);    
// $ysisa = $y;
// $pdf->ln();
// $y = max($y1, $y2);

//membuat kotak di halaman terakhir
$y = MAX($y1, $y2, $y3);
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
$pdf->SetFont('Times','BU',9);
$pdf->Cell($w['0'],6,'','LB');
$pdf->Cell($w['1'],6,'TOTAL','LB',0,'C');
$pdf->Cell($w['2'],6,'','BL',0,'R');
$pdf->Cell($w['3'],6,'','BL',0,'R');
$pdf->Cell($w['4'],6,number_format($totaldb,0,',','.'),'BL',0,'R');
$pdf->Cell($w['5'],6,number_format($totalkr,0,',','.'),'BL',0,'R');
$pdf->Cell($w['6'],6,number_format($totalsaldo,0,',','.'),1,0,'R');

//Menampilkan tanda tangan
// Penandatangan Bendahara
$bendahara = \app\models\TaSekolahJab::find()->andWhere(['tahun' => $Tahun, 'sekolah_id' => Yii::$app->user->identity->sekolah_id])->andWhere('jabatan LIKE \'%bendahara%\'')->one();

IF(($pdf->gety()+6) >= 175) $pdf->AddPage();
$y = $pdf->getY()+10;
$pdf->SetXY(125,$y);
$pdf->SetFont('Times','',10);
$pdf->MultiCell(100,5,$peraturan->sekolah->refKecamatan->Nm_Kecamatan.', '.DATE('j', strtotime($getparam['Laporan']['Tgl_Laporan'])).' '.bulan(DATE('m', strtotime($getparam['Laporan']['Tgl_Laporan']))).' '.DATE('Y', strtotime($getparam['Laporan']['Tgl_Laporan'])), '', 'J', 0);
$pdf->SetXY(125,$pdf->gety());
$pdf->SetFont('Times','',10);
$pdf->MultiCell(100,5,$bendahara['jabatan'], '', 'j', 0);
$pdf->SetXY(125,$pdf->gety()+15);
$pdf->SetFont('Times','',10);
$pdf->MultiCell(100,5,$bendahara['nama'], '', 'j', 0);
$pdf->SetX(125);
$pdf->MultiCell(100,5,'NIP '.$bendahara['nip'], '', 'j', 0);

$pdf->SetXY(15,$y);
$pdf->SetFont('Times','',10);
$pdf->MultiCell(100,5,'Mengetahui,', '', 'j', 0);
$pdf->SetXY(15,$pdf->gety());
$pdf->SetFont('Times','',10);
$pdf->MultiCell(100,5,$peraturan['jabatan'], '', 'j', 0);
$pdf->SetXY(15,$pdf->gety()+15);
$pdf->SetFont('Times','',10);
$pdf->MultiCell(100,5,$peraturan['penandatangan'] == NULL ? '-' : $peraturan['penandatangan'], '', 'j', 0);
$pdf->SetXY(15,$pdf->gety());
$pdf->SetFont('Times','',10);
$pdf->MultiCell(100,5,$peraturan['nip'] == NULL ? '-' : $peraturan['nip'], '', 'j', 0);


//Untuk mengakhiri dokumen pdf, dan mengirim dokumen ke output
$pdf->Output();
exit;
?>