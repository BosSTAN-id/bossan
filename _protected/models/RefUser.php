<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_user".
 *
 * @property integer $id
 * @property string $name
 *
 * @property RefUserMenu[] $refUserMenus
 */
class RefUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefUserMenus()
    {
        return $this->hasMany(RefUserMenu::className(), ['kd_user' => 'id']);
    }
}
