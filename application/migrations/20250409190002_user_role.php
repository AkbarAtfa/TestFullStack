<?php defined('BASEPATH') or exit('No direct script access allowed');
class Migration_User_role extends CI_Migration
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
            'user_id' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
            ),
            'role_id' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
            ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('user_role');
        $this->dbforge->add_column('user_role', [
            'CONSTRAINT user_id FOREIGN KEY(user_id) REFERENCES user(id)',
        ]);
        $this->dbforge->add_column('user_role', [
            'CONSTRAINT role_id FOREIGN KEY(role_id) REFERENCES role(id)',
        ]);
    }

    public function down()
    {
        $this->dbforge->drop_table('user_role');
    }
}
