<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_jabatan".
 *
 * @property integer $Kd_Jab
 * @property string $Nm_Jab
 *
 * @property TaSubUnitJab[] $taSubUnitJabs
 */
class RefJabatan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_jabatan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Kd_Jab'], 'required'],
            [['Kd_Jab'], 'integer'],
            [['Nm_Jab'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Kd_Jab' => 'Kd  Jab',
            'Nm_Jab' => 'Nm  Jab',
        ];
    }

}
