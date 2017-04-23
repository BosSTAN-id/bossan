<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_sekolah".
 *
 * @property integer $id
 * @property integer $pendidikan_id
 * @property integer $jenis_id
 * @property string $nama_sekolah
 * @property string $alamat
 * @property string $kepala_sekolah
 * @property string $nip
 * @property string $rekening_sekolah
 * @property string $nama_bank
 * @property string $alamat_cabang
 * @property integer $kecamatan_id
 * @property integer $kelurahan_id
 * @property integer $negeri
 */
class RefSekolah extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_sekolah';
    }

    public $kecamatanKelurahan;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pendidikan_id', 'jenis_id'], 'required'],
            [['pendidikan_id', 'jenis_id', 'kecamatan_id', 'kelurahan_id', 'negeri'], 'integer'],
            [['nama_sekolah', 'kepala_sekolah', 'rekening_sekolah', 'nama_bank', 'alamat_cabang', 'kecamatanKelurahan'], 'string', 'max' => 100],
            [['alamat'], 'string', 'max' => 255],
            [['nip'], 'string', 'max' => 18],
            [['jenis_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefJenisSekolah::className(), 'targetAttribute' => ['jenis_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'pendidikan_id' => Yii::t('app', 'Pendidikan ID'),
            'jenis_id' => Yii::t('app', 'Jenis ID'),
            'nama_sekolah' => Yii::t('app', 'Nama Sekolah'),
            'alamat' => Yii::t('app', 'Alamat'),
            'kepala_sekolah' => Yii::t('app', 'Kepala Sekolah'),
            'nip' => Yii::t('app', 'Nip'),
            'rekening_sekolah' => Yii::t('app', 'Rekening Sekolah'),
            'nama_bank' => Yii::t('app', 'Nama Bank'),
            'alamat_cabang' => Yii::t('app', 'Alamat Cabang'),
            'kecamatan_id' => Yii::t('app', 'Kecamatan ID'),
            'kelurahan_id' => Yii::t('app', 'Kelurahan ID'),
            'negeri' => Yii::t('app', 'Negeri'),
            'kecamatanKelurahan' => 'Desa/Kelurahan',
        ];
    }

    public function getRefJenisSekolah()
    {
        return $this->hasOne(RefJenisSekolah::className(), ['id' => 'jenis_id']);
    } 

    public function getRefKecamatan()
    {
        return $this->hasOne(\app\models\RefKecamatan::className(), ['Kd_Kecamatan' => 'kecamatan_id']);
    }        

    public function getRefDesa()
    {
        return $this->hasOne(\app\models\RefDesa::className(), ['Kd_Kecamatan' => 'kecamatan_id', 'Kd_Desa' => 'kelurahan_id']);
    }     

    public function getLokasi()
    {
        return $this->refKecamatan['Nm_Kecamatan'].' / '. $this->refDesa['Nm_Desa'];
    }   
}
