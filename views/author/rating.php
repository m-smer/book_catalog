<?php

use app\models\Author;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var array $authors */

$this->title = 'Authors TOP 10';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="author-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <table class="table table-striped table-bordered">
        <thead>
            <th>Автор</th>
            <th>Кол-во книг</th>
        </thead>
        <tbody>
            <?php foreach ($authors as $author): ?>
                <tr>
                    <td><?= $author['full_name'] ?></td>
                    <td><?= $author['books_count'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>
