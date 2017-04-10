<?php

use yii\db\Migration;

class m170408_074642_new_column_document_name_table_ticket_file extends Migration
{
    public function up()
    {
        $this->addColumn('{{%ticket_file}}','document_name','string');

    }

    public function down()
    {
        $this->dropColumn('document_name', '{{%ticket_file}}','document_name');
    }

}
