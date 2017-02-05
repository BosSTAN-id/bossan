<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "ta_pengumuman".
 *
 * @property integer $id
 * @property integer $diumumkan_di
 * @property integer $sticky
 * @property string $title
 * @property string $content
 * @property integer $published
 * @property integer $user_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class TaPengumuman extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ta_pengumuman';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['diumumkan_di', 'sticky', 'title', 'published', 'user_id'], 'required'],
            [['diumumkan_di', 'sticky', 'published', 'user_id', 'created_at', 'updated_at'], 'integer'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'diumumkan_di' => 'Diumumkan pada',
            'sticky' => 'Sticky',
            'title' => 'Judul',
            'content' => 'Content',
            'published' => 'Di Publikasikan',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }    
    
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

}
