<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_sub_program_sekolah".
 *
 * @property integer $id
 * @property integer $kd_program
 * @property integer $kd_sub_program
 * @property string $uraian_sub_program
 */
class RefSubProgramSekolah extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_sub_program_sekolah';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kd_program', 'kd_sub_program', 'uraian_sub_program'], 'required'],
            [['kd_program', 'kd_sub_program'], 'integer'],
            [['uraian_sub_program'], 'string', 'max' => 255],
            [['kd_program', 'kd_sub_program'], 'unique', 'targetAttribute' => ['kd_program', 'kd_sub_program'], 'message' => 'The combination of Kd Program and Kd Sub Program has already been taken.'],
            [['kd_program'], 'exist', 'skipOnError' => true, 'targetClass' => RefProgramSekolah::className(), 'targetAttribute' => ['kd_program' => 'kd_program']],
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
            'kd_sub_program' => Yii::t('app', 'Kd Sub Program'),
            'uraian_sub_program' => Yii::t('app', 'Uraian Sub Program'),
        ];
    }

    public function getRefProgram()
    {
        return $this->hasOne(RefProgramSekolah::className(), ['kd_program' => 'kd_program']);
    }  
}
