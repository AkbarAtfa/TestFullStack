<?php
defined('BASEPATH') or exit('No direct script access allowed');

class loginController extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('User_model');
		$this->load->model('UserRole_model');
		$this->load->helper('captcha');
	}

	public function index()
	{
		// $vals = array(
		// 	'img_path'      => './captcha/',
		// 	'img_url'       => base_url('captcha'),
		// 	'img_width'     => '150',
		// 	'img_height'    => 30,
		// 	'expiration'    => 7200,
		// 	// White background and border, black text and red grid
		// 	'colors'        => array(
		// 		'background' => array(255, 255, 255),
		// 		'border' => array(255, 255, 255),
		// 		'text' => array(0, 0, 0),
		// 		'grid' => array(255, 40, 40)
		// 	)
		// );

		// $cap = create_captcha($vals);
		// var_dump($cap);
		return $this->load->view('loginView', [
			'captcha' => ''
		]);
	}

	public function login()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		if ($this->User_model->login($username, $password)) {
			$this->UserRole_model->refreshRole();
			redirect('home');
		}
		$this->session->set_flashdata('message_login_error', 'Login Gagal, pastikan username dan password benar!');
		redirect(base_url());
	}

	public function logout()
	{
		// Hapus semua data session
		$this->session->sess_destroy();
		redirect('');
	}
}
