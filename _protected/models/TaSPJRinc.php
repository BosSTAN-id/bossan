<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ta_spj_rinc".
 *
 * @property string $tahun
 * @property string $no_bukti
 * @property string $tgl_bukti
 * @property string $no_spj
 * @property integer $no_urut
 * @property integer $sekolah_id
 * @property integer $kd_program
 * @property integer $kd_sub_program
 * @property integer $kd_kegiatan
 * @property integer $Kd_Rek_1
 * @property integer $Kd_Rek_2
 * @property integer $Kd_Rek_3
 * @property integer $Kd_Rek_4
 * @property integer $Kd_Rek_5
 * @property integer $komponen_id
 * @property integer $pembayaran
 * @property string $nilai
 * @property string $nm_penerima
 * @property string $alamat_penerima
 * @property string $uraian
 * @property integer $bank_id
 *
 * @property TaSpjPot[] $taSpjPots
 * @property RefPotongan[] $kdPotongans
 */
class TaSPJRinc extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ta_spj_rinc';
    }

    public $rek5;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tahun', 'no_bukti', 'tgl_bukti'], 'required'],
            [['tahun', 'tgl_bukti'], 'safe'],
            [['no_urut', 'sekolah_id', 'kd_program', 'kd_sub_program', 'kd_kegiatan', 'Kd_Rek_1', 'Kd_Rek_2', 'Kd_Rek_3', 'Kd_Rek_4', 'Kd_Rek_5', 'komponen_id', 'pembayaran', 'bank_id'], 'integer'],
            [['nilai'], 'number'],
            [['no_bukti'], 'unique', 'message' => 'No Bukti ini sudah pernah ada'],
            // [
            //     'no_bukti',
            //     'unique',
            //     'message' => 'No Bukti ini sudah pernah ada',
            //     'when' => function ($model) {
            //         return !empty($model->no_bukti);
            //     },
            //     'whenClient' => new JsExpression("function (attribute, value) {
            //         return $('#taspjrinc-no_bukti').val().length > 0;
            //     }")
            // ],
            [['no_bukti', 'no_spj', 'rek5'], 'string', 'max' => 50],
            [['nm_penerima'], 'string', 'max' => 100],
            [['alamat_penerima', 'uraian'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tahun' => 'Tahun',
            'no_bukti' => 'No Bukti',
            'tgl_bukti' => 'Tgl Bukti',
            'no_spj' => 'No Spj',
            'no_urut' => 'No Urut',
            'sekolah_id' => 'Sekolah ID',
            'kd_program' => 'Kd Program',
            'kd_sub_program' => 'Kd Sub Program',
            'kd_kegiatan' => 'Kd Kegiatan',
            'Kd_Rek_1' => 'Kd  Rek 1',
            'Kd_Rek_2' => 'Kd  Rek 2',
            'Kd_Rek_3' => 'Kd  Rek 3',
            'Kd_Rek_4' => 'Kd  Rek 4',
            'Kd_Rek_5' => 'Kd  Rek 5',
            'komponen_id' => 'Komponen ID',
            'pembayaran' => 'Pembayaran',
            'nilai' => 'Nilai',
            'nm_penerima' => 'Nm Penerima',
            'alamat_penerima' => 'Alamat Penerima',
            'uraian' => 'Uraian',
            'bank_id' => 'Bank ID',
            'rek5' => 'Rekening Belanja/Pendapatan' ,            
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaSpjPots()
    {
        return $this->hasMany(TaSpjPot::className(), ['tahun' => 'tahun', 'no_bukti' => 'no_bukti']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKdPotongans()
    {
        return $this->hasMany(RefPotongan::className(), ['kd_potongan' => 'kd_potongan'])->viaTable('ta_spj_pot', ['tahun' => 'tahun', 'no_bukti' => 'no_bukti']);
    }

    public function getRefRek5()
    {
        return $this->hasOne(RefRek5::className(), ['Kd_Rek_1' => 'Kd_Rek_1', 'Kd_Rek_2' => 'Kd_Rek_2', 'Kd_Rek_3' => 'Kd_Rek_3', 'Kd_Rek_4' => 'Kd_Rek_4', 'Kd_Rek_5' => 'Kd_Rek_5']);
    }

    public function getRefRek3()
    {
        return $this->hasOne(RefRek3::className(), ['Kd_Rek_1' => 'Kd_Rek_1', 'Kd_Rek_2' => 'Kd_Rek_2', 'Kd_Rek_3' => 'Kd_Rek_3']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaRkasBelanjaRincs()
    {
        return $this->hasMany(TaRkasBelanjaRinc::className(), ['tahun' => 'tahun', 'sekolah_id' => 'sekolah_id', 'kd_program' => 'kd_program', 'kd_sub_program' => 'kd_sub_program', 'kd_kegiatan' => 'kd_kegiatan', 'Kd_Rek_1' => 'Kd_Rek_1', 'Kd_Rek_2' => 'Kd_Rek_2', 'Kd_Rek_3' => 'Kd_Rek_3', 'Kd_Rek_4' => 'Kd_Rek_4', 'Kd_Rek_5' => 'Kd_Rek_5']);
    }

    public function getKomponen()
    {
        return $this->hasOne(RefKomponenBos::className(), ['id' => 'komponen_id']);
    }

    public function getSekolah()
    {
        return $this->hasOne(RefSekolah::className(), ['id' => 'sekolah_id']);
    }

    public function getPenerimaan2()
    {
        return $this->hasOne(\app\models\RefPenerimaanSekolah2::className(), ['kd_penerimaan_1' => 'kd_penerimaan_1', 'kd_penerimaan_2' => 'kd_penerimaan_2']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefKegiatan()
    {
        return $this->hasOne(RefKegiatanSekolah::className(), ['kd_program' => 'kd_program', 'kd_sub_program' => 'kd_sub_program', 'kd_kegiatan' => 'kd_kegiatan']);
    }

    public function getRefProgram()
    {
        return $this->hasOne(RefProgramSekolah::className(), ['kd_program' => 'kd_program']);
    }  

    public function getRefSubProgram()
    {
        return $this->hasOne(RefSubProgramSekolah::className(), ['kd_program' => 'kd_program', 'kd_sub_program' => 'kd_sub_program']);
    }     
}
