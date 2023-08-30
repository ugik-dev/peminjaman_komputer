<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserController extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('UserModel'));
		$this->load->helper(array('DataStructure', 'Validation'));
		$this->db->db_debug = false;
	}

	public function index()
	{
		redirect('login');
	}

	public function login()
	{
		$this->SecurityModel->guestOnlyGuard();
		$pageData = array(
			'title' => 'Masuk',
		);

		$this->load->view('LoginPage', $pageData);
	}

	public function loginProcess()
	{
		try {
			// $this->SecurityModel->guestOnlyGuard(TRUE);
			Validation::ajaxValidateForm($this->SecurityModel->loginValidation());

			$loginData = $this->input->post();

			$user = $this->UserModel->login($loginData);

			$this->session->set_userdata($user);
			echo json_encode(array("error" => FALSE, "user" => $user));
		} catch (Exception $e) {
			ExceptionHandler::handle($e);
		}
	}

	public function changePassword()
	{
		try {
			$this->SecurityModel->userOnlyGuard(TRUE);
			// $this->SecurityModel->pengusulSubTypeGuard(['dosen_tendik'], TRUE);
			// Validation::ajaxValidateForm($this->SecurityModel->deleteDosenTendik());

			$CP = $this->input->post();
			if (md5($CP['old_password']) != $this->session->userdata('password')) {
				throw new UserException('Password Lama Salah', 0);
			}
			$this->UserModel->changePassword($CP);
			$this->session->set_userdata('password', md5($CP['password']));
			echo json_encode(array());
		} catch (Exception $e) {
			ExceptionHandler::handle($e);
		}
	}
	public function editUser()
	{
		try {
			$this->SecurityModel->userOnlyGuard(TRUE);
			// $this->SecurityModel->pengusulSubTypeGuard(['dosen_tendik'], TRUE);
			// Validation::ajaxValidateForm($this->SecurityModel->deleteDosenTendik());

			$data = $this->input->post();
			if (md5($data['password']) != $this->session->userdata('password')) {
				throw new UserException('Pasword Salah!', 0);
			} else {
				$result = $this->UserModel->editUser($data);
				$this->session->set_userdata('username', $result['username']);
				$this->session->set_userdata('nama', $result['nama']);
			}
			//$this->UserModel->changePassword($CP);

			echo json_encode($result);
		} catch (Exception $e) {
			ExceptionHandler::handle($e);
		}
	}

	public function logout()
	{
		// $this->SecurityModel->userOnlyGuard();
		$this->session->sess_destroy();
		echo json_encode(["error" => FALSE, 'data' => 'Logout berhasil.']);
	}

	function editPhoto()
	{
		try {
			$this->SecurityModel->userOnlyGuard(TRUE);
			$config['upload_path'] = "./upload/profile";
			$config['allowed_types'] = 'jpg|png';
			$config['encrypt_name'] = TRUE;


			$this->load->library('upload', $config);
			if ($this->upload->do_upload("photo")) {
				$data = array('upload_data' => $this->upload->data());
				$id = $this->input->post('id_user');
				$image = $data['upload_data']['file_name'];
				$fileold = $this->input->post('oldphoto');
				if ($fileold != 'profile_small.jpg') {
					unlink("./upload/profile/" . $fileold);
				};
				$result = $this->UserModel->editPhoto($id, $image);
				$this->session->set_userdata('photo', $image);
				echo json_decode($result);
			}


			echo json_encode(array());
		} catch (Exception $e) {
			ExceptionHandler::handle($e);
		}
	}
}
