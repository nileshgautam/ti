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
		$this->load->helper('validate');
		$this->load->library("report");
		if (!isset($_SESSION['logged_in'])) {
			redirect('Login');
		}
		Estimate::$userId = $_SESSION['logged_in']['people_id'];
	}

	public function index()
	{
		$page['projects'] = $this->report->project_task_reports(Estimate::$userId);
		$page['header'] =  'Dashoard | ' . BRAND_NAME;
		$page['title'] =  'Estimate | ' . BRAND_NAME;
		$this->load->view('admin/layout/header', $page);
		$this->load->view('admin/layout/sidebar');
		$this->load->view('estimate/index');
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

		// echo '<pre>';
		// print_r($_POST);
		// die;
		$page['title'] =  '';
		$page['header'] =  'Estimate';
		$condition=array('parent_id'=>$_POST['quotation']);
		// $page['question'] = $this->CustomModel->getAllfromTable('estimate_question_master');
		$page['question'] = $this->CustomModel->getAllfromWhere( 'estimate_question_master', $condition,  'title');
		$page['roles'] = $this->CustomModel->getAllfromWhere( 'estimate_role_master', $condition,  'name');

		// print_r($page['question']);
		// die;
		$this->load->view('admin/layout/header',);
		$this->load->view('admin/layout/sidebar');
		$this->load->view('estimate/estimate-page',$page);
		$this->load->view('admin/layout/footer');
		$this->load->view('estimate/script/custom-estimate');

		
	}
}
