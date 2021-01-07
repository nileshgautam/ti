<?php

class Common
{
	private $CI;
	public function __construct()
	{
		$this->CI = &get_instance();
		$this->CI->load->model("MainModel");
		$this->CI->load->helper("validate");
		$this->CI->load->model("CustomModel");
	}

	public function saveExpense($companyId, $userId, $class)
	{
		if (isset($_POST['category']) && isset($_POST['expenseDate'])) {
			// $description = $_POST['description'];
			$category = $_POST['category'];
			$expenseDate = explode("/", $_POST['expenseDate']);
			$expenseDate = date("Y-m-d", mktime(0, 0, 0, $expenseDate[1], $expenseDate[0], $expenseDate[2]));
			$project = $_POST['project'];
			$cost = $_POST['cost'];
			$gst = $_POST['gst'];
			$comment = $_POST['comment'];
			$attachment = "";

			if (isset($_FILES['attachment']['name'])) {
				$target = base_url() . "/uploads/expense/";

				if (move_uploaded_file($_FILES['attachment']['tmp_name'], $target . $attachment)) {
					$attachment = $_FILES['attachment']['name'];
				}
			}

			$data = array(
				"userId" => $userId,
				"companyId" => $companyId,
				"category" => $category,
				"expenseDate" => $expenseDate,
				"project" => $project,
				"cost" => $cost,
				"gst" => $gst,
				"comment" => $comment,
				"attachment" => $attachment
			);

			$result = $this->CI->MainModel->insertInto("expenses", $data);
			if ($result) {
				$this->CI->session->set_flashdata("success", "Expense added successfully");
			} else {
				$this->CI->session->set_flashdata("error", "System error found, Please contact service provider");
			}
		} else {
			$this->CI->session->set_flashdata("error", "System error found, Please contact service provider");
		}
		redirect($class . "/expenses");
	}

	public function saveTaskExpense($companyId, $userId, $class)
	{
		// print_r($_POST);
		// die();
		if (isset($_POST['category']) && isset($_POST['expenseDate'])) {
			// $description = $_POST['description'];
			$category = $_POST['category'];
			$expenseDate = explode("/", $_POST['expenseDate']);
			$expenseDate = date("Y-m-d", mktime(0, 0, 0, $expenseDate[1], $expenseDate[0], $expenseDate[2]));
			$taskId = $_POST['task'];
			$cost = $_POST['cost'];
			$gst = $_POST['gst'];
			$comment = $_POST['comment'];
			$attachment = "";

			if (isset($_FILES['attachment']['name'])) {
				$target = base_url() . "/uploads/expense/";

				if (move_uploaded_file($_FILES['attachment']['tmp_name'], $target . $attachment)) {
					$attachment = $_FILES['attachment']['name'];
				}
			}

			$data = array(
				"userId" => $userId,
				"companyId" => $companyId,
				"category" => $category,
				"expenseDate" => $expenseDate,
				"taskId" => $taskId,
				"cost" => $cost,
				"gst" => $gst,
				"comment" => $comment,
				"attachment" => $attachment
			);

			$result = $this->CI->MainModel->insertInto("task_expenses", $data);
			if ($result) {
				$this->CI->session->set_flashdata("success", "Expense added successfully");
			} else {
				$this->CI->session->set_flashdata("error", "System error found, Please contact service provider");
			}
		} else {
			$this->CI->session->set_flashdata("error", "System error found, Please contact service provider");
		}
		redirect($class . "/expenses");
	}

	public function getDateRange($day = null, $date = null)
	{
		$currentYear = date("Y");
		if ($day < 0) {
			$day = $day . " day";
		} else {
			$day = "+" . $day . " day";
		}

		if ($day != '' && $day != null && $date != null && $date != '') {
			$newYear = date("Y", strtotime($day . $date));
			if ($currentYear != $newYear) {
				$currentYear = $newYear;
			}
			$week_number = date("W", strtotime($day . $date));
		} else {
			$week_number = date("W");
		}

		$this_week_sd = date('m/d/Y', strtotime($currentYear . "W" . $week_number));
		//echo "<br>";
		$this_week_ed = date('m/d/Y', strtotime($currentYear . "W" . $week_number . "+6 days"));

		return [
			'week' => $week_number,
			'year' => $currentYear,
			'startDate' => $this_week_sd,
			'endDate' => $this_week_ed
		];
	}

