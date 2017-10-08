<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

class TaAsetTetap extends \yii\db\ActiveRecord
{

    const KONDISI_BAIK = 1;
    const KONDISI_RUSAK_RINGAN_SEDANG = 2;
    const KONDISI_RUSAK_BERAT  = 3;   

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ta_aset_tetap';
    }

    public $jumlahBarang;
    public $kode25;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tahun', 'sekolah_id', 'Kd_Aset1', 'Kd_Aset2', 'Kd_Aset3', 'Kd_Aset4', 'Kd_Aset5', 'no_register'], 'required'],
            [['tahun', 'tgl_perolehan'], 'safe'],
            [['jumlahBarang', 'sekolah_id', 'Kd_Aset1', 'Kd_Aset2', 'Kd_Aset3', 'Kd_Aset4', 'Kd_Aset5', 'no_urut', 'kepemilikan', 'sumber_perolehan', 'kondisi', 'created_at', 'updated_at'], 'integer'],
            [['nilai_perolehan', 'masa_manfaat', 'nilai_sisa'], 'number'],
            [['no_register'], 'string', 'max' => 100],
            [['kode25'], 'string'],
            [['referensi_bukti', 'keterangan', 'attr1', 'attr2', 'attr3', 'attr4', 'attr5', 'attr6', 'attr7', 'attr8', 'attr9', 'attr10'], 'string', 'max' => 255],
            [['tahun', 'sekolah_id', 'Kd_Aset1', 'Kd_Aset2', 'Kd_Aset3', 'Kd_Aset4', 'Kd_Aset5', 'no_register'], 'unique', 'targetAttribute' => ['tahun', 'sekolah_id', 'Kd_Aset1', 'Kd_Aset2', 'Kd_Aset3', 'Kd_Aset4', 'Kd_Aset5', 'no_register'], 'message' => 'The combination of Tahun, Sekolah ID, Kd  Aset1, Kd  Aset2, Kd  Aset3, Kd  Aset4, Kd  Aset5 and No Register has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tahun' => 'Tahun',
            'sekolah_id' => 'Sekolah ID',
            'Kd_Aset1' => 'Kd  Aset1',
            'Kd_Aset2' => 'Kd  Aset2',
            'Kd_Aset3' => 'Kd  Aset3',
            'Kd_Aset4' => 'Kd  Aset4',
            'Kd_Aset5' => 'Kd  Aset5',
            'no_urut' => 'No Urut',
            'no_register' => 'No Register',
            'kepemilikan' => 'Kepemilikan',
            'sumber_perolehan' => 'Sumber Perolehan',
            'referensi_bukti' => 'Referensi Bukti',
            'tgl_perolehan' => 'Tgl Perolehan',
            'nilai_perolehan' => 'Nilai Perolehan',
            'masa_manfaat' => 'Masa Manfaat',
            'nilai_sisa' => 'Nilai Sisa',
            'kondisi' => 'Kondisi',
            'keterangan' => 'Keterangan',
            'attr1' => 'Attr1',
            'attr2' => 'Attr2',
            'attr3' => 'Attr3',
            'attr4' => 'Attr4',
            'attr5' => 'Attr5',
            'attr6' => 'Attr6',
            'attr7' => 'Attr7',
            'attr8' => 'Attr8',
            'attr9' => 'Attr9',
            'attr10' => 'Attr10',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'jumlahBarang' => 'Jumlah Barang',
            'kode25' => 'Jenis Barang',
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function saveMulti(){
        $tahun = $this->tahun;
        $sekolah_id = $this->sekolah_id;
        $Kd_Aset1 = $this->Kd_Aset1;
        $Kd_Aset2 = $this->Kd_Aset2;
        $Kd_Aset3 = $this->Kd_Aset3;
        $Kd_Aset4 = $this->Kd_Aset4;
        $Kd_Aset5 = $this->Kd_Aset5;
        $kepemilikan = $this->kepemilikan;
        $sumber_perolehan = $this->sumber_perolehan;
        $referensi_bukti = $this->referensi_bukti;
        $tgl_perolehan = $this->tgl_perolehan;
        $nilai_perolehan = $this->nilai_perolehan;
        $masa_manfaat = $this->masa_manfaat;
        $nilai_sisa = $this->nilai_sisa;
        $keterangan = $this->keterangan;
        $attr1 = $this->attr1;
        $attr2 = $this->attr2;
        $attr3 = $this->attr3;
        $attr4 = $this->attr4;
        $attr5 = $this->attr5;
        $attr6 = $this->attr6;
        $attr7 = $this->attr7;
        $attr8 = $this->attr8;
        $attr9 = $this->attr9;
        $attr10 = $this->attr10;
        $jumlahBarang = $this->jumlahBarang;
        while($jumlahBarang> 0){
            $model = new TaAsetTetap();
            $model->tahun = $tahun;
            $model->sekolah_id = $sekolah_id;
            $model->Kd_Aset1 = $Kd_Aset1;
            $model->Kd_Aset2 = $Kd_Aset2;
            $model->Kd_Aset3 = $Kd_Aset3;
            $model->Kd_Aset4 = $Kd_Aset4;
            $model->Kd_Aset5 = $Kd_Aset5;
            $model->no_register = \thamtech\uuid\helpers\UuidHelper::uuid();
            $maxNoAsetIni = TaAsetTetap::find()->where([
                'tahun' => $model->tahun,
                'sekolah_id' => $model->sekolah_id,
                'Kd_Aset1' => $model->Kd_Aset1,
                'Kd_Aset2' => $model->Kd_Aset2,
                'Kd_Aset3' => $model->Kd_Aset3,
                'Kd_Aset4' => $model->Kd_Aset4,
                'Kd_Aset5' => $model->Kd_Aset5,
            ])->orderBy('no_urut DESC')->one();
            $model->no_urut = $maxNoAsetIni['no_urut'] + 1;
            $model->kepemilikan = $kepemilikan;
            $model->sumber_perolehan = $sumber_perolehan;
            $model->referensi_bukti = $referensi_bukti;
            $model->tgl_perolehan = $tgl_perolehan;
            $model->nilai_perolehan = $nilai_perolehan;
            $model->masa_manfaat = $masa_manfaat;
            $model->nilai_sisa = $nilai_sisa;
            $model->keterangan = $keterangan;
            $model->kondisi = 1;
            $model->attr1 = $attr1;
            $model->attr2 = $attr2;
            $model->attr3 = $attr3;
            $model->attr4 = $attr4;
            $model->attr5 = $attr5;
            $model->attr6 = $attr6;
            $model->attr7 = $attr7;
            $model->attr8 = $attr8;
            $model->attr9 = $attr9;
            $model->attr10 = $attr10;
            // return var_dump($model->validate());     
            if(!$model->save()) return false;
            $jumlahBarang--;
        }
        return true;
    }

    // public function beforeSave($insert)
    // {
    //     if (!parent::beforeSave($insert)) {
    //         return false;
    //     }

    //     $uuid = \thamtech\uuid\helpers\UuidHelper::uuid();
        
    //     // ...custom code here...
    //     if($insert){
    //         $this->no_register = $uuid;
    //     }
    //     // return true;
    //     return parent::beforeSave($insert);
    // }

    public function getKdAset5()
    {
        return $this->hasOne(RefRekAset5::className(), ['Kd_Aset1' => 'Kd_Aset1', 'Kd_Aset2' => 'Kd_Aset2', 'Kd_Aset3' => 'Kd_Aset3', 'Kd_Aset4' => 'Kd_Aset4', 'Kd_Aset5' => 'Kd_Aset5']);
    }

    public function getKdAset4()
    {
        return $this->hasOne(RefRekAset4::className(), ['Kd_Aset1' => 'Kd_Aset1', 'Kd_Aset2' => 'Kd_Aset2', 'Kd_Aset3' => 'Kd_Aset3', 'Kd_Aset4' => 'Kd_Aset4']);
    }

    public function getKdAset3()
    {
        return $this->hasOne(RefRekAset3::className(), ['Kd_Aset1' => 'Kd_Aset1', 'Kd_Aset2' => 'Kd_Aset2', 'Kd_Aset3' => 'Kd_Aset3']);
    }    


    public function getKdAset2()
    {
        return $this->hasOne(RefRekAset2::className(), ['Kd_Aset1' => 'Kd_Aset1', 'Kd_Aset2' => 'Kd_Aset2']);
    }    

    public function getKdAset1()
    {
        return $this->hasOne(RefRekAset1::className(), ['Kd_Aset1' => 'Kd_Aset1']);
    }

    public function getKondisi()
    {
        switch ($this->kondisi) {
            case 1:
                # code...
                break;
            
            default:
                # code...
                break;
        }
    }
}
