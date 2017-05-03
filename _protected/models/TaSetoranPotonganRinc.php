<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ta_setoran_potongan_rinc".
 *
 * @property string $tahun
 * @property integer $sekolah_id
 * @property string $no_setoran
 * @property integer $kd_potongan
 * @property string $nilai
 * @property integer $pembayaran
 * @property string $keterangan
 *
 * @property TaSetoranPotongan $tahun0
 */
class TaSetoranPotonganRinc extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ta_setoran_potongan_rinc';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tahun', 'sekolah_id', 'no_setoran', 'kd_potongan', 'nilai'], 'required'],
            [['tahun'], 'safe'],
            [['sekolah_id', 'kd_potongan', 'pembayaran'], 'integer'],
            [['nilai'], 'number'],
            [['no_setoran'], 'string', 'max' => 50],
            [['keterangan'], 'string', 'max' => 100],
            [['tahun', 'sekolah_id', 'no_setoran'], 'exist', 'skipOnError' => true, 'targetClass' => TaSetoranPotongan::className(), 'targetAttribute' => ['tahun' => 'tahun', 'sekolah_id' => 'sekolah_id', 'no_setoran' => 'no_setoran']],
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
            'no_setoran' => 'No Setoran',
            'kd_potongan' => 'Kd Potongan',
            'nilai' => 'Nilai',
            'pembayaran' => 'Pembayaran',
            'keterangan' => 'Keterangan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTahun0()
    {
        return $this->hasOne(TaSetoranPotongan::className(), ['tahun' => 'tahun', 'sekolah_id' => 'sekolah_id', 'no_setoran' => 'no_setoran']);
    }

    public function getKdPotongan()
    {
        return $this->hasOne(RefPotongan::className(), ['kd_potongan' => 'kd_potongan']);
    }    
}