	public function getWeeklyTimesheetDetails($userId = null, $day = null, $date = null)
	{

		$weeklyUserData = [];

		$requiredDate = requiredDates($day, $date);
		$allTask = $this->CI->CustomModel1->getTask($userId);
		$timesheetWeeklyDetails = $this->CI->MainModel->selectAllFromWhere("employee_weekly_timesheet", array("employeeId" => $userId, "year" => $requiredDate['currentYear'], "week" => (int)$requiredDate['week_number']));
		if ($allTask) {
			foreach ($allTask as $task) {
				$i = 0;
				// echo '<pre>';
				// print_r($task);die;
				foreach ($requiredDate['daterange'] as $date) {
					$weeklyUserData[$task['taskId']][$i]['date'] = $date->format("Y-m-d");
					// $weeklyUserData[$task['taskId']][0]['projectName'] = $task['name'];
					$weeklyUserData[$task['taskId']][0]['taskName'] = $task['title'];
					$weeklyUserData[$task['taskId']][0]['scope'] = $task['scope'];
					$weeklyUserData[$task['taskId']][0]['projectId'] = $task['project_id'];
					$result = $this->getUserTimeSheetDetails($userId, $task['taskId'], $date->format("Y-m-d"));
					if ($result) {
						$weeklyUserData[$task['taskId']][$i]['hours'] = $result[0]['workingHours'];
					}
					$i++;
				}
			}
		}

		// if ($globalProjects) {
		// 	foreach ($globalProjects as $gProject) {
		// 		// echo '<pre>';
		// 		// print_r($gProject);
		// 		// die;

		// 		$i = 0;
		// 		foreach ($daterange as $date) {
		// 			$weeklyUserData[$gProject['task_id']][$i]['date'] = $date->format("Y-m-d");
		// 			$weeklyUserData[$gProject['task_id']][0]['projectName'] = $gProject['name'];
		// 			$weeklyUserData[$gProject['task_id']][0]['taskName'] = $gProject['title'];
		// 			$weeklyUserData[$gProject['task_id']][0]['scope'] = $gProject['scope'];
		// 			$weeklyUserData[$gProject['task_id']][0]['projectId'] = $gProject['task_id'];
		// 			$result = $this->getUserTimeSheetDetails($userId, $gProject['task_id'], $date->format("Y-m-d"));

		// 			if ($result) {
		// 				$weeklyUserData[$gProject['task_id']][$i]['hours'] = $result[0]['workingHours'];
		// 			}
		// 			$i++;
		// 		}
		// 	}
		// }


		// 		echo '<pre>';
		// print_r($weeklyUserData);
		// die;
		$dateDetails = array(
			'thisWeekSd' => $requiredDate['this_week_sd'],
			'thisWeekEd' => $requiredDate['this_week_ed'],
			'currentWeek' => $requiredDate['week_number'],
			'dateRange' => $requiredDate['daterange'],
			'userTimesheetData' => $weeklyUserData,
			'timesheetWeeklyDetails' => $timesheetWeeklyDetails
		);


		// echo "<pre>";
		// print_r($dateDetails);
		// die();
		return $dateDetails;
	}

	public function removeTaskFromTimesheet($userId = null, $class = null)
	{
		if (isset($_POST['tasks'])) {
			$projects = json_decode($_POST['tasks'], true);

			$this->CI->db->trans_begin();
			foreach ($projects as $project) {
				// $this->CI->MainModel->deleteFromTable("employee_task", array("companyId" => $companyId, "employeeId" => $userId, "taskId" => $project['taskId']));
				$this->CI->MainModel->deleteFromTable("employee_task", array("employeeId" => $userId, "taskId" => $project['taskId']));
			}

			if ($this->CI->db->trans_status() === FALSE) {
				$this->CI->db->trans_rollback();
				echo json_encode(array('error' => "Unable to remove task from timesheet, Please contact service provider"));
			} else {
				$this->CI->db->trans_commit();
				echo json_encode(array('success' => "Task is removed from timesheet successfully"));
			}
		} else {
			echo json_encode(array('error' => "System error found, Please contact service provider"));
		}
		// redirect($class."/timesheet");
	}

	public function getUserTimeSheetDetails($userId = null, $taskId = null, $date = null)
	{
		$result = $this->CI->MainModel->selectAllFromWhere("timesheet", array("employeeId" => $userId, "date" => $date, "taskId" => $taskId));
		return 	$result ? $result : FALSE;
	}

