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
        IF($this->model->kd_sah == 1){
            //Put the watermark
            $this->SetFont('Arial','B',50);
            $this->SetTextColor(163,163,163);
            $this->RotatedText(120,170,'DRAFT USULAN',45);
        }        
    }
    function Footer()
    {
        //ambil link
        // $link = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];        
        // $this->Image("http://api.qrserver.com/v1/create-qr-code/?size=150x150&data=$link", 156, 320 ,5,0,'PNG');        
        // Go to 1.5 cm from bottom
        $this->SetY(-10);
        // Select Arial italic 8
        $this->SetFont('Arial','I',8);
        // Print centered page number
        $this->Cell(0,10,'Printed By BosSTAN | '.$this->PageNo().'/{nb}',0,0,'R');
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
$pdf = new PDF('L','mm',array(216,330));
$pdf->setModel($model);
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

$pdf->Image('images/logo.jpg',15,15,25,30,'');

$pdf->SetXY(40,18);
$pdf->SetFont('Arial','B',14); 
$pdf->MultiCell(275,6, strtoupper(\app\models\TaTh::dokudoku('bulat', $ref['set_10'])), '', 'C', 0);

$pdf->SetXY(40,24);
$pdf->SetFont('Arial','B',12); 
$pdf->MultiCell(275,6,strtoupper($model->sekolah->nama_sekolah), '', 'C', 0);
$pdf->SetXY(40,30);
$pdf->MultiCell(275,6,strtoupper('Surat Pertanggungjawaban Bendahara Sekolah'), '', 'C', 0);
$pdf->SetXY(40,36);
$pdf->MultiCell(275,6,strtoupper('Atas SPJ: '.$model->no_spj), '', 'C', 0);
$pdf->SetXY(15,40);
$pdf->MultiCell(300,6,'', 'B', 'C', 0);

$pdf->SetFont('Times','B',12); 
$pdf->SetXY(15,50);
$pdf->MultiCell(45,6,'Kepala Sekolah', '', 'L', 0);
$pdf->SetXY(60,50);
$pdf->MultiCell(5,6,':', '', 'L', 0);
$pdf->SetFont('Times','',12); 
$pdf->SetXY(63,50);
$pdf->MultiCell(200,6,$model->sekolah->kepala_sekolah, '', 'L', 0);

$pdf->SetFont('Times','B',12); 
$pdf->SetXY(15,56);
$pdf->MultiCell(45,6,'Bendahara Sekolah', '', 'L', 0);
$pdf->SetXY(60,56);
$pdf->MultiCell(5,6,':', '', 'L', 0);
$pdf->SetFont('Times','',12); 
$pdf->SetXY(63,56);
$pdf->MultiCell(200,6,$model->nm_bendahara, '', 'L', 0);


$w = [20,130,30,30,30,30,30]; // Tentukan width masing-masing kolom
 
$pdf->SetFont('Times','B',10);
$pdf->SetXY(15,66);
$pdf->Cell($w['0'],6,'KODE','LBT',0,'C');
$pdf->Cell($w['1'],6,'URAIAN','LBTR',0,'C');
$pdf->Cell($w['2'],6,'ANGGARAN','LBTR',0,'C');
$pdf->Cell($w['3'],6,'s.d SPJ LALU','LBTR',0,'C');
$pdf->Cell($w['4'],6,'SPJ INI','LBTR',0,'C');
$pdf->Cell($w['5'],6,'s.d SPJ INI','LBTR',0,'C');
$pdf->SetFont('Times','B',9);
$pdf->Cell($w['6'],6,'SISA ANGGARAN','LBTR',0,'C');
$pdf->ln();

$y1 = $pdf->GetY(); // Untuk baris berikutnya
$y2 = $pdf->GetY(); //untuk baris berikutnya
$yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
$x = 15;
$program = NULL;
$subprogram = NULL;
$kegiatan = NULL;
$rek1 = NULL;
$i = 1;

$ysisa = $y1;

$totalanggaran = 0;
$totallalu = 0;
$totalini = 0;
$totalsdini = 0;
$totalsisa = 0;
$totalanggaranp = 0;
$totallalup = 0;
$totalinip = 0;
$totalsdinip = 0;
$totalsisap = 0;


foreach($data as $data){

    IF($y2 > 196 || $y1 + (5*(strlen($data['Nm_Rek_5'])/35)) > 196 ){ //cek pagebreak
        $ylst = 207 - $yst; //207 batas margin bawah dikurang dengan y pertama
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
        $pdf->SetFont('Times','B',10);
        $pdf->SetXY(15,15);
        $pdf->Cell($w['0'],6,'KODE','LBT',0,'C');
        $pdf->Cell($w['1'],6,'URAIAN','LBTR',0,'C');
        $pdf->Cell($w['2'],6,'ANGGARAN','LBTR',0,'C');
        $pdf->Cell($w['3'],6,'s.d SPJ LALU','LBTR',0,'C');
        $pdf->Cell($w['4'],6,'SPJ INI','LBTR',0,'C');
        $pdf->Cell($w['5'],6,'s.d SPJ INI','LBTR',0,'C');
        $pdf->SetFont('Times','B',9);
        $pdf->Cell($w['6'],6,'SISA ANGGARAN','LBTR',0,'C');
        $pdf->ln();

        $y1 = $pdf->GetY(); // Untuk baris berikutnya
        $y2 = $pdf->GetY(); //untuk baris berikutnya
        $yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
        $ysisa = $y1;

    }


    $y = max($y1, $y2);

    IF($rek1 == 4 && $data['Kd_Rek_1'] == 5){
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
        $pdf->MultiCell($w['2'],6,number_format($totalanggaranp,0,',','.'),'BT','R');
        $xcurrent = $xcurrent+$w['2'];
        $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w['3'],6,number_format($totallalup,0,',','.'),'BT','R');
        $xcurrent = $xcurrent+$w['3'];
        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w['4'],6,number_format($totalinip,0,',','.'),'BT','R');
        $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
        $xcurrent = $xcurrent+$w['4'];
        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w['5'],6,number_format($totalsdinip,0,',','.'),'BT','R');
        $xcurrent = $xcurrent+$w['5'];
        $pdf->SetXY($xcurrent, $y);
        $pdf->MultiCell($w['6'],6,number_format($totalsisap,0,',','.'),'BTR','R');
        $xcurrent = $xcurrent+$w['6'];
        $pdf->SetXY($xcurrent, $y);    
        $ysisa = $y;
        $pdf->ln();
        $y = max($y1, $y2);            
    }

    IF($kegiatan <> $data['kd_program'].'.'.$data['kd_sub_program'].'.'.$data['kd_kegiatan'].'.'.$data['Kd_Rek_1'] ){
        IF($rek1 <> $data['Kd_Rek_1']){
            switch ($data['Kd_Rek_1']) {
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

        IF($subprogram <> $data['kd_program'].'.'.$data['kd_sub_program'].'.'.$data['Kd_Rek_1']){
            IF($program <> $data['kd_program'].'.'.$data['Kd_Rek_1']){
                //code goes here
                $pdf->SetFont('Times','B',10);
                //new data      
                $pdf->SetXY($x, $y);
                $xcurrent= $x;
                $pdf->MultiCell($w['0'],6,$data['kd_program'] ,'','L');
                $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
                $xcurrent = $xcurrent+$w['0'];
                $pdf->SetXY($xcurrent, $y);
                $pdf->MultiCell($w['1'],6,$data['uraian_program'],'','L');
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
            $pdf->MultiCell($w['0'],6,$data['kd_program'].'.'.substr('0'.$data['kd_sub_program'],-2) ,'','L');
            $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
            $xcurrent = $xcurrent+$w['0'];
            $pdf->SetXY($xcurrent+5, $y);
            $pdf->MultiCell($w['1']-5,6,$data['uraian_sub_program'],'','L');
            $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
            $ysisa = $y;
            $pdf->ln();
            $y = max($y1, $y2);             
        }
        //code goes here
        $pdf->SetFont('Times','',10);
        //new data      
        $pdf->SetXY($x, $y);
        $xcurrent= $x;
        $pdf->MultiCell($w['0'],6,$data['kd_program'].'.'.substr('0'.$data['kd_sub_program'],-2).'.'.substr('0'.$data['kd_kegiatan'],-2) ,'','L');
        $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
        $xcurrent = $xcurrent+$w['0'];
        $pdf->SetXY($xcurrent+10, $y);
        $pdf->MultiCell($w['1']-10,6,$data['uraian_kegiatan'],'','L');
        $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
        $ysisa = $y;
        $pdf->ln();
        $y = max($y1, $y2); 
    }

    $pdf->SetFont('Times','',10);
    //new data      
    $pdf->SetXY($x, $y);
    $xcurrent= $x;
    $pdf->MultiCell($w['0'],6,$data['Kd_Rek_1'].'.'.$data['Kd_Rek_2'].'.'.$data['Kd_Rek_3'].'.'.substr('0'.$data['Kd_Rek_4'],-2).'.'.substr('0'.$data['Kd_Rek_5'],-2) ,'','R');
    $xcurrent = $xcurrent+$w['0'];
    $pdf->SetXY($xcurrent+15, $y);
    $pdf->MultiCell($w['1']-15,6,$data['Nm_Rek_5'],'','L');
    $xcurrent = $xcurrent+$w['1'];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w['2'],6,number_format($data['anggaran'],0,',','.'),'','R');
    $xcurrent = $xcurrent+$w['2'];
    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w['3'],6,number_format($data['spjlalu'],0,',','.'),'','R');
    $xcurrent = $xcurrent+$w['3'];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w['4'],6,number_format($data['spjini'],0,',','.'),'','R');
    $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent+$w['4'];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w['5'],6,number_format($data['sdspjini'],0,',','.'),'','R');
    $xcurrent = $xcurrent+$w['5'];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w['6'],6,number_format($data['sisa_anggaran'],0,',','.'),'','R');
    $xcurrent = $xcurrent+$w['6'];
    $pdf->SetXY($xcurrent, $y);

    IF($data['Kd_Rek_1'] == 5){
        $totalanggaran = $totalanggaran+$data['anggaran'];
        $totallalu = $totallalu+$data['spjlalu'];
        $totalini = $totalini+$data['spjini'];
        $totalsdini = $totalsdini+$data['sdspjini'];
        $totalsisa = $totalsisa+$data['sisa_anggaran'];
        
    }
    IF($data['Kd_Rek_1'] == 4){
        $totalanggaranp = $totalanggaranp+$data['anggaran'];
        $totallalup = $totallalup+$data['spjlalu'];
        $totalinip = $totalinip+$data['spjini'];
        $totalsdinip = $totalsdinip+$data['sdspjini'];
        $totalsisap = $totalsisap+$data['sisa_anggaran'];
        
    }    
    
    $ysisa = $y;

    $i++; //Untuk urutan nomor
    $pdf->ln();

    //simpan untuk cek kegiatan/program
    $kegiatan = $data['kd_program'].'.'.$data['kd_sub_program'].'.'.$data['kd_kegiatan'].'.'.$data['Kd_Rek_1'];
    $subprogram = $data['kd_program'].'.'.$data['kd_sub_program'].'.'.$data['Kd_Rek_1'];
    $program = $data['kd_program'].'.'.$data['Kd_Rek_1'];
    $rek1 = $data['Kd_Rek_1'];


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
$pdf->MultiCell($w['3'],6,number_format($totallalu,0,',','.'),'BT','R');
$xcurrent = $xcurrent+$w['3'];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w['4'],6,number_format($totalini,0,',','.'),'BT','R');
$y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
$xcurrent = $xcurrent+$w['4'];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w['5'],6,number_format($totalsdini,0,',','.'),'BT','R');
$xcurrent = $xcurrent+$w['5'];
$pdf->SetXY($xcurrent, $y);
$pdf->MultiCell($w['6'],6,number_format($totalsisa,0,',','.'),'BTR','R');
$xcurrent = $xcurrent+$w['6'];
$pdf->SetXY($xcurrent, $y);    
$ysisa = $y;
$pdf->ln();
$y = max($y1, $y2);


