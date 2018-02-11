<?php

use yii\db\Migration;

/**
 * Handles the creation of table `seo`.
 */
class m180211_092108_init extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%seo}}', [
            'id' => $this->primaryKey(),
            'entity' => $this->string(255),
            'entity_id' => $this->integer(11)->unsigned()->notNull(),
            'title' => $this->string(255),
            'h1' => $this->string(255),
            'keywords' => $this->text(),
            'description' => $this->text(),
            'seo_text' => $this->text(),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%seo}}');
    }
}
