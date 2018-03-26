<?php

use yii\db\Migration;

/**
 * Handles the creation of table `posts_lang`.
 */
class m180325_182753_create_posts_lang_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('posts_lang', [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer()->notNull(),
            'language' => $this->string(2)->notNull(),
            'title' => $this->string()->notNull(),
            'content' => $this->text()->notNull(),
        ]);

        $this->createIndex(
            'idx-posts_lang-post_id',
            'posts_lang',
            'post_id'
        );
        $this->addForeignKey(
            'fk-posts_lang-post_id',
            'posts_lang',
            'post_id',
            'posts',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-posts_lang-language',
            'posts_lang',
            'language'
        );
        $this->addForeignKey(
            'fk-posts_lang-language',
            'posts_lang',
            'language',
            'languages',
            'code',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey(
            'fk-posts_lang-post_id',
            'posts_lang'
        );
        $this->dropIndex(
            'idx-posts_lang-post_id',
            'posts_lang'
        );

        $this->dropForeignKey(
            'fk-posts_lang-language',
            'posts_lang'
        );
        $this->dropIndex(
            'idx-posts_lang-language',
            'posts_lang'
        );

        $this->dropTable('posts_lang');
    }
}
