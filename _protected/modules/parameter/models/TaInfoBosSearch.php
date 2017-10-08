<?php

namespace app\modules\parameter\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TaInfoBos;

/**
 * TaInfoBosSearch represents the model behind the search form about `app\models\TaInfoBos`.
 */
class TaInfoBosSearch extends TaInfoBos
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sekolah_id', 'jumlah_siswa', 'jumlah_guru'], 'integer'],
            [['tahun_ajaran'], 'safe'],
            [['satuan_bos', 'jumlah_dana_bos'], 'number'],
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
        $query = TaInfoBos::find();

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
            'sekolah_id' => $this->sekolah_id,
            'tahun_ajaran' => $this->tahun_ajaran,
            'satuan_bos' => $this->satuan_bos,
            'jumlah_siswa' => $this->jumlah_siswa,
            'jumlah_guru' => $this->jumlah_guru,
            'jumlah_dana_bos' => $this->jumlah_dana_bos,
        ]);

        return $dataProvider;
    }
}
