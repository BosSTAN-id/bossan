<?php

namespace app\modules\management\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TaPengumuman;

/**
 * TaPengumumanSearch represents the model behind the search form about `app\models\TaPengumuman`.
 */
class TaPengumumanSearch extends TaPengumuman
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'diumumkan_di', 'sticky', 'published', 'user_id', 'created_at', 'updated_at'], 'integer'],
            [['content'], 'safe'],
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
        $query = TaPengumuman::find();

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
            'diumumkan_di' => $this->diumumkan_di,
            'sticky' => $this->sticky,
            'published' => $this->published,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}
