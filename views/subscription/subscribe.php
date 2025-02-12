<?php

use app\models\Book;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Author $authorModel */
/** @var app\models\form\SubscriptionForm $formModel */

$this->title = 'Подписка на автора ' . $authorModel->full_name;
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="book-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="subscribe-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($formModel, 'phone_number')->textInput(['autofocus' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton('Subscribe!', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
