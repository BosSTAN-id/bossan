<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_rek_penerimaan".
 *
 * @property integer $Kd_Rek_1
 * @property integer $Kd_Rek_2
 * @property integer $Kd_Rek_3
 * @property integer $Kd_Rek_4
 * @property integer $Kd_Rek_5
 * @property integer $kd_penerimaan_1
 * @property integer $kd_penerimaan_2
 *
 * @property RefRek5 $kdRek1
 * @property RefPenerimaanSekolah2 $kdPenerimaan1
 */
class RefRekPenerimaan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_rek_penerimaan';
    }

    public $rekening5;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Kd_Rek_1', 'Kd_Rek_2', 'Kd_Rek_3', 'Kd_Rek_4', 'Kd_Rek_5', 'kd_penerimaan_1', 'kd_penerimaan_2'], 'required'],
            [['rekening5'], 'string'],
            [['Kd_Rek_1', 'Kd_Rek_2', 'Kd_Rek_3', 'Kd_Rek_4', 'Kd_Rek_5', 'kd_penerimaan_1', 'kd_penerimaan_2'], 'integer'],
            [['Kd_Rek_1', 'Kd_Rek_2', 'Kd_Rek_3', 'Kd_Rek_4', 'Kd_Rek_5', 'kd_penerimaan_1', 'kd_penerimaan_2'], 'unique', 'targetAttribute' => ['Kd_Rek_1', 'Kd_Rek_2', 'Kd_Rek_3', 'Kd_Rek_4', 'Kd_Rek_5', 'kd_penerimaan_1', 'kd_penerimaan_2'], 'message' => 'The combination of Kd  Rek 1, Kd  Rek 2, Kd  Rek 3, Kd  Rek 4, Kd  Rek 5, Kd Penerimaan 1 and Kd Penerimaan 2 has already been taken.'],
            [['Kd_Rek_1', 'Kd_Rek_2', 'Kd_Rek_3', 'Kd_Rek_4', 'Kd_Rek_5'], 'exist', 'skipOnError' => true, 'targetClass' => RefRek5::className(), 'targetAttribute' => ['Kd_Rek_1' => 'Kd_Rek_1', 'Kd_Rek_2' => 'Kd_Rek_2', 'Kd_Rek_3' => 'Kd_Rek_3', 'Kd_Rek_4' => 'Kd_Rek_4', 'Kd_Rek_5' => 'Kd_Rek_5']],
            [['kd_penerimaan_1', 'kd_penerimaan_2'], 'exist', 'skipOnError' => true, 'targetClass' => RefPenerimaanSekolah2::className(), 'targetAttribute' => ['kd_penerimaan_1' => 'kd_penerimaan_1', 'kd_penerimaan_2' => 'kd_penerimaan_2']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Kd_Rek_1' => Yii::t('app', 'Kd  Rek 1'),
            'Kd_Rek_2' => Yii::t('app', 'Kd  Rek 2'),
            'Kd_Rek_3' => Yii::t('app', 'Kd  Rek 3'),
            'Kd_Rek_4' => Yii::t('app', 'Kd  Rek 4'),
            'Kd_Rek_5' => Yii::t('app', 'Kd  Rek 5'),
            'kd_penerimaan_1' => Yii::t('app', 'Kd Penerimaan 1'),
            'kd_penerimaan_2' => Yii::t('app', 'Kd Penerimaan 2'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKdRek1()
    {
        return $this->hasOne(RefRek5::className(), ['Kd_Rek_1' => 'Kd_Rek_1', 'Kd_Rek_2' => 'Kd_Rek_2', 'Kd_Rek_3' => 'Kd_Rek_3', 'Kd_Rek_4' => 'Kd_Rek_4', 'Kd_Rek_5' => 'Kd_Rek_5']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKdPenerimaan1()
    {
        return $this->hasOne(RefPenerimaanSekolah2::className(), ['kd_penerimaan_1' => 'kd_penerimaan_1', 'kd_penerimaan_2' => 'kd_penerimaan_2']);
    }
}
