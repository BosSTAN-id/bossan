<?php

namespace app\modules\penatausahaan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TaSPJRinc;

/**
 * TaSPJRincSearch represents the model behind the search form about `app\models\TaSPJRinc`.
 */
class TaSPJRincSearch extends TaSPJRinc
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tahun', 'no_bukti', 'tgl_bukti', 'no_spj', 'nm_penerima', 'alamat_penerima', 'uraian'], 'safe'],
            [['no_urut', 'sekolah_id', 'kd_program', 'kd_sub_program', 'kd_kegiatan', 'Kd_Rek_1', 'Kd_Rek_2', 'Kd_Rek_3', 'Kd_Rek_4', 'Kd_Rek_5', 'komponen_id', 'pembayaran'], 'integer'],
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
        $query = TaSPJRinc::find();

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
            'tgl_bukti' => $this->tgl_bukti,
            'no_urut' => $this->no_urut,
            'sekolah_id' => $this->sekolah_id,
            'kd_program' => $this->kd_program,
            'kd_sub_program' => $this->kd_sub_program,
            'kd_kegiatan' => $this->kd_kegiatan,
            'Kd_Rek_1' => $this->Kd_Rek_1,
            'Kd_Rek_2' => $this->Kd_Rek_2,
            'Kd_Rek_3' => $this->Kd_Rek_3,
            'Kd_Rek_4' => $this->Kd_Rek_4,
            'Kd_Rek_5' => $this->Kd_Rek_5,
            'komponen_id' => $this->komponen_id,
            'pembayaran' => $this->pembayaran,
            'nilai' => $this->nilai,
        ]);

        $query->andFilterWhere(['like', 'no_bukti', $this->no_bukti])
            ->andFilterWhere(['like', 'no_spj', $this->no_spj])
            ->andFilterWhere(['like', 'nm_penerima', $this->nm_penerima])
            ->andFilterWhere(['like', 'alamat_penerima', $this->alamat_penerima])
            ->andFilterWhere(['like', 'uraian', $this->uraian]);

        return $dataProvider;
    }
}
