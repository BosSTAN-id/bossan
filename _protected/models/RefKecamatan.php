<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_kecamatan".
 *
 * @property integer $Kd_Prov
 * @property integer $Kd_Kab_Kota
 * @property integer $Kd_Kecamatan
 * @property string $Nm_Kecamatan
 */
class RefKecamatan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_kecamatan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Kd_Prov', 'Kd_Kab_Kota', 'Kd_Kecamatan'], 'required'],
            [['Kd_Prov', 'Kd_Kab_Kota', 'Kd_Kecamatan'], 'integer'],
            [['Nm_Kecamatan'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Kd_Prov' => Yii::t('app', 'Kd  Prov'),
            'Kd_Kab_Kota' => Yii::t('app', 'Kd  Kab  Kota'),
            'Kd_Kecamatan' => Yii::t('app', 'Kd  Kecamatan'),
            'Nm_Kecamatan' => Yii::t('app', 'Nm  Kecamatan'),
        ];
    }
}
