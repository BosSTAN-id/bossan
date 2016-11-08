<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_penerimaan_sekolah_2".
 *
 * @property integer $kd_penerimaan_1
 * @property integer $kd_penerimaan_2
 * @property string $uraian
 * @property string $abbr
 *
 * @property RefPenerimaanSekolah1 $kdPenerimaan1
 * @property RefRekPenerimaan[] $refRekPenerimaans
 * @property TaRkasBelanja[] $taRkasBelanjas
 * @property TaRkasPendapatan[] $taRkasPendapatans
 */
class RefPenerimaanSekolah2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_penerimaan_sekolah_2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kd_penerimaan_1', 'kd_penerimaan_2', 'uraian'], 'required'],
            [['kd_penerimaan_1', 'kd_penerimaan_2', 'sekolah'], 'integer'],
            [['uraian'], 'string', 'max' => 100],
            [['abbr'], 'string', 'max' => 10],
            [['kd_penerimaan_1'], 'exist', 'skipOnError' => true, 'targetClass' => RefPenerimaanSekolah1::className(), 'targetAttribute' => ['kd_penerimaan_1' => 'kd_penerimaan_1']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'kd_penerimaan_1' => Yii::t('app', 'Kd Penerimaan 1'),
            'kd_penerimaan_2' => Yii::t('app', 'Kd Penerimaan 2'),
            'uraian' => Yii::t('app', 'Uraian'),
            'abbr' => Yii::t('app', 'Abbr'),
            'sekolah' => 'Digunakan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKdPenerimaan1()
    {
        return $this->hasOne(RefPenerimaanSekolah1::className(), ['kd_penerimaan_1' => 'kd_penerimaan_1']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefRekPenerimaans()
    {
        return $this->hasMany(RefRekPenerimaan::className(), ['kd_penerimaan_1' => 'kd_penerimaan_1', 'kd_penerimaan_2' => 'kd_penerimaan_2']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaRkasBelanjas()
    {
        return $this->hasMany(TaRkasBelanja::className(), ['kd_penerimaan_1' => 'kd_penerimaan_1', 'kd_penerimaan_2' => 'kd_penerimaan_2']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaRkasPendapatans()
    {
        return $this->hasMany(TaRkasPendapatan::className(), ['kd_penerimaan_1' => 'kd_penerimaan_1', 'kd_penerimaan_2' => 'kd_penerimaan_2']);
    }
}
