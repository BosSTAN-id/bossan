<?php

namespace app\modules\controltransfer\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TaTrans3;

/**
 * TaTrans3Search represents the model behind the search form about `app\models\TaTrans3`.
 */
class TaTrans3Search extends TaTrans3
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Tahun', 'Kd_Trans_1', 'Kd_Trans_2', 'Kd_Trans_3'], 'integer'],
            [['Nm_Sub_Bidang', 'Kd_sub_DAK'], 'safe'],
            [['Pagu'], 'number'],
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
        $query = TaTrans3::find();

        // add conditions that should always apply here
        IF(Yii::$app->session->get('tahun'))
        {
            $Tahun = Yii::$app->session->get('tahun');
        }ELSE{
            $Tahun = DATE('Y');
        }         
        $query->andWhere(['Tahun' => $Tahun]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate() || !$this->Kd_Trans_1) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'Tahun' => $this->Tahun,
            'Kd_Trans_1' => $this->Kd_Trans_1,
            'Kd_Trans_2' => $this->Kd_Trans_2,
            'Kd_Trans_3' => $this->Kd_Trans_3,
            'Pagu' => $this->Pagu,
        ]);

        $query->andFilterWhere(['like', 'Nm_Sub_Bidang', $this->Nm_Sub_Bidang])
            ->andFilterWhere(['like', 'Kd_sub_DAK', $this->Kd_sub_DAK]);

        return $dataProvider;
    }
}
