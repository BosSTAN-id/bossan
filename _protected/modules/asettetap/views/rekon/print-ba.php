<?php
Use app\itbz\fpdf\src\fpdf\fpdf;


class PDF_Rotate extends \fpdf\FPDF
{
    var $angle=0;

    function Rotate($angle,$x=-1,$y=-1)
    {
        if($x==-1)
            $x=$this->x;
        if($y==-1)
            $y=$this->y;
        if($this->angle!=0)
            $this->_out('Q');
        $this->angle=$angle;
        if($angle!=0)
        {
            $angle*=M_PI/180;
            $c=cos($angle);
            $s=sin($angle);
            $cx=$x*$this->k;
            $cy=($this->h-$y)*$this->k;
            $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
        }
    }

    function _endpage()
    {
        if($this->angle!=0)
        {
            $this->angle=0;
            $this->_out('Q');
        }
        parent::_endpage();
    }
}

class PDF extends PDF_Rotate
{

    function setModel($model){
        $this->model = $model;
    }

    function Header(){
        //masukkan watermark apabila status == 0
        // IF($this->model->status == 1){
        //     //Put the watermark
        //     $this->SetFont('Arial','B',50);
        //     $this->SetTextColor(163,163,163);
        //     $this->RotatedText(60,190,'Draft',45);
        // }        
    }
    function Footer()
    {
        //ambil link
        // $link = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];        
        // $this->Image("http://api.qrserver.com/v1/create-qr-code/?size=150x150&data=$link", 156, 320 ,5,0,'PNG');        
        // Go to 1.5 cm from bottom
        $this->SetY(-15);
        // Select Arial italic 8
        $this->SetFont('Arial','I',8);
        // Print centered page number
        $this->Cell(0,10,'Printed By BosSTAN '.$this->PageNo().'/{nb}',0,0,'R');
    }


    function RotatedText($x, $y, $txt, $angle)
    {
        //Text rotated around its origin
        $this->Rotate($angle,$x,$y);
        $this->Text($x,$y,$txt);
        $this->Rotate(0);
    }    
}

//menugaskan variabel $pdf pada function fpdf().
$pdf = new PDF('P','mm',array(216,330));
$pdf->setModel($model);
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
$pdf->SetMargins(25,25,25) ;//(float left, float top [, float right])
$pdf->SetAutoPageBreak(true, 25); // set bottom margin (boolean auto [, float margin])
$link = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
//cara menambahkan image dalam dokumen. Urutan data-> alamat file-posisi X- posisi Y-ukuran width - ukurang high -  menambahkan link bila perlu

$pdf->Image('images/logo.jpg',15,15,25,28,'');

$pdf->SetXY(40,10);
$pdf->SetFont('Arial','B',15); 
$pdf->MultiCell(160,18,strtoupper(\app\models\TaTh::dokudoku('bulat', $ref['set_10'])), '', 'C', 0);

$pdf->SetXY(40,25);
$pdf->SetFont('Arial','B',17); 
$pdf->MultiCell(160,7,strtoupper(\app\models\TaTh::dokudoku('bulat', $ref['set_11'])), '', 'C', 0);

IF($pdf->GetY() <= 35){
    $y = 35;
}ELSE{
    $y = $pdf->GetY();
}
$pdf->SetXY(40,$y);
$pdf->SetFont('Arial','B',10); 
$pdf->MultiCell(160,4, \app\models\TaTh::dokudoku('bulat', $ref['set_5']), '', 'C', 0);

IF($pdf->GetY() <= 40){
    $y = 40;
}ELSE{
    $y = $pdf->GetY();
}
$pdf->SetXY(15,$y);
$pdf->SetFont('Arial','B',28); 
$pdf->MultiCell(185,4,'', 'B', 'C', 0);

$y = $pdf->GetY()+4;
//bagian tanggal
$pdf->SetXY(130,$y);
$pdf->SetFont('Arial','',11); 
$pdf->MultiCell(70,8,\app\models\TaTh::dokudoku('bulat', $ref['set_4']).', '.DATE('j', strtotime($model['tgl_ba'])).' '.bulan(DATE('m', strtotime($model['tgl_ba']))).' '.DATE('Y', strtotime($model['tgl_ba'])), '', 'L', 0);

$ykepada = $pdf->GetY();
$pdf->SetXY(130,$ykepada);
$pdf->MultiCell(70,6,'Kepada Yth.', '', 'L', 0);

$pdf->SetXY(130,$pdf->GetY());
$pdf->MultiCell(70,6,'Kepala '.\app\models\TaTh::dokudoku('bulat', $ref['set_11']), '', 'L', 0);
$pdf->SetXY(130,$pdf->GetY());
$pdf->MultiCell(70,6,'di-', '', 'L', 0);
$pdf->SetXY(140,$pdf->GetY());
$pdf->MultiCell(70,6,\app\models\TaTh::dokudoku('bulat', $ref['set_6']), '', 'L', 0);
$y2 = $pdf->GetY();

//bagian nomor surat
$pdf->SetXY(15,$ykepada);
$pdf->MultiCell(25,6,'Nomor', '', 'L', 0);
$pdf->SetXY(35,$ykepada);
$pdf->MultiCell(70,6,': '.$model->no_ba, '', 'L', 0);
$y = $pdf->GetY();
$pdf->SetXY(15,$y);
$pdf->MultiCell(25,6,'Lampiran', '', 'L', 0);
$pdf->SetXY(35,$y);
$pdf->MultiCell(70,6,': '.'1 Berkas', '', 'L', 0);
$y = $pdf->GetY();
$pdf->SetXY(15,$y);
$pdf->MultiCell(25,6,'Perihal', '', 'L', 0);
$pdf->SetXY(35,$y);
$pdf->MultiCell(80,6,': '.'Berita Acara Rekonsiliasi Aset '.$model->sekolah->nama_sekolah, '', 'L', 0);
$y1 = $pdf->GetY();

//content
$y = MAX($y1, $y2)+10;
$pdf->SetXY(15,$y);
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(185,6,'Kepala Sekolah '.$model->sekolah->nama_sekolah.' menginformasikan kepada Kepala '.\app\models\TaTh::dokudoku('bulat', $ref['set_11']).' posisi Aset Tetap pada Sekolah yang saya pimpin.', '', 'J', 0);
// $pdf->Write(6,'Dengan memperhatikan '.$model->Memperhatikan.', bersama ini kami mengajukan '.$model->Perihal.' (rincian penggunaan dana terlampir) sebagai berikut:');
 
//bagian berikut
$y = $pdf->GetY()+4;
$left = 35;

$w = [20,70,40]; // Tentukan width masing-masing kolom

$pdf->SetFont('Arial','B',10);
$pdf->SetXY($left,$y);
$pdf->Cell($w['0'],11,'Kode','LT',0,'C');
$pdf->SetFont('Arial','B',9);
$pdf->Cell($w['1'],11,'Klasifikasi Aset','LTR',0,'C');
$pdf->SetFont('Arial','B',10);
$pdf->Cell($w['2'],11,'Saldo ','LTR',0,'C');
$pdf->ln();

$y1 = $pdf->GetY(); // Untuk baris berikutnya
$y2 = $pdf->GetY(); //untuk baris berikutnya
$y3 = $pdf->GetY(); //untuk baris berikutnya
$yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
$x = 35;
$saldo = 0;

foreach($balance as $data){

    IF($y2 > 160 || $y1 + (4*(strlen($data['kdAset5']['Nm_Aset5'])/23)) > 160 || $y3 > 160  ){ //cek pagebreak
        $ylst = 190 - $yst; //207 batas margin bawah dikurang dengan y pertama
        //setiap selesai page maka buat rectangle
            $pdf->Rect($x, $yst, $w['0'] ,$ylst);
            $pdf->Rect($x+$w['0'], $yst, $w['1'] ,$ylst);
            $pdf->Rect($x+$w['0']+$w['1'], $yst, $w['2'] ,$ylst);
        
        //setelah buat rectangle baru kemudian addPage
        $pdf->AddPage();

        $pdf->SetFont('Arial','B',10);
        $pdf->SetXY($left,35);
        $pdf->Cell($w['0'],11,'Kode','LT',0,'C');
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell($w['1'],11,'Klasifikasi Aset','LTR',0,'C');
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell($w['2'],11,'Saldo ','LTR',0,'C');
        $pdf->ln();
        
        $y1 = $pdf->GetY(); // Untuk baris berikutnya
        $y2 = $pdf->GetY(); //untuk baris berikutnya
        $y3 = $pdf->GetY(); //untuk baris berikutnya
        $yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
        $x = 15;
        $ysisa = $y1;

    }


    $y = MAX($y1, $y2, $y3);


    //new data
    $pdf->SetFont('Arial','',8);    
    $pdf->SetXY($x, $y);
    $xcurrent= $x;
    $pdf->MultiCell($w['0'],4,$data['Kd_Aset1'].'.'.$data['Kd_Aset2'].'.'.$data['Kd_Aset3'].'.'.substr('0'.$data['Kd_Aset4'], -2).'.'.substr('0'.$data['Kd_Aset5'], -2),'','R');
    $xcurrent = $xcurrent+$w['0'];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w['1'],4,$data['kdAset5']['Nm_Aset5'],'','L');
    $xcurrent = $xcurrent+$w['1'];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w['2'],4,number_format($data['nilai_perolehan'], 2, ',', '.'),'','R');
    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan    
    
    $saldo = $saldo+$data['nilai_perolehan'];

    $ysisa = $y;

    $pdf->ln();

}

