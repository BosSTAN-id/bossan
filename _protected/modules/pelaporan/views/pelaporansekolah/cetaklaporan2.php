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
	    // Select Arial italic 8
	    $this->SetFont('Arial','I',8);
	    // Print centered page number
	    $this->Cell(0,10,'Printed By BosSTAN | '.$this->PageNo().'/{nb}',0,0,'R');
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

$border = 0;
$pdf->AddPage();
$pdf->SetAutoPageBreak(true,10);
$pdf->AliasNbPages();
$left = 25;


$pdf->SetXY(10,20);
$pdf->SetFont('Arial','B',12);
$pdf->MultiCell(310,5,'RENCANA KEGIATAN DAN ANGGARAN SEKOLAH (RKAS)', '', 'C', 0);
$pdf->SetX(10);
$pdf->MultiCell(310,5, 'TAHUN ANGGARAN '.$Tahun, '', 'C', 0);

$pdf->SetFont('Arial','B',10);
$pdf->SetXY(15,$pdf->GetY()+10);
$pdf->Cell(40,5,'Nama Sekolah','',0,'L');
$pdf->Cell(110,5,': '.$peraturan->sekolah->nama_sekolah,'',0,'L');
$pdf->Cell(140,5,'Formulir BOS-K2',1,0,'C');
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


$w = [20, 110, 40, 30, 30, 30, 30]; // Tentukan width masing-masing kolom
 

$pdf->SetFont('Arial','B',10);
$pdf->SetXY(15,$pdf->GetY()+6);
$pdf->Cell($w['0'],5,'No.','LT',0,'C');
$pdf->Cell($w['1'],5,'Uraian','LTR',0,'C');
$pdf->Cell($w['2'],5,'Jumlah','LTR',0,'C');
$pdf->Cell($w['3']+$w['4']+$w['5']+$w['6'],5,'TRIWULAN','LTR',0,'C');
$pdf->ln();

$pdf->SetFont('Arial','B',10);
$pdf->SetXY(15,$pdf->GetY());
$pdf->Cell($w['0'],5,'Kode','L',0,'C');
$pdf->Cell($w['1'],5,'','LR',0,'C');
$pdf->Cell($w['2'],5,'(dalam Rp)','LR',0,'C');
$pdf->Cell($w['3'],5,'I','LTR',0,'C');
$pdf->Cell($w['4'],5,'II','LTR',0,'C');
$pdf->Cell($w['5'],5,'III','LTR',0,'C');
$pdf->Cell($w['6'],5,'IV','LTR',0,'C');
$pdf->ln();

$pdf->SetFont('Arial','B',10);
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
$x = 15;
$program = NULL;
$subprogram = NULL;
$kegiatan = NULL;
$rek1 = NULL;
$i = 1;

$ysisa = $y1;

