<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{// when run it will create the users table in the database
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true,
                'unsigned' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'email' => [
                'type' => "VARCHAR",
                'constraint' => 100, 
            ],
            'password' => [
                'type' => "VARCHAR",
                'constraint' => 100,  
            ],
            'address' => [
                'type' => "TEXT",
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]) ;
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('email');
        $this->forge->createTable('users');


    }

    public function down()
    {
        //when it run it will drop what you added in the up function
        $this->forge->dropTable('users');
    }
}
