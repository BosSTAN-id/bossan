<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Ref_Rek_5".
 *
 * @property integer $Kd_Rek_1
 * @property integer $Kd_Rek_2
 * @property integer $Kd_Rek_3
 * @property integer $Kd_Rek_4
 * @property integer $Kd_Rek_5
 * @property string $Nm_Rek_5
 * @property string $Peraturan
 *
 * @property RefRek4 $kdRek1
 * @property RefRek4 $kdRek2
 * @property RefRek4 $kdRek3
 * @property RefRek4 $kdRek4
 */
class RefRek5 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Ref_Rek_5';
    }

    public static function primaryKey()
    {
        return ['Kd_Rek_1', 'Kd_Rek_2', 'Kd_Rek_3', 'Kd_Rek_4', 'Kd_Rek_5'];
    }  

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Kd_Rek_1', 'Kd_Rek_2', 'Kd_Rek_3', 'Kd_Rek_4', 'Kd_Rek_5', 'Nm_Rek_5'], 'required'],
            [['Kd_Rek_1', 'Kd_Rek_2', 'Kd_Rek_3', 'Kd_Rek_4', 'Kd_Rek_5', 'Sekolah'], 'integer'],
            [['Nm_Rek_5'], 'string'],
            [['Kd_Rek_1'], 'exist', 'skipOnError' => true, 'targetClass' => RefRek4::className(), 'targetAttribute' => ['Kd_Rek_1' => 'Kd_Rek_1']],
            [['Kd_Rek_2'], 'exist', 'skipOnError' => true, 'targetClass' => RefRek4::className(), 'targetAttribute' => ['Kd_Rek_2' => 'Kd_Rek_2']],
            [['Kd_Rek_3'], 'exist', 'skipOnError' => true, 'targetClass' => RefRek4::className(), 'targetAttribute' => ['Kd_Rek_3' => 'Kd_Rek_3']],
            [['Kd_Rek_4'], 'exist', 'skipOnError' => true, 'targetClass' => RefRek4::className(), 'targetAttribute' => ['Kd_Rek_4' => 'Kd_Rek_4']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Kd_Rek_1' => 'Kd  Rek 1',
            'Kd_Rek_2' => 'Kd  Rek 2',
            'Kd_Rek_3' => 'Kd  Rek 3',
            'Kd_Rek_4' => 'Kd  Rek 4',
            'Kd_Rek_5' => 'Kd  Rek 5',
            'Nm_Rek_5' => 'Nm  Rek 5',
            'Sekolah' => 'Dapat Digunakan Sekolah'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKdRek1()
    {
        return $this->hasOne(RefRek4::className(), ['Kd_Rek_1' => 'Kd_Rek_1']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKdRek2()
    {
        return $this->hasOne(RefRek4::className(), ['Kd_Rek_2' => 'Kd_Rek_2']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKdRek3()
    {
        return $this->hasOne(RefRek4::className(), ['Kd_Rek_3' => 'Kd_Rek_3']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKdRek4()
    {
        return $this->hasOne(RefRek4::className(), ['Kd_Rek_4' => 'Kd_Rek_4']);
    }

    public function getRefRek4()
    {
        return $this->hasOne(RefRek4::className(), ['Kd_Rek_1' => 'Kd_Rek_1', 'Kd_Rek_2' => 'Kd_Rek_2', 'Kd_Rek_3' => 'Kd_Rek_3', 'Kd_Rek_4' => 'Kd_Rek_4']);
    }

    public function getRefRek3()
    {
        return $this->hasOne(RefRek3::className(), ['Kd_Rek_1' => 'Kd_Rek_1', 'Kd_Rek_2' => 'Kd_Rek_2', 'Kd_Rek_3' => 'Kd_Rek_3']);
    }    
}
