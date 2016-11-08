<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_desa".
 *
 * @property integer $Kd_Prov
 * @property integer $Kd_Kab_Kota
 * @property integer $Kd_Kecamatan
 * @property integer $Kd_Desa
 * @property string $Nm_Desa
 */
class RefDesa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_desa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Kd_Prov', 'Kd_Kab_Kota', 'Kd_Kecamatan', 'Kd_Desa'], 'required'],
            [['Kd_Prov', 'Kd_Kab_Kota', 'Kd_Kecamatan', 'Kd_Desa'], 'integer'],
            [['Nm_Desa'], 'string', 'max' => 150],
            [['Kd_Prov', 'Kd_Kab_Kota', 'Kd_Kecamatan'], 'exist', 'skipOnError' => true, 'targetClass' => RefKecamatan::className(), 'targetAttribute' => ['Kd_Prov' => 'Kd_Prov', 'Kd_Kab_Kota' => 'Kd_Kab_Kota', 'Kd_Kecamatan' => 'Kd_Kecamatan']],
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
            'Kd_Desa' => Yii::t('app', 'Kd  Desa'),
            'Nm_Desa' => Yii::t('app', 'Nm  Desa'),
        ];
    }
}