//membuat kotak di halaman terakhir
$y = MAX($y1, $y2, $y3);
$ylst = $y - $yst;  //$y batas marjin bawah dikurangi dengan y pertama
    $pdf->Rect($x, $yst, $w['0'] ,$ylst);
    $pdf->Rect($x+$w['0'], $yst, $w['1'] ,$ylst);
    $pdf->Rect($x+$w['0']+$w['1'], $yst, $w['2'] ,$ylst);


//Menampilkan jumlah halaman terakhir
$pdf->SetFont('Arial','B',8);
$pdf->setxy($x,$y);
$pdf->Cell($w['0'],6,'','LB');
$pdf->Cell($w['1'],6,'TOTAL','B',0,'C');
$pdf->Cell($w['2'],6,number_format($saldo, 0, ',', '.'),'BLR',0,'R');

$pdf->ln();

$y = $pdf->GetY()+4;
$pdf->SetXY(15,$y);
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(185,6,'Demikianlah informasi yang dapat kami sampaikan, atas bantuan dan kerjasama yang baik diucapkan terima kasih.', '', 'J', 0);



$y = $pdf->GetY()+8;
$pdf->SetXY(130,$y);
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(70,6, \app\models\TaTh::dokudoku('bulat', $ref['set_4']).', '.DATE('j', strtotime($model['tgl_ba'])).' '.bulan(DATE('m', strtotime($model['tgl_ba']))).' '.DATE('Y', strtotime($model['tgl_ba'])), '', 'C', 0);


$pdf->SetXY(130,$pdf->GetY());
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(70,6,$model['jbt_penandatangan'], '', 'C', 0);

$pdf->SetXY(130,$pdf->GetY()+25);
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(70,6,$model['nm_penandatangan'], '', 'C', 0);

$pdf->SetXY(130,$pdf->GetY());
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(70,6,'NIP '.$model['nip_penandatangan'], '', 'C', 0);


// Menampilkan lampiran KIB
// parameter for KIB
$w = [10,30,80,40,60,80]; // Tentukan width masing-masing kolom
$xPenandatangan = 240; 
// ---------------------------------------------------------------------------------------------------------------------------------------------------
// ---------------------------------KIB A-------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------------------------------------
$pdf->AddPage('L', [216,330]);
$pdf->SetMargins(15,15,15) ;//(float left, float top [, float right]) Halaman F4 216,330
$pdf->SetAutoPageBreak(true, 15); // set bottom margin (boolean auto [, float margin])
$pdf->AliasNbPages();
$left = 15;


$pdf->SetXY($left,$left);
$pdf->SetFont('Arial','B',12);
$pdf->MultiCell(300, 6,'DAFTAR RINCIAN ASET TETAP KARTU INVENTARIS BARANG (KIB) A', '', 'C', 0);
$pdf->MultiCell(300, 6,'ATAS BERITA ACARA REKONSILIASI: '.$model['no_ba'], '', 'C', 0);

$pdf->SetFont('Arial','B',10);
$pdf->SetXY($left,35);
$pdf->Cell($w['0'],11,'NO','LT',0,'C');
$pdf->SetFont('Arial','B',9);
$pdf->Cell($w['1'],11,'Kode','LTR',0,'C');
$pdf->SetFont('Arial','B',10);
$pdf->Cell($w['2'],11,'Uraian ','LTR',0,'C');
$pdf->SetFont('Arial','B',9);
$pdf->Cell($w['3'],11,'Nilai','LTR',0,'C');
$pdf->SetFont('Arial','B',10);
$pdf->Cell($w['4'],11,'Sumber Perolehan','LTR',0,'C');
$pdf->Cell($w['5'],11,'Keterangan','LTR',0,'C');
$pdf->ln();

$pdf->SetFont('Arial','B',10);
$pdf->SetXY($left,41);
$pdf->Cell($w['0'],6,'','L',0,'C');
$pdf->Cell($w['1'],6,'','LR',0,'C');
$pdf->Cell($w['2'],6,'','LR',0,'C');
$pdf->Cell($w['3'],6,'','LR',0,'C');
$pdf->Cell($w['4'],6,'','LR',0,'C');
$pdf->Cell($w['5'],6,'','LR',0,'C');
$pdf->ln();

$pdf->SetFont('Arial','B',10);
$pdf->SetXY($left,46);
$pdf->Cell($w['0'],6,'1','LTB',0,'C');
$pdf->Cell($w['1'],6,'2','LTRB',0,'C');
$pdf->Cell($w['2'],6,'3','LTRB',0,'C');
$pdf->Cell($w['3'],6,'4','LTRB',0,'C');
$pdf->Cell($w['4'],6,'5','LTRB',0,'C');
$pdf->Cell($w['5'],6,'6','LTRB',0,'C');
$pdf->ln();

$y1 = $pdf->GetY(); // Untuk baris berikutnya
$y2 = $pdf->GetY(); //untuk baris berikutnya
$y3 = $pdf->GetY(); //untuk baris berikutnya
$yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
$x = 15;
$i = 1;

$ysisa = $y1;

$totalKibA = 0;


foreach($kibA as $data){

    IF($y2 > 180 || $y1 + (4*(strlen($data['kdAset5']['Nm_Aset5'])/23)) > 180 || $y3 > 180  ){ //cek pagebreak
        $ylst = 190 - $yst; //207 batas margin bawah dikurang dengan y pertama
        //setiap selesai page maka buat rectangle
            $pdf->Rect($x, $yst, $w['0'] ,$ylst);
            $pdf->Rect($x+$w['0'], $yst, $w['1'] ,$ylst);
            $pdf->Rect($x+$w['0']+$w['1'], $yst, $w['2'] ,$ylst);
            $pdf->Rect($x+$w['0']+$w['1']+$w['2'], $yst, $w['3'] ,$ylst);
            $pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3'], $yst, $w['4'] ,$ylst);
            $pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4'], $yst, $w['5'] ,$ylst);
            // $pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4']+$w['5'], $yst ,$w['6'],$ylst);
        
        //setelah buat rectangle baru kemudian addPage
        $pdf->AddPage('L', [216,330]);

        $pdf->SetFont('Arial','B',10);
        $pdf->SetXY($left,35);
        $pdf->Cell($w['0'],11,'NO','LT',0,'C');
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell($w['1'],11,'Kode','LTR',0,'C');
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell($w['2'],11,'Uraian ','LTR',0,'C');
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell($w['3'],11,'Nilai','LTR',0,'C');
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell($w['4'],11,'Sumber Perolehan','LTR',0,'C');
        $pdf->Cell($w['5'],11,'Keterangan','LTR',0,'C');
        $pdf->ln();

        $pdf->SetFont('Arial','B',10);
        $pdf->SetXY($left,41);
        $pdf->Cell($w['0'],6,'','L',0,'C');
        $pdf->Cell($w['1'],6,'','LR',0,'C');
        $pdf->Cell($w['2'],6,'','LR',0,'C');
        $pdf->Cell($w['3'],6,'','LR',0,'C');
        $pdf->Cell($w['4'],6,'','LR',0,'C');
        $pdf->Cell($w['5'],6,'','LR',0,'C');
        $pdf->ln();

        $pdf->SetFont('Arial','B',10);
        $pdf->SetXY($left,46);
        $pdf->Cell($w['0'],6,'1','LTB',0,'C');
        $pdf->Cell($w['1'],6,'2','LTRB',0,'C');
        $pdf->Cell($w['2'],6,'3','LTRB',0,'C');
        $pdf->Cell($w['3'],6,'4','LTRB',0,'C');
        $pdf->Cell($w['4'],6,'5','LTRB',0,'C');
        $pdf->Cell($w['5'],6,'6','LTRB',0,'C');
        $pdf->ln();


        $y1 = $pdf->GetY(); // Untuk baris berikutnya
        $y2 = $pdf->GetY(); //untuk baris berikutnya
        $y3 = $pdf->GetY(); //untuk baris berikutnya
        $yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
        $x = 15;
        $ysisa = $y1;

    }


    $y = MAX($y1, $y2, $y3);


    //new data
    $pdf->SetFont('Arial','',8);    
    $pdf->SetXY($x, $y);
    $xcurrent= $x;
    $pdf->MultiCell($w['0'],4,$i,'','C');
    $xcurrent = $xcurrent+$w['0'];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w['1'],4,$data['Kd_Aset1'].'.'.$data['Kd_Aset2'].'.'.$data['Kd_Aset3'].'.'.substr('0'.$data['Kd_Aset4'], -2).'.'.substr('0'.$data['Kd_Aset5'], -2).'-'.substr('0'.$data['no_urut'], -2),'','R');
    $xcurrent = $xcurrent+$w['1'];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w['2'],4,$data['kdAset5']['Nm_Aset5'],'','L');
    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan    
    $xcurrent = $xcurrent+$w['2'];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w['3'],4,number_format($data['nilai_perolehan'],0,',','.'),'','R');
    $xcurrent = $xcurrent+$w['3'];
    $pdf->SetXY($xcurrent, $y);
    if($data['sumber_perolehan'] == 1){
        $sumber_perolehan = 'Belanja';
    }else{
        $sumber_perolehan = 'Hibah';
    }
    $pdf->MultiCell($w['4'],4,$sumber_perolehan.' pada '.$data['tgl_perolehan'],'','L');
    $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent+$w['4'];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w['5'],4,"Luas $data->attr1; Hak: $data->attr3",'','L');
    $y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent+$w['5'];
    $pdf->SetXY($xcurrent, $y);

    
    $totalKibA = $totalKibA+$data['nilai_perolehan'];

    
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
    // $pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4']+$w['5'],$yst, $w['6'],$ylst);


