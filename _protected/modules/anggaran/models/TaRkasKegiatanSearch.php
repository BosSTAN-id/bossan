<?php

namespace app\modules\anggaran\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TaRkasKegiatan;

/**
 * TaRkasKegiatanSearch represents the model behind the search form about `app\models\TaRkasKegiatan`.
 */
class TaRkasKegiatanSearch extends TaRkasKegiatan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tahun'], 'safe'],
            [['sekolah_id', 'kd_program', 'kd_sub_program', 'kd_kegiatan', 'kd_penerimaan_1', 'kd_penerimaan_2'], 'integer'],
            [['pagu_anggaran'], 'number'],
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
        $query = TaRkasKegiatan::find();

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
            'kd_program' => $this->kd_program,
            'kd_sub_program' => $this->kd_sub_program,
            'kd_kegiatan' => $this->kd_kegiatan,
            'pagu_anggaran' => $this->pagu_anggaran,
            'kd_penerimaan_1' => $this->kd_penerimaan_1,
            'kd_penerimaan_2' => $this->kd_penerimaan_2,
        ]);

        return $dataProvider;
    }
}
