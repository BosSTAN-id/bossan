<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ta_sekolah_jab".
 *
 * @property string $tahun
 * @property integer $sekolah_id
 * @property integer $kd_jabatan
 * @property integer $no_jabatan
 * @property string $nama
 * @property string $nip
 * @property string $jabatan
 */
class TaSekolahJab extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ta_sekolah_jab';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tahun', 'sekolah_id', 'kd_jabatan', 'no_jabatan'], 'required'],
            [['tahun'], 'safe'],
            [['sekolah_id', 'kd_jabatan', 'no_jabatan'], 'integer'],
            [['nama'], 'string', 'max' => 50],
            [['nip'], 'string', 'max' => 21],
            [['jabatan'], 'string', 'max' => 75],
            [['sekolah_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefSekolah::className(), 'targetAttribute' => ['sekolah_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tahun' => Yii::t('app', 'Tahun'),
            'sekolah_id' => Yii::t('app', 'Sekolah ID'),
            'kd_jabatan' => Yii::t('app', 'Kd Jabatan'),
            'no_jabatan' => Yii::t('app', 'No Jabatan'),
            'nama' => Yii::t('app', 'Nama'),
            'nip' => Yii::t('app', 'Nip'),
            'jabatan' => Yii::t('app', 'Jabatan'),
        ];
    }

    public function getKdJabatan()
    {
        return $this->hasOne(RefJabatan::className(), ['Kd_Jab' => 'kd_jabatan']);
    }

}
