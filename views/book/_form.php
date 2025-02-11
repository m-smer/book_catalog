<?php

use app\models\Author;
use app\models\form\BookForm;
use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var BookForm $formModel */
/** @var Author[] $authors */
/** @var yii\widgets\ActiveForm $form */


$initialPreview = [];
$initialPreviewConfig = [];

if (!empty($formModel->existingImages)) {
    foreach ($formModel->existingImages as $image) {
        $initialPreview[] = Yii::$app->request->baseUrl . '/uploads/' . $image->filename;
        $initialPreviewConfig[] = [
            'caption' => $image->filename,
            'url' => Url::toRoute(['image/delete', 'id' => $image->image_id]), // URL для удаления изображения
        ];
    }
}

?>

<div class="book-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($formModel, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($formModel, 'year')->textInput() ?>

    <?= $form->field($formModel, 'isbn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($formModel, 'authorIds')->widget(Select2::class, [
        'data' => ArrayHelper::map($authors, 'author_id', 'full_name'),
        'options' => ['multiple' => true],
        'pluginOptions' => [
            'tags' => true,
            'tokenSeparators' => [',', ' '],
        ],
    ]) ?>

    <?= $form->field($formModel, 'images[]')->widget(FileInput::class, [
        'options' => [
            'multiple' => false,
            'accept' => 'image/*',
        ],
        'pluginOptions' => [
            'showPreview' => true,
            'showCaption' => false,
            'showRemove' => true,
            'showUpload' => false,
            'browseClass' => 'btn btn-primary',
            'initialPreview' => $initialPreview,
            'initialPreviewAsData' => true,
            'initialPreviewConfig' => $initialPreviewConfig,
            'overwriteInitial' => false,
            'previewSettings' => [
                'image' => ['width' => '100px', 'height' => '100px'],
            ],
        ]
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