//membuat kotak di halaman terakhir
$y=$pdf->gety();
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
$pdf->Cell($w['3'],6,number_format($totallalup - $totallalu,0,',','.'),'BL',0,'R');
$pdf->Cell($w['4'],6,number_format($totalinip - $totalini,0,',','.'),'BL',0,'R');
$pdf->Cell($w['5'],6,number_format($totalsdinip - $totalsdini,0,',','.'),'BL',0,'R');
$pdf->Cell($w['6'],6,number_format($totalsisap - $totalsisa,0,',','.'),1,0,'R');

$pdf->ln();
IF(($pdf->gety()+6) >= 175) $pdf->AddPage();
//Menampilkan tanda tangan
$y = $pdf->gety()+6;
$pdf->SetXY(255,$y);
$pdf->SetFont('Times','B',10);
$pdf->MultiCell(255,5,str_replace(['Kelurahan ', 'Desa '], '', $model->sekolah->refDesa->Nm_Desa).', '.DATE('j', strtotime($model->tgl_spj)).' '.bulan(DATE('m', strtotime($model->tgl_spj))).' '.DATE('Y', strtotime($model->tgl_spj)), '', 'J', 0);
$pdf->SetXY(255,$pdf->gety());
$pdf->SetFont('Times','B',10);
$pdf->MultiCell(255,5,$model->jbt_bendahara, '', 'j', 0);
$pdf->SetXY(255,$pdf->gety()+20);
$pdf->SetFont('Times','B',10);
$pdf->MultiCell(255,5,$model['nm_bendahara'], '', 'j', 0);
$pdf->SetX(255);
$pdf->MultiCell(255,5,'NIP '.$model['nip_bendahara'], '', 'j', 0);

