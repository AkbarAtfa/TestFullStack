<?php

class UserRole_model extends CI_Model
{
    private $_table = "user_role";

    public $user_id;
    public $role_id;

    function __construct()
    {
        $this->load->database();
    }

    function tampil_data()
    {
        return $this->db->get($this->_table);
    }

    function getRoleUser(int $userId)
    {
        $this->db->where('user_id', $userId);
        $this->db->join('role', 'role.id = user_role.role_id');
        $query = $this->db->get($this->_table)->result();
        return $query;
    }

    function refreshRole()
    {
        $userId = $this->session->get_userdata()['user_id'];
        $getRoleUser = $this->getRoleUser($userId);
        $getAllNameRoleUser = [];
        foreach ($getRoleUser as $key => $value) {
            $getAllNameRoleUser[] = $value->name;
        }
        $this->session->set_userdata([
            'roles' => $getAllNameRoleUser
        ]);
    }

    function input_data($data)
    {
        $this->db->insert($this->_table, $data);
    }

    function update($id, $data)
    {
        $check = $this->getRoleUser($id);
        if (count($check) > 0) {
            $this->db->where('user_id', $id)->update($this->_table, $data);
        } else {
            $data['user_id'] = $id;
            $this->input_data($data);
        }
    }
}
