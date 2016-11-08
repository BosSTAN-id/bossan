<?php

namespace app\modules\globalsetting\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RefPenerimaanSekolah2;

/**
 * RefPenerimaanSekolah2Search represents the model behind the search form about `app\models\RefPenerimaanSekolah2`.
 */
class RefPenerimaanSekolah2Search extends RefPenerimaanSekolah2
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kd_penerimaan_1', 'kd_penerimaan_2'], 'integer'],
            [['uraian', 'abbr'], 'safe'],
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
        $query = RefPenerimaanSekolah2::find();

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
            'kd_penerimaan_1' => $this->kd_penerimaan_1,
            'kd_penerimaan_2' => $this->kd_penerimaan_2,
        ]);

        $query->andFilterWhere(['like', 'uraian', $this->uraian])
            ->andFilterWhere(['like', 'abbr', $this->abbr]);

        return $dataProvider;
    }
}
