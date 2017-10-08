<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_rek_aset1".
 *
 * @property integer $Kd_Aset1
 * @property string $Nm_Aset1
 *
 * @property RefRekAset2[] $refRekAset2s
 */
class RefRekAset1 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_rek_aset1';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Kd_Aset1', 'Nm_Aset1'], 'required'],
            [['Kd_Aset1'], 'integer'],
            [['Nm_Aset1'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Kd_Aset1' => 'Kd  Aset1',
            'Nm_Aset1' => 'Nm  Aset1',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefRekAset2s()
    {
        return $this->hasMany(RefRekAset2::className(), ['Kd_Aset1' => 'Kd_Aset1']);
    }
}
