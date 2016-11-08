<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_program_sekolah".
 *
 * @property integer $kd_program
 * @property string $uraian_program
 */
class RefProgramSekolah extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_program_sekolah';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uraian_program'], 'required'],
            [['uraian_program'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'kd_program' => Yii::t('app', 'Kd Program'),
            'uraian_program' => Yii::t('app', 'Uraian Program'),
        ];
    }
}
