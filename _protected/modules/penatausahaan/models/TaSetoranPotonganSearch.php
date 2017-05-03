<?php

namespace app\modules\penatausahaan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TaSetoranPotongan;

/**
 * TaSetoranPotonganSearch represents the model behind the search form about `app\models\TaSetoranPotongan`.
 */
class TaSetoranPotonganSearch extends TaSetoranPotongan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tahun', 'no_setoran', 'tgl_setoran', 'keterangan'], 'safe'],
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
        $query = TaSetoranPotongan::find();

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
            'tgl_setoran' => $this->tgl_setoran,
        ]);

        $query->andFilterWhere(['like', 'no_setoran', $this->no_setoran])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
}
