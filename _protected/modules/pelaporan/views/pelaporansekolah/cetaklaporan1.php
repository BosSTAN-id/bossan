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
$pdf->Cell(150,5,'Formulir BOS-K1',1,0,'C');
$pdf->ln();

$pdf->SetFont('Arial','B',10);
$pdf->SetXY(15,$pdf->GetY());
$pdf->Cell(40,5,'Desa/Kelurahan','',0,'L');
$pdf->Cell(110,5,': '.$peraturan->sekolah->refDesa->Nm_Desa,'',0,'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(150,5,'Diisi Oleh Sekolah','LR',0,'C');
$pdf->ln();

$pdf->SetFont('Arial','B',10);
$pdf->SetXY(15,$pdf->GetY());
$pdf->Cell(40,5,'Provinsi/Kabupaten','',0,'L');
$pdf->Cell(110,5,': Sumatera Selatan / Banyuasin','',0,'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(150,5,'Dikirim ke Tim Manajemen BOS','LRB',0,'C');
$pdf->ln();


$w = [30, 90, 30, 30, 90, 30]; // Tentukan width masing-masing kolom
 
$pdf->SetFont('Arial','B',10);
$pdf->SetXY(15,$pdf->GetY() + 6);
$pdf->Cell($w['0']+$w['1']+$w['2'],6,'PENERIMAAN/PENDAPATAN','LT',0,'C');
$pdf->Cell($w['3']+$w['4']+$w['5'],6,'PENGELUARAN/BELANJA','LTR',0,'C');
$pdf->ln();

$pdf->SetFont('Arial','B',10);
$pdf->SetXY(15,$pdf->GetY());
$pdf->Cell($w['0'],6,'Kode','LT',0,'C');
$pdf->Cell($w['1'],6,'Uraian','LTR',0,'C');
$pdf->Cell($w['2'],6,'Jumlah','LTR',0,'C');
$pdf->Cell($w['3'],6,'Kode','LTR',0,'C');
$pdf->Cell($w['4'],6,'Uraian','LTR',0,'C');
$pdf->Cell($w['5'],6,'Jumlah','LTR',0,'C');
$pdf->ln();

$pdf->SetFont('Arial','B',10);
$pdf->SetXY(15,$pdf->GetY());
$pdf->Cell($w['0'],6,'1','LTB',0,'C');
$pdf->Cell($w['1'],6,'2','LTRB',0,'C');
$pdf->Cell($w['2'],6,'3','LTRB',0,'C');
$pdf->Cell($w['3'],6,'1','LTRB',0,'C');
$pdf->Cell($w['4'],6,'2','LTRB',0,'C');
$pdf->Cell($w['5'],6,'3','LTRB',0,'C');
$pdf->ln();


$baris1 = $y1 = $pdf->GetY(); // Untuk baris berikutnya
$y2 = $pdf->GetY(); //untuk baris berikutnya
$y3 = $pdf->GetY(); //untuk baris berikutnya
$yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
$x = 15;
$kegiatan = NULL;
$i = 1;

$ysisa = $y1;

//bagian untuk penerimaan, menampilkan semua penerimaan
// --------------------------------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------------------------------

	//Saldo Awal		
    $y = MAX($y1, $y2, $y3);
    $saldoawal = $data1->all();
    $pdf->SetFont('Arial','B',10);
    $jumlah_saldoawal = $data1->sum('nilai');
	$pdf->SetXY($x, $y);
	$xcurrent= $x;
	$pdf->MultiCell($w['0'],6,'1','T','C');
	$xcurrent = $xcurrent+$w['0'];
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['1'],6,'Sisa Tahun Lalu','T','L');
    $y1 = $pdf->GetY();
	$xcurrent = $xcurrent+$w['1'];
 	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['2'],6,number_format($jumlah_saldoawal, 0, '.', '.'),'T','R');
    $y2 = $pdf->GetY();
    $pdf->ln();

    foreach($saldoawal as $value){
        $y = MAX($y1, $y2, $y3);
        $pdf->SetFont('Arial','',10);
        $pdf->SetXY($x, $y);
        $xcurrent= $x;
        $pdf->MultiCell($w['0'],6,$value->kd_penerimaan_1.'.'.$value->kd_penerimaan_2,'','C');
        $xcurrent = $xcurrent+$w['0'];
        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w['1'],6,'     '.$value->penerimaan2->uraian,'','L');
        $y1 = $pdf->GetY();
        $xcurrent = $xcurrent+$w['1'];
        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w['2'],6,number_format($value->nilai, 0, '.', '.'),'','R');
        $y2 = $pdf->GetY();
        $pdf->ln();        
    }

	//Pendapatan Rutin		
    $y = MAX($y1, $y2, $y3);
    $pdf->SetFont('Arial','B',10);
    $rutin = $data2->andWhere(['kd_penerimaan_1' => 2]);
    $jumlah_rutin = $rutin->sum('total'); 
	$pdf->SetXY($x, $y);
	$xcurrent= $x;
	$pdf->MultiCell($w['0'],6,'2','','C');
	$xcurrent = $xcurrent+$w['0'];
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['1'],6,'Pendapatan Rutin','','L');
    $y1 = $pdf->GetY();
	$xcurrent = $xcurrent+$w['1'];
 	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['2'],6,number_format($jumlah_rutin, 0, '.', '.'),'','R');
    $y2 = $pdf->GetY();
    $pdf->ln();

    $rutin = $rutin->all();
    foreach($rutin as $value){
        $y = MAX($y1, $y2, $y3);
        $pdf->SetFont('Arial','',10);
        $pdf->SetXY($x, $y);
        $xcurrent= $x;
        $pdf->MultiCell($w['0'],6,$value->kd_penerimaan_1.'.'.$value->kd_penerimaan_2,'','C');
        $xcurrent = $xcurrent+$w['0'];
        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w['1'],6,'     '.$value->penerimaan2->uraian,'','L');
        $y1 = $pdf->GetY();
        $xcurrent = $xcurrent+$w['1'];
        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w['2'],6,number_format($value->total, 0, '.', '.'),'','R');
        $y2 = $pdf->GetY();
        $pdf->ln();        
    }

	//Pendapatan BOS		
    $y = MAX($y1, $y2, $y3);
    $pdf->SetFont('Arial','B',10);
    $bos = $data3->andWhere(['kd_penerimaan_1' => 3]);
    $jumlah_bos = $bos->sum('total');
	$pdf->SetXY($x, $y);
	$xcurrent= $x;
	$pdf->MultiCell($w['0'],6,'3','','C');
	$xcurrent = $xcurrent+$w['0'];
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['1'],6,'Bantuan Operasional Sekolah','','L');
    $y1 = $pdf->GetY();
	$xcurrent = $xcurrent+$w['1'];
 	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['2'],6,number_format($jumlah_bos, 0, '.', '.'),'','R');
    $y2 = $pdf->GetY();
    $pdf->ln();

    $bos = $bos->all();
    foreach($bos as $value){
        $y = MAX($y1, $y2, $y3);
        $pdf->SetFont('Arial','',10);
        $pdf->SetXY($x, $y);
        $xcurrent= $x;
        $pdf->MultiCell($w['0'],6,$value->kd_penerimaan_1.'.'.$value->kd_penerimaan_2,'','C');
        $xcurrent = $xcurrent+$w['0'];
        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w['1'],6,'     '.$value->penerimaan2->uraian,'','L');
        $y1 = $pdf->GetY();
        $xcurrent = $xcurrent+$w['1'];
        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w['2'],6,number_format($value->total, 0, '.', '.'),'','R');
        $y2 = $pdf->GetY();
        $pdf->ln();                
    } 

	//Pendapatan Bantuan	
    $y = MAX($y1, $y2, $y3);
    $pdf->SetFont('Arial','B',10);
    $bantuan = $data4->andWhere(['kd_penerimaan_1' => 4]);
    $jumlah_bantuan = $bantuan->sum('total'); 
	$pdf->SetXY($x, $y);
	$xcurrent= $x;
	$pdf->MultiCell($w['0'],6,'4','','C');
	$xcurrent = $xcurrent+$w['0'];
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['1'],6,'Bantuan','','L');
    $y1 = $pdf->GetY();
	$xcurrent = $xcurrent+$w['1'];
 	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['2'],6,number_format($jumlah_bantuan, 0, '.', '.'),'','R');
    $y2 = $pdf->GetY();
    $pdf->ln();

    $bantuan = $bantuan->all();
    foreach($bantuan as $value){
        $y = MAX($y1, $y2, $y3);
        $pdf->SetFont('Arial','',10);
        $pdf->SetXY($x, $y);
        $xcurrent= $x;
        $pdf->MultiCell($w['0'],6,$value->kd_penerimaan_1.'.'.$value->kd_penerimaan_2,'','C');
        $xcurrent = $xcurrent+$w['0'];
        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w['1'],6,'     '.$value->penerimaan2->uraian,'','L');
        $y1 = $pdf->GetY();
        $xcurrent = $xcurrent+$w['1'];
        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w['2'],6,number_format($value->total, 0, '.', '.'),'','R');
        $y2 = $pdf->GetY();
        $pdf->ln();                
    } 

	//Pendapatan Lain-Lain
    $y = MAX($y1, $y2, $y3);
    $pdf->SetFont('Arial','B',10);
    $lain = $data5->andWhere('kd_penerimaan_1 NOT IN (1,2,3,4)');
    $jumlah_lain = $lain->sum('total');
	$pdf->SetXY($x, $y);
	$xcurrent= $x;
	$pdf->MultiCell($w['0'],6,'5','','C');
	$xcurrent = $xcurrent+$w['0'];
	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['1'],6,'Pendapatan Lainnya','','L');
    $y1 = $pdf->GetY();
	$xcurrent = $xcurrent+$w['1'];
 	$pdf->SetXY($xcurrent, $y);
	$pdf->MultiCell($w['2'],6,number_format($jumlah_lain, 0, '.', '.'),'','R');
    $y2 = $pdf->GetY();
    $pdf->ln();

    $lain = $lain->all();
    foreach($lain as $value){
        $y = MAX($y1, $y2, $y3);
        $pdf->SetFont('Arial','',10);
        $pdf->SetXY($x, $y);
        $xcurrent= $x;
        $pdf->MultiCell($w['0'],6,$value->kd_penerimaan_1.'.'.$value->kd_penerimaan_2,'','C');
        $xcurrent = $xcurrent+$w['0'];
        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w['1'],6,'     '.$value->penerimaan2->uraian,'','L');
        $y1 = $pdf->GetY();
        $xcurrent = $xcurrent+$w['1'];
        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w['2'],6,number_format($value->total, 0, '.', '.'),'','R');
        $y2 = $pdf->GetY();
        $pdf->ln();               
    }

    $ypendapatanakhir = MAX($y1, $y2, $y3);

