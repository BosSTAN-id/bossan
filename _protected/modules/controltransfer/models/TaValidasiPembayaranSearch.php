<?php

namespace app\modules\controltransfer\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TaValidasiPembayaran;

/**
 * TaValidasiPembayaranSearch represents the model behind the search form about `app\models\TaValidasiPembayaran`.
 */
class TaValidasiPembayaranSearch extends TaValidasiPembayaran
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Tahun', 'Kd_Urusan', 'Kd_Bidang', 'Kd_Unit', 'Kd_Sub', 'Kd_Trans_1', 'Kd_Trans_2', 'Kd_Trans_3'], 'integer'],
            [['No_Validasi', 'Tgl_Validasi', 'No_SPM', 'No_RPH', 'Nm_Penandatangan', 'Jabatan_Penandatangan', 'NIP_Penandatangan'], 'safe'],
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
        $query = TaValidasiPembayaran::find();

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
            'Kd_Urusan' => $this->Kd_Urusan,
            'Kd_Bidang' => $this->Kd_Bidang,
            'Kd_Unit' => $this->Kd_Unit,
            'Kd_Sub' => $this->Kd_Sub,
            'Tgl_Validasi' => $this->Tgl_Validasi,
            'Kd_Trans_1' => $this->Kd_Trans_1,
            'Kd_Trans_2' => $this->Kd_Trans_2,
            'Kd_Trans_3' => $this->Kd_Trans_3,
        ]);

        $query->andFilterWhere(['like', 'No_Validasi', $this->No_Validasi])
            ->andFilterWhere(['like', 'No_SPM', $this->No_SPM])
            ->andFilterWhere(['like', 'No_RPH', $this->No_RPH])
            ->andFilterWhere(['like', 'Nm_Penandatangan', $this->Nm_Penandatangan])
            ->andFilterWhere(['like', 'Jabatan_Penandatangan', $this->Jabatan_Penandatangan])
            ->andFilterWhere(['like', 'NIP_Penandatangan', $this->NIP_Penandatangan]);

        return $dataProvider;
    }
}
