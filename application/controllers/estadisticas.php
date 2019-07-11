<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Estadisticas extends CI_Controller {


public function __construct()
{
	parent::__construct();
	$this->db = $this->load->database($this->session->userdata('DB'),TRUE, TRUE);
	$this->load->model('Estadisticas_model');
}

public function index()
{

	$this->load->view('estructura/head');

	$data['medios_consulta'] = $this->Estadisticas_model->medios_de_consulta_por_periodo_anios();
	$data['periodo_ingreso'] = $this->Estadisticas_model->periodo_de_ingreso_anios();
	$data['informacion_interes'] = $this->Estadisticas_model->informacion_interes_por_periodo_anios();

	$this->load->view('estadisticas/estadisticas',$data);
	$this->load->view('estructura/footer');
}



}

/* End of file login.php */
/* Location: ./application/controllers/login.php */