<?php

namespace app\modules\globalsetting\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RefSubProgramSekolah;

/**
 * RefSubProgramSekolahSearch represents the model behind the search form about `app\models\RefSubProgramSekolah`.
 */
class RefSubProgramSekolahSearch extends RefSubProgramSekolah
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'kd_program', 'kd_sub_program'], 'integer'],
            [['uraian_sub_program'], 'safe'],
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
        $query = RefSubProgramSekolah::find();

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
            'kd_sub_program' => $this->kd_sub_program,
        ]);

        $query->andFilterWhere(['like', 'uraian_sub_program', $this->uraian_sub_program]);

        return $dataProvider;
    }
}
