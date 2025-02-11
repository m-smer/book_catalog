<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Author $model */

$this->title = 'Update Author: ' . $model->author_id;
$this->params['breadcrumbs'][] = ['label' => 'Authors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->author_id, 'url' => ['view', 'author_id' => $model->author_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="author-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
