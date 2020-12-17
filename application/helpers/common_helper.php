<?php

$CI = &get_instance();

function timestamp()
{
	return date("Y-m-d H:i:s");
}


function upload_image()
{
	$CI = &get_instance();
	if (!empty($_FILES['files']['name'])) {
		// File upload configuration
		$file_name = $_FILES['files']['name'];
		$file_name = preg_replace("/\s+/", "_", $file_name);
		$file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
		$file_name = pathinfo($file_name, PATHINFO_FILENAME);
		$file_name = $file_name . "_" . date('mjYHis') . "." . $file_ext;
		$config['file_name'] = $file_name;
		$config['upload_path'] = realpath(APPPATH . '../uploads/'); // working on localhost
		$config['allowed_types'] = '*';
		$config['max_size'] = 2000;
		// Load and initialize upload library
		$CI->load->library('upload', $config);

		$CI->upload->initialize($config);

		$CI->upload->do_upload();

		// Upload file to server
		if ($CI->upload->do_upload('files')) {
			// Uploaded file data
			$Filedata = array(
				'file_name' => $file_name,
				'upload_time' => date("Y-m-d H:i:s")
			);
			echo json_encode($Filedata, true);
		} else {
			echo "error";
		}
		// Insert files data into the database
	}
}


function uploadFile($arr = null, $path = null)
{
	// Count total files
	$countfiles = count($arr['files']['name']);
	// print_r($arr['files']['name']);
	// print_r($countfiles);
	// die;
	// Upload directory
	$upload_location = "uploads/";
	$dirName = $upload_location . $path;

	if (!file_exists($dirName)) {
		mkdir($dirName, 0755, true);
	}
	// To store uploaded files path
	$files_arr = array();

	// Loop all files
	for ($index = 0; $index < $countfiles; $index++) {
		// File name
		$filename = $arr['files']['name'][$index];
		// Get extension
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		// Valid image extension
		$valid_ext = array("png", "jpeg", "jpg", "pdf", "docx", "doc");
		// Check extension
		if (in_array($ext, $valid_ext)) {
			$file_name = preg_replace("/\s+/", "_", $filename);
			$file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
			$file_name = pathinfo($file_name, PATHINFO_FILENAME);
			$filename = $file_name . "_" . date('mjYHis') . "." . $file_ext;
			// File path
			$file_path = $dirName . '/' . $filename;
			// Upload file
			if (move_uploaded_file($arr['files']['tmp_name'][$index], $file_path)) {
				$files_arr[] = $file_path;
			}
		}
	}
	// print_r($files_arr);
	return  json_encode($files_arr);
	// die;
}

function uploadData($arr = null, $path = null)
{

	// Upload directory
	$upload_location = "uploads/";
	$dirName = $upload_location . $path;
	if (!file_exists($dirName)) {
		mkdir($dirName, 0755, true);
	}
	// To store uploaded files path
	$files_arr = '';
	// File name
	$filename = $arr['files']['name'];
	// Get extension
	$ext = pathinfo($filename, PATHINFO_EXTENSION);
	// Valid image extension
	$valid_ext = array("png", "jpeg", "jpg", "pdf", "docx", "doc");
	// Check extension
	if (in_array($ext, $valid_ext)) {
		$file_name = preg_replace("/\s+/", "_", $filename);
		$file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
		$file_name = pathinfo($file_name, PATHINFO_FILENAME);
		$filename = $file_name . "_" . date('mjYHis') . "." . $file_ext;
		// File path
		$file_path = $dirName . '/' . $filename;
		// Upload file
		if (move_uploaded_file($arr['files']['tmp_name'], $file_path)) {
			$files_arr = $file_path;
			return  json_encode($files_arr);
		}
	} else {
		return false;
	}

	// print_r($files_arr);
	return  json_encode($files_arr);
	// die;
}

function timeRange($from = 0, $to = 0, $gap = 1)
{

	$hours = ($to >= $from) ? $to - $from : $to + 24 - $from;

	$arr[0] = convertAMPM($from);
	if ($hours > 0) {
		for ($i = 1; $i < $hours + 1; $i++) {
			$arr[$i] = convertAMPM($from + $i * $gap);
		}
	} else {
		$arr[1] = convertAMPM($from + $gap);
	}
	return $arr;
}

function convertAMPM($time)
{
	// print_r($time);
	// echo '<br/>';

	if ($time >= 24) {
		return ($time - 24) . ":00am";
	}
	if ($time >= 12) {
		return ($time - 12 == 0 ? 12 : $time - 12) . ":00pm";
	}
	return $time . ":00am";
}


// Function to convert time from 12 hrs to 24hrs
function time_in_24_hour_format($time = null)
{
	return date("H:i:s", strtotime($time));
}

// Function to convert time from 24 hrs to 12hrs
function time_in_12_hour_format($time = null)
{
	return date("g:i a", strtotime($time));
}

function CalculateTime($time1, $time2)
{
	$time1 = date('H:i:s', strtotime($time1));
	$time2 = date('H:i:s', strtotime($time2));
	$times = array($time1, $time2);
	$seconds = 0;
	foreach ($times as $time) {
		list($hour, $minute, $second) = explode(':', $time);
		$seconds += $hour * 3600;
		$seconds += $minute * 60;
		$seconds += $second;
	}
	$hours = floor($seconds / 3600);
	$seconds -= $hours * 3600;
	$minutes  = floor($seconds / 60);
	$seconds -= $minutes * 60;
	if ($seconds < 9) {
		$seconds = "0" . $seconds;
	}
	if ($minutes < 9) {
		$minutes = "0" . $minutes;
	}
	if ($hours < 9) {
		$hours = "0" . $hours;
	}
	return "{$hours}:{$minutes}:{$seconds}";
}


function calculate_hrs($time)
{

	$timestamp = explode(':', $time);

	// print_r($timestamp);die;
	$hrs = (int)$timestamp[0] * 60;
	// print_r($hrs);die;
	$minute = (int)$timestamp[1] + $hrs;
	// print_r($minute);die;
	$hrs = $minute / 60;
	$min =$minute % 60;

	
	echo $hrs.'h <br/>';
	echo $minute.'m <br/>';



	// echo '<br>';
	// print_r($timestamp);
}



// calendor 
