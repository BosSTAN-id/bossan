<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_rek_4".
 *
 * @property integer $Kd_Rek_1
 * @property integer $Kd_Rek_2
 * @property integer $Kd_Rek_3
 * @property integer $Kd_Rek_4
 * @property string $Nm_Rek_4
 *
 * @property RefRek3 $kdRek1
 * @property RefRek5[] $refRek5s
 */
class RefRek4 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_rek_4';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Kd_Rek_1', 'Kd_Rek_2', 'Kd_Rek_3', 'Kd_Rek_4', 'Nm_Rek_4'], 'required'],
            [['Kd_Rek_1', 'Kd_Rek_2', 'Kd_Rek_3', 'Kd_Rek_4'], 'integer'],
            [['Nm_Rek_4'], 'string', 'max' => 100],
            [['Kd_Rek_1', 'Kd_Rek_2', 'Kd_Rek_3'], 'exist', 'skipOnError' => true, 'targetClass' => RefRek3::className(), 'targetAttribute' => ['Kd_Rek_1' => 'Kd_Rek_1', 'Kd_Rek_2' => 'Kd_Rek_2', 'Kd_Rek_3' => 'Kd_Rek_3']],
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
            'Nm_Rek_4' => Yii::t('app', 'Nm  Rek 4'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKdRek1()
    {
        return $this->hasOne(RefRek3::className(), ['Kd_Rek_1' => 'Kd_Rek_1', 'Kd_Rek_2' => 'Kd_Rek_2', 'Kd_Rek_3' => 'Kd_Rek_3']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefRek5s()
    {
        return $this->hasMany(RefRek5::className(), ['Kd_Rek_1' => 'Kd_Rek_1', 'Kd_Rek_2' => 'Kd_Rek_2', 'Kd_Rek_3' => 'Kd_Rek_3', 'Kd_Rek_4' => 'Kd_Rek_4']);
    }
}
