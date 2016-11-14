<?php

namespace app\modules\anggaran\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RefKegiatanSekolah;

/**
 * RefKegiatanSekolahSearch represents the model behind the search form about `app\models\RefKegiatanSekolah`.
 */
class RefKegiatanSekolahSearch extends RefKegiatanSekolah
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'kd_program', 'subprogram_id', 'kd_sub_program', 'kd_kegiatan'], 'integer'],
            [['uraian_kegiatan'], 'safe'],
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
        $query = RefKegiatanSekolah::find();

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
            'id' => $this->id,
            'kd_program' => $this->kd_program,
            'subprogram_id' => $this->subprogram_id,
            'kd_sub_program' => $this->kd_sub_program,
            'kd_kegiatan' => $this->kd_kegiatan,
        ]);

        $query->andFilterWhere(['like', 'uraian_kegiatan', $this->uraian_kegiatan]);

        return $dataProvider;
    }
}
