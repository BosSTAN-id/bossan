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
$pdf->Cell(140,5,'Formulir BOS-K7',1,0,'C');
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


$w = [20, 90, 30, 25, 25, 25, 25, 25, 25]; // Tentukan width masing-masing kolom
 

$pdf->SetFont('Times','B',10);
$pdf->SetXY(15,$pdf->GetY()+6);
$pdf->Cell($w['0'],5,'No','LT',0,'C');
$pdf->Cell($w['1'],5,'','LTR',0,'C');
$pdf->Cell($w['2'],5,'Anggaran','LTR',0,'C');
$pdf->Cell($w['3']+$w['4']+$w['5']+$w['6']+$w['7']+$w['8'],5,'Penggunaan Dana per Sumber Dana','LTR',0,'C');
$pdf->ln();

$pdf->SetFont('Times','B',10);
$pdf->SetXY(15,$pdf->GetY());
$pdf->Cell($w['0'],5,'Kode','L',0,'C');
$pdf->Cell($w['1'],5,'Uraian','LR',0,'C');
$pdf->Cell($w['2'],5,'(dalam Rp)','LR',0,'C');
$pdf->Cell($w['3'],5,'Rutin','LTR',0,'C');
$pdf->Cell($w['4']+$w['5']+$w['6'],5,'Bantuan Operasional Sekolah (BOS)','LTR',0,'C');
$pdf->Cell($w['7'],5,'Bantuan','LTR',0,'C');
$pdf->Cell($w['8'],5,'Sumber','LTR',0,'C');
$pdf->ln();

$pdf->SetFont('Times','B',10);
$pdf->SetXY(15,$pdf->GetY());
$pdf->Cell($w['0'],5,'','L',0,'C');
$pdf->Cell($w['1'],5,'','LR',0,'C');
$pdf->Cell($w['2'],5,'','LR',0,'C');
$pdf->Cell($w['3'],5,'','LR',0,'C');
$pdf->Cell($w['4'],5,'Pusat','LTR',0,'C');
$pdf->Cell($w['5'],5,'Provinsi','LTR',0,'C');
$pdf->Cell($w['6'],5,'Kab/Kota','LTR',0,'C');
$pdf->Cell($w['7'],5,'Lain','LR',0,'C');
$pdf->Cell($w['8'],5,'Lainnya','LR',0,'C');
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
$totalrutin = 0;
$totalbospusat = 0;
$totalbosprov = 0;
$totalboslain = 0;
$totalbantuan = 0;
$totallain = 0;
$totalanggaranp = 0;
$totalrutinp = 0;
$totalbospusatp = 0;
$totalbosprovp = 0;
$totalboslainp = 0;
$totalbantuanp = 0;
$totallainp = 0;

