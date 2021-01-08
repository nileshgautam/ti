<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Employee extends ci_controller
{
	private static $userId;
	private static $companyId;
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('MainModel');
		$this->load->model('CustomModel1');
		$this->load->model('CustomModel');
		$this->load->model('EmployeeModel');
		$this->load->helper('common');
		$this->load->library("common");

		if (!$_SESSION['logged_in']) {
			redirect('Login');
		}
		Employee::$userId = $_SESSION['logged_in']['people_id'];
		// Employee::$companyId = $_SESSION['employeeInfo']['companyId'];
	}

	public function allocatedTask()
	{
		// $data['allocatedTask'] = $this->CustomModel->getAllocatedProjects(Employee::$userId);
		$data['allocatedTask'] = $this->CustomModel->getAllocatedTask(Employee::$userId);
		// print_r($data['allocatedTask']);die;
		// $data['class'] = __class__;
		$this->load->view('admin/layout/header');
		$this->load->view('admin/layout/sidebar');
		$this->load->view('template/AllocatedTask', $data);
		$this->load->view('admin/layout/footer');
		$this->load->view('template/scripts/AllocateTaskScript', $data);
	}

	public function timesheet($day = null, $date = null)
	{
		$day = base64_decode($day);
		$date = base64_decode($date);
		// echo "<pre>";
		$data['dateDetails'] = $this->common->getWeeklyTimesheetDetails(Employee::$userId, $day, $date);
		// $data['class'] = __class__;
		// 	echo "<pre>";
		// 	print_r($data['dateDetails']);
		// die;
		$this->load->view('admin/layout/header');
		$this->load->view('admin/layout/sidebar');
		$this->load->view('template/Timesheet', $data);
		$this->load->view('template/scripts/TimesheetScript', $data);
		$this->load->view('admin/layout/footer');
	}

	public function saveTimesheetData()
	{
		$result = $this->common->saveTimesheetData(Employee::$userId);
		if ($result) {
			echo json_encode(array("success" => "Data is saved"));
		} else {
			echo json_encode(array("error" => "Unable to save hours, Please contact service provider"));
		}
	}

	public function submitUserTimesheetData($userId = null)
	{
		$this->common->submitTimesheetData(Employee::$userId);
	}

	// Function to show daily task
	function dailytimesheet()
	{
		$cdate = date('Y-m-d');


		$data['allocatedTask'] = $this->CustomModel->getDailyAllocatedTasks(Employee::$userId, $cdate);

		$data['projects'] = $this->CustomModel->getProjectByAssignTask(Employee::$userId, $cdate);




		// echo Employee::$userId;
		// echo $cdate;


		$data['task'] = $this->CustomModel->getDailyTask(Employee::$userId, $cdate);
		$data['document'] = $this->CustomModel->getAllfromTable('master_document');

		// echo '<pre>';
		// print_r($data['projects']); die;

		$this->load->view('admin/layout/header');
		$this->load->view('admin/layout/sidebar');
		$this->load->view('template/bookedtime', $data);
		$this->load->view('admin/layout/footer');
		$this->load->view('template/scripts/bookedtime');
	}


	public function getAllocatedtask()
	{
		$cdate = date('Y-m-d');
		$projectid = $_POST['projectid'];
		$result = $this->CustomModel->getDailyAllocatedTasks(Employee::$userId, $cdate, $projectid);
		echo json_encode($result);
	}


	function getBookedTime()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$getbookedSlots = $this->CustomModel->getBookedSlots(Employee::$userId, date('Y-m-d'));
			echo json_encode($getbookedSlots);
		} else {
			echo json_encode('error contact IT');
		}
	}


	function getTask()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$data = $_POST;
			// print_r($data);
			// die;
			$condition = array('task_id' => $_POST['taskId']);
			$tableName = 'taskstatus';
			$getbookedSlots = $this->MainModel->selectAllFromWhere($tableName, $condition);
			echo json_encode($getbookedSlots[0]);
		} else {
			echo json_encode('error contact IT');
		}
	}

	function getAllTask()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$condition = array('employeeId' => Employee::$userId, 'save_date' => date('Y-m-d'));
			$tableName = 'taskstatus';
			$getbookedSlots = $this->MainModel->selectAllFromWhere($tableName, $condition);
			// print_r($getbookedSlots);die;
			echo json_encode($getbookedSlots);
		} else {
			echo json_encode('error contact IT');
		}
	}

	// Function to upload files to folder
	function uploadFile()
	{
		// print_r($_FILES);
		// die;
		$filesRes = uploadData($_FILES, base64_decode($_POST['projectid']));

		// $res=json_decode($filesRes,true);
		// print_r($res);die;

		echo $filesRes;
	}

	// Function To Insert data into DB dailytimesheet
	function updateTask()
	{
		// print_r($_POST);
		// die;
		if ($_POST) {
			$file = isset($_POST['fileData']) ? $_POST['fileData'] : 'No-files';
			$data = array(
				'project_id' => validateInput($_POST['projectId']),
				'servicesId' => validateInput($_POST['servicesId']),
				'taks_id' => validateInput($_POST['taskId']),
				'client_id' => validateInput($_POST['clientid']),
				'start_time' => date("H:i", strtotime($_POST['stTime'])),
				'end_time' => date("H:i", strtotime($_POST['edTime'])),
				'description' => validateInput($_POST['description']),
				'files' => $file,
				'employee_id' => Employee::$userId,
				'save_date' => timestamp(),
				'status' => 'Saved'
			);
			if ($data) {
				$res = $this->CustomModel->insert('dailytimesheet', $data);
				echo ($res != '') ? json_encode(array('message' => 'Task saved', 'type' => 'success')) : json_encode(array('message' => 'Opps contact IT, or Service provider', 'type' => 'error'));
			}
		}
	}


	function getfiles()
	{
		if ($_POST) {
			$condition = array(
				'start_time' => base64_decode($_POST['st']),
				'end_time' => base64_decode($_POST['et']),
				'project_id' => base64_decode($_POST['projectid']),
				'taks_id' => base64_decode($_POST['taskid']),
				'save_date' => date('Y-m-d')
			);
			// echo '<pre>';
			$tableName = 'dailytimesheet';
			$getfiles = $this->MainModel->selectAllFromWhere($tableName, $condition);
			echo json_encode($getfiles[0]);

		}
	}

	// Function To Insert data into DB dailytimesheet
	function updateSelectedTask()
	{
		if ($_POST) {
			$file = json_encode($_POST['doc']);
			// echo '<pre>';

			// print_r($_POST);die;

			$condition = array(
				'start_time' => base64_decode($_POST['st']),
				'end_time' => base64_decode($_POST['et']),
				'project_id' => base64_decode($_POST['proid']),
				'taks_id' => base64_decode($_POST['taskid']),
				'save_date' => date('Y-m-d'),
				'employee_id' => $_POST['employee_id']

			);

			// print_r($condition);die;

			if ($file) {
				$res = $this->CustomModel->update_row('dailytimesheet', $condition, array('files' => $file));
				// print_r($res);
				echo ($res == true) ? json_encode(array('message' => 'Docment saved', 'type' => 'success')) : json_encode(array('message' => 'Opps contact IT, or Service provider', 'type' => 'error'));
			}
		}
	}


	function updateRow()
	{
		if ($_POST) {

			$data = [];
			// print_r($_POST);die;
			$condition = array(
				'start_time' => base64_decode($_POST['condition']['st']),
				'end_time' => base64_decode($_POST['condition']['et']),
				'project_id' => base64_decode($_POST['condition']['pid']),
				'taks_id' => base64_decode($_POST['condition']['task_id']),
				'save_date' => date('Y-m-d')
			);

			if ($_POST['flag'] == 'description') {
				$data = array(
					'description' => ($_POST['data']['userDescription'] != '') ? $_POST['data']['userDescription'] : 'No-description',
				);
			} elseif ($_POST['flag'] == 'time') {
				$data = array(
					'start_time' => $_POST['data']['st'],
					'end_time' => $_POST['data']['et'],
				);
			}

			// print_r($data);die;
			$res = $this->CustomModel->update_row('dailytimesheet', $condition, $data);

			echo ($res == true) ? json_encode(array('message' => 'Row updated', 'type' => 'success')) : json_encode(array('message' => 'Opps contact IT, or Service provider', 'type' => 'error'));
		} else {
			echo json_encode(array('message' => 'No Data available', 'type' => 'error'));
		}
	}



	// Update task status saved to submit
	public function submitDailyTask($var = null)
	{
		if ($_POST) {
			$Arr = [];
			$status = '';
			$arr = $_POST['data'];
			// print_r($arr);die;
			$tableName = 'dailytimesheet';
			foreach ($arr as $item) {

				$condition['taks_id'] = $item['id'];
				$condition['start_time'] = base64_decode($item['st']);
				$condition['end_time'] = base64_decode($item['et']);

				$subarr['status'] = 'submitted';
				$subarr['submit_date'] = date('Y-m-d');

				// array_push($Arr, $subarr);
				$res = $this->CustomModel->update_row($tableName, $condition, $subarr);
				$status =	($res == false) ? false : true;
			}

			// // $res =updateBatch('dailytimesheet', $Arr, 'taks_id');
			// //  // update batch
			// //  function updateBatch($tablename = null, $data = null, $id = null)

			// //  {
			// $this->db->where('start_time');
			// $this->db->where('end_time');
			// $query = $this->db->update_batch('dailytimesheet', $Arr, 'taks_id');

			// return ($query != null) ? true : false;


			echo ($status == true) ? json_encode(array('message' => 'Task Submitted', 'type' => 'success')) : json_encode(array('message' => 'Task Submitted', 'type' => 'error'));
		}
	}

	// Function to delete data
	public function deleteTask()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// print_r($_POST);
			// die;
			$id = base64_decode($_POST['row_id']);
			$table = $_POST['table_name'];
			$condition = array(
				'taks_id' => $id,
				'save_date' => date('Y-m-d'),
				'start_time' => time_in_24_hour_format(base64_decode($_POST['st'])),
				'end_time' => time_in_24_hour_format(base64_decode($_POST['et'])),
				'dailyts_id' => base64_decode($_POST['dailyts_id'])


			);


			// print_r($condition);die;

			$res = $this->MainModel->deleteFromTable($table, $condition);
			echo $res == true ? json_encode(array('message' => 'Task removed.', 'type' => 'success')) : json_encode(array('message' => 'Opps something wrong! Contact IT.', 'type' => 'error'));
		}
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

	public function isAvaible($var = null)
	{
		// print_r($_POST);die;

		$st = time_in_24_hour_format($_POST['stTime']);
		$et = time_in_24_hour_format($_POST['endTime']);

		$condition = array('start_time' => $st, 'end_time' => $et, 'employee_id' => Employee::$userId);
		$res = $this->MainModel->selectAllFromWhere('dailytimesheet', $condition);

		if ($res > 0) {
			// print_r($res);
			echo json_encode(array('message' => 'true'));
		} else {
			echo json_encode(array('message' => 'false'));
		}
	}

	// public function removeTaskFromTimesheet()
	// {

	// 	$this->common->removeTaskFromTimesheet(Employee::$userId, __class__);
	// }

	public function getContract()
	{
		if (isset($_POST['clientId'])) {
			$employeeId = $_SESSION['userInfo']['userId'];
			$clientId = $_POST['clientId'];
			$container = [];
			$clientDetails = $this->EmployeeModel->getUniqueContract($employeeId, $clientId);

			if ($clientDetails) {
				echo json_encode(array("success" => $clientDetails));
			} else {
				echo json_encode(array("error" => "No details found regarding this client"));
			}
		} else {
			echo json_encode(array("error" => "System Error, Please contact IT"));
		}
	}

	public function getLocations()
	{
		if (isset($_POST['contractId'])) {
			$employeeId = $_SESSION['userInfo']['userId'];
			$contractId = $_POST['contractId'];
			$clientId = $_POST['clientId'];

			$container = [];
			$contractDetails = $this->EmployeeModel->getUniqueLocations($employeeId, $contractId, $clientId);

			if ($contractDetails) {
				echo json_encode(array("success" => $contractDetails));
			} else {
				echo json_encode(array("error" => "No details found regarding this client"));
			}
		} else {
			echo json_encode(array("error" => "System Error, Please contact IT"));
		}
	}

	public function getServices()
	{
		// print_r($_POST);
		// die();
		if (isset($_POST['contractId']) && isset($_POST['clientId'])) {
			$employeeId = $_SESSION['userInfo']['userId'];
			$contractId = $_POST['contractId'];
			$clientId = $_POST['clientId'];
			$locationId = $_POST['locationId'];

			$container = [];
			$serviceDetails = $this->EmployeeModel->getUniqueServices($employeeId, $contractId, $clientId, $locationId);

			if ($serviceDetails) {
				echo json_encode(array("success" => $serviceDetails));
			} else {
				echo json_encode(array("error" => "No details found regarding this client"));
			}
		} else {
			echo json_encode(array("error" => "System Error, Please contact IT"));
		}
	}

	public function getTimeSheetDetails()
	{
		if (isset($_POST['date'])) {
			$date = $_POST['date'];
			$employeeId = $_SESSION['userInfo']['userId'];

			$result = $this->EmployeeModel->getTimeSheetDetails($date, $employeeId);

			if ($result) {
				echo json_encode(array("success" => $result));
			}
		} else {
			echo json_encode(array("error" => "System Error, Please contact IT"));
		}
	}

	public function saveTimesheet()
	{

		if (isset($_POST['startTime']) && isset($_POST['endTime']) && isset($_POST['client'])) {
			$employeeId = $_SESSION['userInfo']['userId'];
			$count = count($_POST['activity']);

			$checkDetails = $this->MainModel->selectAllFromWhere("timesheet", array("employeeId" => $employeeId, "date" => $_POST['date'], "startTime" => $_POST['startTime'], "endTime" => $_POST['endTime']));
			if ($checkDetails) {
				echo json_encode(array("error" => "Entry exists for this from time and to time for today"));
				return;
			}

			for ($i = 0; $i < $count; $i++) {
				$file = '';
				if (isset($_FILES['attchment']['name'][$i])) {

					$attchment = date("YmdHis") . $_FILES['attchment']['name'][$i];
					$target = "uploads/";
					if (move_uploaded_file($_FILES['attchment']['tmp_name'][$i], $target . $attchment)) {
						$file = $attchment;
					}
				}

				$data = array(
					"date" => $_POST['date'],
					"employeeId" => $employeeId,
					"startTime" => $_POST['startTime'],
					"endTime" => $_POST['endTime'],
					"clientId" => $_POST['client'],
					"contractId" => $_POST['contract'],
					"serviceId" => $_POST['service'],
					"locationId" => $_POST['location'],
					"activityId" => $_POST['activity'][$i],
					"budgetedHours" => $_POST['budgetedHours'],
					"consumedHours" => $_POST['consumed'],
					"workingHours" => $_POST['hours'][$i],
					"totalWorkingHours" => $_POST['diffHours'],
					"attachment" => $file,
					"remarks" => $_POST['remark'][$i],
				);

				// $this->db->trans_begin();
				$result = $this->MainModel->insertInto('timesheet', $data);
			}

			if (isset($result) && $result) {
				echo json_encode(array("success" => "Timesheet saved successfully"));
			} else {
				echo json_encode(array("error" => "System Error, Please contact IT"));
			}
		} else {
			echo json_encode(array("error" => "System Error, Please contact IT"));
		}
	}

	public function addAllocatePost()
	{
		$this->common->addUserTask(Employee::$userId);
	}
}


