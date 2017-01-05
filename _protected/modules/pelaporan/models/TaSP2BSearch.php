<?php

namespace app\modules\pelaporan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TaSP2B;

/**
 * TaSP2BSearch represents the model behind the search form about `app\models\TaSP2B`.
 */
class TaSP2BSearch extends TaSP2B
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tahun', 'no_sp2b', 'no_sp3b', 'tgl_sp2b', 'penandatangan', 'jbt_penandatangan', 'nip_penandatangan'], 'safe'],
            [['saldo_awal', 'pendapatan', 'belanja', 'saldo_akhir'], 'number'],
            [['jumlah_sekolah', 'status'], 'integer'],
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
        $query = TaSP2B::find();

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
            'tgl_sp2b' => $this->tgl_sp2b,
            'saldo_awal' => $this->saldo_awal,
            'pendapatan' => $this->pendapatan,
            'belanja' => $this->belanja,
            'saldo_akhir' => $this->saldo_akhir,
            'jumlah_sekolah' => $this->jumlah_sekolah,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'no_sp2b', $this->no_sp2b])
            ->andFilterWhere(['like', 'no_sp3b', $this->no_sp3b])
            ->andFilterWhere(['like', 'penandatangan', $this->penandatangan])
            ->andFilterWhere(['like', 'jbt_penandatangan', $this->jbt_penandatangan])
            ->andFilterWhere(['like', 'nip_penandatangan', $this->nip_penandatangan]);

        return $dataProvider;
    }
}
