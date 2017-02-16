<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ta_saldo_awal".
 *
 * @property string $tahun
 * @property integer $sekolah_id
 * @property string $keterangan
 * @property string $nilai
 * @property integer $Kd_Rek_1
 * @property integer $Kd_Rek_2
 * @property integer $Kd_Rek_3
 * @property integer $Kd_Rek_4
 * @property integer $Kd_Rek_5
 * @property integer $kd_penerimaan_1
 * @property integer $kd_penerimaan_2
 */
class TaSaldoAwal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ta_saldo_awal';
    }

    public $penerimaan_2;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tahun', 'sekolah_id'], 'required'],
            [['tahun'], 'safe'],
            [['sekolah_id', 'Kd_Rek_1', 'Kd_Rek_2', 'Kd_Rek_3', 'Kd_Rek_4', 'Kd_Rek_5', 'kd_penerimaan_1', 'kd_penerimaan_2', 'pembayaran'], 'integer'],
            [['nilai'], 'number'],
            [['keterangan'], 'string', 'max' => 255],
            [['penerimaan_2'], 'string'],
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
            'keterangan' => 'Keterangan',
            'nilai' => 'Nilai',
            'Kd_Rek_1' => 'Kd  Rek 1',
            'Kd_Rek_2' => 'Kd  Rek 2',
            'Kd_Rek_3' => 'Kd  Rek 3',
            'Kd_Rek_4' => 'Kd  Rek 4',
            'Kd_Rek_5' => 'Kd  Rek 5',
            'kd_penerimaan_1' => 'Kd Penerimaan 1',
            'kd_penerimaan_2' => 'Kd Penerimaan 2',
            'penerimaan_2' => 'Sumber Dana',
            'pembayaran' => 'Pembayaran',
        ];
    }

    public function getPenerimaan2()
    {
        return $this->hasOne(\app\models\RefPenerimaanSekolah2::className(), ['kd_penerimaan_1' => 'kd_penerimaan_1', 'kd_penerimaan_2' => 'kd_penerimaan_2']);
    }    
}
