<?php

use yii\db\Migration;

/**
 * Handles the creation for table `ticket_head_table`.
 */
class m160618_215837_create_ticket_head_table extends Migration
{
    private $table = 'ticket_head';
    
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable($this->table, [
            'id'          => $this->primaryKey(),
            'user_id'     => $this->integer()->unsigned(),
            'department'  => $this->string(255),
            'topic'       => $this->string(255),
            'status'      => $this->integer(1)->defaultValue('0')->unsigned(),
            'date_update' => $this->timestamp()->defaultValue(null),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable($this->table);
    }
}
