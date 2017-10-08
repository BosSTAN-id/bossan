<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ta_aset_tetap_ba_saldo".
 *
 * @property string $tahun
 * @property integer $sekolah_id
 * @property string $no_ba
 * @property integer $Kd_Aset1
 * @property integer $Kd_Aset2
 * @property integer $Kd_Aset3
 * @property integer $Kd_Aset4
 * @property integer $Kd_Aset5
 * @property string $nilai_perolehan
 *
 * @property TaAsetTetapBa $tahun0
 */
class TaAsetTetapBaSaldo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ta_aset_tetap_ba_saldo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tahun'], 'safe'],
            [['sekolah_id', 'Kd_Aset1', 'Kd_Aset2', 'Kd_Aset3', 'Kd_Aset4', 'Kd_Aset5'], 'integer'],
            [['nilai_perolehan'], 'number'],
            [['no_ba'], 'string', 'max' => 50],
            [['tahun', 'sekolah_id', 'Kd_Aset1', 'Kd_Aset2', 'Kd_Aset3', 'Kd_Aset4', 'Kd_Aset5'], 'unique', 'targetAttribute' => ['tahun', 'sekolah_id', 'Kd_Aset1', 'Kd_Aset2', 'Kd_Aset3', 'Kd_Aset4', 'Kd_Aset5'], 'message' => 'The combination of Tahun, Sekolah ID, Kd  Aset1, Kd  Aset2, Kd  Aset3, Kd  Aset4 and Kd  Aset5 has already been taken.'],
            [['tahun', 'sekolah_id', 'no_ba'], 'exist', 'skipOnError' => true, 'targetClass' => TaAsetTetapBa::className(), 'targetAttribute' => ['tahun' => 'tahun', 'sekolah_id' => 'sekolah_id', 'no_ba' => 'no_ba']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tahun' => 'Tahun',
            'sekolah_id' => 'Sekolah ID',
            'no_ba' => 'No Ba',
            'Kd_Aset1' => 'Kd  Aset1',
            'Kd_Aset2' => 'Kd  Aset2',
            'Kd_Aset3' => 'Kd  Aset3',
            'Kd_Aset4' => 'Kd  Aset4',
            'Kd_Aset5' => 'Kd  Aset5',
            'nilai_perolehan' => 'Nilai Perolehan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTahun0()
    {
        return $this->hasOne(TaAsetTetapBa::className(), ['tahun' => 'tahun', 'sekolah_id' => 'sekolah_id', 'no_ba' => 'no_ba']);
    }

    public function getKdAset5()
    {
        return $this->hasOne(RefRekAset5::className(), ['Kd_Aset1' => 'Kd_Aset1', 'Kd_Aset2' => 'Kd_Aset2', 'Kd_Aset3' => 'Kd_Aset3', 'Kd_Aset4' => 'Kd_Aset4', 'Kd_Aset5' => 'Kd_Aset5']);
    }
}
