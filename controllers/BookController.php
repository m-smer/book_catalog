<?php

namespace app\controllers;

use app\models\Author;
use app\models\Book;
use app\models\form\BookForm;
use app\models\search\BookSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * BookController implements the CRUD actions for Book model.
 */
class BookController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
                'access' => [
                    'class' => AccessControl::class,
                    'only' => ['create', 'update', 'delete'],
                    'rules' => [
                        [
                            'allow' => true,
                            'actions' => ['create', 'update', 'delete'],
                            'roles' => ['@'],
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Book models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new BookSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Book model.
     * @param int $book_id Book ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($book_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($book_id),
        ]);
    }

    /**
     * Creates a new Book model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $formModel = new BookForm();
        $book = new Book();
        $authors = Author::find()->all();

        if ($formModel->load($this->request->post()))
        {
            $formModel->images = UploadedFile::getInstances($formModel, 'images');
            if ($formModel->validate() && $formModel->saveARModel($book)) {
                return $this->redirect(['view', 'book_id' => $book->book_id]);
            }
        }

        return $this->render('create', [
            'formModel' => $formModel,
            'authors' => $authors,
        ]);
    }

    /**
     * Updates an existing Book model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $book_id Book ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(int $book_id)
    {
        $book = $this->findModel($book_id);
        $authors = Author::find()->all();

        $formModel = new BookForm();
        $formModel->load($book->attributes, '');
        $formModel->authorIds = $book->getAuthors()->select('author_id')->column(); // Текущие авторы
        $formModel->existingImages = $book->images;

        if ($formModel->load($this->request->post()))
        {
            $formModel->images = UploadedFile::getInstances($formModel, 'images');
            if ($formModel->validate() && $formModel->saveARModel($book)) {
                return $this->redirect(['view', 'book_id' => $book->book_id]);
            }
        }

        return $this->render('update', [
            'formModel' => $formModel,
            'arModel' => $book,
            'authors' => $authors,
        ]);
    }


    /**
     * Deletes an existing Book model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $book_id Book ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($book_id)
    {
        $this->findModel($book_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Book model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $book_id Book ID
     * @return Book the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($book_id)
    {
        if (($model = Book::findOne(['book_id' => $book_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
