<?php

use yii\db\Migration;

/**
 * Handles the creation of table `categories_lang`.
 */
class m180325_175234_create_categories_lang_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('categories_lang', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'language' => $this->string(2)->notNull(),
            'name' => $this->string()->notNull(),
            'description' => $this->text()->notNull(),

        ]);

        $this->createIndex(
            'idx-categories_lang-category_id',
            'categories_lang',
            'category_id'
        );
        $this->addForeignKey(
            'fk-categories_lang-category_id',
            'categories_lang',
            'category_id',
            'categories',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-categories_lang-language',
            'categories_lang',
            'language'
        );
        $this->addForeignKey(
            'fk-categories_lang-language',
            'categories_lang',
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
            'fk-categories_lang-category_id',
            'categories_lang'
        );
        $this->dropIndex(
            'idx-categories_lang-category_id',
            'categories_lang'
        );

        $this->dropForeignKey(
            'fk-categories_lang-language',
            'categories_lang'
        );
        $this->dropIndex(
            'idx-categories_lang-language',
            'categories_lang'
        );

        $this->dropTable('categories_lang');
    }
}
