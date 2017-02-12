<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "ta_mutasi_kas".
 *
 * @property string $tahun
 * @property string $no_bukti
 * @property integer $sekolah_id
 * @property string $tgl_bukti
 * @property integer $no_bku
 * @property integer $kd_mutasi
 * @property string $nilai
 * @property string $uraian
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $user_id
 */
class TaMutasiKas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ta_mutasi_kas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tahun', 'no_bukti', 'sekolah_id', 'tgl_bukti', 'nilai'], 'required'],
            [['tahun', 'tgl_bukti'], 'safe'],
            [['sekolah_id', 'no_bku', 'kd_mutasi', 'created_at', 'updated_at', 'user_id'], 'integer'],
            [['nilai'], 'number'],
            [['no_bukti'], 'string', 'max' => 50],
            [['uraian'], 'string', 'max' => 255],
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
            'sekolah_id' => 'Sekolah ID',
            'tgl_bukti' => 'Tgl Bukti',
            'no_bku' => 'No Bku',
            'kd_mutasi' => 'Kd Mutasi',
            'nilai' => 'Nilai',
            'uraian' => 'Uraian',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'user_id' => 'User ID',
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }  
}
