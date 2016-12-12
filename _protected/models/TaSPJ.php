<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ta_spj".
 *
 * @property string $tahun
 * @property string $no_spj
 * @property integer $sekolah_id
 * @property string $tgl_spj
 * @property integer $no_bku
 * @property string $keterangan
 * @property integer $kd_sah
 * @property string $no_pengesahan
 * @property string $disahkan_oleh
 * @property string $nip_pengesahan
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $user_id
 * @property string $nm_bendahara
 * @property string $nip_bendahara
 * @property string $jbt_bendahara
 * @property string $jbt_pengesahan
 * @property string $tgl_pengesahan
 *
 * @property TaSpjRinc[] $taSpjRincs
 */
class TaSPJ extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ta_spj';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tahun', 'no_spj', 'sekolah_id', 'tgl_spj', 'no_bku'], 'required'],
            [['tahun', 'tgl_spj', 'tgl_pengesahan'], 'safe'],
            [['sekolah_id', 'no_bku', 'kd_sah', 'created_at', 'updated_at', 'user_id'], 'integer'],
            [['no_spj', 'no_pengesahan', 'nip_pengesahan', 'nm_bendahara'], 'string', 'max' => 50],
            [['keterangan', 'jbt_bendahara', 'jbt_pengesahan'], 'string', 'max' => 255],
            [['disahkan_oleh'], 'string', 'max' => 100],
            [['nip_bendahara'], 'string', 'max' => 18],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tahun' => 'Tahun',
            'no_spj' => 'No Spj',
            'sekolah_id' => 'Sekolah ID',
            'tgl_spj' => 'Tgl Spj',
            'no_bku' => 'No Bku',
            'keterangan' => 'Keterangan',
            'kd_sah' => 'Kd Sah',
            'no_pengesahan' => 'No Pengesahan',
            'disahkan_oleh' => 'Disahkan Oleh',
            'nip_pengesahan' => 'Nip Pengesahan',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'user_id' => 'User ID',
            'nm_bendahara' => 'Nm Bendahara',
            'nip_bendahara' => 'Nip Bendahara',
            'jbt_bendahara' => 'Jbt Bendahara',
            'jbt_pengesahan' => 'Jbt Pengesahan',
            'tgl_pengesahan' => 'Tgl Pengesahan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaSpjRincs()
    {
        return $this->hasMany(TaSpjRinc::className(), ['tahun' => 'tahun', 'no_spj' => 'no_spj']);
    }
}
