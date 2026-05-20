<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCountaryTable extends Migration
{
     public function up(){
            $this->forge->addField([
                'id' => [
                        'type'=>'INT',
                        'auto_increment'=>true,
                        'unsigned'=> true,
                ],
                'name'=> [// 
                    'type'=> 'VARCHAR',
                    'constraint'=>100,
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
            $this->forge->addUniqueKey('name');
            $this->forge->createTable('countries');
     }

    public function down()
    {
        //
        $this->forge->dropTable('countries');
    }
}
