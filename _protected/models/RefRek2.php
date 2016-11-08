<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_rek_2".
 *
 * @property integer $Kd_Rek_1
 * @property integer $Kd_Rek_2
 * @property string $Nm_Rek_2
 *
 * @property RefRek1 $kdRek1
 * @property RefRek3[] $refRek3s
 */
class RefRek2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_rek_2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Kd_Rek_1', 'Kd_Rek_2', 'Nm_Rek_2'], 'required'],
            [['Kd_Rek_1', 'Kd_Rek_2'], 'integer'],
            [['Nm_Rek_2'], 'string', 'max' => 100],
            [['Kd_Rek_1'], 'exist', 'skipOnError' => true, 'targetClass' => RefRek1::className(), 'targetAttribute' => ['Kd_Rek_1' => 'Kd_Rek_1']],
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
            'Nm_Rek_2' => Yii::t('app', 'Nm  Rek 2'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKdRek1()
    {
        return $this->hasOne(RefRek1::className(), ['Kd_Rek_1' => 'Kd_Rek_1']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefRek3s()
    {
        return $this->hasMany(RefRek3::className(), ['Kd_Rek_1' => 'Kd_Rek_1', 'Kd_Rek_2' => 'Kd_Rek_2']);
    }
}
