<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'password' => [
                'type' => 'TEXT',
            ]
        ]);

        $this->forge->addUniqueKey('email');
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('users' );
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
