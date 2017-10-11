<?php
namespace app\controllers;

use app\models\User;
use app\models\LoginForm;
use app\models\AccountActivation;
use app\models\PasswordResetRequestForm;
use app\models\ResetPasswordForm;
use app\models\SignupForm;
use app\models\ContactForm;
use yii\helpers\Html;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Response;

/**
 * Site controller.
 * It is responsible for displaying static pages, logging users in and out,
 * sign up and account activation, and password reset.
 */
class SiteController extends Controller
{
    /**
     * Returns a list of behaviors that this component should behave as.
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Declares external actions for the controller.
     *
     * @return array
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

//Choose what year this application will use as default year --@hoaaah

    public function actionTahun($id)
    {
        $session = Yii::$app->session;
        IF($session['tahun']){
            $session->remove('tahun');
        }
        $session->set('tahun', $id);


        return $this->redirect(Yii::$app->request->referrer);
    }

    //Untuk QRCODE
    public function actionQr($url){
        $qr = Yii::$app->get('qr');

        Yii::$app->response->format = Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', $qr->getContentType());

        return $qr
            ->setText($url)
            ->setLabel('BosSTAN')
            ->writeString();       
    }
//------------------------------------------------------------------------------------------------//
// STATIC PAGES
//------------------------------------------------------------------------------------------------//

    /**
     * Displays the index (home) page.
     * Use it in case your home page contains static content.
     *
     * @return string
     */
    public function actionIndex()
    {
        IF(Yii::$app->session->get('tahun'))
        {
            $Tahun = Yii::$app->session->get('tahun');
        }ELSE{
            $Tahun = DATE('Y');
        }
        $sticky = \app\models\TaPengumuman::find()->where(['published' => 1, 'sticky' => 1]);
        $pengumuman = \app\models\TaPengumuman::find()->where(['published' => 1, 'sticky' => 0]);
        $sticky->andWhere('diumumkan_di = 3 OR diumumkan_di = 2');
        $sticky = count($sticky->all());
        $pengumuman->andWhere('diumumkan_di = 3 OR diumumkan_di = 2');
        $pengumuman = $pengumuman->orderBy('id DESC');
        // $pengumuman = $pengumuman;
        $dataProvider = new ActiveDataProvider([
            'query' => $pengumuman,
            'pagination' => [
                'pageSize' => $sticky + 3,
            ],
        ]);

        // if user sekolah
        $infoBos = $realisasiPendapatanGraphArray = $realisasiBelanjaGraphArray = null;
        if(Yii::$app->user->identity->sekolah_id){
            $sekolah_id = Yii::$app->user->identity->sekolah_id;
            $infoBos = \app\models\TaInfoBos::find()->where([
                'sekolah_id' => $sekolah_id,
            ])->orderBy('id DESC')->one();
            $realisasiBelanjaGraph = Yii::$app->db->createCommand("
                SELECT 1 AS bulan, IFNULL(SUM(nilai),0) AS nilai FROM ta_spj_rinc WHERE Kd_Rek_1 = 5 AND tahun = $Tahun AND sekolah_id = $sekolah_id AND tgl_bukti LIKE '$Tahun-01-%'
                UNION ALL
                SELECT 2 AS bulan, IFNULL(SUM(nilai),0) AS nilai FROM ta_spj_rinc WHERE Kd_Rek_1 = 5 AND tahun = $Tahun AND sekolah_id = $sekolah_id AND tgl_bukti LIKE '$Tahun-02-%'
                UNION ALL
                SELECT 3 AS bulan, IFNULL(SUM(nilai),0) AS nilai FROM ta_spj_rinc WHERE Kd_Rek_1 = 5 AND tahun = $Tahun AND sekolah_id = $sekolah_id AND tgl_bukti LIKE '$Tahun-03-%'
                UNION ALL
                SELECT 4 AS bulan, IFNULL(SUM(nilai),0) AS nilai FROM ta_spj_rinc WHERE Kd_Rek_1 = 5 AND tahun = $Tahun AND sekolah_id = $sekolah_id AND tgl_bukti LIKE '$Tahun-04-%'
                UNION ALL
                SELECT 5 AS bulan, IFNULL(SUM(nilai),0) AS nilai FROM ta_spj_rinc WHERE Kd_Rek_1 = 5 AND tahun = $Tahun AND sekolah_id = $sekolah_id AND tgl_bukti LIKE '$Tahun-05-%'
                UNION ALL
                SELECT 6 AS bulan, IFNULL(SUM(nilai),0) AS nilai FROM ta_spj_rinc WHERE Kd_Rek_1 = 5 AND tahun = $Tahun AND sekolah_id = $sekolah_id AND tgl_bukti LIKE '$Tahun-06-%'
                UNION ALL
                SELECT 7 AS bulan, IFNULL(SUM(nilai),0) AS nilai FROM ta_spj_rinc WHERE Kd_Rek_1 = 5 AND tahun = $Tahun AND sekolah_id = $sekolah_id AND tgl_bukti LIKE '$Tahun-07-%'
                UNION ALL
                SELECT 8 AS bulan, IFNULL(SUM(nilai),0) AS nilai FROM ta_spj_rinc WHERE Kd_Rek_1 = 5 AND tahun = $Tahun AND sekolah_id = $sekolah_id AND tgl_bukti LIKE '$Tahun-08-%'
                UNION ALL
                SELECT 9 AS bulan, IFNULL(SUM(nilai),0) AS nilai FROM ta_spj_rinc WHERE Kd_Rek_1 = 5 AND tahun = $Tahun AND sekolah_id = $sekolah_id AND tgl_bukti LIKE '$Tahun-09-%'
                UNION ALL
                SELECT 10 AS bulan, IFNULL(SUM(nilai),0) AS nilai FROM ta_spj_rinc WHERE Kd_Rek_1 = 5 AND tahun = $Tahun AND sekolah_id = $sekolah_id AND tgl_bukti LIKE '$Tahun-10-%'
                UNION ALL
                SELECT 11 AS bulan, IFNULL(SUM(nilai),0) AS nilai FROM ta_spj_rinc WHERE Kd_Rek_1 = 5 AND tahun = $Tahun AND sekolah_id = $sekolah_id AND tgl_bukti LIKE '$Tahun-11-%'
                UNION ALL
                SELECT 12 AS bulan, IFNULL(SUM(nilai),0) AS nilai FROM ta_spj_rinc WHERE Kd_Rek_1 = 5 AND tahun = $Tahun AND sekolah_id = $sekolah_id AND tgl_bukti LIKE '$Tahun-12-%'            
            ")->queryAll();
            $realisasiBelanjaGraphArray = \yii\helpers\ArrayHelper::getColumn($realisasiBelanjaGraph, 'nilai');
            $realisasiPendapatanGraph = Yii::$app->db->createCommand("
            SELECT 1 AS bulan, IFNULL(SUM(nilai),0) AS nilai FROM ta_spj_rinc WHERE Kd_Rek_1 = 4 AND tahun = $Tahun AND sekolah_id = $sekolah_id AND tgl_bukti LIKE '$Tahun-01-%'
            UNION ALL
            SELECT 2 AS bulan, IFNULL(SUM(nilai),0) AS nilai FROM ta_spj_rinc WHERE Kd_Rek_1 = 4 AND tahun = $Tahun AND sekolah_id = $sekolah_id AND tgl_bukti LIKE '$Tahun-02-%'
            UNION ALL
            SELECT 3 AS bulan, IFNULL(SUM(nilai),0) AS nilai FROM ta_spj_rinc WHERE Kd_Rek_1 = 4 AND tahun = $Tahun AND sekolah_id = $sekolah_id AND tgl_bukti LIKE '$Tahun-03-%'
            UNION ALL
            SELECT 4 AS bulan, IFNULL(SUM(nilai),0) AS nilai FROM ta_spj_rinc WHERE Kd_Rek_1 = 4 AND tahun = $Tahun AND sekolah_id = $sekolah_id AND tgl_bukti LIKE '$Tahun-04-%'
            UNION ALL
            SELECT 5 AS bulan, IFNULL(SUM(nilai),0) AS nilai FROM ta_spj_rinc WHERE Kd_Rek_1 = 4 AND tahun = $Tahun AND sekolah_id = $sekolah_id AND tgl_bukti LIKE '$Tahun-05-%'
            UNION ALL
            SELECT 6 AS bulan, IFNULL(SUM(nilai),0) AS nilai FROM ta_spj_rinc WHERE Kd_Rek_1 = 4 AND tahun = $Tahun AND sekolah_id = $sekolah_id AND tgl_bukti LIKE '$Tahun-06-%'
            UNION ALL
            SELECT 7 AS bulan, IFNULL(SUM(nilai),0) AS nilai FROM ta_spj_rinc WHERE Kd_Rek_1 = 4 AND tahun = $Tahun AND sekolah_id = $sekolah_id AND tgl_bukti LIKE '$Tahun-07-%'
            UNION ALL
            SELECT 8 AS bulan, IFNULL(SUM(nilai),0) AS nilai FROM ta_spj_rinc WHERE Kd_Rek_1 = 4 AND tahun = $Tahun AND sekolah_id = $sekolah_id AND tgl_bukti LIKE '$Tahun-08-%'
            UNION ALL
            SELECT 9 AS bulan, IFNULL(SUM(nilai),0) AS nilai FROM ta_spj_rinc WHERE Kd_Rek_1 = 4 AND tahun = $Tahun AND sekolah_id = $sekolah_id AND tgl_bukti LIKE '$Tahun-09-%'
            UNION ALL
            SELECT 10 AS bulan, IFNULL(SUM(nilai),0) AS nilai FROM ta_spj_rinc WHERE Kd_Rek_1 = 4 AND tahun = $Tahun AND sekolah_id = $sekolah_id AND tgl_bukti LIKE '$Tahun-10-%'
            UNION ALL
            SELECT 11 AS bulan, IFNULL(SUM(nilai),0) AS nilai FROM ta_spj_rinc WHERE Kd_Rek_1 = 4 AND tahun = $Tahun AND sekolah_id = $sekolah_id AND tgl_bukti LIKE '$Tahun-11-%'
            UNION ALL
            SELECT 12 AS bulan, IFNULL(SUM(nilai),0) AS nilai FROM ta_spj_rinc WHERE Kd_Rek_1 = 4 AND tahun = $Tahun AND sekolah_id = $sekolah_id AND tgl_bukti LIKE '$Tahun-12-%'            
        ")->queryAll();
        $realisasiPendapatanGraphArray = \yii\helpers\ArrayHelper::getColumn($realisasiPendapatanGraph, 'nilai');            
        }
        return $this->render('index',[
            'dataProvider' => $dataProvider,
            'infoBos' => $infoBos,
            'realisasiBelanjaGraph' => $realisasiBelanjaGraphArray,
            'realisasiPendapatanGraph' => $realisasiPendapatanGraphArray,
        ]);

    }

    // Bagian ini untuk menampilkan pengumuman
    public function actionView($id)
    {
        return $this->render('pengumuman', ['model' => \app\models\TaPengumuman::findOne(['id' => $id])]);
    }

    // Bagian ini untuk menampilkan user profile
    public function actionProfile()
    {
        $id = Yii::$app->user->identity->id;
        $model = \app\models\User::findOne(['id' => $id]);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('kv-detail-success', 'Perubahan disimpan');
            return $this->redirect(Yii::$app->request->referrer); 
        }

        return $this->render('profile', ['model' => $model]);
    } 

    public function actionUbahpassword()
    {
        $id = Yii::$app->user->identity->id;
        // load user data
        $model = \app\models\User::findOne($id);

        if ($model->load(Yii::$app->request->post())) {
            //  $this->password_hash = Yii::$app->security->generatePasswordHash($password);
            // var_dump($model->password_hash);
            // var_dump(Yii::$app->security->validatePassword($model->passwordlama, $model->password_hash));
            // var_dump(Yii::$app->security->generatePasswordHash($model->passwordlama));
            IF(Yii::$app->security->validatePassword($model->passwordlama, $model->password_hash)){
                $model->setPassword($model->password);
                $model->save();
                Yii::$app->getSession()->setFlash('success',  'Password sudah diganti');
                return $this->redirect(Yii::$app->request->referrer);                                
                // IF($model->save()){
                //     echo 1;
                // }ELSE{
                //     echo 0;
                // }                 
            }ELSE{
                Yii::$app->getSession()->setFlash('warning',  'Password lama anda salah');
                return $this->redirect(Yii::$app->request->referrer);                
            }
           
        } else {
            return $this->renderAjax('ubahpwd', [
                'user' => $model,
            ]);
        }        

        // if (!$user->load(Yii::$app->request->post())) {
        //     return $this->renderAjax('ubahpwd', ['user' => $user, 'role' => $user->item_name]);
        // }

        // // only if user entered new password we want to hash and save it
        // if ($user->password) {
        //     $user->setPassword($user->password);
        // }

        // return $this->redirect(['view', 'id' => $user->id]);
    }          

    /**
     * Displays the about static page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Displays the contact static page and sends the contact email.
     *
     * @return string|\yii\web\Response
     */
    public function actionContact()
    {
        $model = new ContactForm();

        if (!$model->load(Yii::$app->request->post()) || !$model->validate()) {
            return $this->render('contact', ['model' => $model]);
        }

        if (!$model->sendEmail(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('error', Yii::t('app', 'There was some error while sending email.'));
            return $this->refresh();
        }

        Yii::$app->session->setFlash('success', Yii::t('app', 
            'Thank you for contacting us. We will respond to you as soon as possible.'));
        
        return $this->refresh();
    }

//------------------------------------------------------------------------------------------------//
// LOG IN / LOG OUT / PASSWORD RESET
//------------------------------------------------------------------------------------------------//

    /**
     * Logs in the user if his account is activated,
     * if not, displays appropriate message.
     *
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        // user is logged in, he doesn't need to login
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        // get setting value for 'Login With Email'
        $lwe = Yii::$app->params['lwe'];

        // if 'lwe' value is 'true' we instantiate LoginForm in 'lwe' scenario
        $model = $lwe ? new LoginForm(['scenario' => 'lwe']) : new LoginForm();

        // monitor login status
        $successfulLogin = true;

        // posting data or login has failed
        if (!$model->load(Yii::$app->request->post()) || !$model->login()) {
            $successfulLogin = false;
        }

        // if user's account is not activated, he will have to activate it first
        if ($model->status === User::STATUS_INACTIVE && $successfulLogin === false) {
            Yii::$app->session->setFlash('error', Yii::t('app', 
                'You have to activate your account first. Please check your email.'));
            return $this->refresh();
        } 

        // if user is not denied because he is not active, then his credentials are not good
        if ($successfulLogin === false) {
            return $this->render('login', ['model' => $model]);
        }

        // login was successful, let user go wherever he previously wanted
        return $this->goBack();
    }

    /**
     * Logs out the user.
     *
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

/*----------------*
 * PASSWORD RESET *
 *----------------*/

    /**
     * Sends email that contains link for password reset action.
     *
     * @return string|\yii\web\Response
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();

        if (!$model->load(Yii::$app->request->post()) || !$model->validate()) {
            return $this->render('requestPasswordResetToken', ['model' => $model]);
        }

        if (!$model->sendEmail()) {
            Yii::$app->session->setFlash('error', Yii::t('app', 
                'Sorry, we are unable to reset password for email provided.'));
            return $this->refresh();
        }

        Yii::$app->session->setFlash('success', Yii::t('app', 'Check your email for further instructions.'));

        return $this->goHome();
    }

    /**
     * Resets password.
     *
     * @param  string $token Password reset token.
     * @return string|\yii\web\Response
     *
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if (!$model->load(Yii::$app->request->post()) || !$model->validate() || !$model->resetPassword()) {
            return $this->render('resetPassword', ['model' => $model]);
        }

        Yii::$app->session->setFlash('success', Yii::t('app', 'New password was saved.'));

        return $this->goHome();      
    }    

//------------------------------------------------------------------------------------------------//
// SIGN UP / ACCOUNT ACTIVATION
//------------------------------------------------------------------------------------------------//

    /**
     * Signs up the user.
     * If user need to activate his account via email, we will display him
     * message with instructions and send him account activation email with link containing account activation token. 
     * If activation is not necessary, we will log him in right after sign up process is complete.
     * NOTE: You can decide whether or not activation is necessary, @see config/params.php
     *
     * @return string|\yii\web\Response
     */
    public function actionSignup()
    {  
        // get setting value for 'Registration Needs Activation'
        $rna = Yii::$app->params['rna'];

        // if 'rna' value is 'true', we instantiate SignupForm in 'rna' scenario
        $model = $rna ? new SignupForm(['scenario' => 'rna']) : new SignupForm();

        // if validation didn't pass, reload the form to show errors
        if (!$model->load(Yii::$app->request->post()) || !$model->validate()) {
            return $this->render('signup', ['model' => $model]);  
        }

        // try to save user data in database, if successful, the user object will be returned
        $user = $model->signup();

        if (!$user) {
            // display error message to user
            Yii::$app->session->setFlash('error', Yii::t('app', 'We couldn\'t sign you up, please contact us.'));
            return $this->refresh();
        }

        // user is saved but activation is needed, use signupWithActivation()
        if ($user->status === User::STATUS_INACTIVE) {
            $this->signupWithActivation($model, $user);
            return $this->refresh();
        }

        // now we will try to log user in
        // if login fails we will display error message, else just redirect to home page
    
        if (!Yii::$app->user->login($user)) {
            // display error message to user
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Please try to log in.'));

            // log this error, so we can debug possible problem easier.
            Yii::error('Login after sign up failed! User '.Html::encode($user->username).' could not log in.');
        }
                      
        return $this->goHome();
    }

    /**
     * Tries to send account activation email.
     *
     * @param $model
     * @param $user
     */
    private function signupWithActivation($model, $user)
    {
        // sending email has failed
        if (!$model->sendAccountActivationEmail($user)) {
            // display error message to user
            Yii::$app->session->setFlash('error', Yii::t('app', 
                'We couldn\'t send you account activation email, please contact us.'));

            // log this error, so we can debug possible problem easier.
            Yii::error('Signup failed! User '.Html::encode($user->username).' could not sign up. 
                Possible causes: verification email could not be sent.');
        }

        // everything is OK
        Yii::$app->session->setFlash('success', Yii::t('app', 'Hello').' '.Html::encode($user->username). '. ' .
            Yii::t('app', 'To be able to log in, you need to confirm your registration. 
                Please check your email, we have sent you a message.'));
    }

/*--------------------*
 * ACCOUNT ACTIVATION *
 *--------------------*/

    /**
     * Activates the user account so he can log in into system.
     *
     * @param  string $token
     * @return \yii\web\Response
     *
     * @throws BadRequestHttpException
     */
    public function actionActivateAccount($token)
    {
        try {
            $user = new AccountActivation($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if (!$user->activateAccount()) {
            Yii::$app->session->setFlash('error', Html::encode($user->username). Yii::t('app', 
                ' your account could not be activated, please contact us!'));
            return $this->goHome();
        }

        Yii::$app->session->setFlash('success', Yii::t('app', 'Success! You can now log in.').' '.
            Yii::t('app', 'Thank you').' '.Html::encode($user->username).' '.Yii::t('app', 'for joining us!'));

        return $this->redirect('login');
    }
}
