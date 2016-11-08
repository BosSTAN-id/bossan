<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_kegiatan_sekolah".
 *
 * @property integer $id
 * @property integer $kd_program
 * @property integer $subprogram_id
 * @property integer $kd_sub_program
 * @property integer $kd_kegiatan
 * @property string $uraian_kegiatan
 */
class RefKegiatanSekolah extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_kegiatan_sekolah';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kd_program', 'subprogram_id', 'kd_sub_program', 'kd_kegiatan', 'uraian_kegiatan'], 'required'],
            [['kd_program', 'subprogram_id', 'kd_sub_program', 'kd_kegiatan'], 'integer'],
            [['uraian_kegiatan'], 'string', 'max' => 255],
            [['kd_program', 'kd_sub_program', 'kd_kegiatan'], 'unique', 'targetAttribute' => ['kd_program', 'kd_sub_program', 'kd_kegiatan'], 'message' => 'The combination of Kd Program, Kd Sub Program and Kd Kegiatan has already been taken.'],
            [['kd_program', 'kd_sub_program'], 'exist', 'skipOnError' => true, 'targetClass' => RefSubProgramSekolah::className(), 'targetAttribute' => ['kd_program' => 'kd_program', 'kd_sub_program' => 'kd_sub_program']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'kd_program' => Yii::t('app', 'Kd Program'),
            'subprogram_id' => Yii::t('app', 'Subprogram ID'),
            'kd_sub_program' => Yii::t('app', 'Kd Sub Program'),
            'kd_kegiatan' => Yii::t('app', 'Kd Kegiatan'),
            'uraian_kegiatan' => Yii::t('app', 'Uraian Kegiatan'),
        ];
    }
}
