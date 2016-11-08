<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ta_rkas_belanja_rinc".
 *
 * @property string $tahun
 * @property integer $sekolah_id
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
 *
 * @property TaRkasBelanja $tahun0
 */
class TaRkasBelanjaRinc extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ta_rkas_belanja_rinc';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tahun', 'sekolah_id', 'kd_program', 'kd_sub_program', 'kd_kegiatan', 'Kd_Rek_1', 'Kd_Rek_2', 'Kd_Rek_3', 'Kd_Rek_4', 'Kd_Rek_5', 'no_rinc', 'keterangan'], 'required'],
            [['tahun'], 'safe'],
            [['sekolah_id', 'kd_program', 'kd_sub_program', 'kd_kegiatan', 'Kd_Rek_1', 'Kd_Rek_2', 'Kd_Rek_3', 'Kd_Rek_4', 'Kd_Rek_5', 'no_rinc'], 'integer'],
            [['nilai_1', 'nilai_2', 'nilai_3', 'jml_satuan', 'nilai_rp', 'total'], 'number'],
            [['keterangan'], 'string', 'max' => 255],
            [['sat_1', 'sat_2', 'sat_3'], 'string', 'max' => 10],
            [['satuan123'], 'string', 'max' => 50],
            [['tahun', 'sekolah_id', 'kd_program', 'kd_sub_program', 'kd_kegiatan', 'Kd_Rek_1', 'Kd_Rek_2', 'Kd_Rek_3', 'Kd_Rek_4', 'Kd_Rek_5'], 'exist', 'skipOnError' => true, 'targetClass' => TaRkasBelanja::className(), 'targetAttribute' => ['tahun' => 'Tahun', 'sekolah_id' => 'sekolah_id', 'kd_program' => 'kd_program', 'kd_sub_program' => 'kd_sub_program', 'kd_kegiatan' => 'kd_kegiatan', 'Kd_Rek_1' => 'Kd_Rek_1', 'Kd_Rek_2' => 'Kd_Rek_2', 'Kd_Rek_3' => 'Kd_Rek_3', 'Kd_Rek_4' => 'Kd_Rek_4', 'Kd_Rek_5' => 'Kd_Rek_5']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tahun' => Yii::t('app', 'Tahun'),
            'sekolah_id' => Yii::t('app', 'Sekolah ID'),
            'kd_program' => Yii::t('app', 'Kd Program'),
            'kd_sub_program' => Yii::t('app', 'Kd Sub Program'),
            'kd_kegiatan' => Yii::t('app', 'Kd Kegiatan'),
            'Kd_Rek_1' => Yii::t('app', 'Kd  Rek 1'),
            'Kd_Rek_2' => Yii::t('app', 'Kd  Rek 2'),
            'Kd_Rek_3' => Yii::t('app', 'Kd  Rek 3'),
            'Kd_Rek_4' => Yii::t('app', 'Kd  Rek 4'),
            'Kd_Rek_5' => Yii::t('app', 'Kd  Rek 5'),
            'no_rinc' => Yii::t('app', 'No Rinc'),
            'keterangan' => Yii::t('app', 'Keterangan'),
            'sat_1' => Yii::t('app', 'Sat 1'),
            'nilai_1' => Yii::t('app', 'Nilai 1'),
            'sat_2' => Yii::t('app', 'Sat 2'),
            'nilai_2' => Yii::t('app', 'Nilai 2'),
            'sat_3' => Yii::t('app', 'Sat 3'),
            'nilai_3' => Yii::t('app', 'Nilai 3'),
            'satuan123' => Yii::t('app', 'Satuan123'),
            'jml_satuan' => Yii::t('app', 'Jml Satuan'),
            'nilai_rp' => Yii::t('app', 'Nilai Rp'),
            'total' => Yii::t('app', 'Total'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTahun0()
    {
        return $this->hasOne(TaRkasBelanja::className(), ['Tahun' => 'tahun', 'sekolah_id' => 'sekolah_id', 'kd_program' => 'kd_program', 'kd_sub_program' => 'kd_sub_program', 'kd_kegiatan' => 'kd_kegiatan', 'Kd_Rek_1' => 'Kd_Rek_1', 'Kd_Rek_2' => 'Kd_Rek_2', 'Kd_Rek_3' => 'Kd_Rek_3', 'Kd_Rek_4' => 'Kd_Rek_4', 'Kd_Rek_5' => 'Kd_Rek_5']);
    }
}
