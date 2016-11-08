<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ta_th".
 *
 * @property integer $id
 * @property string $tahun
 * @property string $set_1
 * @property string $set_2
 * @property string $set_3
 * @property string $set_4
 * @property string $set_5
 * @property string $set_6
 * @property string $set_7
 * @property string $set_8
 * @property string $set_9
 * @property string $set_10
 * @property string $set_11
 * @property string $set_12
 */
class TaTh extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ta_th';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tahun'], 'safe'],
            [['set_1', 'set_2', 'set_3', 'set_4', 'set_5', 'set_6', 'set_7', 'set_8', 'set_9', 'set_10', 'set_11', 'set_12'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'tahun' => Yii::t('app', 'Tahun'),
            'set_1' => Yii::t('app', 'Pwd Keu'),
            'set_2' => Yii::t('app', 'Server Keu'),
            'set_3' => Yii::t('app', 'Un Keu'),
            'set_4' => Yii::t('app', 'Server BMD'),
            'set_5' => Yii::t('app', 'Pwd BMD'),
            'set_6' => Yii::t('app', 'Un BMD'),
            'set_7' => Yii::t('app', 'Db Keu'),
            'set_8' => Yii::t('app', 'Db BMD'),
            'set_9' => Yii::t('app', 'Set 9'),
            'set_10' => Yii::t('app', 'Set 10'),
            'set_11' => Yii::t('app', 'Set 11'),
            'set_12' => Yii::t('app', 'Set 12'),
        ];
    }

    public static function dokudoku($action, $string) {
        $output = false;

        $encrypt_method = "AES-256-CBC";
        $secret_key = 'adierzo';
        $secret_iv = 'bramisbandi';

        // hash
        $key = hash('sha256', $secret_key);
        
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if( $action == 'donat' ) {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        }
        else if( $action == 'bulat' ){
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }     
}
