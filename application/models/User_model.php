<?php

class User_model extends CI_Model
{
    private $_table = "user";

    const SESSION_KEY = 'user_id';

    public $name;
    public $username;
    public $password;

    function __construct()
    {
        $this->load->database();
    }

    function tampil_data()
    {
        return $this->db->get($this->_table);
    }

    public function findUsername(string $username)
    {
        $this->db->where('username', $username);
        $query = $this->db->get($this->_table);
        $user = $query->row();
        return $user;
    }

    function input_data($data)
    {
        $this->db->insert($this->_table, $data);
    }

    function is_username_unique($username, $exclude_id = null)
    {
        $this->db->where('username', $username);
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        return $this->db->get($this->_table)->num_rows() === 0;
    }

    function get_by_id($id)
    {
        return $this->db->select('name,username,id,photo')->get_where($this->_table, ['id' => $id])->row();
    }

    function update($id, $data)
    {
        $this->db->where('id', $id)->update($this->_table, $data);
    }

    function delete($id)
    {
        $this->db->where('id', $id)->delete($this->_table);
    }

    public function login($username, $password)
    {
        $user = $this->findUsername($username);
        // cek apakah user sudah terdaftar?
        if (!$user) {
            return FALSE;
        }

        // cek apakah password-nya benar?
        if (!password_verify($password, $user->password)) {
            return FALSE;
        }

        // bikin session
        $this->session->set_userdata([self::SESSION_KEY => $user->id]);

        return $this->session->has_userdata(self::SESSION_KEY);
    }

    var $column_order = ['username', 'name', null]; // kolom buat sorting
    var $column_search = ['username', 'name']; // kolom buat search
    var $order = ['id' => 'asc'];

    private function _get_datatables_query()
    {
        $this->db->from($this->_table);

        $i = 0;
        foreach ($this->column_search as $item) {
            if ($_GET['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_GET['search']['value']);
                } else {
                    $this->db->or_like($item, $_GET['search']['value']);
                }

                if (count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if (isset($_GET['order'])) {
            $this->db->order_by($this->column_order[$_GET['order']['0']['column']], $_GET['order']['0']['dir']);
        } else if ($this->order) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_GET['length'] != -1) {
            $this->db->limit($_GET['length'], $_GET['start']);
        }
        return $this->db->get()->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        return $this->db->count_all_results();
    }

    function count_all()
    {
        $this->db->from($this->_table);
        return $this->db->count_all_results();
    }
}
