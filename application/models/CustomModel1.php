<?php

class CustomModel1 extends ci_model
{
	public function validateUser($username, $password, $companyId)
	{
		$query = "SELECT * FROM users WHERE companyId = '$companyId' AND username = '" . $username . "' and password = '" . $password . "'";
		$q = $this->db->query($query)->result_array();
		return $this->db->affected_rows() ? $q : FALSE;
	}

	public function countClients()
	{
		// return $this->db->count_all_results('clients');
		$query = $this->db->query('SELECT * FROM clients');
		return $query->num_rows();
	}

	public function countEmployees()
	{
		// return $this->db->count_all_results('clients');
		$query = $this->db->query('SELECT * FROM users WHERE roleId=2');
		return $query->num_rows();
	}

	public function countServices()
	{
		// return $this->db->count_all_results('clients');
		$query = $this->db->query('SELECT * FROM services');
		return $query->num_rows();
	}

	public function countActivities()
	{
		// return $this->db->count_all_results('clients');
		$query = $this->db->query('SELECT * FROM activities');
		return $query->num_rows();
	}

	public function countTimesheet()
	{
		// return $this->db->count_all_results('clients');
		$query = $this->db->query('SELECT * FROM timesheet');
		return $query->num_rows();
	}


	function getemployee($id = null)
	{
		$query = $this->db->query("SELECT people_id, first_name, last_name FROM employees WHERE people_id='$id'");
		return $query->result_array();
	}

	public function countLocation()
	{
		// return $this->db->count_all_results('clients');
		$query = $this->db->query('SELECT * FROM locations');
		return $query->num_rows();
	}

	public function countContracts()
	{
		// return $this->db->count_all_results('clients');
		$query = $this->db->query('SELECT * FROM tasks');
		return $query->num_rows();
	}

	// public function getClientAllocatedServices()
	// {
	// 	$query = "SELECT client_contracts.id,client_contracts.clientId,clients.clientName,locations.locationName,contract.contractName,services.serviceName,client_contracts.budgetedHours,client_contracts.allocatedAt FROM `client_contracts` LEFT JOIN clients ON client_contracts.clientId=clients.clientId LEFT JOIN contract ON client_contracts.contractId=contract.contractId LEFT JOIN services on client_contracts.serviceId=services.serviceId LEFT JOIN locations ON client_contracts.locationId=locations.locationId";
	// 	$q = $this->db->query($query)->result_array();
	// 	return $this->db->affected_rows() ? $q : FALSE;
	// }

	// public function getClientContractLocations()
	// {
	// 	$query = "SELECT * FROM `client_assigned_location` left JOIN locations ON client_assigned_location.locationId=locations.locationId";
	// 	$q = $this->db->query($query)->result_array();
	// 	return $this->db->affected_rows() ? $q : FALSE;	
	// }

	public function assignedContractLocations()
	{
		$query = "SELECT client_contracts.id,client_contracts.clientId,clients.clientName,locations.locationName,tasks.contractName,services.serviceName,client_contracts.budgetedHours,client_contracts.allocatedAt FROM `client_contracts` LEFT JOIN clients ON client_contracts.clientId=clients.clientId LEFT JOIN tasks ON client_contracts.contractId=tasks.contractId LEFT JOIN services on client_contracts.serviceId=services.serviceId LEFT JOIN locations ON client_contracts.locationId=locations.locationId";
		$q = $this->db->query($query)->result_array();
		return $this->db->affected_rows() ? $q : FALSE;
	}

	public function getServiceAllocatedEmployees()
	{
		$query = "SELECT users.name,clients.clientName,newcontract.contract_name,services.serviceName,locations.locationName,employee_project_relation.budgetedHours,employee_project_relation.relationId FROM `employee_project_relation` LEFT JOIN users ON employee_project_relation.employeeId=users.userId LEFT JOIN clients ON employee_project_relation.clientId=clients.clientId LEFT JOIN newcontract ON employee_project_relation.contractId=newcontract.contractId LEFT JOIN services on employee_project_relation.serviceId=services.serviceId LEFT JOIN locations on employee_project_relation.locationId=locations.locationId GROUP BY newcontract.contractId";

		$q = $this->db->query($query)->result_array();
		return $this->db->affected_rows() ? $q : FALSE;
	}

	// public function getContract($clientId=null)
	// {
	// 	$query="SELECT * FROM `client_contracts` LEFT JOIN contract on client_contracts.contractId=contract.contractId WHERE client_contracts.clientId='".$clientId."'";
	// 	$q = $this->db->query($query)->result_array();
	// 	return $this->db->affected_rows() ? $q : FALSE;
	// }