foreach($data as $model){

	$y = MAX($y1, $y2, $y3);

    IF($rek1 == 4 && $model['Kd_Rek_1'] == 5){
        $pdf->SetFont('Times','U',10);
        $pdf->SetXY($x, $y);
        $xcurrent= $x;
        $pdf->MultiCell($w['0'],5, '','BLT','R');
        $xcurrent = $xcurrent+$w['0'];
        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w['1'],5,'Subtotal','BT','L');
        $xcurrent = $xcurrent+$w['1'];
        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w['2'],5,number_format($totalanggaranp,0,',','.'),'BT','R');
        $xcurrent = $xcurrent+$w['2'];
        $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w['3'],5,number_format($totalrutinp,0,',','.'),'BT','R');
        $xcurrent = $xcurrent+$w['3'];
        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w['4'],5,number_format($totalbospusatp,0,',','.'),'BT','R');
        $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
        $xcurrent = $xcurrent+$w['4'];
        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w['5'],5,number_format($totalbosprovp,0,',','.'),'BT','R');
        $xcurrent = $xcurrent+$w['5'];
        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w['6'],5,number_format($totalboslainp,0,',','.'),'BTR','R');
        $xcurrent = $xcurrent+$w['6'];
        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w['7'],6,number_format($totalbantuan,0,',','.'),'BTR','R');
        $xcurrent = $xcurrent+$w['7'];
        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w['8'],6,number_format($totallain,0,',','.'),'BTR','R');
        $xcurrent = $xcurrent+$w['8'];
        $pdf->SetXY($xcurrent, $y);    
        $ysisa = $y;
        $pdf->ln();
        $y = max($y1, $y2);  
    }

	IF($kegiatan <> $model['kd_program'].'.'.$model['kd_sub_program'].'.'.$model['kd_kegiatan'].'.'.$model['Kd_Rek_1'] ){
        IF($rek1 <> $model['Kd_Rek_1']){
            switch ($model['Kd_Rek_1']) {
                case 4:
                    $pdf->SetFont('Times','BU',10);
                    //new data		
                    $pdf->SetXY($x, $y);
                    $xcurrent= $x;
                    $pdf->MultiCell($w['0'],6,'' ,'','L');
                    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
                    $xcurrent = $xcurrent+$w['0'];
                    $pdf->SetXY($xcurrent, $y);
                    $pdf->MultiCell($w['1'],6,'Pendapatan','','L');
                    $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
                    $ysisa = $y;
                    $pdf->ln();
                    $y = max($y1, $y2); 
                    break;
                case 5:
                    $pdf->SetFont('Times','BU',10);
                    //new data		
                    $pdf->SetXY($x, $y);
                    $xcurrent= $x;
                    $pdf->MultiCell($w['0'],6,'' ,'','L');
                    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
                    $xcurrent = $xcurrent+$w['0'];
                    $pdf->SetXY($xcurrent, $y);
                    $pdf->MultiCell($w['1'],6,'Belanja','','L');
                    $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
                    $ysisa = $y;
                    $pdf->ln();
                    $y = max($y1, $y2); 
                    break;
                default:
                    $pdf->SetFont('Times','BU',10);
                    //new data		
                    $pdf->SetXY($x, $y);
                    $xcurrent= $x;
                    $pdf->MultiCell($w['0'],6,'' ,'','L');
                    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
                    $xcurrent = $xcurrent+$w['0'];
                    $pdf->SetXY($xcurrent, $y);
                    $pdf->MultiCell($w['1'],6,'Kesalahan Penganggaran','','L');
                    $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
                    $ysisa = $y;
                    $pdf->ln();
                    $y = max($y1, $y2); 
                    break;
            }
        }

        IF($subprogram <> $model['kd_program'].'.'.$model['kd_sub_program'].'.'.$model['Kd_Rek_1']){
            IF($program <> $model['kd_program'].'.'.$model['Kd_Rek_1']){
                //code goes here
                $pdf->SetFont('Times','B',10);
                //new data		
                $pdf->SetXY($x, $y);
                $xcurrent= $x;
                $pdf->MultiCell($w['0'],6,$model['kd_program'] ,'','L');
                $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
                $xcurrent = $xcurrent+$w['0'];
                $pdf->SetXY($xcurrent, $y);
                $pdf->MultiCell($w['1'],6,$model['uraian_program'],'','L');
                $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
                $ysisa = $y;
                $pdf->ln();
                $y = max($y1, $y2);                     
            }
            //code goes here
            $pdf->SetFont('Times','B',10);
            //new data		
            $pdf->SetXY($x, $y);
            $xcurrent= $x;
            $pdf->MultiCell($w['0'],6,$model['kd_program'].'.'.substr('0'.$model['kd_sub_program'],-2) ,'','L');
            $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
            $xcurrent = $xcurrent+$w['0'];
            $pdf->SetXY($xcurrent+5, $y);
            $pdf->MultiCell($w['1']-5,6,$model['uraian_sub_program'],'','L');
            $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
            $ysisa = $y;
            $pdf->ln();
            $y = max($y1, $y2);             
        }
        // //code goes here
        // $pdf->SetFont('Times','',10);
        // //new data		
        // $pdf->SetXY($x, $y);
        // $xcurrent= $x;
        // $pdf->MultiCell($w['0'],6,$model['kd_program'].'.'.substr('0'.$model['kd_sub_program'],-2).'.'.substr('0'.$model['kd_kegiatan'],-2) ,'','L');
        // $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
        // $xcurrent = $xcurrent+$w['0'];
        // $pdf->SetXY($xcurrent+10, $y);
        // $pdf->MultiCell($w['1']-10,6,$model['uraian_kegiatan'],'','L');
        // $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
        // $ysisa = $y;
        // $pdf->ln();
        // $y = max($y1, $y2); 
    }



	IF($y2 > 196 || $y1 + (5*(strlen($model['uraian_kegiatan'])/35)) > 180 || $y1 + (5*(strlen($model['uraian_sub_program'])/35)) > 180 || $y1 + (5*(strlen($model['uraian_program'])/35)) > 180 ){ //cek pagebreak
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

        $pdf->SetFont('Times','B',10);
        $pdf->SetXY(15,$pdf->GetY()+6);
        $pdf->Cell($w['0'],5,'No','LT',0,'C');
        $pdf->Cell($w['1'],5,'','LTR',0,'C');
        $pdf->Cell($w['2'],5,'Anggaran','LTR',0,'C');
        $pdf->Cell($w['3']+$w['4']+$w['5']+$w['6']+$w['7']+$w['8'],5,'Penggunaan Dana per Sumber Dana','LTR',0,'C');
        $pdf->ln();

        $pdf->SetFont('Times','B',10);
        $pdf->SetXY(15,$pdf->GetY());
        $pdf->Cell($w['0'],5,'Kode','L',0,'C');
        $pdf->Cell($w['1'],5,'Uraian','LR',0,'C');
        $pdf->Cell($w['2'],5,'(dalam Rp)','LR',0,'C');
        $pdf->Cell($w['3'],5,'Rutin','LTR',0,'C');
        $pdf->Cell($w['4']+$w['5']+$w['6'],5,'Bantuan Operasional Sekolah (BOS)','LTR',0,'C');
        $pdf->Cell($w['7'],5,'Bantuan','LTR',0,'C');
        $pdf->Cell($w['8'],5,'Sumber','LTR',0,'C');
        $pdf->ln();

        $pdf->SetFont('Times','B',10);
        $pdf->SetXY(15,$pdf->GetY());
        $pdf->Cell($w['0'],5,'','L',0,'C');
        $pdf->Cell($w['1'],5,'','LR',0,'C');
        $pdf->Cell($w['2'],5,'','LR',0,'C');
        $pdf->Cell($w['3'],5,'','LR',0,'C');
        $pdf->Cell($w['4'],5,'Pusat','LTR',0,'C');
        $pdf->Cell($w['5'],5,'Provinsi','LTR',0,'C');
        $pdf->Cell($w['6'],5,'Kab/Kota','LTR',0,'C');
        $pdf->Cell($w['7'],5,'Lain','LR',0,'C');
        $pdf->Cell($w['8'],5,'Lainnya','LR',0,'C');
        $pdf->ln();


		$y1 = $pdf->GetY(); // Untuk baris berikutnya
		$y2 = $pdf->GetY(); //untuk baris berikutnya
		$y3 = $pdf->GetY(); //untuk baris berikutnya
		$yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
		$x = 15;
		$ysisa = $y1;
        $y = max($y1, $y2);  

	}



    $pdf->SetFont('Times','',10);
	//new data		
	$pdf->SetXY($x, $y);
	$xcurrent= $x;
	$pdf->MultiCell($w['0'],5,$model['kd_program'].'.'.substr('0'.$model['kd_sub_program'], -2).'.'.substr('0'.$model['kd_kegiatan'], -2),'','L');
	$xcurrent = $xcurrent+$w['0'];
	$pdf->SetXY($xcurrent+10, $y);
	$pdf->MultiCell($w['1']-10,5,$model['uraian_kegiatan'],'','L');
    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
	$xcurrent = $xcurrent+$w['1'];
 	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['2'],5,number_format($model['anggaran'],0,',','.'),'','R');
	$xcurrent = $xcurrent+$w['2'];
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['3'],5,number_format($model['rutin'],0,',','.'),'','R');
	$xcurrent = $xcurrent+$w['3'];
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['4'],5,number_format($model['bos_pusat'],0,',','.'),'','R');
	$y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
	$xcurrent = $xcurrent+$w['4'];
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['5'],5,number_format($model['bos_provinsi'],0,',','.'),'','R');
	$y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
	$xcurrent = $xcurrent+$w['5'];
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['6'],5,number_format($model['bos_lain'],0,',','.'),'','R');
	$xcurrent = $xcurrent+$w['6'];
    $pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['7'],5,number_format($model['bantuan'],0,',','.'),'','R');
	$xcurrent = $xcurrent+$w['7'];$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['8'],5,number_format($model['lain'],0,',','.'),'','R');
	$xcurrent = $xcurrent+$w['8'];
	$pdf->SetXY($xcurrent, $y);

	
	$totalhutang = 0;
	
	$ysisa = $y;

	$i++; //Untuk urutan nomor
	$pdf->ln();

	IF($model['Kd_Rek_1'] == 5){
        $totalanggaran = $totalanggaran+$model['anggaran'];
        $totalrutin = $totalrutin + $model['rutin'];
        $totalbospusat = $totalbospusat + $model['bos_pusat'];
        $totalbosprov = $totalbosprov + $model['bos_provinsi'];
        $totalboslain = $totalboslain + $model['bos_lain'];
        $totalbantuan = $totalbantuan + $model['bantuan'];
        $totallain = $totallain + $model['lain'];
        
    }
	IF($model['Kd_Rek_1'] == 4){
        $totalanggaranp = $totalanggaranp+$model['anggaran'];
        $totalrutinp = $totalrutinp + $model['rutin'];
        $totalbospusatp = $totalbospusatp + $model['bos_pusat'];
        $totalbosprovp = $totalbosprovp + $model['bos_provinsi'];
        $totalboslainp = $totalboslainp + $model['bos_lain'];
        $totalbantuanp = $totalbantuanp + $model['bantuan'];
        $totallainp = $totallainp + $model['lain'];
        
    }   

    //simpan untuk cek kegiatan/program
    $kegiatan = $model['kd_program'].'.'.$model['kd_sub_program'].'.'.$model['kd_kegiatan'].'.'.$model['Kd_Rek_1'];
    $subprogram = $model['kd_program'].'.'.$model['kd_sub_program'].'.'.$model['Kd_Rek_1'];
    $program = $model['kd_program'].'.'.$model['Kd_Rek_1'];
    $rek1 = $model['Kd_Rek_1'];

}

