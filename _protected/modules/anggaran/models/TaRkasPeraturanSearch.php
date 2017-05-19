<?php

namespace app\modules\anggaran\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TaRkasPeraturan;

/**
 * TaRkasPeraturanSearch represents the model behind the search form about `app\models\TaRkasPeraturan`.
 */
class TaRkasPeraturanSearch extends TaRkasPeraturan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tahun', 'no_peraturan', 'tgl_peraturan', 'penandatangan', 'nip', 'jabatan', 'komite_sekolah', 'jabatan_komite'], 'safe'],
            [['sekolah_id', 'perubahan_id', 'verifikasi'], 'integer'],
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
        $query = TaRkasPeraturan::find();

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
            'perubahan_id' => $this->perubahan_id,
            'tgl_peraturan' => $this->tgl_peraturan,
            'verifikasi' => $this->verifikasi,
        ]);

        $query->andFilterWhere(['like', 'no_peraturan', $this->no_peraturan])
            ->andFilterWhere(['like', 'penandatangan', $this->penandatangan])
            ->andFilterWhere(['like', 'nip', $this->nip])
            ->andFilterWhere(['like', 'jabatan', $this->jabatan])
            ->andFilterWhere(['like', 'komite_sekolah', $this->komite_sekolah])
            ->andFilterWhere(['like', 'jabatan_komite', $this->jabatan_komite]);

        return $dataProvider;
    }
}