	public function getLocation($clientId = null)
	{
		$query = "SELECT * FROM `client_location_relation` LEFT JOIN locations on client_location_relation.locationId=locations.locationId WHERE client_location_relation.clientId='" . $clientId . "'";
		$q = $this->db->query($query)->result_array();
		return $this->db->affected_rows() ? $q : FALSE;
	}

	// public function getClientLocations($clientId=null)
	// {
	// 	$query="SELECT * FROM `client_location_relation` LEFT JOIN locations on client_location_relation.locationId=locations.locationId WHERE client_location_relation.clientId='".$clientId."'";
	// 	$q = $this->db->query($query)->result_array();
	// 	return $this->db->affected_rows() ? $q : FALSE;
	// }


	public function getService($contractId = null)
	{
		$query = "SELECT * FROM `newcontract_client_service` LEFT JOIN services on newcontract_client_service.serviceId=services.serviceId WHERE contractId='" . $contractId . "' ";
		$q = $this->db->query($query)->result_array();
		return $this->db->affected_rows() ? $q : FALSE;
	}

	public function getTimesheet($startDate = null, $endDate = null)
	{
		$query = "SELECT users.name as employeeName,date,startTime,endTime,clients.clientName,newcontract.contract_name,services.serviceName,activities.activityName,budgetedHours,remarks,timesheet.createdAt FROM `timesheet` left JOIN clients on timesheet.clientId=clients.clientId LEFT JOIN newcontract on timesheet.contractId=newcontract.contractId LEFT JOIN services on timesheet.serviceId=services.serviceId LEFT JOIN activities on timesheet.activityId=activities.activityId LEFT JOIN users ON timesheet.employeeId=users.userId WHERE  DATE_FORMAT(STR_TO_DATE(date,'%d/%m/%Y'),'%Y-%m-%d') >= DATE_FORMAT(STR_TO_DATE( '" . $startDate . "','%d/%m/%Y'),'%Y-%m-%d') AND DATE_FORMAT(STR_TO_DATE(date,'%d/%m/%Y'),'%Y-%m-%d') <= DATE_FORMAT(STR_TO_DATE( '" . $endDate . "','%d/%m/%Y'),'%Y-%m-%d')";
		$q = $this->db->query($query)->result_array();
		return $this->db->affected_rows() ? $q : FALSE;
	}

	public function getClientLocations($clientId = null)
	{
		$query = "SELECT locations.locationId FROM `client_location_relation` LEFT JOIN locations on client_location_relation.locationId=locations.locationId WHERE clientId='" . $clientId . "'";
		$q = $this->db->query($query)->result_array();
		return $this->db->affected_rows() ? $q : FALSE;
	}

	public function assignedClientLocations($contractId = null)
	{
		$query = "SELECT * FROM `newcontract_client_location` LEFT JOIN locations on newcontract_client_location.locationId=locations.locationId WHERE newcontract_client_location.contractId='" . $contractId . "'";
		$q = $this->db->query($query)->result_array();
		return $this->db->affected_rows() ? $q : FALSE;
	}

	// public function assignedClientServices()
	// {
	// 	$query="SELECT client_assigned_services.clientId,services.serviceName,services.serviceId FROM `client_assigned_services` LEFT JOIN services on client_assigned_services.serviceId=services.serviceId";
	// 	$q = $this->db->query($query)->result_array();
	// 	return $this->db->affected_rows() ? $q : FALSE;
	// }

	public function clientLocations()
	{
		$query = "SELECT client_location_relation.clientId,locations.locationName FROM `client_location_relation` LEFT JOIN locations on client_location_relation.locationId=locations.locationId";
		$q = $this->db->query($query)->result_array();
		return $this->db->affected_rows() ? $q : FALSE;
	}

	public function getServiceAllocatedActivity()
	{
		$query = "SELECT * FROM `client_service_activity` LEFT JOIN activities ON client_service_activity.activityId=activities.activityId";
		$q = $this->db->query($query)->result_array();
		return $this->db->affected_rows() ? $q : FALSE;
	}

	public function getExpenses($companyId, $userId)
	{
		$query = "SELECT * FROM `expenses` t1 LEFT JOIN projects t2 ON t1.project=t2.projectId WHERE t1.companyId = '$companyId' AND t1.userId = '$userId'";
		$q = $this->db->query($query)->result_array();
		return $this->db->affected_rows() ? $q : FALSE;
	}

