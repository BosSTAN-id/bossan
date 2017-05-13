<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ta_saldo_awal_potongan".
 *
 * @property string $tahun
 * @property integer $sekolah_id
 * @property integer $kd_potongan
 * @property string $nilai
 *
 * @property RefPotongan $kdPotongan
 */
class TaSaldoAwalPotongan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ta_saldo_awal_potongan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tahun', 'sekolah_id', 'kd_potongan'], 'required'],
            [['tahun'], 'safe'],
            [['sekolah_id', 'kd_potongan'], 'integer'],
            [['nilai'], 'number'],
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
            'sekolah_id' => 'Sekolah ID',
            'kd_potongan' => 'Kd Potongan',
            'nilai' => 'Nilai',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKdPotongan()
    {
        return $this->hasOne(RefPotongan::className(), ['kd_potongan' => 'kd_potongan']);
    }
}
