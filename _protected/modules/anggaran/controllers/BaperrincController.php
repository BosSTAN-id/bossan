<?php

namespace app\modules\anggaran\controllers;

use Yii;
use app\models\TaRkasPeraturan;
use app\modules\anggaran\models\TaRkasPeraturanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;

/**
 * BaperrincController implements the CRUD actions for TaRkasPeraturan model.
 */
class BaperrincController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all TaRkasPeraturan models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new TaRkasPeraturanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionK2($tahun, $sekolah_id, $perubahan_id, $penerimaan2){
        if($penerimaan2) list($kd_penerimaan_1, $kd_penerimaan_2) = explode('.', $penerimaan2);
        if($kd_penerimaan_1 == 0 || !$kd_penerimaan_1) $kd_penerimaan_1 = '%';
        if($kd_penerimaan_2 == 0 || !$kd_penerimaan_2) $kd_penerimaan_2 = '%';
        $model = $this->findModel($tahun, $sekolah_id, $perubahan_id);
        $Tahun = $tahun;
        $data =  Yii::$app->db->createCommand("
            SELECT a.tahun, a.sekolah_id, a.kd_program, c.uraian_program, a.kd_sub_program, d.uraian_sub_program, a.kd_kegiatan, e.uraian_kegiatan, a.Kd_Rek_1, a.anggaran, b.TW1, b.TW2, b.TW3, b.TW4 FROM
            (
                SELECT
                a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, SUM(a.total) AS anggaran
                FROM
                ta_rkas_history a
                WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = :perubahan_id
                AND IFNULL(a.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2,'') LIKE :kd_penerimaan_2
                GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1
            ) a 
            LEFT JOIN
            (
                SELECT
                a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1,
                SUM(IFNULL(a.januari1,0) + IFNULL(a.februari1,0) + IFNULL(a.maret1,0)) AS TW1,
                SUM(IFNULL(a.april1,0) + IFNULL(a.mei1,0) + IFNULL(a.juni1,0)) AS TW2,
                SUM(IFNULL(a.juli,0) + IFNULL(a.agustus,0) + IFNULL(a.september,0)) AS TW3,
                SUM(IFNULL(a.oktober,0) + IFNULL(a.november,0) + IFNULL(a.desember,0)) AS TW4
                FROM
                ta_rkas_belanja_rencana_history a
                INNER JOIN 
                (
                    SELECT a.tahun, a.sekolah_id, a.perubahan_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2 , a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                        FROM ta_rkas_history a
                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = :perubahan_id
                        AND IFNULL(a.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2,'') LIKE :kd_penerimaan_2
                        GROUP BY a.tahun, a.sekolah_id, a.perubahan_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2 , a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                )b 
                ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.perubahan_id = b.perubahan_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.kd_rek_5 = b.Kd_Rek_5
                WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = :perubahan_id
                AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2,'') LIKE :kd_penerimaan_2
                GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1
                UNION ALL
                SELECT
                a.tahun, a.sekolah_id, 0 AS kd_program, 0 AS kd_sub_program, 0 AS kd_kegiatan, a.Kd_Rek_1,
                SUM(IFNULL(a.januari1,0) + IFNULL(a.februari1,0) + IFNULL(a.maret1,0)) AS TW1,
                SUM(IFNULL(a.april1,0) + IFNULL(a.mei1,0) + IFNULL(a.juni1,0)) AS TW2,
                SUM(IFNULL(a.juli,0) + IFNULL(a.agustus,0) + IFNULL(a.september,0)) AS TW3,
                SUM(IFNULL(a.oktober,0) + IFNULL(a.november,0) + IFNULL(a.desember,0)) AS TW4
                FROM
                ta_rkas_pendapatan_rencana_history a
                WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = :perubahan_id
                AND a.kd_penerimaan_1 LIKE :kd_penerimaan_1 AND a.kd_penerimaan_2 LIKE :kd_penerimaan_2
                GROUP BY a.tahun, a.sekolah_id, a.Kd_Rek_1
            ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan AND a.Kd_Rek_1 = b.Kd_Rek_1
            INNER JOIN ref_program_sekolah c ON a.kd_program = c.kd_program
            INNER JOIN ref_sub_program_sekolah d ON a.kd_program = d.kd_program AND a.kd_sub_program = d.kd_sub_program
            INNER JOIN ref_kegiatan_sekolah e ON a.kd_program = e.kd_program AND a.kd_sub_program = e.kd_sub_program AND a.kd_kegiatan = e.kd_kegiatan
            ORDER BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1 ASC                        
        ")->bindValues([
            ':tahun' => $Tahun,
            ':sekolah_id' => $sekolah_id,
            ':perubahan_id' => $perubahan_id,
            ':kd_penerimaan_1' => $kd_penerimaan_1,
            ':kd_penerimaan_2' => $kd_penerimaan_2,
        ])->queryAll();

        $peraturan = \app\models\TaRkasPeraturan::findOne([
            'tahun' => $Tahun,
            'perubahan_id' => $perubahan_id,
            'sekolah_id' => $sekolah_id,
            ]);
        $references = \app\models\TaTh::findOne(['tahun' => $Tahun]);   
        if(isset($kd_penerimaan_1)) $footerSumberDana = \app\models\RefPenerimaanSekolah2::find()->where(['kd_penerimaan_1' => $kd_penerimaan_1, 'kd_penerimaan_2' => $kd_penerimaan_2])->one();
        return $this->render('preview1', [
            'model' => $model,
            'data' => $data,
            'Tahun' => $tahun,
            'peraturan' => $peraturan,
            'ref' => $references,
            'footerSumberDana' => isset($footerSumberDana) ? $footerSumberDana : null,
        ]);
    }

    public function actionBos($tahun, $sekolah_id, $perubahan_id, $penerimaan2){
        if($penerimaan2) list($kd_penerimaan_1, $kd_penerimaan_2) = explode('.', $penerimaan2);
        if($kd_penerimaan_1 == 0 || !$kd_penerimaan_1) $kd_penerimaan_1 = '%';
        if($kd_penerimaan_2 == 0 || !$kd_penerimaan_2) $kd_penerimaan_2 = '%';
        $model = $this->findModel($tahun, $sekolah_id, $perubahan_id);
        $Tahun = $tahun;
        $data =  Yii::$app->db->createCommand("  
            SELECT
            a.tahun, a.sekolah_id, IFNULL(a.komponen_id, 0) AS komponen_id, IFNULL(b.komponen, 'Non-Komponen BOS') AS komponen, a.Kd_Rek_1, SUM(a.total) AS anggaran
            FROM
            ta_rkas_history a
            LEFT JOIN ref_komponen_bos b ON a.komponen_id = b.id
            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = :perubahan_id
            AND IFNULL(a.kd_penerimaan_1, '') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.Kd_Rek_1 = 5
            GROUP BY a.tahun, a.sekolah_id, a.komponen_id, a.Kd_Rek_1                                      
        ")->bindValues([
                ':tahun' => $Tahun,
                ':sekolah_id' => $sekolah_id,
                ':perubahan_id' => $perubahan_id,
                ':kd_penerimaan_1' => $kd_penerimaan_1,
                ':kd_penerimaan_2' => $kd_penerimaan_2,
        ])->queryAll();
        $total =  Yii::$app->db->createCommand("  
            SELECT
            a.tahun, a.sekolah_id, SUM(a.total) AS anggaran
            FROM
            ta_rkas_history a
            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = :perubahan_id
            AND IFNULL(a.kd_penerimaan_1, '') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.Kd_Rek_1 = 5
            GROUP BY a.tahun, a.sekolah_id
        ")->bindValues([
                ':tahun' => $Tahun,
                ':sekolah_id' => $sekolah_id,
                ':perubahan_id' => $perubahan_id,
                ':kd_penerimaan_1' => $kd_penerimaan_1,
                ':kd_penerimaan_2' => $kd_penerimaan_2,
        ])->queryAll();

        $peraturan = \app\models\TaRkasPeraturan::findOne([
            'tahun' => $Tahun,
            'perubahan_id' => $perubahan_id,
            'sekolah_id' => $sekolah_id,
            ]);
        $references = \app\models\TaTh::findOne(['tahun' => $Tahun]);   
        if(isset($kd_penerimaan_1)) $footerSumberDana = \app\models\RefPenerimaanSekolah2::find()->where(['kd_penerimaan_1' => $kd_penerimaan_1, 'kd_penerimaan_2' => $kd_penerimaan_2])->one();
        return $this->render('preview2', [
            'model' => $model,
            'data' => $data,
            'Tahun' => $tahun,
            'peraturan' => $peraturan,
            'ref' => $references,
            'totalAnggaran' => $total[0]['anggaran'],
            'footerSumberDana' => isset($footerSumberDana) ? $footerSumberDana : null,
        ]);
    }

    public function actionRka221($tahun, $sekolah_id, $perubahan_id, $penerimaan2){
        if($penerimaan2) list($kd_penerimaan_1, $kd_penerimaan_2) = explode('.', $penerimaan2);
        if($kd_penerimaan_1 == 0 || !$kd_penerimaan_1) $kd_penerimaan_1 = '%';
        if($kd_penerimaan_2 == 0 || !$kd_penerimaan_2) $kd_penerimaan_2 = '%';
        $model = $this->findModel($tahun, $sekolah_id, $perubahan_id);
        $Tahun = $tahun;
        $data =  Yii::$app->db->createCommand("  
            SELECT
            a.kd_program, b.uraian_program,
            a.kd_sub_program, c.uraian_sub_program,
            a.kd_kegiatan, d.uraian_kegiatan,
            a.Kd_Rek_1, j.Nm_Rek_1, a.Kd_Rek_2, e.Nm_Rek_2,
            a.Kd_Rek_3, f.Nm_Rek_3,
            a.Kd_Rek_4, g.Nm_Rek_4,
            a.Kd_Rek_5, h.Nm_Rek_5,
            a.sekolah_id, i.nama_sekolah,
            a.keterangan, 
            a.jml_satuan,
            a.satuan123,
            a.nilai_rp,
            SUM(a.total) AS total
            FROM (
                    SELECT
                    c.tahun,
                    c.sekolah_id,
                    c.no_peraturan,
                    c.tgl_peraturan,
                    c.perubahan_id,
                    d.kd_program,
                    d.kd_sub_program,
                    d.kd_kegiatan,
                    d.Kd_Rek_1,
                    d.Kd_Rek_2,
                    d.Kd_Rek_3,
                    d.Kd_Rek_4,
                    d.Kd_Rek_5,
                    d.no_rinc,
                    d.keterangan,
                    d.satuan123,
                    d.jml_satuan,
                    d.nilai_rp,
                    d.total
                    FROM
                    ta_rkas_peraturan AS c
                    INNER JOIN ta_rkas_history AS d ON d.tahun = c.tahun AND d.sekolah_id = c.sekolah_id AND d.perubahan_id = c.perubahan_id
                    WHERE c.tahun = :tahun AND c.sekolah_id = :sekolah_id AND c.perubahan_id = :perubahan_id AND
                    IFNULL(d.kd_penerimaan_1, '') LIKE :kd_penerimaan_1 AND IFNULL(d.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
            ) a
            INNER JOIN ref_program_sekolah b ON a.kd_program = b.kd_program
            INNER JOIN ref_sub_program_sekolah c ON a.kd_program = c.kd_program AND a.kd_sub_program = c.kd_sub_program
            INNER JOIN ref_kegiatan_sekolah d ON a.kd_program = d.kd_program AND a.kd_sub_program = d.kd_sub_program AND a.kd_kegiatan = d.kd_kegiatan
            INNER JOIN ref_rek_1 j ON a.Kd_Rek_1 = j.Kd_Rek_1
            INNER JOIN ref_rek_2 e ON a.Kd_Rek_1 = e.Kd_Rek_1 AND a.Kd_Rek_2 =  e.Kd_Rek_2
            INNER JOIN ref_rek_3 f ON a.Kd_Rek_1 = f.Kd_Rek_1 AND a.Kd_Rek_2 =  f.Kd_Rek_2 AND a.Kd_Rek_3 = f.Kd_Rek_3
            INNER JOIN ref_rek_4 g ON a.Kd_Rek_1 = g.Kd_Rek_1 AND a.Kd_Rek_2 =  g.Kd_Rek_2 AND a.Kd_Rek_3 = g.Kd_Rek_3 AND a.Kd_Rek_4 = g.Kd_Rek_4
            INNER JOIN ref_rek_5 h ON a.Kd_Rek_1 = h.Kd_Rek_1 AND a.Kd_Rek_2 =  h.Kd_Rek_2 AND a.Kd_Rek_3 = h.Kd_Rek_3 AND a.Kd_Rek_4 = h.Kd_Rek_4 AND a.Kd_Rek_5 = h.Kd_Rek_5
            INNER JOIN ref_sekolah i ON a.sekolah_id = i.id
            GROUP BY a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.jml_satuan, a.satuan123, a.nilai_rp, a.keterangan
            ORDER BY a.Kd_Rek_1, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5 ASC                                                                       
        ")->bindValues([
                ':tahun' => $Tahun,
                ':sekolah_id' => $sekolah_id,
                ':perubahan_id' => $perubahan_id,
                ':kd_penerimaan_1' => $kd_penerimaan_1,
                ':kd_penerimaan_2' => $kd_penerimaan_2,
        ])->queryAll();

        $peraturan = \app\models\TaRkasPeraturan::findOne([
            'tahun' => $Tahun,
            'perubahan_id' => $perubahan_id,
            'sekolah_id' => $sekolah_id,
            ]);
        $references = \app\models\TaTh::findOne(['tahun' => $Tahun]);   
        if(isset($kd_penerimaan_1)) $footerSumberDana = \app\models\RefPenerimaanSekolah2::find()->where(['kd_penerimaan_1' => $kd_penerimaan_1, 'kd_penerimaan_2' => $kd_penerimaan_2])->one();
        return $this->render('preview3', [
            'model' => $model,
            'data' => $data,
            'Tahun' => $tahun,
            'peraturan' => $peraturan,
            'ref' => $references,
            // 'totalAnggaran' => $total[0]['anggaran'],
            'footerSumberDana' => isset($footerSumberDana) ? $footerSumberDana : null,
        ]);
    }

    public function actionView($tahun, $sekolah_id, $perubahan_id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "TaRkasPeraturan #".$tahun, $sekolah_id, $perubahan_id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($tahun, $sekolah_id, $perubahan_id),
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','tahun, $sekolah_id, $perubahan_id'=>$tahun, $sekolah_id, $perubahan_id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($tahun, $sekolah_id, $perubahan_id),
            ]);
        }
    }


    public function actionBulkDelete()
    {        
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
       
    }

    protected function findModel($tahun, $sekolah_id, $perubahan_id)
    {
        if (($model = TaRkasPeraturan::findOne(['tahun' => $tahun, 'sekolah_id' => $sekolah_id, 'perubahan_id' => $perubahan_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
