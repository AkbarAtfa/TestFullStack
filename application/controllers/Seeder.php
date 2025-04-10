<?php defined('BASEPATH') or exit('No direct script access allowed');
class Seeder extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Role_model');
        $this->load->model('UserRole_model');
    }

    public function index()
    {
        $this->seedUser();
        $this->seedRole();
        $this->seedUserRole();
    }

    public function seedUser()
    {
        $data = [
            'name' => 'akbar',
            'username' => 'akbar1407',
            'password' => password_hash('12345678', PASSWORD_DEFAULT),
        ];
        $this->User_model->input_data($data);
    }

    public function seedRole()
    {
        $roles = ['admin', 'editor', 'user'];
        foreach ($roles as $key) {
            $this->Role_model->input_data([
                'name' => $key
            ]);
        }
    }

    public function seedUserRole()
    {
        $dataUser = $this->User_model->findUsername('akbar1407');
        $dataRole = $this->Role_model->findName('admin');
        $data = [
            'user_id' => $dataUser->id,
            'role_id' => $dataRole->id,
        ];
        $this->UserRole_model->input_data($data);
    }
}
