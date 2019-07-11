<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ayuda extends CI_Controller {


public function __construct()
{
	parent::__construct();
	$this->load->library('user_agent');
	$this->db = $this->load->database($this->session->userdata('DB'),TRUE, TRUE);
}

public function manual_usuario()
{
	$this->load->view('estructura/head');
	$this->load->view('ayuda/manual_usuario');
	$this->load->view('estructura/footer');
}






}

/* End of file login.php */
/* Location: ./application/controllers/login.php */