	public function getTaskExpenses($companyId, $userId)
	{
		$query = "SELECT * FROM `task_expenses` t1 LEFT JOIN tasks t2 ON t1.taskId=t2.taskId WHERE t1.companyId = '$companyId' AND t1.userId = '$userId'";
		$q = $this->db->query($query)->result_array();
		return $this->db->affected_rows() ? $q : FALSE;
	}

	public function getTask($userId)
	{
		$query = "SELECT * FROM `employee_task_relation` t1 RIGHT JOIN `employee_task` t2 ON t1.taskId = t2.taskId JOIN task t3 ON t3.task_Id = t1.taskId WHERE t1.employeeId = t2.employeeId AND t1.employeeId = '$userId'";
		$q = $this->db->query($query)->result_array();
		return $this->db->affected_rows() ? $q : FALSE;
	}

	public function getProductDetailsByTask($companyId, $taskId)
	{
		$query = "SELECT * FROM `tasks` t1 LEFT JOIN projects t2 ON t1.projectId=t2.projectId WHERE t1.companyId = '$companyId' AND t1.taskId = '$taskId'";
		$q = $this->db->query($query)->result_array();
		return $this->db->affected_rows() ? $q : FALSE;
	}

	public function getGlobalTasks()
	{
		$query = "SELECT * FROM `task` t1 JOIN project t2 ON t1.project_Id = t2.project_Id";
		$q = $this->db->query($query)->result_array();
		return $this->db->affected_rows() ? $q : FALSE;
	}

	public function getAllocatedProjects($companyId, $userId)
	{
		$query = "SELECT *, t1.projectId as allocatedContractId FROM `employee_project_relation` t1 JOIN users t2 ON t1.employeeId = t2.userId JOIN projects t3 ON t3.projectId = t1.projectId WHERE t1.companyId = '$companyId' AND t1.employeeId = '$userId'";

		$q = $this->db->query($query)->result_array();
		return $this->db->affected_rows() ? $q : FALSE;

		// if($result)
		// {
		// 	foreach($result as $key => $details)
		// 	{
		// 		$selfAddedTasks = $this->MainModel->selectAllFromWhere("employee_task",Array("employeeId"=>$userId,"taskId"=>$details['taskId']));

		// 		if($selfAddedTasks)
		// 		{
		// 			$result[$key]['employeeTaskId'] = $selfAddedTasks[0]['taskId'];
		// 		}
		// 		else
		// 		{
		// 			$result[$key]['employeeTaskId'] = "NULL";
		// 		}
		// 	}
		// 	return $result;
		// }
		// else
		// {
		// 	return FALSE;
		// }
	}

	public function getAllocatedWithConsumedHours($companyId, $userId)
	{
		$query = "SELECT SUM(t1.workingHours) as totalHours,t3.projectId,t3.projectName,t3.budgetedHours FROM timesheet t1 LEFT JOIN users t2 ON t1.employeeId = t2.userId JOIN projects t3 ON t1.projectId = t3.projectId WHERE t2.companyId = '$companyId' AND t2.managerId = '$userId' OR t2.userId = '$userId' GROUP BY t1.projectId";

		$q = $this->db->query($query)->result_array();
		return $this->db->affected_rows() ? $q : FALSE;
	}

	public function getAllocatedTaskWithConsumedHours($companyId, $userId, $projectId)
	{
		$query = "SELECT SUM(t1.workingHours) as taskHours,t4.taskName FROM timesheet t1 LEFT JOIN users t2 ON t1.employeeId = t2.userId JOIN projects t3 ON t1.projectId = t3.projectId JOIN tasks t4 ON t1.taskId = t4.taskId WHERE t1.companyId = '$companyId' AND (t2.managerId = '$userId' OR t2.userId = '$userId') AND t1.projectId = '$projectId' GROUP BY t1.taskId";

		$q = $this->db->query($query)->result_array();
		return $this->db->affected_rows() ? $q : FALSE;
	}

	public function getProjectAndRemainingDays($companyId, $userId)
	{
		$query = "SELECT t1.projectName,DATEDIFF(t1.endDate,NOW()) as days FROM `projects` t1 JOIN employee_project_relation t2 ON t1.projectId = t2.projectId WHERE t1.companyId = '$companyId' AND t2.employeeId = '$userId'";

		$q = $this->db->query($query)->result_array();
		return $this->db->affected_rows() ? $q : FALSE;
	}

