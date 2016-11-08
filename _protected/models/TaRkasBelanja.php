<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ta_rkas_belanja".
 *
 * @property string $Tahun
 * @property integer $sekolah_id
 * @property integer $kd_program
 * @property integer $kd_sub_program
 * @property integer $kd_kegiatan
 * @property integer $Kd_Rek_1
 * @property integer $Kd_Rek_2
 * @property integer $Kd_Rek_3
 * @property integer $Kd_Rek_4
 * @property integer $Kd_Rek_5
 * @property integer $kd_penerimaan_1
 * @property integer $kd_penerimaan_2
 * @property integer $komponen_id
 *
 * @property RefRek5 $kdRek1
 * @property RefPenerimaanSekolah2 $kdPenerimaan1
 * @property TaRkasKegiatan $tahun
 * @property TaRkasBelanjaRinc[] $taRkasBelanjaRincs
 */
class TaRkasBelanja extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ta_rkas_belanja';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Tahun', 'sekolah_id', 'kd_program', 'kd_sub_program', 'kd_kegiatan', 'Kd_Rek_1', 'Kd_Rek_2', 'Kd_Rek_3', 'Kd_Rek_4', 'Kd_Rek_5'], 'required'],
            [['Tahun'], 'safe'],
            [['sekolah_id', 'kd_program', 'kd_sub_program', 'kd_kegiatan', 'Kd_Rek_1', 'Kd_Rek_2', 'Kd_Rek_3', 'Kd_Rek_4', 'Kd_Rek_5', 'kd_penerimaan_1', 'kd_penerimaan_2', 'komponen_id'], 'integer'],
            [['Kd_Rek_1', 'Kd_Rek_2', 'Kd_Rek_3', 'Kd_Rek_4', 'Kd_Rek_5'], 'exist', 'skipOnError' => true, 'targetClass' => RefRek5::className(), 'targetAttribute' => ['Kd_Rek_1' => 'Kd_Rek_1', 'Kd_Rek_2' => 'Kd_Rek_2', 'Kd_Rek_3' => 'Kd_Rek_3', 'Kd_Rek_4' => 'Kd_Rek_4', 'Kd_Rek_5' => 'Kd_Rek_5']],
            [['kd_penerimaan_1', 'kd_penerimaan_2'], 'exist', 'skipOnError' => true, 'targetClass' => RefPenerimaanSekolah2::className(), 'targetAttribute' => ['kd_penerimaan_1' => 'kd_penerimaan_1', 'kd_penerimaan_2' => 'kd_penerimaan_2']],
            [['Tahun', 'sekolah_id', 'kd_program', 'kd_sub_program', 'kd_kegiatan'], 'exist', 'skipOnError' => true, 'targetClass' => TaRkasKegiatan::className(), 'targetAttribute' => ['Tahun' => 'tahun', 'sekolah_id' => 'sekolah_id', 'kd_program' => 'kd_program', 'kd_sub_program' => 'kd_sub_program', 'kd_kegiatan' => 'kd_kegiatan']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Tahun' => Yii::t('app', 'Tahun'),
            'sekolah_id' => Yii::t('app', 'Sekolah ID'),
            'kd_program' => Yii::t('app', 'Kd Program'),
            'kd_sub_program' => Yii::t('app', 'Kd Sub Program'),
            'kd_kegiatan' => Yii::t('app', 'Kd Kegiatan'),
            'Kd_Rek_1' => Yii::t('app', 'Kd  Rek 1'),
            'Kd_Rek_2' => Yii::t('app', 'Kd  Rek 2'),
            'Kd_Rek_3' => Yii::t('app', 'Kd  Rek 3'),
            'Kd_Rek_4' => Yii::t('app', 'Kd  Rek 4'),
            'Kd_Rek_5' => Yii::t('app', 'Kd  Rek 5'),
            'kd_penerimaan_1' => Yii::t('app', 'Kd Penerimaan 1'),
            'kd_penerimaan_2' => Yii::t('app', 'Kd Penerimaan 2'),
            'komponen_id' => Yii::t('app', 'Komponen ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefRek5()
    {
        return $this->hasOne(RefRek5::className(), ['Kd_Rek_1' => 'Kd_Rek_1', 'Kd_Rek_2' => 'Kd_Rek_2', 'Kd_Rek_3' => 'Kd_Rek_3', 'Kd_Rek_4' => 'Kd_Rek_4', 'Kd_Rek_5' => 'Kd_Rek_5']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaRkasBelanjaRincs()
    {
        return $this->hasMany(TaRkasBelanjaRinc::className(), ['tahun' => 'Tahun', 'sekolah_id' => 'sekolah_id', 'kd_program' => 'kd_program', 'kd_sub_program' => 'kd_sub_program', 'kd_kegiatan' => 'kd_kegiatan', 'Kd_Rek_1' => 'Kd_Rek_1', 'Kd_Rek_2' => 'Kd_Rek_2', 'Kd_Rek_3' => 'Kd_Rek_3', 'Kd_Rek_4' => 'Kd_Rek_4', 'Kd_Rek_5' => 'Kd_Rek_5']);
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
