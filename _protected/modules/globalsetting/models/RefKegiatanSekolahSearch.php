<?php

namespace app\modules\globalsetting\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RefKegiatanSekolah;

/**
 * RefKegiatanSekolahSearch represents the model behind the search form about `app\models\RefKegiatanSekolah`.
 */
class RefKegiatanSekolahSearch extends RefKegiatanSekolah
{
    public $kode;
    public $uraian_program;
    public $kd_sub_program_gb;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'kd_program', 'subprogram_id', 'kd_sub_program', 'kd_kegiatan'], 'integer'],
            [['kode', 'uraian_program', 'kd_sub_program_gb'], 'string'],
            [['uraian_kegiatan'], 'safe'],
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
        $query = RefKegiatanSekolah::find();

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

        IF(isset($this->kode) & $this->kode <> NULL){
            $var = explode ('.', $this->kode);
            $this->kd_program = $var['0'];
            IF(isset($var['1'])) $this->kd_sub_program = $var['1'];
            IF(isset($var['2']))$this->kd_kegiatan = $var['2'];
        }

        IF(isset($this->kd_sub_program_gb) & $this->kd_sub_program_gb <> NULL){
            $var = explode ('.', $this->kd_sub_program_gb);
            $this->kd_program = $var['0'];
            $this->kd_sub_program = $var['1'];
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'kd_program' => $this->kd_program,
            'subprogram_id' => $this->subprogram_id,
            'kd_sub_program' => $this->kd_sub_program,
            'kd_kegiatan' => $this->kd_kegiatan,
        ]);

        $query->andFilterWhere(['like', 'uraian_kegiatan', $this->uraian_kegiatan]);

        // // filter by country name
        // $query->joinWith(['refProgram' => function ($q) {
        //     $q->where('ref_program_sekolah.uraian_program LIKE "%' . $this->uraian_program . '%"');
        // }]); 


        return $dataProvider;
    }
}