	public function saveTimesheetData($userId = null)
	{
		if (isset($_POST['timesheetData']) && isset($_POST['week'])) {
			$timesheetData = json_decode($_POST['timesheetData'], true);
			// print_r($timesheetData);
			// die();
			$week = $_POST['week'];
			$this->CI->db->trans_begin();
			if ($timesheetData) {
				foreach ($timesheetData as $details) {
					$data = array(
						// "companyId" => $companyId,
						"employeeId" => $userId,
						"workingHours" => $details['hours'],
						"date" => $details['date'],
						'week' => $week,
						"projectId" => $details['projectId'],
						"taskId" => $details['taskId']
					);
					$checkDataForDate = $this->CI->MainModel->selectAllFromWhere("timesheet", array("employeeId" => $userId, "date" => $details['date'], "taskId" => $details['taskId']));
					if ($checkDataForDate) {
						// $data['updatedAt'] = date("Y-m-d H:i:s");
						$result = $this->CI->MainModel->updateWhere("timesheet", $data, array("employeeId" => $userId, "date" => $details['date'], "taskId" => $details['taskId']));
					} else {
						$result = $this->CI->MainModel->insertInto("timesheet", $data);
					}
				}
			}

			if ($this->CI->db->trans_status() === FALSE) {
				$this->CI->db->trans_rollback();
				return false;
			} else {
				$this->CI->db->trans_commit();
				return true;
			}
		} else {
			return false;
		}
	}

	public function submitTimesheetData($userId)
	{
		if (isset($_POST['week']) && isset($_POST['year'])) {
			extract($_POST);
			$weeklyData = array(
				// "companyId" => $companyId,
				"employeeId" => $userId,
				"week" => $week,
				"year" => $year,
				"status" => 'submitted'
			);

			$checkCurrentWeekData = $this->CI->MainModel->selectAllFromWhere("employee_weekly_timesheet", $weeklyData);
			if (!$checkCurrentWeekData) {
				$result = $this->CI->MainModel->insertInto("employee_weekly_timesheet", $weeklyData);
				if ($result) {
					echo json_encode(array("success" => "Timesheet is submited successfully"));
				} else {
					echo json_encode(array("error" => "Unable to submit timesheet, Please contact service provider"));
				}
			} else {
				echo json_encode(array("error" => "Already submitted the timesheet for this week"));
			}
		} else {
			echo json_encode(array("error" => "System error found, Please contact service provider"));
		}
	}
	// Allocate task to users
	public function allocateTaskToUser()
	{

		// print_r($_POST);die;

		if (isset($_POST['startDate']) && isset($_POST['endDate']) && isset($_POST['users']) && isset($_POST['Hours']) && isset($_POST['taskId'])) {
			extract($_POST);
			$data = array(
				"employeeId" => $users,
				"startDate" => yymmdd($startDate),
				"endDate" => yymmdd($endDate),
				"budgetedHours" => $Hours,
				"taskId" => $_POST['taskId'],
				"project_id" => $_POST['projectid'],
				"allocatedAt" =>timestamp()
			);

		// print_r($data);die;


			$checkTask = $this->CI->MainModel->selectAllFromWhere("employee_task_relation", array("employeeId" => $users, 'taskId' => $taskId,"project_id" => $_POST['projectid']));
			// print_r($checkTask);die;

			// print_r($data);die;

			if ($checkTask) {
				// print_r($checkTask);die;
				echo json_encode(array('msg' => 'This task is already allocated to this user', 'type' => 'error'), true);
			} else {
				$result = $this->CI->MainModel->insertInto("employee_task_relation", $data);
				if ($result) {
					echo json_encode(array("msg" => "Task is allocated to user", "type" => "success"), true);
				} else {
					echo json_encode(array("msg" => "Unable to allocate task, Please contact service provider", 'type' => 'error'), true);
				}
			}
		} else {
			echo json_encode(array("msg" => "System error found, Please contact service provider", 'type' => 'error'), true);
		}
	}

	public function addUserTask($userId)
	{
		if (isset($_POST['tasks'])) {

			// print_r($_POST);die;
			$tasks = json_decode($_POST['tasks'], true);

			$this->CI->db->trans_begin();
			foreach ($tasks as $details) {
				$data = array(
					"employeeId" => $userId,
					"taskId" => $details['taskId']
				);

				$this->CI->MainModel->insertInto("employee_task", $data);
			}

			if ($this->CI->db->trans_status() === FALSE) {
				echo json_encode(array("error" => "Unable to add task, Please contact servider provider"));
				$this->CI->db->trans_rollback();
			} else {
				echo json_encode(array("success" => "Task added successfully"));
				$this->CI->db->trans_commit();
			}
		} else {
			echo json_encode(array("error" => "System error found, Please contact service provider"));
		}
	}

