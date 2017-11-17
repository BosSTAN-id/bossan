<?php

namespace app\modules\globalsetting\controllers;

use Yii;
use app\models\RefKegiatanSekolah;
use app\models\RefProgramSekolah;
use app\models\RefSubProgramSekolah;
use app\modules\globalsetting\models\RefKegiatanSekolahSearch;
use app\modules\globalsetting\models\RefSubProgramSekolahSearch;
use app\modules\globalsetting\models\RefProgramSekolahSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * ProgkerController implements the CRUD actions for RefKegiatanSekolah model.
 */
class ProgkerController extends Controller
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
     * Lists all RefKegiatanSekolah models.
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

        $searchProgramModel = new RefProgramSekolahSearch(); 
        $dataProgramProvider = $searchProgramModel->search(Yii::$app->request->queryParams);
        $dataProgramProvider->pagination->pageSize = 0;

        $searchModel = new RefKegiatanSekolahSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 0;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchProgramModel' => $searchProgramModel,
            'dataProgramProvider' => $dataProgramProvider,
            'Tahun' => $Tahun,
        ]);
    }

    public function actionView($id)
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
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new RefKegiatanSekolah model.
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

        $model = new RefKegiatanSekolah();

        if ($model->load(Yii::$app->request->post())) {
            $subprogram = RefSubProgramSekolah::findOne(['kd_program' => $model->kd_program, 'kd_sub_program' => $model->kd_sub_program]);
            $model->subprogram_id = $subprogram->id;
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

    public function actionCreatesubprogram()
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

        // $query = RefSubProgramSekolah::find();
        
        // $dataProvider = new \yii\data\ActiveDataProvider([
        //     'query' => $query,
        // ]);

        $model = new RefSubProgramSekolah();

        if ($model->load(Yii::$app->request->post())) {
            IF($model->save()){
                echo 1;
            }ELSE{
                echo 0;
            }
        } else {
            return $this->renderAjax('_formsubprogram', [
                'model' => $model,
                // 'dataProvider' => $dataProvider,
            ]);
        }
    }

    public function actionUpdatesubprogram($id)
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

        $model = RefSubProgramSekolah::find()->where(['id' => $id])->one();

        if ($model->load(Yii::$app->request->post())) {
            IF($model->save()){
                echo 1;
            }ELSE{
                echo 0;
            }
        } else {
            return $this->renderAjax('_formsubprogram', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id)
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

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $subprogram = RefSubProgramSekolah::findOne(['kd_program' => $model->kd_program, 'kd_sub_program' => $model->kd_sub_program]);
            $model->subprogram_id = $subprogram->id;
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
     * Deletes an existing RefKegiatanSekolah model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
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

        $this->findModel($id)->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }

    /*
    // part sub program
    */
    public function actionSubprogramtab($id)
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

        $model = RefProgramSekolah::find()->where(['kd_program' => $id])->one();

        $searchSubProgramModel = new RefSubProgramSekolahSearch();
        $dataSubProgramProvider = $searchSubProgramModel->search(Yii::$app->request->queryParams);
        $dataSubProgramProvider->query->andWhere(['kd_program' => $id]);
        $dataSubProgramProvider->pagination->pageSize = 0;
        
        return $this->renderAjax('_subprogramtab', [
            'model' => $model,
            'searchSubProgramModel' => $searchSubProgramModel,
            'dataSubProgramProvider' => $dataSubProgramProvider,
        ]);
    }

    public function actionTambahsubprogram($id)
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

        $program = RefProgramSekolah::find()->where(['kd_program' => $id])->one();

        $model = new RefSubProgramSekolah();
        $model->kd_program = $program->kd_program;

        if ($model->load(Yii::$app->request->post())) {
            IF($model->save()){
                echo 1;
            }ELSE{
                echo 0;
            }
        } else {
            return $this->renderAjax('_formsubprogram', [
                'program' => $program,
                'model' => $model,
            ]);
        }
    }  

    public function actionUbahsubprogram($id)
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
        $model = RefSubProgramSekolah::find()->where(['id' => $id])->one();

        $program = RefProgramSekolah::find()->where(['kd_program' => $model->refProgram->kd_program])->one();

        $model->kd_program = $program->kd_program;

        if ($model->load(Yii::$app->request->post())) {
            IF($model->save()){
                echo 1;
            }ELSE{
                echo 0;
            }
        } else {
            return $this->renderAjax('_formsubprogram', [
                'program' => $program,
                'model' => $model,
            ]);
        }
    }  

    public function actionDeletesubprogram($id)
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

        $model = RefSubProgramSekolah::find()->where(['id' => $id])->one();
        $model->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }

    /*
    // part kegiatan
    */
    public function actionKegiatantab($id)
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

        $model = RefSubProgramSekolah::find()->where(['id' => $id])->one();

        $searchKegiatanModel = new RefKegiatanSekolahSearch();
        $dataKegiatanProvider = $searchKegiatanModel->search(Yii::$app->request->queryParams);
        $dataKegiatanProvider->query->andWhere(['subprogram_id' => $id]);
        $dataKegiatanProvider->pagination->pageSize = 0;
        
        return $this->renderAjax('_kegiatantab', [
            'model' => $model,
            'searchKegiatanModel' => $searchKegiatanModel,
            'dataKegiatanProvider' => $dataKegiatanProvider,
        ]);
    }

    public function actionTambahkegiatan($id)
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

        $subProgram = RefSubProgramSekolah::find()->where(['id' => $id])->one();

        $model = new RefKegiatanSekolah();
        $model->kd_program = $subProgram->kd_program;
        $model->subprogram_id = $subProgram->id;
        $model->kd_sub_program = $subProgram->kd_sub_program;

        if ($model->load(Yii::$app->request->post())) {
            IF($model->save()){
                echo 1;
            }ELSE{
                echo 0;
            }
        } else {
            return $this->renderAjax('_form', [
                'subProgram' => $subProgram,
                'model' => $model,
            ]);
        }
    }  
    
    public function actionUbahkegiatan($id)
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

        $model = $this->findModel($id);

        $subProgram = RefSubProgramSekolah::find()->where(['id' => $model->refSubProgram->id])->one();

        if ($model->load(Yii::$app->request->post())) {
            IF($model->save()){
                echo 1;
            }ELSE{
                echo 0;
            }
        } else {
            return $this->renderAjax('_form', [
                'subProgram' => $subProgram,
                'model' => $model,
            ]);
        }
    }  

    protected function findModel($id)
    {
        if (($model = RefKegiatanSekolah::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
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

    protected function cekakses(){

        IF(Yii::$app->user->identity){
            $akses = \app\models\RefUserMenu::find()->where(['kd_user' => Yii::$app->user->identity->kd_user, 'menu' => 108])->one();
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
