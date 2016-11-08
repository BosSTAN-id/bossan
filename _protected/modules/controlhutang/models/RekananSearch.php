<?php

namespace app\modules\controlhutang\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Rekanan;

/**
 * RekananSearch represents the model behind the search form about `app\models\Rekanan`.
 */
class RekananSearch extends Rekanan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Kd_Rekanan'], 'integer'],
            [['Nm_Perusahaan', 'Alamat', 'Nm_Pemilik', 'NPWP'], 'safe'],
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
        $query = Rekanan::find();

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
            'Kd_Rekanan' => $this->Kd_Rekanan,
        ]);

        $query->andFilterWhere(['like', 'Nm_Perusahaan', $this->Nm_Perusahaan])
            ->andFilterWhere(['like', 'Alamat', $this->Alamat])
            ->andFilterWhere(['like', 'Nm_Pemilik', $this->Nm_Pemilik])
            ->andFilterWhere(['like', 'NPWP', $this->NPWP]);

        return $dataProvider;
    }
}