	public function getBillableExpenses($companyId, $userId)
	{
		$query = "SELECT SUM(t1.cost) as cost FROM `expenses` t1 JOIN projects t2 ON t1.project = t2.projectId WHERE t1.companyId = '$companyId' AND t1.userId = '$userId' AND t1.category = 'Billable' GROUP BY t1.project";

		$q = $this->db->query($query)->result_array();
		return $this->db->affected_rows() ? $q : FALSE;
	}

	public function getNoNBillableExpenses($companyId, $userId)
	{
		$query = "SELECT SUM(t1.cost) as cost FROM `expenses` t1 JOIN projects t2 ON t1.project = t2.projectId WHERE t1.companyId = '$companyId' AND t1.userId = '$userId' AND t1.category = 'Non-Billable' GROUP BY t1.project";
		$q = $this->db->query($query)->result_array();
		return $this->db->affected_rows() ? $q : FALSE;
	}

	public function getProjectExpenses($companyId, $userId)
	{
		$query = "SELECT t2.projectName FROM `expenses` t1 JOIN projects t2 ON t1.project = t2.projectId WHERE t1.companyId = '$companyId' AND t1.userId = '$userId' GROUP BY t1.project";
		$q = $this->db->query($query)->result_array();
		return $this->db->affected_rows() ? $q : FALSE;
	}

	public function getAllUsers($companyId)
	{
		$query = "SELECT IFNULL(t2.managerId,'') as managerUId, t2.name as managerName, t1.username as username, t1.name as name, t1.userId as userId, t1.phone as phone FROM `users` t1 LEFT JOIN users t2 ON t1.managerId=t2.userId WHERE t1.companyId = '$companyId' AND t1.roleId !='1'";
		$q = $this->db->query($query)->result_array();
		return $this->db->affected_rows() ? $q : FALSE;
	}

	public function getAllocatedProjectToUser($userId)
	{
		// $query = "SELECT *, SUM(t3.workingHours) as consumedHours FROM `employee_project_relation` t1 LEFT JOIN `projects` t2 ON t1.projectId = t2.projectId JOIN timesheet t3 ON t1.employeeId = t3.employeeId AND t1.projectId = t3.projectId WHERE t1.employeeId = '$userId' GROUP BY t3.projectId";

		$query = "SELECT *,SUM(t3.workingHours) as consumedHours,t1.budgetedHours as budgetedHours FROM employee_project_relation t1 JOIN users t2 ON t1.employeeId = t2.managerId OR t1.employeeId = t2.userId LEFT JOIN timesheet t3 ON t2.userId = t3.employeeId AND t1.projectId = t3.projectId JOIN projects t4 ON t1.projectId = t4.projectId WHERE t1.employeeId = '$userId' GROUP BY t1.projectId";

		$q = $this->db->query($query)->result_array();
		return $this->db->affected_rows() ? $q : FALSE;
	}

	public function getAllocatedTaskToUser($userId)
	{
		$query = "SELECT * FROM `employee_project_relation` t1 LEFT JOIN `tasks` t2 ON t1.taskId = t2.taskId LEFT JOIN projects t3 ON t3.projectId = t1.projectId WHERE t1.employeeId = '$userId'";
		$q = $this->db->query($query)->result_array();
		return $this->db->affected_rows() ? $q : FALSE;
	}

	public function getAllTasks($companyId, $userId)
	{
		$query = "SELECT * FROM `tasks` t1 LEFT JOIN `projects` t2 ON t1.projectId = t2.projectId WHERE t1.companyId = '$companyId' AND t1.managerId = '$userId'";
		$q = $this->db->query($query)->result_array();
		return $this->db->affected_rows() ? $q : FALSE;
	}

	public function getTaskDetailsUserWise($companyId, $userId, $taskId)
	{
		$query = "SELECT *,IFNULL(SUM(t5.workingHours),0) as totalWorkedHours FROM `users` t1 JOIN `employee_task_relation` t2 ON t1.userId = t2.employeeId JOIN tasks t3 ON t3.taskId = t2.taskId LEFT JOIN timesheet t5 ON t2.employeeId = t5.employeeId JOIN projects t6 ON t6.projectId = t3.projectId  WHERE t1.companyId = '$companyId' AND t1.managerId = '$userId' AND t2.taskId = '$taskId' GROUP BY t5.taskId";
		$q = $this->db->query($query)->result_array();
		return $this->db->affected_rows() ? $q : FALSE;
	}

