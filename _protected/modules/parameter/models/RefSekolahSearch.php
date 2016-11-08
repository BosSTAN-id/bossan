<?php

namespace app\modules\parameter\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RefSekolah;

/**
 * RefSekolahSearch represents the model behind the search form about `app\models\RefSekolah`.
 */
class RefSekolahSearch extends RefSekolah
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'pendidikan_id', 'jenis_id', 'kecamatan_id', 'kelurahan_id'], 'integer'],
            [['nama_sekolah', 'alamat', 'kepala_sekolah', 'nip', 'rekening_sekolah', 'nama_bank', 'alamat_cabang'], 'safe'],
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
        $query = RefSekolah::find();

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
            'pendidikan_id' => $this->pendidikan_id,
            'jenis_id' => $this->jenis_id,
            'kecamatan_id' => $this->kecamatan_id,
            'kelurahan_id' => $this->kelurahan_id,
        ]);

        $query->andFilterWhere(['like', 'nama_sekolah', $this->nama_sekolah])
            ->andFilterWhere(['like', 'alamat', $this->alamat])
            ->andFilterWhere(['like', 'kepala_sekolah', $this->kepala_sekolah])
            ->andFilterWhere(['like', 'nip', $this->nip])
            ->andFilterWhere(['like', 'rekening_sekolah', $this->rekening_sekolah])
            ->andFilterWhere(['like', 'nama_bank', $this->nama_bank])
            ->andFilterWhere(['like', 'alamat_cabang', $this->alamat_cabang]);

        return $dataProvider;
    }
}
