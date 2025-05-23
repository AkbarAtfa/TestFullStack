<?php defined('BASEPATH') or exit('No direct script access allowed');
class Migration_User extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100'
            ),
            'username' => array(
                'type' => 'VARCHAR',
                'constraint' => '100'
            ),
            'photo' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => TRUE, // Nullable
            ),
            'password' => array(
                'type' => 'VARCHAR',
                'constraint' => '100'
            ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('user');
    }

    public function down()
    {
        $this->dbforge->drop_table('user');
    }
}
