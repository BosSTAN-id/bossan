<?php

namespace app\modules\kasharian\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TaDeposito;

/**
 * TaDepositoSearch represents the model behind the search form about `app\models\TaDeposito`.
 */
class TaDepositoSearch extends TaDeposito
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Kd_Deposito'], 'integer'],
            [['Nm_Bank', 'No_Dokumen', 'Tgl_Penempatan', 'Tgl_Jatuh_Tempo', 'Keterangan'], 'safe'],
            [['Suku_Bunga', 'Nilai'], 'number'],
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
        $query = TaDeposito::find();

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
            'Kd_Deposito' => $this->Kd_Deposito,
            'Tgl_Penempatan' => $this->Tgl_Penempatan,
            'Tgl_Jatuh_Tempo' => $this->Tgl_Jatuh_Tempo,
            'Suku_Bunga' => $this->Suku_Bunga,
            'Nilai' => $this->Nilai,
        ]);

        $query->andFilterWhere(['like', 'Nm_Bank', $this->Nm_Bank])
            ->andFilterWhere(['like', 'No_Dokumen', $this->No_Dokumen])
            ->andFilterWhere(['like', 'Keterangan', $this->Keterangan]);

        return $dataProvider;
    }
}
