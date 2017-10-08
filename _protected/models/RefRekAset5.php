<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_rek_aset5".
 *
 * @property integer $Kd_Aset1
 * @property integer $Kd_Aset2
 * @property integer $Kd_Aset3
 * @property integer $Kd_Aset4
 * @property integer $Kd_Aset5
 * @property string $Nm_Aset5
 *
 * @property RefRekAset4 $kdAset1
 */
class RefRekAset5 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_rek_aset5';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Kd_Aset1', 'Kd_Aset2', 'Kd_Aset3', 'Kd_Aset4', 'Kd_Aset5'], 'required'],
            [['Kd_Aset1', 'Kd_Aset2', 'Kd_Aset3', 'Kd_Aset4', 'Kd_Aset5'], 'integer'],
            [['Nm_Aset5'], 'string', 'max' => 255],
            [['Kd_Aset1', 'Kd_Aset2', 'Kd_Aset3', 'Kd_Aset4'], 'exist', 'skipOnError' => true, 'targetClass' => RefRekAset4::className(), 'targetAttribute' => ['Kd_Aset1' => 'Kd_Aset1', 'Kd_Aset2' => 'Kd_Aset2', 'Kd_Aset3' => 'Kd_Aset3', 'Kd_Aset4' => 'Kd_Aset4']],
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
            'Kd_Aset5' => 'Kd  Aset5',
            'Nm_Aset5' => 'Nm  Aset5',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKdAset1()
    {
        return $this->hasOne(RefRekAset4::className(), ['Kd_Aset1' => 'Kd_Aset1', 'Kd_Aset2' => 'Kd_Aset2', 'Kd_Aset3' => 'Kd_Aset3', 'Kd_Aset4' => 'Kd_Aset4']);
    }
}