$pdf->SetXY(15,$y);
$pdf->SetFont('Times','B',10);
$pdf->MultiCell(255,5,'Mengetahui', '', 'J', 0);
$pdf->SetXY(15,$pdf->gety());
$pdf->SetFont('Times','B',10);
$pdf->MultiCell(255,5,'Kepala Sekolah', '', 'j', 0);
$pdf->SetXY(15,$pdf->gety()+20);
$pdf->SetFont('Times','B',10);
$pdf->MultiCell(255,5,$model['sekolah']['kepala_sekolah'], '', 'j', 0);
$pdf->SetX(15);
$pdf->MultiCell(255,5,'NIP '.$model['sekolah']['nip'], '', 'j', 0);

// Bagian RINCIAN SPJ ------------------------------------------------------------------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------------------------------------------------------------------------------
// $pdf = new PDF('P','mm',array(216,330));
$pdf->AddPage('P', [216,330]);
 
$pdf->Image('images/logo.jpg',15,15,25,30,'');

$pdf->SetXY(40,18);
$pdf->SetFont('Arial','B',14); 
$pdf->MultiCell(160,6, strtoupper(\app\models\TaTh::dokudoku('bulat', $ref['set_10'])), '', 'C', 0);

$pdf->SetXY(40,24);
$pdf->SetFont('Arial','B',12); 
$pdf->MultiCell(160,6,strtoupper($model->sekolah->nama_sekolah), '', 'C', 0);
$pdf->SetXY(40,30);
$pdf->MultiCell(160,6,strtoupper('Rincian Surat Pertanggungjawaban Bendahara Sekolah'), '', 'C', 0);
$pdf->SetXY(40,36);
$pdf->MultiCell(160,6,strtoupper('Atas SPJ: '.$model->no_spj), '', 'C', 0);
$pdf->SetXY(15,40);
$pdf->MultiCell(185,6,'', 'B', 'C', 0);


