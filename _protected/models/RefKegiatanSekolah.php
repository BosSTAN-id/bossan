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
 *
 * @property RefSubProgramSekolah $kdProgram
 * @property TaRkasKegiatan[] $taRkasKegiatans
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
            'id' => 'ID',
            'kd_program' => 'Kd Program',
            'subprogram_id' => 'Subprogram ID',
            'kd_sub_program' => 'Kd Sub Program',
            'kd_kegiatan' => 'Kd Kegiatan',
            'uraian_kegiatan' => 'Uraian Kegiatan',
        ];
    }


    public function getRefProgram()
    {
        return $this->hasOne(RefProgramSekolah::className(), ['kd_program' => 'kd_program']);
    }  

    public function getRefSubProgram()
    {
        return $this->hasOne(RefSubProgramSekolah::className(), ['kd_program' => 'kd_program', 'kd_sub_program' => 'kd_sub_program']);
    } 

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaRkasKegiatans()
    {
        return $this->hasMany(TaRkasKegiatan::className(), ['kd_program' => 'kd_program', 'kd_sub_program' => 'kd_sub_program', 'kd_kegiatan' => 'kd_kegiatan']);
    }
}