	public function addTask($companyId, $userId = null, $class = null)
	{
		if (isset($_POST['hours']) && isset($_POST['taskName']) && isset($_POST['project']) && isset($_POST['taskDescription']) && isset($_POST['startDate']) && isset($_POST['endDate'])) {
			extract($_POST);
			$data = array(
				"companyId" => $companyId,
				"taskName" => $taskName,
				"taskDescription" => $taskDescription,
				"projectId" => $project,
				"managerId" => $userId,
				'endDate' => $endDate,
				'startDate' => $startDate,
				"budgeted_hours" => $hours
			);

			$result = $this->CI->MainModel->insertInto("tasks", $data);

			if ($result) {
				$this->CI->session->set_flashdata("success", "Task added successfully");
			} else {
				$this->CI->session->set_flashdata("error", "Unable to add task, Please contact service provider");
			}
		} else {
			$this->CI->session->set_flashdata("error", "System error found, Please contact service provider");
		}
		redirect($class . "/allTasks");
	}

	// public function getTaskByproject($companyId, $userId)
	// {
	// 	if (isset($_POST['projectId'])) {
	// 		extract($_POST);
	// 		$tasks = $this->CI->MainModel->selectAllFromWhere("tasks", array("companyId" => $companyId, "managerId" => $userId, "projectId" => $projectId));

	// 		if ($tasks) {
	// 			echo json_encode(array("success" => $tasks));
	// 		} else {
	// 			echo json_encode(array("error" => "No task found"));
	// 		}
	// 	} else {
	// 		echo json_encode(array("error" => "System error found, Please contact service provider"));
	// 	}
	// }

	// public function getProjectDetails($companyId)
	// {
	// 	if (isset($_POST['projectId'])) {
	// 		extract($_POST);

	// 		$result = $this->CI->MainModel->selectAllFromWhere("projects", array("companyId" => $companyId, "projectId" => $projectId));
	// 		if ($result) {
	// 			echo json_encode(array("success" => $result));
	// 		} else {
	// 			echo json_encode(array("error" => "System error found, Please contact service provider"));
	// 		}
	// 	} else {
	// 		echo json_encode(array("error" => "System error found, Please contact service provider"));
	// 	}
	// }

	// public function getTaskDetails($companyId)
	// {
	// 	if (isset($_POST['taskId'])) {
	// 		extract($_POST);

	// 		$result = $this->CI->CustomModel->getProductDetailsByTask($companyId, $taskId);
	// 		if ($result) {
	// 			echo json_encode(array("success" => $result));
	// 		} else {
	// 			echo json_encode(array("error" => "System error found, Please contact service provider"));
	// 		}
	// 	} else {
	// 		echo json_encode(array("error" => "System error found, Please contact service provider"));
	// 	}
	// }

	// public function saveUserDetails($companyId, $userId = null)
	// {
	// 	if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['mobile']) && isset($_POST['pincode']) && isset($_POST['address'])) {
	// 		extract($_POST);
	// 		$this->CI->db->trans_begin();
	// 		$data = array(
	// 			"companyId" => $companyId,
	// 			"name" => $name,
	// 			"email" => $email,
	// 			"phone" => $mobile,
	// 			"pincode" => $pincode,
	// 			"address" => $address,
	// 		);
	// 		if (isset($_FILES['userImage']['name'])) {
	// 			$datetime = strtotime("now");
	// 			$target = "uploads/userImage/";
	// 			$fileName = $datetime . $_FILES['userImage']['name'];
	// 			if (move_uploaded_file($_FILES['userImage']['tmp_name'], $target . $fileName)) {
	// 				$image = $fileName;
	// 				$data["image"] = $image;
	// 			}
	// 		}

	// 		$this->CI->MainModel->updateWhere("users", $data, array("companyId" => $companyId, "userId" => $userId));

	// 		if ($this->CI->db->trans_status() === FALSE) {
	// 			echo json_encode(array("error" => "Unable to change user details, Please contact service provider"));
	// 			$this->CI->db->trans_rollback();
	// 		} else {
	// 			echo json_encode(array("success" => "User details saved successfully"));
	// 			$this->CI->db->trans_commit();
	// 		}
	// 	} else {
	// 		echo json_encode(array("error" => "System error found, Please contact service provider"));
	// 	}
	// }
}