//Menampilkan jumlah halaman terakhir
$pdf->SetFont('Arial','B',8);
$pdf->setxy($x,$y);
$pdf->Cell($w['0'],6,'','LB');
$pdf->Cell($w['1'],6,'','B',0,'C');
$pdf->Cell($w['2'],6,'TOTAL','B',0,'C');
$pdf->Cell($w['3'],6,'','B',0,'C');
$pdf->Cell($w['4'],6,number_format($totalKibA, 0, ',', '.'),'BLR',0,'R');
$pdf->Cell($w['5'],6,'','BR',0,'R');
// $pdf->Cell($w['5'],6,'','BR',0,'C');

$pdf->ln();

// Penandatangan 
$y = $pdf->GetY()+8;
$pdf->SetXY($xPenandatangan,$y);
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(70,6, \app\models\TaTh::dokudoku('bulat', $ref['set_4']).', '.DATE('j', strtotime($model['tgl_ba'])).' '.bulan(DATE('m', strtotime($model['tgl_ba']))).' '.DATE('Y', strtotime($model['tgl_ba'])), '', 'C', 0);

$pdf->SetXY($xPenandatangan,$pdf->GetY());
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(70,6,$model['jbt_penandatangan'], '', 'C', 0);

$pdf->SetXY($xPenandatangan,$pdf->GetY()+25);
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(70,6,$model['nm_penandatangan'], '', 'C', 0);

$pdf->SetXY($xPenandatangan,$pdf->GetY());
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(70,6,'NIP '.$model['nip_penandatangan'], '', 'C', 0);

// ---------------------------------------------------------------------------------------------------------------------------------------------------
// ---------------------------------KIB B-------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------------------------------------
$pdf->AddPage('L', [216,330]);
$pdf->SetMargins(15,15,15) ;//(float left, float top [, float right]) Halaman F4 216,330
$pdf->SetAutoPageBreak(true, 15); // set bottom margin (boolean auto [, float margin])
$pdf->AliasNbPages();
$left = 15;


$pdf->SetXY($left,$left);
$pdf->SetFont('Arial','B',12);
$pdf->MultiCell(300, 6,'DAFTAR RINCIAN ASET TETAP KARTU INVENTARIS BARANG (KIB) B', '', 'C', 0);
$pdf->MultiCell(300, 6,'ATAS BERITA ACARA REKONSILIASI: '.$model['no_ba'], '', 'C', 0);

$pdf->SetFont('Arial','B',10);
$pdf->SetXY($left,35);
$pdf->Cell($w['0'],11,'NO','LT',0,'C');
$pdf->SetFont('Arial','B',9);
$pdf->Cell($w['1'],11,'Kode','LTR',0,'C');
$pdf->SetFont('Arial','B',10);
$pdf->Cell($w['2'],11,'Uraian ','LTR',0,'C');
$pdf->SetFont('Arial','B',9);
$pdf->Cell($w['3'],11,'Nilai','LTR',0,'C');
$pdf->SetFont('Arial','B',10);
$pdf->Cell($w['4'],11,'Sumber Perolehan','LTR',0,'C');
$pdf->Cell($w['5'],11,'Keterangan','LTR',0,'C');
$pdf->ln();

$pdf->SetFont('Arial','B',10);
$pdf->SetXY($left,41);
$pdf->Cell($w['0'],6,'','L',0,'C');
$pdf->Cell($w['1'],6,'','LR',0,'C');
$pdf->Cell($w['2'],6,'','LR',0,'C');
$pdf->Cell($w['3'],6,'','LR',0,'C');
$pdf->Cell($w['4'],6,'','LR',0,'C');
$pdf->Cell($w['5'],6,'','LR',0,'C');
$pdf->ln();

$pdf->SetFont('Arial','B',10);
$pdf->SetXY($left,46);
$pdf->Cell($w['0'],6,'1','LTB',0,'C');
$pdf->Cell($w['1'],6,'2','LTRB',0,'C');
$pdf->Cell($w['2'],6,'3','LTRB',0,'C');
$pdf->Cell($w['3'],6,'4','LTRB',0,'C');
$pdf->Cell($w['4'],6,'5','LTRB',0,'C');
$pdf->Cell($w['5'],6,'6','LTRB',0,'C');
$pdf->ln();

$y1 = $pdf->GetY(); // Untuk baris berikutnya
$y2 = $pdf->GetY(); //untuk baris berikutnya
$y3 = $pdf->GetY(); //untuk baris berikutnya
$yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
$x = 15;
$i = 1;

$ysisa = $y1;

$totalKibA = 0;


foreach($kibB as $data){

    IF($y2 > 180 || $y1 + (4*(strlen($data['kdAset5']['Nm_Aset5'])/23)) > 180 || $y3 > 180  ){ //cek pagebreak
        $ylst = 190 - $yst; //207 batas margin bawah dikurang dengan y pertama
        //setiap selesai page maka buat rectangle
            $pdf->Rect($x, $yst, $w['0'] ,$ylst);
            $pdf->Rect($x+$w['0'], $yst, $w['1'] ,$ylst);
            $pdf->Rect($x+$w['0']+$w['1'], $yst, $w['2'] ,$ylst);
            $pdf->Rect($x+$w['0']+$w['1']+$w['2'], $yst, $w['3'] ,$ylst);
            $pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3'], $yst, $w['4'] ,$ylst);
            $pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4'], $yst, $w['5'] ,$ylst);
            // $pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4']+$w['5'], $yst ,$w['6'],$ylst);
        
        //setelah buat rectangle baru kemudian addPage
        $pdf->AddPage('L', [216,330]);

        $pdf->SetFont('Arial','B',10);
        $pdf->SetXY($left,35);
        $pdf->Cell($w['0'],11,'NO','LT',0,'C');
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell($w['1'],11,'Kode','LTR',0,'C');
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell($w['2'],11,'Uraian ','LTR',0,'C');
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell($w['3'],11,'Nilai','LTR',0,'C');
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell($w['4'],11,'Sumber Perolehan','LTR',0,'C');
        $pdf->Cell($w['5'],11,'Keterangan','LTR',0,'C');
        $pdf->ln();

        $pdf->SetFont('Arial','B',10);
        $pdf->SetXY($left,41);
        $pdf->Cell($w['0'],6,'','L',0,'C');
        $pdf->Cell($w['1'],6,'','LR',0,'C');
        $pdf->Cell($w['2'],6,'','LR',0,'C');
        $pdf->Cell($w['3'],6,'','LR',0,'C');
        $pdf->Cell($w['4'],6,'','LR',0,'C');
        $pdf->Cell($w['5'],6,'','LR',0,'C');
        $pdf->ln();

        $pdf->SetFont('Arial','B',10);
        $pdf->SetXY($left,46);
        $pdf->Cell($w['0'],6,'1','LTB',0,'C');
        $pdf->Cell($w['1'],6,'2','LTRB',0,'C');
        $pdf->Cell($w['2'],6,'3','LTRB',0,'C');
        $pdf->Cell($w['3'],6,'4','LTRB',0,'C');
        $pdf->Cell($w['4'],6,'5','LTRB',0,'C');
        $pdf->Cell($w['5'],6,'6','LTRB',0,'C');
        $pdf->ln();


        $y1 = $pdf->GetY(); // Untuk baris berikutnya
        $y2 = $pdf->GetY(); //untuk baris berikutnya
        $y3 = $pdf->GetY(); //untuk baris berikutnya
        $yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
        $x = 15;
        $ysisa = $y1;

    }


    $y = MAX($y1, $y2, $y3);


    //new data
    $pdf->SetFont('Arial','',8);    
    $pdf->SetXY($x, $y);
    $xcurrent= $x;
    $pdf->MultiCell($w['0'],4,$i,'','C');
    $xcurrent = $xcurrent+$w['0'];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w['1'],4,$data['Kd_Aset1'].'.'.$data['Kd_Aset2'].'.'.$data['Kd_Aset3'].'.'.substr('0'.$data['Kd_Aset4'], -2).'.'.substr('0'.$data['Kd_Aset5'], -2).'-'.substr('0'.$data['no_urut'], -2),'','R');
    $xcurrent = $xcurrent+$w['1'];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w['2'],4,$data['kdAset5']['Nm_Aset5'],'','L');
    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan    
    $xcurrent = $xcurrent+$w['2'];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w['3'],4,number_format($data['nilai_perolehan'],0,',','.'),'','R');
    $xcurrent = $xcurrent+$w['3'];
    $pdf->SetXY($xcurrent, $y);
    if($data['sumber_perolehan'] == 1){
        $sumber_perolehan = 'Belanja';
    }else{
        $sumber_perolehan = 'Hibah';
    }
    $pdf->MultiCell($w['4'],4,$sumber_perolehan.' pada '.$data['tgl_perolehan'],'','L');
    $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent+$w['4'];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w['5'],4,"Ruang $data->attr1; Merk: $data->attr2; Tipe: $data->attr3; CC: $data->attr4; No Rangka: $data->attr8; No Polisi: $data->attr9",'','L');
    $y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent+$w['5'];
    $pdf->SetXY($xcurrent, $y);

    
    $totalKibA = $totalKibA+$data['nilai_perolehan'];

    
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
    // $pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4']+$w['5'],$yst, $w['6'],$ylst);


