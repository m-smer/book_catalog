<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var \app\models\Form\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\Url;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to login:</p>

    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'labelOptions' => ['class' => 'col-lg-3 col-form-label mr-lg-3'],
                    'inputOptions' => ['class' => 'col-lg-3 form-control'],
                    'errorOptions' => ['class' => 'col-lg-4 invalid-feedback'],
                ],
            ]); ?>

            <?= $form->field($model, 'phone_number')->textInput(['autofocus' => true]) ?>

            <?= Html::button('Send code', ['class' => 'btn btn-primary', 'name' => 'send-code-button']) ?>
            <div id="response-message"></div>

            <div id="otpCodeInput" class="hidden">
                <?= $form->field($model, 'otp_code')->textInput() ?>
            </div>

            <?= $form->field($model, 'rememberMe')->checkbox([
                'template' => "<div class=\"custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
            ]) ?>

            <div class="form-group">
                <div>
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>


        </div>
    </div>
</div>

<?php
$this->registerJs("

$(document).ready(function () {
    $('button[name=send-code-button]').on('click', function () {
        const phone_number = parseInt(document.getElementById('loginform-phone_number').value);
        
        if (isNaN(phone_number)) {
            return false;
        }
              
        console.log('click');       
        
        var url = '" . Url::to(['user/send-code']) . "';      
        var data = {
            phone_number: phone_number,
        };

        $.ajax({
            url: url,
            type: 'POST', 
            data: data, 
            success: function (response) {                
                if (response.success) {
                    $('#response-message').html('<p>Код отправлен</p>');
                } else {
                    $('#response-message').html('<p style=\"color: red;\">Такой номер телефона не зарегистрирован</p>');
                }
                
            },
            error: function (xhr, status, error) {
                $('#response-message').html('<p style=\"color: red;\">Ошибка: ' + error + '</p>');
            }
        });
    });
});


");