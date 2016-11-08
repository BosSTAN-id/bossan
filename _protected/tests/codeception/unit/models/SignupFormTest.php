<?php
namespace tests\codeception\unit\models;

use app\models\SignupForm;
use app\rbac\models\Role;
use Codeception\Specify;
use tests\codeception\unit\DbTestCase;
use tests\codeception\fixtures\UserFixture;
use Yii;

class SignupFormTest extends DbTestCase
{
    use Specify;

    /**
     * Make sure that signup is working if registration with activation is
     * requested by administrator.
     */
    public function testSignupWithActivation()
    {
        $model = new SignupForm([
            'username' => 'some_username',
            'email' => 'some_email@example.com',
            'password' => 'some_password',
            'status' => 1
        ]);
        $model->scenario = 'rna';

        $user = $model->signup();

        $this->assertInstanceOf('app\models\User', $user, 'user should be valid');

        expect('username should be correct', $user->username)->equals('some_username');
        expect('email should be correct', $user->email)->equals('some_email@example.com');
        expect('password should be correct', $user->validatePassword('some_password'))->true();

        expect('user has valid account activation token', $user->account_activation_token)->notNull();

        expect('account activation email should be sent', $model->sendAccountActivationEmail($user))->true();
    }

    /**
     * Make sure that signup without activation is working.
     */
    public function testNormalSignup()
    {
        $model = new SignupForm([
            'username' => 'some_username',
            'email' => 'some_email@example.com',
            'password' => 'some_password',
            'status' => 10
        ]);

        $user = $model->signup();

        $this->assertInstanceOf('app\models\User', $user, 'user should be valid');

        expect('username should be correct', $user->username)->equals('some_username');
        expect('email should be correct', $user->email)->equals('some_email@example.com');
        expect('password should be correct', $user->validatePassword('some_password'))->true();

        expect('account activation token is not set', $user->account_activation_token)->null();
    }   

    /**
     * Make sure that user can not take username|email that already exists.
     */
    public function testNotCorrectSignup()
    {
        $model = new SignupForm([
            'username' => 'member',
            'email' => 'member@example.com',
            'password' => 'member123',
            'status' => 1
        ]);

        expect('username and email are in use, user should not be created', $model->signup())->null();
    }

    /**
     * Declares the fixtures that are needed by the current test case.
     *
     * @return array
     */
    public function fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => '@tests/codeception/unit/fixtures/data/models/user.php',
            ],
        ];
    }
}
