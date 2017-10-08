<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "ta_aset_tetap_ba".
 *
 * @property string $tahun
 * @property integer $sekolah_id
 * @property string $no_ba
 * @property string $tgl_ba
 * @property string $nm_penandatangan
 * @property string $nip_penandatangan
 * @property string $jbt_penandatangan
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property TaAsetTetapBaRinci[] $taAsetTetapBaRincis
 * @property TaAsetTetapBaSaldo[] $taAsetTetapBaSaldos
 */
class TaAsetTetapBa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ta_aset_tetap_ba';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tahun', 'sekolah_id', 'no_ba'], 'required'],
            [['tahun', 'tgl_ba'], 'safe'],
            [['sekolah_id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'snapshot_status', 'balance_status'], 'integer'],
            [['no_ba'], 'string', 'max' => 50],
            [['nm_penandatangan', 'nip_penandatangan', 'jbt_penandatangan'], 'string', 'max' => 100],
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
            'no_ba' => 'No Ba',
            'tgl_ba' => 'Tgl Ba',
            'nm_penandatangan' => 'Nm Penandatangan',
            'nip_penandatangan' => 'Nip Penandatangan',
            'jbt_penandatangan' => 'Jbt Penandatangan',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'snapshot_status' => 'Status Snapshot',
            'balance_status' => 'Status Saldo',
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            BlameableBehavior::className(),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaAsetTetapBaRincis()
    {
        return $this->hasMany(TaAsetTetapBaRinci::className(), ['tahun' => 'tahun', 'sekolah_id' => 'sekolah_id', 'no_ba' => 'no_ba']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaAsetTetapBaSaldos()
    {
        return $this->hasMany(TaAsetTetapBaSaldo::className(), ['tahun' => 'tahun', 'sekolah_id' => 'sekolah_id', 'no_ba' => 'no_ba']);
    }

    public function getSekolah()
    {
        return $this->hasOne(RefSekolah::className(), ['id' => 'sekolah_id']);
    }
}
