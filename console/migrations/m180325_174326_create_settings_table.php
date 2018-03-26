<?php

use yii\db\Migration;

/**
 * Handles the creation of table `settings`.
 */
class m180325_174326_create_settings_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('settings', [
            'id' => $this->primaryKey(),
            'key' => $this->string(50)->notNull()->unique(),
            'value' => $this->string()->notNull()->unique(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('settings');
    }
}
