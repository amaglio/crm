<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cron_tab extends CI_Controller {


public function __construct()
{
	parent::__construct();
	$this->load->model('Consulta_model');
	//$this->db = $this->load->database($this->session->userdata('DB'),TRUE, TRUE);
}

public function chequear_standby_consultas()
{
	$this->Configuracion_model->chequear_fecha_standby();
}




}

/* End of file login.php */
/* Location: ./application/controllers/login.php */