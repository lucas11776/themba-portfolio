<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mail_model extends CI_Model
{
  /**
   * Email address to send email to
   */
  private const EMAIL = 'thembangubeni04@gmail.com';

  /**
   * Email Address
   */
  private const EMAIL_PASSWORD = '';

  /**
   * Initialize email class
   */
  public function __construct()
  {
    $this->email->initialize(
      array(
        'protocol' => 'smtp',
        'smtp_host' => 'ssl://smtp.googlemail.com',
        'smtp_port' => 465,
        'smtp_user' => $this::EMAIL,
        'smtp_pass' => $this::EMAIL_PASSWORD,
        'charset' => 'iso-8859-1',
        'wordwrap' => TRUE
      )
    );
  }

  /**
   * Send mail to email address
   * 
   * @param   string
   * @return  boolean
   */
  public function send(array $mail)
  {
    $this->email->to($this::EMAIL);
    $this->email->from($mail['email']);
    $this->email->subject($mail['subject']);
    $this->email->message($mail['message']);

    // show_error($this->email->print_debugger());

    return $this->email->send();
  }
}