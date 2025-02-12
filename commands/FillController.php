<?php

namespace app\commands;

use app\models\Author;
use app\models\Book;
use app\models\User;
use Yii;
use yii\console\Controller;
use function PHPUnit\Framework\isInt;

class FillController extends Controller
{
    private $faker;
    const AUTHORS_NUM = 30;
    const BOOKS_NUM = 300;

    public function init ()
    {
        $this->faker = \Faker\Factory::create();
    }
    public function actionIndex() {

        User::deleteAll();
        Book::deleteAll();
        Author::deleteAll();

        $users = [];
        for ($i = 0; $i < 3; $i++) {
            $users[$i] = new User([
                'full_name' => $this->faker->name(),
                'phone_number' => $i + 1,
                'auth_key' => \Yii::$app->security->generateRandomString(),
            ]);
            if (!$users[$i]->save()) {
                $this->stdout(var_export($users[$i]->getErrors(), 1) . PHP_EOL);
            };
        }

        $authors = [];
        for ($i = 1; $i <=self::AUTHORS_NUM; $i++) {
            $authors[$i] = new Author([
                'full_name' => $this->faker->name(),
            ]);
            if (!$authors[$i]->save()) {
                $this->stdout(var_export($authors[$i]->getErrors(), 1) . PHP_EOL);
            };
        }

        for ($i = 1; $i <= self::BOOKS_NUM; $i++) {
            $book = new Book([
                'title' => $this->faker->name(),
                'year' => $i,
                'isbn' => $this->faker->isbn13(),
            ]);

            if (!$book->save()) {
                $this->stdout(var_export($book->getErrors(), 1) . PHP_EOL);
            };

            $authorsIndexes = array_rand($authors, rand( 1, 5));
            if (is_int($authorsIndexes)) {
                $authorsIndexes = [$authorsIndexes];
            }
            foreach ($authorsIndexes as $index) {
                $book->link('authors', $authors[$index]);
            }
        }
    }

}