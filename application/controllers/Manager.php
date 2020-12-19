<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Manager extends CI_Controller
{
	private static $userId;
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
		$this->load->model('CustomModel1');
		$this->load->model('MainModel');
		$this->load->helper('validate');
		$this->load->helper('smtpmail');
		$this->load->library("common");

		if (!isset($_SESSION['logged_in'])) {
			redirect('Login');
		}
		Manager::$userId = $_SESSION['logged_in']['people_id'];
	}

	public function index()
	{
		$page['header'] =  'Admin-Dashoard | ' . BRAND_NAME;
		$this->load->view('admin/layout/header', $page);
		$this->load->view('admin/layout/sidebar');
		$this->load->view('admin/pages/index');
		$this->load->view('admin/layout/footer');
	}
	public function project($var = null)
	{
		$page['header'] =  'Projects | ' . BRAND_NAME;
		// $page['projects'] = $this->CustomModel->getAllfromWhere('project', array('resources' => $_SESSION['logged_in']['people_id']));
		// $page['projects'] = $this->CustomModel->getProjects();
		$page['projects'] = $this->CustomModel->getAssignedProject(Manager::$userId);

		// echo '<pre>';
		// print_r($page['projects']);die;
		$this->load->view('admin/layout/header', $page);
		$this->load->view('admin/layout/sidebar');
		$this->load->view('manager/pages/managerProject');
		$this->load->view('manager/scripts/projectManager');
		$this->load->view('admin/layout/footer');
	}
	public function users()
	{
		$page['header'] =  'Projects | ' . BRAND_NAME;
		$page['users'] = $this->CustomModel->getAllfromWhere('employees', array('ManagerId' => Manager::$userId));

		// echo '<pre>';
		// print_r($page['users']);die;
		$this->load->view('admin/layout/header', $page);
		$this->load->view('admin/layout/sidebar');
		$this->load->view('manager/pages/usersList');
		$this->load->view('manager/scripts/projectManager');
		$this->load->view('admin/layout/footer');
	}
	public function userTask($id = null)
	{
		if ($id) {
			$id = base64_decode($id);
			// $cdate = date('Y-m-d');
			$page['task'] = $this->CustomModel->getAllocatedTask(Manager::$userId);
			$page['projects'] = $this->CustomModel->getAssignproject(Manager::$userId);
			// $data['projects_task'] = $this->CustomModel->getProjectByAssignTask(Manager::$userId, $cdate);

			// print_r($page['projects']); die;
			$page['users'] = $this->CustomModel1->getemployee(Manager::$userId);

			// $page['MasterTask'] = $this->CustomModel->getTaskByProjectAndManager(Manager::$userId);

			$this->load->view('admin/layout/header', $page);
			$this->load->view('admin/layout/sidebar');
			$this->load->view('manager/pages/userTask');
			$this->load->view('manager/scripts/projectManager');
			$this->load->view('admin/layout/footer');
		}
	}

	public function getTasklist($var = null)
	{
		$cdate = date('Y-m-d');
		$projectid = $_POST['projectid'];
		// $result=$this->CustomModel->CustomModel->getDailyAllocatedTasks(Manager::$userId, $cdate, $projectid);
		$result = $this->CustomModel->taklistByProjectId($projectid);
		echo json_encode($result);
	}


	public function task($var = null)
	{
		$page['header'] =  'Task | ' . BRAND_NAME;

		$page['task'] = $this->CustomModel->getAllfromWhere('task', array('manager_id' => Manager::$userId));

		$page['employee'] = $this->CustomModel->getAllfromWhere('employees', array('managerId' => Manager::$userId));

		$this->load->view('admin/layout/header', $page);
		$this->load->view('admin/layout/sidebar');
		$this->load->view('manager/pages/taksMaster');
		$this->load->view('manager/scripts/projectManager');
		$this->load->view('admin/layout/footer');
	}
	public function projectTask($id = null, $projectName = null)
	{
		if ($id) {

			// $page['task'] = $this->CustomModel->getAllfromWhere('task', array('project_id' => base64_decode($id)));

			$page['task'] = $this->CustomModel->getTaskListbyprojectId(base64_decode($id));

			$page['project'] = $this->CustomModel->getAllfromWhere('project', array('project_id' => base64_decode($id)));

			// echo '<pre>';

			// 	print_r($page['task']);die;

			$page['employee'] = $this->CustomModel->getAllfromWhere('employees', array('managerId' => Manager::$userId));

			$page['projecName'] = base64_decode($projectName);
			$page['projecid'] = base64_decode($id);

			$this->load->view('admin/layout/header', $page);
			$this->load->view('admin/layout/sidebar');
			$this->load->view('manager/pages/projectTaskmaster');
			$this->load->view('manager/scripts/projectManager');
			$this->load->view('admin/layout/footer');
		}
	}
	// Functio to get Task list by task title
	public function tasklist()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (isset($_POST)) {
				$data = $this->CustomModel->getTaskByServicesId($_POST['s'], $_POST['t']);
				echo json_encode($data, true);
			}
		}
	}

	// Functio to get Task list by services id title
	public function tasklist_by_service_id()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			// print_r($_POST['serviceid']);die;
			if (isset($_POST)) {
				$data =$this->CustomModel->getAllfromWhere('master_tasks', array('category'=>$_POST['serviceid']));
				echo json_encode($data, true);
			}
		}
	}

	public function allocateTaskToUser()
	{
		$this->common->allocateTaskToUser();
	}

	// Function for Selectting services by project id
	public function selected_services($var = null)
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (isset($_POST)) {
				$res = $this->CustomModel->getservices($_POST['id']);
				$res = sService($res[0]['services']);
				// echo '<pre>';
				// print_r($res[0]['title']);die;

				echo json_encode($res, true);
			}
		}
	}
	// Function for add new task to the master list
	public function addnewTask()
	{

		// echo '<pre>';
		// print_r($_POST);
		// die;
		// // // $tableName = $_POST['flage'];
		// // // $descrption = validateInput($_POST['description']);
		$activeStatus = true;
		$rowData = array(
			'title' => validateInput($_POST['task']),
			'description' => 'Not available',
			'active_status' => $activeStatus
		);
		$condistion = array('category' => $_POST['serviceid'], 'title' => validateInput($_POST['task']));
		$res = $this->CustomModel->getAllfromWhere('master_tasks', $condistion);
		if (!empty($res)) {
			echo json_encode(array('message' => $_POST['task'] . ' , already exists', 'type' => 'error'));
		} elseif ($res == '') {
			$Id = $this->MainModel->getNewIDorNo('master_tasks', 'TSK');
			$rowData['task_id'] = $Id;
			$rowData['category'] = validateInput($_POST['serviceid']);
			$rowData['created_timestamp'] = timestamp();
			$rowData['created_by'] = Manager::$userId;
			$result = $this->MainModel->getinsertedData('master_tasks', $rowData);

			echo $result != '' ? json_encode(array('message' => $_POST['task'] . ', Added to the master list', 'type' => 'success')) : json_encode(array('message' => 'Opps somthing went wrong. contact IT.', 'type' => 'error'));
		}
	}
	// Function for Selectting services by project id
	public function psotServicesTask($var = null)
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (isset($_POST)) {
				// echo '<pre>';
				// print_r($_POST);
				// die;
				$serviceTask = array(
					'task_id' => $_POST['selected-task'],
					'service_category_id' => $_POST['service'],
					'project_id' => $_POST['project-id'],
					'start_date' => yymmdd($_POST['st-date']),
					'end_date' => yymmdd($_POST['et-date']),
					'created_by' => Manager::$userId,
					'assigned_hrs' => $_POST['hours'],
					'created_date' => date("Y-m-d h:i:s")
				);

				$condition = array(
					'task_id' => $_POST['selected-task'],
					'service_category_id' => $_POST['service'],
					'project_id' => $_POST['project-id']
				);

				$res = $this->MainModel->selectAllFromTableWhere('task_project_relation', $condition);

				// print_r($_POST);
				// print_r($res);
				// die;
				if ($res > 0) {
					echo json_encode(array('msg' => 'The Task already exist.', 'type' => 'error'));
				} else {
					$res = $this->CustomModel->insert('task_project_relation', $serviceTask);
					if (isset($res)) {
						echo json_encode(array('msg' => 'Task added to this project', 'type' => 'success'));
					} else {
						echo json_encode(array('msg' => 'Opps! some error occored, Contact IT.', 'type' => 'error'));
					}
				}
			}
		}
	}
	// Timesheet weekly
	public function timesheet($day = null, $date = null)
	{
		$day = base64_decode($day);
		$date = base64_decode($date);
		$page['header'] =  'Timesheet | ' . BRAND_NAME;
		$data['dateDetails'] = $this->common->getWeeklyTimesheetDetails(Manager::$userId, $day, $date);
		// $data['class'] = __class__;

		$this->load->view('admin/layout/header', $data);
		$this->load->view('admin/layout/sidebar');
		$this->load->view('template/Timesheet');
		$this->load->view('template/scripts/TimesheetScript');
		$this->load->view('admin/layout/footer');
	}
	function dailyTimesheet($userId = null, $date = null)
	{
		$id = base64_decode($userId);

		// print_r($id);
		$currentDate = date('Y-m-d');
		$page['header'] =  'Daily Timesheet | ' . BRAND_NAME;
		$taskArr = $this->CustomModel->getDailyTask($id, $currentDate);
		// // echo '<pre>';
		// // print_r($taskArr);
		// // die;
		$hrs = 0;
		$minute = 0;

		if ($taskArr) {
			for ($i = 0; $i < count($taskArr); $i++) {
				$minute += (int)$taskArr[$i]['consumedTime'];
			}
			$hrs = $minute / 60;
		} else {
			$hrs = 0.0;
		}

		// $timeArraySlt = [];
		// $taskList = [];
		// $timeArr = timeRange(7, 24);

		// for ($i = 0; $i < count($timeArr) - 1; $i++) {
		// 	$timeArraySlt[$timeArr[$i]] = array();
		// }

		// if ($taskArr) {
		// 	foreach ($timeArraySlt as $timeSlt => $task) {
		// 		for ($j = 0; $j < count($taskArr); $j++) {

		// 			$basetime = date("H:i:s", strtotime($timeSlt));

		// 			$bt = explode(':', $basetime);
		// 			$searchTime = explode(':', $taskArr[$j]['taskStTime']);

		// 			$sTtime =  $taskArr[$j]['taskStTime'];

		// 			$sTtime = date("H:i:s", strtotime($taskArr[$j]['taskStTime']));

		// 			$sTtime = ($sTtime == 00) ? 12 : $sTtime;
		// 			// echo '<br/>';
		// 			// print_r($sTtime);
		// 			$sEdtime = explode(':', $taskArr[$j]['taskedTime']);
		// 			if ($bt[0] == $searchTime[0]) {
		// 				$baseNext = $bt[0] + 1;
		// 				if (($sEdtime[0] <= $baseNext)) {
		// 					$taskList[$sTtime] = $taskArr[$j];
		// 					array_push($timeArraySlt[$timeSlt], $taskList);
		// 					$taskList = [];
		// 				}
		// 			} else {
		// 				$page['dailytimesheet'] = $timeArraySlt[$timeSlt];
		// 			}
		// 		}
		// 	}
		// }

		$page['dailytimesheet'] = $taskArr;
		$page['totalhrs'] = $hrs;
		// my_print($timeArraySlt);die;
		$this->load->view('admin/layout/header', $page);
		$this->load->view('admin/layout/sidebar');
		$this->load->view('template/daily-timesheet', $page);
		$this->load->view('manager/scripts/projectManager');
		$this->load->view('admin/layout/footer');
	}
	// Function to show daily task
	function booketimes()
	{
		$cdate = date('Y-m-d');
		// $data['allocatedTask'] = $this->CustomModel->getDailyAllocatedTasks(Manager::$userId, $cdate);
		$data['projects'] = $this->CustomModel->getProjectByAssignTask(Manager::$userId, $cdate);

		// echo '<pre>';
		// print_r($data['projects']);die;

		$data['task'] = $this->CustomModel->getDailyTask(Manager::$userId, $cdate);
		$data['document'] = $this->CustomModel->getAllfromTable('master_document');
		$this->load->view('admin/layout/header');
		$this->load->view('admin/layout/sidebar');
		$this->load->view('template/bookedtime', $data);
		$this->load->view('admin/layout/footer');
		$this->load->view('template/scripts/bookedtime');
	}

	function showTask($id = null)
	{
		$id = base64_decode($id);
		$condition = array('task_id' => $id);
		$data['task'] = $this->MainModel->selectAllFromTableWhere('taskstatus', $condition);
		// my_print($data['task']);
		$this->load->view('admin/layout/header');
		$this->load->view('admin/layout/sidebar');
		$this->load->view('template/viewTask', $data);
		$this->load->view('admin/layout/footer');
		$this->load->view('template/scripts/dailytimesheet');
	}
	// Select all users
	public function allUser($day = null, $date = null, $dateString = null)
	{
		$day = base64_decode($day);
		$date = base64_decode($date);
		$data['dateString'] = base64_decode($dateString);
		$dateDetails = $this->common->getDateRange($day, $date);
		// // print_r($dateDetails);
		// // die();
		$currentWeek = intval($dateDetails['week']);
		$currentYear = $dateDetails['year'];
		$data['startDate'] = $dateDetails['startDate'];
		$data['endDate'] = $dateDetails['endDate'];


		$data['allUsers'] = $this->CustomModel1->getAllocatedUsers(Manager::$userId, $currentWeek, $currentYear);
		// echo "<pre>";
		// print_r($data['allUsers']);die;

		$this->load->view('admin/layout/header');
		$this->load->view('admin/layout/sidebar');
		$this->load->view('manager/pages/AllUser', $data);
		$this->load->view('admin/layout/footer');
		$this->load->view('manager/scripts/scripts/AllUserScript');
	}
	public function getTask()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (isset($_POST)) {
				// print_r($_POST);
				// die;

				$condistion = array(
					'task_id' => base64_decode($_POST['id']),
					'project_id' => base64_decode($_POST['projectid']),
					'taskStTime' => base64_decode($_POST['taskStTime']),
					'taskedTime' => base64_decode($_POST['taskedTime']),

				);
				// print_r($condistion);
				// die;

				$task = $this->MainModel->selectAllFromTableWhere('taskstatus', $condistion);
				echo json_encode($task[0]);
			}
		}
	}
	public function rejectTask()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (isset($_POST)) {
				// print_r($_POST);
				$id = $_POST['taskid'];
				$condition = array('taks_id' => $id, 'start_time' => $_POST['st'], 'end_time' => $_POST['et']);
				$data = array('status' => REJECT, 'remark' => validateInput($_POST['remark']));
				$task = $this->MainModel->updateWhere('dailytimesheet',	$data, $condition);
				// print_r($task);
				echo ($task == true) ? json_encode(array('msg' => 'Task rejected.', 'type' => 'success')) : json_encode(array('msg' => 'Opps! some error occored, Contact IT.', 'type' => 'error'));
			}
		}
	}
	public function approved_task()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (isset($_POST)) {
				// print_r($_POST);
				$id = $_POST['task_id'];
				// $condition = array('taks_id' => $id);
				$condition = array('taks_id' => $id, 'start_time' => $_POST['st'], 'end_time' => $_POST['et']);
				$data = array('status' => APPROVE);
				$task = $this->MainModel->updateWhere('dailytimesheet',	$data, $condition);
				// print_r($task);
				echo ($task == true) ? json_encode(array('msg' => 'Task approved.', 'type' => 'success')) : json_encode(array('msg' => 'Opps! some error occored, Contact IT.', 'type' => 'error'));
			}
		}
	}

	// public function userTimesheet($userId = null, $day = null, $date = null)
	// {
	// 	$data['userId'] = $userId = base64_decode($userId);
	// 	$day = base64_decode($day);
	// 	$date = base64_decode($date);

	// 	$data['dateDetails'] = $this->common->getWeeklyTimesheetDetails($userId, $day, $date);
	// 	$data['class'] = __class__;

	// 	// echo '<pre>';

	// 	// print_r($data['dateDetails']);die;

	// 	$this->load->view('admin/layout/header');
	// 	$this->load->view('admin/layout/sidebar');
	// 	$this->load->view('manager/pages/UserTimesheet', $data);
	// 	$this->load->view('manager/scripts/scripts/UserTimesheetScript', $data);
	// 	$this->load->view('admin/layout/footer');
	// }

	// public function saveUserTimesheetData($userId = null)
	// {
	// 	// $result = $this->common->saveTimesheetData(Manager::$companyId, $userId);
	// 	$result = $this->common->saveTimesheetData($userId);
	// 	if ($result) {
	// 		echo json_encode(array("success" => "Timesheet is saved"));
	// 	} else {
	// 		echo json_encode(array("error" => "Unable to save hours, Please contact service provider"));
	// 	}
	// }

	// public function submitUserTimesheetData($userId = null)
	// {
	// 	$this->common->submitTimesheetData($userId);
	// }

	// public function submitTimesheetData()
	// {
	// 	$this->common->submitTimesheetData(Manager::$userId);
	// }

	// public function removeTaskFromTimesheet()
	// {
	// 	$this->common->removeTaskFromTimesheet(Manager::$userId, __class__);
	// }

	// public function approveRejectTimesheet()
	// {
	// 	if (isset($_POST['userId']) && isset($_POST['week']) && isset($_POST['year']) && isset($_POST['status']) && isset($_POST['remarks'])) {
	// 		extract($_POST);
	// 		$where = array(
	// 			// 'companyId' => Manager::$companyId,
	// 			'employeeId' => $userId,
	// 			'week' => $week,
	// 			'year' => $year,
	// 		);

	// 		$data = array(
	// 			'status' => $status,
	// 			'remarks' => $remarks
	// 		);

	// 		$result = $this->MainModel->updateWhere("employee_weekly_timesheet", $data, $where);
	// 		if ($result) {
	// 			echo json_encode(array("success" => "Timesheet Status is updated successfully"));

	// 			if ($status == "rejected") {
	// 				$userDetails = $this->MainModel->selectAllFromWhere("employees", array("people_id" => $userId));

	// 				$managerDetails = $this->MainModel->selectAllFromWhere("employees", array("people_id" => Manager::$userId));

	// 				if ($userDetails && $managerDetails) {
	// 					$message = $managerDetails[0]['first_name'] . ' ' . $managerDetails[0]['last_name'] . " (Manager) has rejected your timesheet";
	// 					sentmail($userDetails[0]['email'], 'Timesheet Rejection :GennextIT', $message);
	// 				}
	// 			}
	// 		} else {
	// 			echo json_encode(array("error" => "Unable to change status, No changes made"));
	// 		}
	// 	} else {
	// 		echo json_encode(array("error" => "System error found, Please contact service provider"));
	// 	}
	// }
}
