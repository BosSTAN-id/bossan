<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_komponen_bos".
 *
 * @property integer $id
 * @property string $komponen
 * @property integer $bos_id
 *
 * @property RefRekKomponen[] $refRekKomponens
 * @property RefRek5[] $kdRek1s
 */
class RefKomponenBos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_komponen_bos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bos_id'], 'integer'],
            [['komponen'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'komponen' => Yii::t('app', 'Komponen'),
            'bos_id' => Yii::t('app', 'Bos ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefRekKomponens()
    {
        return $this->hasMany(RefRekKomponen::className(), ['komponen_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKdRek1s()
    {
        return $this->hasMany(RefRek5::className(), ['Kd_Rek_1' => 'Kd_Rek_1', 'Kd_Rek_2' => 'Kd_Rek_2', 'Kd_Rek_3' => 'Kd_Rek_3', 'Kd_Rek_4' => 'Kd_Rek_4', 'Kd_Rek_5' => 'Kd_Rek_5'])->viaTable('ref_rek_komponen', ['komponen_id' => 'id']);
    }
}
