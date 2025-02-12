<?php

namespace app\controllers;

use app\models\Form\ContactForm;
use app\models\Form\LoginForm;
use app\models\User;
use app\services\OTPCode\OTPCodeService;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class UserController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
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


    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionSendCode()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $phone_number = \Yii::$app->request->post('phone_number');

        //todo проверка корректности ввода номера телефона
        if ($phone_number && $user = User::findIdentityPhoneNumber($phone_number)) {

            $OTPCodeService = Yii::$container->get(OTPCodeService::class);
            $OTPCodeService->setNewCode($user->phone_number);

            return [
                'success' => true,
            ];
        } else {
            return [
                'success' => false,
            ];
        }
    }

}
