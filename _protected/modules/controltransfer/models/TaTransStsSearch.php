<?php

namespace app\modules\controltransfer\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TaTransSts;

/**
 * TaTransStsSearch represents the model behind the search form about `app\models\TaTransSts`.
 */
class TaTransStsSearch extends TaTransSts
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Tahun', 'Kd_Trans_1', 'Kd_Trans_2', 'Kd_Trans_3', 'D_K'], 'integer'],
            [['No_STS', 'Tgl_STS', 'Rek_Penerima', 'Bank_Penerima'], 'safe'],
            [['Nilai'], 'number'],
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
        $query = TaTransSts::find();

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
            'Tahun' => $this->Tahun,
            'Kd_Trans_1' => $this->Kd_Trans_1,
            'Kd_Trans_2' => $this->Kd_Trans_2,
            'Kd_Trans_3' => $this->Kd_Trans_3,
            'Tgl_STS' => $this->Tgl_STS,
            'Nilai' => $this->Nilai,
            'D_K' => $this->D_K,
        ]);

        $query->andFilterWhere(['like', 'No_STS', $this->No_STS])
            ->andFilterWhere(['like', 'Rek_Penerima', $this->Rek_Penerima])
            ->andFilterWhere(['like', 'Bank_Penerima', $this->Bank_Penerima]);

        return $dataProvider;
    }
}