$w = [10,35,35,15,65,25]; // Tentukan width masing-masing kolom
 
$pdf->SetFont('Times','B',10);
$pdf->SetXY(15,55);
$pdf->Cell($w['0'],6,'NO','LBT',0,'C');
$pdf->Cell($w['1'],6,'NO. REKENING','LBTR',0,'C');
$pdf->Cell($w['2'],6,'NOMOR','LBTR',0,'C');
$pdf->Cell($w['3'],6,'TGL','LBTR',0,'C');
$pdf->Cell($w['4'],6,'URAIAN','LBTR',0,'C');
$pdf->Cell($w['5'],6,'JUMLAH','LBTR',0,'C');
$pdf->ln();

$y1 = $pdf->GetY(); // Untuk baris berikutnya
$y2 = $pdf->GetY(); //untuk baris berikutnya
$yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
$x = 15;
$totaljumlah = NULL;
$kode = NULL;
$i = 1;

$ysisa = $y1;

foreach($bukti as $data){

    IF($y2 > 196 || $y1 + (5*(strlen($data['uraian'])/35)) > 196 ){ //cek pagebreak
        $ylst = 207 - $yst; //207 batas margin bawah dikurang dengan y pertama
        //setiap selesai page maka buat rectangle
        $pdf->Rect($x, $yst, $w['0'] ,$ylst);
        $pdf->Rect($x+$w['0'], $yst, $w['1'] ,$ylst);
        $pdf->Rect($x+$w['0']+$w['1'], $yst, $w['2'] ,$ylst);
        $pdf->Rect($x+$w['0']+$w['1']+$w['2'], $yst, $w['3'] ,$ylst);
        $pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3'], $yst, $w['4'] ,$ylst);
        $pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4'], $yst, $w['5'] ,$ylst);
        
        //setelah buat rectangle baru kemudian addPage
        $pdf->AddPage('P', [216,330]);
        $pdf->SetFont('Times','B',10);
        $pdf->SetXY(15,55);
        $pdf->Cell($w['0'],6,'NO','LBT',0,'C');
        $pdf->Cell($w['1'],6,'NO. REKENING','LBTR',0,'C');
        $pdf->Cell($w['2'],6,'NOMOR','LBTR',0,'C');
        $pdf->Cell($w['3'],6,'TGL','LBTR',0,'C');
        $pdf->Cell($w['4'],6,'URAIAN','LBTR',0,'C');
        $pdf->Cell($w['5'],6,'JUMLAH','LBTR',0,'C');
        $pdf->ln();

        $y1 = $pdf->GetY(); // Untuk baris berikutnya
        $y2 = $pdf->GetY(); //untuk baris berikutnya
        $yst = $pdf->GetY(); //untuk Y pertama sebagai awal rectangle
        $x = 15;

        $ysisa = $y1;

    }


    $y = max($y1, $y2);


    $pdf->SetFont('Times','',10);
    //new data      
    $pdf->SetXY($x, $y);
    $xcurrent= $x;
    $pdf->MultiCell($w['0'],6,$i ,'','C');
    $xcurrent = $xcurrent+$w['0'];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w['1'],6,$data['kd_program'].'.'.$data['kd_sub_program'].'.'.substr('0'.$data['kd_kegiatan'],-2).'.'.$data['Kd_Rek_1'].'.'.$data['Kd_Rek_1'].'.'.$data['Kd_Rek_2'].'.'.$data['Kd_Rek_3'].'.'.substr('0'.$data['Kd_Rek_4'],-2).'.'.substr('0'.$data['Kd_Rek_5'],-2),'','R');
    $xcurrent = $xcurrent+$w['1'];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w['2'],6,$data['no_bukti'],'','L');
    $xcurrent = $xcurrent+$w['2'];
    $y1 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w['3'],6,date('d/m/y', strtotime($data['tgl_bukti'])),'','R');
    $xcurrent = $xcurrent+$w['3'];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w['4'],6,$data['uraian'],'','L');
    $y2 = $pdf->GetY(); //berikan nilai untuk $y1 titik terbawah Uraian Kegiatan
    $xcurrent = $xcurrent+$w['4'];
    $pdf->SetXY($xcurrent, $y);
    $pdf->MultiCell($w['5'],6,$data['Kd_Rek_1'] == 4 ? number_format($data['nilai'],0,',','.') : '('.number_format($data['nilai'],0,',','.').')','','R');

    IF($data['Kd_Rek_1'] == 5){
        $data['nilai'] = -($data['nilai']);
        $totaljumlah = $totaljumlah+$data['nilai'];
        
    }
    IF($data['Kd_Rek_1'] == 4){
        $data['nilai'] = ($data['nilai']);
        $totaljumlah = $totaljumlah+$data['nilai'];
        
    }    
    
    $ysisa = $y;

    $i++; //Untuk urutan nomor
    $pdf->ln();

    //simpan untuk cek kegiatan/program
    $kode = $data['Kd_Rek_1'].'.'.$data['Kd_Rek_2'].'.'.$data['Kd_Rek_3'].'.'.substr('0'.$data['Kd_Rek_4'],-2).'.'.substr('0'.$data['Kd_Rek_5'],-2);


}
$y = max($y1, $y2);


