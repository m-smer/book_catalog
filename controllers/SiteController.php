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
//        $OTPCodeService = Yii::$container->get(OTPCodeService::class);
//        $OTPCodeService->setNewCode(1);

        return $this->render('index');
    }


}
