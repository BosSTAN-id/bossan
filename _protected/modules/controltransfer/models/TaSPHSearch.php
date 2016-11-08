<?php

namespace app\modules\controltransfer\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TaSPH;

/**
 * TaSPHSearch represents the model behind the search form about `app\models\TaSPH`.
 */
class TaSPHSearch extends TaSPH
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Tahun', 'Kd_Urusan', 'Kd_Bidang', 'Kd_Unit', 'Kd_Sub'], 'integer'],
            [['No_SPH', 'Nm_Kepala_SKPD', 'NIP', 'Jabatan', 'Alamat', 'Kd_Rekanan', 'Nm_Rekanan', 'Jab_Rekanan', 'Alamat_Rekanan', 'Pekerjaan', 'No_Kontrak', 'Tgl_Kontrak', 'Nm_Perusahaan'], 'safe'],
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
        $query = TaSPH::find();

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
            'Nilai' => $this->Nilai,
            'Tgl_Kontrak' => $this->Tgl_Kontrak,
        ]);

        $query->andFilterWhere(['like', 'No_SPH', $this->No_SPH])
            ->andFilterWhere(['like', 'Nm_Kepala_SKPD', $this->Nm_Kepala_SKPD])
            ->andFilterWhere(['like', 'NIP', $this->NIP])
            ->andFilterWhere(['like', 'Jabatan', $this->Jabatan])
            ->andFilterWhere(['like', 'Alamat', $this->Alamat])
            ->andFilterWhere(['like', 'Kd_Rekanan', $this->Kd_Rekanan])
            ->andFilterWhere(['like', 'Nm_Rekanan', $this->Nm_Rekanan])
            ->andFilterWhere(['like', 'Jab_Rekanan', $this->Jab_Rekanan])
            ->andFilterWhere(['like', 'Alamat_Rekanan', $this->Alamat_Rekanan])
            ->andFilterWhere(['like', 'Pekerjaan', $this->Pekerjaan])
            ->andFilterWhere(['like', 'No_Kontrak', $this->No_Kontrak])
            ->andFilterWhere(['like', 'Nm_Perusahaan', $this->Nm_Perusahaan]);

        return $dataProvider;
    }
}