//Menampilkan jumlah halaman terakhir
$pdf->SetFont('Arial','B',8);
$pdf->setxy($x,$y);
$pdf->Cell($w['0'],6,'','LB');
$pdf->Cell($w['1'],6,'','B',0,'C');
$pdf->Cell($w['2'],6,'TOTAL','B',0,'C');
$pdf->Cell($w['3'],6,'','B',0,'C');
$pdf->Cell($w['4'],6,number_format($totalKibA, 0, ',', '.'),'BLR',0,'R');
$pdf->Cell($w['5'],6,'','BR',0,'R');
// $pdf->Cell($w['5'],6,'','BR',0,'C');

$pdf->ln();

// Penandatangan 
$y = $pdf->GetY()+8;
$pdf->SetXY($xPenandatangan,$y);
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(70,6, \app\models\TaTh::dokudoku('bulat', $ref['set_4']).', '.DATE('j', strtotime($model['tgl_ba'])).' '.bulan(DATE('m', strtotime($model['tgl_ba']))).' '.DATE('Y', strtotime($model['tgl_ba'])), '', 'C', 0);

$pdf->SetXY($xPenandatangan,$pdf->GetY());
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(70,6,$model['jbt_penandatangan'], '', 'C', 0);

$pdf->SetXY($xPenandatangan,$pdf->GetY()+25);
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(70,6,$model['nm_penandatangan'], '', 'C', 0);

$pdf->SetXY($xPenandatangan,$pdf->GetY());
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(70,6,'NIP '.$model['nip_penandatangan'], '', 'C', 0);

// ---------------------------------------------------------------------------------------------------------------------------------------------------
// ---------------------------------KIB C-------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------------------------------------
$pdf->AddPage('L', [216,330]);
$pdf->SetMargins(15,15,15) ;//(float left, float top [, float right]) Halaman F4 216,330
$pdf->SetAutoPageBreak(true, 15); // set bottom margin (boolean auto [, float margin])
$pdf->AliasNbPages();
$left = 15;


$pdf->SetXY($left,$left);
$pdf->SetFont('Arial','B',12);
$pdf->MultiCell(300, 6,'DAFTAR RINCIAN ASET TETAP KARTU INVENTARIS BARANG (KIB) C', '', 'C', 0);
$pdf->MultiCell(300, 6,'ATAS BERITA ACARA REKONSILIASI: '.$model['no_ba'], '', 'C', 0);

$pdf->SetFont('Arial','B',10);
$pdf->SetXY($left,35);
$pdf->Cell($w['0'],11,'NO','LT',0,'C');
$pdf->SetFont('Arial','B',9);
$pdf->Cell($w['1'],11,'Kode','LTR',0,'C');
$pdf->SetFont('Arial','B',10);
$pdf->Cell($w['2'],11,'Uraian ','LTR',0,'C');
$pdf->SetFont('Arial','B',9);
$pdf->Cell($w['3'],11,'Nilai','LTR',0,'C');
$pdf->SetFont('Arial','B',10);
$pdf->Cell($w['4'],11,'Sumber Perolehan','LTR',0,'C');
$pdf->Cell($w['5'],11,'Keterangan','LTR',0,'C');
$pdf->ln();

$pdf->SetFont('Arial','B',10);
$pdf->SetXY($left,41);
$pdf->Cell($w['0'],6,'','L',0,'C');
$pdf->Cell($w['1'],6,'','LR',0,'C');
$pdf->Cell($w['2'],6,'','LR',0,'C');
$pdf->Cell($w['3'],6,'','LR',0,'C');
$pdf->Cell($w['4'],6,'','LR',0,'C');
$pdf->Cell($w['5'],6,'','LR',0,'C');
$pdf->ln();

$pdf->SetFont('Arial','B',10);
$pdf->SetXY($left,46);
$pdf->Cell($w['0'],6,'1','LTB',0,'C');
$pdf->Cell($w['1'],6,'2','LTRB',0,'C');
$pdf->Cell($w['2'],6,'3','LTRB',0,'C');
$pdf->Cell($w['3'],6,'4','LTRB',0,'C');
$pdf->Cell($w['4'],6,'5','LTRB',0,'C');
$pdf->Cell($w['5'],6,'6','LTRB',0,'C');
$pdf->ln();

$y1 = $pdf->GetY(); // Untuk baris berikutnya
$y2 = $pdf->GetY(); //untuk baris berikutnya
$y3 = $pdf->GetY(); //untuk baris berikutnya
$yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
$x = 15;
$i = 1;

$ysisa = $y1;

$totalKibA = 0;


foreach($kibC as $data){

    IF($y2 > 180 || $y1 + (4*(strlen($data['kdAset5']['Nm_Aset5'])/23)) > 180 || $y3 > 180  ){ //cek pagebreak
        $ylst = 190 - $yst; //207 batas margin bawah dikurang dengan y pertama
        //setiap selesai page maka buat rectangle
            $pdf->Rect($x, $yst, $w['0'] ,$ylst);
            $pdf->Rect($x+$w['0'], $yst, $w['1'] ,$ylst);
            $pdf->Rect($x+$w['0']+$w['1'], $yst, $w['2'] ,$ylst);
            $pdf->Rect($x+$w['0']+$w['1']+$w['2'], $yst, $w['3'] ,$ylst);
            $pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3'], $yst, $w['4'] ,$ylst);
            $pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4'], $yst, $w['5'] ,$ylst);
            // $pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4']+$w['5'], $yst ,$w['6'],$ylst);
        
        //setelah buat rectangle baru kemudian addPage
        $pdf->AddPage('L', [216,330]);

        $pdf->SetFont('Arial','B',10);
        $pdf->SetXY($left,35);
        $pdf->Cell($w['0'],11,'NO','LT',0,'C');
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell($w['1'],11,'Kode','LTR',0,'C');
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell($w['2'],11,'Uraian ','LTR',0,'C');
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell($w['3'],11,'Nilai','LTR',0,'C');
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell($w['4'],11,'Sumber Perolehan','LTR',0,'C');
        $pdf->Cell($w['5'],11,'Keterangan','LTR',0,'C');
        $pdf->ln();

        $pdf->SetFont('Arial','B',10);
        $pdf->SetXY($left,41);
        $pdf->Cell($w['0'],6,'','L',0,'C');
        $pdf->Cell($w['1'],6,'','LR',0,'C');
        $pdf->Cell($w['2'],6,'','LR',0,'C');
        $pdf->Cell($w['3'],6,'','LR',0,'C');
        $pdf->Cell($w['4'],6,'','LR',0,'C');
        $pdf->Cell($w['5'],6,'','LR',0,'C');
        $pdf->ln();

        $pdf->SetFont('Arial','B',10);
        $pdf->SetXY($left,46);
        $pdf->Cell($w['0'],6,'1','LTB',0,'C');
        $pdf->Cell($w['1'],6,'2','LTRB',0,'C');
        $pdf->Cell($w['2'],6,'3','LTRB',0,'C');
        $pdf->Cell($w['3'],6,'4','LTRB',0,'C');
        $pdf->Cell($w['4'],6,'5','LTRB',0,'C');
        $pdf->Cell($w['5'],6,'6','LTRB',0,'C');
        $pdf->ln();


        $y1 = $pdf->GetY(); // Untuk baris berikutnya
        $y2 = $pdf->GetY(); //untuk baris berikutnya
        $y3 = $pdf->GetY(); //untuk baris berikutnya
        $yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
        $x = 15;
        $ysisa = $y1;

    }


    $y = MAX($y1, $y2, $y3);


    //new data
    $pdf->SetFont('Arial','',8);    
    $pdf->SetXY($x, $y);
    $xcurrent= $x;
    $pdf->MultiCell($w['0'],4,$i,'','C');
    $xcurrent = $xcurrent+$w['0'];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w['1'],4,$data['Kd_Aset1'].'.'.$data['Kd_Aset2'].'.'.$data['Kd_Aset3'].'.'.substr('0'.$data['Kd_Aset4'], -2).'.'.substr('0'.$data['Kd_Aset5'], -2).'-'.substr('0'.$data['no_urut'], -2),'','R');
    $xcurrent = $xcurrent+$w['1'];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w['2'],4,$data['kdAset5']['Nm_Aset5'],'','L');
    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan    
    $xcurrent = $xcurrent+$w['2'];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w['3'],4,number_format($data['nilai_perolehan'],0,',','.'),'','R');
    $xcurrent = $xcurrent+$w['3'];
    $pdf->SetXY($xcurrent, $y);
    if($data['sumber_perolehan'] == 1){
        $sumber_perolehan = 'Belanja';
    }else{
        $sumber_perolehan = 'Hibah';
    }
    $pdf->MultiCell($w['4'],4,$sumber_perolehan.' pada '.$data['tgl_perolehan'],'','L');
    $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent+$w['4'];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w['5'],4,"Luas $data->attr1; Alamat: $data->attr2; Bertingkat: $data->attr3; Beton: $data->attr4",'','L');
    $y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent+$w['5'];
    $pdf->SetXY($xcurrent, $y);

    
    $totalKibA = $totalKibA+$data['nilai_perolehan'];

    
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
    // $pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4']+$w['5'],$yst, $w['6'],$ylst);


//Menampilkan jumlah halaman terakhir
$pdf->SetFont('Arial','B',8);
$pdf->setxy($x,$y);
$pdf->Cell($w['0'],6,'','LB');
$pdf->Cell($w['1'],6,'','B',0,'C');
$pdf->Cell($w['2'],6,'TOTAL','B',0,'C');
$pdf->Cell($w['3'],6,'','B',0,'C');
$pdf->Cell($w['4'],6,number_format($totalKibA, 0, ',', '.'),'BLR',0,'R');
$pdf->Cell($w['5'],6,'','BR',0,'R');
// $pdf->Cell($w['5'],6,'','BR',0,'C');

