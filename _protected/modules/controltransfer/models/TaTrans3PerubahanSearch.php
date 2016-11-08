<?php

namespace app\modules\controltransfer\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TaTrans3Perubahan;

/**
 * TaTrans3PerubahanSearch represents the model behind the search form about `app\models\TaTrans3Perubahan`.
 */
class TaTrans3PerubahanSearch extends TaTrans3Perubahan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Tahun', 'Kd_Trans_1', 'Kd_Trans_2', 'Kd_Trans_3', 'No_Perubahan'], 'integer'],
            [['Pagu'], 'number'],
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
        $query = TaTrans3Perubahan::find();

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
            'No_Perubahan' => $this->No_Perubahan,
            'Pagu' => $this->Pagu,
        ]);

        return $dataProvider;
    }
}
