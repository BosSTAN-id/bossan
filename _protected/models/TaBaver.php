<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ta_baver".
 *
 * @property string $tahun
 * @property string $no_ba
 * @property string $tgl_ba
 * @property string $verifikatur
 * @property string $nip_verifikatur
 * @property string $penandatangan
 * @property string $jabatan_penandatangan
 * @property string $nip_penandatangan
 * @property integer $status
 *
 * @property TaBaverRinc[] $taBaverRincs
 */
class TaBaver extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ta_baver';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tahun', 'no_ba'], 'required'],
            [['tahun', 'tgl_ba'], 'safe'],
            [['status'], 'integer'],
            [['no_ba', 'verifikatur', 'penandatangan'], 'string', 'max' => 100],
            [['nip_verifikatur', 'nip_penandatangan'], 'string', 'max' => 18],
            [['jabatan_penandatangan'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tahun' => 'Tahun',
            'no_ba' => 'No Ba',
            'tgl_ba' => 'Tgl Ba',
            'verifikatur' => 'Verifikatur',
            'nip_verifikatur' => 'Nip Verifikatur',
            'penandatangan' => 'Penandatangan',
            'jabatan_penandatangan' => 'Jabatan Penandatangan',
            'nip_penandatangan' => 'Nip Penandatangan',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaBaverRincs()
    {
        return $this->hasMany(TaBaverRinc::className(), ['tahun' => 'tahun', 'no_ba' => 'no_ba']);
    }
}
