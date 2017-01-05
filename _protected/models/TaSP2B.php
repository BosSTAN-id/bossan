<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ta_sp2b".
 *
 * @property string $tahun
 * @property string $no_sp2b
 * @property string $no_sp3b
 * @property string $tgl_sp2b
 * @property string $saldo_awal
 * @property string $pendapatan
 * @property string $belanja
 * @property string $saldo_akhir
 * @property string $penandatangan
 * @property string $jbt_penandatangan
 * @property string $nip_penandatangan
 * @property integer $jumlah_sekolah
 * @property integer $status
 *
 * @property TaSp3b $tahun0
 */
class TaSP2B extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ta_sp2b';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tahun', 'no_sp2b', 'no_sp3b'], 'required'],
            [['tahun', 'tgl_sp2b'], 'safe'],
            [['saldo_awal', 'pendapatan', 'belanja', 'saldo_akhir'], 'number'],
            [['jumlah_sekolah', 'status'], 'integer'],
            [['no_sp2b', 'no_sp3b'], 'string', 'max' => 50],
            [['penandatangan', 'jbt_penandatangan', 'nip_penandatangan'], 'string', 'max' => 100],
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
            'no_sp2b' => 'No Sp2b',
            'no_sp3b' => 'No Sp3b',
            'tgl_sp2b' => 'Tgl Sp2b',
            'saldo_awal' => 'Saldo Awal',
            'pendapatan' => 'Pendapatan',
            'belanja' => 'Belanja',
            'saldo_akhir' => 'Saldo Akhir',
            'penandatangan' => 'Penandatangan',
            'jbt_penandatangan' => 'Jbt Penandatangan',
            'nip_penandatangan' => 'Nip Penandatangan',
            'jumlah_sekolah' => 'Jumlah Sekolah',
            'status' => 'Status',
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
