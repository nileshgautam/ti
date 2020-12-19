<?php
defined('BASEPATH') or exit('No direct script access allowed');
class CustomModel extends ci_model
{
    // function to extrcat records from database with where condition
    public function getAllfromWhere($condition = null, $table = null, $orderBy = null)
    {
        $this->db->order_by($orderBy, "asc");
        $result = $this->db->get_where($condition, $table)->result_array();
        return $this->db->affected_rows() ? $result : FALSE;
    }

    public function getAllUsers()
    {
        $query = $this->db->get('users');
        return $query->result();
    }


    public function getAllfromTable($tableName = null)
    {
        $query = $this->db->get($tableName);
        return  $query->result_array();
    }

    public function insert($table = null, $data = null)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    public function getUser($id)
    {
        $query = $this->db->get_where('users', array('id' => $id));
        return $query->row_array();
    }

    public function checkUser($email)
    {
        $query = $this->db->get_where('users', array('email' => $email));
        return $query->row_array();
    }

    public function activate($data, $id)
    {
        $this->db->where('users.id', $id);
        return $this->db->update('users', $data);
    }


    public function update_row($tableName = null, $condition = null, $data = null)
    {
        $this->db->where($condition);
        $query = $this->db->update($tableName, $data);
        return ($query != null) ? true : false;
    }

    function insetPeopleData($peopleData = null, $contactData = null, $empData = null, $emrdata = null)
    {
        $this->db->trans_start();
        $this->db->insert('people', $peopleData);
        $this->db->insert('address', $contactData);
        $this->db->insert('internal_people_detail', $empData);
        $this->db->trans_complete();
        return ($this->db->trans_status() === FALSE) ? false : true;
    }

    function insetPeopleDetails($document = null, $emcontactData = null, $cost = null, $credentials = null)
    {
        $this->db->trans_start();
        $this->db->insert('people_document', $document);
        $this->db->insert('emergency_contact', $emcontactData);
        $this->db->insert('cost', $cost);
        $this->db->insert('login', $credentials);
        $this->db->trans_complete();
        return ($this->db->trans_status() === FALSE) ? false : true;
    }

    function externalPeopleData($peopleData = null, $contactData = null)
    {
        $this->db->trans_start();
        $this->db->insert('external_people_detail', $peopleData);
        $this->db->insert('address', $contactData);
        $this->db->trans_complete();
        return ($this->db->trans_status() === FALSE) ? false : true;
    }

    function update_client($id = null, $peopleData = null, $contactData = null)
    {
        $this->db->trans_start();
        $this->db->where($id);
        $this->db->update('external_people_detail',  $peopleData);
        $this->db->update('address', $contactData);
        $this->db->trans_complete();
        return ($this->db->trans_status() === FALSE) ? false : true;
    }

    function assignProject($projectDataArr = null, $condition = null)
    {
        $this->db->trans_start();
        $this->db->where($condition);
        // $this->db->update('project', $status);
        $this->db->insert('peopl_project_relationship', $projectDataArr);
        $this->db->trans_complete();
        return ($this->db->trans_status() === FALSE) ? false : true;
    }

    // Function for Extraction data from client database
    public function getClients()
    {
        $q = "SELECT *, address.phone, address.email,address.country FROM `external_people_detail` LEFT JOIN address on external_people_detail.client_id=address.reference_id";
        $result = $this->db->query($q)->result_array();
        return ($result != null) ? $result : false;
    }

    function getAssignedProject($id = null)
    {
        $q = "SELECT * FROM project LEFT JOIN peopl_project_relationship on project.project_Id=peopl_project_relationship.project_id where peopl_project_relationship.people_id='$id'";
        $result = $this->db->query($q)->result_array();
        return ($result != null) ? $result : false;
    }

    // Function for Extraction data from client database
    public function getemployee()
    {
        // $q = "SELECT people.people_id, login.username, people.first_name,people.last_name, internal_people_detail.department,internal_people_detail.managerId, address.phone FROM `people` LEFT JOIN internal_people_detail on people.people_id=internal_people_detail.people_id LEFT JOIN address on address.reference_id=people.people_id LEFT JOIN login on login.people_id=people.people_id";
        $q = "SELECT people.people_id, login.username, people.first_name,people.last_name, internal_people_detail.department,internal_people_detail.managerId, address.phone FROM `people` LEFT JOIN internal_people_detail on people.people_id=internal_people_detail.people_id LEFT JOIN address on address.reference_id=people.people_id LEFT JOIN login on login.people_id=people.people_id WHERE internal_people_detail.role!='Admin'";

        $result = $this->db->query($q)->result_array();
        return ($result != null) ? $result : false;
    }

