<?php

namespace app\modules\parameter\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RefPotongan;

/**
 * RefPotonganSearch represents the model behind the search form about `app\models\RefPotongan`.
 */
class RefPotonganSearch extends RefPotongan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kd_potongan'], 'integer'],
            [['nm_potongan', 'kd_map'], 'safe'],
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
        $query = RefPotongan::find();

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
            'kd_potongan' => $this->kd_potongan,
        ]);

        $query->andFilterWhere(['like', 'nm_potongan', $this->nm_potongan])
            ->andFilterWhere(['like', 'kd_map', $this->kd_map]);

        return $dataProvider;
    }
}
