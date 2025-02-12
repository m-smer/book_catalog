<?php

namespace app\controllers;

use app\models\Author;
use app\models\form\SubscriptionForm;
use app\models\Subscription;
use app\models\User;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

class SubscriptionController extends Controller
{

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'only' => ['subscribe'],
                    'rules' => [
                        [
                            'allow' => true,
                            'actions' => ['subscribe'],
                            'roles' => ['?'],
                        ],
                    ],
                    'denyCallback' => function ($rule, $action) {
                        throw new ForbiddenHttpException('Подписка доступна только гостям.');
                    }
                ],
            ]
        );
    }
    public function actionSubscribe(int $author_id) {

        $authorModel = $this->findAuthorModel($author_id);
        $formModel = new SubscriptionForm();


        if ($this->request->isPost
            && $formModel->load($this->request->post())
            && $formModel->validate())
        {
            $result = Subscription::subscribe($formModel->phone_number, $author_id);
            if (!$result) {
                \Yii::$app->session->setFlash('error', 'Не удалось сохранить подписку');
            } else {
                \Yii::$app->session->setFlash('success', 'Подписка оформлена');
            }

        }

        return $this->render('subscribe', [
            'authorModel' => $authorModel,
            'formModel' => $formModel,
        ]);
    }


    protected function findAuthorModel($author_id)
    {
        if (($model = Author::findOne(['author_id' => $author_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}