$pdf->ln();

// Penandatangan 
$y = $pdf->GetY()+8;
$pdf->SetXY($xPenandatangan,$y);
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(70,6, \app\models\TaTh::dokudoku('bulat', $ref['set_4']).', '.DATE('j', strtotime($model['tgl_ba'])).' '.bulan(DATE('m', strtotime($model['tgl_ba']))).' '.DATE('Y', strtotime($model['tgl_ba'])), '', 'C', 0);

$pdf->SetXY($xPenandatangan,$pdf->GetY());
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(70,6,$model['jbt_penandatangan'], '', 'C', 0);

$pdf->SetXY($xPenandatangan,$pdf->GetY()+25);
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(70,6,$model['nm_penandatangan'], '', 'C', 0);

$pdf->SetXY($xPenandatangan,$pdf->GetY());
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(70,6,'NIP '.$model['nip_penandatangan'], '', 'C', 0);

// ---------------------------------------------------------------------------------------------------------------------------------------------------
// ---------------------------------KIB D-------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------------------------------------
$pdf->AddPage('L', [216,330]);
$pdf->SetMargins(15,15,15) ;//(float left, float top [, float right]) Halaman F4 216,330
$pdf->SetAutoPageBreak(true, 15); // set bottom margin (boolean auto [, float margin])
$pdf->AliasNbPages();
$left = 15;


$pdf->SetXY($left,$left);
$pdf->SetFont('Arial','B',12);
$pdf->MultiCell(300, 6,'DAFTAR RINCIAN ASET TETAP KARTU INVENTARIS BARANG (KIB) D', '', 'C', 0);
$pdf->MultiCell(300, 6,'ATAS BERITA ACARA REKONSILIASI: '.$model['no_ba'], '', 'C', 0);

$pdf->SetFont('Arial','B',10);
$pdf->SetXY($left,35);
$pdf->Cell($w['0'],11,'NO','LT',0,'C');
$pdf->SetFont('Arial','B',9);
$pdf->Cell($w['1'],11,'Kode','LTR',0,'C');
$pdf->SetFont('Arial','B',10);
$pdf->Cell($w['2'],11,'Uraian ','LTR',0,'C');
$pdf->SetFont('Arial','B',9);
$pdf->Cell($w['3'],11,'Nilai','LTR',0,'C');
$pdf->SetFont('Arial','B',10);
$pdf->Cell($w['4'],11,'Sumber Perolehan','LTR',0,'C');
$pdf->Cell($w['5'],11,'Keterangan','LTR',0,'C');
$pdf->ln();

$pdf->SetFont('Arial','B',10);
$pdf->SetXY($left,41);
$pdf->Cell($w['0'],6,'','L',0,'C');
$pdf->Cell($w['1'],6,'','LR',0,'C');
$pdf->Cell($w['2'],6,'','LR',0,'C');
$pdf->Cell($w['3'],6,'','LR',0,'C');
$pdf->Cell($w['4'],6,'','LR',0,'C');
$pdf->Cell($w['5'],6,'','LR',0,'C');
$pdf->ln();

$pdf->SetFont('Arial','B',10);
$pdf->SetXY($left,46);
$pdf->Cell($w['0'],6,'1','LTB',0,'C');
$pdf->Cell($w['1'],6,'2','LTRB',0,'C');
$pdf->Cell($w['2'],6,'3','LTRB',0,'C');
$pdf->Cell($w['3'],6,'4','LTRB',0,'C');
$pdf->Cell($w['4'],6,'5','LTRB',0,'C');
$pdf->Cell($w['5'],6,'6','LTRB',0,'C');
$pdf->ln();

$y1 = $pdf->GetY(); // Untuk baris berikutnya
$y2 = $pdf->GetY(); //untuk baris berikutnya
$y3 = $pdf->GetY(); //untuk baris berikutnya
$yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
$x = 15;
$i = 1;

$ysisa = $y1;

$totalKibA = 0;


foreach($kibD as $data){

    IF($y2 > 180 || $y1 + (4*(strlen($data['kdAset5']['Nm_Aset5'])/23)) > 180 || $y3 > 180  ){ //cek pagebreak
        $ylst = 190 - $yst; //207 batas margin bawah dikurang dengan y pertama
        //setiap selesai page maka buat rectangle
            $pdf->Rect($x, $yst, $w['0'] ,$ylst);
            $pdf->Rect($x+$w['0'], $yst, $w['1'] ,$ylst);
            $pdf->Rect($x+$w['0']+$w['1'], $yst, $w['2'] ,$ylst);
            $pdf->Rect($x+$w['0']+$w['1']+$w['2'], $yst, $w['3'] ,$ylst);
            $pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3'], $yst, $w['4'] ,$ylst);
            $pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4'], $yst, $w['5'] ,$ylst);
            // $pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4']+$w['5'], $yst ,$w['6'],$ylst);
        
        //setelah buat rectangle baru kemudian addPage
        $pdf->AddPage('L', [216,330]);

        $pdf->SetFont('Arial','B',10);
        $pdf->SetXY($left,35);
        $pdf->Cell($w['0'],11,'NO','LT',0,'C');
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell($w['1'],11,'Kode','LTR',0,'C');
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell($w['2'],11,'Uraian ','LTR',0,'C');
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell($w['3'],11,'Nilai','LTR',0,'C');
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell($w['4'],11,'Sumber Perolehan','LTR',0,'C');
        $pdf->Cell($w['5'],11,'Keterangan','LTR',0,'C');
        $pdf->ln();

        $pdf->SetFont('Arial','B',10);
        $pdf->SetXY($left,41);
        $pdf->Cell($w['0'],6,'','L',0,'C');
        $pdf->Cell($w['1'],6,'','LR',0,'C');
        $pdf->Cell($w['2'],6,'','LR',0,'C');
        $pdf->Cell($w['3'],6,'','LR',0,'C');
        $pdf->Cell($w['4'],6,'','LR',0,'C');
        $pdf->Cell($w['5'],6,'','LR',0,'C');
        $pdf->ln();

        $pdf->SetFont('Arial','B',10);
        $pdf->SetXY($left,46);
        $pdf->Cell($w['0'],6,'1','LTB',0,'C');
        $pdf->Cell($w['1'],6,'2','LTRB',0,'C');
        $pdf->Cell($w['2'],6,'3','LTRB',0,'C');
        $pdf->Cell($w['3'],6,'4','LTRB',0,'C');
        $pdf->Cell($w['4'],6,'5','LTRB',0,'C');
        $pdf->Cell($w['5'],6,'6','LTRB',0,'C');
        $pdf->ln();


        $y1 = $pdf->GetY(); // Untuk baris berikutnya
        $y2 = $pdf->GetY(); //untuk baris berikutnya
        $y3 = $pdf->GetY(); //untuk baris berikutnya
        $yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
        $x = 15;
        $ysisa = $y1;

    }


    $y = MAX($y1, $y2, $y3);


    //new data
    $pdf->SetFont('Arial','',8);    
    $pdf->SetXY($x, $y);
    $xcurrent= $x;
    $pdf->MultiCell($w['0'],4,$i,'','C');
    $xcurrent = $xcurrent+$w['0'];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w['1'],4,$data['Kd_Aset1'].'.'.$data['Kd_Aset2'].'.'.$data['Kd_Aset3'].'.'.substr('0'.$data['Kd_Aset4'], -2).'.'.substr('0'.$data['Kd_Aset5'], -2).'-'.substr('0'.$data['no_urut'], -2),'','R');
    $xcurrent = $xcurrent+$w['1'];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w['2'],4,$data['kdAset5']['Nm_Aset5'],'','L');
    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan    
    $xcurrent = $xcurrent+$w['2'];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w['3'],4,number_format($data['nilai_perolehan'],0,',','.'),'','R');
    $xcurrent = $xcurrent+$w['3'];
    $pdf->SetXY($xcurrent, $y);
    if($data['sumber_perolehan'] == 1){
        $sumber_perolehan = 'Belanja';
    }else{
        $sumber_perolehan = 'Hibah';
    }
    $pdf->MultiCell($w['4'],4,$sumber_perolehan.' pada '.$data['tgl_perolehan'],'','L');
    $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent+$w['4'];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w['5'],4,"Luas $data->attr1; Konstruksi: $data->attr2; Dimensi: $data->attr3; Lokasi: $data->attr4",'','L');
    $y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent+$w['5'];
    $pdf->SetXY($xcurrent, $y);

    
    $totalKibA = $totalKibA+$data['nilai_perolehan'];

    
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
    // $pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4']+$w['5'],$yst, $w['6'],$ylst);


//Menampilkan jumlah halaman terakhir
$pdf->SetFont('Arial','B',8);
$pdf->setxy($x,$y);
$pdf->Cell($w['0'],6,'','LB');
$pdf->Cell($w['1'],6,'','B',0,'C');
$pdf->Cell($w['2'],6,'TOTAL','B',0,'C');
$pdf->Cell($w['3'],6,'','B',0,'C');
$pdf->Cell($w['4'],6,number_format($totalKibA, 0, ',', '.'),'BLR',0,'R');
$pdf->Cell($w['5'],6,'','BR',0,'R');
// $pdf->Cell($w['5'],6,'','BR',0,'C');

$pdf->ln();

