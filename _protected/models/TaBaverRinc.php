<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ta_baver_rinc".
 *
 * @property string $tahun
 * @property string $no_ba
 * @property integer $sekolah_id
 * @property string $no_peraturan
 * @property string $keterangan
 *
 * @property TaBaver $tahun0
 */
class TaBaverRinc extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ta_baver_rinc';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tahun', 'no_ba', 'sekolah_id', 'no_peraturan'], 'required'],
            [['tahun'], 'safe'],
            [['sekolah_id'], 'integer'],
            [['no_ba', 'no_peraturan'], 'string', 'max' => 100],
            [['keterangan'], 'string', 'max' => 255],
            [['tahun', 'no_ba'], 'exist', 'skipOnError' => true, 'targetClass' => TaBaver::className(), 'targetAttribute' => ['tahun' => 'tahun', 'no_ba' => 'no_ba']],
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
            'sekolah_id' => 'Sekolah ID',
            'no_peraturan' => 'No Peraturan',
            'keterangan' => 'Keterangan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTahun0()
    {
        return $this->hasOne(TaBaver::className(), ['tahun' => 'tahun', 'no_ba' => 'no_ba']);
    }
}
