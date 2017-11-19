<?php

namespace app\modules\anggaran\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;


class PreviewRkas extends Model
{
    public $kd_laporan;
    public $penerimaan2;
    public $no_peraturan;

    public function rules()
    {
        return [
            // [['Kd_Laporan', 'Kd_Urusan', 'Kd_Bidang', 'Kd_Unit', 'Kd_Sub', 'Kd_Trans_1', 'Kd_Trans_2', 'Kd_Trans_3', 'jenis_sekolah_id', 'pendidikan_id'], 'integer'],
            [['kd_laporan', 'penerimaan2', 'no_peraturan'], 'safe'],
        ];
    }

}