// Penandatangan 
$y = $pdf->GetY()+8;
$pdf->SetXY($xPenandatangan,$y);
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(70,6, \app\models\TaTh::dokudoku('bulat', $ref['set_4']).', '.DATE('j', strtotime($model['tgl_ba'])).' '.bulan(DATE('m', strtotime($model['tgl_ba']))).' '.DATE('Y', strtotime($model['tgl_ba'])), '', 'C', 0);

$pdf->SetXY($xPenandatangan,$pdf->GetY());
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(70,6,$model['jbt_penandatangan'], '', 'C', 0);

$pdf->SetXY($xPenandatangan,$pdf->GetY()+25);
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(70,6,$model['nm_penandatangan'], '', 'C', 0);

$pdf->SetXY($xPenandatangan,$pdf->GetY());
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(70,6,'NIP '.$model['nip_penandatangan'], '', 'C', 0);

// ---------------------------------------------------------------------------------------------------------------------------------------------------
// ---------------------------------KIB E-------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------------------------------------
$pdf->AddPage('L', [216,330]);
$pdf->SetMargins(15,15,15) ;//(float left, float top [, float right]) Halaman F4 216,330
$pdf->SetAutoPageBreak(true, 15); // set bottom margin (boolean auto [, float margin])
$pdf->AliasNbPages();
$left = 15;


$pdf->SetXY($left,$left);
$pdf->SetFont('Arial','B',12);
$pdf->MultiCell(300, 6,'DAFTAR RINCIAN ASET TETAP KARTU INVENTARIS BARANG (KIB) E', '', 'C', 0);
$pdf->MultiCell(300, 6,'ATAS BERITA ACARA REKONSILIASI: '.$model['no_ba'], '', 'C', 0);

$pdf->SetFont('Arial','B',10);
$pdf->SetXY($left,35);
$pdf->Cell($w['0'],11,'NO','LT',0,'C');
$pdf->SetFont('Arial','B',9);
$pdf->Cell($w['1'],11,'Kode','LTR',0,'C');
$pdf->SetFont('Arial','B',10);
$pdf->Cell($w['2'],11,'Uraian ','LTR',0,'C');
$pdf->SetFont('Arial','B',9);
$pdf->Cell($w['3'],11,'Nilai','LTR',0,'C');
$pdf->SetFont('Arial','B',10);
$pdf->Cell($w['4'],11,'Sumber Perolehan','LTR',0,'C');
$pdf->Cell($w['5'],11,'Keterangan','LTR',0,'C');
$pdf->ln();

$pdf->SetFont('Arial','B',10);
$pdf->SetXY($left,41);
$pdf->Cell($w['0'],6,'','L',0,'C');
$pdf->Cell($w['1'],6,'','LR',0,'C');
$pdf->Cell($w['2'],6,'','LR',0,'C');
$pdf->Cell($w['3'],6,'','LR',0,'C');
$pdf->Cell($w['4'],6,'','LR',0,'C');
$pdf->Cell($w['5'],6,'','LR',0,'C');
$pdf->ln();

$pdf->SetFont('Arial','B',10);
$pdf->SetXY($left,46);
$pdf->Cell($w['0'],6,'1','LTB',0,'C');
$pdf->Cell($w['1'],6,'2','LTRB',0,'C');
$pdf->Cell($w['2'],6,'3','LTRB',0,'C');
$pdf->Cell($w['3'],6,'4','LTRB',0,'C');
$pdf->Cell($w['4'],6,'5','LTRB',0,'C');
$pdf->Cell($w['5'],6,'6','LTRB',0,'C');
$pdf->ln();

$y1 = $pdf->GetY(); // Untuk baris berikutnya
$y2 = $pdf->GetY(); //untuk baris berikutnya
$y3 = $pdf->GetY(); //untuk baris berikutnya
$yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
$x = 15;
$i = 1;

$ysisa = $y1;

$totalKibA = 0;


foreach($kibE as $data){

    IF($y2 > 180 || $y1 + (4*(strlen($data['kdAset5']['Nm_Aset5'])/23)) > 180 || $y3 > 180  ){ //cek pagebreak
        $ylst = 190 - $yst; //207 batas margin bawah dikurang dengan y pertama
        //setiap selesai page maka buat rectangle
            $pdf->Rect($x, $yst, $w['0'] ,$ylst);
            $pdf->Rect($x+$w['0'], $yst, $w['1'] ,$ylst);
            $pdf->Rect($x+$w['0']+$w['1'], $yst, $w['2'] ,$ylst);
            $pdf->Rect($x+$w['0']+$w['1']+$w['2'], $yst, $w['3'] ,$ylst);
            $pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3'], $yst, $w['4'] ,$ylst);
            $pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4'], $yst, $w['5'] ,$ylst);
            // $pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4']+$w['5'], $yst ,$w['6'],$ylst);
        
        //setelah buat rectangle baru kemudian addPage
        $pdf->AddPage('L', [216,330]);

        $pdf->SetFont('Arial','B',10);
        $pdf->SetXY($left,35);
        $pdf->Cell($w['0'],11,'NO','LT',0,'C');
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell($w['1'],11,'Kode','LTR',0,'C');
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell($w['2'],11,'Uraian ','LTR',0,'C');
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell($w['3'],11,'Nilai','LTR',0,'C');
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell($w['4'],11,'Sumber Perolehan','LTR',0,'C');
        $pdf->Cell($w['5'],11,'Keterangan','LTR',0,'C');
        $pdf->ln();

        $pdf->SetFont('Arial','B',10);
        $pdf->SetXY($left,41);
        $pdf->Cell($w['0'],6,'','L',0,'C');
        $pdf->Cell($w['1'],6,'','LR',0,'C');
        $pdf->Cell($w['2'],6,'','LR',0,'C');
        $pdf->Cell($w['3'],6,'','LR',0,'C');
        $pdf->Cell($w['4'],6,'','LR',0,'C');
        $pdf->Cell($w['5'],6,'','LR',0,'C');
        $pdf->ln();

        $pdf->SetFont('Arial','B',10);
        $pdf->SetXY($left,46);
        $pdf->Cell($w['0'],6,'1','LTB',0,'C');
        $pdf->Cell($w['1'],6,'2','LTRB',0,'C');
        $pdf->Cell($w['2'],6,'3','LTRB',0,'C');
        $pdf->Cell($w['3'],6,'4','LTRB',0,'C');
        $pdf->Cell($w['4'],6,'5','LTRB',0,'C');
        $pdf->Cell($w['5'],6,'6','LTRB',0,'C');
        $pdf->ln();


        $y1 = $pdf->GetY(); // Untuk baris berikutnya
        $y2 = $pdf->GetY(); //untuk baris berikutnya
        $y3 = $pdf->GetY(); //untuk baris berikutnya
        $yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
        $x = 15;
        $ysisa = $y1;

    }


    $y = MAX($y1, $y2, $y3);


    //new data
    $pdf->SetFont('Arial','',8);    
    $pdf->SetXY($x, $y);
    $xcurrent= $x;
    $pdf->MultiCell($w['0'],4,$i,'','C');
    $xcurrent = $xcurrent+$w['0'];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w['1'],4,$data['Kd_Aset1'].'.'.$data['Kd_Aset2'].'.'.$data['Kd_Aset3'].'.'.substr('0'.$data['Kd_Aset4'], -2).'.'.substr('0'.$data['Kd_Aset5'], -2).'-'.substr('0'.$data['no_urut'], -2),'','R');
    $xcurrent = $xcurrent+$w['1'];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w['2'],4,$data['kdAset5']['Nm_Aset5'],'','L');
    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan    
    $xcurrent = $xcurrent+$w['2'];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w['3'],4,number_format($data['nilai_perolehan'],0,',','.'),'','R');
    $xcurrent = $xcurrent+$w['3'];
    $pdf->SetXY($xcurrent, $y);
    if($data['sumber_perolehan'] == 1){
        $sumber_perolehan = 'Belanja';
    }else{
        $sumber_perolehan = 'Hibah';
    }
    $pdf->MultiCell($w['4'],4,$sumber_perolehan.' pada '.$data['tgl_perolehan'],'','L');
    $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent+$w['4'];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w['5'],4,"Judul: $data->attr1; Pencipta: $data->attr2; Bahan: $data->attr3; Ukuran: $data->attr4",'','L');
    $y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent+$w['5'];
    $pdf->SetXY($xcurrent, $y);

    
    $totalKibA = $totalKibA+$data['nilai_perolehan'];

    
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
    // $pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4']+$w['5'],$yst, $w['6'],$ylst);


//Menampilkan jumlah halaman terakhir
$pdf->SetFont('Arial','B',8);
$pdf->setxy($x,$y);
$pdf->Cell($w['0'],6,'','LB');
$pdf->Cell($w['1'],6,'','B',0,'C');
$pdf->Cell($w['2'],6,'TOTAL','B',0,'C');
$pdf->Cell($w['3'],6,'','B',0,'C');
$pdf->Cell($w['4'],6,number_format($totalKibA, 0, ',', '.'),'BLR',0,'R');
$pdf->Cell($w['5'],6,'','BR',0,'R');
// $pdf->Cell($w['5'],6,'','BR',0,'C');

$pdf->ln();

// Penandatangan 
$y = $pdf->GetY()+8;
$pdf->SetXY($xPenandatangan,$y);
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(70,6, \app\models\TaTh::dokudoku('bulat', $ref['set_4']).', '.DATE('j', strtotime($model['tgl_ba'])).' '.bulan(DATE('m', strtotime($model['tgl_ba']))).' '.DATE('Y', strtotime($model['tgl_ba'])), '', 'C', 0);

