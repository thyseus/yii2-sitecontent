<?php

use yii\db\Migration;

class m170213_084019_add_metatags_columns_to_sitecontent extends Migration
{
    public function up()
    {
        $this->addColumn('sitecontent', 'meta_title', $this->string());
        $this->addColumn('sitecontent', 'meta_description', $this->string());
        $this->addColumn('sitecontent', 'meta_keywords', $this->string());
    }

    public function down()
    {
        $this->dropColumn('sitecontent', 'meta_title');
        $this->dropColumn('sitecontent', 'meta_description');
        $this->dropColumn('sitecontent', 'meta_keywords');
    }
}
