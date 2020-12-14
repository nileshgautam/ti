<?php

class EmployeeModel extends ci_model
{
	public function getConsumedHours($employeeId)
	{
		$query = "SELECT *,SUM(TIME_TO_SEC(workingHours))/3600 as TotalHours FROM `timesheet` WHERE employeeId = '$employeeId' GROUP BY clientId,contractId,serviceId";

		$q = $this->db->query($query)->result_array();
		return $this->db->affected_rows() ? $q : FALSE;
	}

	public function getTimeSheetDetails($date,$employeeId)
	{
		$query = "SELECT *,SUM(TIME_TO_SEC(timesheet.workingHours))/3600 as Hours FROM `timesheet` LEFT JOIN clients ON clients.clientId = timesheet.clientId LEFT JOIN (select distinct contractId from contract) as C  ON C.contractId = timesheet.contractId LEFT JOIN services ON services.serviceId = timesheet.serviceId LEFT JOIN activities ON activities.activityId = timesheet.activityId LEFT JOIN locations ON locations.locationId = timesheet.locationId WHERE employeeId = '$employeeId' AND `date` = '$date' GROUP BY timesheet.startTime,timesheet.endTime,timesheet.contractId";

		// $db_debug = $this->db->db_debug; //save setting
		// $this->db->db_debug = FALSE; //disable debugging for queries
		$q = $this->db->query($query)->result_array();
		// print_r($this->db->error());
		//check for errors, etc
		// $this->db->db_debug = $db_debug; //restore setting
		// mysqli_error();
		// $q = $this->db->query($query)->result_array();
		return $this->db->affected_rows() ? $q : FALSE;
	}

	public function getActivityDetails($employeeId,$clientId,$contractId,$serviceId,$date,$startTime,$endTime)
	{
		$query = "SELECT * FROM `timesheet` JOIN activities ON activities.activityId = timesheet.activityId WHERE employeeId = '$employeeId' AND `date` = '$date' AND startTime = '$startTime' AND endTime = '$endTime' AND clientId = '$clientId' AND contractId = '$contractId' AND serviceId = '$serviceId'";

		$q = $this->db->query($query)->result_array();
		return $this->db->affected_rows() ? $q : FALSE;
	}

	public function getUniqueContract($employeeId,$clientId)
	{
		$query = "SELECT DISTINCT a.contractId,b.contract_name FROM `employee_service_relation` a JOIN newcontract b ON a.contractId = b.contractId WHERE a.employeeId = '$employeeId' AND a.clientId = '$clientId' ";

		$q = $this->db->query($query)->result_array();
		return $this->db->affected_rows() ? $q : FALSE;
	}

	public function getUniqueLocations($employeeId,$contractId,$clientId)
	{

		$query = "SELECT DISTINCT b.locationId,c.locationName FROM `employee_service_relation` a JOIN newcontract b ON a.locationId = b.locationId JOIN locations c ON c.locationId = b.locationId WHERE a.employeeId = '$employeeId' AND a.clientId = '$clientId' AND a.contractId = '$contractId'";

		$q = $this->db->query($query)->result_array();
		return $this->db->affected_rows() ? $q : FALSE;
	}

	public function getUniqueServices($employeeId,$contractId,$clientId,$locationId)
	{
		$query = "SELECT DISTINCT b.serviceId,d.serviceName FROM `employee_service_relation` a JOIN newcontract b ON a.serviceId = b.serviceId JOIN services d ON d.serviceId = b.serviceId WHERE a.employeeId = '$employeeId' AND a.clientId = '$clientId' AND a.contractId = '$contractId' AND a.locationId = '$locationId'";

		$q = $this->db->query($query)->result_array();
		return $this->db->affected_rows() ? $q : FALSE;
	}

	public function getActivity($employeeId,$clientId,$contractId,$locationId,$serviceId)
	{
		$query = "SELECT * FROM `employee_service_relation` a JOIN employee_activity_relation b ON a.relationId = b.relationId JOIN activities c ON c.activityId = b.activityId WHERE a.employeeId = '$employeeId' AND a.clientId = '$clientId' AND a.contractId = '$contractId' AND a.locationId = '$locationId' AND a.serviceId = '$serviceId' ";

		$q = $this->db->query($query)->result_array();
		return $this->db->affected_rows() ? $q : FALSE;
	}

	public function getAllocatedClients($employeeId)
	{
		$query = "SELECT DISTINCT a.clientId,b.clientId,b.clientName,b.clientDescription FROM `employee_service_relation` a JOIN clients b ON a.clientId = b.clientId WHERE a.employeeId = '$employeeId' ";

		$q = $this->db->query($query)->result_array();
		return $this->db->affected_rows() ? $q : FALSE;
	}
}
?>