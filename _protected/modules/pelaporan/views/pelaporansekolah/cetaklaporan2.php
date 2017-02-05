<?php
Use app\itbz\fpdf\src\fpdf\fpdf;


class PDF extends \fpdf\FPDF
{
	function Footer()
	{
		//ambil link
		$link = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];		
		$this->Image("http://api.qrserver.com/v1/create-qr-code/?size=150x150&data=$link", 280, 203 ,5,0,'PNG');		
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
$pdf->Cell(110,5,': Sumatera Selatan / Banyuasin','',0,'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(140,5,'Dikirim ke Tim Manajemen BOS','LRB',0,'C');
$pdf->ln();


$w = [30, 100, 40, 30, 30, 30, 30]; // Tentukan width masing-masing kolom
 

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
$kegiatan = NULL;
$i = 1;

$ysisa = $y1;


foreach($data as $model){

	// IF($y2 > 196 || $y1 + (5*(strlen($model['Nm_Rekanan'])/35)) > 160 ){ //cek pagebreak
	// 	$ylst = 190 - $yst; //207 batas margin bawah dikurang dengan y pertama
	// 	//setiap selesai page maka buat rectangle
	// 	$pdf->Rect($x, $yst, $w['0'] ,$ylst);
	// 	$pdf->Rect($x+$w['0'], $yst, $w['1'] ,$ylst);
	// 	$pdf->Rect($x+$w['0']+$w['1'], $yst, $w['2'] ,$ylst);
	// 	$pdf->Rect($x+$w['0']+$w['1']+$w['2'], $yst, $w['3'] ,$ylst);
	// 	$pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3'], $yst, $w['4'] ,$ylst);
	// 	$pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4'], $yst, $w['5'] ,$ylst);
	// 	$pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4']+$w['5'], $yst ,$w['6'],$ylst);
		
	// 	//setelah buat rectangle baru kemudian addPage
	// 	$pdf->AddPage();
	// 	$pdf->SetAutoPageBreak(true,10);
	// 	$pdf->AliasNbPages();
	// 	$left = 25;

	// 	$pdf->SetFont('Arial','B',10);
	// 	$pdf->SetXY(15,20);
	// 	$pdf->Cell($w['0'],11,'NO','LT',0,'C');
	// 	$pdf->Cell($w['1'],11,'NOMOR SPH','LTR',0,'C');
	// 	$pdf->Cell($w['2'],11,'NOMOR KONTRAK','LTR',0,'C');
	// 	$pdf->Cell($w['3'],11,'TANGGAL','LTR',0,'C');
	// 	$pdf->Cell($w['4'],11,'PEKERJAAN','LTR',0,'C');
	// 	$pdf->Cell($w['5'],11,'NAMA REKANAN','LTR',0,'C');
	// 	$pdf->Cell($w['6'],11,'NILAI KONTRAK','LTR',0,'C');
	// 	$pdf->ln();

	// 	$pdf->SetFont('Arial','B',10);
	// 	$pdf->SetXY(15,26);
	// 	$pdf->Cell($w['0'],6,'','L',0,'C');
	// 	$pdf->Cell($w['1'],6,'','LR',0,'C');
	// 	$pdf->Cell($w['2'],6,'','LR',0,'C');
	// 	$pdf->Cell($w['3'],6,'','LR',0,'C');
	// 	$pdf->Cell($w['4'],6,'','LR',0,'C');
	// 	$pdf->Cell($w['5'],6,'','LR',0,'C');
	// 	$pdf->Cell($w['6'],6,'','LR',0,'C');
	// 	$pdf->ln();

	// 	$pdf->SetFont('Arial','B',10);
	// 	$pdf->SetXY(15,32);
	// 	$pdf->Cell($w['0'],6,'1','LTB',0,'C');
	// 	$pdf->Cell($w['1'],6,'2','LTRB',0,'C');
	// 	$pdf->Cell($w['2'],6,'3','LTRB',0,'C');
	// 	$pdf->Cell($w['3'],6,'4','LTRB',0,'C');
	// 	$pdf->Cell($w['4'],6,'5','LTRB',0,'C');
	// 	$pdf->Cell($w['5'],6,'6','LTRB',0,'C');
	// 	$pdf->Cell($w['6'],6,'8','LTRB',0,'C');
	// 	$pdf->ln();

	// 	$y1 = $pdf->GetY(); // Untuk baris berikutnya
	// 	$y2 = $pdf->GetY(); //untuk baris berikutnya
	// 	$y3 = $pdf->GetY(); //untuk baris berikutnya
	// 	$yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
	// 	$x = 15;
	// 	$ysisa = $y1;

	// }


	$y = MAX($y1, $y2, $y3);


	//new data		
	$pdf->SetXY($x, $y);
	$xcurrent= $x;
	$pdf->MultiCell($w['0'],5,$model['kd_program'].'.'.substr('0'.$model['kd_sub_program'], -2).'.'.substr('0'.$model['kd_kegiatan'], -2),'T','C');
	$xcurrent = $xcurrent+$w['0'];
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['1'],5,$model['uraian_kegiatan'],'T','L');
    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
	$xcurrent = $xcurrent+$w['1'];
 	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['2'],5,number_format($model['anggaran'],0,',','.'),'T','R');
	$xcurrent = $xcurrent+$w['2'];
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['3'],5,number_format($model['TW1'],0,',','.'),'T','R');
	$xcurrent = $xcurrent+$w['3'];
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['4'],5,number_format($model['TW2'],0,',','.'),'T','R');
	$y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
	$xcurrent = $xcurrent+$w['4'];
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['5'],5,number_format($model['TW3'],0,',','.'),'T','R');
	$y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
	$xcurrent = $xcurrent+$w['5'];
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['6'],5,number_format($model['TW4'],0,',','.'),'T','R');
	$xcurrent = $xcurrent+$w['6'];
	$pdf->SetXY($xcurrent, $y);

	
	$totalhutang = 0;
	
	$ysisa = $y;

	$i++; //Untuk urutan nomor
	$pdf->ln();


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


//Menampilkan jumlah halaman terakhir
$pdf->setxy($x,$y);
$pdf->Cell($w['0'],6,'','LB');
$pdf->Cell($w['1'],6,'','B',0,'C');
$pdf->Cell($w['2'],6,'TOTAL','B',0,'C');
$pdf->Cell($w['3'],6,'','B',0,'C');
$pdf->Cell($w['4'],6,'','B',0,'C');
$pdf->Cell($w['5'],6,'','B',0,'C');
$pdf->Cell($w['6'],6,number_format($totalhutang,0,',','.'),1,0,'R');

//Menampilkan tanda tangan
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