$pdf->SetXY($xPenandatangan,$pdf->GetY());
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(70,6,$model['jbt_penandatangan'], '', 'C', 0);

$pdf->SetXY($xPenandatangan,$pdf->GetY()+25);
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(70,6,$model['nm_penandatangan'], '', 'C', 0);

$pdf->SetXY($xPenandatangan,$pdf->GetY());
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(70,6,'NIP '.$model['nip_penandatangan'], '', 'C', 0);


// ---------------------------------------------------------------------------------------------------------------------------------------------------
// ---------------------------------Rusak Berat-------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------------------------------------
$pdf->AddPage('L', [216,330]);
$pdf->SetMargins(15,15,15) ;//(float left, float top [, float right]) Halaman F4 216,330
$pdf->SetAutoPageBreak(true, 15); // set bottom margin (boolean auto [, float margin])
$pdf->AliasNbPages();
$left = 15;


$pdf->SetXY($left,$left);
$pdf->SetFont('Arial','B',12);
$pdf->MultiCell(300, 6,'DAFTAR RINCIAN ASET TETAP KARTU INVENTARIS BARANG (KIB) RUSAK BERAT', '', 'C', 0);
$pdf->MultiCell(300, 6,'ATAS BERITA ACARA REKONSILIASI: '.$model['no_ba'], '', 'C', 0);

$pdf->SetFont('Arial','B',10);
$pdf->SetXY($left,35);
$pdf->Cell($w['0'],11,'NO','LT',0,'C');
$pdf->SetFont('Arial','B',9);
$pdf->Cell($w['1'],11,'Kode','LTR',0,'C');
$pdf->SetFont('Arial','B',10);
$pdf->Cell($w['2'],11,'Uraian ','LTR',0,'C');
$pdf->SetFont('Arial','B',9);
$pdf->Cell($w['3'],11,'Nilai','LTR',0,'C');
$pdf->SetFont('Arial','B',10);
$pdf->Cell($w['4'],11,'Sumber Perolehan','LTR',0,'C');
$pdf->Cell($w['5'],11,'Keterangan','LTR',0,'C');
$pdf->ln();

$pdf->SetFont('Arial','B',10);
$pdf->SetXY($left,41);
$pdf->Cell($w['0'],6,'','L',0,'C');
$pdf->Cell($w['1'],6,'','LR',0,'C');
$pdf->Cell($w['2'],6,'','LR',0,'C');
$pdf->Cell($w['3'],6,'','LR',0,'C');
$pdf->Cell($w['4'],6,'','LR',0,'C');
$pdf->Cell($w['5'],6,'','LR',0,'C');
$pdf->ln();

$pdf->SetFont('Arial','B',10);
$pdf->SetXY($left,46);
$pdf->Cell($w['0'],6,'1','LTB',0,'C');
$pdf->Cell($w['1'],6,'2','LTRB',0,'C');
$pdf->Cell($w['2'],6,'3','LTRB',0,'C');
$pdf->Cell($w['3'],6,'4','LTRB',0,'C');
$pdf->Cell($w['4'],6,'5','LTRB',0,'C');
$pdf->Cell($w['5'],6,'6','LTRB',0,'C');
$pdf->ln();

$y1 = $pdf->GetY(); // Untuk baris berikutnya
$y2 = $pdf->GetY(); //untuk baris berikutnya
$y3 = $pdf->GetY(); //untuk baris berikutnya
$yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
$x = 15;
$i = 1;

$ysisa = $y1;

$totalKibA = 0;


foreach($rusakBerat as $data){

    IF($y2 > 180 || $y1 + (4*(strlen($data['kdAset5']['Nm_Aset5'])/23)) > 180 || $y3 > 180  ){ //cek pagebreak
        $ylst = 190 - $yst; //207 batas margin bawah dikurang dengan y pertama
        //setiap selesai page maka buat rectangle
            $pdf->Rect($x, $yst, $w['0'] ,$ylst);
            $pdf->Rect($x+$w['0'], $yst, $w['1'] ,$ylst);
            $pdf->Rect($x+$w['0']+$w['1'], $yst, $w['2'] ,$ylst);
            $pdf->Rect($x+$w['0']+$w['1']+$w['2'], $yst, $w['3'] ,$ylst);
            $pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3'], $yst, $w['4'] ,$ylst);
            $pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4'], $yst, $w['5'] ,$ylst);
            // $pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4']+$w['5'], $yst ,$w['6'],$ylst);
        
        //setelah buat rectangle baru kemudian addPage
        $pdf->AddPage('L', [216,330]);

        $pdf->SetFont('Arial','B',10);
        $pdf->SetXY($left,35);
        $pdf->Cell($w['0'],11,'NO','LT',0,'C');
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell($w['1'],11,'Kode','LTR',0,'C');
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell($w['2'],11,'Uraian ','LTR',0,'C');
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell($w['3'],11,'Nilai','LTR',0,'C');
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell($w['4'],11,'Sumber Perolehan','LTR',0,'C');
        $pdf->Cell($w['5'],11,'Keterangan','LTR',0,'C');
        $pdf->ln();

        $pdf->SetFont('Arial','B',10);
        $pdf->SetXY($left,41);
        $pdf->Cell($w['0'],6,'','L',0,'C');
        $pdf->Cell($w['1'],6,'','LR',0,'C');
        $pdf->Cell($w['2'],6,'','LR',0,'C');
        $pdf->Cell($w['3'],6,'','LR',0,'C');
        $pdf->Cell($w['4'],6,'','LR',0,'C');
        $pdf->Cell($w['5'],6,'','LR',0,'C');
        $pdf->ln();

        $pdf->SetFont('Arial','B',10);
        $pdf->SetXY($left,46);
        $pdf->Cell($w['0'],6,'1','LTB',0,'C');
        $pdf->Cell($w['1'],6,'2','LTRB',0,'C');
        $pdf->Cell($w['2'],6,'3','LTRB',0,'C');
        $pdf->Cell($w['3'],6,'4','LTRB',0,'C');
        $pdf->Cell($w['4'],6,'5','LTRB',0,'C');
        $pdf->Cell($w['5'],6,'6','LTRB',0,'C');
        $pdf->ln();


        $y1 = $pdf->GetY(); // Untuk baris berikutnya
        $y2 = $pdf->GetY(); //untuk baris berikutnya
        $y3 = $pdf->GetY(); //untuk baris berikutnya
        $yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
        $x = 15;
        $ysisa = $y1;

    }


    $y = MAX($y1, $y2, $y3);


    //new data
    $pdf->SetFont('Arial','',8);    
    $pdf->SetXY($x, $y);
    $xcurrent= $x;
    $pdf->MultiCell($w['0'],4,$i,'','C');
    $xcurrent = $xcurrent+$w['0'];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w['1'],4,$data['Kd_Aset1'].'.'.$data['Kd_Aset2'].'.'.$data['Kd_Aset3'].'.'.substr('0'.$data['Kd_Aset4'], -2).'.'.substr('0'.$data['Kd_Aset5'], -2).'-'.substr('0'.$data['no_urut'], -2),'','R');
    $xcurrent = $xcurrent+$w['1'];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w['2'],4,$data['kdAset5']['Nm_Aset5'],'','L');
    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan    
    $xcurrent = $xcurrent+$w['2'];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w['3'],4,number_format($data['nilai_perolehan'],0,',','.'),'','R');
    $xcurrent = $xcurrent+$w['3'];
    $pdf->SetXY($xcurrent, $y);
    if($data['sumber_perolehan'] == 1){
        $sumber_perolehan = 'Belanja';
    }else{
        $sumber_perolehan = 'Hibah';
    }
    $pdf->MultiCell($w['4'],4,$sumber_perolehan.' pada '.$data['tgl_perolehan'],'','L');
    $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent+$w['4'];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w['5'],4,"$data->attr1; $data->attr2; $data->attr3; $data->attr4; $data->attr8; $data->attr9",'','L');
    $y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent+$w['5'];
    $pdf->SetXY($xcurrent, $y);

    
    $totalKibA = $totalKibA+$data['nilai_perolehan'];

    
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
    // $pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4']+$w['5'],$yst, $w['6'],$ylst);


//Menampilkan jumlah halaman terakhir
$pdf->SetFont('Arial','B',8);
$pdf->setxy($x,$y);
$pdf->Cell($w['0'],6,'','LB');
$pdf->Cell($w['1'],6,'','B',0,'C');
$pdf->Cell($w['2'],6,'TOTAL','B',0,'C');
$pdf->Cell($w['3'],6,'','B',0,'C');
$pdf->Cell($w['4'],6,number_format($totalKibA, 0, ',', '.'),'BLR',0,'R');
$pdf->Cell($w['5'],6,'','BR',0,'R');
// $pdf->Cell($w['5'],6,'','BR',0,'C');

$pdf->ln();

// Penandatangan 
$y = $pdf->GetY()+8;
$pdf->SetXY($xPenandatangan,$y);
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(70,6, \app\models\TaTh::dokudoku('bulat', $ref['set_4']).', '.DATE('j', strtotime($model['tgl_ba'])).' '.bulan(DATE('m', strtotime($model['tgl_ba']))).' '.DATE('Y', strtotime($model['tgl_ba'])), '', 'C', 0);

$pdf->SetXY($xPenandatangan,$pdf->GetY());
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(70,6,$model['jbt_penandatangan'], '', 'C', 0);

$pdf->SetXY($xPenandatangan,$pdf->GetY()+25);
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(70,6,$model['nm_penandatangan'], '', 'C', 0);

