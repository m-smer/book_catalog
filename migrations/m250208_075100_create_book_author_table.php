<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%book_author}}`.
 */
class m250208_075100_create_book_author_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%book_author}}', [
            'book_author_id' => $this->primaryKey(),
            'book_id' => $this->integer(),
            'author_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-book_author-book_id',
            'book_author',
            'book_id',
            'book',
            'book_id',
            'RESTRICT',
        );

        $this->addForeignKey(
            'fk-book_author-author_id',
            'book_author',
            'author_id',
            'author',
            'author_id',
            'RESTRICT'
        );

        $this->createIndex(
            'idx-book_author-unique',
            'book_author',
            ['book_id', 'author_id'],
            true);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-book_author-unique', 'book_author');
        $this->dropForeignKey('fk-book_author-book_id', 'book_author');
        $this->dropForeignKey('fk-book_author-author_id', 'book_author');
        $this->dropTable('{{%book_author}}');
    }
}
