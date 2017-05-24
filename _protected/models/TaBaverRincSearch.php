<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TaBaverRinc;

/**
 * TaBaverRincSearch represents the model behind the search form about `app\models\TaBaverRinc`.
 */
class TaBaverRincSearch extends TaBaverRinc
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tahun', 'no_ba', 'no_peraturan', 'keterangan'], 'safe'],
            [['sekolah_id'], 'integer'],
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
        $query = TaBaverRinc::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'tahun' => $this->tahun,
            'sekolah_id' => $this->sekolah_id,
        ]);

        $query->andFilterWhere(['like', 'no_ba', $this->no_ba])
            ->andFilterWhere(['like', 'no_peraturan', $this->no_peraturan])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
}
