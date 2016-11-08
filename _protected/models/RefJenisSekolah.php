<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_jenis_sekolah".
 *
 * @property integer $id
 * @property integer $pendidikan_id
 * @property string $jenis_sekolah
 */
class RefJenisSekolah extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_jenis_sekolah';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pendidikan_id'], 'required'],
            [['pendidikan_id'], 'integer'],
            [['jenis_sekolah'], 'string', 'max' => 100],
            [['pendidikan_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefPendidikan::className(), 'targetAttribute' => ['pendidikan_id' => 'id']],
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
            'jenis_sekolah' => Yii::t('app', 'Jenis Sekolah'),
        ];
    }
}
