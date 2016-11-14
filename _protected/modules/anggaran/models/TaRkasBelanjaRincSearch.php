<?php

namespace app\modules\anggaran\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TaRkasBelanjaRinc;

/**
 * TaRkasBelanjaRincSearch represents the model behind the search form about `app\models\TaRkasBelanjaRinc`.
 */
class TaRkasBelanjaRincSearch extends TaRkasBelanjaRinc
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tahun', 'keterangan', 'sat_1', 'sat_2', 'sat_3', 'satuan123'], 'safe'],
            [['sekolah_id', 'kd_program', 'kd_sub_program', 'kd_kegiatan', 'Kd_Rek_1', 'Kd_Rek_2', 'Kd_Rek_3', 'Kd_Rek_4', 'Kd_Rek_5', 'no_rinc'], 'integer'],
            [['nilai_1', 'nilai_2', 'nilai_3', 'jml_satuan', 'nilai_rp', 'total'], 'number'],
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
        $query = TaRkasBelanjaRinc::find();

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
            'Kd_Rek_1' => $this->Kd_Rek_1,
            'Kd_Rek_2' => $this->Kd_Rek_2,
            'Kd_Rek_3' => $this->Kd_Rek_3,
            'Kd_Rek_4' => $this->Kd_Rek_4,
            'Kd_Rek_5' => $this->Kd_Rek_5,
            'no_rinc' => $this->no_rinc,
            'nilai_1' => $this->nilai_1,
            'nilai_2' => $this->nilai_2,
            'nilai_3' => $this->nilai_3,
            'jml_satuan' => $this->jml_satuan,
            'nilai_rp' => $this->nilai_rp,
            'total' => $this->total,
        ]);

        $query->andFilterWhere(['like', 'keterangan', $this->keterangan])
            ->andFilterWhere(['like', 'sat_1', $this->sat_1])
            ->andFilterWhere(['like', 'sat_2', $this->sat_2])
            ->andFilterWhere(['like', 'sat_3', $this->sat_3])
            ->andFilterWhere(['like', 'satuan123', $this->satuan123]);

        return $dataProvider;
    }
}
