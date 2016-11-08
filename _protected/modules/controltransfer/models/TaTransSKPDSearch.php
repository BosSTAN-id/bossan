<?php

namespace app\modules\controltransfer\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TaTransSKPD;

/**
 * TaTransSKPDSearch represents the model behind the search form about `app\models\TaTransSKPD`.
 */
class TaTransSKPDSearch extends TaTransSKPD
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Tahun', 'Kd_Trans_1', 'Kd_Trans_2', 'Kd_Trans_3', 'Kd_Urusan', 'Kd_Bidang', 'Kd_Unit', 'Kd_Sub'], 'integer'],
            [['Pagu'], 'number'],
            [['Referensi_Dokumen'], 'safe'],
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
        $query = TaTransSKPD::find();

        // add conditions that should always apply here
        IF(isset(Yii::$app->user->identity->Kd_Urusan) && Yii::$app->user->identity->Kd_Urusan <> NULL) {
            $query->andWhere(['Kd_Urusan' => Yii::$app->user->identity->Kd_Urusan]);
            $query->andWhere(['Kd_Bidang' => Yii::$app->user->identity->Kd_Bidang]);
            $query->andWhere(['Kd_Unit' => Yii::$app->user->identity->Kd_Unit]);
            $query->andWhere(['Kd_Sub' => Yii::$app->user->identity->Kd_Sub]);
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
            'Kd_Trans_3' => $this->Kd_Trans_3,
            'Kd_Urusan' => $this->Kd_Urusan,
            'Kd_Bidang' => $this->Kd_Bidang,
            'Kd_Unit' => $this->Kd_Unit,
            'Kd_Sub' => $this->Kd_Sub,
            'Pagu' => $this->Pagu,
        ]);

        $query->andFilterWhere(['like', 'Referensi_Dokumen', $this->Referensi_Dokumen]);

        return $dataProvider;
    }
}
