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
$pdf = new PDF('L','mm',array(216,330));
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
$left = 25;


$pdf->SetXY(10,20);
$pdf->SetFont('Arial','B',12);
$pdf->MultiCell(310,5,'REALISASI PENGGUNAAN DANA TIAP JENIS ANGGARAN', '', 'C', 0);
$pdf->SetX(10);
$pdf->MultiCell(310,5, 'TAHUN ANGGARAN '.$Tahun, '', 'C', 0);

$pdf->SetFont('Arial','B',10);
$pdf->SetXY(15,$pdf->GetY()+10);
$pdf->Cell(40,5,'Nama Sekolah','',0,'L');
$pdf->Cell(110,5,': '.$peraturan->sekolah->nama_sekolah,'',0,'L');
$pdf->Cell(140,5,'Formulir BOS-K7A',1,0,'C');
$pdf->ln();

$pdf->SetFont('Arial','B',10);
$pdf->SetXY(15,$pdf->GetY());
$pdf->Cell(40,5,'Desa/Kelurahan','',0,'L');
$pdf->Cell(110,5,': '.$peraturan->sekolah->refDesa->Nm_Desa,'',0,'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(140,5,'Diisi Oleh Sekolah','LR',0,'C');
$pdf->ln();

$pdf->SetFont('Arial','B',10);
$pdf->SetXY(15,$pdf->GetY());
$pdf->Cell(40,5,'Provinsi/Kabupaten','',0,'L');
$pdf->Cell(110,5,': '.\app\models\TaTh::dokudoku('bulat', $ref['set_8']),'',0,'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(140,5,'Dikirim ke Tim Manajemen BOS','LRB',0,'C');
$pdf->ln();


$w = [10, 35, 20, 15, 15, 15, 15, 15, 15, 15, 15, 15, 15, 15, 15, 15, 15, 20]; // Tentukan width masing-masing kolom
 

$pdf->SetFont('Times','B',8);
$pdf->SetXY(15,$pdf->GetY()+6);
$pdf->Cell($w['0'],5,'No','LT',0,'C');
$pdf->Cell($w['1'],5,'Program','LTR',0,'C');
$pdf->Cell($w['2'],5,'Anggaran','LTR',0,'C');
$pdf->Cell($w['3']+$w['4']+$w['5']+$w['6']+$w['7']+$w['8']+$w['9']+$w['10']+$w['11']+$w['12']+$w['13']+$w['14']+$w['15']+$w['16'],5,'Komponen Penggunaan Dana BOS','LTR',0,'C');
$pdf->Cell($w['17'],5,'','LTR',0,'C');
$pdf->ln();

$pdf->SetFont('Times','B',8);
$pdf->SetXY(15,$pdf->GetY());
$pdf->Cell($w['0'],5,'Kode','L',0,'C');
$pdf->Cell($w['1'],5,'Uraian','LR',0,'C');
$pdf->Cell($w['2'],5,'(dalam Rp)','LR',0,'C');
$pdf->SetFont('Times','B',6);
$pdf->Cell($w['3'],5,'Pengembangan','LTR',0,'C');
$pdf->Cell($w['4'],5,'Penerimaan','LTR',0,'C');
$pdf->Cell($w['5'],5,'Pembelajaran','LTR',0,'C');
$pdf->Cell($w['6'],5,'Ulangan','LTR',0,'C');
$pdf->Cell($w['7'],5,'Bahan Pakai','LTR',0,'C');
$pdf->Cell($w['8'],5,'Langganan','LTR',0,'C');
$pdf->Cell($w['9'],5,'Perawatan','LTR',0,'C');
$pdf->Cell($w['10'],5,'Honor Guru &','LTR',0,'C');
$pdf->Cell($w['11'],5,'Pengembangan','LTR',0,'C');
$pdf->Cell($w['12'],5,'Membantu','LTR',0,'C');
$pdf->Cell($w['13'],5,'Pengelolaan','LTR',0,'C');
$pdf->Cell($w['14'],5,'Perangkat','LTR',0,'C');
$pdf->Cell($w['15'],5,'Biaya','LTR',0,'C');
$pdf->Cell($w['16'],5,'Tanpa','LTR',0,'C');
$pdf->SetFont('Times','B',8);
$pdf->Cell($w['17'],5,'Jumlah','LR',0,'C');
$pdf->ln();

$pdf->SetFont('Times','B',8);
$pdf->SetXY(15,$pdf->GetY());
$pdf->Cell($w['0'],3,'','L',0,'C');
$pdf->Cell($w['1'],3,'','LR',0,'C');
$pdf->Cell($w['2'],3,'','LR',0,'C');
$pdf->SetFont('Times','B',6);
$pdf->Cell($w['3'],3,'Perpustakaan','LR',0,'C');
$pdf->Cell($w['4'],3,'Siswa Baru','LR',0,'C');
$pdf->Cell($w['5'],3,'& Ekskul','LR',0,'C');
$pdf->Cell($w['6'],3,'& Ujian','LR',0,'C');
$pdf->Cell($w['7'],3,'Habis','LR',0,'C');
$pdf->Cell($w['8'],3,'Daya & Jasa','LR',0,'C');
$pdf->Cell($w['9'],3,'Sekolah','LR',0,'C');
$pdf->Cell($w['10'],3,'Tenaga Pendidik','LR',0,'C');
$pdf->Cell($w['11'],3,'Profesi Guru','LR',0,'C');
$pdf->Cell($w['12'],3,'Siswa Miskin','LR',0,'C');
$pdf->Cell($w['13'],3,'BOS','LR',0,'C');
$pdf->Cell($w['14'],3,'Komputer','LR',0,'C');
$pdf->Cell($w['15'],3,'Lainnya','LR',0,'C');
$pdf->Cell($w['16'],3,'Kategori','LR',0,'C');
$pdf->Cell($w['17'],3,'','LR',0,'C');
$pdf->ln();


$baris1 = $y1 = $pdf->GetY(); // Untuk baris berikutnya
$y2 = $pdf->GetY(); //untuk baris berikutnya
$y3 = $pdf->GetY(); //untuk baris berikutnya
$yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
$x = 15;
$program = NULL;
$subprogram = NULL;
$kegiatan = NULL;
$rek1 = NULL;
$i = 1;

$ysisa = $y1;

$totalanggaran = 0;
$totalkomponen1 = 0;
$totalkomponen2 = 0;
$totalkomponen3 = 0;
$totalkomponen4 = 0;
$totalkomponen5 = 0;
$totalkomponen6 = 0;
$totalkomponen7 = 0;
$totalkomponen8 = 0;
$totalkomponen9 = 0;
$totalkomponen10 = 0;
$totalkomponen11 = 0;
$totalkomponen12 = 0;
$totalkomponen13 = 0;
$totalkomponenlain = 0;
$totaljumlah = 0;

foreach($data as $model){

	$y = MAX($y1, $y2, $y3);

	IF($y2 > 196 || $y1 + (5*(strlen($model['uraian_program'])/35)) > 180 ){ //cek pagebreak
		$ylst = 190 - $yst; //207 batas margin bawah dikurang dengan y pertama
		//setiap selesai page maka buat rectangle
		$pdf->Rect($x, $yst, $w['0'] ,$ylst);
		$pdf->Rect($x+$w['0'], $yst, $w['1'] ,$ylst);
		$pdf->Rect($x+$w['0']+$w['1'], $yst, $w['2'] ,$ylst);
		$pdf->Rect($x+$w['0']+$w['1']+$w['2'], $yst, $w['3'] ,$ylst);
		$pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3'], $yst, $w['4'] ,$ylst);
		$pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4'], $yst, $w['5'] ,$ylst);
		$pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4']+$w['5'], $yst ,$w['6'],$ylst);
        $pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4']+$w['5']+$w['6'],$yst, $w['7'],$ylst);
        $pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4']+$w['5']+$w['6']+$w['7'],$yst, $w['8'],$ylst);        
		
		//setelah buat rectangle baru kemudian addPage
		$pdf->AddPage();
		$pdf->SetAutoPageBreak(true,10);
		$pdf->AliasNbPages();
		$left = 25;

        $pdf->SetFont('Times','B',8);
        $pdf->SetXY(15,$pdf->GetY()+6);
        $pdf->Cell($w['0'],5,'No','LT',0,'C');
        $pdf->Cell($w['1'],5,'Program','LTR',0,'C');
        $pdf->Cell($w['2'],5,'Anggaran','LTR',0,'C');
        $pdf->Cell($w['3']+$w['4']+$w['5']+$w['6']+$w['7']+$w['8']+$w['9']+$w['10']+$w['11']+$w['12']+$w['13']+$w['14']+$w['15']+$w['16'],5,'Komponen Penggunaan Dana BOS','LTR',0,'C');
        $pdf->Cell($w['17'],5,'','LTR',0,'C');
        $pdf->ln();

        $pdf->SetFont('Times','B',8);
        $pdf->SetXY(15,$pdf->GetY());
        $pdf->Cell($w['0'],5,'Kode','L',0,'C');
        $pdf->Cell($w['1'],5,'Uraian','LR',0,'C');
        $pdf->Cell($w['2'],5,'(dalam Rp)','LR',0,'C');
        $pdf->SetFont('Times','B',6);
        $pdf->Cell($w['3'],5,'Pengembangan','LTR',0,'C');
        $pdf->Cell($w['4'],5,'Penerimaan','LTR',0,'C');
        $pdf->Cell($w['5'],5,'Pembelajaran','LTR',0,'C');
        $pdf->Cell($w['6'],5,'Ulangan','LTR',0,'C');
        $pdf->Cell($w['7'],5,'Bahan Pakai','LTR',0,'C');
        $pdf->Cell($w['8'],5,'Langganan','LTR',0,'C');
        $pdf->Cell($w['9'],5,'Perawatan','LTR',0,'C');
        $pdf->Cell($w['10'],5,'Honor Guru &','LTR',0,'C');
        $pdf->Cell($w['11'],5,'Pengembangan','LTR',0,'C');
        $pdf->Cell($w['12'],5,'Membantu','LTR',0,'C');
        $pdf->Cell($w['13'],5,'Pengelolaan','LTR',0,'C');
        $pdf->Cell($w['14'],5,'Perangkat','LTR',0,'C');
        $pdf->Cell($w['15'],5,'Biaya','LTR',0,'C');
        $pdf->Cell($w['16'],5,'Tanpa','LTR',0,'C');
        $pdf->SetFont('Times','B',8);
        $pdf->Cell($w['17'],5,'Jumlah','LR',0,'C');
        $pdf->ln();

        $pdf->SetFont('Times','B',8);
        $pdf->SetXY(15,$pdf->GetY());
        $pdf->Cell($w['0'],3,'','L',0,'C');
        $pdf->Cell($w['1'],3,'','LR',0,'C');
        $pdf->Cell($w['2'],3,'','LR',0,'C');
        $pdf->SetFont('Times','B',6);
        $pdf->Cell($w['3'],3,'Perpustakaan','LR',0,'C');
        $pdf->Cell($w['4'],3,'Siswa Baru','LR',0,'C');
        $pdf->Cell($w['5'],3,'& Ekskul','LR',0,'C');
        $pdf->Cell($w['6'],3,'& Ujian','LR',0,'C');
        $pdf->Cell($w['7'],3,'Habis','LR',0,'C');
        $pdf->Cell($w['8'],3,'Daya & Jasa','LR',0,'C');
        $pdf->Cell($w['9'],3,'Sekolah','LR',0,'C');
        $pdf->Cell($w['10'],3,'Tenaga Pendidik','LR',0,'C');
        $pdf->Cell($w['11'],3,'Profesi Guru','LR',0,'C');
        $pdf->Cell($w['12'],3,'Siswa Miskin','LR',0,'C');
        $pdf->Cell($w['13'],3,'BOS','LR',0,'C');
        $pdf->Cell($w['14'],3,'Komputer','LR',0,'C');
        $pdf->Cell($w['15'],3,'Lainnya','LR',0,'C');
        $pdf->Cell($w['16'],3,'Kategori','LR',0,'C');
        $pdf->Cell($w['17'],3,'','LR',0,'C');
        $pdf->ln();


		$y1 = $pdf->GetY(); // Untuk baris berikutnya
		$y2 = $pdf->GetY(); //untuk baris berikutnya
		$y3 = $pdf->GetY(); //untuk baris berikutnya
		$yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
		$x = 15;
		$ysisa = $y1;

	}



    $pdf->SetFont('Times','',7);
	//new data		
	$pdf->SetXY($x, $y);
	$xcurrent= $x;
	$pdf->MultiCell($w['0'],5,$model['kd_program'],'','C');
	$xcurrent = $xcurrent+$w['0'];
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['1'],5,$model['uraian_program'],'','L');
    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
	$xcurrent = $xcurrent+$w['1'];
 	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['2'],5,number_format($model['anggaran'],0,',','.'),'','R');
	$xcurrent = $xcurrent+$w['2'];
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['3'],5,number_format($model['komponen1'],0,',','.'),'','R');
	$xcurrent = $xcurrent+$w['3'];
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['4'],5,number_format($model['komponen2'],0,',','.'),'','R');
	$y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
	$xcurrent = $xcurrent+$w['4'];
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['5'],5,number_format($model['komponen3'],0,',','.'),'','R');
	$y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
	$xcurrent = $xcurrent+$w['5'];
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['6'],5,number_format($model['komponen4'],0,',','.'),'','R');
	$xcurrent = $xcurrent+$w['6'];
    $pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['7'],5,number_format($model['komponen5'],0,',','.'),'','R');
	$xcurrent = $xcurrent+$w['7'];$pdf->SetXY($xcurrent, $y);
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['8'],5,number_format($model['komponen6'],0,',','.'),'','R');
	$xcurrent = $xcurrent+$w['8'];
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['9'],5,number_format($model['komponen7'],0,',','.'),'','R');
	$xcurrent = $xcurrent+$w['9'];
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['10'],5,number_format($model['komponen8'],0,',','.'),'','R');
	$xcurrent = $xcurrent+$w['10'];
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['11'],5,number_format($model['komponen9'],0,',','.'),'','R');
	$xcurrent = $xcurrent+$w['11'];
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['12'],5,number_format($model['komponen10'],0,',','.'),'','R');
	$xcurrent = $xcurrent+$w['12'];
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['13'],5,number_format($model['komponen11'],0,',','.'),'','R');
	$xcurrent = $xcurrent+$w['13'];
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['14'],5,number_format($model['komponen12'],0,',','.'),'','R');
	$xcurrent = $xcurrent+$w['14'];
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['15'],5,number_format($model['komponen13'],0,',','.'),'','R');
	$xcurrent = $xcurrent+$w['15'];
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['16'],5,number_format($model['komponenlain'],0,',','.'),'','R');
	$xcurrent = $xcurrent+$w['16'];
	$pdf->SetXY($xcurrent, $y);
    $jumlah = $model['komponen1'] + $model['komponen2'] + $model['komponen3'] + $model['komponen4'] + $model['komponen5'] + $model['komponen6'] + $model['komponen7'] + $model['komponen8'] + $model['komponen9'] + $model['komponen10'] + $model['komponen11'] +$model['komponen12'] + $model['komponen13'] + $model['komponenlain'];
	$pdf->MultiCell($w['17'],5,number_format($jumlah,0,',','.'),'','R');
	$xcurrent = $xcurrent+$w['17'];

	
	$ysisa = $y;

	$i++; //Untuk urutan nomor
	$pdf->ln();

    $totalanggaran = $totalanggaran + $model['anggaran'];
    $totalkomponen1 = $totalkomponen1 + $model['komponen1'];
    $totalkomponen2 = $totalkomponen2 + $model['komponen2'];
    $totalkomponen3 = $totalkomponen3 + $model['komponen3'];
    $totalkomponen4 = $totalkomponen4 + $model['komponen4'];
    $totalkomponen5 = $totalkomponen5 + $model['komponen5'];
    $totalkomponen6 = $totalkomponen6 + $model['komponen6'];
    $totalkomponen7 = $totalkomponen7 + $model['komponen7'];
    $totalkomponen8 = $totalkomponen8 + $model['komponen8'];
    $totalkomponen9 = $totalkomponen9 + $model['komponen9'];
    $totalkomponen10 = $totalkomponen10 + $model['komponen10'];
    $totalkomponen11 = $totalkomponen11 + $model['komponen11'];
    $totalkomponen12 = $totalkomponen12 + $model['komponen12'];
    $totalkomponen13 = $totalkomponen13 + $model['komponen13'];
    $totalkomponenlain = $totalkomponenlain + $model['komponenlain'];
    $totaljumlah = $totaljumlah + $jumlah;

    $jumlah = 0;

}

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
$pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4']+$w['5']+$w['6'],$yst, $w['7'],$ylst);
$pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4']+$w['5']+$w['6']+$w['7'],$yst, $w['8'],$ylst);
$pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4']+$w['5']+$w['6']+$w['7']+$w['8'],$yst, $w['9'],$ylst);
$pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4']+$w['5']+$w['6']+$w['7']+$w['8']+$w['9'],$yst, $w['10'],$ylst);
$pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4']+$w['5']+$w['6']+$w['7']+$w['8']+$w['9']+$w['10'],$yst, $w['11'],$ylst);
$pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4']+$w['5']+$w['6']+$w['7']+$w['8']+$w['9']+$w['10']+$w['11'],$yst, $w['12'],$ylst);
$pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4']+$w['5']+$w['6']+$w['7']+$w['8']+$w['9']+$w['10']+$w['11']+$w['12'],$yst, $w['13'],$ylst);
$pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4']+$w['5']+$w['6']+$w['7']+$w['8']+$w['9']+$w['10']+$w['11']+$w['12']+$w['13'],$yst, $w['14'],$ylst);
$pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4']+$w['5']+$w['6']+$w['7']+$w['8']+$w['9']+$w['10']+$w['11']+$w['12']+$w['13']+$w['14'],$yst, $w['15'],$ylst);
$pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4']+$w['5']+$w['6']+$w['7']+$w['8']+$w['9']+$w['10']+$w['11']+$w['12']+$w['13']+$w['14']+$w['15'],$yst, $w['16'],$ylst);
$pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4']+$w['5']+$w['6']+$w['7']+$w['8']+$w['9']+$w['10']+$w['11']+$w['12']+$w['13']+$w['14']+$w['15']+$w['16'],$yst, $w['17'],$ylst);



