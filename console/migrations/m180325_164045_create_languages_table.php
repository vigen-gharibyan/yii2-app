<?php

use yii\db\Migration;

/**
 * Handles the creation of table `languages`.
 */
class m180325_164045_create_languages_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('languages', [
            'id' => $this->primaryKey(),
            'code' => $this->string(2)->notNull()->unique(),
            'local' => $this->string(10)->notNull()->unique(),
            'name' => $this->string(50)->notNull()->unique(),
            'flag' => $this->string()->notNull(),
            'default' => $this->smallInteger()->notNull()->defaultValue(0),

            'enabled' => $this->smallInteger()->notNull()->defaultValue(1),
            'order' => $this->integer()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('languages');
    }
}
