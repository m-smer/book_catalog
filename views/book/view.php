<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Book $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="book-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'book_id' => $model->book_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'book_id' => $model->book_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'book_id',
            'title',
            'year',
            'isbn',
            [
                'attribute' => 'Картинка',
                'format' => 'html',
                'value' => function ($model) {
                    $firstImage = $model->getImages()->one();
                    if ($firstImage) {
                        return Html::img(Yii::$app->request->baseUrl . '/uploads/' . $firstImage->filename, [
                            'style' => 'width: 100px; height: auto;',
                        ]);
                    }
                    return 'Нет изображений';
                },
            ],
        ],
    ]) ?>

</div>