//Menampilkan jumlah halaman terakhir
$pdf->setxy($x,$y);
$pdf->SetFont('Times','BU',6);
//new data		
$pdf->SetXY($x, $y);
$xcurrent= $x;
$pdf->MultiCell($w['0'],6, '','BLT','R');
$xcurrent = $xcurrent+$w['0'];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w['1'],6,'Total','BTR','L');
$xcurrent = $xcurrent+$w['1'];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w['2'],6,number_format($totalanggaran,0,',','.'),'BTR','R');
$xcurrent = $xcurrent+$w['2'];
$y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w['3'],6,number_format($totalkomponen1,0,',','.'),'BTR','R');
$xcurrent = $xcurrent+$w['3'];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w['4'],6,number_format($totalkomponen2,0,',','.'),'BTR','R');
$y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$xcurrent = $xcurrent+$w['4'];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w['5'],6,number_format($totalkomponen3,0,',','.'),'BTR','R');
$xcurrent = $xcurrent+$w['5'];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w['6'],6,number_format($totalkomponen4,0,',','.'),'BTR','R');
$xcurrent = $xcurrent+$w['6'];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w['7'],6,number_format($totalkomponen5,0,',','.'),'BTR','R');
$xcurrent = $xcurrent+$w['7'];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w['8'],6,number_format($totalkomponen6,0,',','.'),'BTR','R');
$xcurrent = $xcurrent+$w['8'];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w['9'],6,number_format($totalkomponen7,0,',','.'),'BTR','R');
$xcurrent = $xcurrent+$w['9'];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w['10'],6,number_format($totalkomponen8,0,',','.'),'BTR','R');
$xcurrent = $xcurrent+$w['10'];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w['11'],6,number_format($totalkomponen9,0,',','.'),'BTR','R');
$xcurrent = $xcurrent+$w['11'];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w['12'],6,number_format($totalkomponen10,0,',','.'),'BTR','R');
$xcurrent = $xcurrent+$w['12'];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w['13'],6,number_format($totalkomponen11,0,',','.'),'BTR','R');
$xcurrent = $xcurrent+$w['13'];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w['14'],6,number_format($totalkomponen12,0,',','.'),'BTR','R');
$xcurrent = $xcurrent+$w['14'];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w['15'],6,number_format($totalkomponen13,0,',','.'),'BTR','R');
$xcurrent = $xcurrent+$w['15']; 
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w['16'],6,number_format($totalkomponenlain,0,',','.'),'BTR','R');
$xcurrent = $xcurrent+$w['16'];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w['17'],6,number_format($totaljumlah,0,',','.'),'BTR','R');
$xcurrent = $xcurrent+$w['17'];
$ysisa = $y;
$pdf->ln();
$y = max($y1, $y2);