$totalanggaran = 0;
$totaltw1 = 0;
$totaltw2 = 0;
$totaltw3 = 0;
$totaltw4 = 0;
$totalanggaranp = 0;
$totaltw1p = 0;
$totaltw2p = 0;
$totaltw3p = 0;
$totaltw4p = 0;

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
        $pdf->MultiCell($w['3'],5,number_format($totaltw1p,0,',','.'),'BT','R');
        $xcurrent = $xcurrent+$w['3'];
        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w['4'],5,number_format($totaltw2p,0,',','.'),'BT','R');
        $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
        $xcurrent = $xcurrent+$w['4'];
        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w['5'],5,number_format($totaltw3p,0,',','.'),'BT','R');
        $xcurrent = $xcurrent+$w['5'];
        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w['6'],5,number_format($totaltw4p,0,',','.'),'BTR','R');
        $xcurrent = $xcurrent+$w['6'];
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



	IF($y2 > 196 || $y1 + (5*(strlen($model['uraian_kegiatan'])/35)) > 180 ){ //cek pagebreak
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

		$pdf->SetFont('Arial','B',10);
		$pdf->SetXY(15,$pdf->GetY()+6);
		$pdf->Cell($w['0'],5,'No.','LT',0,'C');
		$pdf->Cell($w['1'],5,'Uraian','LTR',0,'C');
		$pdf->Cell($w['2'],5,'Jumlah','LTR',0,'C');
		$pdf->Cell($w['3']+$w['4']+$w['5']+$w['6'],5,'TRIWULAN','LTR',0,'C');
		$pdf->ln();

		$pdf->SetFont('Arial','B',10);
		$pdf->SetXY(15,$pdf->GetY());
		$pdf->Cell($w['0'],5,'Kode','L',0,'C');
		$pdf->Cell($w['1'],5,'','LR',0,'C');
		$pdf->Cell($w['2'],5,'(dalam Rp)','LR',0,'C');
		$pdf->Cell($w['3'],5,'I','LTR',0,'C');
		$pdf->Cell($w['4'],5,'II','LTR',0,'C');
		$pdf->Cell($w['5'],5,'III','LTR',0,'C');
		$pdf->Cell($w['6'],5,'IV','LTR',0,'C');
		$pdf->ln();

		$pdf->SetFont('Arial','B',10);
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
	$pdf->MultiCell($w['3'],5,number_format($model['TW1'],0,',','.'),'','R');
	$xcurrent = $xcurrent+$w['3'];
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['4'],5,number_format($model['TW2'],0,',','.'),'','R');
	$y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
	$xcurrent = $xcurrent+$w['4'];
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['5'],5,number_format($model['TW3'],0,',','.'),'','R');
	$y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
	$xcurrent = $xcurrent+$w['5'];
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['6'],5,number_format($model['TW4'],0,',','.'),'','R');
	$xcurrent = $xcurrent+$w['6'];
	$pdf->SetXY($xcurrent, $y);

	
	$totalhutang = 0;
	
	$ysisa = $y;

	$i++; //Untuk urutan nomor
	$pdf->ln();

	IF($model['Kd_Rek_1'] == 5){
        $totalanggaran = $totalanggaran+$model['anggaran'];
        $totaltw1 = $totaltw1+$model['TW1'];
        $totaltw2 = $totaltw2+$model['TW2'];
        $totaltw3 = $totaltw3+$model['TW3'];
        $totaltw4 = $totaltw4+$model['TW4'];
        
    }
	IF($model['Kd_Rek_1'] == 4){
        $totalanggaranp = $totalanggaranp+$model['anggaran'];
        $totaltw1p = $totaltw1p+$model['TW1'];
        $totaltw2p = $totaltw2p+$model['TW2'];
        $totaltw3p = $totaltw3p+$model['TW3'];
        $totaltw4p = $totaltw4p+$model['TW4'];
        
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
$pdf->MultiCell($w['3'],6,number_format($totaltw1,0,',','.'),'BT','R');
$xcurrent = $xcurrent+$w['3'];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w['4'],6,number_format($totaltw2,0,',','.'),'BT','R');
$y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$xcurrent = $xcurrent+$w['4'];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w['5'],6,number_format($totaltw3,0,',','.'),'BT','R');
$xcurrent = $xcurrent+$w['5'];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w['6'],6,number_format($totaltw4,0,',','.'),'BTR','R');
$xcurrent = $xcurrent+$w['6'];
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


//Menampilkan jumlah halaman terakhir
$pdf->setxy($x,$y);
$pdf->SetFont('Times','BU',10);
$pdf->Cell($w['0'],6,'','LB');
$pdf->Cell($w['1'],6,'TOTAL','LB',0,'C');
$pdf->Cell($w['2'],6,number_format($totalanggaranp - $totalanggaran,0,',','.'),'BL',0,'R');
$pdf->Cell($w['3'],6,number_format($totaltw1p - $totaltw1,0,',','.'),'BL',0,'R');
$pdf->Cell($w['4'],6,number_format($totaltw2p - $totaltw2,0,',','.'),'BL',0,'R');
$pdf->Cell($w['5'],6,number_format($totaltw3p - $totaltw3,0,',','.'),'BL',0,'R');
$pdf->Cell($w['6'],6,number_format($totaltw4p - $totaltw4,0,',','.'),1,0,'R');

//Menampilkan tanda tangan
IF(($pdf->gety()+6) >= 175) $pdf->AddPage();
$pdf->SetXY(215,$pdf->gety()+10);
$pdf->SetFont('Arial','B',10);
$pdf->MultiCell(100,5,$peraturan->sekolah->refKecamatan->Nm_Kecamatan.', '.DATE('j', strtotime($peraturan['tgl_peraturan'])).' '.bulan(DATE('m', strtotime($peraturan['tgl_peraturan']))).' '.DATE('Y', strtotime($peraturan['tgl_peraturan'])), '', 'J', 0);
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