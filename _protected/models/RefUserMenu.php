<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_user_menu".
 *
 * @property integer $menu
 * @property integer $kd_user
 *
 * @property RefUser $kdUser
 */
class RefUserMenu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_user_menu';
    }

    public static function primaryKey(){
       return array('kd_user', 'menu');
    }    

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menu', 'kd_user'], 'integer'],
            [['kd_user', 'menu'], 'unique', 'targetAttribute' => ['kd_user', 'menu'], 'message' => 'The combination of Menu and Kd User has already been taken.'],
            [['kd_user'], 'exist', 'skipOnError' => true, 'targetClass' => RefUser::className(), 'targetAttribute' => ['kd_user' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'menu' => 'Menu',
            'kd_user' => 'Kd User',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKdUser()
    {
        return $this->hasOne(RefUser::className(), ['id' => 'kd_user']);
    }
}
