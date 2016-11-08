<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_penerimaan_sekolah_1".
 *
 * @property integer $kd_penerimaan_1
 * @property string $uraian_penerimaan_1
 * @property string $abbr
 *
 * @property RefPenerimaanSekolah2[] $refPenerimaanSekolah2s
 */
class RefPenerimaanSekolah1 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_penerimaan_sekolah_1';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kd_penerimaan_1', 'uraian_penerimaan_1'], 'required'],
            [['kd_penerimaan_1'], 'integer'],
            [['uraian_penerimaan_1'], 'string', 'max' => 100],
            [['abbr'], 'string', 'max' => 5],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'kd_penerimaan_1' => Yii::t('app', 'Kd Penerimaan 1'),
            'uraian_penerimaan_1' => Yii::t('app', 'Uraian Penerimaan 1'),
            'abbr' => Yii::t('app', 'Abbr'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefPenerimaanSekolah2s()
    {
        return $this->hasMany(RefPenerimaanSekolah2::className(), ['kd_penerimaan_1' => 'kd_penerimaan_1']);
    }
}
