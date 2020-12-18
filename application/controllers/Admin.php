<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

	private static $userId;

	public function __construct()
	{
		parent::__construct();
		// Load session library
		$this->load->library('session');
		// Load Custom model
		$this->load->model('CustomModel');
		$this->load->model('MainModel');
		$this->load->helper('validate');
		$this->load->helper('email');
		if (!isset($_SESSION['logged_in'])) {
			redirect('Login');
		}
		Admin::$userId = $_SESSION['logged_in']['people_id'];
	}
	public function index()
	{
		$page['header'] =  'Admin-Dashoard | ' . BRAND_NAME;
		$this->load->view('admin/layout/header', $page);
		$this->load->view('admin/layout/sidebar');
		$this->load->view('admin/pages/index');
		$this->load->view('admin/layout/footer');
	}
	public function clinetForm($var = null)
	{
		$page['header'] =  'People | ' . BRAND_NAME;
		$page['country'] = $this->CustomModel->getAllfromTable('countries');
		$page['currency'] = $this->CustomModel->getAllfromTable('currency_master');
		$page['ogtype'] = $this->CustomModel->getAllfromTable('master_clienttype');
		$page['document'] = $this->CustomModel->getAllfromTable('master_document');

		// echo '<pre>';
		// print_r($page['document']);die;
		$this->load->view('admin/layout/header', $page);
		$this->load->view('admin/layout/sidebar');
		$this->load->view('admin/pages/clientAdministration');
		$this->load->view('admin/script/clientForm');
		$this->load->view('admin/layout/footer');
	}
	public function people()
	{
		$page['header'] =  'People | ' . BRAND_NAME;
		$page['role'] = $this->CustomModel->getAllfromTable('master_role');
		// $condition = 'role=Manager or role=Admin';
		$page['manager'] = $this->CustomModel->getmanager();
		$page['designation'] = $this->CustomModel->getAllfromTable('master_designation');
		$page['department'] = $this->CustomModel->getAllfromTable('master_department');
		$page['skill'] = $this->CustomModel->getAllfromTable('master_skill');
		$page['country'] = $this->CustomModel->getAllfromTable('countries');
		$page['currency'] = $this->CustomModel->getAllfromTable('currency_master');
		$page['document'] = $this->CustomModel->getAllfromTable('master_document');
		$page['ogtype'] = $this->CustomModel->getAllfromTable('master_clienttype');

		// echo '<pre>';
		// print_r($page['country']);die;
		$this->load->view('admin/layout/header', $page);
		$this->load->view('admin/layout/sidebar');
		$this->load->view('admin/pages/people-administration');
		$this->load->view('admin/script/addpeople');
		$this->load->view('admin/layout/footer');
	}

	function get_designation()
	{
		$id = $_POST['depid'];

		// print_r($_POST);die;
		$desgi = $this->CustomModel->getAllfromWhere('master_designation', array('dept_id' => base64_decode($id)));

		// print_r($desgi);die;
		echo json_encode($desgi);
	}
	// Function for loading people dashboard
	public function people_dashboard($var = null)
	{
		$page['header'] =  'People - Dashboard | ' . BRAND_NAME;
		$page['client'] = $this->CustomModel->getClients();
		$page['employee'] = $this->CustomModel->getemployee();
		// print_r($page['employee']);die;
		$this->load->view('admin/layout/header', $page);
		$this->load->view('admin/layout/sidebar');
		$this->load->view('admin/pages/peopleMaster');
		$this->load->view('admin/script/addpeople');
		$this->load->view('admin/layout/footer');
	}
	// Function for loading Project dashboard
	public function project()
	{
		$page['header'] =  'Project | ' . BRAND_NAME;
		$page['project'] = $this->CustomModel->getProjects();
		$page['manager'] = $this->CustomModel->getAllfromWhere('employees', array('role' => 'Manager'));
		// echo '<pre>';
		// print_r($page['project']);die;
		$this->load->view('admin/layout/header', $page);
		$this->load->view('admin/layout/sidebar');
		$this->load->view('admin/pages/projectMaster');
		$this->load->view('admin/script/projectFormScript');
		$this->load->view('admin/layout/footer');
	}
	// Function for loading Project Form
	public function projectForm()
	{
		$page['header'] =  'Project Form | ' . BRAND_NAME;
		$page['client'] = $this->CustomModel->getAllfromTable('external_people_detail');
		$page['currency'] = $this->CustomModel->getAllfromTable('currency_master');
		$page['services'] = $this->CustomModel->get_services();
		$page['manager'] = $this->CustomModel->getAllfromWhere('employees', array('role' => 'Manager'));
		// print_r($page['client']);
		$this->load->view('admin/layout/header', $page);
		$this->load->view('admin/layout/sidebar');
		$this->load->view('admin/pages/projectForm');
		$this->load->view('admin/script/projectFormScript');
		$this->load->view('admin/layout/footer');
	}


	public function projectPost($var = null)
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (isset($_POST)) {
				$id = $this->MainModel->getNewIDorNo('project', 'TPRO');
				$projectDataArr = array(
					'project_Id' => $id,
					'name' => validateInput($_POST['title']),
					'currency' => validateInput($_POST['currency']),
					'description' => validateInput($_POST['description']),
					'value' => validateInput($_POST['value']),
					'services' => json_encode($_POST['services'], true),
					'billable' => validateInput($_POST['billable']),
					'billing_type' => validateInput($_POST['billtp']),
					'start_date' => validateInput(yymmdd($_POST['stdate'])),
					'end_date' => validateInput(yymmdd($_POST['eddate'])),
					'budget_hours' => validateInput($_POST['bgthrs']),
					'enquiry_date' => validateInput(yymmdd($_POST['enq-date'])),
					'client_id' => validateInput($_POST['client']),
					'Created_datetime' => timestamp(),
					'Created_by' => Admin::$userId,
					'status' => 10,
				);

				$res = $this->CustomModel->insert('project', $projectDataArr);
				if (isset($res)) {
					echo json_encode(array('msg' => 'Project Created', 'type' => 'success', 'data' => $id));
				} else {
					echo json_encode(array('msg' => 'Opps! some error occored, Contact IT.', 'type' => 'error'));
				}
			} else {
				echo json_encode(array('msg' => 'Opps! some error occored, Contact IT.', 'type' => 'error'));
			}
		}
	}
	public function assignProject($var = null)
	{
		$page['header'] =  'Managers | ' . BRAND_NAME;
		$page['manager'] = $this->CustomModel->getAllfromWhere('employees', array('role' => 'Manager'));
		// print_r($page['manager']);die;
		$this->load->view('admin/layout/header', $page);
		$this->load->view('admin/layout/sidebar');
		$this->load->view('admin/pages/managerList');
		// $this->load->view('admin/script/');
		$this->load->view('admin/layout/footer');
	}
	public function assignedProject($id = null)
	{
		// print_r($id);die;
		$id = base64_decode($id);
		$page['header'] =  'Project List | ' . BRAND_NAME;
		$page['Mid'] = $id;
		// $page['projects'] = $this->CustomModel->getAllfromWhere('project', array('resources' => $id));
		$page['projects'] = $this->CustomModel->getAssignedProject($id);
		$page['mangerName'] = $this->CustomModel->getEmployees($id);

		// $page['newProjects'] = $this->CustomModel->getAllfromWhere('project', array('status' => CREATE_STATUS));

		$page['newProjects'] = $this->CustomModel->getAllfromTable('project');
		// print_r($page['projects']);die;
		$this->load->view('admin/layout/header', $page);
		$this->load->view('admin/layout/sidebar');
		$this->load->view('admin/pages/projectList');
		$this->load->view('admin/script/assignProject');
		$this->load->view('admin/layout/footer');
	}
	public function assignProjectPost($var = null)
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (isset($_POST)) {
				// print_r($_POST);
				$projectDataArr = array(
					'people_id' => base64_decode($_POST['mid']),
					'project_id' => base64_decode($_POST['projects']),
					'assigned_date' => date("Y-m-d")
				);

				$res = $this->CustomModel->getAllfromWhere(
					'peopl_project_relationship',
					array('project_id' => base64_decode($_POST['projects']), 'people_id' => base64_decode($_POST['mid']))
				);
				if ($res) {
					echo json_encode(array('msg' => 'Already assign this project.', 'type' => 'error'));
				} else {
					// $status = array('status' => ASSIGNED_STATUS, 'resources' => $_POST['mid']);
					$condistion = array('project_id' => base64_decode($_POST['projects']));
					$res = $this->CustomModel->assignProject($projectDataArr,  $condistion);
					if (isset($res)) {
						echo json_encode(array('msg' => 'Assigned successfully', 'type' => 'success'));
					} else {
						echo json_encode(array('msg' => 'Opps! some error occored, Contact IT.', 'type' => 'error'));
					}
				}
			}
		}
	}
	public function role()
	{
		$page['description'] = $this->CustomModel->getAllfromTable('master_role');
		$page['title'] = 'Role master';
		// echo '<pre>';
		// print_r($page['description']);die;
		$page['header'] =  'Role master | ' . BRAND_NAME;
		$page['flage'] = 'master_role';
		$this->load->view('admin/layout/header', $page);
		$this->load->view('admin/layout/sidebar');
		$this->load->view('admin/pages/masterTemplate', $page);
		$this->load->view('admin/layout/footer');
	}
	public function designation()
	{
		$page['title'] = 'Designation';
		$page['header'] = 'Designation Administration| ' . BRAND_NAME;
		$page['flage'] = 'master_designation';
		$page['description'] = $this->CustomModel->getAllfromTable('master_designation');
		$page['department'] = $this->CustomModel->getAllfromTable('master_department');
		// print_r($page['department']);die;
		$this->load->view('admin/layout/header', $page);
		$this->load->view('admin/layout/sidebar');
		// $this->load->view('admin/layout/sidebar');
		$this->load->view('admin/pages/disignation', $page);
		$this->load->view('admin/layout/footer');
	}
	public function department()
	{
		$page['title'] = 'Department';
		$page['header'] = ' Department Administration| ' . BRAND_NAME;
		$page['description'] = $this->CustomModel->getAllfromTable('master_department');
		$page['flage'] = 'master_department';
		$this->load->view('admin/layout/header', $page);
		$this->load->view('admin/layout/sidebar');
		$this->load->view('admin/pages/masterTemplate', $page);
		$this->load->view('admin/layout/footer');
	}

	public function skill()
	{
		$page['title'] = 'Skill';
		$page['header'] = ' Skill Administration| ' . BRAND_NAME;
		$page['description'] = $this->CustomModel->getAllfromTable('master_skill');
		$page['flage'] = 'master_skill';
		$this->load->view('admin/layout/header', $page);
		$this->load->view('admin/layout/sidebar');
		$this->load->view('admin/pages/masterTemplate', $page);
		$this->load->view('admin/layout/footer');
	}

	public function services_category()
	{
		$page['title'] = 'Service Category';
		$page['header'] = ' Sertvice Category Administration| ' . BRAND_NAME;
		$page['description'] = $this->CustomModel->getAllfromTable('master_services_category');
		$page['flage'] = 'master_services_category';
		$this->load->view('admin/layout/header', $page);
		$this->load->view('admin/layout/sidebar');
		$this->load->view('admin/pages/masterTemplate', $page);
		$this->load->view('admin/layout/footer');
	}

	public function document_category()
	{
		$page['title'] = 'Document Category';
		$page['header'] = ' Document Category Administration| ' . BRAND_NAME;
		$page['description'] = $this->CustomModel->getAllfromTable('master_document_category');
		$page['flage'] = 'master_document_category';
		$this->load->view('admin/layout/header', $page);
		$this->load->view('admin/layout/sidebar');
		$this->load->view('admin/pages/masterTemplate', $page);
		$this->load->view('admin/layout/footer');
	}

	public function document()
	{
		$page['title'] = 'Document';
		$page['header'] = ' Document Administration| ' . BRAND_NAME;
		$page['description'] = $this->CustomModel->getAllfromTable('master_document');
		$page['flage'] = 'master_document';
		$this->load->view('admin/layout/header', $page);
		$this->load->view('admin/layout/sidebar');
		$this->load->view('admin/pages/masterTemplate', $page);
		$this->load->view('admin/layout/footer');
	}

	public function document_owner()
	{
		$page['title'] = 'Document owner';
		$page['header'] = 'Document owner Administration| ' . BRAND_NAME;
		$page['description'] = $this->CustomModel->getAllfromTable('master_document_owner');
		$page['flage'] = 'master_document_owner';
		$this->load->view('admin/layout/header', $page);
		$this->load->view('admin/layout/sidebar');
		$this->load->view('admin/pages/document-owner', $page);
		$this->load->view('admin/layout/footer');
	}

	// Funtion to load data form ajax into the form view
	public function confidentiality()
	{
		$page['title'] = 'Confidentiality';
		$page['header'] = ' Confidentiality Administration | ' . BRAND_NAME;
		$page['description'] = $this->CustomModel->getAllfromTable('master_confidentiality');
		$page['flage'] = 'master_confidentiality';
		$this->load->view('admin/layout/header', $page);
		$this->load->view('admin/layout/sidebar');
		$this->load->view('admin/pages/confidentiality', $page);
		$this->load->view('admin/layout/footer');
	}

	// Funtion to load data form ajax into the form view
	public function edit_row($var = null)
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (isset($_POST)) {
				$tableName = $_POST['flage'];
				$id = $_POST['id'];
				$res = $this->MainModel->selectAllFromWhere($tableName, array('id' => $id));
				echo json_encode($res[0], true);
			}
		}
	}

	// Function for inserting Master formdata into the master database
	public function postFormData($var = null)
	{
		// print_r($_POST); die;
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (isset($_POST)) {
				$tableName = $_POST['flage'];
				$descrption = validateInput($_POST['description']);
				$activeStatus = true;
				$rowData = array(
					'title' => validateInput($_POST['title']),
					'description' => $descrption,
					'active_status' => $activeStatus
				);

				// Checking duplicate values if availble
				// $condition = array('description' => $descrption, 'title' => validateInput($_POST['title']));
				// $check = $this->MainModel->selectAllFromWhere($tableName, $condition);

				// if ($check > 0) {
				// // 	echo json_encode(array('message' => 'Duplicate entry not allowed', 'type' => 'error'));
				// } else {

					switch ($tableName) {
						case "master_skill":
							$Id = $this->MainModel->getNewIDorNo($tableName, 'SKL');
							$rowData['skill_id'] = $Id;
							$result = $this->MainModel->getinsertedData($tableName, $rowData);
							echo messages($result);
							break;
						case "master_role":
							$Id = $this->MainModel->getNewIDorNo($tableName, 'Rol');
							$rowData['role_id'] = $Id;
							$result = $this->MainModel->getinsertedData($tableName, $rowData);
							echo messages($result);
							break;
						case "master_designation":
							$Id = $this->MainModel->getNewIDorNo($tableName, 'DES');
							$rowData['desig_id'] = $Id;
							$rowData['dept_id'] = $_POST['deg'];
							$result = $this->MainModel->getinsertedData($tableName, $rowData);
							echo messages($result);
							break;
						case "master_department":
							$Id = $this->MainModel->getNewIDorNo($tableName, 'DEP');
							$rowData['dept_id'] = $Id;
							$result = $this->MainModel->getinsertedData($tableName, $rowData);
							echo messages($result);
							break;
						case "master_services_category":
							$Id = $this->MainModel->getNewIDorNo($tableName, 'SRC');
							$rowData['services_id'] = $Id;
							$result = $this->MainModel->getinsertedData($tableName, $rowData);
							echo messages($result);
							break;
						case "master_document_category":
							$Id = $this->MainModel->getNewIDorNo($tableName, 'DOC');
							$rowData['document_category_id'] = $Id;
							$result = $this->MainModel->getinsertedData($tableName, $rowData);
							echo messages($result);
							break;
						case "master_confidentiality":
							$Id = $this->MainModel->getNewIDorNo($tableName, 'CONF');
							$rowData['confidentiality_id'] = $Id;
							$rowData['visibility_level'] = validateInput($_POST['visibility-level']);
							$result = $this->MainModel->getinsertedData($tableName, $rowData);
							echo messages($result);
							break;
						case "master_document":
							$Id = $this->MainModel->getNewIDorNo($tableName, 'DOC');
							$rowData['document_id'] = $Id;
							// $rowData['visibility_level'] = validateInput($_POST['visibility-level']);
							$result = $this->MainModel->getinsertedData($tableName, $rowData);
							echo messages($result);
							break;
						case "master_tasks":
							$Id = $this->MainModel->getNewIDorNo($tableName, 'TSK');
							$rowData['task_id'] = $Id;
							$rowData['category'] = validateInput($_POST['categories']);
							$rowData['created_timestamp'] = timestamp();
							$rowData['created_by'] = Admin::$userId;
							$result = $this->MainModel->getinsertedData($tableName, $rowData);
							echo messages($result);
							break;
						default:
							echo "Table not found!";
					}
				}
			}
		// }
	}

	// Function for update form data into the master database
	public function edit_FormData($var = null)
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (isset($_POST)) {

				// print_r($_POST);
				// die;
				$id = array(
					'id' => $_POST['id'],
				);
				$tableName = $_POST['flage'];
				$title = validateInput($_POST['title']);
				$descrption = validateInput($_POST['description']);
				$rowData=[];
				if ($tableName == 'master_tasks') {
					$rowData = array(
						'title' => $title,
						'description' => $descrption,
						'category' => validateInput($_POST['categories']),
					);
				} else {
					$rowData = array(
						'title' => $title,
						'description' => $descrption,
						
					);
				}

				// print_r($rowData);
				// die;
				$result = $this->CustomModel->update_row($tableName, $id, $rowData);
				echo messages_update($result);
			}
		}
	}

	// Function for update form data into the master database
	public function edit_designation_form($var = null)
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (isset($_POST)) {

				// print_r($_POST);
				// die;
				$tableName = $_POST['flage'];
				$title = validateInput($_POST['title']);
				$descrption = validateInput($_POST['description']);
				$id = array(
					'id' => $_POST['id'],
				);
				$rowData = array(
					'title' => $title,
					'description' => $descrption,
					'dept_id' => validateInput($_POST['deg']),
				);
				$result = $this->CustomModel->update_row($tableName, $id, $rowData);
				echo messages_update($result);
			}
		}
	}

	public function edit_conf($var = null)
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (isset($_POST)) {
				$tableName = $_POST['flage'];
				$title = validateInput($_POST['title']);
				$descrption = validateInput($_POST['description']);
				$id = array(
					'id' => $_POST['id'],
				);
				$rowData = array(
					'title' => $title,
					'description' => $descrption,
					'visibility_level' => validateInput($_POST['visibility-level'])
				);
				$result = $this->CustomModel->update_row($tableName, $id, $rowData);
				echo messages_update($result);
			}
		}
	}

	// Function for update form data into the master database
	public function edit_doc_ow($var = null)
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (isset($_POST)) {
				$tableName = $_POST['flage'];
				$title = validateInput($_POST['title']);
				$descrption = validateInput($_POST['description']);
				$location = validateInput($_POST['location']);
				$id = array(
					'id' => $_POST['id'],
				);
				$rowData = array(
					'title' => $title,
					'description' => $descrption,
					'location' => $location,
				);
				$result = $this->CustomModel->update_row($tableName, $id, $rowData);
				echo messages_update($result);
			}
		}
	}

	// Function for Delete formdata from the master database
	function deleteRowData($var = null)
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (isset($_POST)) {
				$check = $this->MainModel->deleteFromTable($_POST['table_name'], array('id' => $_POST['row_id']));
				// print_r($check);die;
				echo deleteMessages($check);
			}
		}
	}

	// Function for update form data into the master database
	function post_doc_owner($var = null)
	{
		$condition = array('title' => validateInput($_POST['title']));
		$check = $this->MainModel->selectAllFromWhere('master_document_owner', $condition);
		if ($check > 0) {
			echo json_encode(array('message' => 'Duplicate row not allow!', 'type' => 'error'), true);
		}
		$Id = $this->MainModel->getNewIDorNo('master_document_owner', 'DOW');
		$formData = array(
			'document_owner_id' => $Id,
			'title' => validateInput($_POST['title']),
			'description' => validateInput($_POST['description']),
			// 'location' => validateInput($_POST['location']),
			'active_status' => true,
		);
		$result = $this->MainModel->getinsertedData('master_document_owner', $formData);
		echo messages($result);
	}

	// Function for Post people info
	public function people_post($user = null, $document = null, $emcontact = null, $cost = null)
	{
		// print_r($user);
		// print_r($document);
		// print_r($emcontact);
		// print_r($cost);
		// die;

		$id = $this->MainModel->getNewIDorNo('people', 'TIOE');

		// Array for the personal information
		$dob = yymmdd($user['dob']);
		// User info
		$personalinfoData = array(
			'people_id' => $id,
			'first_name' => validateInput($user['first_name']),
			'last_name' => validateInput($user['last_name']),
			'gender' => validateInput($user['gender']),
			'dob' => validateInput($dob),
			'People_type' => validateInput('INP'),
			'CreatedAt' => date("Y-m-d"),
			'CreatedById' => $_SESSION['logged_in']['people_id'],
		);

		// Array for the contact information
		$contactData = array(
			'phone' => validateInput($user['mobile']),
			'email' => validateInput($user['email']),
			'address' => validateInput($user['address']),
			'city' => validateInput($user['city']),
			'state' => validateInput($user['state']),
			'country' => validateInput($user['country']),
			'pin' => validateInput($user['pin_zip']),
			'reference_id' => $id,
			'type' => 'regi_contact'
		);
		$skill = json_encode($user['skills'], true);

		// Array for the Employee information
		$mangagerId = isset($user['manager']) ? $user['manager'] : $_SESSION['logged_in']['people_id'];
		$DOJ = yymmdd($user['join_date']);
		// Employee details
		$employeeData = array(
			'role' => validateInput($user['role']),
			'department' => validateInput($user['department']),
			'designation' => validateInput($user['designation']),
			'skill' => $skill,
			'managerId' => $mangagerId,
			'join_date' => validateInput($DOJ),
			'created_by' => $_SESSION['logged_in']['people_id'],
			'created_date' => date("Y-m-d"),
			'people_id' => $id,
		);

		// Document data
		$docid = $this->MainModel->getNewIDorNo('people_document', 'PEDOC');

		$docArr = array(
			'doc_id' => $docid,
			'refer_id' => $id,
			'documents' => json_encode($document),
			'created_by' => $_SESSION['logged_in']['people_id'],
			'created_date' => date("Y-m-d"),
		);

		// Emergency contact
		// $pname = validateInput($emcontact['f_name']) . ' ' . validateInput($emcontact['l_name']);
		// $pname = validateInput($emcontact['f_name']) . ' ' . validateInput($emcontact['l_name']);

		$emergency_contact = array(
			'person_name' => validateInput($emcontact['f_name']),
			'phone' => validateInput($emcontact['mobile']),
			'email' => validateInput($emcontact['email']),
			'address' => validateInput($emcontact['address']),
			'city' => validateInput($emcontact['city']),
			'state' => validateInput($emcontact['state']),
			'country' => validateInput($emcontact['country']),
			'pin' => validateInput($emcontact['pin']),
			'people_id' => validateInput($id),
			'type' => 'em_contact'
		);

		// cost data

		$costData = array(
			'working_hours' => validateInput($cost['working_hrs']),
			'cost_per_hours' => validateInput($cost['cost_per_hrs']),
			'rate_per_hour' => validateInput($cost['rate_per_hrs']),
			'people_id' => validateInput($id)
		);

		// creadential
		$password=passwordGenerate(8);
		// $password = '123';
		$credentials = array(
			'username' => validateInput($user['email']),
			'password' => hash('sha512', $password),
			'people_id' => $id
		);

		// steps to save databse
		$res = $this->CustomModel->insetPeopleData($personalinfoData, $contactData, $employeeData);

		// return ($res == true) ? json_encode(array('type' => true, 'id' => $id), true) : json_encode(array('type' => false), true);
		$to = validateInput($user['email']);
		$sub = 'Timesheet Access Credentials';
	    $message = 'Hi ' . $user['first_name'] . ', 
		<br/> Your username : ' . validateInput($user['email']).'
		<br/> Password is :' . $password.'<br/> 
		<br/> Website url is :' . base_url().'<br/>';

		if ($res) {
			$docres = $this->CustomModel->insetPeopleDetails($docArr, $emergency_contact, $costData, $credentials);
			if ($docres) {
				$res = sentmail($to, $sub, $message);
				return	$res == true ? true : false;
			}
		} else {
			return false;
		}
	}

	// Function for Post people info
	public function documentPost($id = null, $document = null)
	{
		// print_r($_POST);die;
		if ($_POST['docid'] != '') {
			$id = array('refer_id' => $_POST['id']);
			$data = $_POST['data'];
			$docArr = array(
				'documents' => $data,
				'created_by' => $_SESSION['logged_in']['people_id'],
				'created_date' => date("Y-m-d"),
			);
			$res = $this->CustomModel->update_row('people_document', $id, $docArr);
			echo isset($res) ? json_encode(array('type' => 'success', 'id' => $id, 'message' => 'Document updated.')) : json_encode(array('type' => 'error', 'message' => 'Opps Contact IT.'));
		} else {
			$docid = $this->MainModel->getNewIDorNo('people_document', 'PEDOC');
			$id = $_POST['id'];
			$data = $_POST['data'];
			$docArr = array(
				'doc_id' => $docid,
				'refer_id' => $id,
				'documents' => $data,
				'created_by' => $_SESSION['logged_in']['people_id'],
				'created_date' => date("Y-m-d"),
			);
			$res = $this->CustomModel->insert('people_document', $docArr);
			echo isset($res) ? json_encode(array('type' => 'success', 'id' => $id, 'message' => 'Document saved.')) : json_encode(array('type' => 'error', 'message' => 'Opps Contact IT.'));
		}
	}

	// Function for Post Emengency Contact details info
	public function emergencyContact($id = null, $contact = null)
	{
		$pname = validateInput($contact['f_name']) . ' ' . validateInput($contact['l_name']);
		$emergency_contact = array(
			'person_name' => $pname,
			'phone' => validateInput($contact['mobile']),
			'email' => validateInput($contact['email']),
			'address' => validateInput($contact['address']),
			'city' => validateInput($contact['city']),
			'state' => validateInput($contact['state']),
			'country' => validateInput($contact['country']),
			'pin' => validateInput($contact['pin']),
			'people_id' => validateInput($id),
			'type' => 'em_contact'
		);
		$res = $this->CustomModel->insert('emergency_contact', $emergency_contact);
		return ($res == true) ? json_encode(array('type' => true, 'id' => $id), true) : json_encode(array('type' => false), true);
		// cost


	}

	// Function for Post Credentials Contact details info
	public function setCredentials($email = null, $password = null, $id = null)
	{
		$credentials = array(
			'username' => validateInput($email),
			'password' => hash('sha512', validateInput($password)),
			'people_id' => $id
		);

		$res = $this->CustomModel->insert('login', $credentials);

		if (isset($res)) {
			return true;
			// echo json_encode(array('msg' => 'Credentials set', 'type' => 'success'));
		} else {
			return false;
			// echo json_encode(array('msg' => 'Opps! some error occored, Contact IT.', 'type' => 'error'));
		}
	}

	// Function for Post Save employee Cost Contact details info

	public function setEmpCost($cost = null, $id = null)
	{

		if (isset($cost)) {
			$costData = array(
				'working_hours' => validateInput($cost['working_hrs']),
				'cost_per_hours' => validateInput($cost['cost_per_hrs']),
				'rate_per_hour' => validateInput($cost['rate_per_hrs']),
				'people_id' => validateInput($id)
			);
			$res = $this->CustomModel->insert('cost', $costData);
			if (isset($res)) {

				echo json_encode(array('msg' => 'Credentials set', 'type' => 'success'));
			} else {
				echo json_encode(array('msg' => 'Opps! some error occored, Contact IT.', 'type' => 'error'));
			}
		}
	}

	public function ext_people_post($var = null)
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (isset($_POST)) {
				// echo '<pre>';
				// print_r($_POST);
				// die;
				$id = $this->MainModel->getNewIDorNo('external_people_detail', 'CLID');
				// Array for the personal information
				$clientData = array(
					'client_id' => $id,
					'client_name' => validateInput($_POST['org-name']),
					'mobile' => validateInput($_POST['c-mobile']),
					'currency' => validateInput($_POST['currency']),
					'gst_vat_number' => validateInput($_POST['gst-vat']),
					'orgnaization_type' => validateInput($_POST['og-type']),
					'created_date' => date("Y-m-d"),
					'created_by' => $_SESSION['logged_in']['people_id'],
				);
				$city = isset($_POST['c-city']) ? validateInput($_POST['c-city']) : 'NA';
				$state = isset($_POST['c-state']) ? validateInput($_POST['c-state']) : 'NA';
				// Array for the contact information
				$clientAddress = array(
					'phone' => validateInput($_POST['c-mobile']),
					'email' => validateInput($_POST['c-email']),
					'address' => validateInput($_POST['c-address']),
					'city' => 	$city,
					'state' => 	$state,
					'country' => validateInput($_POST['c-country']),
					'pin' => validateInput($_POST['c-pin-zip']),
					'reference_id' => $id,
					'type' => 'client_contact'
				);

				$res = $this->CustomModel->externalPeopleData($clientData, $clientAddress);
				echo ($res == true) ? json_encode(array('message' => 'client successfully created', 'type' => 'success', 'clientid' => $id), true) : json_encode(array('message' => 'Opps! some error occored, Contact IT.', 'type' => 'error'), true);
			}
		}
	}

	// For state data
	function state($id = null)
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (isset($_POST)) {
				// Checking duplicate values if availble
				$tableName = 'states';
				$condition = array('country_id' => $_POST['id']);
				$check = $this->MainModel->selectAllFromWhere($tableName, $condition);
				echo ($check != FALSE) ? json_encode(array('data' => $check), true) : json_encode(array('data' => false), true);
			}
		}
	}

	// For ciry data
	function city($id = null)
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (isset($_POST)) {
				// Checking duplicate values if availble
				$tableName = 'cities';
				$condition = array('state_id' => $_POST['id']);
				$check = $this->MainModel->selectAllFromWhere($tableName, $condition);
				echo ($check != FALSE) ? json_encode(array('data' => $check), true) : json_encode(array('data' => false), true);
			}
		}
	}

	public function documetArray()
	{
		$page = $this->CustomModel->getAllfromTable('master_document');
		echo ($page != false) ? json_encode(array('data' => $page), true) : json_encode(array('data' => 'null'), true);
	}

	// Function for upload employee data
	function upload_employee_document()
	{
		$result = uploadData($_FILES, 'Employee');
		if ($result) {
			echo $result;
		} else {
			echo "error";
		}
	}
	// Function for upload Clinet data
	function upload_image()
	{

		// print_r();
		// print_r($_FILES);
		// die;
		$result = uploadData($_FILES, $_POST['clinetId']);
		if ($result) {
			echo $result;
		} else {
			echo "error";
		}
	}

	// saveUserdata
	function saveUserdata()
	{
		// echo '<pre>';
		// print_r($_POST);
		// die;
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (isset($_POST)) {
				$res = $this->people_post(
					$_POST['userData'][0],
					$_POST['userData'][1],
					$_POST['userData'][2],
					$_POST['userData'][3]
				); //post user info
				echo ($res == true) ? json_encode(array('message' => 'Employee crerated', 'type' => 'success')) : json_encode(array('message' => 'Opps! some error occored, Contact IT.', 'type' => 'error'));
			}
		}
	}


	public function addnewClient()
	{
		if ($_POST) {
			// print_r($_POST['email']);die;
			$id = $this->MainModel->getNewIDorNo('external_people_detail', 'CLID');
			$data = array(
				'client_id' => $id,
				'client_name' => validateInput($_POST['org-name'])
			);

			$adddata = array(
				'reference_id' => $id,
				'email' => $_POST['email']
			);

			$res = $this->MainModel->selectAllFromWhere('clients', array('email' => validateInput($_POST['email'])));
			// print_r($res);die;
			if ($res != '') {
				echo json_encode(array('type' => 'error', 'message' => 'Email already exist'));
			} else {
				// $result = $this->CustomModel->insert('external_people_detail', $data);
				$res = $this->CustomModel->externalPeopleData($data, $adddata);
				if ($res) {
					echo json_encode(array('type' => 'success', 'message' => 'client created'));
				} else {
					echo json_encode(array('type' => 'error', 'message' => 'no data available'));
				}
			}
		} else {
			echo json_encode(array('type' => 'error', 'message' => 'no data available'));
		}
	}

	// Project 
	// Edit 

	public function project_edit($id = null)
	{
		$page['header'] =  'Project Form | ' . BRAND_NAME;
		$page['client'] = $this->CustomModel->getAllfromTable('external_people_detail');
		$page['currency'] = $this->CustomModel->getAllfromTable('currency_master');
		$page['services'] = $this->CustomModel->get_services();
		$page['manager'] = $this->CustomModel->getAllfromWhere('employees', array('role' => 'Manager'));
		$page['project'] = $this->CustomModel->getAllfromWhere('project', array('project_Id' => base64_decode($id)));

		// print_r($page['client']);
		$this->load->view('admin/layout/header', $page);
		$this->load->view('admin/layout/sidebar');
		$this->load->view('admin/pages/projectForm');
		$this->load->view('admin/script/projectFormScript');
		$this->load->view('admin/layout/footer');
	}

	public function edit_projectPost()
	{
		if ($_POST) {
			$projectDataArr = array(
				'name' => validateInput($_POST['title']),
				'currency' => validateInput($_POST['currency']),
				'description' => validateInput($_POST['description']),
				'value' => validateInput($_POST['value']),
				'services' => json_encode($_POST['services'], true),
				'billable' => validateInput($_POST['billable']),
				'billing_type' => validateInput($_POST['billtp']),
				'start_date' => validateInput(yymmdd($_POST['stdate'])),
				'end_date' => validateInput(yymmdd($_POST['eddate'])),
				'budget_hours' => validateInput($_POST['bgthrs']),
				'enquiry_date' => validateInput(yymmdd($_POST['enq-date'])),
				'client_id' => validateInput($_POST['client']),
				'Created_datetime' => timestamp(),
				'Created_by' => Admin::$userId,
				'status' => 10,
			);
			$id = array('project_Id' => validateInput($_POST['project-id']));
			$result = $this->CustomModel->update_row('project', $id, $projectDataArr);
			echo $result === true ? json_encode(array('message' => 'Project Updated!', 'type' => 'success')) : json_encode(array('message' => 'Error! Contact IT', 'type' => 'error'));
		}
	}

	function project_delete($id = null)
	{
		$id = $_POST['row_id'];
		if ($id) {
			$check = $this->MainModel->deleteFromTable('project', array('project_id' => base64_decode($id)));
			echo $check == true ? json_encode(array('message' => 'Project deleted!', 'type' => 'success')) : json_encode(array('message' => 'Error! Contact IT', 'type' => 'error'));
		}
	}

	// Clients

	public function client_edit($id = null)
	{
		$page['header'] =  'People | ' . BRAND_NAME;
		$page['country'] = $this->CustomModel->getAllfromTable('countries');
		$page['currency'] = $this->CustomModel->getAllfromTable('currency_master');
		$page['ogtype'] = $this->CustomModel->getAllfromTable('master_clienttype');
		$page['document'] = $this->CustomModel->getAllfromTable('master_document');

		$page['client'] = $this->CustomModel->getAllfromWhere('clients', array('client_id' => base64_decode($id)));

		// echo '<pre>';
		// print_r($page['document']);die;
		$this->load->view('admin/layout/header', $page);
		$this->load->view('admin/layout/sidebar');
		$this->load->view('admin/pages/clientAdministration');
		$this->load->view('admin/script/clientForm');
		$this->load->view('admin/layout/footer');
	}

	public function update_people_post()
	{
		if ($_POST) {
			$clientData = array(
				// 'client_id' => $id,
				'client_name' => validateInput($_POST['org-name']),
				'mobile' => validateInput($_POST['c-mobile']),
				'currency' => validateInput($_POST['currency']),
				'gst_vat_number' => validateInput($_POST['gst-vat']),
				'orgnaization_type' => validateInput($_POST['og-type']),
				'created_date' => date("Y-m-d"),
				'created_by' => $_SESSION['logged_in']['people_id'],
			);

			$city = isset($_POST['c-city']) ? validateInput($_POST['c-city']) : 'NA';
			$state = isset($_POST['c-state']) ? validateInput($_POST['c-state']) : 'NA';
			// Array for the contact information

			$clientAddress = array(
				'phone' => validateInput($_POST['c-mobile']),
				'email' => validateInput($_POST['c-email']),
				'address' => validateInput($_POST['c-address']),
				'city' => 	$city,
				'state' => 	$state,
				'country' => validateInput($_POST['c-country']),
				'pin' => validateInput($_POST['c-pin-zip']),
				// 'reference_id' => $id,
				'type' => 'client_contact'
			);
			$c_id['client_id'] = $_POST['client-id'];
			$id['reference_id'] = $_POST['client-id'];

			$result = $this->CustomModel->update_row('external_people_detail', $c_id, $clientData);

			$result = $this->CustomModel->update_row('address', $id, $clientAddress);

			echo $result === true ? json_encode(array('message' => 'client Updated!', 'type' => 'success')) : json_encode(array('message' => 'Error! Contact IT', 'type' => 'error'));
		}
	}

	function client_delete($id = null)
	{
		$id = $_POST['row_id'];
		if ($id) {
			$check = $this->MainModel->deleteFromTable('external_people_detail', array('client_id' => base64_decode($id)));
			$check = $this->MainModel->deleteFromTable('address', array('reference_id' => base64_decode($id)));
			echo $check == true ? json_encode(array('message' => 'Client deleted!', 'type' => 'success')) : json_encode(array('message' => 'Error! Contact IT', 'type' => 'error'));
		}
	}

	// employee

	function employee_delete($id = null)
	{
		$id = $_POST['row_id'];

		if ($id) {
			$check = $this->MainModel->deleteFromTable('people', array('people_id' => base64_decode($id)));
			$check = $this->MainModel->deleteFromTable('address', array('reference_id' => base64_decode($id)));
			$check = $this->MainModel->deleteFromTable('internal_people_detail', array('people_id' => base64_decode($id)));
			$check = $this->MainModel->deleteFromTable('people_document', array('refer_id' => base64_decode($id)));
			$check = $this->MainModel->deleteFromTable('emergency_contact', array('people_id' => base64_decode($id)));
			$check = $this->MainModel->deleteFromTable('cost', array('people_id' => base64_decode($id)));
			$check = $this->MainModel->deleteFromTable('login', array('people_id' => base64_decode($id)));

			echo $check == true ? json_encode(array('message' => 'Employee deleted!', 'type' => 'success')) : json_encode(array('message' => 'Error! Contact IT', 'type' => 'error'));
		}
	}


	public function emp_edit($id = null)
	{
		$page['header'] =  'People | ' . BRAND_NAME;
		$page['role'] = $this->CustomModel->getAllfromTable('master_role');
		// $condition = 'role=Manager or role=Admin';
		$page['manager'] = $this->CustomModel->getmanager();
		$page['designation'] = $this->CustomModel->getAllfromTable('master_designation');
		$page['department'] = $this->CustomModel->getAllfromTable('master_department');
		$page['skill'] = $this->CustomModel->getAllfromTable('master_skill');
		$page['country'] = $this->CustomModel->getAllfromTable('countries');
		$page['currency'] = $this->CustomModel->getAllfromTable('currency_master');
		$page['document'] = $this->CustomModel->getAllfromTable('master_document');
		$page['ogtype'] = $this->CustomModel->getAllfromTable('master_clienttype');

		$page['employee'] = $this->CustomModel->getAllfromWhere('employee_details', array('people_id' => base64_decode($id)));

		$this->load->view('admin/layout/header', $page);
		$this->load->view('admin/layout/sidebar');
		$this->load->view('admin/pages/people-administration');
		$this->load->view('admin/script/addpeople');
		$this->load->view('admin/layout/footer');
	}



	// Function for Post people info
	public function updateUserdata()
	{
		// 		echo "<pre>";
		// print_r($_POST);die;
		if ($_POST) {
			// print_r();
			$empid = $_POST['empid'];
			$user = $_POST['userData'][0];
			$document = $_POST['userData'][1];
			$emcontact = $_POST['userData'][2];
			$cost = $_POST['userData'][3];
			// Array for the personal information
			$dob = yymmdd($user['dob']);
			// User info
			$personalinfoData = array(
				'first_name' => validateInput($user['first_name']),
				'last_name' => validateInput($user['last_name']),
				'gender' => validateInput($user['gender']),
				'dob' => validateInput($dob),
				'People_type' => validateInput('INP'),
				'CreatedAt' => date("Y-m-d"),
				'CreatedById' => $_SESSION['logged_in']['people_id'],
			);

			$res = $this->CustomModel->update_row('people', array('people_id' => validateInput($empid)), $personalinfoData);

			// Array for the contact information
			$contactData = array(
				'phone' => validateInput($user['mobile']),
				'email' => validateInput($user['email']),
				'address' => validateInput($user['address']),
				'city' => validateInput($user['city']),
				'state' => validateInput($user['state']),
				'country' => validateInput($user['country']),
				'pin' => validateInput($user['pin_zip']),
				'type' => 'regi_contact'
			);

			$res = $this->CustomModel->update_row('address', array('reference_id' => validateInput($empid)), $contactData);

			$skill = json_encode($user['skills'], true);

			// Array for the Employee information
			$mangagerId = isset($user['manager']) ? $user['manager'] : $_SESSION['logged_in']['people_id'];
			$DOJ = yymmdd($user['join_date']);
			// Employee details
			$employeeData = array(
				'role' => validateInput($user['role']),
				'department' => validateInput($user['department']),
				'designation' => validateInput($user['designation']),
				'skill' => $skill,
				'managerId' => $mangagerId,
				'join_date' => validateInput($DOJ),
				'created_by' => $_SESSION['logged_in']['people_id'],
				'created_date' => date("Y-m-d"),

			);

			$res = $this->CustomModel->update_row('internal_people_detail', array('people_id' => validateInput($empid)), $employeeData);

			if ($_POST['docid'] != '') {
				$docArr = array(
					'documents' => json_encode($document),
					'created_by' => $_SESSION['logged_in']['people_id'],
					'created_date' => date("Y-m-d"),
				);
				$res = $this->CustomModel->update_row('people_document', array('refer_id' => validateInput($empid)), $docArr);
			} elseif ($_POST['docid'] == '') {
				// Document data
				$docid = $this->MainModel->getNewIDorNo('people_document', 'PEDOC');
				$docArr = array(
					'doc_id' => $docid,
					'refer_id' => $empid,
					'documents' => json_encode($document),
					'created_by' => $_SESSION['logged_in']['people_id'],
					'created_date' => date("Y-m-d"),
				);
				$res = $this->CustomModel->insert('people_document', $docArr);
			}

			// Emergency contact

			$emergency_contact = array(
				'person_name' => validateInput($emcontact['f_name']),
				'phone' => validateInput($emcontact['mobile']),
				'email' => validateInput($emcontact['email']),
				'address' => validateInput($emcontact['address']),
				'city' => validateInput($emcontact['city']),
				'state' => validateInput($emcontact['state']),
				'country' => validateInput($emcontact['country']),
				'pin' => validateInput($emcontact['pin']),
				'type' => 'em_contact'
			);

			$res = $this->CustomModel->update_row('emergency_contact', array('people_id' => validateInput($empid)), $emergency_contact);
			// cost data

			$costData = array(
				'working_hours' => validateInput($cost['working_hrs']),
				'cost_per_hours' => validateInput($cost['cost_per_hrs']),
				'rate_per_hour' => validateInput($cost['rate_per_hrs']),
			);

			$res = $this->CustomModel->update_row('cost', array('people_id' => validateInput($empid)), $costData);

			echo ($res == true) ? json_encode(array('type' => 'success', 'message' => 'employee updated')) : json_encode(array('type' => 'error', 'message' => 'Oops ... contact IT'));
		}
	}


	function taskmaster()
	{
		$page['header'] =  'Task master | ' . BRAND_NAME;
		$page['flage'] = 'master_tasks';
		$page['title'] =  'Task Master';
		$page['categories'] = $this->CustomModel->getAllfromTable('master_services_category');
		$page['tasks'] = $this->CustomModel->getTaskListbyCategories();
		$this->load->view('admin/layout/header', $page);
		$this->load->view('admin/layout/sidebar');
		$this->load->view('admin/pages/taskmaster');
		$this->load->view('admin/script/taskmaster');
		$this->load->view('admin/layout/footer');
	}
}
