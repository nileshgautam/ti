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
		$page['clients'] = $this->CustomModel->getAllfromTable('client_quotation_relation');
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
		// $this->load->view('estimate/create-new');
		$this->load->view('estimate/create-estimate');
		$this->load->view('admin/layout/footer');
	}

	public function generateQuotation()
	{

		$page['header'] =  'Estimate';
		$page['qtype'] = $this->CustomModel->getAllfromWhere('estimate_quotation_type', array('id' => $_POST['quotation']),  'title');

		$condition = array('parent_id' => $_POST['quotation']);

		$page['question'] = $this->CustomModel->getAllfromWhere('estimate_question_master', $condition,  'title');

		$page['qtype'] = $this->CustomModel->getAllfromWhere('estimate_quotation_type', array('id' => $_POST['quotation']),  'title');

		$page['roles'] = $this->CustomModel->getAllfromWhere('estimate_role_master', $condition,  'name');

		$page['country'] = $this->CustomModel->getAllfromTable('countries');
		$page['ogtype'] = $this->CustomModel->getAllfromTable('master_clienttype');

		// $page['clinetDetails'] = $_POST;

		$this->load->view('admin/layout/header');
		$this->load->view('admin/layout/sidebar');
		$this->load->view('estimate/estimate-page', $page);
		$this->load->view('admin/layout/footer');
		$this->load->view('estimate/script/custom-estimate');
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
			$id = $this->MainModel->getNewIDorNo('client_quotation_relation', 'TIRQ');
			$arrData = array(
				'q_id' => $id,
				'quation_type_id' => $_POST['client_data']['qtype'],
				'client_data' => json_encode($_POST['client_data']),
				'data' => json_encode($_POST['quotation']),
				'created_date' => timestamp()
			);
			$res = $this->CustomModel->insert('client_quotation_relation', $arrData);
			// json_encode($res);
			echo $res != '' ? json_encode($res[0],true) : json_encode(array('message' => 'Something went wrong Contact IT', 'type' => 'error'));
		}
	}

	public function editquotation($qid = null, $quotationid = null)
	{
		$res=$this->CustomModel->getAllfromWhere('client_quotation_relation', array('id' => base64_decode($qid)),  'created_date');

		// echo '<pre>';
		// print_r($res);die;

		$page['header'] =  'Dashoard | ' . BRAND_NAME;
		$page['title'] =  ' Edit|Estimate' . BRAND_NAME;
		$page['quotation'] = json_encode($res[0]);
		$this->load->view('admin/layout/header', $page);
		$this->load->view('admin/layout/sidebar');
		$this->load->view('estimate/estimate-page');
		// $this->load->view('estimate/edit-est');
		$this->load->view('estimate/script/edit-est');
		$this->load->view('admin/layout/footer');
	}
}
