<?php

class Role_model extends CI_Model
{
    private $_table = "role";

    public $name;

    function __construct()
    {
        $this->load->database();
    }

    function findName(string $name)
    {
        $this->db->where('name', $name);
        $query = $this->db->get($this->_table);
        $data = $query->row();
        return $data;
    }

    function tampil_data()
    {
        return $this->db->get($this->_table)->result();
    }

    function input_data($data)
    {
        $this->db->insert($this->_table, $data);
    }
}
