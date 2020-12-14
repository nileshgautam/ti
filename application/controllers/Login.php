<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{


	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct()
	{
		parent::__construct();
		// Load session library
		$this->load->library('session');
		// Load Custom model
		$this->load->model('CustomModel');
	}


	public function index()
	{
		$page['title'] =  'Login | ' . BRAND_NAME;
		$this->load->view('login/login', $page);
	}

	// Check for user login process
	public function user_login()
	{
		// print_r($_POST);
		// die;
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$remember_me = $this->input->post('remember_me');
		if (isset($remember_me)) {
			$remember_me = 1;
		} else {
			$remember_me = 0;
		}
		if ($username == "" &&  $password == "") {
			echo json_encode(array('msg' => 'Error! invalid username', 'type' => 'danger'), true);
		} elseif ($username == "") {
			echo json_encode(array('msg' => 'Error! username required', 'type' => 'danger'), true);
		} elseif ($password == '') {
			echo json_encode(array('msg' => 'Error! invalid password', 'type' => 'danger'), true);
		} else {
			$this->load->model('CustomModel');
			$tableName = 'employees';
			$condition = array('username' => $username, 'password' => hash('sha512', $password));
			$result = $this->CustomModel->getAllfromWhere($tableName, $condition);
			if (!$result) {
				// print_r($result);die;
				echo json_encode(array('msg' => 'Warning! username and password invalid', 'type' => 'danger'), true);
			} elseif ($result > 0) {
				$sess_data = array(
					'username' => $username,
					'unmae' => $result[0]['username'],
					'role' => $result[0]['role'],
					'Name' => $result[0]['first_name'],
					'people_id' => $result[0]['people_id'],
					'login' => true,
				);
				$this->session->set_userdata('logged_in', $sess_data);
				echo json_encode(array('msg' => 'true', 'type' => 'success', 'remember_me' => $remember_me, 'role' => $result[0]['role']), true);
			}
		}
	}

	function profile($id = null)
	{
		$tableName = 'employees';
		$condition = array('people_id' => base64_decode($id));
		$page['details'] = $this->CustomModel->getAllfromWhere($tableName, $condition);
		$this->load->view('admin/layout/header');
		$this->load->view('admin/layout/sidebar');
		$this->load->view('template/profile', $page);
		$this->load->view('template/scripts/profile');
		$this->load->view('admin/layout/footer');
	}

	public function changePasswordPost()
	{
		// print_r($_POST);
		$oldpassword = $this->input->post('inputoldPassword');
		$newpassword = $this->input->post('inputNewPassword');

		$password = hash('sha512', $newpassword);
		$oldpassword = hash('sha512', $oldpassword);

		$id = $_SESSION['logged_in']['people_id'];

		$tableName = 'login';

		$condition = array('people_id' => $id, 'password' => $oldpassword);

		$status = $this->CustomModel->getAllfromWhere($tableName, $condition);
		// print_r($status);die;

		if ($status > 0) {
			$res = $this->CustomModel->update_row('login', $condition, array('password' => $password));
			echo $res==true?json_encode(array('message'=>'Password changed','type'=>'success')):json_encode(array('message'=>'Old password did not match','type'=>'error'));
		}else if($status==''){
			echo json_encode(array('message'=>'Old password did not match','type'=>'error'));
		}
	}

	// Logout from admin page
	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url());
	}
}