//bagian untuk belanja, menampilkan semua belanja per program yang terpilih
// --------------------------------------------------------------------------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------------------------------

	//Saldo Awal		
    $y1 = $y2 = $y3 = $baris1;
    $jumlah_belanja = 0;

    foreach($data as $value){
        $xb = 165;
        $y = MAX($y1, $y2, $y3);
        $pdf->SetFont('Arial','B',10);
        $pdf->SetXY($xb, $y);
        $xcurrent= $xb;
        $pdf->MultiCell($w['3'],6,$value->kd_program ,'','C');
        $xcurrent = $xcurrent+$w['0'];
        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w['4'],6,$value->refprogram->uraian_program,'','L');
        $y1 = $pdf->GetY();
        $xcurrent = $xcurrent+$w['1'];
        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w['5'],6,number_format($value->total, 0, '.', '.'),'','R');
        $y2 = $pdf->GetY();
        $pdf->ln();
        $jumlah_belanja = $jumlah_belanja+$value->total;    
    }

    $ybelanjaakhir = MAX($y1, $y2, $y3);

//membuat kotak di halaman terakhir
$y = MAX($ypendapatanakhir, $ybelanjaakhir);
$ylst = $y - $yst;  //$y batas marjin bawah dikurangi dengan y pertama
$pdf->Rect($x, $yst, $w['0'] ,$ylst);
$pdf->Rect($x+$w['0'], $yst, $w['1'] ,$ylst);
$pdf->Rect($x+$w['0']+$w['1'], $yst, $w['2'] ,$ylst);
$pdf->Rect($x+$w['0']+$w['1']+$w['2'], $yst, $w['3'] ,$ylst);
$pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3'], $yst, $w['4'] ,$ylst);
$pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4'], $yst, $w['5'] ,$ylst);

$pdf->SetFont('Arial','B',10);
$pdf->SetXY(15,$y);
$pdf->Cell($w['0'],6,'','BL',0,'C');
$pdf->Cell($w['1'],6,'Jumlah Pendapatan','BR',0,'R');
$pdf->Cell($w['2'],6,number_format($jumlah_saldoawal+$jumlah_rutin+$jumlah_bos+$jumlah_bantuan+$jumlah_lain, 0, ',', '.'),'BR',0,'R');
$pdf->Cell($w['3'],6,'','B',0,'C');
$pdf->Cell($w['4'],6,'Jumlah Belanja','BR',0,'R');
$pdf->Cell($w['5'],6,number_format($jumlah_belanja, 0, ',', '.'),'BR',0,'C');
$pdf->ln();

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