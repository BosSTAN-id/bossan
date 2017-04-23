<?php

namespace app\modules\parameter\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RefDesa;

/**
 * RefDesaSearch represents the model behind the search form about `app\models\RefDesa`.
 */
class RefDesaSearch extends RefDesa
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Kd_Prov', 'Kd_Kab_Kota', 'Kd_Kecamatan', 'Kd_Desa'], 'integer'],
            [['Nm_Desa'], 'safe'],
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
        $query = RefDesa::find();

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
            'Kd_Prov' => $this->Kd_Prov,
            'Kd_Kab_Kota' => $this->Kd_Kab_Kota,
            'Kd_Kecamatan' => $this->Kd_Kecamatan,
            'Kd_Desa' => $this->Kd_Desa,
        ]);

        $query->andFilterWhere(['like', 'Nm_Desa', $this->Nm_Desa]);

        return $dataProvider;
    }
}
