<?php

function sentmail($to = null, $subject = null, $mail_body = null)
{
    $CI = &get_instance();

    // $email = base64_decode($email); 

    // $config = array(
    //     'protocol' => 'smtp',
    //     'smtp_host' => 'ssl://smtp.gmail.com',
    //     'smtp_port' => 465,
    //     'smtp_user' => 'yya9017@gmail.com',
    //     'smtp_pass' => 'Yatharth@1234',
    //     'mailtype' => 'html',
    //     'charset' => 'iso-8859-1'
    // );

    $config = array(
        'protocol' => 'smtp',
        'smtp_host' => 'ssl://mail.gennextit.com',
        'smtp_port' => 465,
        'smtp_user' => 'info@gennextit.com',
        'smtp_pass' => '9eq0L@#F]d7-',
        'mailtype' => 'html',
        'charset' => 'iso-8859-1',
  );


    $CI->load->library('email', $config);
    $CI->email->set_newline("\r\n");
    $CI->email->initialize($config);

    $CI->email->from($config['smtp_user']);
    $CI->email->to($to);

    $CI->email->subject($subject);
    $CI->email->message($mail_body);

    $r = $CI->email->send();
    //  echo $CI->email->print_debugger();
    //  die;
    if ($r) {
        return true;
    } else {
        return false;
    }
}
