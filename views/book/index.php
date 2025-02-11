<?php

use app\models\Book;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\BookSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Books';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Book', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'book_id',
            [
                'attribute' => 'Image',
                'format' => 'html',
                'value' => function ($model) {
                    $firstImage = $model->getImages()->one(); // Получаем первое изображение
                    if ($firstImage) {
                        return Html::img(Yii::$app->request->baseUrl . '/uploads/' . $firstImage->filename, [
                            'style' => 'width: 50px; height: auto;',
                        ]);
                    }
                    return '';
                },
            ],
            'title',
            'year',
            'isbn',
            [
                'attribute' => 'author',
                'label' => 'Авторы',
                'value' => function ($model) {
                    return implode(', ', ArrayHelper::getColumn($model->authors, 'full_name'));
                },
                'filter' => Html::activeTextInput($searchModel, 'author', [
                    'class' => 'form-control',
                ]),
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Book $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'book_id' => $model->book_id]);
                 }
            ],
        ],
    ]); ?>


</div>