    // Function for Extraction data from client database
    public function get_services()
    {
        $q = "SELECT * FROM `master_services_category` ORDER BY `master_services_category`.`title` ASC";
        $result = $this->db->query($q)->result_array();
        return ($result != null) ? $result : false;
    }

    public function getservices($project_id = null)
    {
        $query = "SELECT services FROM project WHERE project_Id='$project_id'";
        $result = $this->db->query($query)->result_array();
        return ($result != null) ? $result : false;
    }

    public function getmanager()
    {
        $query = "SELECT * FROM `employee_details`WHERE role<>'user'
        ";
        // $query = "SELECT people_id, first_name, last_name from employees WHERE role='Manager' OR 'Admin'";
        $r = $this->db->query($query)->result_array();
        return ($r != null) ? $r : false;
    }

    // Function for Get Project with related clients
    public function getProjects()
    {
        $query = "SELECT *, external_people_detail.client_name FROM `project` LEFT JOIN external_people_detail on project.client_id=external_people_detail.client_id
        ORDER BY `Created_datetime` DESC";
        $r = $this->db->query($query)->result_array();

        return ($r != null) ? $r : false;
    }

    public function getAllocatedTask($userId)
    {


        // print_r($userId);
        // die;
        // $query = "SELECT *,task.title,task.description FROM employee_task_relation LEFT JOIN  task on task.task_id=employee_task_relation.taskId WHERE employee_task_relation.employeeId='$userId'";

        $query = "SELECT employee_task_relation.taskId, master_tasks.title, master_tasks.description, employee_task_relation.budgetedHours, employee_task_relation.startDate, employee_task_relation.endDate, employee_task_relation.employeeId FROM `employee_task_relation` left JOIN master_tasks on master_tasks.task_id=employee_task_relation.taskId WHERE employee_task_relation.employeeId='$userId'";
        $q = $this->db->query($query)->result_array();
        // print_r($q);die;
        return $this->db->affected_rows() ? $q : FALSE;

        // if ($result) {
        //     foreach ($result as $key => $details) {
        //         $selfAddedTasks = $this->MainModel->selectAllFromWhere("employee_task", array("employeeId" => $userId, "taskId" => $details['taskId']));

        //         if ($selfAddedTasks) {
        //             $result[$key]['employeeTaskId'] = $selfAddedTasks[0]['taskId'];
        //         } else {
        //             $result[$key]['employeeTaskId'] = "NULL";
        //         }
        //     }
        //     return $result;
        // } else {
        //     return FALSE;
        // }
    }


    function getTaskByProjectAndManager($id = null)
    {
        $query = "SELECT * FROM `task_project_relation` left join peopl_project_relationship on peopl_project_relationship.project_id=task_project_relation.project_id LEFT JOIN master_tasks on master_tasks.task_id=task_project_relation.task_id WHERE peopl_project_relationship.people_id='$id'";

        $q = $this->db->query($query)->result_array();
        return $result = $this->db->affected_rows() ? $q : FALSE;
    }

    // Function to get employees Name
    function getEmployees($id = null)
    {
        $query = "SELECT first_name , last_name, role FROM `employees` WHERE people_id='$id' ORDER BY `role` ASC";

        $q = $this->db->query($query)->result_array();
        return $result = $this->db->affected_rows() ? $q : FALSE;
    }

    function getDailyAllocatedTasks($userId = null, $date = null, $project_id = null)
    {
        // $q = "SELECT * FROM assigntask WHERE end_date>='$date' and assigntask.employeeId='$userId'";

        // print_r($userId);
        // print_r($date);
        // die;
        // $q = "SELECT
        // employee_task_relation.taskId as task_id,
        // task_project_relation.project_id,
        // project.client_id,
        // master_tasks.category as service_id,
        // master_tasks.title, 
        // master_tasks.description,
        // employee_task_relation.budgetedHours, 
        // employee_task_relation.startDate, 
        // employee_task_relation.endDate, 
        // employee_task_relation.employeeId 
        // FROM `employee_task_relation` 
        // LEFT JOIN master_tasks on master_tasks.task_id=employee_task_relation.taskId
        // LEFT JOIN task_project_relation on task_project_relation.task_id=employee_task_relation.taskId
        // LEFT JOIN project on task_project_relation.project_id=project.project_Id
        // WHERE employee_task_relation.employeeId='$userId' AND employee_task_relation.endDate>='$date'";



        $q = "SELECT employee_task_relation.taskId, master_tasks.title, project.project_Id,project.name, project.client_id, master_tasks.category,employee_task_relation.employeeId, employee_task_relation.budgetedHours as assignhrs, employee_task_relation.startDate, employee_task_relation.endDate
        from employee_task_relation LEFT JOIN master_tasks ON employee_task_relation.taskId = master_tasks.task_id LEFT JOIN project on project.project_Id=employee_task_relation.project_id WHERE employeeId='$userId' AND employee_task_relation.endDate>='$date' AND project.project_Id='$project_id'";

        $result = $this->db->query($q)->result_array();
        return $this->db->affected_rows() ? $result : FALSE;
    }


