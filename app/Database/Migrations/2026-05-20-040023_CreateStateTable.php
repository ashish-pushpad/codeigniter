<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStateTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                    'type'=>'INT',
                    'auto_increment'=>true,
                    'unsigned'=> true,
            ],
            'state'=> [
                'type'=> 'VARCHAR',
                'constraint'=>100,
            ],
            'country_id'=> [
                'type'=>'INT',
                'unsigned'=>true
            ],
            'added_by'=>[
                'type'=>'INT',
                'default'=>1,
                'unsigned'=>true,
            ],
            'created_at'=>[
                'type'=>'DATETIME',
                'null'=> true,
            ],
            'updated_at'=>[
                'type'=>'DATETIME',
                'null'=> true
            ]
        ]);
        
        $this->forge->addKey('id',true);
        $this->forge->addForeignKey(
            'added_by',
            'users',
            'id'
        );
        $this->forge->addForeignKey(
            'country_id',
            'countries',
            'id'
        );


        $this->forge->createTable('states');
    }

    public function down()
    {
        //
        $this->forge->dropTable('states');
    }
}
