<?php
Use app\itbz\fpdf\src\fpdf\fpdf;


class PDF extends \fpdf\FPDF
{
    function setFooterSumberDana($footerSumberDana){
        $this->footerSumberDana = $footerSumberDana;
    }

    function Footer()
    {

        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,'Printed By BosSTAN '.$this->PageNo().'/{nb}',0,0,'R');
        $this->Image(\yii\helpers\Url::to(['/site/qr', 'url' => Yii::$app->request->absoluteUrl], true), $this->getX()-55, $this->getY()-5 , 15, 0,'PNG'); // 156, 320
        if($this->footerSumberDana){
            $this->SetX(15);
            $this->Cell(0,10,'Laporan ini memuat Anggaran dari '.$this->footerSumberDana->kdPenerimaan1->uraian_penerimaan_1.' - '.$this->footerSumberDana->uraian,0,0,'L');
        }
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

$pdf->setFooterSumberDana($footerSumberDana);
$border = 0;
$pdf->AddPage();
$pdf->SetAutoPageBreak(true,10);
$pdf->AliasNbPages();
$left = 15;


$pdf->SetXY($left,20);
$pdf->SetFont('Times','B',12);
$pdf->MultiCell(215-(2*$left),5,'RENCANA PENGGUNAAN DANA BOS PERIODE '.$Tahun, '', 'C', 0);
$pdf->SetX($left);
$pdf->MultiCell(215-(2*$left),5, date('d/m/Y', strtotime($getparam['Laporan']['Tgl_1'])).' s.d. '.date('d/m/Y', strtotime($getparam['Laporan']['Tgl_2'])), '', 'C', 0);

$pdf->SetFont('Times','',10);
$pdf->SetXY($left,$pdf->GetY()+10);
$pdf->Cell(33,5,'Nama Sekolah','',0,'L');
$pdf->Cell(60,5,': '.$peraturan->sekolah->nama_sekolah,'',0,'L');
$pdf->SetFont('Times','B',10);
$pdf->Cell(92,5,'Formulir BOS-03',1,0,'C');
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


$w = [10, 15, 130, 30]; // Tentukan width masing-masing kolom
 

$pdf->SetFont('Times','B',10);
$pdf->SetXY(15,$pdf->GetY()+6);
$pdf->Cell($w['0'],5,'No','LT',0,'C');
$pdf->Cell($w['1'],5,'Kode','LTR',0,'C');
$pdf->Cell($w['2'],5,'Komponen','LTR',0,'C');
$pdf->Cell($w['3'],5,'Jumlah Dana','LTR',0,'C');
$pdf->ln();


$baris1 = $y1 = $pdf->GetY(); // Untuk baris berikutnya
$y2 = $pdf->GetY(); //untuk baris berikutnya
$y3 = $pdf->GetY(); //untuk baris berikutnya
$yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
$x = $left;
$rek1 = NULL;
$i = 1;

$ysisa = $y1;

$totalsaldo = 0;

foreach($data as $model){

    $totalsaldo = $totalsaldo + $model['anggaran'];

	$y = MAX($y1, $y2, $y3);

	IF($y2 > 196 || $y1 + (5*(strlen($model['komponen'])/35)) > 180 ){ //cek pagebreak
		$ylst = 190 - $yst; //207 batas margin bawah dikurang dengan y pertama
		//setiap selesai page maka buat rectangle
		$pdf->Rect($x, $yst, $w['0'] ,$ylst);
		$pdf->Rect($x+$w['0'], $yst, $w['1'] ,$ylst);
		$pdf->Rect($x+$w['0']+$w['1'], $yst, $w['2'] ,$ylst);
		$pdf->Rect($x+$w['0']+$w['1']+$w['2'], $yst, $w['3'] ,$ylst);
		
		//setelah buat rectangle baru kemudian addPage
		$pdf->AddPage();
		$pdf->SetAutoPageBreak(true,10);
		$pdf->AliasNbPages();
		$left = 25;

		$pdf->SetFont('Times','B',10);
		$pdf->SetXY(15,$pdf->GetY()+6);
		$pdf->Cell($w['0'],5,'No','LT',0,'C');
		$pdf->Cell($w['1'],5,'Kode','LTR',0,'C');
		$pdf->Cell($w['2'],5,'Komponen','LTR',0,'C');
		$pdf->Cell($w['3'],5,'Jumlah Dana','LTR',0,'C');
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
    $pdf->MultiCell($w['0'],5,$i,'','R');
	$xcurrent = $xcurrent+$w['0'];
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['1'],5,$model['komponen_id'],'','C');
    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
	$xcurrent = $xcurrent+$w['1'];
 	$pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w['2'],5,$model['komponen'],'','L');
    $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
	$xcurrent = $xcurrent+$w['2'];
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['3'],5,number_format($model['anggaran'],0,',','.') ,'','R');
    $y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
	$xcurrent = $xcurrent+$w['3'];
	
	$ysisa = $y;

	$i++; //Untuk urutan nomor
	$pdf->ln();

}

