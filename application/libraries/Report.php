<?php

class Report
{
	private $CI;
	// private $userId;
	public function __construct()
	{
		$this->CI = &get_instance();
		$this->CI->load->model("MainModel");
		$this->CI->load->library('session');
		$this->CI->load->helper("validate");
		$this->CI->load->model("CustomModel");
		$this->CI->load->model("CustomModel1");

		// Report::$userId=$_SESSION['logged_in']['people_id'];
	}

	public function project_task_reports($userId)
	{
		$allocatedProjects = $this->CI->CustomModel->getProjectbyUserIdConsumendhrs($userId);

		// echo '<pre>';
		// print_r($allocatedProjects);die();
		
		if ($allocatedProjects) {
			foreach ($allocatedProjects as $key => $projects) {
				$result = $this->CI->CustomModel->getTaskbyManagerIdAndProjectId(
					 $projects['project_Id'], $userId
				);
				if ($result) {
					$allocatedProjects[$key]['details'] = $result;
				}
			}
		}
		return $allocatedProjects;
	}
}
