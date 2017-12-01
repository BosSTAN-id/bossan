<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ta_rkas_peraturan".
 *
 * @property string $tahun
 * @property integer $sekolah_id
 * @property integer $perubahan_id
 * @property string $no_peraturan
 * @property string $tgl_peraturan
 * @property string $penandatangan
 * @property string $nip
 * @property string $jabatan
 * @property integer $verifikasi
 */
class TaRkasPeraturan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ta_rkas_peraturan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tahun', 'sekolah_id', 'perubahan_id'], 'required'],
            [['tahun', 'tgl_peraturan'], 'safe'],
            [['sekolah_id', 'perubahan_id', 'verifikasi'], 'integer'],
            [['no_peraturan', 'penandatangan', 'jabatan', 'komite_sekolah', 'jabatan_komite'], 'string', 'max' => 100],
            [['nip'], 'string', 'max' => 18],
            [['no_peraturan'], 'unique'],
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
            'perubahan_id' => Yii::t('app', 'Perubahan ID'),
            'no_peraturan' => Yii::t('app', 'No Peraturan'),
            'tgl_peraturan' => Yii::t('app', 'Tgl Peraturan'),
            'penandatangan' => Yii::t('app', 'Penandatangan'),
            'nip' => Yii::t('app', 'Nip'),
            'jabatan' => Yii::t('app', 'Jabatan'),
            'komite_sekolah' => Yii::t('app', 'Penandatangan Komite'),
            'jabatan_komite' => Yii::t('app', 'Jabatan Penandatangan Komite'),
            'verifikasi' => Yii::t('app', 'Verifikasi'),
        ];
    }

    public function getSekolah()
    {
        return $this->hasOne(RefSekolah::className(), ['id' => 'sekolah_id']);
    }

    public function getPerubahan()
    {
        return $this->hasOne(RefPerubahan::className(), ['id' => 'perubahan_id']);
    }

    public function getTerlampir()
    {
        return $this->hasOne(\app\models\TaBaverRinc::className(), ['tahun' => 'tahun', 'no_peraturan' => 'no_peraturan']);
    }
}