    public function getAssignproject($id = null)
    {
        // echo $id;
        $q = "SELECT peopl_project_relationship.project_id,project.name, peopl_project_relationship.people_id FROM `peopl_project_relationship` left JOIN project on project.project_Id=peopl_project_relationship.project_id WHERE peopl_project_relationship.people_id='$id'";
        $result = $this->db->query($q)->result_array();
        // print_r($result);die;
        return  $result != '' ? $result : FALSE;
    }

    public function getProjectByAssignTask($userId = null, $date = null)
    {
        $q = "SELECT  project.project_Id,project.name,employee_task_relation.employeeId, employee_task_relation.budgetedHours as assignhrs, employee_task_relation.startDate, employee_task_relation.endDate
       from employee_task_relation LEFT JOIN master_tasks ON employee_task_relation.taskId = master_tasks.task_id LEFT JOIN project on project.project_Id=employee_task_relation.project_id WHERE employee_task_relation.employeeId='$userId' AND employee_task_relation.endDate>='$date' GROUP by project_id";

        $result = $this->db->query($q)->result_array();
        return  $result != '' ? $result : FALSE;
    }

    // function to get task by project id for manager screen

    public function taklistByProjectId($project_id = null)
    {
        $q = "SELECT * FROM `task_project_relation` LEFT JOIN master_tasks on task_project_relation.task_id=master_tasks.task_id WHERE task_project_relation.project_id='$project_id'";
        $result =  $this->db->query($q)->result_array();
        return $this->db->affected_rows() ? $result : FALSE;

        # code...
    }


    function getDailyTask($userId = null, $date = null)
    {
        // $q = "SELECT * FROM `taskstatus` WHERE save_date='$date' AND employeeId='$userId' AND status='submitted' OR status='approved'  ORDER BY `taskstatus`.`taskStTime`";
        $q = "SELECT * 
            FROM `taskstatus`
         WHERE save_date='$date' 
         AND employeeId='$userId' 
         AND status!='saved' 
         ORDER BY `taskstatus`.`taskStTime`";

        //  echo '<pre>';
        $result = $this->db->query($q)->result_array();
        // print_r($result);die;
        return $this->db->affected_rows() ? $result : FALSE;
    }




    // update batch
    function updateBatch($tablename = null, $data = null, $id = null)
    {
        $query = $this->db->update_batch($tablename, $data, $id);

        return ($query != null) ? true : false;
    }


    public function getBookedSlots($employeeid = null, $currentdate = null)
    {
        $q = "SELECT start_time, end_time FROM dailytimesheet WHERE save_date='$currentdate' AND employee_id='$employeeid' ORDER by start_time";
        $result = $this->db->query($q)->result_array();
        return $this->db->affected_rows() ? $result : FALSE;
    }

    // update batch


    function getTaskByServicesId($id = null)
    {
        $q = "SELECT * FROM master_tasks WHERE master_tasks.category='$id'  
        ORDER BY `master_tasks`.`title`  ASC";
        $result = $this->db->query($q)->result_array();
        // echo '<pre>';
        // print_r($result);
        // die;
        return $this->db->affected_rows() ? $result : FALSE;
    }

    function getTaskByid($id = null, $date = null)
    {

        $q = "SELECT 
        master_tasks.task_id, master_tasks.title, employee_task_relation.budgetedHours, 
        IFNULL(sum(Format(TIME_TO_SEC(timediff(dailytimesheet.end_time, dailytimesheet.start_time))/60,0)),0) as consumedTime, dailytimesheet.employee_id, 
        dailytimesheet.project_id, dailytimesheet.submit_date, dailytimesheet.dailyts_id 
         FROM dailytimesheet
        LEFT JOIN master_tasks on dailytimesheet.taks_id=master_tasks.task_id
        LEFT JOIN employee_task_relation on dailytimesheet.employee_id=employee_task_relation.employeeId and dailytimesheet.taks_id=employee_task_relation.taskId
        WHERE dailytimesheet.submit_date='$date' and dailytimesheet.employee_id='$id'
        GROUP by dailytimesheet.employee_id";
        $result = $this->db->query($q)->result_array();
        return  $result;
    }

