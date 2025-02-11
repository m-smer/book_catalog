<?php

use app\models\Author;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Book $arModel */
/** @var app\models\form\BookForm $formModel */
/** @var Author[] $authors */

$this->title = 'Update Book: ' . $arModel->title;
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $arModel->title, 'url' => ['view', 'book_id' => $arModel->book_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="book-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'arModel' => $arModel,
        'formModel' => $formModel,
        'authors' => $authors,
    ]) ?>

</div>
