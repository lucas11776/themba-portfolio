<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	/**
	 * Application home page
	 */
	public function index()
	{
		// validate form data
		$this->form_validation->set_rules('name', 'name', 'required|min_length[3]|max_length[30]');
		$this->form_validation->set_rules('email', 'email', 'required|valid_email');
		$this->form_validation->set_rules('message', 'message', 'required|min_length[10]|max_length[2500]');

		// check if form is valid
		if($this->form_validation->run() === false)
		{
			// home page
			$this->load->view('home');
			
			return;
		}

		// mail to be sent to my email address
		$mail = array(
			'email'   => $this->input->post('email'),
			'subject' => strtoupper($this->input->post('name')) . ' sent you a message from your website.',
			'message' => $this->input->post('message')
		);

		// send mail to my email address
		if($this->mail->send($mail) === false)
		{
			$this->session->set_flashdata('mail_fail', 'Something went wrong when tring to send email please try again later.');
		}
		else
		{
			$this->session->set_flashdata('mail_sent', 'Message has been sent to my inbox I will get back to your soon.');
			
			redirect('#contact');
		}

		// home page
		$this->load->view('home');
	}
}
