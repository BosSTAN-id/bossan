<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ta_rkas_kegiatan".
 *
 * @property string $tahun
 * @property integer $sekolah_id
 * @property integer $kd_program
 * @property integer $kd_sub_program
 * @property integer $kd_kegiatan
 * @property string $pagu_anggaran
 * @property integer $kd_penerimaan_1
 * @property integer $kd_penerimaan_2
 *
 * @property TaRkasBelanja[] $taRkasBelanjas
 * @property RefRek5[] $kdRek1s
 * @property RefSekolah $sekolah
 * @property RefKegiatanSekolah $kdProgram
 */
class TaRkasKegiatan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ta_rkas_kegiatan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tahun', 'sekolah_id', 'kd_program', 'kd_sub_program', 'kd_kegiatan'], 'required'],
            [['tahun'], 'safe'],
            [['sekolah_id', 'kd_program', 'kd_sub_program', 'kd_kegiatan', 'kd_penerimaan_1', 'kd_penerimaan_2'], 'integer'],
            [['pagu_anggaran'], 'number'],
            [['sekolah_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefSekolah::className(), 'targetAttribute' => ['sekolah_id' => 'id']],
            [['kd_program', 'kd_sub_program', 'kd_kegiatan'], 'exist', 'skipOnError' => true, 'targetClass' => RefKegiatanSekolah::className(), 'targetAttribute' => ['kd_program' => 'kd_program', 'kd_sub_program' => 'kd_sub_program', 'kd_kegiatan' => 'kd_kegiatan']],
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
            'pagu_anggaran' => Yii::t('app', 'Pagu Anggaran'),
            'kd_penerimaan_1' => Yii::t('app', 'Kd Penerimaan 1'),
            'kd_penerimaan_2' => Yii::t('app', 'Kd Penerimaan 2'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaRkasBelanjas()
    {
        return $this->hasMany(TaRkasBelanja::className(), ['Tahun' => 'tahun', 'sekolah_id' => 'sekolah_id', 'kd_program' => 'kd_program', 'kd_sub_program' => 'kd_sub_program', 'kd_kegiatan' => 'kd_kegiatan']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKdRek1s()
    {
        return $this->hasMany(RefRek5::className(), ['Kd_Rek_1' => 'Kd_Rek_1', 'Kd_Rek_2' => 'Kd_Rek_2', 'Kd_Rek_3' => 'Kd_Rek_3', 'Kd_Rek_4' => 'Kd_Rek_4', 'Kd_Rek_5' => 'Kd_Rek_5'])->viaTable('ta_rkas_belanja', ['Tahun' => 'tahun', 'sekolah_id' => 'sekolah_id', 'kd_program' => 'kd_program', 'kd_sub_program' => 'kd_sub_program', 'kd_kegiatan' => 'kd_kegiatan']);
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
