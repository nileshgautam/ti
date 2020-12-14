<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reports extends CI_Controller
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

		Reports::$userId = $_SESSION['logged_in']['people_id'];
	}

	public function index()
	{
		$page['projects'] = $this->report->project_task_reports(Reports::$userId);
		$page['header'] =  'Dashoard | ' . BRAND_NAME;
		$this->load->view('admin/layout/header', $page);
		$this->load->view('admin/layout/sidebar');
		$this->load->view('reports/pages/manager');
		$this->load->view('reports/scripts/manager-reports-drill', $page);
		$this->load->view('admin/layout/footer');
	}

	public function user()
	{
		$id = $_SESSION['logged_in']['people_id'];
		$page['header'] =  'Dashoard | ' . BRAND_NAME;

		$page['assginTask'] = $this->CustomModel->getTaskByid($id, date('Y-m-d'));

		// echo '<pre>';
		// print_r($page['assginTask']);
		// die;
		$this->load->view('admin/layout/header', $page);
		$this->load->view('admin/layout/sidebar');
		$this->load->view('template/index');
		$this->load->view('admin/layout/footer');
		$this->load->view('template/scripts/reports', $page);
	}
}
