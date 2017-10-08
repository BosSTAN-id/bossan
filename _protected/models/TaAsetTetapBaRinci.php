<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ta_aset_tetap_ba_rinci".
 *
 * @property string $tahun
 * @property integer $sekolah_id
 * @property string $no_ba
 * @property integer $Kd_Aset1
 * @property integer $Kd_Aset2
 * @property integer $Kd_Aset3
 * @property integer $Kd_Aset4
 * @property integer $Kd_Aset5
 * @property string $no_register
 * @property integer $kepemilikan
 * @property integer $sumber_perolehan
 * @property string $referensi_bukti
 * @property string $tgl_perolehan
 * @property string $nilai_perolehan
 * @property string $masa_manfaat
 * @property string $nilai_sisa
 * @property integer $kondisi
 * @property string $keterangan
 * @property string $attr1
 * @property string $attr2
 * @property string $attr3
 * @property string $attr4
 * @property string $attr5
 * @property string $attr6
 * @property string $attr7
 * @property string $attr8
 * @property string $attr9
 * @property string $attr10
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property TaAsetTetapBa $tahun0
 */
class TaAsetTetapBaRinci extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ta_aset_tetap_ba_rinci';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tahun', 'sekolah_id', 'no_ba', 'Kd_Aset1', 'Kd_Aset2', 'Kd_Aset3', 'Kd_Aset4', 'Kd_Aset5', 'no_register'], 'required'],
            [['tahun', 'tgl_perolehan'], 'safe'],
            [['sekolah_id', 'Kd_Aset1', 'Kd_Aset2', 'Kd_Aset3', 'Kd_Aset4', 'Kd_Aset5', 'kepemilikan', 'sumber_perolehan', 'kondisi', 'created_at', 'updated_at'], 'integer'],
            [['nilai_perolehan', 'masa_manfaat', 'nilai_sisa'], 'number'],
            [['no_ba'], 'string', 'max' => 50],
            [['no_register'], 'string', 'max' => 100],
            [['referensi_bukti', 'keterangan', 'attr1', 'attr2', 'attr3', 'attr4', 'attr5', 'attr6', 'attr7', 'attr8', 'attr9', 'attr10'], 'string', 'max' => 255],
            [['tahun', 'sekolah_id', 'Kd_Aset1', 'Kd_Aset2', 'Kd_Aset3', 'Kd_Aset4', 'Kd_Aset5', 'no_register'], 'unique', 'targetAttribute' => ['tahun', 'sekolah_id', 'Kd_Aset1', 'Kd_Aset2', 'Kd_Aset3', 'Kd_Aset4', 'Kd_Aset5', 'no_register'], 'message' => 'The combination of Tahun, Sekolah ID, Kd  Aset1, Kd  Aset2, Kd  Aset3, Kd  Aset4, Kd  Aset5 and No Register has already been taken.'],
            [['tahun', 'sekolah_id', 'no_ba'], 'exist', 'skipOnError' => true, 'targetClass' => TaAsetTetapBa::className(), 'targetAttribute' => ['tahun' => 'tahun', 'sekolah_id' => 'sekolah_id', 'no_ba' => 'no_ba']],
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
            'no_ba' => 'No Ba',
            'Kd_Aset1' => 'Kd  Aset1',
            'Kd_Aset2' => 'Kd  Aset2',
            'Kd_Aset3' => 'Kd  Aset3',
            'Kd_Aset4' => 'Kd  Aset4',
            'Kd_Aset5' => 'Kd  Aset5',
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTahun0()
    {
        return $this->hasOne(TaAsetTetapBa::className(), ['tahun' => 'tahun', 'sekolah_id' => 'sekolah_id', 'no_ba' => 'no_ba']);
    }

    public function getKdAset5()
    {
        return $this->hasOne(RefRekAset5::className(), ['Kd_Aset1' => 'Kd_Aset1', 'Kd_Aset2' => 'Kd_Aset2', 'Kd_Aset3' => 'Kd_Aset3', 'Kd_Aset4' => 'Kd_Aset4', 'Kd_Aset5' => 'Kd_Aset5']);
    }    
}