$y = max($y1, $y2);

//membuat kotak di halaman terakhir
$y = MAX($y1, $y2, $y3);
$ylst = $y - $yst;  //$y batas marjin bawah dikurangi dengan y pertama
$pdf->Rect($x, $yst, $w['0'] ,$ylst);
$pdf->Rect($x+$w['0'], $yst, $w['1'] ,$ylst);
$pdf->Rect($x+$w['0']+$w['1'], $yst, $w['2'] ,$ylst);
$pdf->Rect($x+$w['0']+$w['1']+$w['2'], $yst, $w['3'] ,$ylst);


//Menampilkan jumlah halaman terakhir
$pdf->setxy($x,$y);
$pdf->SetFont('Times','BU',9);
$pdf->Cell($w['0'],6,'','LB');
$pdf->Cell($w['1'],6,'TOTAL','LB',0,'C');
$pdf->Cell($w['2'],6,'','BL',0,'R');
$pdf->Cell($w['3'],6,number_format($totalsaldo,0,',','.'),'BLR',0,'R');


//Menampilkan tanda tangan
IF(($pdf->gety()+6) >= 275) $pdf->AddPage();
$pdf->SetXY(115,$pdf->gety()+10);
$pdf->SetFont('Times','',10);
$pdf->MultiCell(100,5,$peraturan->sekolah->refKecamatan->Nm_Kecamatan.', '.DATE('j', strtotime($peraturan['tgl_peraturan'])).' '.bulan(DATE('m', strtotime($peraturan['tgl_peraturan']))).' '.DATE('Y', strtotime($peraturan['tgl_peraturan'])), '', 'J', 0);
$y = $pdf->getY();
$pdf->SetXY(115,$pdf->gety());
$pdf->SetFont('Times','',10);
$pdf->MultiCell(100,5,'Menyetujui,', '', 'j', 0);
$pdf->SetXY(115,$pdf->gety());
$pdf->SetFont('Times','',10);
$pdf->MultiCell(100,5,$peraturan['jabatan'], '', 'j', 0);
$pdf->SetXY(115,$pdf->gety()+15);
$pdf->SetFont('Times','',10);
$pdf->MultiCell(100,5,$peraturan['penandatangan'], '', 'j', 0);
$pdf->SetX(115);
$pdf->MultiCell(100,5,'NIP '.$peraturan['nip'], '', 'j', 0);

$pdf->SetXY(15,$y);
$pdf->SetFont('Times','',10);
$pdf->MultiCell(100,5,'Mengetahui,', '', 'j', 0);
$pdf->SetXY(15,$pdf->gety());
$pdf->SetFont('Times','',10);
$pdf->MultiCell(100,5,$peraturan['jabatan_komite'], '', 'j', 0);
$pdf->SetXY(15,$pdf->gety()+15);
$pdf->SetFont('Times','',10);
$pdf->MultiCell(100,5,$peraturan['komite_sekolah'] == NULL ? '-' : $peraturan['komite_sekolah'], '', 'j', 0);



//Untuk mengakhiri dokumen pdf, dan mengirim dokumen ke output
$pdf->Output();
exit;
?>