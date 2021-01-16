<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Estimate extends CI_Controller
{
	private static $userId;
	public function __construct()
	{
		parent::__construct();
		// Load Custom model
		$this->load->model('CustomModel');
		$this->load->model('MainModel');
		$this->load->model('EstimateModel');
		$this->load->helper('validate');
		$this->load->library("report");
		if (!isset($_SESSION['logged_in'])) {
			redirect('Login');
		}
		Estimate::$userId = $_SESSION['logged_in']['people_id'];
	}

	public function index()
	{
		$page['clients'] = $this->EstimateModel->getAllClinets();
		$page['header'] =  'Dashoard | ' . BRAND_NAME;
		$page['title'] =  'Estimate | ' . BRAND_NAME;
		$this->load->view('admin/layout/header', $page);
		$this->load->view('admin/layout/sidebar');
		$this->load->view('estimate/index');
		$this->load->view('estimate/script/index');
		$this->load->view('admin/layout/footer');
	}

	public function create()
	{
		$page['header'] =  'Dashoard | ' . BRAND_NAME;
		$page['title'] =  'Estimate | ' . BRAND_NAME;
		$page['country'] = $this->CustomModel->getAllfromTable('countries');
		$page['ogtype'] = $this->CustomModel->getAllfromTable('master_clienttype');
		$page['quotation_Type'] = $this->CustomModel->getAllfromTable('estimate_quotation_type');
		$this->load->view('admin/layout/header', $page);
		$this->load->view('admin/layout/sidebar');
		$this->load->view('estimate/create-new');
		$this->load->view('admin/layout/footer');
	}

	public function insert()
	{
		if ($_POST) {
			$id = $this->MainModel->getNewIDorNo('estimate_clients', 'CLID');
			$clinetData = array(
				'client_id' => $id,
				'name' => $_POST['org-name'],
				'gst' => $_POST['gst-vat'],
				'phone' => $_POST['c-phone'],
				'mobile' => $_POST['c-mobile'],
				'email' => $_POST['c-email'],
				'country' => $_POST['c-country'],
				'pin' => $_POST['c-pin-zip'],
				'org_type' => $_POST['og-type'],
				'quotation_type_id' => $_POST['quotation'],
				'created_at' => timestamp(),
			);

			$isAvailble = $this->CustomModel->getAllfromWhere('estimate_clients', array('email' => $_POST['c-email']));
			$page = [];
			$page['id'] = $id;
			$page['title'] =  '';
			$page['header'] =  'Estimate';
			$condition = array('parent_id' => $_POST['quotation']);
			$page['question'] = $this->CustomModel->getAllfromWhere('estimate_question_master', $condition,  'title');
			$page['qtype'] = $this->CustomModel->getAllfromWhere('estimate_quotation_type', array('id' => $_POST['quotation']),  'title');
			$page['roles'] = $this->CustomModel->getAllfromWhere('estimate_role_master', $condition,  'name');

			if ($isAvailble == false) {
				$res = $this->CustomModel->insert('estimate_clients', $clinetData);
				if ($res) {
					$page['clinetDetails'] = $_POST;
					$this->load->view('admin/layout/header',);
					$this->load->view('admin/layout/sidebar');
					$this->load->view('estimate/estimate-page', $page);
					$this->load->view('admin/layout/footer');
					$this->load->view('estimate/script/custom-estimate');
				}
			} else {
				$messge = array('message' => 'Email already exit');
				$this->session->set_flashdata('error', $messge);
				redirect(__CLASS__ . '/create');
			}
		}
	}

	function insertNewQuatation()
	{
		if ($_POST) {
			// echo '<pre>';
			// print_r($_POST);
			// die;
			$arrData = array(
				'quation_type_id' => $_POST['qttype'],
				'client_id' => $_POST['client'],
				'data' => json_encode($_POST),
				'created_date' => timestamp(),
			);
			// $condition = array('client_id' => $_POST['clinet'], 'quation_type_id' => $_POST['qttype']);
			// $isAvaible = $this->CustomModel->getAllfromWhere('client_quotation_relation', $condition,  'client_id');

			$res = $this->CustomModel->insert('client_quotation_relation', $arrData);
			// print_r($res);
			// die;
			echo $res === 1 ? json_encode(array('message' => 'Save into the databse', 'type' => 'success')) : json_encode(array('message' => 'Something went wrong Contact IT', 'type' => 'error'));


			// if ($isAvaible > 0) {
			// 	$res = $this->CustomModel->insert('client_quotation_relation', $arrData);
			// 	echo $res === 1 ? json_encode(array('message' => 'Save into the databse', 'type' => 'success')) : json_encode(array('message' => 'Something went wrong Contact IT', 'type' => 'error'));
			// } else {
			// 	$res = $this->CustomModel->insert('client_quotation_relation', $arrData);
			// 	echo $res === 1 ? json_encode(array('message' => 'Save into the databse', 'type' => 'success')) : json_encode(array('message' => 'Something went wrong Contact IT', 'type' => 'error'));
			// }
		}
	}
}
