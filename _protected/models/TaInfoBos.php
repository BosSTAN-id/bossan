<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ta_info_bos".
 *
 * @property integer $id
 * @property integer $sekolah_id
 * @property string $tahun_ajaran
 * @property string $satuan_bos
 * @property integer $jumlah_siswa
 * @property integer $jumlah_guru
 * @property string $jumlah_dana_bos
 *
 * @property RefSekolah $sekolah
 */
class TaInfoBos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ta_info_bos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sekolah_id', 'tahun_ajaran'], 'required'],
            [['sekolah_id', 'jumlah_siswa', 'jumlah_guru'], 'integer'],
            [['tahun_ajaran'], 'safe'],
            [['satuan_bos', 'jumlah_dana_bos'], 'number'],
            [['sekolah_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefSekolah::className(), 'targetAttribute' => ['sekolah_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sekolah_id' => 'Sekolah ID',
            'tahun_ajaran' => 'Tahun Ajaran',
            'satuan_bos' => 'Satuan Bos',
            'jumlah_siswa' => 'Jumlah Siswa',
            'jumlah_guru' => 'Jumlah Guru',
            'jumlah_dana_bos' => 'Jumlah Dana Bos',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSekolah()
    {
        return $this->hasOne(RefSekolah::className(), ['id' => 'sekolah_id']);
    }
}
