<?php

namespace app\modules\parameter\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RefRekAset1;

/**
 * RefRekAset1Search represents the model behind the search form about `app\models\RefRekAset1`.
 */
class RefRekAset1Search extends RefRekAset1
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Kd_Aset1'], 'integer'],
            [['Nm_Aset1'], 'safe'],
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
        $query = RefRekAset1::find();

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
            'Kd_Aset1' => $this->Kd_Aset1,
        ]);

        $query->andFilterWhere(['like', 'Nm_Aset1', $this->Nm_Aset1]);

        return $dataProvider;
    }
}
