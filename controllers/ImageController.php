<?php

namespace app\controllers;

use app\models\Image;
use yii\web\Controller;

class ImageController extends Controller
{

    public function actionDelete($id)
    {
        $image = Image::findOne($id);
        if (!$image) {
            return false;
        }

        $filePath = \Yii::getAlias('@webroot/uploads/' . $image->filename);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $image->delete();

        return true;
    }
}