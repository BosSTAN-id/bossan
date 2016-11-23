<?php

namespace app\modules\anggaran\controllers;

use Yii;
use yii\base\Model;
use yii\helpers\Json;
use app\models\TaRkasKegiatan;
use app\modules\anggaran\models\TaRkasKegiatanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RkasController implements the CRUD actions for TaRkasKegiatan model.
 */
class RencanaController extends Controller
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


    //Bagian untuk RKAS Index------------------------------------------------------------------------------------------
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

        $sekolah_id = Yii::$app->user->identity->sekolah_id ? Yii::$app->user->identity->sekolah_id : NULL;
        $pdt = \app\models\TaRkasPendapatanRinc::find()->where(['tahun' => $Tahun, 'sekolah_id' => $sekolah_id])->sum('total');
        $belanja = \app\models\TaRkasBelanjaRinc::find()->where(['tahun' => $Tahun, 'sekolah_id' => $sekolah_id, 'Kd_Rek_1' => 5, 'Kd_Rek_2' => 2])->sum('total');
        $btl = \app\models\TaRkasBelanjaRinc::find()->where(['tahun' => $Tahun, 'sekolah_id' => $sekolah_id, 'Kd_Rek_1' => 5, 'Kd_Rek_2' => 1])->sum('total');

        return $this->render('index', [
            'Tahun' => $Tahun,
            'pdt' => $pdt,
            'belanja' => $belanja,
            'btl' => $btl,
        ]);
    }


    //Bagian untuk RKAS Kegiatan-----------------------------------------------------------------------------------------
    public function actionRkaskegiatan()
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
        $searchModel = new TaRkasKegiatanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['tahun' => $Tahun]);
        $dataProvider->query->andWhere('kd_program <> 0');
        IF(Yii::$app->user->identity->sekolah_id && $sekolah_id = Yii::$app->user->identity->sekolah_id){
            $dataProvider->query->andWhere(['sekolah_id' => $sekolah_id]);
        }

        return $this->render('kegiatan', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'Tahun' => $Tahun,
        ]);
    }


    //Bagian untuk RKAS Belanja-----------------------------------------------------------------------------------------
    public function actionRkasbelanja($tahun, $sekolah_id, $kd_program, $kd_sub_program, $kd_kegiatan)
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

        $kegiatan = \app\models\TaRkasKegiatan::findOne([
                'tahun' => $tahun,
                'sekolah_id' => $sekolah_id,
                'kd_program' => $kd_program,
                'kd_sub_program' => $kd_sub_program,
                'kd_kegiatan' => $kd_kegiatan,
                ]);

        $searchModel = new \app\modules\anggaran\models\TaRkasBelanjaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->where([
                'tahun' => $tahun,
                'sekolah_id' => $sekolah_id,
                'kd_program' => $kd_program,
                'kd_sub_program' => $kd_sub_program,
                'kd_kegiatan' => $kd_kegiatan,
            ]);
        $treeprogram = \app\models\TaRkasKegiatan::find()->select('tahun, sekolah_id, kd_program')->where(['tahun' => $tahun, 'sekolah_id' => $sekolah_id])->groupBy('tahun, sekolah_id, kd_program')->andWhere('kd_program <> 0')->all();

        return $this->render('belanja', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'Tahun' => $Tahun,
            'kegiatan' => $kegiatan,
            'treeprogram' => $treeprogram,
        ]);
    }

    public function actionUpdatebelanja($tahun, $sekolah_id, $kd_program, $kd_sub_program, $kd_kegiatan, $Kd_Rek_1, $Kd_Rek_2, $Kd_Rek_3, $Kd_Rek_4, $Kd_Rek_5)
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
        $session = Yii::$app->session;
        IF($session['Kd_Rek_1'] && $session['Kd_Rek_2']){
            $session->remove('Kd_Rek_1');
            $session->remove('Kd_Rek_2');
        }
        $session->set('Kd_Rek_1', 5);
        $session->set('Kd_Rek_2', 2);        

        $model = \app\models\TaRkasBelanja::findOne(['tahun' => $tahun, 'sekolah_id' => $sekolah_id, 'kd_program' => $kd_program, 'kd_sub_program' => $kd_sub_program, 'kd_kegiatan' => $kd_kegiatan , 'Kd_Rek_1' => $Kd_Rek_1, 'Kd_Rek_2' => $Kd_Rek_2, 'Kd_Rek_3' => $Kd_Rek_3, 'Kd_Rek_4' => $Kd_Rek_4, 'Kd_Rek_5' => $Kd_Rek_5]);

        if ($model->load(Yii::$app->request->post())) {
            IF($model->penerimaan_2)
                list($model->kd_penerimaan_1, $model->kd_penerimaan_2) = explode('.', $model->penerimaan_2);
            IF($model->save()){
                echo 1;
            }ELSE{
                echo 0;
            }
        } else {
            return $this->renderAjax('_formbelanja', [
                'model' => $model,
            ]);
        }
    }  


    //Bagian untuk RKAS Belanja Tidak Langsung-----------------------------------------------------------------------------------------
    //Bagian ini tidak perlu rincian, cukup gunakan data belanja seperti di atas
    public function actionRkasbtl()
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
        
        $sekolah_id = Yii::$app->user->identity->sekolah_id;
        //cek kegiatan terlebih dahulu jika tidak ada maka buat kegiatan non kegiatan
        $cekkegiatan = \app\models\TaRkasKegiatan::findOne(['tahun' => $Tahun, 'sekolah_id' => $sekolah_id, 'kd_program' => 0]);
        IF(!$cekkegiatan){
            $kegiatan = new \app\models\TaRkasKegiatan();
            $kegiatan->tahun = $Tahun;
            $kegiatan->sekolah_id = $sekolah_id;
            $kegiatan->kd_program = $kegiatan->kd_sub_program = $kegiatan->kd_kegiatan = 0;
            $kegiatan->pagu_anggaran = 0;
            $kegiatan->save();
        }

        $searchModel = new \app\modules\anggaran\models\TaRkasBelanjaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->where([
                'tahun' => $Tahun,
                'sekolah_id' => $sekolah_id,
                'kd_program' => 0,
                'kd_sub_program' => 0,
                'kd_kegiatan' => 0,
            ]);

        return $this->render('btl', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'Tahun' => $Tahun,
        ]);
    }


    public function actionRencanabtl($tahun, $sekolah_id, $kd_program, $kd_sub_program, $kd_kegiatan, $Kd_Rek_1, $Kd_Rek_2, $Kd_Rek_3, $Kd_Rek_4, $Kd_Rek_5)
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
        $session = Yii::$app->session;
        IF($session['Kd_Rek_1'] && $session['Kd_Rek_2']){
            $session->remove('Kd_Rek_1');
            $session->remove('Kd_Rek_2');
        }
        $session->set('Kd_Rek_1', 5);
        $session->set('Kd_Rek_2', 1);


        $anggaran = \app\models\TaRkasBelanjaRinc::find()->where(['tahun' => $tahun, 'sekolah_id' => $sekolah_id, 'kd_program' => $kd_program, 'kd_sub_program' => $kd_sub_program, 'kd_kegiatan' => $kd_kegiatan, 'Kd_Rek_1' => $Kd_Rek_1, 'Kd_Rek_2' => $Kd_Rek_2, 'Kd_Rek_3' => $Kd_Rek_3, 'Kd_Rek_4' => $Kd_Rek_4, 'Kd_Rek_5' => $Kd_Rek_5]);
        $rencana = \app\models\TaRkasBelanjaRencana::findOne(['tahun' => $tahun, 'sekolah_id' => $sekolah_id, 'kd_program' => $kd_program, 'kd_sub_program' => $kd_sub_program, 'kd_kegiatan' => $kd_kegiatan, 'Kd_Rek_1' => $Kd_Rek_1, 'Kd_Rek_2' => $Kd_Rek_2, 'Kd_Rek_3' => $Kd_Rek_3, 'Kd_Rek_4' => $Kd_Rek_4, 'Kd_Rek_5' => $Kd_Rek_5]);
        IF($rencana){
            $model = $rencana;
        }ELSE{
            $model = new \app\models\TaRkasBelanjaRencana();
            $model->tahun = $tahun;
            $model->sekolah_id = $sekolah_id;
            $model->kd_program = $kd_program;
            $model->kd_sub_program = $kd_sub_program;
            $model->kd_kegiatan = $kd_kegiatan;
            $model->Kd_Rek_1 = $Kd_Rek_1;
            $model->Kd_Rek_2 = $Kd_Rek_2;
            $model->Kd_Rek_3 = $Kd_Rek_3;
            $model->Kd_Rek_4 = $Kd_Rek_4;
            $model->Kd_Rek_5 = $Kd_Rek_5;
        }

        if ($model->load(Yii::$app->request->post())) {
            IF($model->save()){
                echo 1;
            }ELSE{
                echo 0;
            }
        } else {
            return $this->renderAjax('_formrencanabelanja', [
                'model' => $model,
                'anggaran' => $anggaran,
            ]);
        }
    }


    //Bagian untuk RKAS Belanja-----------------------------------------------------------------------------------------
    public function actionRkaspendapatan()
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

        $sekolah_id = Yii::$app->user->identity->sekolah_id;        
        $searchModel = new \app\modules\anggaran\models\TaRkasPendapatanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->where([
                'tahun' => $Tahun,
                'sekolah_id' => $sekolah_id,
            ]);

        return $this->render('pendapatan', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'Tahun' => $Tahun,
        ]);
    }

    public function actionRencanapendapatan($tahun, $sekolah_id, $Kd_Rek_1, $Kd_Rek_2, $Kd_Rek_3, $Kd_Rek_4, $Kd_Rek_5, $kd_penerimaan_1, $kd_penerimaan_2)
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

        $anggaran = \app\models\TaRkasPendapatanRinc::find()->where(['tahun' => $tahun, 'sekolah_id' => $sekolah_id, 'Kd_Rek_1' => $Kd_Rek_1, 'Kd_Rek_2' => $Kd_Rek_2, 'Kd_Rek_3' => $Kd_Rek_3, 'Kd_Rek_4' => $Kd_Rek_4, 'Kd_Rek_5' => $Kd_Rek_5]);
        $rencana = \app\models\TaRkasPendapatanRencana::findOne(['tahun' => $tahun, 'sekolah_id' => $sekolah_id, 'Kd_Rek_1' => $Kd_Rek_1, 'Kd_Rek_2' => $Kd_Rek_2, 'Kd_Rek_3' => $Kd_Rek_3, 'Kd_Rek_4' => $Kd_Rek_4, 'Kd_Rek_5' => $Kd_Rek_5]);
        IF($rencana){
            $model = $rencana;
        }ELSE{
            $model = new \app\models\TaRkasPendapatanRencana();
            $model->tahun = $tahun;
            $model->sekolah_id = $sekolah_id;
            $model->Kd_Rek_1 = $Kd_Rek_1;
            $model->Kd_Rek_2 = $Kd_Rek_2;
            $model->Kd_Rek_3 = $Kd_Rek_3;
            $model->Kd_Rek_4 = $Kd_Rek_4;
            $model->Kd_Rek_5 = $Kd_Rek_5;
            $model->kd_penerimaan_1 = $kd_penerimaan_1;
            $model->kd_penerimaan_2 = $kd_penerimaan_2;
        }

        if ($model->load(Yii::$app->request->post())) {
            // var_dump($model);
            IF($model->save()){
                echo 1;
            }ELSE{
                echo 0;
            }
        } else {
            return $this->renderAjax('_formrencanapdt', [
                'model' => $model,
                'anggaran' => $anggaran,
            ]);
        }
    }


    //Bagian untuk kamus-----------------------------------------------------------------------------------------
    public function actionKamuskegiatan()
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
        $searchModel = new \app\modules\anggaran\models\RefKegiatanSekolahSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize=100;

        return $this->renderAjax('kamuskegiatan', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'Tahun' => $Tahun,
        ]);
    }

    public function actionKamusbelanja()
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
        $searchModel = new \app\modules\anggaran\models\RefRek5Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['Kd_Rek_1' => 5, 'Kd_Rek_2' => 2]);
        $dataProvider->pagination->pageSize=100;

        return $this->renderAjax('kamusbelanja', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'Tahun' => $Tahun,
        ]);
    }    

    //for depdrop action ----@hoaaah
    public function actionSubprogram() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $kd_program = $parents[0];
                $out = \app\models\RefSubProgramSekolah::find()
                           ->where([
                            'kd_program' => $kd_program,
                            ])
                           ->select(['kd_sub_program AS id','CONCAT(kd_program,\'.\',kd_sub_program,\' \',uraian_sub_program) AS name'])->asArray()->all();
                // the getSubCatList function will query the database based on the
                // cat_id and return an array like below:
                // [
                //    ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
                //    ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
                // ]
                echo Json::encode(['output'=>$out, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }
     
    public function actionKegiatan() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $ids = $_POST['depdrop_parents'];
            $kd_program = empty($ids[0]) ? null : $ids[0];
            $kd_sub_program = empty($ids[1]) ? null : $ids[1];
            if ($kd_program != null) {
               //$data = self::getProdList($cat_id, $subcat_id);
               $data = \app\models\RefKegiatanSekolah::find()
                           ->where([
                            'kd_program' => $kd_program,
                            'kd_sub_program' => $kd_sub_program,
                            ])
                           ->select(['kd_kegiatan AS id','CONCAT(kd_program,\'.\',kd_sub_program,\'.\',kd_kegiatan,\' \',uraian_kegiatan) AS name'])->asArray()->all();
                /**
                 * the getProdList function will query the database based on the
                 * cat_id and sub_cat_id and return an array like below:
                 *  [
                 *      'out'=>[
                 *          ['id'=>'<prod-id-1>', 'name'=>'<prod-name1>'],
                 *          ['id'=>'<prod_id_2>', 'name'=>'<prod-name2>']
                 *       ],
                 *       'selected'=>'<prod-id-1>'
                 *  ]
                 */
               
               echo Json::encode(['output'=>$data, 'selected'=>'']);
               return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }

    public function actionKdrek4() {
        $out = [];
        $session = Yii::$app->session;        
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $Kd_Rek_3 = $parents[0];
                $out = \app\models\RefRek4::find()
                           ->where([
                            'Kd_Rek_1' => $session['Kd_Rek_1'],
                            'Kd_Rek_2' => $session['Kd_Rek_2'],
                            'Kd_Rek_3' => $Kd_Rek_3,
                            ])
                           ->select(['Kd_Rek_4 AS id','CONCAT(Kd_Rek_3,\'.\',Kd_Rek_4,\' \',Nm_Rek_4) AS name'])->asArray()->all();
                // the getSubCatList function will query the database based on the
                // cat_id and return an array like below:
                // [
                //    ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
                //    ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
                // ]
                echo Json::encode(['output'=>$out, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }
     
    public function actionKdrek5() {
        $out = [];
        $session = Yii::$app->session;        
        if (isset($_POST['depdrop_parents'])) {
            $ids = $_POST['depdrop_parents'];
            $Kd_Rek_3 = empty($ids[0]) ? null : $ids[0];
            $Kd_Rek_4 = empty($ids[1]) ? null : $ids[1];
            if ($Kd_Rek_3 != null) {
               //$data = self::getProdList($cat_id, $subcat_id);
               $data = \app\models\RefRek5::find()
                           ->where([
                            'Kd_Rek_1' => $session['Kd_Rek_1'],
                            'Kd_Rek_2' => $session['Kd_Rek_2'],
                            'Kd_Rek_3' => $Kd_Rek_3,
                            'Kd_Rek_4' => $Kd_Rek_4,
                            // 'sekolah' => 1,
                            ])
                           ->select(['Kd_Rek_5 AS id','CONCAT(Kd_Rek_3,\'.\',Kd_Rek_4,\'.\',Kd_Rek_5,\' \',Nm_Rek_5) AS name'])->asArray()->all();
                /**
                 * the getProdList function will query the database based on the
                 * cat_id and sub_cat_id and return an array like below:
                 *  [
                 *      'out'=>[
                 *          ['id'=>'<prod-id-1>', 'name'=>'<prod-name1>'],
                 *          ['id'=>'<prod_id_2>', 'name'=>'<prod-name2>']
                 *       ],
                 *       'selected'=>'<prod-id-1>'
                 *  ]
                 */
               
               echo Json::encode(['output'=>$data, 'selected'=>'']);
               return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }      

    /**
     * Finds the TaRkasKegiatan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $tahun
     * @param integer $sekolah_id
     * @param integer $kd_program
     * @param integer $kd_sub_program
     * @param integer $kd_kegiatan
     * @return TaRkasKegiatan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($tahun, $sekolah_id, $kd_program, $kd_sub_program, $kd_kegiatan)
    {
        if (($model = TaRkasKegiatan::findOne(['tahun' => $tahun, 'sekolah_id' => $sekolah_id, 'kd_program' => $kd_program, 'kd_sub_program' => $kd_sub_program, 'kd_kegiatan' => $kd_kegiatan])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    protected function cekakses(){

        IF(Yii::$app->user->identity){
            $akses = \app\models\RefUserMenu::find()->where(['kd_user' => Yii::$app->user->identity->kd_user, 'menu' => 404])->one();
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
