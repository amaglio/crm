<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {


	public function __construct()
	{	
 
		parent::__construct();
		$this->load->model('Contacto_model');
		$this->load->model('Consulta_model');
		$this->load->model('Evento_model');
		//$this->output->enable_profiler(TRUE);

		$this->db = $this->load->database($this->session->userdata('DB'),TRUE, TRUE);

	 	//$this->output->enable_profiler(TRUE);

		 
	}

	/*
	public function index()
	{	 
 
 		// Consultas de mis programas
	 
 		$consultas = $this->Consulta_model->traer_ultimas_consultas_de_mis_programas($this->session->userdata('id_persona'));

 		$consultas_informacion = array();
 		$consultas_sin_asignar = 0;
 		
 		
 		foreach ($consultas->result() as $row ):

 			$informacion['consultas'] = $row;
 			

 			if( ! isset($row->OPERADOR_A_CARGO ) )
 				$consultas_sin_asignar++;

 			//$informacion['persona'] = $this->Contacto_model->traer_informacion_crm_sigeu_persona($row->ID_CRM_PERSONA);
 			//$informacion['programas'] = $this->Consulta_model->traer_programas_consulta($row->ID_CRM_CONSULTA);
 			array_push($consultas_informacion, $informacion);

 		endforeach;

 		$datos['consultas_mis_programa'] = $consultas_informacion;
	 
	 	
 		// Consultas pipeline
 
  
 		$estado_consulta_prg = $this->Consulta_model->traer_estado_consulta_prg();
 		$array_pipeline = array();
 		foreach ($estado_consulta_prg->result() as $row):

 				$pipeline['estado'] = $row;
				$pipeline['cantidad']= $this->Consulta_model->traer_consultas_prg_estado($row->ID_ESTADO, $this->session->userdata('id_persona'))->num_rows();
				array_push($array_pipeline, $pipeline);

		endforeach;

		$datos['pipeline'] = $array_pipeline;

 		// Numeros orientativos 

 		$datos['cantidad_contactos_pendientes'] = $this->Contacto_model->traer_cantidad_contactos_web_pendientes();
 		$datos['consultas_sin_asignar'] = $consultas_sin_asignar;
		$datos['cantidad_asistentes_pendientes'] = $this->Contacto_model->traer_cantidad_asistentes_web_pendientes();
 		$datos['mis_consultas_a_cargo'] = $this->Consulta_model->traer_consultas_a_cargo($this->session->userdata('id_persona'))->num_rows();
 		$datos['eventos_activos'] = count($this->Evento_model->get_eventos());
 		$datos['cantidad_consultas_sin_ver'] = $this->Consulta_model->cantidad_consultas_de_mis_programas_sin_ver($this->session->userdata('id_persona'));
 
	 
 		$this->load->view('estructura/head');
		$this->load->view('home/home',$datos);
		$this->load->view('estructura/footer');  
	}*/

	public function index()
	{	 
 
 		// Consultas de mis programas
	 
 		//$datos['consultas'] = $this->Consulta_model->traer_ultimas_consultas_de_mis_programas($this->session->userdata('id_persona'));
 		$datos['consultas'] = $this->Consulta_model->traer_ultimas_consultas_a_cargo($this->session->userdata('id_persona'));
 		$consultas_sin_asignar = 0;
 		// Consultas pipeline
   
 		$estado_consulta_prg = $this->Consulta_model->traer_estado_consulta_prg();
 		$array_pipeline = array();
 		foreach ($estado_consulta_prg->result() as $row):

 				$pipeline['estado'] = $row;
				$pipeline['cantidad']= $this->Consulta_model->traer_consultas_prg_estado($row->ID_ESTADO, $this->session->userdata('id_persona'))->num_rows();
				array_push($array_pipeline, $pipeline);

		endforeach;

		$datos['pipeline'] = $array_pipeline;

 		// Numeros orientativos 

 		$datos['cantidad_contactos_pendientes'] = $this->Contacto_model->traer_cantidad_contactos_web_pendientes();
		$datos['cantidad_asistentes_pendientes'] = $this->Contacto_model->traer_cantidad_asistentes_web_pendientes();
		$datos['consultas_sin_asignar'] = $consultas_sin_asignar;
 		$datos['mis_consultas_a_cargo'] = $this->Consulta_model->traer_consultas_a_cargo($this->session->userdata('id_persona'))->num_rows();
 		$datos['eventos_activos'] = count($this->Evento_model->get_eventos());
 		$datos['cantidad_consultas_sin_ver'] = $this->Consulta_model->cantidad_consultas_de_mis_programas_sin_ver($this->session->userdata('id_persona'));
 
	 
 		$this->load->view('estructura/head');
		$this->load->view('home/home',$datos);
		$this->load->view('estructura/footer');  
	}

}

/* End of file login.php */
/* Location: ./application/controllers/login.php */