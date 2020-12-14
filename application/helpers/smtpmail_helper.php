<?php

function sentmail($email = null, $subject = null, $message = null)
{
      $CI = &get_instance();
      // $email = base64_decode($email); 
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
      $CI->email->from('info@gennextit.com', 'your crone job');
      $CI->email->to($email);
      // $CI->email->cc($email); 
      $CI->email->subject($subject);
      $CI->email->message($message);
      if ($CI->email->send()) {
            return true;
        } else {
    
            return false;
        }
}
