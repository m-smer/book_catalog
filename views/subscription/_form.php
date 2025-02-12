<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Author $authorModel */
/** @var app\models\form\SubscriptionForm $formModel */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="subscribe-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($formModel, 'phone_number')->textInput(['autofocus' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Subscribe!', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
