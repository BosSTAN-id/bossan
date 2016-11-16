<?php

namespace app\modules\anggaran\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TaRkasPendapatan;

/**
 * TaRkasPendapatanSearch represents the model behind the search form about `app\models\TaRkasPendapatan`.
 */
class TaRkasPendapatanSearch extends TaRkasPendapatan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tahun'], 'safe'],
            [['sekolah_id', 'Kd_Rek_1', 'Kd_Rek_2', 'Kd_Rek_3', 'Kd_Rek_4', 'Kd_Rek_5', 'kd_penerimaan_1', 'kd_penerimaan_2'], 'integer'],
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
        $query = TaRkasPendapatan::find();

        // add conditions that should always apply here

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
            'tahun' => $this->tahun,
            'sekolah_id' => $this->sekolah_id,
            'Kd_Rek_1' => $this->Kd_Rek_1,
            'Kd_Rek_2' => $this->Kd_Rek_2,
            'Kd_Rek_3' => $this->Kd_Rek_3,
            'Kd_Rek_4' => $this->Kd_Rek_4,
            'Kd_Rek_5' => $this->Kd_Rek_5,
            'kd_penerimaan_1' => $this->kd_penerimaan_1,
            'kd_penerimaan_2' => $this->kd_penerimaan_2,
        ]);

        return $dataProvider;
    }
}
