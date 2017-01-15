<?php

namespace app\modules\penatausahaan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TaSPJ;

/**
 * TaSPJSearch represents the model behind the search form about `app\models\TaSPJ`.
 */
class TaSPJSearch extends TaSPJ
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tahun', 'no_spj', 'tgl_spj', 'keterangan', 'no_pengesahan', 'disahkan_oleh', 'nip_pengesahan', 'nm_bendahara', 'nip_bendahara', 'jbt_bendahara', 'jbt_pengesahan', 'tgl_pengesahan'], 'safe'],
            [['sekolah_id', 'no_bku', 'kd_sah', 'created_at', 'updated_at', 'user_id', 'kd_verifikasi'], 'integer'],
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
        $query = TaSPJ::find();

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
            'tgl_spj' => $this->tgl_spj,
            'no_bku' => $this->no_bku,
            'kd_sah' => $this->kd_sah,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user_id' => $this->user_id,
            'tgl_pengesahan' => $this->tgl_pengesahan,
            'kd_verifikasi' => $this->kd_verifikasi,
        ]);

        $query->andFilterWhere(['like', 'no_spj', $this->no_spj])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan])
            ->andFilterWhere(['like', 'no_pengesahan', $this->no_pengesahan])
            ->andFilterWhere(['like', 'disahkan_oleh', $this->disahkan_oleh])
            ->andFilterWhere(['like', 'nip_pengesahan', $this->nip_pengesahan])
            ->andFilterWhere(['like', 'nm_bendahara', $this->nm_bendahara])
            ->andFilterWhere(['like', 'nip_bendahara', $this->nip_bendahara])
            ->andFilterWhere(['like', 'jbt_bendahara', $this->jbt_bendahara])
            ->andFilterWhere(['like', 'jbt_pengesahan', $this->jbt_pengesahan]);

        return $dataProvider;
    }
}
