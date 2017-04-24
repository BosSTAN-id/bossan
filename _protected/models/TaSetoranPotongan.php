<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ta_setoran_potongan".
 *
 * @property string $tahun
 * @property integer $sekolah_id
 * @property string $no_setoran
 * @property string $tgl_setoran
 * @property string $keterangan
 *
 * @property TaSetoranPotonganRinc[] $taSetoranPotonganRincs
 */
class TaSetoranPotongan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ta_setoran_potongan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tahun', 'sekolah_id', 'no_setoran', 'tgl_setoran'], 'required'],
            [['tahun', 'tgl_setoran'], 'safe'],
            [['sekolah_id'], 'integer'],
            [['no_setoran'], 'string', 'max' => 50],
            [['keterangan'], 'string', 'max' => 100],
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
            'no_setoran' => 'No Setoran',
            'tgl_setoran' => 'Tgl Setoran',
            'keterangan' => 'Keterangan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaSetoranPotonganRincs()
    {
        return $this->hasMany(TaSetoranPotonganRinc::className(), ['tahun' => 'tahun', 'sekolah_id' => 'sekolah_id', 'no_setoran' => 'no_setoran']);
    }
}
