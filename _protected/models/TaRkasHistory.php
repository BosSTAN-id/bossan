<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "ta_rkas_history".
 *
 * @property string $tahun
 * @property integer $sekolah_id
 * @property integer $perubahan_id
 * @property integer $kd_program
 * @property integer $kd_sub_program
 * @property integer $kd_kegiatan
 * @property integer $Kd_Rek_1
 * @property integer $Kd_Rek_2
 * @property integer $Kd_Rek_3
 * @property integer $Kd_Rek_4
 * @property integer $Kd_Rek_5
 * @property integer $no_rinc
 * @property string $keterangan
 * @property string $sat_1
 * @property string $nilai_1
 * @property string $sat_2
 * @property string $nilai_2
 * @property string $sat_3
 * @property string $nilai_3
 * @property string $satuan123
 * @property string $jml_satuan
 * @property string $nilai_rp
 * @property string $total
 * @property integer $kd_penerimaan_1
 * @property integer $kd_penerimaan_2
 * @property integer $komponen_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property TaRkasPeraturan $tahun0
 */
class TaRkasHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ta_rkas_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tahun', 'sekolah_id', 'perubahan_id', 'kd_program', 'kd_sub_program', 'kd_kegiatan', 'Kd_Rek_1', 'Kd_Rek_2', 'Kd_Rek_3', 'Kd_Rek_4', 'Kd_Rek_5', 'no_rinc', 'keterangan'], 'required'],
            [['tahun'], 'safe'],
            [['sekolah_id', 'perubahan_id', 'kd_program', 'kd_sub_program', 'kd_kegiatan', 'Kd_Rek_1', 'Kd_Rek_2', 'Kd_Rek_3', 'Kd_Rek_4', 'Kd_Rek_5', 'no_rinc', 'kd_penerimaan_1', 'kd_penerimaan_2', 'komponen_id', 'created_at', 'updated_at'], 'integer'],
            [['nilai_1', 'nilai_2', 'nilai_3', 'jml_satuan', 'nilai_rp', 'total'], 'number'],
            [['keterangan'], 'string', 'max' => 255],
            [['sat_1', 'sat_2', 'sat_3'], 'string', 'max' => 10],
            [['satuan123'], 'string', 'max' => 50],
            [['tahun', 'sekolah_id', 'perubahan_id'], 'exist', 'skipOnError' => true, 'targetClass' => TaRkasPeraturan::className(), 'targetAttribute' => ['tahun' => 'tahun', 'sekolah_id' => 'sekolah_id', 'perubahan_id' => 'perubahan_id']],
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
            'perubahan_id' => 'Perubahan ID',
            'kd_program' => 'Kd Program',
            'kd_sub_program' => 'Kd Sub Program',
            'kd_kegiatan' => 'Kd Kegiatan',
            'Kd_Rek_1' => 'Kd  Rek 1',
            'Kd_Rek_2' => 'Kd  Rek 2',
            'Kd_Rek_3' => 'Kd  Rek 3',
            'Kd_Rek_4' => 'Kd  Rek 4',
            'Kd_Rek_5' => 'Kd  Rek 5',
            'no_rinc' => 'No Rinc',
            'keterangan' => 'Keterangan',
            'sat_1' => 'Sat 1',
            'nilai_1' => 'Nilai 1',
            'sat_2' => 'Sat 2',
            'nilai_2' => 'Nilai 2',
            'sat_3' => 'Sat 3',
            'nilai_3' => 'Nilai 3',
            'satuan123' => 'Satuan123',
            'jml_satuan' => 'Jml Satuan',
            'nilai_rp' => 'Nilai Rp',
            'total' => 'Total',
            'kd_penerimaan_1' => 'Kd Penerimaan 1',
            'kd_penerimaan_2' => 'Kd Penerimaan 2',
            'komponen_id' => 'Komponen ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }     

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTahun0()
    {
        return $this->hasOne(TaRkasPeraturan::className(), ['tahun' => 'tahun', 'sekolah_id' => 'sekolah_id', 'perubahan_id' => 'perubahan_id']);
    }
}
