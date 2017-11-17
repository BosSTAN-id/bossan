<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ta_rkas_pendapatan".
 *
 * @property string $tahun
 * @property integer $sekolah_id
 * @property integer $Kd_Rek_1
 * @property integer $Kd_Rek_2
 * @property integer $Kd_Rek_3
 * @property integer $Kd_Rek_4
 * @property integer $Kd_Rek_5
 * @property integer $kd_penerimaan_1
 * @property integer $kd_penerimaan_2
 *
 * @property RefRek5 $kdRek1
 * @property RefPenerimaanSekolah2 $kdPenerimaan1
 * @property TaRkasPendapatanRinc[] $taRkasPendapatanRincs
 */
class TaRkasPendapatan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ta_rkas_pendapatan';
    }
    
    public $penerimaan_2;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tahun', 'sekolah_id', 'Kd_Rek_1', 'Kd_Rek_2', 'Kd_Rek_3', 'Kd_Rek_4', 'Kd_Rek_5', 'kd_penerimaan_1', 'kd_penerimaan_2'], 'required'],
            [['tahun'], 'safe'],
            [['penerimaan_2'], 'string'],
            [['sekolah_id', 'Kd_Rek_1', 'Kd_Rek_2', 'Kd_Rek_3', 'Kd_Rek_4', 'Kd_Rek_5', 'kd_penerimaan_1', 'kd_penerimaan_2'], 'integer'],
            [['Kd_Rek_1', 'Kd_Rek_2', 'Kd_Rek_3', 'Kd_Rek_4', 'Kd_Rek_5'], 'exist', 'skipOnError' => true, 'targetClass' => RefRek5::className(), 'targetAttribute' => ['Kd_Rek_1' => 'Kd_Rek_1', 'Kd_Rek_2' => 'Kd_Rek_2', 'Kd_Rek_3' => 'Kd_Rek_3', 'Kd_Rek_4' => 'Kd_Rek_4', 'Kd_Rek_5' => 'Kd_Rek_5']],
            [['kd_penerimaan_1', 'kd_penerimaan_2'], 'exist', 'skipOnError' => true, 'targetClass' => RefPenerimaanSekolah2::className(), 'targetAttribute' => ['kd_penerimaan_1' => 'kd_penerimaan_1', 'kd_penerimaan_2' => 'kd_penerimaan_2']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tahun' => Yii::t('app', 'Tahun'),
            'sekolah_id' => Yii::t('app', 'Sekolah'),
            'Kd_Rek_1' => Yii::t('app', 'Rek 1'),
            'Kd_Rek_2' => Yii::t('app', 'Rek 2'),
            'Kd_Rek_3' => Yii::t('app', 'Rek 3'),
            'Kd_Rek_4' => Yii::t('app', 'Rek 4'),
            'Kd_Rek_5' => Yii::t('app', 'Rek 5'),
            'kd_penerimaan_1' => Yii::t('app', 'Penerimaan 1'),
            'kd_penerimaan_2' => Yii::t('app', 'Penerimaan 2'),
            'penerimaan_2' => 'Sumber Dana',            
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefRek5()
    {
        return $this->hasOne(RefRek5::className(), ['Kd_Rek_1' => 'Kd_Rek_1', 'Kd_Rek_2' => 'Kd_Rek_2', 'Kd_Rek_3' => 'Kd_Rek_3', 'Kd_Rek_4' => 'Kd_Rek_4', 'Kd_Rek_5' => 'Kd_Rek_5']);
    }


    public function getRefRek3()
    {
        return $this->hasOne(RefRek3::className(), ['Kd_Rek_1' => 'Kd_Rek_1', 'Kd_Rek_2' => 'Kd_Rek_2', 'Kd_Rek_3' => 'Kd_Rek_3']);
    }

    public function getSekolah()
    {
        return $this->hasOne(RefSekolah::className(), ['id' => 'sekolah_id']);
    }

    public function getPenerimaan1()
    {
        return $this->hasOne(\app\models\RefPenerimaanSekolah1::className(), ['kd_penerimaan_1' => 'kd_penerimaan_1']);
    }

    public function getPenerimaan2()
    {
        return $this->hasOne(\app\models\RefPenerimaanSekolah2::className(), ['kd_penerimaan_1' => 'kd_penerimaan_1', 'kd_penerimaan_2' => 'kd_penerimaan_2']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaRkasPendapatanRincs()
    {
        return $this->hasMany(TaRkasPendapatanRinc::className(), ['tahun' => 'tahun', 'sekolah_id' => 'sekolah_id', 'Kd_Rek_1' => 'Kd_Rek_1', 'Kd_Rek_2' => 'Kd_Rek_2', 'Kd_Rek_3' => 'Kd_Rek_3', 'Kd_Rek_4' => 'Kd_Rek_4', 'Kd_Rek_5' => 'Kd_Rek_5']);
    }
}
