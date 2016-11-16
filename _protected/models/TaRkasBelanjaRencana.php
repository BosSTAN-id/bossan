<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ta_rkas_belanja_rencana".
 *
 * @property string $tahun
 * @property integer $sekolah_id
 * @property integer $kd_program
 * @property integer $kd_sub_program
 * @property integer $kd_kegiatan
 * @property integer $Kd_Rek_1
 * @property integer $Kd_Rek_2
 * @property integer $Kd_Rek_3
 * @property integer $Kd_Rek_4
 * @property integer $Kd_Rek_5
 * @property string $juli
 * @property string $agustus
 * @property string $september
 * @property string $oktober
 * @property string $november
 * @property string $desember
 * @property string $januari1
 * @property string $februari1
 * @property string $maret1
 * @property string $april1
 * @property string $mei1
 * @property string $juni1
 */
class TaRkasBelanjaRencana extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ta_rkas_belanja_rencana';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tahun', 'sekolah_id', 'kd_program', 'kd_sub_program', 'kd_kegiatan', 'Kd_Rek_1', 'Kd_Rek_2', 'Kd_Rek_3', 'Kd_Rek_4', 'Kd_Rek_5'], 'required'],
            [['tahun'], 'safe'],
            [['sekolah_id', 'kd_program', 'kd_sub_program', 'kd_kegiatan', 'Kd_Rek_1', 'Kd_Rek_2', 'Kd_Rek_3', 'Kd_Rek_4', 'Kd_Rek_5'], 'integer'],
            [['juli', 'agustus', 'september', 'oktober', 'november', 'desember', 'januari1', 'februari1', 'maret1', 'april1', 'mei1', 'juni1'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tahun' => 'Tahun',
            'sekolah_id' => 'Sekolah ID',
            'kd_program' => 'Kd Program',
            'kd_sub_program' => 'Kd Sub Program',
            'kd_kegiatan' => 'Kd Kegiatan',
            'Kd_Rek_1' => 'Kd  Rek 1',
            'Kd_Rek_2' => 'Kd  Rek 2',
            'Kd_Rek_3' => 'Kd  Rek 3',
            'Kd_Rek_4' => 'Kd  Rek 4',
            'Kd_Rek_5' => 'Kd  Rek 5',
            'juli' => 'Juli',
            'agustus' => 'Agustus',
            'september' => 'September',
            'oktober' => 'Oktober',
            'november' => 'November',
            'desember' => 'Desember',
            'januari1' => 'Januari1',
            'februari1' => 'Februari1',
            'maret1' => 'Maret1',
            'april1' => 'April1',
            'mei1' => 'Mei1',
            'juni1' => 'Juni1',
        ];
    }
}
