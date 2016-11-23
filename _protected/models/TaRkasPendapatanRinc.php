<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ta_rkas_pendapatan_rinc".
 *
 * @property string $tahun
 * @property integer $sekolah_id
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
 * @property TaRkasPendapatan $tahun0
 */
class TaRkasPendapatanRinc extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ta_rkas_pendapatan_rinc';
    }

    public $penerimaan_2;    

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tahun', 'sekolah_id', 'Kd_Rek_1', 'Kd_Rek_2', 'Kd_Rek_3', 'Kd_Rek_4', 'Kd_Rek_5', 'kd_penerimaan_1', 'kd_penerimaan_2', 'no_rinc'], 'required'],
            [['tahun'], 'safe'],
            [['penerimaan_2'], 'string'],
            [['sekolah_id', 'Kd_Rek_1', 'Kd_Rek_2', 'Kd_Rek_3', 'Kd_Rek_4', 'Kd_Rek_5', 'no_rinc', 'kd_penerimaan_1', 'kd_penerimaan_2'], 'integer'],
            [['nilai_1', 'nilai_2', 'nilai_3', 'jml_satuan', 'nilai_rp', 'total'], 'number'],
            [['keterangan'], 'string', 'max' => 255],
            [['sat_1', 'sat_2', 'sat_3'], 'string', 'max' => 10],
            [['satuan123'], 'string', 'max' => 50],
            // [['tahun', 'sekolah_id', 'Kd_Rek_1', 'Kd_Rek_2', 'Kd_Rek_3', 'Kd_Rek_4', 'Kd_Rek_5'], 'exist', 'skipOnError' => true, 'targetClass' => TaRkasPendapatan::className(), 'targetAttribute' => ['tahun' => 'tahun', 'sekolah_id' => 'sekolah_id', 'Kd_Rek_1' => 'Kd_Rek_1', 'Kd_Rek_2' => 'Kd_Rek_2', 'Kd_Rek_3' => 'Kd_Rek_3', 'Kd_Rek_4' => 'Kd_Rek_4', 'Kd_Rek_5' => 'Kd_Rek_5']],
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
            'no_rinc' => Yii::t('app', 'No Rincian'),
            'keterangan' => Yii::t('app', 'Keterangan'),
            'sat_1' => Yii::t('app', 'Satuan 1'),
            'nilai_1' => Yii::t('app', 'Volume 1'),
            'sat_2' => Yii::t('app', 'Satuan 2'),
            'nilai_2' => Yii::t('app', 'Volume 2'),
            'sat_3' => Yii::t('app', 'Satuan 3'),
            'nilai_3' => Yii::t('app', 'Volume 3'),
            'satuan123' => Yii::t('app', 'Volume Total'),
            'jml_satuan' => Yii::t('app', 'Satuan Total'),
            'nilai_rp' => Yii::t('app', 'Nilai Satuan'),
            'total' => Yii::t('app', 'Total'),
            'kd_penerimaan_1' => Yii::t('app', 'Penerimaan 1'),
            'kd_penerimaan_2' => Yii::t('app', 'Penerimaan 2'),            
            'penerimaan_2' => 'Sumber Dana',
        ];
    }

    public function getSekolah()
    {
        return $this->hasOne(RefSekolah::className(), ['id' => 'sekolah_id']);
    }

    public function getPenerimaan2()
    {
        return $this->hasOne(\app\models\RefPenerimaanSekolah2::className(), ['kd_penerimaan_1' => 'kd_penerimaan_1', 'kd_penerimaan_2' => 'kd_penerimaan_2']);
    }

    public function getPendapatan()
    {
        return $this->hasOne(TaRkasPendapatan::className(), ['Tahun' => 'tahun', 'sekolah_id' => 'sekolah_id', 'Kd_Rek_1' => 'Kd_Rek_1', 'Kd_Rek_2' => 'Kd_Rek_2', 'Kd_Rek_3' => 'Kd_Rek_3', 'Kd_Rek_4' => 'Kd_Rek_4', 'Kd_Rek_5' => 'Kd_Rek_5']);
    }

    public function getRefRek5()
    {
        return $this->hasOne(RefRek5::className(), ['Kd_Rek_1' => 'Kd_Rek_1', 'Kd_Rek_2' => 'Kd_Rek_2', 'Kd_Rek_3' => 'Kd_Rek_3', 'Kd_Rek_4' => 'Kd_Rek_4', 'Kd_Rek_5' => 'Kd_Rek_5']);
    }      
}
