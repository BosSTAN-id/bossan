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

$pdf->Image('images/logo.jpg',15,15,25,25,'');

$pdf->SetXY(43,10);
$pdf->SetFont('Arial','B',15); 
$pdf->MultiCell(160,18,'PEMERINTAH KABUPATEN BANYUASIN', '', 'C', 0);

$pdf->SetXY(40,25);
$pdf->SetFont('Arial','B',17); 
$pdf->MultiCell(160,7,strtoupper($model->subunit->Nm_Sub_Unit), '', 'C', 0);

$pdf->SetXY(40,35);
$pdf->SetFont('Arial','B',10); 
$pdf->MultiCell(160,4,$ttd['Alamat'].'
Telepon : (0711) 7690008 Faks : (0711) 7690078', '', 'C', 0);

$pdf->SetXY(15,40);
$pdf->SetFont('Arial','B',28); 
$pdf->MultiCell(185,4,'', 'B', 'C', 0);

$pdf->SetXY(43,10);
$pdf->SetFont('Arial','B',16); 
$pdf->MultiCell(135,100,'SURAT PENGAKUAN HUTANG', '', 'C', 0);

$pdf->SetXY(30,63);
$pdf->SetFont('Arial','B',14);
$pdf->MultiCell(160,6,'Nomor :'.$model['No_SPH'], '', 'C', 0);

$pdf->SetXY(25,92);
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(175,6,'Saya yang bertanda tangan di bawah ini :', '', 'J', 0);
 
$pdf->SetFont('Arial','',11);
$pdf->SetXY(25,102);
$pdf->MultiCell(140,4,'Nama', '', 'L', 0);

$pdf->SetFont('Arial','',11);
$pdf->SetXY(70,102);
$pdf->MultiCell(100,4,':    '.$model['Nm_Kepala_SKPD'], '', 'L', 0);

$pdf->SetXY(25,110);
$pdf->MultiCell(140,4,'NIP', '', 'L', 0);
$pdf->SetFont('Arial','',11);

$pdf->SetXY(70,110);
$pdf->MultiCell(140,4,':     '.$model['NIP'], '', 'L', 0);
$pdf->SetFont('Arial','',11);

$pdf->SetXY(25,118);
$pdf->MultiCell(140,4,'Jabatan', '', 'L', 0);
$pdf->SetFont('Arial','',11);

$pdf->SetXY(70,118);
$pdf->MultiCell(140,4,':     '.$model['Jabatan'], '', 'L', 0);
$pdf->SetFont('Arial','',11);

$pdf->SetXY(25,126);
$pdf->MultiCell(140,4,'Alamat', '', 'L', 0);
$pdf->SetFont('Arial','',11);

$pdf->SetXY(70,126);
$pdf->MultiCell(140,4,':     '.$model['Alamat'], '', 'L', 0);
$pdf->SetFont('Arial','',11);

$pdf->SetXY(25,136);
$pdf->MultiCell(140,4,'Dengan ini menyatakan pengakuan hutang kepada :', '', 'L', 0);
$pdf->SetFont('Arial','',11);

$pdf->SetFont('Arial','',11);
$pdf->SetXY(25,146);
$pdf->MultiCell(140,4,'Nama', '', 'L', 0);

$pdf->SetFont('Arial','',11);
$pdf->SetXY(70,146);
$pdf->MultiCell(100,4,':     '.$model['Nm_Rekanan'], '', 'L', 0);

$pdf->SetXY(25,154);
$pdf->MultiCell(140,4,'Jabatan', '', 'L', 0);
$pdf->SetFont('Arial','',11);

$pdf->SetXY(70,154);
$pdf->MultiCell(140,4,':     '.$model['Jab_Rekanan'], '', 'L', 0);
$pdf->SetFont('Arial','',11);

$pdf->SetXY(25,162);
$pdf->MultiCell(140,4,'Alamat', '', 'L', 0);
$pdf->SetFont('Arial','',11);

$pdf->SetXY(70,162);
$pdf->MultiCell(140,4,':     '.$model['Alamat_Rekanan'], '', 'L', 0);
$pdf->SetFont('Arial','',11);


$pdf->SetXY(25,170);
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(175,5,'Sebesar Rp '.number_format($model['Nilai'],0,',','.'). ' ('.terbilang($model['Nilai'], $style=3).' Rupiah) untuk kegiatan /pekerjaan '.$model['Pekerjaan']. ' Nomor Surat Perjanjian '.$model['No_Kontrak']. ' tanggal '.DATE('d',strtotime($model['Tgl_Kontrak'])).' '.bulan(DATE('m',strtotime($model['Tgl_Kontrak']))).' '.DATE('Y',strtotime($model['Tgl_Kontrak'])).' yang dilaksanakan oleh '.$model['Nm_Perusahaan'].' pada tahun anggaran '.$model['Tahun'], '', 'J', 0);

//number_format($model['selisih'],0,',','.')
$pdf->SetXY(25,195);
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(175,5,'Demikian Surat Pengakuan utang ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.', '', 'J', 0);

$pdf->SetXY(130,220);
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(170,6,'Pangkalan Balai, '.DATE('d').' '.bulan(DATE('m')).' '.DATE('Y'), '', 'J', 0);

$pdf->SetXY(141,226);
$pdf->SetFont('Arial','B',11);
$pdf->MultiCell(175,6,$model['Jabatan'], '', 'j', 0);

$pdf->SetXY(135,250);
$pdf->SetFont('Arial','B',11);
$pdf->MultiCell(175,6,$model['Nm_Kepala_SKPD'], '', 'j', 0);

$pdf->SetXY(135,256);
$pdf->SetFont('Arial','B',11);
$pdf->MultiCell(175,6,'NIP '.$model['NIP'], '', 'j', 0);
 

//Untuk mengakhiri dokumen pdf, dan mengirip dokumen ke output
$pdf->Output();
exit;
?>