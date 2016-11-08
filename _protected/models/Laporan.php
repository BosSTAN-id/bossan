<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TaValidasiPembayaranSearch represents the model behind the search form about `app\models\TaValidasiPembayaran`.
 */
class Laporan extends Model
{
    public $Kd_Laporan;
    public $Kd_Urusan;
    public $Kd_Bidang;
    public $Kd_Unit;
    public $Kd_Sub;

    public function rules()
    {
        return [
            [['Kd_Laporan', 'Kd_Urusan', 'Kd_Bidang', 'Kd_Unit', 'Kd_Sub', 'Kd_Trans_1', 'Kd_Trans_2', 'Kd_Trans_3'], 'integer'],
            [['Tgl_1', 'Tgl_2', 'Nm_Penandatangan', 'Jabatan_Penandatangan', 'NIP_Penandatangan'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
}
