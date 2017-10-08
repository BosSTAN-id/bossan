<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_rek_aset4".
 *
 * @property integer $Kd_Aset1
 * @property integer $Kd_Aset2
 * @property integer $Kd_Aset3
 * @property integer $Kd_Aset4
 * @property string $Nm_Aset4
 *
 * @property RefRekAset3 $kdAset1
 * @property RefRekAset5[] $refRekAset5s
 */
class RefRekAset4 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_rek_aset4';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Kd_Aset1', 'Kd_Aset2', 'Kd_Aset3', 'Kd_Aset4', 'Nm_Aset4'], 'required'],
            [['Kd_Aset1', 'Kd_Aset2', 'Kd_Aset3', 'Kd_Aset4'], 'integer'],
            [['Nm_Aset4'], 'string', 'max' => 255],
            [['Kd_Aset1', 'Kd_Aset2', 'Kd_Aset3'], 'exist', 'skipOnError' => true, 'targetClass' => RefRekAset3::className(), 'targetAttribute' => ['Kd_Aset1' => 'Kd_Aset1', 'Kd_Aset2' => 'Kd_Aset2', 'Kd_Aset3' => 'Kd_Aset3']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Kd_Aset1' => 'Kd  Aset1',
            'Kd_Aset2' => 'Kd  Aset2',
            'Kd_Aset3' => 'Kd  Aset3',
            'Kd_Aset4' => 'Kd  Aset4',
            'Nm_Aset4' => 'Nm  Aset4',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKdAset1()
    {
        return $this->hasOne(RefRekAset3::className(), ['Kd_Aset1' => 'Kd_Aset1', 'Kd_Aset2' => 'Kd_Aset2', 'Kd_Aset3' => 'Kd_Aset3']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefRekAset5s()
    {
        return $this->hasMany(RefRekAset5::className(), ['Kd_Aset1' => 'Kd_Aset1', 'Kd_Aset2' => 'Kd_Aset2', 'Kd_Aset3' => 'Kd_Aset3', 'Kd_Aset4' => 'Kd_Aset4']);
    }
}
