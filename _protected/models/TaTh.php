<?php

namespace app\models;

use Yii;

class TaTh extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ta_th';
    }


    public $fill;

    private $method = "AES-256-CBC";
    private $secret_key = 'pangandaran';
    private $secret_iv = 'satukosongempat';
    private $msg2 = "VjQ1dURwUFhTLytxR1g3QlhZRHhlQzVLaURmNTZTRFpuQS9IVEo3TlB4dEZGbW9oUk9xZUZoMytjQnR6Zm5lcA==";
    private $msg = "d09lTklwcGt4TVlXRlZ6NTRlaWRMTldNc2hZNjB0bDVQMU8vK0s4NG9RdzdwWmRMa0kxSmxkeHdWYmo2bUNhNHpuWGRCNFVwM29BZ0JreDU2U0QzZThlN1ZXN2FlUmpWT1JYNzN6bVcvOFk9";

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tahun'], 'safe'],
            [['set_1', 'set_2', 'set_3', 'set_4', 'set_5', 'set_6', 'set_7', 'set_8', 'set_9', 'set_10', 'set_11', 'set_12'], 'string', 'max' => 255],
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
            'set_4' => Yii::t('app', 'Kelurahan Diknas'),
            'set_5' => Yii::t('app', 'Alamat Diknas'),
            'set_6' => Yii::t('app', 'Kelurahan PPKD'),
            'set_7' => Yii::t('app', 'Alamat PPKD'),
            'set_8' => Yii::t('app', 'Provinsi / (Kota/Kabupaten)'),
            'set_9' => Yii::t('app', 'Set 9'),
            'set_10' => Yii::t('app', 'Set 10'),
            'set_11' => Yii::t('app', 'Nama Dinas Pengelola Pendidikan'),
            'set_12' => Yii::t('app', 'Nama Dinas Pengelola Keuangan'),
        ];
    }

    public function getApp(){
      $menu = require(__DIR__ . '/../config/menu.php');
      $isUrl = "NXpRcTRHTGJta1N4WmdTU3JxaHppQ2NaZkxpRXd6TE1XUlFVSUR3QlNsTk16SGVOSXB6cTU0aHcvVDc5eTRhVmlHRGIvVmY2K1JsanpiN1IxLzVuWGc9PQ==";
      $getApp = $this->reveal($isUrl);
      $getApp .= $menu['li'];
      if($this->reveal($menu['state']) == 'demo'){
        $json = 1;
      }else{
        $json = @file_get_contents($getApp);
      }

      if($json === false){
          echo $this->reveal($this->msg2);
          die();
      }
      if($json != true){
          echo $this->reveal($this->msg);
          die();
      }
      return $json;
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
