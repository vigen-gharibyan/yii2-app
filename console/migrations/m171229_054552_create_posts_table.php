<?php

use yii\db\Migration;

/**
 * Handles the creation for table `posts`.
 * Has foreign key to the table:
 *
 * - `user`
 */
class m171229_054552_create_posts_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('posts', [
            'id' => $this->primaryKey(),
            'created_by' => $this->integer()->notNull(),
            'enabled' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        // creates index for column `created_by`
        $this->createIndex(
            'idx-posts-created_by',
            'posts',
            'created_by'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-posts-created_by',
            'posts',
            'created_by',
            'users',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-posts-created_by',
            'posts'
        );

        // drops index for column `created_by`
        $this->dropIndex(
            'idx-posts-created_by',
            'posts'
        );

        $this->dropTable('posts');
    }
}
