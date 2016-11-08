<?php

namespace app\modules\controltransfer\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TaKontrak;

/**
 * TaKontrakSearch represents the model behind the search form about `app\models\TaKontrak`.
 */
class TaKontrakSearch extends TaKontrak
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Tahun', 'Kd_Urusan', 'Kd_Bidang', 'Kd_Unit', 'Kd_Sub', 'Kd_Prog', 'ID_Prog', 'Kd_Keg'], 'integer'],
            [['No_Kontrak', 'Tgl_Kontrak', 'Keperluan', 'Waktu', 'Nm_Perusahaan', 'Bentuk', 'Alamat', 'Nm_Pemilik', 'NPWP', 'Nm_Bank', 'Nm_Rekening', 'No_Rekening'], 'safe'],
            [['Nilai'], 'number'],
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
        $query = TaKontrak::find();

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
            'Kd_Urusan' => $this->Kd_Urusan,
            'Kd_Bidang' => $this->Kd_Bidang,
            'Kd_Unit' => $this->Kd_Unit,
            'Kd_Sub' => $this->Kd_Sub,
            'Kd_Prog' => $this->Kd_Prog,
            'ID_Prog' => $this->ID_Prog,
            'Kd_Keg' => $this->Kd_Keg,
            'Tgl_Kontrak' => $this->Tgl_Kontrak,
            'Nilai' => $this->Nilai,
        ]);

        $query->andFilterWhere(['like', 'No_Kontrak', $this->No_Kontrak])
            ->andFilterWhere(['like', 'Keperluan', $this->Keperluan])
            ->andFilterWhere(['like', 'Waktu', $this->Waktu])
            ->andFilterWhere(['like', 'Nm_Perusahaan', $this->Nm_Perusahaan])
            ->andFilterWhere(['like', 'Bentuk', $this->Bentuk])
            ->andFilterWhere(['like', 'Alamat', $this->Alamat])
            ->andFilterWhere(['like', 'Nm_Pemilik', $this->Nm_Pemilik])
            ->andFilterWhere(['like', 'NPWP', $this->NPWP])
            ->andFilterWhere(['like', 'Nm_Bank', $this->Nm_Bank])
            ->andFilterWhere(['like', 'Nm_Rekening', $this->Nm_Rekening])
            ->andFilterWhere(['like', 'No_Rekening', $this->No_Rekening]);

        return $dataProvider;
    }
}