    // Function for get task from task master by task categories
    public function getTaskListbyCategories()
    {
        $q = "SELECT master_tasks.id,master_tasks.task_id, master_tasks.title, master_tasks.description,master_services_category.title as category FROM `master_tasks` LEFT JOIN master_services_category on master_tasks.category=master_services_category.services_id";
        $result = $this->db->query($q)->result_array();
        return $this->db->affected_rows() ? $result : FALSE;
    }

    // Function for get task list by project id
    public function getTaskListbyprojectId($id = null)
    {
        $q = "SELECT master_tasks.task_id, master_tasks.title, master_tasks.description, task_project_relation.project_id, task_project_relation.assigned_hrs, task_project_relation.start_date,task_project_relation.end_date,task_project_relation.project_id FROM `task_project_relation` LEFT JOIN master_tasks on task_project_relation.task_id=master_tasks.task_id WHERE task_project_relation.project_id='$id'";
        $result = $this->db->query($q)->result_array();
        return $this->db->affected_rows() ? $result : FALSE;
    }

    // Function for get projects task list by project id
    public function getProjectbyUserId($id = null)
    {
        $q = "SELECT project.project_Id, project.name, project.budget_hours as totalHrs, task_project_relation.task_id,peopl_project_relationship.people_id, task_project_relation.assigned_hrs as allocatedHours FROM project LEFT JOIN task_project_relation on project.project_Id=task_project_relation.project_id LEFT JOIN peopl_project_relationship on project.project_Id=peopl_project_relationship.project_id WHERE peopl_project_relationship.people_id='$id'";
        $result = $this->db->query($q)->result_array();
        return $this->db->affected_rows() ? $result : FALSE;
    }

    // Function for get consumed hrs by project
    public function getProjectbyUserIdConsumendhrs($id = null, $date = null)
    {
        $q = "SELECT project.project_Id, project.name, project.budget_hours as assignHrs,
        IFNULL(sum(Format(TIME_TO_SEC(timediff(dailytimesheet.end_time, dailytimesheet.start_time))/60,0)),0)
        as bookedTime FROM project
        LEFT JOIN task_project_relation on project.project_Id=task_project_relation.project_id
        LEFT JOIN peopl_project_relationship on peopl_project_relationship.project_id=project.project_id
        LEFT JOIN dailytimesheet on dailytimesheet.project_id=project.project_Id and task_project_relation.task_id=dailytimesheet.taks_id
        WHERE peopl_project_relationship.people_id='$id' 
        GROUP by project.project_Id  ORDER BY `project`.`project_Id` ASC";
        $result = $this->db->query($q)->result_array();
        return $this->db->affected_rows() ? $result : FALSE;
    }

    // Function for get consumed hrs by project
    public function getTaskbyManagerIdAndProjectId($projectid = null, $managerid = null)
    {
        // print_r($projectid);
        // echo '<br>';
        // print_r($managerid);
        // die;

        $q = "SELECT project.project_Id, project.name, peopl_project_relationship.people_id, task_project_relation.task_id, master_tasks.title,
        task_project_relation.task_id, 
        IFNULL(Format(TIME_TO_SEC(timediff(dailytimesheet.end_time, dailytimesheet.start_time))/60,0),0) as bookedTime
        from project
        LEFT JOIN peopl_project_relationship on peopl_project_relationship.project_id =project.project_Id
        LEFT JOIN task_project_relation on project.project_Id = task_project_relation.project_id
        LEFT JOIN master_tasks on task_project_relation.task_id=master_tasks.task_id
        LEFT JOIN dailytimesheet on dailytimesheet.project_id=project.project_Id and task_project_relation.task_id=dailytimesheet.taks_id
        WHERE project.project_Id='$projectid' and peopl_project_relationship.people_id='$managerid'
        ORDER BY `project`.`project_Id` ASC";

        $result = $this->db->query($q)->result_array();

        // print_r($result);die;

        return $this->db->affected_rows() ? $result : FALSE;
    }
}
