<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * @author Herbert Maschke <thyseus@gmail.com
 */
class m161109_084412_init_sitecontent extends Migration
{
    public function up()
    {
        $tableOptions = '';

        if (Yii::$app->db->driverName == 'mysql')
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%sitecontent}}', [
            'id'                   => Schema::TYPE_PK,
            'parent'               => Schema::TYPE_INTEGER,
            'created_by'           => Schema::TYPE_INTEGER,
            'updated_by'           => Schema::TYPE_INTEGER,
            'language'             => Schema::TYPE_STRING . '(5)',
            'position'             => Schema::TYPE_INTEGER,
            'status'               => Schema::TYPE_INTEGER,
            'slug'                 => Schema::TYPE_STRING . '(255) NOT NULL',
            'title'                => Schema::TYPE_STRING . '(255) NOT NULL',
            'content'              => Schema::TYPE_TEXT,
            'created_at'           => Schema::TYPE_DATETIME,
            'updated_at'           => Schema::TYPE_DATETIME,
            'views'                => Schema::TYPE_INTEGER,
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%sitecontent}}');
    }
}
