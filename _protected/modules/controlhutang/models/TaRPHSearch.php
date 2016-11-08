<?php

namespace app\modules\controlhutang\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TaRPH;

/**
 * TaRPHSearch represents the model behind the search form about `app\models\TaRPH`.
 */
class TaRPHSearch extends TaRPH
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Tahun', 'Kd_Urusan', 'Kd_Bidang', 'Kd_Unit', 'Kd_Sub', 'Lampiran_RPH'], 'integer'],
            [['No_SPH', 'No_SPM', 'No_RPH', 'Tgl_RPH', 'Nm_Kepala_SKPD', 'NIP', 'Jabatan', 'Jatuh_Tempo', 'Rekening_Tujuan', 'Bank', 'Cabang', 'Nama_Rekening'], 'safe'],
            [['Nilai_Bayar', 'PPh', 'PPn', 'Denda'], 'number'],
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
        $query = TaRPH::find();

        // add conditions that should always apply here
        IF(isset(Yii::$app->user->identity->Kd_Urusan) && Yii::$app->user->identity->Kd_Urusan <> NULL) {
            $query->andWhere(['Kd_Urusan' => Yii::$app->user->identity->Kd_Urusan]);
            $query->andWhere(['Kd_Bidang' => Yii::$app->user->identity->Kd_Bidang]);
            $query->andWhere(['Kd_Unit' => Yii::$app->user->identity->Kd_Unit]);
            $query->andWhere(['Kd_Sub' => Yii::$app->user->identity->Kd_Sub]);
        }  

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
            'Tgl_RPH' => $this->Tgl_RPH,
            'Jatuh_Tempo' => $this->Jatuh_Tempo,
            'Nilai_Bayar' => $this->Nilai_Bayar,
            'PPh' => $this->PPh,
            'PPn' => $this->PPn,
            'Denda' => $this->Denda,
            'Lampiran_RPH' => $this->Lampiran_RPH,
        ]);

        $query->andFilterWhere(['like', 'No_SPH', $this->No_SPH])
            ->andFilterWhere(['like', 'No_SPM', $this->No_SPM])
            ->andFilterWhere(['like', 'No_RPH', $this->No_RPH])
            ->andFilterWhere(['like', 'Nm_Kepala_SKPD', $this->Nm_Kepala_SKPD])
            ->andFilterWhere(['like', 'NIP', $this->NIP])
            ->andFilterWhere(['like', 'Jabatan', $this->Jabatan])
            ->andFilterWhere(['like', 'Rekening_Tujuan', $this->Rekening_Tujuan])
            ->andFilterWhere(['like', 'Bank', $this->Bank])
            ->andFilterWhere(['like', 'Cabang', $this->Cabang])
            ->andFilterWhere(['like', 'Nama_Rekening', $this->Nama_Rekening]);

        return $dataProvider;
    }
}
