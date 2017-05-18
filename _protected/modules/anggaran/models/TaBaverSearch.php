<?php

namespace app\modules\anggaran\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TaBaver;

/**
 * TaBaverSearch represents the model behind the search form about `app\models\TaBaver`.
 */
class TaBaverSearch extends TaBaver
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tahun', 'no_ba', 'tgl_ba', 'verifikatur', 'nip_verifikatur', 'penandatangan', 'jabatan_penandatangan', 'nip_penandatangan'], 'safe'],
            [['status'], 'integer'],
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
        $query = TaBaver::find();

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
            'tgl_ba' => $this->tgl_ba,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'no_ba', $this->no_ba])
            ->andFilterWhere(['like', 'verifikatur', $this->verifikatur])
            ->andFilterWhere(['like', 'nip_verifikatur', $this->nip_verifikatur])
            ->andFilterWhere(['like', 'penandatangan', $this->penandatangan])
            ->andFilterWhere(['like', 'jabatan_penandatangan', $this->jabatan_penandatangan])
            ->andFilterWhere(['like', 'nip_penandatangan', $this->nip_penandatangan]);

        return $dataProvider;
    }
}
