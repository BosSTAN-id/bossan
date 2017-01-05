<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ta_sp3b_rinc".
 *
 * @property string $tahun
 * @property string $no_sp3b
 * @property integer $sekolah_id
 * @property string $no_spj
 * @property string $saldo_awal
 * @property string $pendapatan
 * @property string $belanja
 * @property string $saldo_akhir
 *
 * @property TaSp3b $tahun0
 */
class TaSP3BRinc extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ta_sp3b_rinc';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tahun', 'no_sp3b', 'sekolah_id', 'no_spj'], 'required'],
            [['tahun'], 'safe'],
            [['sekolah_id'], 'integer'],
            [['saldo_awal', 'pendapatan', 'belanja', 'saldo_akhir'], 'number'],
            [['no_sp3b', 'no_spj'], 'string', 'max' => 50],
            [['tahun', 'no_sp3b'], 'exist', 'skipOnError' => true, 'targetClass' => TaSp3b::className(), 'targetAttribute' => ['tahun' => 'tahun', 'no_sp3b' => 'no_sp3b']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tahun' => 'Tahun',
            'no_sp3b' => 'No Sp3b',
            'sekolah_id' => 'Sekolah ID',
            'no_spj' => 'No Spj',
            'saldo_awal' => 'Saldo Awal',
            'pendapatan' => 'Pendapatan',
            'belanja' => 'Belanja',
            'saldo_akhir' => 'Saldo Akhir',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTahun0()
    {
        return $this->hasOne(TaSp3b::className(), ['tahun' => 'tahun', 'no_sp3b' => 'no_sp3b']);
    }
}
