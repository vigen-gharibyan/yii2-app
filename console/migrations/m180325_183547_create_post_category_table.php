<?php

use yii\db\Migration;

/**
 * Handles the creation of table `post_category`.
 */
class m180325_183547_create_post_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('post_category', [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-post_category-post_id',
            'post_category',
            'post_id'
        );
        $this->addForeignKey(
            'fk-post_category-post_id',
            'post_category',
            'post_id',
            'posts',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-post_category-category_id',
            'post_category',
            'category_id'
        );
        $this->addForeignKey(
            'fk-post_category-category_id',
            'post_category',
            'category_id',
            'categories',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey(
            'fk-post_category-post_id',
            'post_category'
        );
        $this->dropIndex(
            'idx-post_category-post_id',
            'post_category'
        );

        $this->dropForeignKey(
            'fk-post_category-category_id',
            'post_category'
        );
        $this->dropIndex(
            'idx-post_category-category_id',
            'post_category'
        );

        $this->dropTable('post_category');
    }
}
