<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%image}}`.
 */
class m250208_073231_create_image_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%image}}', [
            'image_id' => $this->primaryKey(),
            'filename' => $this->string()->notNull()->unique(),
            'extension' => $this->string()->notNull(),

            /*
                Можно сделать enum, но с ним могут возникнуть сложности.
                Или int, если, например, сильно экономим ресурсы
            */
            'owner_type' => $this->string()->notNull(),
            'owner_id' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%image}}');
    }
}
