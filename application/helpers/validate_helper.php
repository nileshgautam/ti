<?php
function validateInput($inp)
{
    $val = trim($inp);
    $val = htmlspecialchars($val, ENT_QUOTES);
    $val = stripslashes($val);
    return $val;
}

function validateInput2($inp)
{
    $val = htmlspecialchars($inp, ENT_QUOTES);

    return $val;
}

function removeSpecialSymbol($string)
{
    $string = str_replace(' ', '', $string); // Replaces all spaces with hyphens.
    $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    $string = str_replace('-', '', $string);
    return strtolower($string);
}

function my_print($array = "")
{
    var_dump($array);
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}


function messages($parm)
{
    return isset($parm) ? json_encode(array('message' => 'Row inserted', 'type' => 'success', 'data' => $parm[0])) : json_encode(array('message' => 'Error! Contact IT', 'type' => 'error', 'data' => ''));
}

function deleteMessages($parm)
{
    return ($parm !== 1) ? json_encode(array('message' => 'Row delete!', 'type' => 'success')) : json_encode(array('message' => 'Error! Contact IT', 'type' => 'error'));
}

function messages_update($parm)
{
    return $parm === true ? json_encode(array('message' => 'Row Updated!', 'type' => 'success')) : json_encode(array('message' => 'Error! Contact IT', 'type' => 'error'));
}


function selectedServices($services)
{
    $CI = &get_instance();
    // print_r($services);
    $services = json_decode($services);
    // print_r($services);
    // die;
    $sservices = [];
    // $process=$service;
    foreach ($services as $key => $item) {
        $services_data = $CI->MainModel->selectAllFromWhere('master_services_category', array('services_id' => $item));
        // print_r($services_data[0]);
        array_push($sservices, $services_data[0]['title']);
    }
    return $sservices;
}

function sService($services)
{
    $CI = &get_instance();
    // print_r($services);
    $services = json_decode($services);
    // print_r($services);
    // die;
    $sservices = [];
    // $process=$service;
    foreach ($services as $key => $item) {
        $services_data = $CI->MainModel->selectAllFromWhere('master_services_category', array('services_id' => $item));
        // print_r($services_data[0]);
        $arr = array(
            'id' => $services_data[0]['services_id'],
            'title' => $services_data[0]['title'],
        );

        array_push($sservices, $arr);
    }
    // print_r($sservices);

    return $sservices;
}

// Date filter

//  change date format MMDDYY to YYMMDD
function yymmdd($date)
{
    $date = explode("/", $date);
    // print_r($date);die;
    $dd = $date[0];
    $mm = $date[1];
    $yy = $date[2];
    $date = $yy . '-' . $mm . '-' . $dd;
    return $date;
}

function requiredDates($day = null, $date = null)
{
    $dates = [];
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

    // echo $week_number;

    $this_week_sd = date('d F Y', strtotime($currentYear . "W" . $week_number));
    //echo "<br>";

    $this_week_ed = date('d F Y', strtotime($currentYear . "W" . $week_number . "+6 days"));

    // print_r($this_week_sd);
    // print_r($this_week_ed);die;

    $begin = new DateTime(date("Y-m-d", strtotime($this_week_sd)));
    $end = new DateTime(date("Y-m-d", strtotime($this_week_ed)));
    $end = $end->modify('+1 day');

    $interval = new DateInterval('P1D');
    $daterange = new DatePeriod($begin, $interval, $end);

    $dates['daterange'] = $daterange;
    $dates['week_number'] = $week_number;
    $dates['currentYear'] = $currentYear;
    $dates['this_week_sd'] = $this_week_sd;
    $dates['this_week_ed'] = $this_week_ed;


    return $dates;
}

// Function to calculate time

function time_deff($start = null, $stop = null)
{
    $starttime = $start;
    $stoptime = $stop;
    $diff = (strtotime($stoptime) - strtotime($starttime));
    $total = $diff / 60;

    echo sprintf("%02dh %02dm", floor($total / 60), $total % 60);
}



function time_deff_two($start = null, $stop = null)
{
    $total_time = strtotime($stop) - strtotime($start);
    $hours = intval($total_time / 3600);
    $total_time = $total_time - ($hours * 3600);
    $min = intval($total_time / 60);
    $sec = $total_time - ($min * 60);

    return ($hours . ':' . $min);
    // die;
}

// password Generator
function passwordGenerate($length)
{
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    return substr(str_shuffle($chars), 0, $length);
}


  function ddmmyy($date=null)
{
    $date=date_create($date);
    return date_format($date,"d/m/Y");
    
}