$pdf->SetXY($xPenandatangan,$pdf->GetY());
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(70,6,'NIP '.$model['nip_penandatangan'], '', 'C', 0);


// ---------------------------------------------------------------------------------------------------------------------------------------------------
// ---------------------------------pihak lain-------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------------------------------------
$pdf->AddPage('L', [216,330]);
$pdf->SetMargins(15,15,15) ;//(float left, float top [, float right]) Halaman F4 216,330
$pdf->SetAutoPageBreak(true, 15); // set bottom margin (boolean auto [, float margin])
$pdf->AliasNbPages();
$left = 15;


$pdf->SetXY($left,$left);
$pdf->SetFont('Arial','B',12);
$pdf->MultiCell(300, 6,'DAFTAR RINCIAN ASET TETAP KARTU INVENTARIS BARANG (KIB) PIHAK LAIN YANG DIKUASAI SEKOLAH', '', 'C', 0);
$pdf->MultiCell(300, 6,'ATAS BERITA ACARA REKONSILIASI: '.$model['no_ba'], '', 'C', 0);

$pdf->SetFont('Arial','B',10);
$pdf->SetXY($left,35);
$pdf->Cell($w['0'],11,'NO','LT',0,'C');
$pdf->SetFont('Arial','B',9);
$pdf->Cell($w['1'],11,'Kode','LTR',0,'C');
$pdf->SetFont('Arial','B',10);
$pdf->Cell($w['2'],11,'Uraian ','LTR',0,'C');
$pdf->SetFont('Arial','B',9);
$pdf->Cell($w['3'],11,'Nilai','LTR',0,'C');
$pdf->SetFont('Arial','B',10);
$pdf->Cell($w['4'],11,'Sumber Perolehan','LTR',0,'C');
$pdf->Cell($w['5'],11,'Keterangan','LTR',0,'C');
$pdf->ln();

$pdf->SetFont('Arial','B',10);
$pdf->SetXY($left,41);
$pdf->Cell($w['0'],6,'','L',0,'C');
$pdf->Cell($w['1'],6,'','LR',0,'C');
$pdf->Cell($w['2'],6,'','LR',0,'C');
$pdf->Cell($w['3'],6,'','LR',0,'C');
$pdf->Cell($w['4'],6,'','LR',0,'C');
$pdf->Cell($w['5'],6,'','LR',0,'C');
$pdf->ln();

$pdf->SetFont('Arial','B',10);
$pdf->SetXY($left,46);
$pdf->Cell($w['0'],6,'1','LTB',0,'C');
$pdf->Cell($w['1'],6,'2','LTRB',0,'C');
$pdf->Cell($w['2'],6,'3','LTRB',0,'C');
$pdf->Cell($w['3'],6,'4','LTRB',0,'C');
$pdf->Cell($w['4'],6,'5','LTRB',0,'C');
$pdf->Cell($w['5'],6,'6','LTRB',0,'C');
$pdf->ln();

$y1 = $pdf->GetY(); // Untuk baris berikutnya
$y2 = $pdf->GetY(); //untuk baris berikutnya
$y3 = $pdf->GetY(); //untuk baris berikutnya
$yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
$x = 15;
$i = 1;

$ysisa = $y1;

$totalKibA = 0;


foreach($pihakLain as $data){

    IF($y2 > 180 || $y1 + (4*(strlen($data['kdAset5']['Nm_Aset5'])/23)) > 180 || $y3 > 180  ){ //cek pagebreak
        $ylst = 190 - $yst; //207 batas margin bawah dikurang dengan y pertama
        //setiap selesai page maka buat rectangle
            $pdf->Rect($x, $yst, $w['0'] ,$ylst);
            $pdf->Rect($x+$w['0'], $yst, $w['1'] ,$ylst);
            $pdf->Rect($x+$w['0']+$w['1'], $yst, $w['2'] ,$ylst);
            $pdf->Rect($x+$w['0']+$w['1']+$w['2'], $yst, $w['3'] ,$ylst);
            $pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3'], $yst, $w['4'] ,$ylst);
            $pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4'], $yst, $w['5'] ,$ylst);
            // $pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4']+$w['5'], $yst ,$w['6'],$ylst);
        
        //setelah buat rectangle baru kemudian addPage
        $pdf->AddPage('L', [216,330]);

        $pdf->SetFont('Arial','B',10);
        $pdf->SetXY($left,35);
        $pdf->Cell($w['0'],11,'NO','LT',0,'C');
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell($w['1'],11,'Kode','LTR',0,'C');
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell($w['2'],11,'Uraian ','LTR',0,'C');
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell($w['3'],11,'Nilai','LTR',0,'C');
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell($w['4'],11,'Sumber Perolehan','LTR',0,'C');
        $pdf->Cell($w['5'],11,'Keterangan','LTR',0,'C');
        $pdf->ln();

        $pdf->SetFont('Arial','B',10);
        $pdf->SetXY($left,41);
        $pdf->Cell($w['0'],6,'','L',0,'C');
        $pdf->Cell($w['1'],6,'','LR',0,'C');
        $pdf->Cell($w['2'],6,'','LR',0,'C');
        $pdf->Cell($w['3'],6,'','LR',0,'C');
        $pdf->Cell($w['4'],6,'','LR',0,'C');
        $pdf->Cell($w['5'],6,'','LR',0,'C');
        $pdf->ln();

        $pdf->SetFont('Arial','B',10);
        $pdf->SetXY($left,46);
        $pdf->Cell($w['0'],6,'1','LTB',0,'C');
        $pdf->Cell($w['1'],6,'2','LTRB',0,'C');
        $pdf->Cell($w['2'],6,'3','LTRB',0,'C');
        $pdf->Cell($w['3'],6,'4','LTRB',0,'C');
        $pdf->Cell($w['4'],6,'5','LTRB',0,'C');
        $pdf->Cell($w['5'],6,'6','LTRB',0,'C');
        $pdf->ln();


        $y1 = $pdf->GetY(); // Untuk baris berikutnya
        $y2 = $pdf->GetY(); //untuk baris berikutnya
        $y3 = $pdf->GetY(); //untuk baris berikutnya
        $yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
        $x = 15;
        $ysisa = $y1;

    }


    $y = MAX($y1, $y2, $y3);


    //new data
    $pdf->SetFont('Arial','',8);    
    $pdf->SetXY($x, $y);
    $xcurrent= $x;
    $pdf->MultiCell($w['0'],4,$i,'','C');
    $xcurrent = $xcurrent+$w['0'];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w['1'],4,$data['Kd_Aset1'].'.'.$data['Kd_Aset2'].'.'.$data['Kd_Aset3'].'.'.substr('0'.$data['Kd_Aset4'], -2).'.'.substr('0'.$data['Kd_Aset5'], -2).'-'.substr('0'.$data['no_urut'], -2),'','R');
    $xcurrent = $xcurrent+$w['1'];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w['2'],4,$data['kdAset5']['Nm_Aset5'],'','L');
    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan    
    $xcurrent = $xcurrent+$w['2'];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w['3'],4,number_format($data['nilai_perolehan'],0,',','.'),'','R');
    $xcurrent = $xcurrent+$w['3'];
    $pdf->SetXY($xcurrent, $y);
    if($data['sumber_perolehan'] == 1){
        $sumber_perolehan = 'Belanja';
    }else{
        $sumber_perolehan = 'Hibah';
    }
    $pdf->MultiCell($w['4'],4,$sumber_perolehan.' pada '.$data['tgl_perolehan'],'','L');
    $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent+$w['4'];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w['5'],4,"$data->attr1; $data->attr2; $data->attr3; $data->attr4; $data->attr8; $data->attr9",'','L');
    $y3 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent+$w['5'];
    $pdf->SetXY($xcurrent, $y);

    
    $totalKibA = $totalKibA+$data['nilai_perolehan'];

    
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
    // $pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4']+$w['5'],$yst, $w['6'],$ylst);


//Menampilkan jumlah halaman terakhir
$pdf->SetFont('Arial','B',8);
$pdf->setxy($x,$y);
$pdf->Cell($w['0'],6,'','LB');
$pdf->Cell($w['1'],6,'','B',0,'C');
$pdf->Cell($w['2'],6,'TOTAL','B',0,'C');
$pdf->Cell($w['3'],6,'','B',0,'C');
$pdf->Cell($w['4'],6,number_format($totalKibA, 0, ',', '.'),'BLR',0,'R');
$pdf->Cell($w['5'],6,'','BR',0,'R');
// $pdf->Cell($w['5'],6,'','BR',0,'C');

$pdf->ln();

// Penandatangan 
$y = $pdf->GetY()+8;
$pdf->SetXY($xPenandatangan,$y);
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(70,6, \app\models\TaTh::dokudoku('bulat', $ref['set_4']).', '.DATE('j', strtotime($model['tgl_ba'])).' '.bulan(DATE('m', strtotime($model['tgl_ba']))).' '.DATE('Y', strtotime($model['tgl_ba'])), '', 'C', 0);

$pdf->SetXY($xPenandatangan,$pdf->GetY());
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(70,6,$model['jbt_penandatangan'], '', 'C', 0);

$pdf->SetXY($xPenandatangan,$pdf->GetY()+25);
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(70,6,$model['nm_penandatangan'], '', 'C', 0);

$pdf->SetXY($xPenandatangan,$pdf->GetY());
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(70,6,'NIP '.$model['nip_penandatangan'], '', 'C', 0);

//Untuk mengakhiri dokumen pdf, dan mengirip dokumen ke output
$pdf->Output();
exit;
?>