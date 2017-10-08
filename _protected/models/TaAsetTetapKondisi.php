<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "ta_aset_tetap_kondisi".
 *
 * @property string $no_register
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $kondisi
 * @property string $tgl_pemutakhiran
 */
class TaAsetTetapKondisi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ta_aset_tetap_kondisi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register' /*, 'created_at' */], 'required'],
            [['created_at', 'updated_at', 'kondisi'], 'integer'],
            [['tgl_pemutakhiran'], 'safe'],
            [['no_register'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_register' => 'No Register',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'kondisi' => 'Kondisi',
            'tgl_pemutakhiran' => 'Tgl Pemutakhiran',
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    
}