//Menampilkan tanda tangan
IF(($pdf->gety()+6) >= 160) $pdf->AddPage();
$pdf->SetXY(215,$pdf->gety()+10);
$pdf->SetFont('Arial','B',10);
$pdf->MultiCell(100,5,$peraturan->sekolah->refKecamatan->Nm_Kecamatan.', '.DATE('j', strtotime($getparam['Laporan']['Tgl_Laporan'])).' '.bulan(DATE('m', strtotime($getparam['Laporan']['Tgl_Laporan']))).' '.DATE('Y', strtotime($getparam['Laporan']['Tgl_Laporan'])), '', 'J', 0);
$y = $pdf->getY();
$pdf->SetXY(215,$pdf->gety());
$pdf->SetFont('Arial','B',10);
$pdf->MultiCell(100,5,'Menyetujui,', '', 'j', 0);
$pdf->SetXY(215,$pdf->gety());
$pdf->SetFont('Arial','B',10);
$pdf->MultiCell(100,5,$peraturan['jabatan'], '', 'j', 0);
$pdf->SetXY(215,$pdf->gety()+15);
$pdf->SetFont('Arial','B',10);
$pdf->MultiCell(100,5,$peraturan['penandatangan'], '', 'j', 0);
$pdf->SetX(215);
$pdf->MultiCell(100,5,'NIP '.$peraturan['nip'], '', 'j', 0);

$pdf->SetXY(15,$y);
$pdf->SetFont('Arial','B',10);
$pdf->MultiCell(100,5,'Mengetahui,', '', 'j', 0);
$pdf->SetXY(15,$pdf->gety());
$pdf->SetFont('Arial','B',10);
$pdf->MultiCell(100,5,$peraturan['jabatan_komite'], '', 'j', 0);
$pdf->SetXY(15,$pdf->gety()+15);
$pdf->SetFont('Arial','B',10);
$pdf->MultiCell(100,5,$peraturan['komite_sekolah'] == NULL ? '-' : $peraturan['komite_sekolah'], '', 'j', 0);


//Untuk mengakhiri dokumen pdf, dan mengirim dokumen ke output
$pdf->Output();
exit;
?>