<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_perubahan".
 *
 * @property integer $id
 * @property string $riwayat
 */
class RefPerubahan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_perubahan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'riwayat'], 'required'],
            [['id'], 'integer'],
            [['riwayat'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'riwayat' => 'Riwayat',
        ];
    }
}
