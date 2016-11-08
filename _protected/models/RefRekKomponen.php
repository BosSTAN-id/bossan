<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_rek_komponen".
 *
 * @property integer $Kd_Rek_1
 * @property integer $Kd_Rek_2
 * @property integer $Kd_Rek_3
 * @property integer $Kd_Rek_4
 * @property integer $Kd_Rek_5
 * @property integer $komponen_id
 *
 * @property RefRek5 $kdRek1
 * @property RefKomponenBos $komponen
 */
class RefRekKomponen extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_rek_komponen';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Kd_Rek_1', 'Kd_Rek_2', 'Kd_Rek_3', 'Kd_Rek_4', 'Kd_Rek_5', 'komponen_id'], 'required'],
            [['Kd_Rek_1', 'Kd_Rek_2', 'Kd_Rek_3', 'Kd_Rek_4', 'Kd_Rek_5', 'komponen_id'], 'integer'],
            [['Kd_Rek_1', 'Kd_Rek_2', 'Kd_Rek_3', 'Kd_Rek_4', 'Kd_Rek_5', 'komponen_id'], 'unique', 'targetAttribute' => ['Kd_Rek_1', 'Kd_Rek_2', 'Kd_Rek_3', 'Kd_Rek_4', 'Kd_Rek_5', 'komponen_id'], 'message' => 'The combination of Kd  Rek 1, Kd  Rek 2, Kd  Rek 3, Kd  Rek 4, Kd  Rek 5 and Komponen ID has already been taken.'],
            [['Kd_Rek_1', 'Kd_Rek_2', 'Kd_Rek_3', 'Kd_Rek_4', 'Kd_Rek_5'], 'exist', 'skipOnError' => true, 'targetClass' => RefRek5::className(), 'targetAttribute' => ['Kd_Rek_1' => 'Kd_Rek_1', 'Kd_Rek_2' => 'Kd_Rek_2', 'Kd_Rek_3' => 'Kd_Rek_3', 'Kd_Rek_4' => 'Kd_Rek_4', 'Kd_Rek_5' => 'Kd_Rek_5']],
            [['komponen_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefKomponenBos::className(), 'targetAttribute' => ['komponen_id' => 'id']],
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
            'komponen_id' => Yii::t('app', 'Komponen ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefRek5()
    {
        return $this->hasOne(RefRek5::className(), ['Kd_Rek_1' => 'Kd_Rek_1', 'Kd_Rek_2' => 'Kd_Rek_2', 'Kd_Rek_3' => 'Kd_Rek_3', 'Kd_Rek_4' => 'Kd_Rek_4', 'Kd_Rek_5' => 'Kd_Rek_5']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKomponen()
    {
        return $this->hasOne(RefKomponenBos::className(), ['id' => 'komponen_id']);
    }
}
