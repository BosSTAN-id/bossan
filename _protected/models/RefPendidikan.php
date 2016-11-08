<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_pendidikan".
 *
 * @property integer $id
 * @property string $jenis
 */
class RefPendidikan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_pendidikan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['jenis'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'jenis' => Yii::t('app', 'Jenis'),
        ];
    }
}
