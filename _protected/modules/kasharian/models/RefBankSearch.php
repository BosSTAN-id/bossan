<?php

namespace app\modules\kasharian\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RefBank;

/**
 * RefBankSearch represents the model behind the search form about `app\models\RefBank`.
 */
class RefBankSearch extends RefBank
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Kd_Bank'], 'integer'],
            [['Nm_Bank', 'No_Rekening'], 'safe'],
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
        $query = RefBank::find();

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
            'Kd_Bank' => $this->Kd_Bank,
        ]);

        $query->andFilterWhere(['like', 'Nm_Bank', $this->Nm_Bank])
            ->andFilterWhere(['like', 'No_Rekening', $this->No_Rekening]);

        return $dataProvider;
    }
}
