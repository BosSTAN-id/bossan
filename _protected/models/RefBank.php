<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_bank".
 *
 * @property string $tahun
 * @property integer $sekolah_id
 * @property integer $id
 * @property string $no_rekening
 * @property string $bank
 * @property string $cabang
 * @property string $keterangan
 */
class RefBank extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_bank';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tahun', 'sekolah_id', 'id'], 'required'],
            [['tahun'], 'safe'],
            [['sekolah_id', 'id'], 'integer'],
            [['no_rekening', 'bank'], 'string', 'max' => 50],
            [['cabang'], 'string', 'max' => 100],
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
            'sekolah_id' => 'Sekolah ID',
            'id' => 'ID',
            'no_rekening' => 'No Rekening',
            'bank' => 'Bank',
            'cabang' => 'Cabang',
            'keterangan' => 'Keterangan',
        ];
    }
}
