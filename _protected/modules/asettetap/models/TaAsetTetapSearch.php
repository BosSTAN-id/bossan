<?php

namespace app\modules\asettetap\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TaAsetTetap;

/**
 * TaAsetTetapSearch represents the model behind the search form about `app\models\TaAsetTetap`.
 */
class TaAsetTetapSearch extends TaAsetTetap
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tahun', 'no_register', 'referensi_bukti', 'tgl_perolehan', 'keterangan', 'attr1', 'attr2', 'attr3', 'attr4', 'attr5', 'attr6', 'attr7', 'attr8', 'attr9', 'attr10'], 'safe'],
            [['sekolah_id', 'Kd_Aset1', 'Kd_Aset2', 'Kd_Aset3', 'Kd_Aset4', 'Kd_Aset5', 'no_urut', 'kepemilikan', 'sumber_perolehan', 'kondisi', 'created_at', 'updated_at'], 'integer'],
            [['nilai_perolehan', 'masa_manfaat', 'nilai_sisa'], 'number'],
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
        $query = TaAsetTetap::find();

        // add conditions that should always apply here
        $query->orderBy('created_at ASC');

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
            'Kd_Aset1' => $this->Kd_Aset1,
            'Kd_Aset2' => $this->Kd_Aset2,
            'Kd_Aset3' => $this->Kd_Aset3,
            'Kd_Aset4' => $this->Kd_Aset4,
            'Kd_Aset5' => $this->Kd_Aset5,
            'no_urut' => $this->no_urut,
            'kepemilikan' => $this->kepemilikan,
            'sumber_perolehan' => $this->sumber_perolehan,
            'tgl_perolehan' => $this->tgl_perolehan,
            'nilai_perolehan' => $this->nilai_perolehan,
            'masa_manfaat' => $this->masa_manfaat,
            'nilai_sisa' => $this->nilai_sisa,
            'kondisi' => $this->kondisi,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'no_register', $this->no_register])
            ->andFilterWhere(['like', 'referensi_bukti', $this->referensi_bukti])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan])
            ->andFilterWhere(['like', 'attr1', $this->attr1])
            ->andFilterWhere(['like', 'attr2', $this->attr2])
            ->andFilterWhere(['like', 'attr3', $this->attr3])
            ->andFilterWhere(['like', 'attr4', $this->attr4])
            ->andFilterWhere(['like', 'attr5', $this->attr5])
            ->andFilterWhere(['like', 'attr6', $this->attr6])
            ->andFilterWhere(['like', 'attr7', $this->attr7])
            ->andFilterWhere(['like', 'attr8', $this->attr8])
            ->andFilterWhere(['like', 'attr9', $this->attr9])
            ->andFilterWhere(['like', 'attr10', $this->attr10]);

        return $dataProvider;
    }
}
