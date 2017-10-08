<?php

namespace app\modules\asettetap\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TaAsetTetapBa;

/**
 * TaAsetTetapBaSearch represents the model behind the search form about `app\models\TaAsetTetapBa`.
 */
class TaAsetTetapBaSearch extends TaAsetTetapBa
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tahun', 'no_ba', 'tgl_ba', 'nm_penandatangan', 'nip_penandatangan', 'jbt_penandatangan'], 'safe'],
            [['sekolah_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
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
        $query = TaAsetTetapBa::find();

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
            'tahun' => $this->tahun,
            'sekolah_id' => $this->sekolah_id,
            'tgl_ba' => $this->tgl_ba,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'no_ba', $this->no_ba])
            ->andFilterWhere(['like', 'nm_penandatangan', $this->nm_penandatangan])
            ->andFilterWhere(['like', 'nip_penandatangan', $this->nip_penandatangan])
            ->andFilterWhere(['like', 'jbt_penandatangan', $this->jbt_penandatangan]);

        return $dataProvider;
    }
}