$y = max($y1, $y2);
//subtotal
$pdf->SetFont('Times','U',10);
//new data		
$pdf->SetXY($x, $y);
$xcurrent= $x;
$pdf->MultiCell($w['0'],6, '','BLT','R');
$xcurrent = $xcurrent+$w['0'];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w['1'],6,'Subtotal','BT','L');
$xcurrent = $xcurrent+$w['1'];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w['2'],6,number_format($totalanggaran,0,',','.'),'BT','R');
$xcurrent = $xcurrent+$w['2'];
$y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w['3'],6,number_format($totalrutin,0,',','.'),'BT','R');
$xcurrent = $xcurrent+$w['3'];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w['4'],6,number_format($totalbospusat,0,',','.'),'BT','R');
$y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$xcurrent = $xcurrent+$w['4'];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w['5'],6,number_format($totalbosprov,0,',','.'),'BT','R');
$xcurrent = $xcurrent+$w['5'];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w['6'],6,number_format($totalboslain,0,',','.'),'BTR','R');
$xcurrent = $xcurrent+$w['6'];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w['7'],6,number_format($totalbantuan,0,',','.'),'BTR','R');
$xcurrent = $xcurrent+$w['7'];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w['8'],6,number_format($totallain,0,',','.'),'BTR','R');
$xcurrent = $xcurrent+$w['8'];
$pdf->SetXY($xcurrent, $y);    
$ysisa = $y;
$pdf->ln();
$y = max($y1, $y2);

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


//Menampilkan jumlah halaman terakhir
$pdf->setxy($x,$y);
$pdf->SetFont('Times','BU',10);
$pdf->Cell($w['0'],6,'','LB');
$pdf->Cell($w['1'],6,'TOTAL','LB',0,'C');
$pdf->Cell($w['2'],6,number_format($totalanggaranp - $totalanggaran,0,',','.'),'BL',0,'R');
$pdf->Cell($w['3'],6,number_format($totalrutinp - $totalrutin,0,',','.'),'BL',0,'R');
$pdf->Cell($w['4'],6,number_format($totalbospusatp - $totalbospusat,0,',','.'),'BL',0,'R');
$pdf->Cell($w['5'],6,number_format($totalbosprovp - $totalbosprov,0,',','.'),'BL',0,'R');
$pdf->Cell($w['6'],6,number_format($totalboslainp - $totalboslain,0,',','.'),1,0,'R');
$pdf->Cell($w['7'],6,number_format($totalbantuanp - $totalbantuan,0,',','.'),1,0,'R');
$pdf->Cell($w['8'],6,number_format($totallainp - $totallain,0,',','.'),1,0,'R');

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