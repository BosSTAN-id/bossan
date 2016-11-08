<?php

namespace app\modules\controltransfer\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TaTrans2;

/**
 * TaTrans2Search represents the model behind the search form about `app\models\TaTrans2`.
 */
class TaTrans2Search extends TaTrans2
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Tahun', 'Kd_Trans_1', 'Kd_Trans_2'], 'integer'],
            [['Nm_Bidang', 'Kd_Bid_DAK'], 'safe'],
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
        $query = TaTrans2::find();

        // add conditions that should always apply here
        IF(Yii::$app->session->get('tahun')){
            $query->andWhere(['Tahun' => Yii::$app->session->get('tahun')]);
        }

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
            'Tahun' => $this->Tahun,
            'Kd_Trans_1' => $this->Kd_Trans_1,
            'Kd_Trans_2' => $this->Kd_Trans_2,
        ]);

        $query->andFilterWhere(['like', 'Nm_Bidang', $this->Nm_Bidang])
            ->andFilterWhere(['like', 'Kd_Bid_DAK', $this->Kd_Bid_DAK]);

        return $dataProvider;
    }
}
