<?php

namespace app\controllers;

use app\models\Image;
use yii\web\Controller;

class ImageController extends Controller
{

    public function actionDelete($id)
    {
        $image = Image::findOne($id);

        if (!$image || $image->delete()) {
            return false;
        }

        return true;
    }
}