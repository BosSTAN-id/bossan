<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ta_sp3b".
 *
 * @property string $tahun
 * @property string $no_sp3b
 * @property string $tgl_sp3b
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
 * @property TaSp2b[] $taSp2bs
 * @property TaSp3bRinc[] $taSp3bRincs
 */
class TaSP3B extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ta_sp3b';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tahun', 'no_sp3b'], 'required'],
            [['tahun', 'tgl_sp3b'], 'safe'],
            [['saldo_awal', 'pendapatan', 'belanja', 'saldo_akhir'], 'number'],
            [['jumlah_sekolah', 'status'], 'integer'],
            [['no_sp3b'], 'string', 'max' => 50],
            [['penandatangan', 'jbt_penandatangan', 'nip_penandatangan'], 'string', 'max' => 100],
            [['keterangan'], 'string', 'max' => 255],
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
            'tgl_sp3b' => 'Tgl Sp3b',
            'saldo_awal' => 'Saldo Awal',
            'pendapatan' => 'Pendapatan',
            'belanja' => 'Belanja',
            'saldo_akhir' => 'Saldo Akhir',
            'penandatangan' => 'Penandatangan',
            'jbt_penandatangan' => 'Jbt Penandatangan',
            'nip_penandatangan' => 'Nip Penandatangan',
            'jumlah_sekolah' => 'Jumlah Sekolah',
            'status' => 'Status',
            'keterangan' => 'Keterangan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSp2b()
    {
        return $this->hasOne(TaSP2B::className(), ['tahun' => 'tahun', 'no_sp3b' => 'no_sp3b']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaSp3bRincs()
    {
        return $this->hasMany(TaSP3BRinc::className(), ['tahun' => 'tahun', 'no_sp3b' => 'no_sp3b']);
    }
}
