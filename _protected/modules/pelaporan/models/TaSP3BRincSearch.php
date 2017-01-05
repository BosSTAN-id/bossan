<?php

namespace app\modules\pelaporan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TaSP3BRinc;

/**
 * TaSP3BRincSearch represents the model behind the search form about `app\models\TaSP3BRinc`.
 */
class TaSP3BRincSearch extends TaSP3BRinc
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tahun', 'no_sp3b', 'no_spj'], 'safe'],
            [['sekolah_id'], 'integer'],
            [['saldo_awal', 'pendapatan', 'belanja', 'saldo_akhir'], 'number'],
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
        $query = TaSP3BRinc::find();

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
            'saldo_awal' => $this->saldo_awal,
            'pendapatan' => $this->pendapatan,
            'belanja' => $this->belanja,
            'saldo_akhir' => $this->saldo_akhir,
        ]);

        $query->andFilterWhere(['like', 'no_sp3b', $this->no_sp3b])
            ->andFilterWhere(['like', 'no_spj', $this->no_spj]);

        return $dataProvider;
    }
}
