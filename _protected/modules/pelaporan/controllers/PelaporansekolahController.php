<?php

namespace app\modules\pelaporan\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;

/**
 * ValidasiController implements the CRUD actions for TaValidasiPembayaran model.
 */
class PelaporansekolahController extends Controller
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
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all TaValidasiPembayaran models.
     * @return mixed
     */
    public function actionIndex()
    {
        IF($this->cekakses() !== true){
            Yii::$app->getSession()->setFlash('warning',  'Anda tidak memiliki hak akses');
            return $this->redirect(Yii::$app->request->referrer);
        }    
        IF(Yii::$app->session->get('tahun'))
        {
            $Tahun = Yii::$app->session->get('tahun');
        }ELSE{
            $Tahun = DATE('Y');
        }

        $get = new \app\models\Laporan();
        $Kd_Laporan = NULL;
        $data = NULL;
        $data1 = NULL;
        $data2 = NULL;
        $data3 = NULL;
        $data4 = NULL;
        $data5 = NULL;
        $data6 = NULL;
        $render = NULL;
        $getparam = NULL;
        IF(Yii::$app->request->queryParams){
            $getparam = Yii::$app->request->queryParams;
            IF($getparam['Laporan']['Kd_Sumber'] <> NULL){
                list($kd_penerimaan_1, $kd_penerimaan_2) = explode('.', $getparam['Laporan']['Kd_Sumber']);
                IF($kd_penerimaan_1 == 0) $kd_penerimaan_1 = '%';
                IF($kd_penerimaan_2 == 0) $kd_penerimaan_2 = '%';
            }
            IF($getparam['Laporan']['Kd_Laporan']){
                $Kd_Laporan = Yii::$app->request->queryParams['Laporan']['Kd_Laporan'];
                switch ($Kd_Laporan) {
                    case 1:
                        $data1 = \app\models\TaSaldoAwal::find()->where([
                            'tahun' => $Tahun,
                            'sekolah_id' => Yii::$app->user->identity->sekolah_id,
                            ])->andWhere("IFNULL(kd_penerimaan_1,'') LIKE '$kd_penerimaan_1' AND IFNULL(kd_penerimaan_2,'') LIKE '$kd_penerimaan_2'");
                        $data2 = \app\models\TaRkasHistory::find()->where([
                            'tahun' => $Tahun,
                            'perubahan_id' => $getparam['Laporan']['perubahan_id'],
                            'sekolah_id' => Yii::$app->user->identity->sekolah_id,
                            'Kd_Rek_1' => 4,
                            ])->andWhere("IFNULL(kd_penerimaan_1,'') LIKE '$kd_penerimaan_1' AND IFNULL(kd_penerimaan_2,'') LIKE '$kd_penerimaan_2'");
                        $data3 = \app\models\TaRkasHistory::find()->where([
                            'tahun' => $Tahun,
                            'perubahan_id' => $getparam['Laporan']['perubahan_id'],
                            'sekolah_id' => Yii::$app->user->identity->sekolah_id,
                            'Kd_Rek_1' => 4,
                            ])->andWhere("IFNULL(kd_penerimaan_1,'') LIKE '$kd_penerimaan_1' AND IFNULL(kd_penerimaan_2,'') LIKE '$kd_penerimaan_2'");
                        $data5 = \app\models\TaRkasHistory::find()->where([
                            'tahun' => $Tahun,
                            'perubahan_id' => $getparam['Laporan']['perubahan_id'],
                            'sekolah_id' => Yii::$app->user->identity->sekolah_id,
                            'Kd_Rek_1' => 4,
                            ])->andWhere("IFNULL(kd_penerimaan_1,'') LIKE '$kd_penerimaan_1' AND IFNULL(kd_penerimaan_2,'') LIKE '$kd_penerimaan_2'");
                        $data4 = \app\models\TaRkasHistory::find()->where([
                            'tahun' => $Tahun,
                            'perubahan_id' => $getparam['Laporan']['perubahan_id'],
                            'sekolah_id' => Yii::$app->user->identity->sekolah_id,
                            'Kd_Rek_1' => 4,
                            ])->andWhere("IFNULL(kd_penerimaan_1,'') LIKE '$kd_penerimaan_1' AND IFNULL(kd_penerimaan_2,'') LIKE '$kd_penerimaan_2'");
                        $data = \app\models\TaRkasHistory::find()
                            ->select(["kd_program", "SUM(total) AS total"])
                            ->where([
                            'tahun' => $Tahun,
                            'perubahan_id' => $getparam['Laporan']['perubahan_id'],
                            'sekolah_id' => Yii::$app->user->identity->sekolah_id,
                            'Kd_Rek_1' => 5,
                            ])->andWhere("IFNULL(kd_penerimaan_1,'') LIKE '$kd_penerimaan_1' AND IFNULL(kd_penerimaan_2,'') LIKE '$kd_penerimaan_2'")->groupBy('kd_program')->orderBy('kd_program')->all();
                        // $data = new ActiveDataProvider([
                        //     'query' => \app\models\TaSPH::find()->where("Tahun <= $Tahun")->andWhere('Saldo > 0')
                        // ]);
                        // IF(Yii::$app->user->identity->Kd_Urusan){
                        //     $data->query->andWhere([
                        //                      'ta_sph.Kd_Urusan'=> Yii::$app->user->identity->Kd_Urusan,
                        //                      'ta_sph.Kd_Bidang'=> Yii::$app->user->identity->Kd_Bidang,
                        //                      'ta_sph.Kd_Unit'=> Yii::$app->user->identity->Kd_Unit,
                        //                      'ta_sph.Kd_Sub'=> Yii::$app->user->identity->Kd_Sub,
                        //                      ]);
                        // }

                        // IF(isset($getparam['RefSubUnit']['skpd'])){
                        //     list($Kd_Urusan, $Kd_Bidang, $Kd_Unit, $Kd_Sub) = explode('.', $getparam['RefSubUnit']['skpd']);
                        //     $data->query->andWhere([
                        //                      'ta_sph.Kd_Urusan'=> $Kd_Urusan,
                        //                      'ta_sph.Kd_Bidang'=> $Kd_Bidang,
                        //                      'ta_sph.Kd_Unit'=> $Kd_Unit,
                        //                      'ta_sph.Kd_Sub'=> $Kd_Sub,
                        //                      ]);
                        // }                        
                        // $data->query->orderBy('Tahun DESC');  
                        $render = 'laporan1';
                        break;
                    case 2:
                        $totalCount = Yii::$app->db->createCommand("
                            SELECT COUNT(a.tahun) FROM
                            (
                                SELECT
                                a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, SUM(a.total) AS anggaran
                                FROM
                                ta_rkas_history a
                                WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = :perubahan_id
                                AND IFNULL(a.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2,'') LIKE :kd_penerimaan_2
                                GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1
                            ) a     
                            ", [
                                ':tahun' => $Tahun,
                                ':sekolah_id' => Yii::$app->user->identity->sekolah_id,
                                ':perubahan_id' => $getparam['Laporan']['perubahan_id'],
                                ':kd_penerimaan_1' => $kd_penerimaan_1,
                                ':kd_penerimaan_2' => $kd_penerimaan_2,
                            ])->queryScalar();

                        $data = new SqlDataProvider([
                            'sql' => "
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
                                    ",
                            'params' => [
                                ':tahun' => $Tahun,
                                ':sekolah_id' => Yii::$app->user->identity->sekolah_id,
                                ':perubahan_id' => $getparam['Laporan']['perubahan_id'],
                                ':kd_penerimaan_1' => $kd_penerimaan_1,
                                ':kd_penerimaan_2' => $kd_penerimaan_2,
                            ],
                            'totalCount' => $totalCount,
                            //'sort' =>false, to remove the table header sorting
                            'pagination' => [
                                'pageSize' => 50,
                            ],
                        ]);                                  
                        $render = 'laporan2';
                        break;   
                    case 3:
                        $totalCount = Yii::$app->db->createCommand("
                            SELECT COUNT(a.tahun) FROM
                            (
                                /*SALDO AWAL */
                                SELECT
                                a.tahun, a.sekolah_id, a.kd_penerimaan_1, a.kd_penerimaan_2, '' AS kode, '' AS no_bukti, NULL AS tgl_bukti, 'Saldo Awal' AS keterangan, SUM(a.nilai) AS nilai
                                FROM
                                ta_saldo_awal a
                                WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND IFNULL(a.kd_penerimaan_1, '') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.pembayaran LIKE '%'
                                GROUP BY a.tahun, a.sekolah_id, a.kd_penerimaan_1, a.kd_penerimaan_2
                                /*Saldo Awal sejak tanggal */
                                UNION ALL
                                SELECT
                                a.tahun,
                                a.sekolah_id,
                                '' AS kd_penerimaan_1,
                                '' AS kd_penerimaan_2,
                                '' AS kode, 
                                '' AS no_bukti,
                                '2016-01-01' AS tgl_bukti,
                                'Akumulasi Transaksi' AS uraian,
                                SUM(
                                CASE a.Kd_Rek_1
                                    WHEN 4 THEN a.nilai
                                    WHEN 5 THEN -(a.nilai)
                                END
                                ) AS nilai
                                FROM
                                ta_spj_rinc AS a
                                LEFT JOIN
                                (
                                    SELECT 
                                    a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                    FROM ta_rkas_history a 
                                    WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                    AND IFNULL(a.kd_penerimaan_1, '') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                    GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti < :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                GROUP BY a.tahun, a.sekolah_id
                                /*Transaksi */
                                UNION ALL
                                SELECT
                                a.tahun,
                                a.sekolah_id,
                                b.kd_penerimaan_1,
                                b.kd_penerimaan_2,
                                CONCAT(a.kd_program, RIGHT(CONCAT('0',a.kd_sub_program),2), RIGHT(CONCAT('0',a.kd_kegiatan),2), '.', a.Kd_Rek_3, RIGHT(CONCAT('0',a.Kd_Rek_4),2), RIGHT(CONCAT('0',a.Kd_Rek_5),2)) AS kode,
                                a.no_bukti,
                                a.tgl_bukti,
                                a.uraian,
                                CASE a.Kd_Rek_1
                                    WHEN 4 THEN a.nilai
                                    WHEN 5 THEN -(a.nilai)
                                END
                                FROM
                                ta_spj_rinc AS a
                                LEFT JOIN
                                (
                                    SELECT 
                                    a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                    FROM ta_rkas_history a 
                                    WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                    AND IFNULL(a.kd_penerimaan_1, '') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                    GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                            ) a ORDER BY tgl_bukti, no_bukti ASC    
                            ", [
                                ':tahun' => $Tahun,
                                ':sekolah_id' => Yii::$app->user->identity->sekolah_id,
                                ':perubahan_id' => $getparam['Laporan']['perubahan_id'],
                                ':kd_penerimaan_1' => $kd_penerimaan_1,
                                ':kd_penerimaan_2' => $kd_penerimaan_2,
                                ':tgl_1' => $getparam['Laporan']['Tgl_1'],
                                ':tgl_2' => $getparam['Laporan']['Tgl_2'],
                            ])->queryScalar();

                        $data = new SqlDataProvider([
                            'sql' => "
                                    SELECT * FROM
                                    (
                                        /*SALDO AWAL */
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_penerimaan_1, a.kd_penerimaan_2, '' AS kode, '' AS no_bukti, '$Tahun-01-01' AS tgl_bukti, 'Saldo Awal' AS keterangan, SUM(a.nilai) AS nilai
                                        FROM
                                        ta_saldo_awal a
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND IFNULL(a.kd_penerimaan_1, '') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.pembayaran LIKE '%'
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        /*Saldo Awal sejak tanggal */
                                        UNION ALL
                                        SELECT
                                        a.tahun,
                                        a.sekolah_id,
                                        '' AS kd_penerimaan_1,
                                        '' AS kd_penerimaan_2,
                                        '' AS kode, 
                                        '' AS no_bukti,
                                        :tgl_1 AS tgl_bukti,
                                        'Akumulasi Transaksi' AS uraian,
                                        SUM(
                                        CASE a.Kd_Rek_1
                                            WHEN 4 THEN a.nilai
                                            WHEN 5 THEN -(a.nilai)
                                        END
                                        ) AS nilai
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                            SELECT 
                                            a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            FROM ta_rkas_history a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                            AND IFNULL(a.kd_penerimaan_1, '') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                            GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti < :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                        GROUP BY a.tahun, a.sekolah_id
                                        /*Transaksi */
                                        UNION ALL
                                        SELECT
                                        a.tahun,
                                        a.sekolah_id,
                                        b.kd_penerimaan_1,
                                        b.kd_penerimaan_2,
                                        CONCAT(a.kd_program, RIGHT(CONCAT('0',a.kd_sub_program),2), RIGHT(CONCAT('0',a.kd_kegiatan),2), '.', a.Kd_Rek_3, RIGHT(CONCAT('0',a.Kd_Rek_4),2), RIGHT(CONCAT('0',a.Kd_Rek_5),2)) AS kode,
                                        a.no_bukti,
                                        a.tgl_bukti,
                                        a.uraian,
                                        CASE a.Kd_Rek_1
                                            WHEN 4 THEN a.nilai
                                            WHEN 5 THEN -(a.nilai)
                                        END
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                            SELECT 
                                            a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            FROM ta_rkas_history a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                            AND IFNULL(a.kd_penerimaan_1, '') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                            GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                    ) a ORDER BY tgl_bukti, no_bukti ASC
                                    ",
                            'params' => [
                                ':tahun' => $Tahun,
                                ':sekolah_id' => Yii::$app->user->identity->sekolah_id,
                                ':perubahan_id' => $getparam['Laporan']['perubahan_id'],
                                ':kd_penerimaan_1' => $kd_penerimaan_1,
                                ':kd_penerimaan_2' => $kd_penerimaan_2,
                                ':tgl_1' => $getparam['Laporan']['Tgl_1'],
                                ':tgl_2' => $getparam['Laporan']['Tgl_2'],
                            ],
                            'totalCount' => $totalCount,
                            //'sort' =>false, to remove the table header sorting
                            'pagination' => [
                                'pageSize' => 50,
                            ],
                        ]);                                  
                        $render = 'laporan3';
                        break;
                    case 4:
                        $totalCount = Yii::$app->db->createCommand("
                            SELECT COUNT(a.tahun) FROM
                            (
                                        /*SALDO AWAL */
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_penerimaan_1, a.kd_penerimaan_2, '' AS kode, '' AS no_bukti, '$Tahun-01-01' AS tgl_bukti, 'Saldo Awal' AS keterangan, SUM(a.nilai) AS nilai
                                        FROM
                                        ta_saldo_awal a
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND IFNULL(a.kd_penerimaan_1, '') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.pembayaran = 2
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        /*Saldo Awal sejak tanggal */
                                        UNION ALL
                                        SELECT
                                        a.tahun,
                                        a.sekolah_id,
                                        '' AS kd_penerimaan_1,
                                        '' AS kd_penerimaan_2,
                                        '' AS kode, 
                                        '' AS no_bukti,
                                        '2016-05-31' AS tgl_bukti,
                                        'Akumulasi Transaksi' AS uraian,
                                        SUM(a.nilai) AS nilai
                                        FROM
                                        (                                        
                                            SELECT
                                            a.tahun,
                                            a.sekolah_id,
                                            '' AS kd_penerimaan_1,
                                            '' AS kd_penerimaan_2,
                                            '' AS kode, 
                                            '' AS no_bukti,
                                            '2016-01-01' AS tgl_bukti,
                                            'Akumulasi Transaksi' AS uraian,
                                            SUM(
                                            CASE a.Kd_Rek_1
                                                WHEN 4 THEN a.nilai
                                                WHEN 5 THEN -(a.nilai)
                                            END
                                            ) AS nilai
                                            FROM
                                            ta_spj_rinc AS a
                                            LEFT JOIN
                                            (
                                                SELECT 
                                                a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                                FROM ta_rkas_history a 
                                                WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                                AND IFNULL(a.kd_penerimaan_1, '') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                                GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                            AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti < :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.pembayaran = 2
                                            GROUP BY a.tahun, a.sekolah_id
                                            UNION ALL
                                            SELECT a.tahun, a.sekolah_id, '' AS kd_penerimaan_1, '' AS kd_penerimaan_2, '' AS kode, '' AS no_bukti, '' AS tgl_bukti, '' AS uraian,
                                            SUM(CASE a.kd_mutasi
                                                WHEN 1 THEN a.nilai
                                                WHEN 2 THEN -(a.nilai)
                                            END) AS nilai
                                            FROM ta_mutasi_kas a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_1
                                            GROUP BY a.tahun, a.sekolah_id
                                        ) a GROUP BY a.tahun, a.sekolah_id                                            
                                        /*Transaksi */
                                        UNION ALL
                                        SELECT
                                        a.tahun,
                                        a.sekolah_id,
                                        b.kd_penerimaan_1,
                                        b.kd_penerimaan_2,
                                        CONCAT(a.kd_program, RIGHT(CONCAT('0',a.kd_sub_program),2), RIGHT(CONCAT('0',a.kd_kegiatan),2), '.', a.Kd_Rek_3, RIGHT(CONCAT('0',a.Kd_Rek_4),2), RIGHT(CONCAT('0',a.Kd_Rek_5),2)) AS kode,
                                        a.no_bukti,
                                        a.tgl_bukti,
                                        a.uraian,
                                        CASE a.Kd_Rek_1
                                            WHEN 4 THEN a.nilai
                                            WHEN 5 THEN -(a.nilai)
                                        END
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                            SELECT 
                                            a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            FROM ta_rkas_history a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                            AND IFNULL(a.kd_penerimaan_1, '') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                            GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2  AND a.pembayaran = 2
                                        /*Mutasi Kas*/
                                        UNION ALL
                                        SELECT a.tahun, a.sekolah_id, '' AS kd_penerimaan_1, '' AS kd_penerimaan_2, '' AS kode, a.no_bukti, a.tgl_bukti, a.uraian,
                                        CASE a.kd_mutasi
                                            WHEN 1 THEN a.nilai
                                            WHEN 2 THEN -(a.nilai)
                                        END 
                                        FROM ta_mutasi_kas a 
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 
                                        /*Potongan Pajak Transaksi */
                                        UNION ALL
                                        SELECT
                                        a.tahun,
                                        a.sekolah_id,
                                        b.kd_penerimaan_1,
                                        b.kd_penerimaan_2,
                                        CONCAT(a.kd_program, RIGHT(CONCAT('0',a.kd_sub_program),2), RIGHT(CONCAT('0',a.kd_kegiatan),2), '.', a.Kd_Rek_3, RIGHT(CONCAT('0',a.Kd_Rek_4),2), RIGHT(CONCAT('0',a.Kd_Rek_5),2)) AS kode,
                                        a.no_bukti,
                                        a.tgl_bukti,
                                        d.nm_potongan,
                                        (c.nilai) AS nilai
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                                SELECT 
                                                a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                                FROM ta_rkas_history a 
                                                WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                                AND IFNULL(a.kd_penerimaan_1, '') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                                GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        INNER JOIN
                                        ta_spj_pot c ON a.tahun = c.tahun AND a.sekolah_id = c.sekolah_id AND a.no_bukti = c.no_bukti
                                        INNER JOIN ref_potongan d ON c.kd_potongan =  d.kd_potongan
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.Kd_Rek_1 = 5 AND a.pembayaran = 2
                                        
                                        /* Setoran Pajak Transaksi */
                                        UNION ALL
                                        SELECT a.tahun, a.sekolah_id, '' AS kd_penerimaan_1, '' AS kd_penerimaan_2,
                                        b.kd_potongan, CONCAT(a.no_setoran, '-',b.kd_potongan) AS no_bukti, a.tgl_setoran, b.keterangan,
                                        -(b.nilai) AS nilai
                                        FROM ta_setoran_potongan a
                                        INNER JOIN ta_setoran_potongan_rinc b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.no_setoran = b.no_setoran
                                        INNER JOIN ref_potongan c ON b.kd_potongan = c.kd_potongan
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id
                                        AND a.tgl_setoran <= :tgl_2 AND a.tgl_setoran >= :tgl_1 AND b.pembayaran = 2                                        
                            ) a ORDER BY tgl_bukti, no_bukti ASC    
                            ", [
                                ':tahun' => $Tahun,
                                ':sekolah_id' => Yii::$app->user->identity->sekolah_id,
                                ':perubahan_id' => $getparam['Laporan']['perubahan_id'],
                                ':kd_penerimaan_1' => $kd_penerimaan_1,
                                ':kd_penerimaan_2' => $kd_penerimaan_2,
                                ':tgl_1' => $getparam['Laporan']['Tgl_1'],
                                ':tgl_2' => $getparam['Laporan']['Tgl_2'],
                            ])->queryScalar();

                        $data = new SqlDataProvider([
                            'sql' => "
                                    SELECT * FROM
                                    (
                                        /*SALDO AWAL */
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_penerimaan_1, a.kd_penerimaan_2, '' AS kode, '' AS no_bukti, '$Tahun-01-01' AS tgl_bukti, 'Saldo Awal' AS keterangan, SUM(a.nilai) AS nilai
                                        FROM
                                        ta_saldo_awal a
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND IFNULL(a.kd_penerimaan_1, '') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.pembayaran = 2
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        /*Saldo Awal sejak tanggal */
                                        UNION ALL
                                        SELECT
                                        a.tahun,
                                        a.sekolah_id,
                                        '' AS kd_penerimaan_1,
                                        '' AS kd_penerimaan_2,
                                        '' AS kode, 
                                        '' AS no_bukti,
                                        :tgl_1 AS tgl_bukti,
                                        'Akumulasi Transaksi' AS uraian,
                                        SUM(a.nilai) AS nilai
                                        FROM
                                        (                                        
                                            SELECT
                                            a.tahun,
                                            a.sekolah_id,
                                            '' AS kd_penerimaan_1,
                                            '' AS kd_penerimaan_2,
                                            '' AS kode, 
                                            '' AS no_bukti,
                                            :tgl_1 AS tgl_bukti,
                                            'Akumulasi Transaksi' AS uraian,
                                            SUM(
                                            CASE a.Kd_Rek_1
                                                WHEN 4 THEN a.nilai
                                                WHEN 5 THEN -(a.nilai)
                                            END
                                            ) AS nilai
                                            FROM
                                            ta_spj_rinc AS a
                                            LEFT JOIN
                                            (
                                                SELECT 
                                                a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                                FROM ta_rkas_history a 
                                                WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                                AND IFNULL(a.kd_penerimaan_1, '') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                                GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                            AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti < :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.pembayaran = 2
                                            GROUP BY a.tahun, a.sekolah_id
                                            UNION ALL
                                            SELECT a.tahun, a.sekolah_id, '' AS kd_penerimaan_1, '' AS kd_penerimaan_2, '' AS kode, '' AS no_bukti, '' AS tgl_bukti, '' AS uraian,
                                            SUM(CASE a.kd_mutasi
                                                WHEN 1 THEN a.nilai
                                                WHEN 2 THEN -(a.nilai)
                                            END) AS nilai
                                            FROM ta_mutasi_kas a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti < :tgl_1
                                            GROUP BY a.tahun, a.sekolah_id
                                            /*Potongan */
                                            UNION ALL
                                            SELECT
                                            a.tahun,
                                            a.sekolah_id,
                                            '' AS kd_penerimaan_1,
                                            '' AS kd_penerimaan_2,
                                            '' AS kode, 
                                            '' AS no_bukti,
                                            :tgl_1 AS tgl_bukti,
                                            'Akumulasi Transaksi' AS uraian,
                                            SUM(c.nilai) AS nilai
                                            FROM
                                            ta_spj_rinc AS a
                                            LEFT JOIN
                                            (
                                                    SELECT 
                                                    a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                                    FROM ta_rkas_history a 
                                                    WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                                    AND IFNULL(a.kd_penerimaan_1, '') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                                    GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                            AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                            INNER JOIN
                                            ta_spj_pot c ON a.tahun = c.tahun AND a.sekolah_id = c.sekolah_id AND a.no_bukti = c.no_bukti
                                            INNER JOIN ref_potongan d ON c.kd_potongan =  d.kd_potongan
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <  :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2  AND a.Kd_Rek_1 = 5 AND a.pembayaran = 2
                                            GROUP BY a.tahun, a.sekolah_id

                                            /*Setoran Potongan */
                                            UNION ALL
                                            SELECT
                                            a.tahun,
                                            a.sekolah_id,
                                            '' AS kd_penerimaan_1,
                                            '' AS kd_penerimaan_2,
                                            '' AS kode, 
                                            '' AS no_bukti,
                                            '2016-01-01' AS tgl_bukti,
                                            'Akumulasi Transaksi' AS uraian,
                                            SUM(-(b.nilai)) AS nilai
                                            FROM ta_setoran_potongan a
                                            INNER JOIN ta_setoran_potongan_rinc b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.no_setoran = b.no_setoran
                                            INNER JOIN ref_potongan c ON b.kd_potongan = c.kd_potongan
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id
                                            AND a.tgl_setoran < :tgl_1 AND b.pembayaran = 2
                                            GROUP BY a.tahun, a.sekolah_id                                            
                                        ) a GROUP BY a.tahun, a.sekolah_id  
                                        /*Transaksi */
                                        UNION ALL
                                        SELECT
                                        a.tahun,
                                        a.sekolah_id,
                                        b.kd_penerimaan_1,
                                        b.kd_penerimaan_2,
                                        CONCAT(a.kd_program, RIGHT(CONCAT('0',a.kd_sub_program),2), RIGHT(CONCAT('0',a.kd_kegiatan),2), '.', a.Kd_Rek_3, RIGHT(CONCAT('0',a.Kd_Rek_4),2), RIGHT(CONCAT('0',a.Kd_Rek_5),2)) AS kode,
                                        a.no_bukti,
                                        a.tgl_bukti,
                                        a.uraian,
                                        CASE a.Kd_Rek_1
                                            WHEN 4 THEN a.nilai
                                            WHEN 5 THEN -(a.nilai)
                                        END
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                            SELECT 
                                            a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            FROM ta_rkas_history a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                            AND IFNULL(a.kd_penerimaan_1, '') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                            GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2  AND a.pembayaran = 2
                                        /*Mutasi Kas*/
                                        UNION ALL
                                        SELECT a.tahun, a.sekolah_id, '' AS kd_penerimaan_1, '' AS kd_penerimaan_2, '' AS kode, a.no_bukti, a.tgl_bukti, a.uraian,
                                        CASE a.kd_mutasi
                                            WHEN 1 THEN a.nilai
                                            WHEN 2 THEN -(a.nilai)
                                        END 
                                        FROM ta_mutasi_kas a 
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 
                                        /*Potongan Pajak Transaksi */
                                        UNION ALL
                                        SELECT
                                        a.tahun,
                                        a.sekolah_id,
                                        b.kd_penerimaan_1,
                                        b.kd_penerimaan_2,
                                        CONCAT(a.kd_program, RIGHT(CONCAT('0',a.kd_sub_program),2), RIGHT(CONCAT('0',a.kd_kegiatan),2), '.', a.Kd_Rek_3, RIGHT(CONCAT('0',a.Kd_Rek_4),2), RIGHT(CONCAT('0',a.Kd_Rek_5),2)) AS kode,
                                        a.no_bukti,
                                        a.tgl_bukti,
                                        d.nm_potongan,
                                        (c.nilai) AS nilai
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                                SELECT 
                                                a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                                FROM ta_rkas_history a 
                                                WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                                AND IFNULL(a.kd_penerimaan_1, '') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                                GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        INNER JOIN
                                        ta_spj_pot c ON a.tahun = c.tahun AND a.sekolah_id = c.sekolah_id AND a.no_bukti = c.no_bukti
                                        INNER JOIN ref_potongan d ON c.kd_potongan =  d.kd_potongan
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.Kd_Rek_1 = 5 AND a.pembayaran = 2
                                        
                                        /* Setoran Pajak Transaksi */
                                        UNION ALL
                                        SELECT a.tahun, a.sekolah_id, '' AS kd_penerimaan_1, '' AS kd_penerimaan_2,
                                        b.kd_potongan, CONCAT(a.no_setoran, '-',b.kd_potongan) AS no_bukti, a.tgl_setoran, b.keterangan,
                                        -(b.nilai) AS nilai
                                        FROM ta_setoran_potongan a
                                        INNER JOIN ta_setoran_potongan_rinc b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.no_setoran = b.no_setoran
                                        INNER JOIN ref_potongan c ON b.kd_potongan = c.kd_potongan
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id
                                        AND a.tgl_setoran <= :tgl_2 AND a.tgl_setoran >= :tgl_1 AND b.pembayaran = 2

                                    ) a ORDER BY tgl_bukti, no_bukti ASC
                                    ",
                            'params' => [
                                ':tahun' => $Tahun,
                                ':sekolah_id' => Yii::$app->user->identity->sekolah_id,
                                ':perubahan_id' => $getparam['Laporan']['perubahan_id'],
                                ':kd_penerimaan_1' => $kd_penerimaan_1,
                                ':kd_penerimaan_2' => $kd_penerimaan_2,
                                ':tgl_1' => $getparam['Laporan']['Tgl_1'],
                                ':tgl_2' => $getparam['Laporan']['Tgl_2'],
                            ],
                            'totalCount' => $totalCount,
                            //'sort' =>false, to remove the table header sorting
                            'pagination' => [
                                'pageSize' => 50,
                            ],
                        ]);                                  
                        $render = 'laporan3';
                        break;  
                    case 5:
                        $totalCount = Yii::$app->db->createCommand("
                            SELECT COUNT(a.tahun) FROM
                            (
                                        /*SALDO AWAL */
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_penerimaan_1, a.kd_penerimaan_2, '' AS kode, '' AS no_bukti, '$Tahun-01-01' AS tgl_bukti, 'Saldo Awal' AS keterangan, SUM(a.nilai) AS nilai
                                        FROM
                                        ta_saldo_awal a
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND IFNULL(a.kd_penerimaan_1, '') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.pembayaran = 1
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        /*Saldo Awal sejak tanggal */
                                        UNION ALL
                                        SELECT
                                        a.tahun,
                                        a.sekolah_id,
                                        '' AS kd_penerimaan_1,
                                        '' AS kd_penerimaan_2,
                                        '' AS kode, 
                                        '' AS no_bukti,
                                        '2016-01-01' AS tgl_bukti,
                                        'Akumulasi Transaksi' AS uraian,
                                        SUM(
                                        CASE a.Kd_Rek_1
                                            WHEN 4 THEN a.nilai
                                            WHEN 5 THEN -(a.nilai)
                                        END
                                        ) AS nilai
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                            SELECT 
                                            a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            FROM ta_rkas_history a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                            AND IFNULL(a.kd_penerimaan_1, '') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                            GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti < :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.pembayaran = 1
                                        GROUP BY a.tahun, a.sekolah_id
                                        /*Transaksi */
                                        UNION ALL
                                        SELECT
                                        a.tahun,
                                        a.sekolah_id,
                                        b.kd_penerimaan_1,
                                        b.kd_penerimaan_2,
                                        CONCAT(a.kd_program, RIGHT(CONCAT('0',a.kd_sub_program),2), RIGHT(CONCAT('0',a.kd_kegiatan),2), '.', a.Kd_Rek_3, RIGHT(CONCAT('0',a.Kd_Rek_4),2), RIGHT(CONCAT('0',a.Kd_Rek_5),2)) AS kode,
                                        a.no_bukti,
                                        a.tgl_bukti,
                                        a.uraian,
                                        CASE a.Kd_Rek_1
                                            WHEN 4 THEN a.nilai
                                            WHEN 5 THEN -(a.nilai)
                                        END
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                            SELECT 
                                            a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            FROM ta_rkas_history a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                            AND IFNULL(a.kd_penerimaan_1, '') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                            GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2  AND a.pembayaran = 1
                                        /*Mutasi Kas*/
                                        UNION ALL
                                        SELECT a.tahun, a.sekolah_id, '' AS kd_penerimaan_1, '' AS kd_penerimaan_2, '' AS kode, a.no_bukti, a.tgl_bukti, a.uraian,
                                        CASE a.kd_mutasi
                                            WHEN 2 THEN a.nilai
                                            WHEN 1 THEN -(a.nilai)
                                        END 
                                        FROM ta_mutasi_kas a 
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 
                                        /*Potongan Pajak Transaksi */
                                        UNION ALL
                                        SELECT
                                        a.tahun,
                                        a.sekolah_id,
                                        b.kd_penerimaan_1,
                                        b.kd_penerimaan_2,
                                        CONCAT(a.kd_program, RIGHT(CONCAT('0',a.kd_sub_program),2), RIGHT(CONCAT('0',a.kd_kegiatan),2), '.', a.Kd_Rek_3, RIGHT(CONCAT('0',a.Kd_Rek_4),2), RIGHT(CONCAT('0',a.Kd_Rek_5),2)) AS kode,
                                        a.no_bukti,
                                        a.tgl_bukti,
                                        d.nm_potongan,
                                        (c.nilai) AS nilai
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                                SELECT 
                                                a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                                FROM ta_rkas_history a 
                                                WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                                AND IFNULL(a.kd_penerimaan_1, '') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                                GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        INNER JOIN
                                        ta_spj_pot c ON a.tahun = c.tahun AND a.sekolah_id = c.sekolah_id AND a.no_bukti = c.no_bukti
                                        INNER JOIN ref_potongan d ON c.kd_potongan =  d.kd_potongan
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.Kd_Rek_1 = 5 AND a.pembayaran = 1
                                        
                                        /* Setoran Pajak Transaksi */
                                        UNION ALL
                                        SELECT a.tahun, a.sekolah_id, '' AS kd_penerimaan_1, '' AS kd_penerimaan_2,
                                        b.kd_potongan, CONCAT(a.no_setoran, '-',b.kd_potongan) AS no_bukti, a.tgl_setoran, b.keterangan,
                                        -(b.nilai) AS nilai
                                        FROM ta_setoran_potongan a
                                        INNER JOIN ta_setoran_potongan_rinc b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.no_setoran = b.no_setoran
                                        INNER JOIN ref_potongan c ON b.kd_potongan = c.kd_potongan
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id
                                        AND a.tgl_setoran <= :tgl_2 AND a.tgl_setoran >= :tgl_1 AND b.pembayaran = 1                                        
                            ) a ORDER BY tgl_bukti, no_bukti ASC    
                            ", [
                                ':tahun' => $Tahun,
                                ':sekolah_id' => Yii::$app->user->identity->sekolah_id,
                                ':perubahan_id' => $getparam['Laporan']['perubahan_id'],
                                ':kd_penerimaan_1' => $kd_penerimaan_1,
                                ':kd_penerimaan_2' => $kd_penerimaan_2,
                                ':tgl_1' => $getparam['Laporan']['Tgl_1'],
                                ':tgl_2' => $getparam['Laporan']['Tgl_2'],
                            ])->queryScalar();

                        $data = new SqlDataProvider([
                            'sql' => "
                                    SELECT * FROM
                                    (
                                        /*SALDO AWAL */
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_penerimaan_1, a.kd_penerimaan_2, '' AS kode, '' AS no_bukti, '$Tahun-01-01' AS tgl_bukti, 'Saldo Awal' AS keterangan, SUM(a.nilai) AS nilai
                                        FROM
                                        ta_saldo_awal a
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND IFNULL(a.kd_penerimaan_1, '') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.pembayaran = 1
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        /*Saldo Awal sejak tanggal */
                                        UNION ALL
                                        SELECT
                                        a.tahun,
                                        a.sekolah_id,
                                        '' AS kd_penerimaan_1,
                                        '' AS kd_penerimaan_2,
                                        '' AS kode, 
                                        '' AS no_bukti,
                                        :tgl_1 AS tgl_bukti,
                                        'Akumulasi Transaksi' AS uraian,
                                        SUM(a.nilai) AS nilai
                                        FROM
                                        (                                        
                                            SELECT
                                            a.tahun,
                                            a.sekolah_id,
                                            '' AS kd_penerimaan_1,
                                            '' AS kd_penerimaan_2,
                                            '' AS kode, 
                                            '' AS no_bukti,
                                            :tgl_1 AS tgl_bukti,
                                            'Akumulasi Transaksi' AS uraian,
                                            SUM(
                                            CASE a.Kd_Rek_1
                                                WHEN 4 THEN a.nilai
                                                WHEN 5 THEN -(a.nilai)
                                            END
                                            ) AS nilai
                                            FROM
                                            ta_spj_rinc AS a
                                            LEFT JOIN
                                            (
                                                SELECT 
                                                a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                                FROM ta_rkas_history a 
                                                WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                                AND IFNULL(a.kd_penerimaan_1, '') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                                GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                            AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti < :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.pembayaran = 1
                                            GROUP BY a.tahun, a.sekolah_id
                                            UNION ALL
                                            SELECT a.tahun, a.sekolah_id, '' AS kd_penerimaan_1, '' AS kd_penerimaan_2, '' AS kode, '' AS no_bukti, '' AS tgl_bukti, '' AS uraian,
                                            SUM(CASE a.kd_mutasi
                                                WHEN 2 THEN a.nilai
                                                WHEN 1 THEN -(a.nilai)
                                            END) AS nilai
                                            FROM ta_mutasi_kas a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti < :tgl_1
                                            GROUP BY a.tahun, a.sekolah_id
                                            /*Potongan */
                                            UNION ALL
                                            SELECT
                                            a.tahun,
                                            a.sekolah_id,
                                            '' AS kd_penerimaan_1,
                                            '' AS kd_penerimaan_2,
                                            '' AS kode, 
                                            '' AS no_bukti,
                                            :tgl_1 AS tgl_bukti,
                                            'Akumulasi Transaksi' AS uraian,
                                            SUM(c.nilai) AS nilai
                                            FROM
                                            ta_spj_rinc AS a
                                            LEFT JOIN
                                            (
                                                    SELECT 
                                                    a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                                    FROM ta_rkas_history a 
                                                    WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                                    AND IFNULL(a.kd_penerimaan_1, '') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                                    GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                            AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                            INNER JOIN
                                            ta_spj_pot c ON a.tahun = c.tahun AND a.sekolah_id = c.sekolah_id AND a.no_bukti = c.no_bukti
                                            INNER JOIN ref_potongan d ON c.kd_potongan =  d.kd_potongan
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <  :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2  AND a.Kd_Rek_1 = 5 AND a.pembayaran = 1
                                            GROUP BY a.tahun, a.sekolah_id

                                            /*Setoran Potongan */
                                            UNION ALL
                                            SELECT
                                            a.tahun,
                                            a.sekolah_id,
                                            '' AS kd_penerimaan_1,
                                            '' AS kd_penerimaan_2,
                                            '' AS kode, 
                                            '' AS no_bukti,
                                            '2016-01-01' AS tgl_bukti,
                                            'Akumulasi Transaksi' AS uraian,
                                            SUM(-(b.nilai)) AS nilai
                                            FROM ta_setoran_potongan a
                                            INNER JOIN ta_setoran_potongan_rinc b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.no_setoran = b.no_setoran
                                            INNER JOIN ref_potongan c ON b.kd_potongan = c.kd_potongan
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id
                                            AND a.tgl_setoran < :tgl_1 AND b.pembayaran = 1
                                            GROUP BY a.tahun, a.sekolah_id                                               
                                        ) a GROUP BY a.tahun, a.sekolah_id
                                        /*Transaksi */
                                        UNION ALL
                                        SELECT
                                        a.tahun,
                                        a.sekolah_id,
                                        b.kd_penerimaan_1,
                                        b.kd_penerimaan_2,
                                        CONCAT(a.kd_program, RIGHT(CONCAT('0',a.kd_sub_program),2), RIGHT(CONCAT('0',a.kd_kegiatan),2), '.', a.Kd_Rek_3, RIGHT(CONCAT('0',a.Kd_Rek_4),2), RIGHT(CONCAT('0',a.Kd_Rek_5),2)) AS kode,
                                        a.no_bukti,
                                        a.tgl_bukti,
                                        a.uraian,
                                        CASE a.Kd_Rek_1
                                            WHEN 4 THEN a.nilai
                                            WHEN 5 THEN -(a.nilai)
                                        END
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                            SELECT 
                                            a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            FROM ta_rkas_history a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                            AND IFNULL(a.kd_penerimaan_1, '') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                            GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2  AND a.pembayaran = 1
                                        /*Mutasi Kas*/
                                        UNION ALL
                                        SELECT a.tahun, a.sekolah_id, '' AS kd_penerimaan_1, '' AS kd_penerimaan_2, '' AS kode, a.no_bukti, a.tgl_bukti, a.uraian,
                                        CASE a.kd_mutasi
                                            WHEN 2 THEN a.nilai
                                            WHEN 1 THEN -(a.nilai)
                                        END 
                                        FROM ta_mutasi_kas a 
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 
                                        /*Potongan Pajak Transaksi */
                                        UNION ALL
                                        SELECT
                                        a.tahun,
                                        a.sekolah_id,
                                        b.kd_penerimaan_1,
                                        b.kd_penerimaan_2,
                                        CONCAT(a.kd_program, RIGHT(CONCAT('0',a.kd_sub_program),2), RIGHT(CONCAT('0',a.kd_kegiatan),2), '.', a.Kd_Rek_3, RIGHT(CONCAT('0',a.Kd_Rek_4),2), RIGHT(CONCAT('0',a.Kd_Rek_5),2)) AS kode,
                                        a.no_bukti,
                                        a.tgl_bukti,
                                        d.nm_potongan,
                                        (c.nilai) AS nilai
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                                SELECT 
                                                a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                                FROM ta_rkas_history a 
                                                WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                                AND IFNULL(a.kd_penerimaan_1, '') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                                GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        INNER JOIN
                                        ta_spj_pot c ON a.tahun = c.tahun AND a.sekolah_id = c.sekolah_id AND a.no_bukti = c.no_bukti
                                        INNER JOIN ref_potongan d ON c.kd_potongan =  d.kd_potongan
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.Kd_Rek_1 = 5 AND a.pembayaran = 1
                                        
                                        /* Setoran Pajak Transaksi */
                                        UNION ALL
                                        SELECT a.tahun, a.sekolah_id, '' AS kd_penerimaan_1, '' AS kd_penerimaan_2,
                                        b.kd_potongan, CONCAT(a.no_setoran, '-',b.kd_potongan) AS no_bukti, a.tgl_setoran, b.keterangan,
                                        -(b.nilai) AS nilai
                                        FROM ta_setoran_potongan a
                                        INNER JOIN ta_setoran_potongan_rinc b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.no_setoran = b.no_setoran
                                        INNER JOIN ref_potongan c ON b.kd_potongan = c.kd_potongan
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id
                                        AND a.tgl_setoran <= :tgl_2 AND a.tgl_setoran >= :tgl_1 AND b.pembayaran = 1                                        
                                    ) a ORDER BY tgl_bukti, no_bukti ASC
                                    ",
                            'params' => [
                                ':tahun' => $Tahun,
                                ':sekolah_id' => Yii::$app->user->identity->sekolah_id,
                                ':perubahan_id' => $getparam['Laporan']['perubahan_id'],
                                ':kd_penerimaan_1' => $kd_penerimaan_1,
                                ':kd_penerimaan_2' => $kd_penerimaan_2,
                                ':tgl_1' => $getparam['Laporan']['Tgl_1'],
                                ':tgl_2' => $getparam['Laporan']['Tgl_2'],
                            ],
                            'totalCount' => $totalCount,
                            //'sort' =>false, to remove the table header sorting
                            'pagination' => [
                                'pageSize' => 50,
                            ],
                        ]);                                  
                        $render = 'laporan3';
                        break;                                                                                         
                    case 6:
                        $totalCount = Yii::$app->db->createCommand("
                            SELECT COUNT(a.tahun) FROM
                            (   
                                SELECT
                                a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, SUM(a.total) AS anggaran
                                FROM
                                ta_rkas_history a
                                WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = :perubahan_id
                                AND IFNULL(a.kd_penerimaan_1, '') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1
                            ) a
                            ", [
                                ':tahun' => $Tahun,
                                ':sekolah_id' => Yii::$app->user->identity->sekolah_id,
                                ':perubahan_id' => $getparam['Laporan']['perubahan_id'],
                                ':kd_penerimaan_1' => $kd_penerimaan_1,
                                ':kd_penerimaan_2' => $kd_penerimaan_2,
                            ])->queryScalar();

                        $data = new SqlDataProvider([
                            'sql' => "

                                    SELECT a.tahun, a.sekolah_id, a.kd_program, c.uraian_program, a.kd_sub_program, d.uraian_sub_program, a.kd_kegiatan, e.uraian_kegiatan, a.Kd_Rek_1, a.anggaran,
                                    IFNULL(f.nilai,0) AS rutin, IFNULL(g.nilai,0) AS bos_pusat, IFNULL(j.nilai,0) AS bos_provinsi, IFNULL(k.nilai,0) AS bos_lain, IFNULL(h.nilai,0) AS bantuan, IFNULL(i.nilai,0) AS lain
                                    FROM
                                    (
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, SUM(a.total) AS anggaran
                                        FROM
                                        ta_rkas_history a
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = :perubahan_id
                                        AND IFNULL(a.kd_penerimaan_1, '') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1
                                    ) a 
                                    -- Untuk realisasi Rutin 2
                                    LEFT JOIN
                                    (
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, SUM(a.nilai) AS nilai
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                            SELECT 
                                            a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            FROM ta_rkas_history a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                            AND a.kd_penerimaan_1 = 2
                                            GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND b.kd_penerimaan_1 = 2
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1
                                    ) f ON a.tahun = f.tahun AND a.sekolah_id = f.sekolah_id AND a.kd_program = f.kd_program AND a.kd_sub_program = f.kd_sub_program AND a.kd_kegiatan = f.kd_kegiatan AND a.Kd_Rek_1 = f.Kd_Rek_1
                                    -- Untuk realisasi BOS pusat 3-1
                                    LEFT JOIN
                                    (
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, SUM(a.nilai) AS nilai
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                            SELECT 
                                            a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            FROM ta_rkas_history a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                            AND a.kd_penerimaan_1 = 3 AND a.kd_penerimaan_2 = 1
                                            GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND b.kd_penerimaan_1 = 3 AND b.kd_penerimaan_2 = 1
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1
                                    ) g ON a.tahun = g.tahun AND a.sekolah_id = g.sekolah_id AND a.kd_program = g.kd_program AND a.kd_sub_program = g.kd_sub_program AND a.kd_kegiatan = g.kd_kegiatan AND a.Kd_Rek_1 = g.Kd_Rek_1
                                    -- Untuk realisasi bantuan 4
                                    LEFT JOIN
                                    (
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, SUM(a.nilai) AS nilai
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                            SELECT 
                                            a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            FROM ta_rkas_history a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                            AND a.kd_penerimaan_1 = 4
                                            GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND b.kd_penerimaan_1 = 4
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1
                                    ) h ON a.tahun = h.tahun AND a.sekolah_id = h.sekolah_id AND a.kd_program = h.kd_program AND a.kd_sub_program = h.kd_sub_program AND a.kd_kegiatan = h.kd_kegiatan AND a.Kd_Rek_1 = h.Kd_Rek_1
                                    -- untuk realisasi sumber lainnya 5
                                    LEFT JOIN
                                    (
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, SUM(a.nilai) AS nilai
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                            SELECT 
                                            a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            FROM ta_rkas_history a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                            AND a.kd_penerimaan_1 NOT IN (1,2,3,4)
                                            GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND b.kd_penerimaan_1 NOT IN (1,2,3,4)
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1
                                    ) i ON a.tahun = i.tahun AND a.sekolah_id = i.sekolah_id AND a.kd_program = i.kd_program AND a.kd_sub_program = i.kd_sub_program AND a.kd_kegiatan = i.kd_kegiatan AND a.Kd_Rek_1 = i.Kd_Rek_1
                                    -- Untuk realisasi BOS provinsi 3-2
                                    LEFT JOIN
                                    (
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, SUM(a.nilai) AS nilai
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                            SELECT 
                                            a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            FROM ta_rkas_history a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                            AND a.kd_penerimaan_1 = 3 AND a.kd_penerimaan_2 = 2
                                            GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND b.kd_penerimaan_1 = 3 AND b.kd_penerimaan_2 = 2
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1
                                    ) j ON a.tahun = j.tahun AND a.sekolah_id = j.sekolah_id AND a.kd_program = j.kd_program AND a.kd_sub_program = j.kd_sub_program AND a.kd_kegiatan = j.kd_kegiatan AND a.Kd_Rek_1 = j.Kd_Rek_1
                                    -- Untuk realisasi BOS kab/kota 3-x
                                    LEFT JOIN
                                    (
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, SUM(a.nilai) AS nilai
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                            SELECT 
                                            a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            FROM ta_rkas_history a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                            AND a.kd_penerimaan_1 = 3 AND a.kd_penerimaan_2 > 2
                                            GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND b.kd_penerimaan_1 = 3 AND b.kd_penerimaan_2 > 2
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1
                                    ) k ON a.tahun = k.tahun AND a.sekolah_id = k.sekolah_id AND a.kd_program = k.kd_program AND a.kd_sub_program = k.kd_sub_program AND a.kd_kegiatan = k.kd_kegiatan AND a.Kd_Rek_1 = k.Kd_Rek_1
                                    LEFT JOIN ref_program_sekolah c ON a.kd_program = c.kd_program
                                    LEFT JOIN ref_sub_program_sekolah d ON a.kd_program = d.kd_program AND a.kd_sub_program = d.kd_sub_program
                                    LEFT JOIN ref_kegiatan_sekolah e ON a.kd_program = e.kd_program AND a.kd_sub_program = e.kd_sub_program AND a.kd_kegiatan = e.kd_kegiatan
                                    ORDER BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1 ASC;

                                    ",
                            'params' => [
                                ':tahun' => $Tahun,
                                ':sekolah_id' => Yii::$app->user->identity->sekolah_id,
                                ':perubahan_id' => $getparam['Laporan']['perubahan_id'],
                                ':kd_penerimaan_1' => $kd_penerimaan_1,
                                ':kd_penerimaan_2' => $kd_penerimaan_2,
                                ':tgl_1' => $getparam['Laporan']['Tgl_1'],
                                ':tgl_2' => $getparam['Laporan']['Tgl_2'],
                            ],
                            'totalCount' => $totalCount,
                            //'sort' =>false, to remove the table header sorting
                            'pagination' => [
                                'pageSize' => 50,
                            ],
                        ]);   

                        $render = 'laporan6';
                        break;   
                    case 7:
                        $totalCount = Yii::$app->db->createCommand("
                            SELECT COUNT(a.tahun) FROM(
                                SELECT
                                a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1, SUM(a.total) AS anggaran
                                FROM
                                ta_rkas_history a
                                WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = :perubahan_id
                                AND IFNULL(a.kd_penerimaan_1, '') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.Kd_Rek_1 = 5
                                GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1
                            ) a
                            ", [
                                ':tahun' => $Tahun,
                                ':sekolah_id' => Yii::$app->user->identity->sekolah_id,
                                ':perubahan_id' => $getparam['Laporan']['perubahan_id'],
                                ':kd_penerimaan_1' => $kd_penerimaan_1,
                                ':kd_penerimaan_2' => $kd_penerimaan_2,
                            ])->queryScalar();

                        $data = new SqlDataProvider([
                            'sql' => "
                                    SELECT a.tahun, a.sekolah_id, a.kd_program, c.uraian_program, a.Kd_Rek_1, a.anggaran,
                                    IFNULL(d.nilai,0) AS komponen1,
                                    IFNULL(e.nilai,0) AS komponen2,
                                    IFNULL(f.nilai,0) AS komponen3,
                                    IFNULL(g.nilai,0) AS komponen4,
                                    IFNULL(h.nilai,0) AS komponen5,
                                    IFNULL(i.nilai,0) AS komponen6,
                                    IFNULL(j.nilai,0) AS komponen7,
                                    IFNULL(k.nilai,0) AS komponen8,
                                    IFNULL(l.nilai,0) AS komponen9,
                                    IFNULL(m.nilai,0) AS komponen10,
                                    IFNULL(n.nilai,0) AS komponen11,
                                    IFNULL(o.nilai,0) AS komponen12,
                                    IFNULL(p.nilai,0) AS komponen13,
                                    IFNULL(q.nilai,0) AS komponenlain
                                    FROM
                                    (
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1, SUM(a.total) AS anggaran
                                        FROM
                                        ta_rkas_history a
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = :perubahan_id
                                        AND IFNULL(a.kd_penerimaan_1, '') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.Kd_Rek_1 = 5
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1
                                    ) a
                                    -- Untuk realisasi komponen BOS 1
                                    LEFT JOIN
                                    (
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1, SUM(a.nilai) AS nilai
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                            SELECT 
                                            a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            FROM ta_rkas_history a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                            AND IFNULL(a.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.Kd_Rek_1 = 5 AND a.komponen_id = 1
                                            GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                                    AND a.Kd_Rek_1 = 5 AND a.komponen_id = 1
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1
                                    ) d ON a.tahun = d.tahun AND a.sekolah_id = d.sekolah_id AND a.kd_program = d.kd_program AND a.Kd_Rek_1 = d.Kd_Rek_1
                                    -- Untuk realisasi komponen BOS 2
                                    LEFT JOIN
                                    (
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1, SUM(a.nilai) AS nilai
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                            SELECT 
                                            a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            FROM ta_rkas_history a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                            AND IFNULL(a.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.Kd_Rek_1 = 5 AND a.komponen_id = 2
                                            GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                                    AND a.Kd_Rek_1 = 5 AND a.komponen_id = 2
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1
                                    ) e ON a.tahun = e.tahun AND a.sekolah_id = e.sekolah_id AND a.kd_program = e.kd_program AND a.Kd_Rek_1 = e.Kd_Rek_1
                                    -- Untuk realisasi komponen BOS 3
                                    LEFT JOIN
                                    (
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1, SUM(a.nilai) AS nilai
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                            SELECT 
                                            a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            FROM ta_rkas_history a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                            AND IFNULL(a.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.Kd_Rek_1 = 5 AND a.komponen_id = 3
                                            GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                                    AND a.Kd_Rek_1 = 5 AND a.komponen_id = 3
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1
                                    ) f ON a.tahun = f.tahun AND a.sekolah_id = f.sekolah_id AND a.kd_program = f.kd_program AND a.Kd_Rek_1 = f.Kd_Rek_1
                                    -- Untuk realisasi komponen BOS 4
                                    LEFT JOIN
                                    (
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1, SUM(a.nilai) AS nilai
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                            SELECT 
                                            a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            FROM ta_rkas_history a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                            AND IFNULL(a.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.Kd_Rek_1 = 5 AND a.komponen_id = 4
                                            GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                                    AND a.Kd_Rek_1 = 5 AND a.komponen_id = 4
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1
                                    ) g ON a.tahun = g.tahun AND a.sekolah_id = g.sekolah_id AND a.kd_program = g.kd_program AND a.Kd_Rek_1 = g.Kd_Rek_1
                                    -- Untuk realisasi komponen BOS 5
                                    LEFT JOIN
                                    (
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1, SUM(a.nilai) AS nilai
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                            SELECT 
                                            a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            FROM ta_rkas_history a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                            AND IFNULL(a.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.Kd_Rek_1 = 5 AND a.komponen_id = 5
                                            GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                                    AND a.Kd_Rek_1 = 5 AND a.komponen_id = 5
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1
                                    ) h ON a.tahun = h.tahun AND a.sekolah_id = h.sekolah_id AND a.kd_program = h.kd_program AND a.Kd_Rek_1 = h.Kd_Rek_1
                                    -- Untuk realisasi komponen BOS 6
                                    LEFT JOIN
                                    (
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1, SUM(a.nilai) AS nilai
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                            SELECT 
                                            a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            FROM ta_rkas_history a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                            AND IFNULL(a.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.Kd_Rek_1 = 5 AND a.komponen_id = 6
                                            GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                                    AND a.Kd_Rek_1 = 5 AND a.komponen_id = 6
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1
                                    ) i ON a.tahun = i.tahun AND a.sekolah_id = i.sekolah_id AND a.kd_program = i.kd_program AND a.Kd_Rek_1 = i.Kd_Rek_1
                                    -- Untuk realisasi komponen BOS 7
                                    LEFT JOIN
                                    (
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1, SUM(a.nilai) AS nilai
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                            SELECT 
                                            a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            FROM ta_rkas_history a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                            AND IFNULL(a.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.Kd_Rek_1 = 5 AND a.komponen_id = 7
                                            GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                                    AND a.Kd_Rek_1 = 5 AND a.komponen_id = 7
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1
                                    ) j ON a.tahun = j.tahun AND a.sekolah_id = j.sekolah_id AND a.kd_program = j.kd_program AND a.Kd_Rek_1 = j.Kd_Rek_1
                                    -- Untuk realisasi komponen BOS 8
                                    LEFT JOIN
                                    (
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1, SUM(a.nilai) AS nilai
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                            SELECT 
                                            a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            FROM ta_rkas_history a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                            AND IFNULL(a.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.Kd_Rek_1 = 5 AND a.komponen_id = 8
                                            GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                                    AND a.Kd_Rek_1 = 5 AND a.komponen_id = 8
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1
                                    ) k ON a.tahun = k.tahun AND a.sekolah_id = k.sekolah_id AND a.kd_program = k.kd_program AND a.Kd_Rek_1 = k.Kd_Rek_1
                                    -- Untuk realisasi komponen BOS 9
                                    LEFT JOIN
                                    (
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1, SUM(a.nilai) AS nilai
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                            SELECT 
                                            a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            FROM ta_rkas_history a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                            AND IFNULL(a.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.Kd_Rek_1 = 5 AND a.komponen_id = 9
                                            GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                                    AND a.Kd_Rek_1 = 5 AND a.komponen_id = 9
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1
                                    ) l ON a.tahun = l.tahun AND a.sekolah_id = l.sekolah_id AND a.kd_program = l.kd_program AND a.Kd_Rek_1 = l.Kd_Rek_1
                                    -- Untuk realisasi komponen BOS 10
                                    LEFT JOIN
                                    (
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1, SUM(a.nilai) AS nilai
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                            SELECT 
                                            a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            FROM ta_rkas_history a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                            AND IFNULL(a.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.Kd_Rek_1 = 5 AND a.komponen_id = 10
                                            GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                                    AND a.Kd_Rek_1 = 5 AND a.komponen_id = 10
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1
                                    ) m ON a.tahun = m.tahun AND a.sekolah_id = m.sekolah_id AND a.kd_program = m.kd_program AND a.Kd_Rek_1 = m.Kd_Rek_1
                                    -- Untuk realisasi komponen BOS 11
                                    LEFT JOIN
                                    (
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1, SUM(a.nilai) AS nilai
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                            SELECT 
                                            a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            FROM ta_rkas_history a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                            AND IFNULL(a.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.Kd_Rek_1 = 5 AND a.komponen_id = 11
                                            GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                                    AND a.Kd_Rek_1 = 5 AND a.komponen_id = 11
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1
                                    ) n ON a.tahun = n.tahun AND a.sekolah_id = n.sekolah_id AND a.kd_program = n.kd_program AND a.Kd_Rek_1 = n.Kd_Rek_1
                                    -- Untuk realisasi komponen BOS 12
                                    LEFT JOIN
                                    (
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1, SUM(a.nilai) AS nilai
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                            SELECT 
                                            a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            FROM ta_rkas_history a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                            AND IFNULL(a.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.Kd_Rek_1 = 5 AND a.komponen_id = 12
                                            GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                                    AND a.Kd_Rek_1 = 5 AND a.komponen_id = 12
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1
                                    ) o ON a.tahun = o.tahun AND a.sekolah_id = o.sekolah_id AND a.kd_program = o.kd_program AND a.Kd_Rek_1 = o.Kd_Rek_1
                                    -- Untuk realisasi komponen BOS 13
                                    LEFT JOIN
                                    (
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1, SUM(a.nilai) AS nilai
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                            SELECT 
                                            a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            FROM ta_rkas_history a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                            AND IFNULL(a.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.Kd_Rek_1 = 5 AND a.komponen_id = 13
                                            GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                                    AND a.Kd_Rek_1 = 5 AND a.komponen_id = 13
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1
                                    ) p ON a.tahun = p.tahun AND a.sekolah_id = p.sekolah_id AND a.kd_program = p.kd_program AND a.Kd_Rek_1 = p.Kd_Rek_1
                                    -- Untuk realisasi komponen BOS other
                                    LEFT JOIN
                                    (
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1, SUM(a.nilai) AS nilai
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                            SELECT 
                                            a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            FROM ta_rkas_history a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                            AND IFNULL(a.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.Kd_Rek_1 = 5 AND IFNULL(a.komponen_id,0) NOT IN (1,2,3,4,5,6,7,8,9,10,11,12,13)
                                            GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                                    AND a.Kd_Rek_1 = 5 AND IFNULL(a.komponen_id,0) NOT IN (1,2,3,4,5,6,7,8,9,10,11,12,13) 
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1
                                    ) q ON a.tahun = q.tahun AND a.sekolah_id = q.sekolah_id AND a.kd_program = q.kd_program AND a.Kd_Rek_1 = q.Kd_Rek_1
                                    LEFT JOIN ref_program_sekolah c ON a.kd_program = c.kd_program
                                    ORDER BY a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1 ASC;

                                    ",
                            'params' => [
                                ':tahun' => $Tahun,
                                ':sekolah_id' => Yii::$app->user->identity->sekolah_id,
                                ':perubahan_id' => $getparam['Laporan']['perubahan_id'],
                                ':kd_penerimaan_1' => $kd_penerimaan_1,
                                ':kd_penerimaan_2' => $kd_penerimaan_2,
                                ':tgl_1' => $getparam['Laporan']['Tgl_1'],
                                ':tgl_2' => $getparam['Laporan']['Tgl_2'],
                            ],
                            'totalCount' => $totalCount,
                            //'sort' =>false, to remove the table header sorting
                            'pagination' => [
                                'pageSize' => 50,
                            ],
                        ]);   

                        $render = 'laporan7';
                        break;
                    case 8:
                        $totalCount = Yii::$app->db->createCommand("
                            SELECT COUNT(a.tahun) FROM(
                                SELECT
                                a.tahun, a.sekolah_id, IFNULL(a.komponen_id, 0) AS komponen_id, IFNULL(b.komponen, 'Non-Komponen BOS') AS komponen, a.Kd_Rek_1, SUM(a.total) AS anggaran
                                FROM
                                ta_rkas_history a
                                LEFT JOIN ref_komponen_bos b ON a.komponen_id = b.id
                                WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = :perubahan_id
                                AND IFNULL(a.kd_penerimaan_1, '') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.Kd_Rek_1 = 5
                                GROUP BY a.tahun, a.sekolah_id, a.komponen_id, a.Kd_Rek_1
                            ) a
                            ", [
                                ':tahun' => $Tahun,
                                ':sekolah_id' => Yii::$app->user->identity->sekolah_id,
                                ':perubahan_id' => $getparam['Laporan']['perubahan_id'],
                                ':kd_penerimaan_1' => $kd_penerimaan_1,
                                ':kd_penerimaan_2' => $kd_penerimaan_2,
                            ])->queryScalar();

                        $data = new SqlDataProvider([
                            'sql' => "                                
                                SELECT
                                a.tahun, a.sekolah_id, IFNULL(a.komponen_id, 0) AS komponen_id, IFNULL(b.komponen, 'Non-Komponen BOS') AS komponen, a.Kd_Rek_1, SUM(a.total) AS anggaran
                                FROM
                                ta_rkas_history a
                                LEFT JOIN ref_komponen_bos b ON a.komponen_id = b.id
                                WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = :perubahan_id
                                AND IFNULL(a.kd_penerimaan_1, '') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.Kd_Rek_1 = 5
                                GROUP BY a.tahun, a.sekolah_id, a.komponen_id, a.Kd_Rek_1
                                    ",
                            'params' => [
                                ':tahun' => $Tahun,
                                ':sekolah_id' => Yii::$app->user->identity->sekolah_id,
                                ':perubahan_id' => $getparam['Laporan']['perubahan_id'],
                                ':kd_penerimaan_1' => $kd_penerimaan_1,
                                ':kd_penerimaan_2' => $kd_penerimaan_2
                            ],
                            'totalCount' => $totalCount,
                            //'sort' =>false, to remove the table header sorting
                            'pagination' => [
                                'pageSize' => 50,
                            ],
                        ]);   

                        $render = 'laporan8';
                        break;
                    case 9:
                        $totalCount = Yii::$app->db->createCommand("
                                SELECT COUNT(a.tahun) FROM
                                (
                                    #Saldo Awal
                                    SELECT a.tahun, a.sekolah_id, a.kd_potongan AS kode, '' AS no_bukti, '$Tahun-01-01' AS tgl_bukti, CONCAT('Saldo Awal ',b.nm_potongan) AS keterangan, a.nilai
                                    FROM ta_saldo_awal_potongan a
                                    INNER JOIN ref_potongan b ON a.kd_potongan = b.kd_potongan
                                    WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id
                                    #akumulasi transaksi
                                    UNION ALL
                                    SELECT a.tahun, a.sekolah_id, a.kd_potongan, '' AS no_bukti, :tgl_1, CONCAT('Saldo Akumulasi ', b.nm_potongan) AS uraian, SUM(nilai) AS nilai
                                    FROM (
                                        SELECT a.tahun, a.sekolah_id, a.kd_potongan, b.no_bukti, b.tgl_bukti, b.uraian, a.nilai
                                        FROM ta_spj_pot a
                                        INNER JOIN ta_spj_rinc b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.no_bukti = b.no_bukti
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND b.tgl_bukti <= :tgl_1
                                        UNION ALL
                                        SELECT a.tahun, a.sekolah_id, a.kd_potongan, b.no_setoran, b.tgl_setoran, a.keterangan, -(a.nilai) AS nilai
                                        FROM ta_setoran_potongan_rinc a
                                        INNER JOIN ta_setoran_potongan b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.no_setoran = b.no_setoran
                                        INNER JOIN ref_potongan c ON a.kd_potongan = c.kd_potongan
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND b.tgl_setoran <= :tgl_1
                                    ) a
                                    INNER JOIN ref_potongan b ON a.kd_potongan = b.kd_potongan
                                    GROUP BY a.tahun, a.sekolah_id, a.kd_potongan
                                    #transaksi Potongan
                                    UNION ALL
                                    SELECT a.tahun, a.sekolah_id, a.kd_potongan, b.no_bukti, b.tgl_bukti, b.uraian, a.nilai
                                    FROM ta_spj_pot a
                                    INNER JOIN ta_spj_rinc b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.no_bukti = b.no_bukti
                                    WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND b.tgl_bukti <= :tgl_2 AND b.tgl_bukti >= :tgl_1
                                    #transaksi setoran
                                    UNION ALL
                                    SELECT a.tahun, a.sekolah_id, a.kd_potongan, b.no_setoran, b.tgl_setoran, a.keterangan, -(a.nilai) AS nilai
                                    FROM ta_setoran_potongan_rinc a
                                    INNER JOIN ta_setoran_potongan b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.no_setoran = b.no_setoran
                                    INNER JOIN ref_potongan c ON a.kd_potongan = c.kd_potongan
                                    WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND b.tgl_setoran <= :tgl_2 AND b.tgl_setoran >= :tgl_1
                                ) a ORDER BY a.tgl_bukti
                            ", [
                                ':tahun' => $Tahun,
                                ':sekolah_id' => Yii::$app->user->identity->sekolah_id,
                                ':tgl_1' => $getparam['Laporan']['Tgl_1'],
                                ':tgl_2' => $getparam['Laporan']['Tgl_2'],
                            ])->queryScalar();

                        $data = new SqlDataProvider([
                            'sql' => "                                
                                SELECT * FROM
                                (
                                    #Saldo Awal
                                    SELECT a.tahun, a.sekolah_id, a.kd_potongan AS kode, '' AS no_bukti, '$Tahun-01-01' AS tgl_bukti, CONCAT('Saldo Awal ',b.nm_potongan) AS keterangan, a.nilai
                                    FROM ta_saldo_awal_potongan a
                                    INNER JOIN ref_potongan b ON a.kd_potongan = b.kd_potongan
                                    WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id
                                    #akumulasi transaksi
                                    UNION ALL
                                    SELECT a.tahun, a.sekolah_id, a.kd_potongan, '' AS no_bukti, :tgl_1, CONCAT('Saldo Akumulasi ', b.nm_potongan) AS uraian, SUM(nilai) AS nilai
                                    FROM (
                                        SELECT a.tahun, a.sekolah_id, a.kd_potongan, b.no_bukti, b.tgl_bukti, b.uraian, a.nilai
                                        FROM ta_spj_pot a
                                        INNER JOIN ta_spj_rinc b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.no_bukti = b.no_bukti
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND b.tgl_bukti <= :tgl_1
                                        UNION ALL
                                        SELECT a.tahun, a.sekolah_id, a.kd_potongan, b.no_setoran, b.tgl_setoran, a.keterangan, -(a.nilai) AS nilai
                                        FROM ta_setoran_potongan_rinc a
                                        INNER JOIN ta_setoran_potongan b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.no_setoran = b.no_setoran
                                        INNER JOIN ref_potongan c ON a.kd_potongan = c.kd_potongan
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND b.tgl_setoran <= :tgl_1
                                    ) a
                                    INNER JOIN ref_potongan b ON a.kd_potongan = b.kd_potongan
                                    GROUP BY a.tahun, a.sekolah_id, a.kd_potongan
                                    #transaksi Potongan
                                    UNION ALL
                                    SELECT a.tahun, a.sekolah_id, a.kd_potongan, b.no_bukti, b.tgl_bukti, b.uraian, a.nilai
                                    FROM ta_spj_pot a
                                    INNER JOIN ta_spj_rinc b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.no_bukti = b.no_bukti
                                    WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND b.tgl_bukti <= :tgl_2 AND b.tgl_bukti >= :tgl_1
                                    #transaksi setoran
                                    UNION ALL
                                    SELECT a.tahun, a.sekolah_id, a.kd_potongan, b.no_setoran, b.tgl_setoran, a.keterangan, -(a.nilai) AS nilai
                                    FROM ta_setoran_potongan_rinc a
                                    INNER JOIN ta_setoran_potongan b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.no_setoran = b.no_setoran
                                    INNER JOIN ref_potongan c ON a.kd_potongan = c.kd_potongan
                                    WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND b.tgl_setoran <= :tgl_2 AND b.tgl_setoran >= :tgl_1
                                ) a ORDER BY a.tgl_bukti
                                    ",
                            'params' => [
                                ':tahun' => $Tahun,
                                ':sekolah_id' => Yii::$app->user->identity->sekolah_id,
                                ':tgl_1' => $getparam['Laporan']['Tgl_1'],
                                ':tgl_2' => $getparam['Laporan']['Tgl_2'],
                            ],
                            'totalCount' => $totalCount,
                            //'sort' =>false, to remove the table header sorting
                            'pagination' => [
                                'pageSize' => 50,
                            ],
                        ]);   

                        $render = 'laporan3';
                        break;
                    case 10:
                        $totalCount = Yii::$app->db->createCommand("
                                SELECT COUNT(a.kd_program) FROM
                                (
                                    SELECT
                                    a.kd_program, b.uraian_program,
                                    a.kd_sub_program, c.uraian_sub_program,
                                    a.kd_kegiatan, d.uraian_kegiatan,
                                    a.Kd_Rek_1, j.Nm_Rek_1, a.Kd_Rek_2, e.Nm_Rek_2,
                                    a.Kd_Rek_3, f.Nm_Rek_3,
                                    a.Kd_Rek_4, g.Nm_Rek_4,
                                    a.Kd_Rek_5, h.Nm_Rek_5,
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
                                    GROUP BY a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.jml_satuan, a.satuan123, a.nilai_rp, a.keterangan
                                    ORDER BY a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5 ASC
                                ) a
                            ", [
                                ':tahun' => $Tahun,
                                ':sekolah_id' => Yii::$app->user->identity->sekolah_id,
                                ':perubahan_id' => $getparam['Laporan']['perubahan_id'],
                                ':kd_penerimaan_1' => $kd_penerimaan_1,
                                ':kd_penerimaan_2' => $kd_penerimaan_2
                            ])->queryScalar();

                        $data = new SqlDataProvider([
                            'sql' => "
                            SELECT
                            a.kd_program, b.uraian_program,
                            a.kd_sub_program, c.uraian_sub_program,
                            a.kd_kegiatan, d.uraian_kegiatan,
                            a.Kd_Rek_1, j.Nm_Rek_1, a.Kd_Rek_2, e.Nm_Rek_2,
                            a.Kd_Rek_3, f.Nm_Rek_3,
                            a.Kd_Rek_4, g.Nm_Rek_4,
                            a.Kd_Rek_5, h.Nm_Rek_5,
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
                            GROUP BY a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.jml_satuan, a.satuan123, a.nilai_rp, a.keterangan
                            ORDER BY a.Kd_Rek_1, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5 ASC                            
                                    ",
                            'params' => [
                                ':tahun' => $Tahun,
                                ':sekolah_id' => Yii::$app->user->identity->sekolah_id,
                                ':perubahan_id' => $getparam['Laporan']['perubahan_id'],
                                ':kd_penerimaan_1' => $kd_penerimaan_1,
                                ':kd_penerimaan_2' => $kd_penerimaan_2
                            ],
                            'totalCount' => $totalCount,
                            //'sort' =>false, to remove the table header sorting
                            'pagination' => [
                                'pageSize' => 50,
                            ],
                        ]);  

                        $render = 'laporan10';                              
                    default:
                        # code...
                        break;
                }
            }

        }

        return $this->render('index', [
            'get' => $get,
            'Kd_Laporan' => $Kd_Laporan,
            'data' => $data,
            'data1' => $data1,
            'data2' => $data2,
            'data3' => $data3,
            'data4' => $data4,
            'data5' => $data5,
            'data6' => $data6,
            'render' => $render,
            'getparam' => $getparam,
            'Tahun' => $Tahun,
        ]);
    }


//dari index kita cetak. Code below
//---------------------------------------------------------------------------------------------------------------------------------------------------
    public function actionCetak()
    {
        IF($this->cekakses() !== true){
            Yii::$app->getSession()->setFlash('warning',  'Anda tidak memiliki hak akses');
            return $this->redirect(Yii::$app->request->referrer);
        }    
        IF(Yii::$app->session->get('tahun'))
        {
            $Tahun = Yii::$app->session->get('tahun');
        }ELSE{
            $Tahun = DATE('Y');
        }

        $get = new \app\models\Laporan();
        $Kd_Laporan = NULL;
        $data = NULL;
        $data1 = NULL;
        $data2 = NULL;
        $data3 = NULL;
        $data4 = NULL;
        $data5 = NULL;
        $data6 = NULL;
        $render = NULL;
        $getparam = NULL;
        IF(Yii::$app->request->queryParams){
            $getparam = Yii::$app->request->queryParams;
            IF($getparam['Laporan']['Kd_Sumber'] <> NULL){
                list($kd_penerimaan_1, $kd_penerimaan_2) = explode('.', $getparam['Laporan']['Kd_Sumber']);
                IF($kd_penerimaan_1 == 0) $kd_penerimaan_1 = '%';
                IF($kd_penerimaan_2 == 0) $kd_penerimaan_2 = '%';
                $footerSumberDana = \app\models\RefPenerimaanSekolah2::find()->where(['kd_penerimaan_1' => $kd_penerimaan_1, 'kd_penerimaan_2' => $kd_penerimaan_2])->one();
            }
            IF($getparam['Laporan']['Kd_Laporan']){
                $Kd_Laporan = Yii::$app->request->queryParams['Laporan']['Kd_Laporan'];
                switch ($Kd_Laporan) {
                    case 1:
                        $data1 = \app\models\TaSaldoAwal::find()->where([
                            'tahun' => $Tahun,
                            'sekolah_id' => Yii::$app->user->identity->sekolah_id,
                            ])->andWhere("IFNULL(kd_penerimaan_1,'') LIKE '$kd_penerimaan_1' AND IFNULL(kd_penerimaan_2,'') LIKE '$kd_penerimaan_2'");
                        $data2 = \app\models\TaRkasHistory::find()->where([
                            'tahun' => $Tahun,
                            'perubahan_id' => $getparam['Laporan']['perubahan_id'],
                            'sekolah_id' => Yii::$app->user->identity->sekolah_id,
                            'Kd_Rek_1' => 4,
                            ])->andWhere("IFNULL(kd_penerimaan_1,'') LIKE '$kd_penerimaan_1' AND IFNULL(kd_penerimaan_2,'') LIKE '$kd_penerimaan_2'");
                        $data3 = \app\models\TaRkasHistory::find()->where([
                            'tahun' => $Tahun,
                            'perubahan_id' => $getparam['Laporan']['perubahan_id'],
                            'sekolah_id' => Yii::$app->user->identity->sekolah_id,
                            'Kd_Rek_1' => 4,
                            ])->andWhere("IFNULL(kd_penerimaan_1,'') LIKE '$kd_penerimaan_1' AND IFNULL(kd_penerimaan_2,'') LIKE '$kd_penerimaan_2'");
                        $data5 = \app\models\TaRkasHistory::find()->where([
                            'tahun' => $Tahun,
                            'perubahan_id' => $getparam['Laporan']['perubahan_id'],
                            'sekolah_id' => Yii::$app->user->identity->sekolah_id,
                            'Kd_Rek_1' => 4,
                            ])->andWhere("IFNULL(kd_penerimaan_1,'') LIKE '$kd_penerimaan_1' AND IFNULL(kd_penerimaan_2,'') LIKE '$kd_penerimaan_2'");
                        $data4 = \app\models\TaRkasHistory::find()->where([
                            'tahun' => $Tahun,
                            'perubahan_id' => $getparam['Laporan']['perubahan_id'],
                            'sekolah_id' => Yii::$app->user->identity->sekolah_id,
                            'Kd_Rek_1' => 4,
                            ])->andWhere("IFNULL(kd_penerimaan_1,'') LIKE '$kd_penerimaan_1' AND IFNULL(kd_penerimaan_2,'') LIKE '$kd_penerimaan_2'");
                        $data = \app\models\TaRkasHistory::find()
                            ->select(["kd_program", "SUM(total) AS total"])
                            ->where([
                            'tahun' => $Tahun,
                            'perubahan_id' => $getparam['Laporan']['perubahan_id'],
                            'sekolah_id' => Yii::$app->user->identity->sekolah_id,
                            'Kd_Rek_1' => 5,
                            ])->andWhere("IFNULL(kd_penerimaan_1,'') LIKE '$kd_penerimaan_1' AND IFNULL(kd_penerimaan_2,'') LIKE '$kd_penerimaan_2'")->groupBy('kd_program')->orderBy('kd_program')->all();
                        // $data = new ActiveDataProvider([
                        //     'query' => \app\models\TaSPH::find()->where("Tahun <= $Tahun")->andWhere('Saldo > 0')
                        // ]);
                        // IF(Yii::$app->user->identity->Kd_Urusan){
                        //     $data->query->andWhere([
                        //                      'ta_sph.Kd_Urusan'=> Yii::$app->user->identity->Kd_Urusan,
                        //                      'ta_sph.Kd_Bidang'=> Yii::$app->user->identity->Kd_Bidang,
                        //                      'ta_sph.Kd_Unit'=> Yii::$app->user->identity->Kd_Unit,
                        //                      'ta_sph.Kd_Sub'=> Yii::$app->user->identity->Kd_Sub,
                        //                      ]);
                        // }

                        // IF(isset($getparam['RefSubUnit']['skpd'])){
                        //     list($Kd_Urusan, $Kd_Bidang, $Kd_Unit, $Kd_Sub) = explode('.', $getparam['RefSubUnit']['skpd']);
                        //     $data->query->andWhere([
                        //                      'ta_sph.Kd_Urusan'=> $Kd_Urusan,
                        //                      'ta_sph.Kd_Bidang'=> $Kd_Bidang,
                        //                      'ta_sph.Kd_Unit'=> $Kd_Unit,
                        //                      'ta_sph.Kd_Sub'=> $Kd_Sub,
                        //                      ]);
                        // }                        
                        // $data->query->orderBy('Tahun DESC');  
                        $render = 'cetaklaporan1';
                        break;
                    case 2:
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
                                ':sekolah_id' => Yii::$app->user->identity->sekolah_id,
                                ':perubahan_id' => $getparam['Laporan']['perubahan_id'],
                                ':kd_penerimaan_1' => $kd_penerimaan_1,
                                ':kd_penerimaan_2' => $kd_penerimaan_2,
                        ])->queryAll();                    

                        $render = 'cetaklaporan2';
                        break;   
                    case 3:
                        $data =  Yii::$app->db->createCommand("
                            SELECT * FROM
                            (
                                /*SALDO AWAL */
                                SELECT
                                a.tahun, a.sekolah_id, a.kd_penerimaan_1, a.kd_penerimaan_2, '' AS kode, '' AS no_bukti, '$Tahun-01-01' AS tgl_bukti, 'Saldo Awal' AS keterangan, SUM(a.nilai) AS nilai
                                FROM
                                ta_saldo_awal a
                                WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND IFNULL(a.kd_penerimaan_1, '') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.pembayaran LIKE '%'
                                GROUP BY a.tahun, a.sekolah_id, a.kd_penerimaan_1, a.kd_penerimaan_2
                                /*Saldo Awal sejak tanggal */
                                UNION ALL
                                SELECT
                                a.tahun,
                                a.sekolah_id,
                                '' AS kd_penerimaan_1,
                                '' AS kd_penerimaan_2,
                                '' AS kode, 
                                '' AS no_bukti,
                                :tgl_1 AS tgl_bukti,
                                'Akumulasi Transaksi' AS uraian,
                                SUM(
                                CASE a.Kd_Rek_1
                                    WHEN 4 THEN a.nilai
                                    WHEN 5 THEN -(a.nilai)
                                END
                                ) AS nilai
                                FROM
                                ta_spj_rinc AS a
                                LEFT JOIN
                                (
                                    SELECT 
                                    a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                    FROM ta_rkas_history a 
                                    WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                    AND IFNULL(a.kd_penerimaan_1, '') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                    GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti < :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                GROUP BY a.tahun, a.sekolah_id
                                /*Transaksi */
                                UNION ALL
                                SELECT
                                a.tahun,
                                a.sekolah_id,
                                b.kd_penerimaan_1,
                                b.kd_penerimaan_2,
                                CONCAT(a.kd_program, RIGHT(CONCAT('0',a.kd_sub_program),2), RIGHT(CONCAT('0',a.kd_kegiatan),2), '.', a.Kd_Rek_3, RIGHT(CONCAT('0',a.Kd_Rek_4),2), RIGHT(CONCAT('0',a.Kd_Rek_5),2)) AS kode,
                                a.no_bukti,
                                a.tgl_bukti,
                                a.uraian,
                                CASE a.Kd_Rek_1
                                    WHEN 4 THEN a.nilai
                                    WHEN 5 THEN -(a.nilai)
                                END
                                FROM
                                ta_spj_rinc AS a
                                LEFT JOIN
                                (
                                    SELECT 
                                    a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                    FROM ta_rkas_history a 
                                    WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                    AND IFNULL(a.kd_penerimaan_1, '') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                    GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                            ) a ORDER BY tgl_bukti, no_bukti ASC                    
                        ")->bindValues([
                                ':tahun' => $Tahun,
                                ':sekolah_id' => Yii::$app->user->identity->sekolah_id,
                                ':perubahan_id' => $getparam['Laporan']['perubahan_id'],
                                ':kd_penerimaan_1' => $kd_penerimaan_1,
                                ':kd_penerimaan_2' => $kd_penerimaan_2,
                                ':tgl_1' => $getparam['Laporan']['Tgl_1'],
                                ':tgl_2' => $getparam['Laporan']['Tgl_2'],
                        ])->queryAll();
 
                        $render = 'cetaklaporan3';
                        break;
                    case 4:
                        $data =  Yii::$app->db->createCommand("
                                    SELECT * FROM
                                    (
                                        /*SALDO AWAL */
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_penerimaan_1, a.kd_penerimaan_2, '' AS kode, '' AS no_bukti, '$Tahun-01-01' AS tgl_bukti, 'Saldo Awal' AS keterangan, SUM(a.nilai) AS nilai
                                        FROM
                                        ta_saldo_awal a
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND IFNULL(a.kd_penerimaan_1, '') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.pembayaran = 2
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        /*Saldo Awal sejak tanggal */
                                        UNION ALL
                                        SELECT
                                        a.tahun,
                                        a.sekolah_id,
                                        '' AS kd_penerimaan_1,
                                        '' AS kd_penerimaan_2,
                                        '' AS kode, 
                                        '' AS no_bukti,
                                        :tgl_1 AS tgl_bukti,
                                        'Akumulasi Transaksi' AS uraian,
                                        SUM(a.nilai) AS nilai
                                        FROM
                                        (                                        
                                            SELECT
                                            a.tahun,
                                            a.sekolah_id,
                                            '' AS kd_penerimaan_1,
                                            '' AS kd_penerimaan_2,
                                            '' AS kode, 
                                            '' AS no_bukti,
                                            :tgl_1 AS tgl_bukti,
                                            'Akumulasi Transaksi' AS uraian,
                                            SUM(
                                            CASE a.Kd_Rek_1
                                                WHEN 4 THEN a.nilai
                                                WHEN 5 THEN -(a.nilai)
                                            END
                                            ) AS nilai
                                            FROM
                                            ta_spj_rinc AS a
                                            LEFT JOIN
                                            (
                                                SELECT 
                                                a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                                FROM ta_rkas_history a 
                                                WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                                AND IFNULL(a.kd_penerimaan_1, '') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                                GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                            AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti < :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.pembayaran = 2
                                            GROUP BY a.tahun, a.sekolah_id
                                            UNION ALL
                                            SELECT a.tahun, a.sekolah_id, '' AS kd_penerimaan_1, '' AS kd_penerimaan_2, '' AS kode, '' AS no_bukti, '' AS tgl_bukti, '' AS uraian,
                                            SUM(CASE a.kd_mutasi
                                                WHEN 1 THEN a.nilai
                                                WHEN 2 THEN -(a.nilai)
                                            END) AS nilai
                                            FROM ta_mutasi_kas a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti < :tgl_1
                                            GROUP BY a.tahun, a.sekolah_id
                                            /*Potongan */
                                            UNION ALL
                                            SELECT
                                            a.tahun,
                                            a.sekolah_id,
                                            '' AS kd_penerimaan_1,
                                            '' AS kd_penerimaan_2,
                                            '' AS kode, 
                                            '' AS no_bukti,
                                            :tgl_1 AS tgl_bukti,
                                            'Akumulasi Transaksi' AS uraian,
                                            SUM(c.nilai) AS nilai
                                            FROM
                                            ta_spj_rinc AS a
                                            LEFT JOIN
                                            (
                                                    SELECT 
                                                    a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                                    FROM ta_rkas_history a 
                                                    WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                                    AND IFNULL(a.kd_penerimaan_1, '') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                                    GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                            AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                            INNER JOIN
                                            ta_spj_pot c ON a.tahun = c.tahun AND a.sekolah_id = c.sekolah_id AND a.no_bukti = c.no_bukti
                                            INNER JOIN ref_potongan d ON c.kd_potongan =  d.kd_potongan
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <  :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2  AND a.Kd_Rek_1 = 5 AND a.pembayaran = 2
                                            GROUP BY a.tahun, a.sekolah_id

                                            /*Setoran Potongan */
                                            UNION ALL
                                            SELECT
                                            a.tahun,
                                            a.sekolah_id,
                                            '' AS kd_penerimaan_1,
                                            '' AS kd_penerimaan_2,
                                            '' AS kode, 
                                            '' AS no_bukti,
                                            '2016-01-01' AS tgl_bukti,
                                            'Akumulasi Transaksi' AS uraian,
                                            SUM(-(b.nilai)) AS nilai
                                            FROM ta_setoran_potongan a
                                            INNER JOIN ta_setoran_potongan_rinc b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.no_setoran = b.no_setoran
                                            INNER JOIN ref_potongan c ON b.kd_potongan = c.kd_potongan
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id
                                            AND a.tgl_setoran < :tgl_1 AND b.pembayaran = 2
                                            GROUP BY a.tahun, a.sekolah_id                                            
                                        ) a GROUP BY a.tahun, a.sekolah_id  
                                        /*Transaksi */
                                        UNION ALL
                                        SELECT
                                        a.tahun,
                                        a.sekolah_id,
                                        b.kd_penerimaan_1,
                                        b.kd_penerimaan_2,
                                        CONCAT(a.kd_program, RIGHT(CONCAT('0',a.kd_sub_program),2), RIGHT(CONCAT('0',a.kd_kegiatan),2), '.', a.Kd_Rek_3, RIGHT(CONCAT('0',a.Kd_Rek_4),2), RIGHT(CONCAT('0',a.Kd_Rek_5),2)) AS kode,
                                        a.no_bukti,
                                        a.tgl_bukti,
                                        a.uraian,
                                        CASE a.Kd_Rek_1
                                            WHEN 4 THEN a.nilai
                                            WHEN 5 THEN -(a.nilai)
                                        END
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                            SELECT 
                                            a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            FROM ta_rkas_history a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                            AND IFNULL(a.kd_penerimaan_1, '') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                            GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2  AND a.pembayaran = 2
                                        /*Mutasi Kas*/
                                        UNION ALL
                                        SELECT a.tahun, a.sekolah_id, '' AS kd_penerimaan_1, '' AS kd_penerimaan_2, '' AS kode, a.no_bukti, a.tgl_bukti, a.uraian,
                                        CASE a.kd_mutasi
                                            WHEN 1 THEN a.nilai
                                            WHEN 2 THEN -(a.nilai)
                                        END 
                                        FROM ta_mutasi_kas a 
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 
                                        /*Potongan Pajak Transaksi */
                                        UNION ALL
                                        SELECT
                                        a.tahun,
                                        a.sekolah_id,
                                        b.kd_penerimaan_1,
                                        b.kd_penerimaan_2,
                                        CONCAT(a.kd_program, RIGHT(CONCAT('0',a.kd_sub_program),2), RIGHT(CONCAT('0',a.kd_kegiatan),2), '.', a.Kd_Rek_3, RIGHT(CONCAT('0',a.Kd_Rek_4),2), RIGHT(CONCAT('0',a.Kd_Rek_5),2)) AS kode,
                                        a.no_bukti,
                                        a.tgl_bukti,
                                        d.nm_potongan,
                                        (c.nilai) AS nilai
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                                SELECT 
                                                a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                                FROM ta_rkas_history a 
                                                WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                                AND IFNULL(a.kd_penerimaan_1, '') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                                GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        INNER JOIN
                                        ta_spj_pot c ON a.tahun = c.tahun AND a.sekolah_id = c.sekolah_id AND a.no_bukti = c.no_bukti
                                        INNER JOIN ref_potongan d ON c.kd_potongan =  d.kd_potongan
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.Kd_Rek_1 = 5 AND a.pembayaran = 2
                                        
                                        /* Setoran Pajak Transaksi */
                                        UNION ALL
                                        SELECT a.tahun, a.sekolah_id, '' AS kd_penerimaan_1, '' AS kd_penerimaan_2,
                                        b.kd_potongan, CONCAT(a.no_setoran, '-',b.kd_potongan) AS no_bukti, a.tgl_setoran, b.keterangan,
                                        -(b.nilai) AS nilai
                                        FROM ta_setoran_potongan a
                                        INNER JOIN ta_setoran_potongan_rinc b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.no_setoran = b.no_setoran
                                        INNER JOIN ref_potongan c ON b.kd_potongan = c.kd_potongan
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id
                                        AND a.tgl_setoran <= :tgl_2 AND a.tgl_setoran >= :tgl_1 AND b.pembayaran = 2

                                    ) a ORDER BY tgl_bukti, no_bukti ASC           
                        ")->bindValues([
                                ':tahun' => $Tahun,
                                ':sekolah_id' => Yii::$app->user->identity->sekolah_id,
                                ':perubahan_id' => $getparam['Laporan']['perubahan_id'],
                                ':kd_penerimaan_1' => $kd_penerimaan_1,
                                ':kd_penerimaan_2' => $kd_penerimaan_2,
                                ':tgl_1' => $getparam['Laporan']['Tgl_1'],
                                ':tgl_2' => $getparam['Laporan']['Tgl_2'],
                        ])->queryAll();
                        $render = 'cetaklaporan3';
                        break; 
                    case 5:
                        $data =  Yii::$app->db->createCommand("
                                    SELECT * FROM
                                    (
                                        /*SALDO AWAL */
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_penerimaan_1, a.kd_penerimaan_2, '' AS kode, '' AS no_bukti, '$Tahun-01-01' AS tgl_bukti, 'Saldo Awal' AS keterangan, SUM(a.nilai) AS nilai
                                        FROM
                                        ta_saldo_awal a
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND IFNULL(a.kd_penerimaan_1, '') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.pembayaran = 1
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        /*Saldo Awal sejak tanggal */
                                        UNION ALL
                                        SELECT
                                        a.tahun,
                                        a.sekolah_id,
                                        '' AS kd_penerimaan_1,
                                        '' AS kd_penerimaan_2,
                                        '' AS kode, 
                                        '' AS no_bukti,
                                        :tgl_1 AS tgl_bukti,
                                        'Akumulasi Transaksi' AS uraian,
                                        SUM(a.nilai) AS nilai
                                        FROM
                                        (                                        
                                            SELECT
                                            a.tahun,
                                            a.sekolah_id,
                                            '' AS kd_penerimaan_1,
                                            '' AS kd_penerimaan_2,
                                            '' AS kode, 
                                            '' AS no_bukti,
                                            :tgl_1 AS tgl_bukti,
                                            'Akumulasi Transaksi' AS uraian,
                                            SUM(
                                            CASE a.Kd_Rek_1
                                                WHEN 4 THEN a.nilai
                                                WHEN 5 THEN -(a.nilai)
                                            END
                                            ) AS nilai
                                            FROM
                                            ta_spj_rinc AS a
                                            LEFT JOIN
                                            (
                                                SELECT 
                                                a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                                FROM ta_rkas_history a 
                                                WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                                AND IFNULL(a.kd_penerimaan_1, '') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                                GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                            AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti < :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.pembayaran = 1
                                            GROUP BY a.tahun, a.sekolah_id
                                            UNION ALL
                                            SELECT a.tahun, a.sekolah_id, '' AS kd_penerimaan_1, '' AS kd_penerimaan_2, '' AS kode, '' AS no_bukti, '' AS tgl_bukti, '' AS uraian,
                                            SUM(CASE a.kd_mutasi
                                                WHEN 2 THEN a.nilai
                                                WHEN 1 THEN -(a.nilai)
                                            END) AS nilai
                                            FROM ta_mutasi_kas a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti < :tgl_1
                                            GROUP BY a.tahun, a.sekolah_id
                                            /*Potongan */
                                            UNION ALL
                                            SELECT
                                            a.tahun,
                                            a.sekolah_id,
                                            '' AS kd_penerimaan_1,
                                            '' AS kd_penerimaan_2,
                                            '' AS kode, 
                                            '' AS no_bukti,
                                            :tgl_1 AS tgl_bukti,
                                            'Akumulasi Transaksi' AS uraian,
                                            SUM(c.nilai) AS nilai
                                            FROM
                                            ta_spj_rinc AS a
                                            LEFT JOIN
                                            (
                                                    SELECT 
                                                    a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                                    FROM ta_rkas_history a 
                                                    WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                                    AND IFNULL(a.kd_penerimaan_1, '') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                                    GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                            AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                            INNER JOIN
                                            ta_spj_pot c ON a.tahun = c.tahun AND a.sekolah_id = c.sekolah_id AND a.no_bukti = c.no_bukti
                                            INNER JOIN ref_potongan d ON c.kd_potongan =  d.kd_potongan
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <  :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2  AND a.Kd_Rek_1 = 5 AND a.pembayaran = 1
                                            GROUP BY a.tahun, a.sekolah_id

                                            /*Setoran Potongan */
                                            UNION ALL
                                            SELECT
                                            a.tahun,
                                            a.sekolah_id,
                                            '' AS kd_penerimaan_1,
                                            '' AS kd_penerimaan_2,
                                            '' AS kode, 
                                            '' AS no_bukti,
                                            '2016-01-01' AS tgl_bukti,
                                            'Akumulasi Transaksi' AS uraian,
                                            SUM(-(b.nilai)) AS nilai
                                            FROM ta_setoran_potongan a
                                            INNER JOIN ta_setoran_potongan_rinc b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.no_setoran = b.no_setoran
                                            INNER JOIN ref_potongan c ON b.kd_potongan = c.kd_potongan
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id
                                            AND a.tgl_setoran < :tgl_1 AND b.pembayaran = 1
                                            GROUP BY a.tahun, a.sekolah_id                                               
                                        ) a GROUP BY a.tahun, a.sekolah_id
                                        /*Transaksi */
                                        UNION ALL
                                        SELECT
                                        a.tahun,
                                        a.sekolah_id,
                                        b.kd_penerimaan_1,
                                        b.kd_penerimaan_2,
                                        CONCAT(a.kd_program, RIGHT(CONCAT('0',a.kd_sub_program),2), RIGHT(CONCAT('0',a.kd_kegiatan),2), '.', a.Kd_Rek_3, RIGHT(CONCAT('0',a.Kd_Rek_4),2), RIGHT(CONCAT('0',a.Kd_Rek_5),2)) AS kode,
                                        a.no_bukti,
                                        a.tgl_bukti,
                                        a.uraian,
                                        CASE a.Kd_Rek_1
                                            WHEN 4 THEN a.nilai
                                            WHEN 5 THEN -(a.nilai)
                                        END
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                            SELECT 
                                            a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            FROM ta_rkas_history a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                            AND IFNULL(a.kd_penerimaan_1, '') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                            GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2  AND a.pembayaran = 1
                                        /*Mutasi Kas*/
                                        UNION ALL
                                        SELECT a.tahun, a.sekolah_id, '' AS kd_penerimaan_1, '' AS kd_penerimaan_2, '' AS kode, a.no_bukti, a.tgl_bukti, a.uraian,
                                        CASE a.kd_mutasi
                                            WHEN 2 THEN a.nilai
                                            WHEN 1 THEN -(a.nilai)
                                        END 
                                        FROM ta_mutasi_kas a 
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 
                                        /*Potongan Pajak Transaksi */
                                        UNION ALL
                                        SELECT
                                        a.tahun,
                                        a.sekolah_id,
                                        b.kd_penerimaan_1,
                                        b.kd_penerimaan_2,
                                        CONCAT(a.kd_program, RIGHT(CONCAT('0',a.kd_sub_program),2), RIGHT(CONCAT('0',a.kd_kegiatan),2), '.', a.Kd_Rek_3, RIGHT(CONCAT('0',a.Kd_Rek_4),2), RIGHT(CONCAT('0',a.Kd_Rek_5),2)) AS kode,
                                        a.no_bukti,
                                        a.tgl_bukti,
                                        d.nm_potongan,
                                        (c.nilai) AS nilai
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                                SELECT 
                                                a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                                FROM ta_rkas_history a 
                                                WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                                AND IFNULL(a.kd_penerimaan_1, '') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                                GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        INNER JOIN
                                        ta_spj_pot c ON a.tahun = c.tahun AND a.sekolah_id = c.sekolah_id AND a.no_bukti = c.no_bukti
                                        INNER JOIN ref_potongan d ON c.kd_potongan =  d.kd_potongan
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.Kd_Rek_1 = 5 AND a.pembayaran = 1
                                        
                                        /* Setoran Pajak Transaksi */
                                        UNION ALL
                                        SELECT a.tahun, a.sekolah_id, '' AS kd_penerimaan_1, '' AS kd_penerimaan_2,
                                        b.kd_potongan, CONCAT(a.no_setoran, '-',b.kd_potongan) AS no_bukti, a.tgl_setoran, b.keterangan,
                                        -(b.nilai) AS nilai
                                        FROM ta_setoran_potongan a
                                        INNER JOIN ta_setoran_potongan_rinc b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.no_setoran = b.no_setoran
                                        INNER JOIN ref_potongan c ON b.kd_potongan = c.kd_potongan
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id
                                        AND a.tgl_setoran <= :tgl_2 AND a.tgl_setoran >= :tgl_1 AND b.pembayaran = 1                                        
                                    ) a ORDER BY tgl_bukti, no_bukti ASC
                        ")->bindValues([
                                ':tahun' => $Tahun,
                                ':sekolah_id' => Yii::$app->user->identity->sekolah_id,
                                ':perubahan_id' => $getparam['Laporan']['perubahan_id'],
                                ':kd_penerimaan_1' => $kd_penerimaan_1,
                                ':kd_penerimaan_2' => $kd_penerimaan_2,
                                ':tgl_1' => $getparam['Laporan']['Tgl_1'],
                                ':tgl_2' => $getparam['Laporan']['Tgl_2'],
                        ])->queryAll();
                        $render = 'cetaklaporan3';
                        break;                                                                                                 
                    case 6:
                        $data =  Yii::$app->db->createCommand("

                                    SELECT a.tahun, a.sekolah_id, a.kd_program, c.uraian_program, a.kd_sub_program, d.uraian_sub_program, a.kd_kegiatan, e.uraian_kegiatan, a.Kd_Rek_1, a.anggaran,
                                    IFNULL(f.nilai,0) AS rutin, IFNULL(g.nilai,0) AS bos_pusat, IFNULL(j.nilai,0) AS bos_provinsi, IFNULL(k.nilai,0) AS bos_lain, IFNULL(h.nilai,0) AS bantuan, IFNULL(i.nilai,0) AS lain
                                    FROM
                                    (
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, SUM(a.total) AS anggaran
                                        FROM
                                        ta_rkas_history a
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = :perubahan_id
                                        AND IFNULL(a.kd_penerimaan_1, '') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1
                                    ) a 
                                    -- Untuk realisasi Rutin 2
                                    LEFT JOIN
                                    (
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, SUM(a.nilai) AS nilai
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                            SELECT 
                                            a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            FROM ta_rkas_history a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                            AND a.kd_penerimaan_1 = 2
                                            GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND b.kd_penerimaan_1 = 2
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1
                                    ) f ON a.tahun = f.tahun AND a.sekolah_id = f.sekolah_id AND a.kd_program = f.kd_program AND a.kd_sub_program = f.kd_sub_program AND a.kd_kegiatan = f.kd_kegiatan AND a.Kd_Rek_1 = f.Kd_Rek_1
                                    -- Untuk realisasi BOS pusat 3-1
                                    LEFT JOIN
                                    (
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, SUM(a.nilai) AS nilai
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                            SELECT 
                                            a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            FROM ta_rkas_history a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                            AND a.kd_penerimaan_1 = 3 AND a.kd_penerimaan_2 = 1
                                            GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND b.kd_penerimaan_1 = 3 AND b.kd_penerimaan_2 = 1
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1
                                    ) g ON a.tahun = g.tahun AND a.sekolah_id = g.sekolah_id AND a.kd_program = g.kd_program AND a.kd_sub_program = g.kd_sub_program AND a.kd_kegiatan = g.kd_kegiatan AND a.Kd_Rek_1 = g.Kd_Rek_1
                                    -- Untuk realisasi bantuan 4
                                    LEFT JOIN
                                    (
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, SUM(a.nilai) AS nilai
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                            SELECT 
                                            a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            FROM ta_rkas_history a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                            AND a.kd_penerimaan_1 = 4
                                            GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND b.kd_penerimaan_1 = 4
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1
                                    ) h ON a.tahun = h.tahun AND a.sekolah_id = h.sekolah_id AND a.kd_program = h.kd_program AND a.kd_sub_program = h.kd_sub_program AND a.kd_kegiatan = h.kd_kegiatan AND a.Kd_Rek_1 = h.Kd_Rek_1
                                    -- untuk realisasi sumber lainnya 5
                                    LEFT JOIN
                                    (
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, SUM(a.nilai) AS nilai
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                            SELECT 
                                            a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            FROM ta_rkas_history a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                            AND a.kd_penerimaan_1 NOT IN (1,2,3,4)
                                            GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND b.kd_penerimaan_1 NOT IN (1,2,3,4)
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1
                                    ) i ON a.tahun = i.tahun AND a.sekolah_id = i.sekolah_id AND a.kd_program = i.kd_program AND a.kd_sub_program = i.kd_sub_program AND a.kd_kegiatan = i.kd_kegiatan AND a.Kd_Rek_1 = i.Kd_Rek_1
                                    -- Untuk realisasi BOS provinsi 3-2
                                    LEFT JOIN
                                    (
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, SUM(a.nilai) AS nilai
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                            SELECT 
                                            a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            FROM ta_rkas_history a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                            AND a.kd_penerimaan_1 = 3 AND a.kd_penerimaan_2 = 2
                                            GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND b.kd_penerimaan_1 = 3 AND b.kd_penerimaan_2 = 2
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1
                                    ) j ON a.tahun = j.tahun AND a.sekolah_id = j.sekolah_id AND a.kd_program = j.kd_program AND a.kd_sub_program = j.kd_sub_program AND a.kd_kegiatan = j.kd_kegiatan AND a.Kd_Rek_1 = j.Kd_Rek_1
                                    -- Untuk realisasi BOS kab/kota 3-x
                                    LEFT JOIN
                                    (
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, SUM(a.nilai) AS nilai
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                            SELECT 
                                            a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            FROM ta_rkas_history a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                            AND a.kd_penerimaan_1 = 3 AND a.kd_penerimaan_2 > 2
                                            GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND b.kd_penerimaan_1 = 3 AND b.kd_penerimaan_2 > 2
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1
                                    ) k ON a.tahun = k.tahun AND a.sekolah_id = k.sekolah_id AND a.kd_program = k.kd_program AND a.kd_sub_program = k.kd_sub_program AND a.kd_kegiatan = k.kd_kegiatan AND a.Kd_Rek_1 = k.Kd_Rek_1
                                    LEFT JOIN ref_program_sekolah c ON a.kd_program = c.kd_program
                                    LEFT JOIN ref_sub_program_sekolah d ON a.kd_program = d.kd_program AND a.kd_sub_program = d.kd_sub_program
                                    LEFT JOIN ref_kegiatan_sekolah e ON a.kd_program = e.kd_program AND a.kd_sub_program = e.kd_sub_program AND a.kd_kegiatan = e.kd_kegiatan
                                    ORDER BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1 ASC                  
                        ")->bindValues([
                                ':tahun' => $Tahun,
                                ':sekolah_id' => Yii::$app->user->identity->sekolah_id,
                                ':perubahan_id' => $getparam['Laporan']['perubahan_id'],
                                ':kd_penerimaan_1' => $kd_penerimaan_1,
                                ':kd_penerimaan_2' => $kd_penerimaan_2,
                                ':tgl_1' => $getparam['Laporan']['Tgl_1'],
                                ':tgl_2' => $getparam['Laporan']['Tgl_2'],
                        ])->queryAll();

                        $render = 'cetaklaporan6';
                        break;   
                    case 7:
                        $data =  Yii::$app->db->createCommand("
                                    SELECT a.tahun, a.sekolah_id, a.kd_program, c.uraian_program, a.Kd_Rek_1, a.anggaran,
                                    IFNULL(d.nilai,0) AS komponen1,
                                    IFNULL(e.nilai,0) AS komponen2,
                                    IFNULL(f.nilai,0) AS komponen3,
                                    IFNULL(g.nilai,0) AS komponen4,
                                    IFNULL(h.nilai,0) AS komponen5,
                                    IFNULL(i.nilai,0) AS komponen6,
                                    IFNULL(j.nilai,0) AS komponen7,
                                    IFNULL(k.nilai,0) AS komponen8,
                                    IFNULL(l.nilai,0) AS komponen9,
                                    IFNULL(m.nilai,0) AS komponen10,
                                    IFNULL(n.nilai,0) AS komponen11,
                                    IFNULL(o.nilai,0) AS komponen12,
                                    IFNULL(p.nilai,0) AS komponen13,
                                    IFNULL(q.nilai,0) AS komponenlain
                                    FROM
                                    (
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1, SUM(a.total) AS anggaran
                                        FROM
                                        ta_rkas_history a
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = :perubahan_id
                                        AND IFNULL(a.kd_penerimaan_1, '') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.Kd_Rek_1 = 5
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1
                                    ) a
                                    -- Untuk realisasi komponen BOS 1
                                    LEFT JOIN
                                    (
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1, SUM(a.nilai) AS nilai
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                            SELECT 
                                            a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            FROM ta_rkas_history a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                            AND IFNULL(a.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.Kd_Rek_1 = 5 AND a.komponen_id = 1
                                            GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                                    AND a.Kd_Rek_1 = 5 AND a.komponen_id = 1
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1
                                    ) d ON a.tahun = d.tahun AND a.sekolah_id = d.sekolah_id AND a.kd_program = d.kd_program AND a.Kd_Rek_1 = d.Kd_Rek_1
                                    -- Untuk realisasi komponen BOS 2
                                    LEFT JOIN
                                    (
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1, SUM(a.nilai) AS nilai
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                            SELECT 
                                            a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            FROM ta_rkas_history a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                            AND IFNULL(a.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.Kd_Rek_1 = 5 AND a.komponen_id = 2
                                            GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                                    AND a.Kd_Rek_1 = 5 AND a.komponen_id = 2
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1
                                    ) e ON a.tahun = e.tahun AND a.sekolah_id = e.sekolah_id AND a.kd_program = e.kd_program AND a.Kd_Rek_1 = e.Kd_Rek_1
                                    -- Untuk realisasi komponen BOS 3
                                    LEFT JOIN
                                    (
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1, SUM(a.nilai) AS nilai
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                            SELECT 
                                            a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            FROM ta_rkas_history a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                            AND IFNULL(a.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.Kd_Rek_1 = 5 AND a.komponen_id = 3
                                            GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                                    AND a.Kd_Rek_1 = 5 AND a.komponen_id = 3
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1
                                    ) f ON a.tahun = f.tahun AND a.sekolah_id = f.sekolah_id AND a.kd_program = f.kd_program AND a.Kd_Rek_1 = f.Kd_Rek_1
                                    -- Untuk realisasi komponen BOS 4
                                    LEFT JOIN
                                    (
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1, SUM(a.nilai) AS nilai
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                            SELECT 
                                            a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            FROM ta_rkas_history a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                            AND IFNULL(a.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.Kd_Rek_1 = 5 AND a.komponen_id = 4
                                            GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                                    AND a.Kd_Rek_1 = 5 AND a.komponen_id = 4
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1
                                    ) g ON a.tahun = g.tahun AND a.sekolah_id = g.sekolah_id AND a.kd_program = g.kd_program AND a.Kd_Rek_1 = g.Kd_Rek_1
                                    -- Untuk realisasi komponen BOS 5
                                    LEFT JOIN
                                    (
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1, SUM(a.nilai) AS nilai
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                            SELECT 
                                            a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            FROM ta_rkas_history a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                            AND IFNULL(a.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.Kd_Rek_1 = 5 AND a.komponen_id = 5
                                            GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                                    AND a.Kd_Rek_1 = 5 AND a.komponen_id = 5
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1
                                    ) h ON a.tahun = h.tahun AND a.sekolah_id = h.sekolah_id AND a.kd_program = h.kd_program AND a.Kd_Rek_1 = h.Kd_Rek_1
                                    -- Untuk realisasi komponen BOS 6
                                    LEFT JOIN
                                    (
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1, SUM(a.nilai) AS nilai
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                            SELECT 
                                            a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            FROM ta_rkas_history a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                            AND IFNULL(a.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.Kd_Rek_1 = 5 AND a.komponen_id = 6
                                            GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                                    AND a.Kd_Rek_1 = 5 AND a.komponen_id = 6
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1
                                    ) i ON a.tahun = i.tahun AND a.sekolah_id = i.sekolah_id AND a.kd_program = i.kd_program AND a.Kd_Rek_1 = i.Kd_Rek_1
                                    -- Untuk realisasi komponen BOS 7
                                    LEFT JOIN
                                    (
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1, SUM(a.nilai) AS nilai
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                            SELECT 
                                            a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            FROM ta_rkas_history a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                            AND IFNULL(a.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.Kd_Rek_1 = 5 AND a.komponen_id = 7
                                            GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                                    AND a.Kd_Rek_1 = 5 AND a.komponen_id = 7
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1
                                    ) j ON a.tahun = j.tahun AND a.sekolah_id = j.sekolah_id AND a.kd_program = j.kd_program AND a.Kd_Rek_1 = j.Kd_Rek_1
                                    -- Untuk realisasi komponen BOS 8
                                    LEFT JOIN
                                    (
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1, SUM(a.nilai) AS nilai
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                            SELECT 
                                            a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            FROM ta_rkas_history a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                            AND IFNULL(a.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.Kd_Rek_1 = 5 AND a.komponen_id = 8
                                            GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                                    AND a.Kd_Rek_1 = 5 AND a.komponen_id = 8
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1
                                    ) k ON a.tahun = k.tahun AND a.sekolah_id = k.sekolah_id AND a.kd_program = k.kd_program AND a.Kd_Rek_1 = k.Kd_Rek_1
                                    -- Untuk realisasi komponen BOS 9
                                    LEFT JOIN
                                    (
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1, SUM(a.nilai) AS nilai
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                            SELECT 
                                            a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            FROM ta_rkas_history a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                            AND IFNULL(a.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.Kd_Rek_1 = 5 AND a.komponen_id = 9
                                            GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                                    AND a.Kd_Rek_1 = 5 AND a.komponen_id = 9
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1
                                    ) l ON a.tahun = l.tahun AND a.sekolah_id = l.sekolah_id AND a.kd_program = l.kd_program AND a.Kd_Rek_1 = l.Kd_Rek_1
                                    -- Untuk realisasi komponen BOS 10
                                    LEFT JOIN
                                    (
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1, SUM(a.nilai) AS nilai
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                            SELECT 
                                            a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            FROM ta_rkas_history a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                            AND IFNULL(a.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.Kd_Rek_1 = 5 AND a.komponen_id = 10
                                            GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                                    AND a.Kd_Rek_1 = 5 AND a.komponen_id = 10
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1
                                    ) m ON a.tahun = m.tahun AND a.sekolah_id = m.sekolah_id AND a.kd_program = m.kd_program AND a.Kd_Rek_1 = m.Kd_Rek_1
                                    -- Untuk realisasi komponen BOS 11
                                    LEFT JOIN
                                    (
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1, SUM(a.nilai) AS nilai
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                            SELECT 
                                            a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            FROM ta_rkas_history a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                            AND IFNULL(a.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.Kd_Rek_1 = 5 AND a.komponen_id = 11
                                            GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                                    AND a.Kd_Rek_1 = 5 AND a.komponen_id = 11
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1
                                    ) n ON a.tahun = n.tahun AND a.sekolah_id = n.sekolah_id AND a.kd_program = n.kd_program AND a.Kd_Rek_1 = n.Kd_Rek_1
                                    -- Untuk realisasi komponen BOS 12
                                    LEFT JOIN
                                    (
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1, SUM(a.nilai) AS nilai
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                            SELECT 
                                            a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            FROM ta_rkas_history a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                            AND IFNULL(a.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.Kd_Rek_1 = 5 AND a.komponen_id = 12
                                            GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                                    AND a.Kd_Rek_1 = 5 AND a.komponen_id = 12
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1
                                    ) o ON a.tahun = o.tahun AND a.sekolah_id = o.sekolah_id AND a.kd_program = o.kd_program AND a.Kd_Rek_1 = o.Kd_Rek_1
                                    -- Untuk realisasi komponen BOS 13
                                    LEFT JOIN
                                    (
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1, SUM(a.nilai) AS nilai
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                            SELECT 
                                            a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            FROM ta_rkas_history a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                            AND IFNULL(a.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.Kd_Rek_1 = 5 AND a.komponen_id = 13
                                            GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                                    AND a.Kd_Rek_1 = 5 AND a.komponen_id = 13
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1
                                    ) p ON a.tahun = p.tahun AND a.sekolah_id = p.sekolah_id AND a.kd_program = p.kd_program AND a.Kd_Rek_1 = p.Kd_Rek_1
                                    -- Untuk realisasi komponen BOS other
                                    LEFT JOIN
                                    (
                                        SELECT
                                        a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1, SUM(a.nilai) AS nilai
                                        FROM
                                        ta_spj_rinc AS a
                                        LEFT JOIN
                                        (
                                            SELECT 
                                            a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                            FROM ta_rkas_history a 
                                            WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = :tahun AND sekolah_id = :sekolah_id)
                                            AND IFNULL(a.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(a.kd_penerimaan_2, '') LIKE :kd_penerimaan_2 AND a.Kd_Rek_1 = 5 AND IFNULL(a.komponen_id,0) NOT IN (1,2,3,4,5,6,7,8,9,10,11,12,13)
                                            GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.kd_sub_program, a.kd_kegiatan, a.Kd_Rek_1, a.Kd_Rek_2, a.Kd_Rek_3, a.Kd_Rek_4, a.Kd_Rek_5, a.kd_penerimaan_1, a.kd_penerimaan_2
                                        ) b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                                        AND a.Kd_Rek_1 = b.Kd_Rek_1 AND a.Kd_Rek_2 = b.Kd_Rek_2 AND a.Kd_Rek_3 = b.Kd_Rek_3 AND a.Kd_Rek_4 = b.Kd_Rek_4 AND a.Kd_Rek_5 = b.Kd_Rek_5
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND a.tgl_bukti <= :tgl_2 AND a.tgl_bukti >= :tgl_1 AND IFNULL(b.kd_penerimaan_1,'') LIKE :kd_penerimaan_1 AND IFNULL(b.kd_penerimaan_2, '') LIKE :kd_penerimaan_2
                                                    AND a.Kd_Rek_1 = 5 AND IFNULL(a.komponen_id,0) NOT IN (1,2,3,4,5,6,7,8,9,10,11,12,13) 
                                        GROUP BY a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1
                                    ) q ON a.tahun = q.tahun AND a.sekolah_id = q.sekolah_id AND a.kd_program = q.kd_program AND a.Kd_Rek_1 = q.Kd_Rek_1
                                    LEFT JOIN ref_program_sekolah c ON a.kd_program = c.kd_program
                                    ORDER BY a.tahun, a.sekolah_id, a.kd_program, a.Kd_Rek_1 ASC                
                        ")->bindValues([
                                ':tahun' => $Tahun,
                                ':sekolah_id' => Yii::$app->user->identity->sekolah_id,
                                ':perubahan_id' => $getparam['Laporan']['perubahan_id'],
                                ':kd_penerimaan_1' => $kd_penerimaan_1,
                                ':kd_penerimaan_2' => $kd_penerimaan_2,
                                ':tgl_1' => $getparam['Laporan']['Tgl_1'],
                                ':tgl_2' => $getparam['Laporan']['Tgl_2'],
                        ])->queryAll();

                        $render = 'cetaklaporan7';
                        break;                                         
                    case 8:
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
                                ':sekolah_id' => Yii::$app->user->identity->sekolah_id,
                                ':perubahan_id' => $getparam['Laporan']['perubahan_id'],
                                ':kd_penerimaan_1' => $kd_penerimaan_1,
                                ':kd_penerimaan_2' => $kd_penerimaan_2,
                        ])->queryAll();

                        $render = 'cetaklaporan8';
                        break; 
                    case 9:
                        $data =  Yii::$app->db->createCommand("  
                                SELECT * FROM
                                (
                                    #Saldo Awal
                                    SELECT a.tahun, a.sekolah_id, a.kd_potongan AS kode, '' AS no_bukti, '$Tahun-01-01' AS tgl_bukti, CONCAT('Saldo Awal ',b.nm_potongan) AS keterangan, a.nilai
                                    FROM ta_saldo_awal_potongan a
                                    INNER JOIN ref_potongan b ON a.kd_potongan = b.kd_potongan
                                    WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id
                                    #akumulasi transaksi
                                    UNION ALL
                                    SELECT a.tahun, a.sekolah_id, a.kd_potongan, '' AS no_bukti, :tgl_1, CONCAT('Saldo Akumulasi ', b.nm_potongan) AS uraian, SUM(nilai) AS nilai
                                    FROM (
                                        SELECT a.tahun, a.sekolah_id, a.kd_potongan, b.no_bukti, b.tgl_bukti, b.uraian, a.nilai
                                        FROM ta_spj_pot a
                                        INNER JOIN ta_spj_rinc b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.no_bukti = b.no_bukti
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND b.tgl_bukti <= :tgl_1
                                        UNION ALL
                                        SELECT a.tahun, a.sekolah_id, a.kd_potongan, b.no_setoran, b.tgl_setoran, a.keterangan, -(a.nilai) AS nilai
                                        FROM ta_setoran_potongan_rinc a
                                        INNER JOIN ta_setoran_potongan b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.no_setoran = b.no_setoran
                                        INNER JOIN ref_potongan c ON a.kd_potongan = c.kd_potongan
                                        WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND b.tgl_setoran <= :tgl_1
                                    ) a
                                    INNER JOIN ref_potongan b ON a.kd_potongan = b.kd_potongan
                                    GROUP BY a.tahun, a.sekolah_id, a.kd_potongan
                                    #transaksi Potongan
                                    UNION ALL
                                    SELECT a.tahun, a.sekolah_id, a.kd_potongan, b.no_bukti, b.tgl_bukti, b.uraian, a.nilai
                                    FROM ta_spj_pot a
                                    INNER JOIN ta_spj_rinc b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.no_bukti = b.no_bukti
                                    WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND b.tgl_bukti <= :tgl_2 AND b.tgl_bukti >= :tgl_1
                                    #transaksi setoran
                                    UNION ALL
                                    SELECT a.tahun, a.sekolah_id, a.kd_potongan, b.no_setoran, b.tgl_setoran, a.keterangan, -(a.nilai) AS nilai
                                    FROM ta_setoran_potongan_rinc a
                                    INNER JOIN ta_setoran_potongan b ON a.tahun = b.tahun AND a.sekolah_id = b.sekolah_id AND a.no_setoran = b.no_setoran
                                    INNER JOIN ref_potongan c ON a.kd_potongan = c.kd_potongan
                                    WHERE a.tahun = :tahun AND a.sekolah_id = :sekolah_id AND b.tgl_setoran <= :tgl_2 AND b.tgl_setoran >= :tgl_1
                                ) a ORDER BY a.tgl_bukti                                      
                        ")->bindValues([
                                ':tahun' => $Tahun,
                                ':sekolah_id' => Yii::$app->user->identity->sekolah_id,
                                ':tgl_1' => $getparam['Laporan']['Tgl_1'],
                                ':tgl_2' => $getparam['Laporan']['Tgl_2'],
                        ])->queryAll();

                        $render = 'cetaklaporan3';
                        break;
                    case 10:
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
                            ':sekolah_id' => Yii::$app->user->identity->sekolah_id,
                            ':perubahan_id' => $getparam['Laporan']['perubahan_id'],
                            ':kd_penerimaan_1' => $kd_penerimaan_1,
                            ':kd_penerimaan_2' => $kd_penerimaan_2
                        ])->queryAll();

                        $render = 'cetaklaporan10';                    
                        break;                                                
                    default:
                        # code...
                        break;
                }
            }

        }

        $peraturan = \app\models\TaRkasPeraturan::findOne([
                            'tahun' => $Tahun,
                            'perubahan_id' => $getparam['Laporan']['perubahan_id'],
                            'sekolah_id' => Yii::$app->user->identity->sekolah_id,
                            ]);
        $references = \app\models\TaTh::findOne(['tahun' => $Tahun]);

        return $this->render($render, [
            'get' => $get,
            'Kd_Laporan' => $Kd_Laporan,
            'data' => $data,
            'data1' => $data1,
            'data2' => $data2,
            'data3' => $data3,
            'data4' => $data4,
            'data5' => $data5,
            'data6' => $data6,
            'render' => $render,
            'getparam' => $getparam,
            'Tahun' => $Tahun,
            'peraturan' => $peraturan,
            'ref' => $references,
            'footerSumberDana' => isset($footerSumberDana) ? $footerSumberDana : null,
        ]);
    }

    public function actionSpm() {
        $out = [];
        
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
                if ($parents != null){
                    $cat_id = $parents[0];
                list($Kd_Urusan, $Kd_Bidang, $Kd_Unit, $Kd_Sub,) = explode('.', $cat_id);
                //$hutang = 
                    IF(Yii::$app->session->get('tahun')){
                        $tahun = Yii::$app->session->get('tahun');
                    }ELSE{
                        $tahun = DATE('Y');
                    }                 
                    $out = \app\models\TaSPM::find()
                            ->where([
                                     'tahun'    => $tahun,
                                     'Kd_Urusan'=> $Kd_Urusan,
                                     'Kd_Bidang'=> $Kd_Bidang,
                                     'Kd_Unit'=> $Kd_Unit,
                                     'Kd_Sub'=> $Kd_Sub,
                                     ])
                           ->select(['No_SPM AS id','No_SPM AS name'])->asArray()->all();
                           echo Json::encode(['output'=>$out, 'selected'=>'']);
                           return;
                }
        }
    }    

    /**
     * Finds the TaValidasiPembayaran model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $Kd_Bidang
     * @param integer $Kd_Sub
     * @param integer $Kd_Unit
     * @param integer $Kd_Urusan
     * @param string $No_Validasi
     * @param integer $Tahun
     * @return TaValidasiPembayaran the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($Kd_Bidang, $Kd_Sub, $Kd_Unit, $Kd_Urusan, $No_Validasi, $Tahun)
    {
        if (($model = TaValidasiPembayaran::findOne(['Kd_Bidang' => $Kd_Bidang, 'Kd_Sub' => $Kd_Sub, 'Kd_Unit' => $Kd_Unit, 'Kd_Urusan' => $Kd_Urusan, 'No_Validasi' => $No_Validasi, 'Tahun' => $Tahun])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findSpm($No_SPM, $Tahun)
    {
        if (($model = \app\models\TaSPM::findOne(['No_SPM' => $No_SPM, 'Tahun' => $Tahun])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }    

    protected function sumSpm($No_SPM, $Tahun)
    {
        $model = \app\models\TaSPMRinc::find()
                    ->where([
                     'Tahun'    => $Tahun,
                     'No_SPM'=> $No_SPM,
                     ])
                    ->sum('Nilai');
        return $model;
    }        

    protected function findValidasi($No_SPM, $Tahun)
    {
        if (($model = TaValidasiPembayaran::findOne(['No_SPM' => $No_SPM, 'Tahun' => $Tahun])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function cekakses(){

        IF(Yii::$app->user->identity){
            $akses = \app\models\RefUserMenu::find()->where(['kd_user' => Yii::$app->user->identity->kd_user, 'menu' => 601])->one();
            IF($akses){
                return true;
            }else{
                return false;
            }
        }ELSE{
            return false;
        }
    }      
}
