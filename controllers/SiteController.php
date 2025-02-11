<?php

namespace app\controllers;

use app\models\Form\ContactForm;
use app\models\Form\LoginForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class SiteController extends Controller
{

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
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()

    {
//        Yii::$app->redis->set('mykey', 'some value');
//        echo Yii::$app->redis->get('mykey');
//        die();
//        $user = User::findOne(1);
//        $container =  Yii::$container;
//        $container->set(OTPCodeService::class, [
//            'notificator' => new SMSNotificatorService(),
//                ]
//        );

//        $l = Yii::$container->get(OTPCodeService::class);

//        $l->setNewCode(123,342);
//        echo 'ddd';
//        die();
        return $this->render('index');
    }


}
