<?php

use yii\db\Migration;

/**
 * Handles the creation for table `ticket_file_table`.
 */
class m160719_002353_create_ticket_file_table extends Migration
{

    private $table = '{{%ticket_file}}';
    private $ticket_body = '{{%ticket_body}}';
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        
        if ($this->db->driverName == 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'id_body' => $this->integer()->notNull(),
            'fileName' => $this->string(255)->notNull(),
        ], $tableOptions);
        
        $this->createIndex('i_id_body', $this->table, 'id_body');
        $this->addForeignKey('fk_id_body', $this->table, 'id_body', $this->ticket_body, 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk_id_body', $this->table);
        $this->dropTable($this->table);
    }
}
