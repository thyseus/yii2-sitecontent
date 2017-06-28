<?php

use yii\db\Migration;

class m170727_140001_improve_primary_key extends Migration
{
    /**
     * We want so have an composite primary key so languages can be linked together
     */
    public function up()
    {
        $this->alterColumn('sitecontent', 'id', 'int(11) UNSIGNED NOT NULL');

        $this->dropPrimaryKey('id', 'sitecontent');

        $this->addPrimaryKey('id', 'sitecontent', ['id', 'language']);
    }

    public function down()
    {
    }
}
