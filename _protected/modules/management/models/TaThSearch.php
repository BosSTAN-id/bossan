<?php

namespace app\modules\management\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TaTh;

/**
 * TaThSearch represents the model behind the search form about `app\models\TaTh`.
 */
class TaThSearch extends TaTh
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['tahun', 'set_1', 'set_2', 'set_3', 'set_4', 'set_5', 'set_6', 'set_7', 'set_8', 'set_9', 'set_10', 'set_11', 'set_12'], 'safe'],
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
        $query = TaTh::find();

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
            'id' => $this->id,
            'tahun' => $this->tahun,
        ]);

        $query->andFilterWhere(['like', 'set_1', $this->set_1])
            ->andFilterWhere(['like', 'set_2', $this->set_2])
            ->andFilterWhere(['like', 'set_3', $this->set_3])
            ->andFilterWhere(['like', 'set_4', $this->set_4])
            ->andFilterWhere(['like', 'set_5', $this->set_5])
            ->andFilterWhere(['like', 'set_6', $this->set_6])
            ->andFilterWhere(['like', 'set_7', $this->set_7])
            ->andFilterWhere(['like', 'set_8', $this->set_8])
            ->andFilterWhere(['like', 'set_9', $this->set_9])
            ->andFilterWhere(['like', 'set_10', $this->set_10])
            ->andFilterWhere(['like', 'set_11', $this->set_11])
            ->andFilterWhere(['like', 'set_12', $this->set_12]);

        return $dataProvider;
    }
}
