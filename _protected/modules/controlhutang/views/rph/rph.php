<?php
Use app\itbz\fpdf\src\fpdf\fpdf;

//menugaskan variabel $pdf pada function fpdf().
$pdf = new \fpdf\FPDF('P','mm',array(216,330));

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



//Menambahkan halaman, untuk menambahkan halaman tambahkan command ini. P artinya potrait dan L artinya Landscape
$pdf->AddPage();

//cara menambahkan image dalam dokumen. Urutan data-> alamat file-posisi X- posisi Y-ukuran width - ukurang high -  menambahkan link bila perlu

// $pdf->SetRightMargin(180)

// $pdf->SetRightMargin(180)
$pdf->Image('images/logo.jpg',15,15,25,25,'');

$pdf->SetXY(43,10);
$pdf->SetFont('Arial','B',15); 
$pdf->MultiCell(160,18,'PEMERINTAH KABUPATEN BANYUASIN', '', 'C', 0);

$pdf->SetXY(40,22);
$pdf->SetFont('Arial','B',17); 
$pdf->MultiCell(160,7,'DINAS PENDAPATAN, PENGELOLAAN KEUANGAN DAN ASET DAERAH', '', 'C', 0);

$pdf->SetXY(40,35);
$pdf->SetFont('Arial','B',10); 
$pdf->MultiCell(160,4,'Komplek PerkantoranPemkab Banyuasin - Sekojo No. 11 Pangkalan Balai 30735
Telepon : (0711) 7690008 Faks : (0711) 7690078', '', 'C', 0);

$pdf->SetXY(15,40);
$pdf->SetFont('Arial','B',28); 
$pdf->MultiCell(185,4,'', 'B', 'C', 0);

$pdf->SetXY(43,10);
$pdf->SetFont('Arial','B',16); 
$pdf->MultiCell(135,100,'REKOMENDASI PELUNASAN HUTANG', '', 'C', 0);

$pdf->SetFont('Arial','',11);
$pdf->SetXY(25,70);
$pdf->MultiCell(50,5,'Nomor', '', 'L', 0);

$pdf->SetFont('Arial','',11);
$pdf->SetXY(50,70);
$pdf->MultiCell(100,5,': '.$model->No_RPH, '', 'L', 0);

$pdf->SetFont('Arial','',11);
$pdf->SetXY(140,70);
$pdf->MultiCell(800,5,'Pangkalan Balai, '.DATE('j', strtotime($model->Tgl_RPH)).' '.bulan(DATE('m', strtotime($model->Tgl_RPH))).' '.DATE('Y', strtotime($model->Tgl_RPH)), '', 'L', 0);


$pdf->SetFont('Arial','',11);
$pdf->SetXY(25,75);
$pdf->MultiCell(140,5,'Lampiran', '', 'L', 0);

$pdf->SetFont('Arial','',11);
$pdf->SetXY(50,75);
$pdf->MultiCell(100,5,': '.$model->Lampiran_RPH.' berkas', '', 'L', 0);

$pdf->SetXY(25,80);
$pdf->MultiCell(140,5,'Perihal', '', 'L', 0);
$pdf->SetFont('Arial','',11);

$pdf->SetXY(50,80);
$pdf->MultiCell(140,5,': Rekomendasi Pelunasan Hutang ', '', 'L', 0);
$pdf->SetFont('Arial','',11);

$pdf->SetXY(25,90);
$pdf->MultiCell(140,5,'Kepada Yth,', '', 'L', 0);
$pdf->SetFont('Arial','',11);

$pdf->SetXY(25,95);
$pdf->MultiCell(140,5,'Kepala DPPKAD Kabupaten Banyuasin,', '', 'L', 0);
$pdf->SetFont('Arial','',11);

$pdf->SetXY(25,100);
$pdf->MultiCell(140,5,'di', '', 'L', 0);
$pdf->SetFont('Arial','',11);

$pdf->SetXY(30,105);
$pdf->MultiCell(140,5,'Pangkalan Balai', '', 'L', 0);
$pdf->SetFont('Arial','',11);

$pdf->SetXY(25,120);
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(175,5,'             Sesuai dengan surat tagihan penyedia barang/jasa '.$model->noSPH->Nm_Perusahaan.' Nomor : '.$model->No_Tagihan.' tanggal : '.DATE('j', strtotime($model->Tgl_Tagihan)).' '.bulan(DATE('m', strtotime($model->Tgl_Tagihan))).' '.DATE('Y', strtotime($model->Tgl_Tagihan)).' dan Surat Pengakuan Hutang Nomor : '.$model->noSPH->No_SPH.' tanggal '.DATE('j', strtotime($model->noSPH->Tgl_SPH)).' '.bulan(DATE('m', strtotime($model->noSPH->Tgl_SPH))).' '.DATE('Y', strtotime($model->noSPH->Tgl_SPH)).', kami sampaikan bahwa tagihan tersebut dapat dibayarkan.', '', 'J', 0);

$pdf->SetXY(25,140);
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(175,5,'          Pertimbangan dapat dibayar adalah pekerjaan telah selesai dilaksanakan 100%, termasuk penyelesaian pekerjaan selama masa pemeliharaan sebagaimana ditentukan dalam kontrak/SPK Nomor : '.$model->noSPH->No_Kontrak.', tanggal '.DATE('j', strtotime($model->noSPH->Tgl_Kontrak)).' '.bulan(DATE('m', strtotime($model->noSPH->Tgl_Kontrak))).' '.DATE('Y', strtotime($model->noSPH->Tgl_Kontrak)).' tentang '.$model->noSPH->Pekerjaan.'.', '', 'J', 0);

$pdf->SetXY(25,160);
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(175,5,'          Mengingat pembayaran hutang kepada penyedian barang/jasa '.$model->noSPH->Nm_Perusahaan.' tersebut jatuh tempo tanggal .............. maka sudah saatnya dilakukan pembayaran sebesar Rp '.number_format($model->Nilai_Bayar, 0, ',','.').' ke Rekening Nomor '.$model->Rekening_Tujuan.' Bank '.$model->Bank.' Cabang '.$model->Cabang.' atas nama '.$model->Nama_Rekening.' dengan potongan sebesar Rp '.number_format($model->PPh + $model->PPn + $model->Denda, 0, ',','.').' terdiri atas :', '', 'J', 0);

$pdf->SetXY(25,182);
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(175,5,'         1. PPh 21/22 sebesar', '', 'J', 0);

$pdf->SetFont('Arial','',11);
$pdf->SetXY(80,182);
$pdf->MultiCell(100,5,'Rp '.number_format($model->PPh, 0, ',','.'), '', 'L', 0);

$pdf->SetXY(25,187);
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(175,5,'         2. PPn sebesar', '', 'J', 0);

$pdf->SetFont('Arial','',11);
$pdf->SetXY(80,187);
$pdf->MultiCell(100,5,'Rp '.number_format($model->PPn, 0, ',','.'), '', 'L', 0);

$pdf->SetXY(25,192);
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(175,5,'         3. Denda sebesar', '', 'J', 0);

$pdf->SetFont('Arial','',11);
$pdf->SetXY(80,192);
$pdf->MultiCell(100,5,'Rp '.number_format($model->Denda, 0, ',','.'), '', 'L', 0);

$pdf->SetXY(25,202);
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(175,5,'Demikian Rekomendasi ini saya sampaikan, atas kerjasamanya diucapkan terima kasih. ', '', 'J', 0);



$pdf->SetXY(130,225);
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(80,6, $model->Jabatan, '', 'C', 0);

$pdf->SetXY(130,245);
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(80,6,$model->Nm_Kepala_SKPD, '', 'C', 0);

$pdf->SetXY(130,250);
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(80,6,'NIP '.$model->NIP, '', 'C', 0);
 
//Untuk mengakhiri dokumen pdf, dan mengirip dokumen ke output
$pdf->Output();
exit;
?>