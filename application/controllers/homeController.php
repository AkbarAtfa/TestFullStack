<?php
defined('BASEPATH') or exit('No direct script access allowed');

class homeController extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('User_model');
		$this->load->model('Role_model');
		$this->load->model('UserRole_model');
		if (!$this->session->has_userdata('user_id')) {
			redirect(base_url());
		}
	}

	public function index()
	{
		$data['role'] = $this->Role_model->tampil_data();  // Assuming your roles table is 'roles'
		return $this->load->view('homeView', $data);
	}

	public function get_users()
	{
		$list = $this->User_model->get_datatables();
		$data = [];
		$no = $_GET['start'];

		$listRole = $this->session->get_userdata()['roles'];
		foreach ($list as $user) {
			$accessButtonByRole = '';
			if (in_array('admin', $listRole)) {
				$accessButtonByRole = '<button class="editBtn" data-id="' . $user->id . '">Edit</button>
				 <button class="deleteBtn" data-id="' . $user->id . '">Hapus</button>';
			}
			if (in_array('editor', $listRole)) {
				$accessButtonByRole = '<button class="editBtn" data-id="' . $user->id . '">Edit</button>';
			}

			$no++;
			$row = [];
			$row[] = $no;
			$row[] = $user->username;
			$row[] = $user->name;
			$row[] = $accessButtonByRole; // contoh action
			$data[] = $row;
		}

		$output = [
			"draw" => $_GET['draw'],
			"recordsTotal" => $this->User_model->count_all(),
			"recordsFiltered" => $this->User_model->count_filtered(),
			"data" => $data,
		];

		echo json_encode($output);
	}

	public function get_user($id)
	{
		$this->load->model('User_model');
		$user = $this->User_model->get_by_id($id);
		$checkRole = $this->UserRole_model->getRoleUser($id);
		if (count($checkRole) > 0) {
			$user->role_id = $checkRole[0]->role_id;
		}
		echo json_encode($user);
	}

	// CREATE (POST)
	public function create()
	{
		$this->load->model('User_model');
		$username = $this->input->post('username');
		$name     = $this->input->post('name');
		$password = $this->input->post('password');
		$role_id = $this->input->post('role_id');

		if (!$this->User_model->is_username_unique($username)) {
			return $this->output
				->set_status_header(400)
				->set_output(json_encode(['status' => 'error', 'message' => 'Username sudah digunakan!']));
		}
		$data = [
			'username' => $username,
			'name'     => $name,
			'password' => password_hash($password, PASSWORD_DEFAULT)
		];
		$this->User_model->input_data($data);

		$user_id = $this->User_model->findUsername($username)->id;  // Get the ID of the newly created user
		// Save the user-role relationship
		$user_role_data = [
			'user_id' => $user_id,
			'role_id' => $role_id
		];
		$this->UserRole_model->input_data($user_role_data);
		echo json_encode(['status' => 'created']);
	}

	// UPDATE (PUT)
	public function update($id)
	{
		parse_str(file_get_contents("php://input"), $put);
		$data = [
			'username' => $put['username'],
			'name'     => $put['name'],
		];
		$role_id = $put['role_id'];

		if (!empty($put['password'])) {
			$data['password'] = password_hash($put['password'], PASSWORD_DEFAULT);
		}

		$this->UserRole_model->update($id, [
			'role_id' => $role_id
		]);

		$this->load->model('User_model');
		$this->User_model->update($id, $data);
		echo json_encode(['status' => 'updated']);
	}

	// DELETE (DELETE)
	public function delete($id)
	{
		if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
			$this->load->model('User_model');
			$this->User_model->delete($id);
			echo json_encode(['status' => 'deleted']);
		}
	}

	public function my_profile()
	{
		$user_id = $this->session->get_userdata()['user_id'];
		$data['user'] = $this->User_model->get_by_id($user_id);
		$this->load->view('profileView', $data);
	}

	public function update_my_profile()
	{
		$this->load->library('form_validation');
		$user_id = $this->session->get_userdata()['user_id'];

		$this->form_validation->set_rules('name', 'Nama', 'required');

		if ($this->form_validation->run() == FALSE) {
			$data['user'] = $this->User_model->get_by_id($user_id);
			redirect('profile');
		} else {
			$data = ['name' => $this->input->post('name')];
			if (!empty($_FILES['photo']['name'])) {
				$config['upload_path'] = './uploads/profile/';
				$config['allowed_types'] = 'jpg|jpeg|png';
				$config['file_name'] = 'user_' . $user_id . '_' . time();
				$config['overwrite'] = true;

				$this->load->library('upload', $config);
				if ($this->upload->do_upload('photo')) {
					$upload = $this->upload->data();
					$data['photo'] = 'uploads/profile/' . $upload['file_name'];
				} else {
					$this->session->set_flashdata('error', $this->upload->display_errors());
					return redirect('profile');
				}
			}
			$this->User_model->update($user_id, $data);
			$this->session->set_flashdata('success', 'Profil berhasil diperbarui!');
			redirect('profile');
		}
	}
}
