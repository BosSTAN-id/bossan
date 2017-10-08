<?php

namespace app\modules\asettetap\controllers;

use Yii;
use app\models\TaAsetTetapBa;
use app\models\TaAsetTetapBaRinci;
use app\models\TaAsetTetapBaSaldo;
use app\modules\asettetap\models\TaAsetTetapBaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RekonController implements the CRUD actions for TaAsetTetapBa model.
 */
class RekonController extends Controller
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
                    'dump-aset' => ['POST'],
                    'dump-balance' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all TaAsetTetapBa models.
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
        $searchModel = new TaAsetTetapBaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['tahun' => $Tahun]);
        if(Yii::$app->user->identity->sekolah_id){
            $dataProvider->query->andWhere(['sekolah_id' => Yii::$app->user->identity->sekolah_id]);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'Tahun' => $Tahun,
        ]);
    }

    /**
     * Displays a single TaAsetTetapBa model.
     * @param string $tahun
     * @param integer $sekolah_id
     * @param string $no_ba
     * @return mixed
     */
    public function actionView($tahun, $sekolah_id, $no_ba)
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
        return $this->renderAjax('view', [
            'model' => $this->findModel($tahun, $sekolah_id, $no_ba),
        ]);
    }

    /**
     * Creates a new TaAsetTetapBa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
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

        $model = new TaAsetTetapBa();
        $model->tahun = $Tahun;
        if(Yii::$app->user->identity->sekolah_id){
            $model->sekolah_id =  Yii::$app->user->identity->sekolah_id;
        }

        if ($model->load(Yii::$app->request->post())) {
            IF($model->save()){
                echo 1;
            }ELSE{
                echo 0;
            }
        } else {
            return $this->renderAjax('_form', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TaAsetTetapBa model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $tahun
     * @param integer $sekolah_id
     * @param string $no_ba
     * @return mixed
     */
    public function actionUpdate($tahun, $sekolah_id, $no_ba)
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

        $model = $this->findModel($tahun, $sekolah_id, $no_ba);

        if ($model->load(Yii::$app->request->post())) {
            IF($model->save()){
                echo 1;
            }ELSE{
                echo 0;
            }
        } else {
            return $this->renderAjax('_form', [
                'model' => $model,
            ]);
        }
    }

    public function actionPrintBa($tahun, $sekolah_id, $no_ba)
    {
        $model = $this->findModel($tahun, $sekolah_id, $no_ba);
        $balance = TaAsetTetapBaSaldo::findAll(['tahun' => $tahun, 'sekolah_id' => $sekolah_id, 'no_ba' => $no_ba]);
        $references = \app\models\TaTh::findOne(['tahun' => $tahun]);
        $kibA = TaAsetTetapBaRinci::find()->where(['tahun' => $tahun, 'sekolah_id' => $sekolah_id, 'no_ba' => $no_ba, 'kepemilikan' => 12, 'Kd_Aset1' => 1])->andWhere('kondisi <=2')
        ->orderBy('tahun, Kd_Aset1, Kd_Aset2, Kd_Aset3, Kd_Aset4, Kd_Aset5, no_urut')->all();
        $kibB = TaAsetTetapBaRinci::find()->where(['tahun' => $tahun, 'sekolah_id' => $sekolah_id, 'no_ba' => $no_ba, 'kepemilikan' => 12, 'Kd_Aset1' => 2])->andWhere('kondisi <=2')
        ->orderBy('tahun, Kd_Aset1, Kd_Aset2, Kd_Aset3, Kd_Aset4, Kd_Aset5, no_urut')->all();
        $kibC = TaAsetTetapBaRinci::find()->where(['tahun' => $tahun, 'sekolah_id' => $sekolah_id, 'no_ba' => $no_ba, 'kepemilikan' => 12, 'Kd_Aset1' => 3])->andWhere('kondisi <=2')
        ->orderBy('tahun, Kd_Aset1, Kd_Aset2, Kd_Aset3, Kd_Aset4, Kd_Aset5, no_urut')->all();
        $kibD = TaAsetTetapBaRinci::find()->where(['tahun' => $tahun, 'sekolah_id' => $sekolah_id, 'no_ba' => $no_ba, 'kepemilikan' => 12, 'Kd_Aset1' => 4])->andWhere('kondisi <=2')
        ->orderBy('tahun, Kd_Aset1, Kd_Aset2, Kd_Aset3, Kd_Aset4, Kd_Aset5, no_urut')->all();
        $kibE = TaAsetTetapBaRinci::find()->where(['tahun' => $tahun, 'sekolah_id' => $sekolah_id, 'no_ba' => $no_ba, 'kepemilikan' => 12, 'Kd_Aset1' => 5])->andWhere('kondisi <=2')
        ->orderBy('tahun, Kd_Aset1, Kd_Aset2, Kd_Aset3, Kd_Aset4, Kd_Aset5, no_urut')->all();
        $rusakBerat = TaAsetTetapBaRinci::find()->where(['tahun' => $tahun, 'sekolah_id' => $sekolah_id, 'no_ba' => $no_ba, 'kepemilikan' => 12])->andWhere('kondisi = 3')
        ->orderBy('tahun, Kd_Aset1, Kd_Aset2, Kd_Aset3, Kd_Aset4, Kd_Aset5, no_urut')->all();
        $dihapuskan = TaAsetTetapBaRinci::find()->where(['tahun' => $tahun, 'sekolah_id' => $sekolah_id, 'no_ba' => $no_ba, 'kepemilikan' => 12])->andWhere('kondisi = 4')
        ->orderBy('tahun, Kd_Aset1, Kd_Aset2, Kd_Aset3, Kd_Aset4, Kd_Aset5, no_urut')->all();
        $pihakLain = TaAsetTetapBaRinci::find()->where(['tahun' => $tahun, 'sekolah_id' => $sekolah_id, 'no_ba' => $no_ba])->andWhere('kepemilikan != 12')
        ->orderBy('tahun, Kd_Aset1, Kd_Aset2, Kd_Aset3, Kd_Aset4, Kd_Aset5, no_urut')->all();

        return $this->render('print-ba', [
            'model' => $model,
            'balance' => $balance,
            'ref' => $references,
            'kibA' => $kibA,
            'kibB' => $kibB,
            'kibC' => $kibC,
            'kibD' => $kibD,
            'kibE' => $kibE,
            'rusakBerat' => $rusakBerat,
            'dihapuskan' => $dihapuskan,
            'pihakLain' => $pihakLain,
        ]);
    }

    public function actionDelete($tahun, $sekolah_id, $no_ba)
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

        $this->findModel($tahun, $sekolah_id, $no_ba)->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionDumpAset($tahun, $sekolah_id, $no_ba)
    {
        $model = $this->findModel($tahun, $sekolah_id, $no_ba);
        $dumpAset = TaAsetTetapBaRinci::deleteAll(['tahun' => $tahun, 'sekolah_id' => $sekolah_id, 'no_ba' => $no_ba]);
        $tahunTglBa = date('Y', strtotime($model->tgl_ba));
        $insert = Yii::$app->db->createCommand("
            INSERT INTO ta_aset_tetap_ba_rinci (tahun, sekolah_id, Kd_Aset1, Kd_Aset2, Kd_Aset3, Kd_Aset4, Kd_Aset5, no_urut, no_register, kepemilikan, sumber_perolehan, referensi_bukti, tgl_perolehan, nilai_perolehan, masa_manfaat, nilai_sisa, kondisi, keterangan, attr1, attr2, attr3, attr4, attr5, attr6, attr7, attr8, attr9, attr10, created_at, updated_at, no_ba)
            SELECT *, :no_ba AS no_ba FROM ta_aset_tetap
            WHERE tahun <= :tahun AND sekolah_id = :sekolah_id AND tgl_perolehan <= :tgl_ba
        ")->bindValues([
            ':tahun' => $tahunTglBa,
            ':sekolah_id' => $sekolah_id,
            ':no_ba' => $no_ba,
            ':tgl_ba' => $model->tgl_ba
        ]);
        $model->snapshot_status = 1;
        if($insert->execute()){
            $model->save();
        }
        Yii::$app->getSession()->setFlash('success',  'Dump Snapshot Berhasil!');
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionDumpBalance($tahun, $sekolah_id, $no_ba)
    {
        $model = $this->findModel($tahun, $sekolah_id, $no_ba);
        $dumpAset = TaAsetTetapBaSaldo::deleteAll(['tahun' => $tahun, 'sekolah_id' => $sekolah_id, 'no_ba' => $no_ba]);
        $tahunTglBa = date('Y', strtotime($model->tgl_ba));
        $insert = Yii::$app->db->createCommand("
            INSERT INTO ta_aset_tetap_ba_saldo
            SELECT tahun, sekolah_id, :no_ba AS no_ba, Kd_Aset1, Kd_Aset2, Kd_Aset3, Kd_Aset4, Kd_Aset5, SUM(nilai_perolehan) AS nilai_perolehan FROM ta_aset_tetap
            WHERE tahun <= :tahun AND sekolah_id = :sekolah_id AND kondisi <= 2 AND tgl_perolehan <= :tgl_ba
            GROUP BY tahun, sekolah_id, Kd_Aset1, Kd_Aset2, Kd_Aset3, Kd_Aset4, Kd_Aset5
        ")->bindValues([
            ':tahun' => $tahunTglBa,
            ':sekolah_id' => $sekolah_id,
            ':no_ba' => $no_ba,
            ':tgl_ba' => $model->tgl_ba
        ]);
        $model->balance_status = 1;
        if($insert->execute()){
            $model->save();
        }
        Yii::$app->getSession()->setFlash('success',  'Dump Balance Berhasil!');
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the TaAsetTetapBa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $tahun
     * @param integer $sekolah_id
     * @param string $no_ba
     * @return TaAsetTetapBa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($tahun, $sekolah_id, $no_ba)
    {
        if (($model = TaAsetTetapBa::findOne(['tahun' => $tahun, 'sekolah_id' => $sekolah_id, 'no_ba' => $no_ba])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    protected function cekakses(){

        IF(Yii::$app->user->identity){
            $akses = \app\models\RefUserMenu::find()->where(['kd_user' => Yii::$app->user->identity->kd_user, 'menu' => 703])->one();
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
