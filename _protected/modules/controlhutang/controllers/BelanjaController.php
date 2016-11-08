<?php

namespace app\modules\controlhutang\controllers;

use Yii;
use yii\base\Model;
use yii\helpers\Json;
use app\models\TaRASKArsip;
use app\modules\controlhutang\models\TaRASKArsipSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BelanjaController implements the CRUD actions for TaRASKArsip model.
 */
class BelanjaController extends Controller
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
     * Lists all TaRASKArsip models.
     * @return mixed
     */
    public function actionIndex()
    {
        IF($this->cekakses() !== true){
            Yii::$app->getSession()->setFlash('warning',  'Anda tidak memiliki hak akses');
            return $this->redirect(Yii::$app->request->referrer);
        }
        $searchModel = new TaRASKArsipSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize=50;        

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TaRASKArsip model.
     * @param integer $Tahun
     * @param integer $Kd_Perubahan
     * @param integer $Kd_Urusan
     * @param integer $Kd_Bidang
     * @param integer $Kd_Unit
     * @param integer $Kd_Sub
     * @param integer $Kd_Prog
     * @param integer $ID_Prog
     * @param integer $Kd_Keg
     * @param integer $Kd_Rek_1
     * @param integer $Kd_Rek_2
     * @param integer $Kd_Rek_3
     * @param integer $Kd_Rek_4
     * @param integer $Kd_Rek_5
     * @param integer $No_Rinc
     * @param integer $No_ID
     * @return mixed
     */
    public function actionView($Tahun, $Kd_Perubahan, $Kd_Urusan, $Kd_Bidang, $Kd_Unit, $Kd_Sub, $Kd_Prog, $ID_Prog, $Kd_Keg, $Kd_Rek_1, $Kd_Rek_2, $Kd_Rek_3, $Kd_Rek_4, $Kd_Rek_5, $No_Rinc, $No_ID)
    {
        return $this->render('view', [
            'model' => $this->findModel($Tahun, $Kd_Perubahan, $Kd_Urusan, $Kd_Bidang, $Kd_Unit, $Kd_Sub, $Kd_Prog, $ID_Prog, $Kd_Keg, $Kd_Rek_1, $Kd_Rek_2, $Kd_Rek_3, $Kd_Rek_4, $Kd_Rek_5, $No_Rinc, $No_ID),
        ]);
    }

    /**
     * Creates a new TaRASKArsip model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        IF($this->cekakses() !== true){
            Yii::$app->getSession()->setFlash('warning',  'Anda tidak memiliki hak akses');
            return $this->redirect(Yii::$app->request->referrer);
        }
        $model = new TaRASKArsip();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'Tahun' => $model->Tahun, 'Kd_Perubahan' => $model->Kd_Perubahan, 'Kd_Urusan' => $model->Kd_Urusan, 'Kd_Bidang' => $model->Kd_Bidang, 'Kd_Unit' => $model->Kd_Unit, 'Kd_Sub' => $model->Kd_Sub, 'Kd_Prog' => $model->Kd_Prog, 'ID_Prog' => $model->ID_Prog, 'Kd_Keg' => $model->Kd_Keg, 'Kd_Rek_1' => $model->Kd_Rek_1, 'Kd_Rek_2' => $model->Kd_Rek_2, 'Kd_Rek_3' => $model->Kd_Rek_3, 'Kd_Rek_4' => $model->Kd_Rek_4, 'Kd_Rek_5' => $model->Kd_Rek_5, 'No_Rinc' => $model->No_Rinc, 'No_ID' => $model->No_ID]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TaRASKArsip model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $Tahun
     * @param integer $Kd_Perubahan
     * @param integer $Kd_Urusan
     * @param integer $Kd_Bidang
     * @param integer $Kd_Unit
     * @param integer $Kd_Sub
     * @param integer $Kd_Prog
     * @param integer $ID_Prog
     * @param integer $Kd_Keg
     * @param integer $Kd_Rek_1
     * @param integer $Kd_Rek_2
     * @param integer $Kd_Rek_3
     * @param integer $Kd_Rek_4
     * @param integer $Kd_Rek_5
     * @param integer $No_Rinc
     * @param integer $No_ID
     * @return mixed
     */
    public function actionUpdate($Tahun, $Kd_Perubahan, $Kd_Urusan, $Kd_Bidang, $Kd_Unit, $Kd_Sub, $Kd_Prog, $ID_Prog, $Kd_Keg, $Kd_Rek_1, $Kd_Rek_2, $Kd_Rek_3, $Kd_Rek_4, $Kd_Rek_5, $No_Rinc, $No_ID)
    {
        $model = $this->findModel($Tahun, $Kd_Perubahan, $Kd_Urusan, $Kd_Bidang, $Kd_Unit, $Kd_Sub, $Kd_Prog, $ID_Prog, $Kd_Keg, $Kd_Rek_1, $Kd_Rek_2, $Kd_Rek_3, $Kd_Rek_4, $Kd_Rek_5, $No_Rinc, $No_ID);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'Tahun' => $model->Tahun, 'Kd_Perubahan' => $model->Kd_Perubahan, 'Kd_Urusan' => $model->Kd_Urusan, 'Kd_Bidang' => $model->Kd_Bidang, 'Kd_Unit' => $model->Kd_Unit, 'Kd_Sub' => $model->Kd_Sub, 'Kd_Prog' => $model->Kd_Prog, 'ID_Prog' => $model->ID_Prog, 'Kd_Keg' => $model->Kd_Keg, 'Kd_Rek_1' => $model->Kd_Rek_1, 'Kd_Rek_2' => $model->Kd_Rek_2, 'Kd_Rek_3' => $model->Kd_Rek_3, 'Kd_Rek_4' => $model->Kd_Rek_4, 'Kd_Rek_5' => $model->Kd_Rek_5, 'No_Rinc' => $model->No_Rinc, 'No_ID' => $model->No_ID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionSph($Tahun, $Kd_Perubahan, $Kd_Urusan, $Kd_Bidang, $Kd_Unit, $Kd_Sub, $Kd_Prog, $ID_Prog, $Kd_Keg, $Kd_Rek_1, $Kd_Rek_2, $Kd_Rek_3, $Kd_Rek_4, $Kd_Rek_5, $No_Rinc, $No_ID){
        IF($this->cekakses() !== true){
            Yii::$app->getSession()->setFlash('warning',  'Anda tidak memiliki hak akses');
            return $this->redirect(Yii::$app->request->referrer);
        }

        $sph = $this->findSphd();
        $arsip = $this->findModel($Tahun, $Kd_Perubahan, $Kd_Urusan, $Kd_Bidang, $Kd_Unit, $Kd_Sub, $Kd_Prog, $ID_Prog, $Kd_Keg, $Kd_Rek_1, $Kd_Rek_2, $Kd_Rek_3, $Kd_Rek_4, $Kd_Rek_5, $No_Rinc, $No_ID);
        $model = new \app\models\TaRASKArsipHutang();

        if ($model->load(Yii::$app->request->post())) {
            $model->Tahun = $Tahun;
            $model->Kd_Urusan =  Yii::$app->user->identity->Kd_Urusan;
            $model->Kd_Bidang =  Yii::$app->user->identity->Kd_Bidang;
            $model->Kd_Unit =  Yii::$app->user->identity->Kd_Unit;
            $model->Kd_Sub =  Yii::$app->user->identity->Kd_Sub;
            $model->Kd_Prog = $Kd_Prog;
            $model->ID_Prog = $ID_Prog;
            $model->Kd_Keg = $Kd_Keg;
            $model->Kd_Rek_1 = $Kd_Rek_1;
            $model->Kd_Rek_2 = $Kd_Rek_2;
            $model->Kd_Rek_3 = $Kd_Rek_3;
            $model->Kd_Rek_4 = $Kd_Rek_4;
            $model->Kd_Rek_5 = $Kd_Rek_5;
            $model->No_Rinc = $No_Rinc;
            $model->No_ID = $No_ID;
            $model->Keterangan_Rinc = $arsip['Keterangan_Rinc'];
            $model->Sat_1 = $arsip['Sat_1'];
            $model->Nilai_1 = $arsip['Nilai_1'];
            $model->Sat_2 = $arsip['Sat_2'];
            $model->Nilai_2 = $arsip['Nilai_2'];
            $model->Sat_3 = $arsip['Sat_3'];
            $model->Nilai_3 = $arsip['Nilai_3'];
            $model->Satuan123 = $arsip['Satuan123'];
            $model->Jml_Satuan = $arsip['Jml_Satuan'];
            $model->Nilai_Rp = $arsip['Nilai_Rp'];
            $model->Total = $arsip['Total'];
            $model->Keterangan = $arsip['Keterangan'];
            $model->Kd_Ap_Pub = $arsip['Kd_Ap_Pub'];
            $model->Kd_Sumber = $arsip['Kd_Sumber'];
            $model->Kd_Status_Belanja = 3;
            //$model->No_SPH = $model->No_SPH;
            // var_dump(Yii::$app->request->post());
            //var_dump($Yii::$app->request->post());
            IF($model->save())
            //return $this->redirect(['index']);
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            return $this->renderAjax('utang', [
                'model' => $model,
                'sph' => $sph,
            ]);
        }
    }    

    public function actionDeletesph($Tahun, $Kd_Urusan, $Kd_Bidang, $Kd_Unit, $Kd_Sub, $Kd_Prog, $ID_Prog, $Kd_Keg, $Kd_Rek_1, $Kd_Rek_2, $Kd_Rek_3, $Kd_Rek_4, $Kd_Rek_5, $No_Rinc, $No_ID)
    {
        IF($this->cekakses() !== true){
            Yii::$app->getSession()->setFlash('warning',  'Anda tidak memiliki hak akses');
            return $this->redirect(Yii::$app->request->referrer);
        }
        $this->findArsiphutang($Tahun, $Kd_Urusan, $Kd_Bidang, $Kd_Unit, $Kd_Sub, $Kd_Prog, $ID_Prog, $Kd_Keg, $Kd_Rek_1, $Kd_Rek_2, $Kd_Rek_3, $Kd_Rek_4, $Kd_Rek_5, $No_Rinc, $No_ID)->delete();

        return $this->redirect(['index']);
    }    

    public function actionLanjutan($Tahun, $Kd_Perubahan, $Kd_Urusan, $Kd_Bidang, $Kd_Unit, $Kd_Sub, $Kd_Prog, $ID_Prog, $Kd_Keg, $Kd_Rek_1, $Kd_Rek_2, $Kd_Rek_3, $Kd_Rek_4, $Kd_Rek_5, $No_Rinc, $No_ID){
        IF($this->cekakses() !== true){
            Yii::$app->getSession()->setFlash('warning',  'Anda tidak memiliki hak akses');
            return $this->redirect(Yii::$app->request->referrer);
        }

        $sph = $this->findRekap();
        $arsip = $this->findModel($Tahun, $Kd_Perubahan, $Kd_Urusan, $Kd_Bidang, $Kd_Unit, $Kd_Sub, $Kd_Prog, $ID_Prog, $Kd_Keg, $Kd_Rek_1, $Kd_Rek_2, $Kd_Rek_3, $Kd_Rek_4, $Kd_Rek_5, $No_Rinc, $No_ID);
        $model = new \app\models\TaRASKArsipHutang();

        $model->Tahun = $Tahun;
        $model->Kd_Urusan =  Yii::$app->user->identity->Kd_Urusan;
        $model->Kd_Bidang =  Yii::$app->user->identity->Kd_Bidang;
        $model->Kd_Unit =  Yii::$app->user->identity->Kd_Unit;
        $model->Kd_Sub =  Yii::$app->user->identity->Kd_Sub;
        $model->Kd_Prog = $Kd_Prog;
        $model->ID_Prog = $ID_Prog;
        $model->Kd_Keg = $Kd_Keg;
        $model->Kd_Rek_1 = $Kd_Rek_1;
        $model->Kd_Rek_2 = $Kd_Rek_2;
        $model->Kd_Rek_3 = $Kd_Rek_3;
        $model->Kd_Rek_4 = $Kd_Rek_4;
        $model->Kd_Rek_5 = $Kd_Rek_5;
        $model->No_Rinc = $No_Rinc;
        $model->No_ID = $No_ID;
        $model->Keterangan_Rinc = $arsip['Keterangan_Rinc'];
        $model->Sat_1 = $arsip['Sat_1'];
        $model->Nilai_1 = $arsip['Nilai_1'];
        $model->Sat_2 = $arsip['Sat_2'];
        $model->Nilai_2 = $arsip['Nilai_2'];
        $model->Sat_3 = $arsip['Sat_3'];
        $model->Nilai_3 = $arsip['Nilai_3'];
        $model->Satuan123 = $arsip['Satuan123'];
        $model->Jml_Satuan = $arsip['Jml_Satuan'];
        $model->Nilai_Rp = $arsip['Nilai_Rp'];
        $model->Total = $arsip['Total'];
        $model->Keterangan = $arsip['Keterangan'];
        $model->Kd_Ap_Pub = $arsip['Kd_Ap_Pub'];
        $model->Kd_Sumber = $arsip['Kd_Sumber'];
        $model->Kd_Status_Belanja = 2;
        var_dump($model);
        IF($model->save())
        return $this->redirect(['index']);
    }      

    public function actionKegiatan() {
        IF(Yii::$app->session->get('tahun'))
        {
            $Tahun = Yii::$app->session->get('tahun');
        }ELSE{
            $Tahun = DATE('Y');
        }  

        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $Program = $parents[0];
                list($Kd_Urusan, $Kd_Bidang, $Kd_Unit, $Kd_Sub, $Kd_Prog, $ID_Prog) = explode('.', $Program);
                $out = \app\models\TaKegiatan::find()
                           ->where([
                            'Tahun' => $Tahun,
                            'Kd_Urusan'=>$Kd_Urusan,
                            'Kd_Bidang'=>$Kd_Bidang,
                            'Kd_Unit'=>$Kd_Unit,
                            'Kd_Sub'=>$Kd_Sub,
                            'Kd_Prog' => $Kd_Prog,
                            'ID_Prog' => $ID_Prog
                            ])
                           ->select(['Kd_Keg AS id','Ket_Kegiatan AS name'])->asArray()->all();
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

    /**
     * Deletes an existing TaRASKArsip model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $Tahun
     * @param integer $Kd_Perubahan
     * @param integer $Kd_Urusan
     * @param integer $Kd_Bidang
     * @param integer $Kd_Unit
     * @param integer $Kd_Sub
     * @param integer $Kd_Prog
     * @param integer $ID_Prog
     * @param integer $Kd_Keg
     * @param integer $Kd_Rek_1
     * @param integer $Kd_Rek_2
     * @param integer $Kd_Rek_3
     * @param integer $Kd_Rek_4
     * @param integer $Kd_Rek_5
     * @param integer $No_Rinc
     * @param integer $No_ID
     * @return mixed
     */
    public function actionDelete($Tahun, $Kd_Perubahan, $Kd_Urusan, $Kd_Bidang, $Kd_Unit, $Kd_Sub, $Kd_Prog, $ID_Prog, $Kd_Keg, $Kd_Rek_1, $Kd_Rek_2, $Kd_Rek_3, $Kd_Rek_4, $Kd_Rek_5, $No_Rinc, $No_ID)
    {
        $this->findModel($Tahun, $Kd_Perubahan, $Kd_Urusan, $Kd_Bidang, $Kd_Unit, $Kd_Sub, $Kd_Prog, $ID_Prog, $Kd_Keg, $Kd_Rek_1, $Kd_Rek_2, $Kd_Rek_3, $Kd_Rek_4, $Kd_Rek_5, $No_Rinc, $No_ID)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TaRASKArsip model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $Tahun
     * @param integer $Kd_Perubahan
     * @param integer $Kd_Urusan
     * @param integer $Kd_Bidang
     * @param integer $Kd_Unit
     * @param integer $Kd_Sub
     * @param integer $Kd_Prog
     * @param integer $ID_Prog
     * @param integer $Kd_Keg
     * @param integer $Kd_Rek_1
     * @param integer $Kd_Rek_2
     * @param integer $Kd_Rek_3
     * @param integer $Kd_Rek_4
     * @param integer $Kd_Rek_5
     * @param integer $No_Rinc
     * @param integer $No_ID
     * @return TaRASKArsip the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($Tahun, $Kd_Perubahan, $Kd_Urusan, $Kd_Bidang, $Kd_Unit, $Kd_Sub, $Kd_Prog, $ID_Prog, $Kd_Keg, $Kd_Rek_1, $Kd_Rek_2, $Kd_Rek_3, $Kd_Rek_4, $Kd_Rek_5, $No_Rinc, $No_ID)
    {
        if (($model = TaRASKArsip::findOne(['Tahun' => $Tahun, 'Kd_Perubahan' => $Kd_Perubahan, 'Kd_Urusan' => $Kd_Urusan, 'Kd_Bidang' => $Kd_Bidang, 'Kd_Unit' => $Kd_Unit, 'Kd_Sub' => $Kd_Sub, 'Kd_Prog' => $Kd_Prog, 'ID_Prog' => $ID_Prog, 'Kd_Keg' => $Kd_Keg, 'Kd_Rek_1' => $Kd_Rek_1, 'Kd_Rek_2' => $Kd_Rek_2, 'Kd_Rek_3' => $Kd_Rek_3, 'Kd_Rek_4' => $Kd_Rek_4, 'Kd_Rek_5' => $Kd_Rek_5, 'No_Rinc' => $No_Rinc, 'No_ID' => $No_ID])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findRekap()
    {
        if (($model = \app\models\TaSPH::find(
                ['Kd_Urusan' => Yii::$app->user->identity->Kd_Urusan, 'Kd_Bidang' => Yii::$app->user->identity->Kd_Bidang, 'Kd_Unit' => Yii::$app->user->identity->Kd_Unit, 'Kd_Sub' => Yii::$app->user->identity->Kd_Sub]
                )->all()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    } 

    protected function findSphd()
    {
        IF(Yii::$app->session->get('tahun'))
        {
            $Tahun = Yii::$app->session->get('tahun');
        }ELSE{
            $Tahun = DATE('Y');
        }

        if (($model = \app\models\TaSPH::find()
            ->where(['Kd_Urusan' => Yii::$app->user->identity->Kd_Urusan, 'Kd_Bidang' => Yii::$app->user->identity->Kd_Bidang, 'Kd_Unit' => Yii::$app->user->identity->Kd_Unit, 'Kd_Sub' => Yii::$app->user->identity->Kd_Sub])
            ->andWhere('Tahun<='.$Tahun)
            ->select(['No_SPH','CONCAT(No_SPH, " - ", Nm_Perusahaan ) AS Nm_Perusahaan'])->all()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }    

    protected function findArsiphutang($Tahun, $Kd_Urusan, $Kd_Bidang, $Kd_Unit, $Kd_Sub, $Kd_Prog, $ID_Prog, $Kd_Keg, $Kd_Rek_1, $Kd_Rek_2, $Kd_Rek_3, $Kd_Rek_4, $Kd_Rek_5, $No_Rinc, $No_ID)
    {
        if (($model = \app\models\TaRASKArsipHutang::findOne(['Tahun' => $Tahun, 'Kd_Urusan' => $Kd_Urusan, 'Kd_Bidang' => $Kd_Bidang, 'Kd_Unit' => $Kd_Unit, 'Kd_Sub' => $Kd_Sub, 'Kd_Prog' => $Kd_Prog, 'ID_Prog' => $ID_Prog, 'Kd_Keg' => $Kd_Keg, 'Kd_Rek_1' => $Kd_Rek_1, 'Kd_Rek_2' => $Kd_Rek_2, 'Kd_Rek_3' => $Kd_Rek_3, 'Kd_Rek_4' => $Kd_Rek_4, 'Kd_Rek_5' => $Kd_Rek_5, 'No_Rinc' => $No_Rinc, 'No_ID' => $No_ID])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function cekakses(){

        IF(Yii::$app->user->identity){
            $akses = \app\models\RefUserMenu::find()->where(['kd_user' => Yii::$app->user->identity->kd_user, 'menu' => 101])->one();
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
