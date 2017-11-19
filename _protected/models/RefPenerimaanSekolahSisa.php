<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_penerimaan_sekolah_sisa".
 *
 * @property integer $penerimaan_sisa_1
 * @property integer $penerimaan_sisa_2
 * @property integer $kd_penerimaan_1
 * @property integer $kd_penerimaan_2
 */
class RefPenerimaanSekolahSisa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_penerimaan_sekolah_sisa';
    }

    public $penerimaan2;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['penerimaan_sisa_1', 'penerimaan_sisa_2', 'kd_penerimaan_1', 'kd_penerimaan_2', 'penerimaan2'], 'required'],
            [['penerimaan_sisa_1', 'penerimaan_sisa_2', 'kd_penerimaan_1', 'kd_penerimaan_2'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'penerimaan_sisa_1' => 'Penerimaan Sisa 1',
            'penerimaan_sisa_2' => 'Penerimaan Sisa 2',
            'kd_penerimaan_1' => 'Kd Penerimaan 1',
            'kd_penerimaan_2' => 'Kd Penerimaan 2',
            'penerimaan2' => 'Akun Penerimaan',
        ];
    }

    public function getAkunSisa()
    {
        return $this->hasOne(RefPenerimaanSekolah2::className(), ['kd_penerimaan_1' => 'penerimaan_sisa_1', 'kd_penerimaan_2' => 'penerimaan_sisa_2']);
    }

    public function getKdPenerimaan2()
    {
        return $this->hasOne(RefPenerimaanSekolah2::className(), ['kd_penerimaan_1' => 'kd_penerimaan_1', 'kd_penerimaan_2' => 'kd_penerimaan_2']);
    }
}
