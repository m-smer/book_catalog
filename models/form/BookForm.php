<?php

namespace app\models\form;

use app\models\Book;
use app\models\Image;
use yii\base\Model;

class BookForm extends Model
{
    public $title;
    public $year;
    public $isbn;
    public $images;
    public array $existingImages = [];

    public array $authorIds = [];

    public function rules()
    {
        return [
            [['title', 'year', 'isbn'], 'required'],
            [['year'], 'integer', 'max' => date('Y')],
            [['title', 'isbn'], 'string', 'max' => 255],
            ['authorIds', 'each', 'rule' => ['integer']],
            ['authorIds', 'required'],
            [['images'], 'file', 'skipOnEmpty' => true, 'maxFiles' => 1], // До 10 файлов
        ];

    }

    public function uploadImages($bookId): bool
    {
        if ($this->validate()) {
            foreach ($this->images as $file) {

                $filename = uniqid() . '.' . $file->extension;

                // Сохранение файла на сервере
                $uploadPath = \Yii::getAlias('@webroot/uploads/' . $filename);
                if ($file->saveAs($uploadPath)) {

                    $image = new Image();
                    $image->filename = $filename;
                    $image->extension = $file->extension;
                    $image->owner_type = 'book'; // Тип владельца
                    $image->owner_id = $bookId; // ID книги

                    if (!$image->save()) {
                        return false;
                    }
                } else {
                    return false;
                }
            }
            return true;
        }
        return false;
    }
}