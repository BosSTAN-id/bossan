<?php

namespace app\modules\controlhutang\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TaSPM;

/**
 * TaSPMSearch represents the model behind the search form about `app\models\TaSPM`.
 */
class TaSPMSearch extends TaSPM
{
    /**
     * @inheritdoc
     */

    public $tahun_anggaran;
    public $program;
    public $kegiatan;
    public $kd_skpd;

    public function rules()
    {
        return [
            [['Tahun', 'Kd_Urusan', 'Kd_Bidang', 'Kd_Unit', 'Kd_Sub', 'Jn_SPM', 'Bank_Pembayar', 'Kd_Edit'], 'integer'],
            [['program', 'kegiatan', 'kd_skpd'], 'string'],
            [['No_SPM', 'No_SPP', 'Tgl_SPM', 'Uraian', 'Nm_Penerima', 'Bank_Penerima', 'Rek_Penerima', 'NPWP', 'Nm_Verifikator', 'Nm_Penandatangan', 'Nip_Penandatangan', 'Jbt_Penandatangan'], 'safe'],
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

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = TaSPM::find();

        // add conditions that should always apply here
        IF(Yii::$app->session->get('tahun')){
            $query->andWhere(['Tahun' => Yii::$app->session->get('tahun')]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'Tahun' => $this->Tahun,
            'Kd_Urusan' => $this->Kd_Urusan,
            'Kd_Bidang' => $this->Kd_Bidang,
            'Kd_Unit' => $this->Kd_Unit,
            'Kd_Sub' => $this->Kd_Sub,
            'Jn_SPM' => $this->Jn_SPM,
            'Tgl_SPM' => $this->Tgl_SPM,
            'Bank_Pembayar' => $this->Bank_Pembayar,
            'Kd_Edit' => $this->Kd_Edit,
        ]);

        $query->andFilterWhere(['like', 'No_SPM', $this->No_SPM])
            ->andFilterWhere(['like', 'No_SPP', $this->No_SPP])
            ->andFilterWhere(['like', 'Uraian', $this->Uraian])
            ->andFilterWhere(['like', 'Nm_Penerima', $this->Nm_Penerima])
            ->andFilterWhere(['like', 'Bank_Penerima', $this->Bank_Penerima])
            ->andFilterWhere(['like', 'Rek_Penerima', $this->Rek_Penerima])
            ->andFilterWhere(['like', 'NPWP', $this->NPWP])
            ->andFilterWhere(['like', 'Nm_Verifikator', $this->Nm_Verifikator])
            ->andFilterWhere(['like', 'Nm_Penandatangan', $this->Nm_Penandatangan])
            ->andFilterWhere(['like', 'Nip_Penandatangan', $this->Nip_Penandatangan])
            ->andFilterWhere(['like', 'Jbt_Penandatangan', $this->Jbt_Penandatangan]);

        return $dataProvider;
    }
}
