<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_potongan".
 *
 * @property integer $kd_potongan
 * @property string $nm_potongan
 * @property string $kd_map
 *
 * @property TaSpjPot[] $taSpjPots
 * @property TaSpjRinc[] $tahuns
 */
class RefPotongan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_potongan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kd_potongan', 'nm_potongan'], 'required'],
            [['kd_potongan'], 'integer'],
            [['nm_potongan'], 'string', 'max' => 50],
            [['kd_map'], 'string', 'max' => 6],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'kd_potongan' => 'Kd Potongan',
            'nm_potongan' => 'Nm Potongan',
            'kd_map' => 'Kd Map',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaSpjPots()
    {
        return $this->hasMany(TaSpjPot::className(), ['kd_potongan' => 'kd_potongan']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTahuns()
    {
        return $this->hasMany(TaSpjRinc::className(), ['tahun' => 'tahun', 'no_bukti' => 'no_bukti'])->viaTable('ta_spj_pot', ['kd_potongan' => 'kd_potongan']);
    }
}
