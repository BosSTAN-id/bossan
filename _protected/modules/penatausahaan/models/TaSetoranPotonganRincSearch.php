<?php

namespace app\modules\penatausahaan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TaSetoranPotonganRinc;

/**
 * TaSetoranPotonganRincSearch represents the model behind the search form about `app\models\TaSetoranPotonganRinc`.
 */
class TaSetoranPotonganRincSearch extends TaSetoranPotonganRinc
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tahun', 'no_setoran', 'keterangan'], 'safe'],
            [['sekolah_id', 'kd_potongan', 'pembayaran'], 'integer'],
            [['nilai'], 'number'],
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
        $query = TaSetoranPotonganRinc::find();

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
            'kd_potongan' => $this->kd_potongan,
            'nilai' => $this->nilai,
            'pembayaran' => $this->pembayaran,
        ]);

        $query->andFilterWhere(['like', 'no_setoran', $this->no_setoran])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
}