//membuat kotak di halaman terakhir
$y=$pdf->gety();
$ylst = $y - $yst;  //$y batas marjin bawah dikurangi dengan y pertama
$pdf->Rect($x, $yst, $w['0'] ,$ylst);
$pdf->Rect($x+$w['0'], $yst, $w['1'] ,$ylst);
$pdf->Rect($x+$w['0']+$w['1'], $yst, $w['2'] ,$ylst);
$pdf->Rect($x+$w['0']+$w['1']+$w['2'], $yst, $w['3'] ,$ylst);
$pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3'], $yst, $w['4'] ,$ylst);
$pdf->Rect($x+$w['0']+$w['1']+$w['2']+$w['3']+$w['4'], $yst, $w['5'] ,$ylst);



//Menampilkan jumlah halaman terakhir
$pdf->setxy($x,$y);
$pdf->SetFont('Times','BU',10);
$pdf->Cell($w['0'],6,'','LB');
$pdf->Cell($w['1'],6,'TOTAL','LB',0,'C');
$pdf->Cell($w['2'],6,'','BL',0,'R');
$pdf->Cell($w['3'],6,'','BL',0,'R');
$pdf->Cell($w['4'],6,'','BL',0,'R');
$pdf->Cell($w['5'],6,number_format($totaljumlah,0,',','.'),'BLR',0,'R');

$pdf->ln();
IF(($pdf->gety()+6) >= 175) $pdf->AddPage();
//Menampilkan tanda tangan
$pdf->SetXY(150,$pdf->gety()+6);
$pdf->SetFont('Times','B',10);
$pdf->MultiCell(255,5,str_replace(['Kelurahan ', 'Desa '], '', $model->sekolah->refDesa->Nm_Desa).', '.DATE('j', strtotime($model->tgl_spj)).' '.bulan(DATE('m', strtotime($model->tgl_spj))).' '.DATE('Y', strtotime($model->tgl_spj)), '', 'J', 0);
$pdf->SetXY(150,$pdf->gety());
$pdf->SetFont('Times','B',10);
$pdf->MultiCell(255,5,$model->jbt_bendahara, '', 'j', 0);
$pdf->SetXY(150,$pdf->gety()+20);
$pdf->SetFont('Times','B',10);
$pdf->MultiCell(255,5,$model['nm_bendahara'], '', 'j', 0);
$pdf->SetX(150);
$pdf->MultiCell(255,5,'NIP '.$model['nip_bendahara'], '', 'j', 0);


//Untuk mengakhiri dokumen pdf, dan mengirip dokumen ke output
$pdf->Output();
exit;
?>