<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCityTable extends Migration{

     public function up(){
            $this->forge->addField([
                'id' => [
                        'type'=>'INT',
                        'auto_increment'=>true,
                        'unsigned'=> true,
                ],
                'name'=> [
                    'type'=> 'VARCHAR',
                    'constraint'=>100,
                ],
                'state_id'=>[
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
                'state_id',
                'states',
                'id',
                'CASCADE',
                'CASCADE'
                );
            $this->forge->addForeignKey(
                'added_by',
                'users',
                'id',
                'CASCADE',
                'CASCADE'
            );
            $this->forge->createTable('cities');
     }

    public function down()
    {
        //
        $this->forge->dropTable('cities');
    }
}
