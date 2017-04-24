<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ta_spj_pot".
 *
 * @property string $tahun
 * @property string $no_bukti
 * @property integer $kd_potongan
 * @property string $nilai
 *
 * @property TaSpjRinc $tahun0
 * @property RefPotongan $kdPotongan
 */
class TaSPJPot extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ta_spj_pot';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tahun', 'no_bukti', 'kd_potongan', 'nilai'], 'required'],
            [['tahun'], 'safe'],
            [['kd_potongan', 'sekolah_id'], 'integer'],
            [['nilai'], 'number'],
            [['no_bukti'], 'string', 'max' => 50],
            [['tahun', 'no_bukti'], 'exist', 'skipOnError' => true, 'targetClass' => TaSpjRinc::className(), 'targetAttribute' => ['tahun' => 'tahun', 'no_bukti' => 'no_bukti']],
            [['kd_potongan'], 'exist', 'skipOnError' => true, 'targetClass' => RefPotongan::className(), 'targetAttribute' => ['kd_potongan' => 'kd_potongan']],
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
            'kd_potongan' => 'Kd Potongan',
            'nilai' => 'Nilai',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBukti()
    {
        return $this->hasOne(TaSpjRinc::className(), ['tahun' => 'tahun', 'no_bukti' => 'no_bukti']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKdPotongan()
    {
        return $this->hasOne(RefPotongan::className(), ['kd_potongan' => 'kd_potongan']);
    }
}
