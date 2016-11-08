<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_rek_1".
 *
 * @property integer $Kd_Rek_1
 * @property string $Nm_Rek_1
 *
 * @property RefRek2[] $refRek2s
 */
class RefRek1 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_rek_1';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Kd_Rek_1', 'Nm_Rek_1'], 'required'],
            [['Kd_Rek_1'], 'integer'],
            [['Nm_Rek_1'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Kd_Rek_1' => Yii::t('app', 'Kd  Rek 1'),
            'Nm_Rek_1' => Yii::t('app', 'Nm  Rek 1'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefRek2s()
    {
        return $this->hasMany(RefRek2::className(), ['Kd_Rek_1' => 'Kd_Rek_1']);
    }
}
