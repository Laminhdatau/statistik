<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('M_auth');
	}

	public function index()
	{
		$this->form_validation->set_rules('username', 'Username', 'required|trim');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');
		if ($this->form_validation->run() == false) {
			$this->load->view('v_login'); 
		} else {
			$this->_login();
		}
	}

	private function _login()
	{
		$username = $this->input->post('username', true);
    $password = $this->input->post('password', true);
    $data = $this->M_auth->cek_user($username, $password);
    if ($data['user'] == FALSE) {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Username yang anda masukkan tidak ditemukan!</div>');
      redirect('login');
		} else if ($data['pass'] == FALSE){
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password yang anda masukkan tidak cocok!</div>');
      redirect('login');
		} else {
			$sess['user'] = $data['user'];
			$this->session->set_userdata($sess);
			redirect('home');
		}

	}

	public function logout()
    {
			$this->session->unset_userdata('user');
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Anda keluar aplikasi!</div>');
		// $this->session->sess_destroy();
        redirect('login');
    }
}