	public function getAllocatedUsers($userId, $currentWeek = null, $currentYear = null)
	{
		// $query = "SELECT * FROM `employees` t1 WHERE t1.companyId = '$companyId' AND (t1.managerId = '$userId' OR t1.userId = '$userId')";
		// $result = $this->db->query($query)->result_array();
		// return $this->db->affected_rows() ? $q : FALSE;

		return  $this->MainModel->selectAllFromWhere('employees', array('managerId' => $userId));


		// $result = $this->MainModel->selectAllFromWhere('employees', array('managerId' => $userId));

		// // print_r($result);die;

		// if ($result) {
		// 	foreach ($result as $key => $details) {
		// 		$weeklyData = $this->MainModel->selectAllFromWhere("employee_weekly_timesheet", array("employeeId" => $details['people_id'], "year" => $currentYear, "week" => $currentWeek));

		// 		if ($weeklyData) {
		// 			$result[$key]['status'] = $weeklyData[0]['status'];
		// 		} else {
		// 			$result[$key]['status'] = 'not submited';
		// 		}
		// 	}
		// 	return $result;
		// } else {
		// 	return false;
		// }
	}

	public function getCreatedTask($userId)
	{
		$query = "SELECT * FROM `tasks` t1 WHERE t1.managerId = '$userId'";
		$q = $this->db->query($query)->result_array();
		return $this->db->affected_rows() ? $q : FALSE;
	}

	public function getAllocatedTask($userId)
	{
		$query = "SELECT *, t1.taskId as allocatedContractId FROM `employee_task_relation` t1 JOIN employees t2 ON t1.employeeId = t2.people_id JOIN task t3 ON t3.task_Id = t1.taskId JOIN project t4 ON t4.project_Id = t3.project_id WHERE  t1.employeeId = '$userId'";

		$q = $this->db->query($query)->result_array();
		$result = $this->db->affected_rows() ? $q : FALSE;

		if ($result) {
			foreach ($result as $key => $details) {
				$selfAddedTasks = $this->MainModel->selectAllFromWhere("employee_task", array("employeeId" => $userId, "taskId" => $details['taskId']));

				if ($selfAddedTasks) {
					$result[$key]['employeeTaskId'] = $selfAddedTasks[0]['taskId'];
				} else {
					$result[$key]['employeeTaskId'] = "NULL";
				}
			}
			return $result;
		} else {
			return FALSE;
		}
	}

	public function getTaskAndProjectDetails($companyId, $taskId)
	{
		$query = "SELECT * FROM tasks t1 JOIN projects t2 ON t1.projectId = t2.projectId WHERE t1.companyId = '$companyId' AND t1.taskId = '$taskId'";
		$q = $this->db->query($query)->result_array();
		return $this->db->affected_rows() ? $q : FALSE;
	}

	public function getWeeklyTimesheetStatus($userId)
	{
		$query = "SELECT * FROM `employee_weekly_timesheet` t1 JOIN timesheet t2 ON t1.employeeId = t2.employeeId AND t1.week = t2.week AND t1.year = YEAR(t2.date) WHERE t1.employeeId = '$userId' AND (t1.status = 'rejected' || t1.status = 'approved') GROUP BY t2.projectId";
		$q = $this->db->query($query)->result_array();
		return $this->db->affected_rows() ? $q : FALSE;
	}

	public function getProjectDetail($companyId)
	{
		$query = "SELECT *,SUM(t2.workingHours) as consumedHours,t1.projectId as projectId FROM `projects` t1 LEFT JOIN `timesheet` t2 ON t1.projectId = t2.projectId WHERE t1.companyId = '$companyId' AND t1.projectName NOT IN('Holiday','Leave','Sickness') GROUP BY t1.projectId";
		$q = $this->db->query($query)->result_array();
		return $this->db->affected_rows() ? $q : FALSE;
	}

	public function getAllProjects()
	{
		$query = "SELECT * FROM `projects` t1 WHERE t1.projectName NOT IN('Holiday','Leave','Sickness')";
		$q = $this->db->query($query)->result_array();
		return $this->db->affected_rows() ? $q : FALSE;
	}

	public function getAllocatedHours($projectId = '')
	{
		$query = "SELECT sum(budgetedHours) as budgetedHours FROM `employee_project_relation` WHERE projectId='" . $projectId . "'";
		$q = $this->db->query($query)->result_array();
		return $this->db->affected_rows() ? $q : FALSE;
	}

	public function project_reports()
	{
		$query = "SELECT * FROM `users` left JOIN employee_task on employee_task.employeeId=users.userId LEFT JOIN tasks on tasks.taskId=employee_task.taskId LEFT JOIN timesheet on timesheet.employeeId=users.userId and timesheet.taskId=tasks.taskId";
		$q = $this->db->query($query)->result_array();
		return $this->db->affected_rows() ? $q : FALSE;
	}
}
