<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "ref_sekolah_perubahan".
 *
 * @property integer $id
 * @property integer $sekolah_id
 * @property string $nama_sekolah
 * @property string $alamat
 * @property string $kepala_sekolah
 * @property string $nip
 * @property string $rekening_sekolah
 * @property string $nama_bank
 * @property string $alamat_cabang
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $user_id
 */
class RefSekolahPerubahan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_sekolah_perubahan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sekolah_id', 'created_at', 'updated_at', 'user_id'], 'integer'],
            [['nama_sekolah'], 'string', 'max' => 100],
            [['alamat', 'kepala_sekolah', 'rekening_sekolah', 'nama_bank', 'alamat_cabang'], 'string', 'max' => 255],
            [['nip'], 'string', 'max' => 18],
            [['sekolah_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefSekolah::className(), 'targetAttribute' => ['sekolah_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'sekolah_id' => Yii::t('app', 'Sekolah ID'),
            'nama_sekolah' => Yii::t('app', 'Nama Sekolah'),
            'alamat' => Yii::t('app', 'Alamat'),
            'kepala_sekolah' => Yii::t('app', 'Kepala Sekolah'),
            'nip' => Yii::t('app', 'Nip'),
            'rekening_sekolah' => Yii::t('app', 'Rekening Sekolah'),
            'nama_bank' => Yii::t('app', 'Nama Bank'),
            'alamat_cabang' => Yii::t('app', 'Alamat Cabang'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'user_id' => Yii::t('app', 'User ID'),
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'user_id',
                'updatedByAttribute' => 'user_id',
            ],            
        ];
    }     
}
