<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Escuela_negocios extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database($this->session->userdata('DB'),TRUE, TRUE);
		$this->load->model('Escuela_negocios_model');
		$this->load->model('Contacto_model');
		$this->load->model('Empresa_model');
	}
	
	public function index(){

		$this->load->view('estructura/head');
		$data = [];
		//$data['referentes'] = $this->Escuela_negocios_model->get_referentes(); 
		$referentes = $this->Escuela_negocios_model->get_referentes(); 

		$array_referentes = array();

		foreach ($referentes as $row) 
		{
			$referentes['datos_referente'] = $row;
			$referentes['ultima_empresa_referente'] = $this->Escuela_negocios_model->get_ultima_empresa_referente($row['ID_CRM_PERSONA']);
			array_push($array_referentes, $referentes);
		}

		$data['referentes'] = $array_referentes;
		$data['alarmas'] = $this->Escuela_negocios_model->get_alarmas();
		$data['ultimas_acciones'] = $this->Escuela_negocios_model->get_ultimas_acciones();
		//$data['empresas'] = $this->Empresa_model->get_empresas();
		$data['mensaje'] = $this->session->flashdata('mensaje');
		$this->load->view('escuela_negocios/escuela_negocios', $data);
		$this->load->view('estructura/footer');
	}

	/*
	public function ver_referente($id_referente, $id_crm_persona_empresa = null){

		$_POST['id_crm_persona'] = $id_referente;
		$this->form_validation->set_data($_POST);
		$this->form_validation->set_message('comprobar_persona_crm_existente_validation', 'El referente no existe o ha sido dada de baja');
 
		if ($this->form_validation->run('ver_contacto') == FALSE):  //  
 

			chrome_log("No Paso validacion");

			$this->session->set_flashdata('mensaje', 'No paso la validacion, el referente no existe o ha sido dado de baja');
			redirect('escuela_negocios');

		else:

			chrome_log("Si Paso validacion");

			$this->load->view('estructura/head');

			// [CAMBIOS] - Falta poner validador de ID_REFERENTE en el form
			$data['mensaje'] = $this->session->flashdata('mensaje');
		 	$data['datos_referente'] = $this->Contacto_model->traer_informacion_crm_persona($id_referente);
		 	$data['emails_referente'] = $this->Contacto_model->traer_emails_crm($id_referente);
		 	$data['telefonos_referente'] = $this->Contacto_model->traer_telefonos_crm($id_referente);
		 	$data['experiencia_laboral'] = $this->Contacto_model->traer_experiencia_laboral_crm($id_referente);
		 	$data['acciones_referente'] = $this->Escuela_negocios_model->get_acciones_referente($id_referente);
 

		 	if( isset($id_crm_persona_empresa) && !empty($id_crm_persona_empresa) )
		 	{
		 		$data['id_crm_persona_empresa'] = $id_crm_persona_empresa;
		 	}
		 	else
		 	{
		 		$data['ultima_empresa_referente'] = $this->Escuela_negocios_model->get_ultima_empresa_referente($id_referente);
		 		
		 		if(isset($data['ultima_empresa_referente']->ID_CRM_PERSONA_EMPRESA))
			 		$data['id_crm_persona_empresa'] = $data['ultima_empresa_referente']->ID_CRM_PERSONA_EMPRESA;
		 	}

			$this->load->view('escuela_negocios/ver_referente', $data);
			$this->load->view('estructura/footer');

		endif;
	}*/

	public function ver_referente($id_referente, $id_empresa = null){

		$_POST['id_crm_persona'] = $id_referente;
		$this->form_validation->set_data($_POST);
		$this->form_validation->set_message('comprobar_persona_crm_existente_validation', 'El referente no existe o ha sido dada de baja');
 
		if ($this->form_validation->run('ver_contacto') == FALSE):  //  
 

			chrome_log("No Paso validacion");

			$this->session->set_flashdata('mensaje', 'No paso la validacion, el referente no existe o ha sido dado de baja');
			redirect('escuela_negocios');

		else:

			chrome_log("Si Paso validacion");

			$this->load->view('estructura/head');

			// [CAMBIOS] - Falta poner validador de ID_REFERENTE en el form
			$data['mensaje'] = $this->session->flashdata('mensaje');
		 	$data['datos_referente'] = $this->Contacto_model->traer_informacion_crm_persona($id_referente);
		 	$data['emails_referente'] = $this->Contacto_model->traer_emails_crm($id_referente);
		 	$data['telefonos_referente'] = $this->Contacto_model->traer_telefonos_crm($id_referente); 
		 	//$data['experiencia_laboral'] = $this->Contacto_model->traer_experiencia_laboral_crm($id_referente);
		 	$data['acciones_referente'] = $this->Escuela_negocios_model->get_acciones_referente($id_referente);
 			$data['experiencia_laboral'] = $this->Escuela_negocios_model->traer_referencias_persona($id_referente);

 			 
		 	if( isset($id_empresa) && !empty($id_empresa) )
		 	{
		 		$data['id_empresa'] = $id_empresa;
		 	}
		 	else
		 	{
		 		$data['ultima_empresa_referente'] = $this->Escuela_negocios_model->get_ultima_empresa_referente($id_referente);
		 		$data['id_empresa'] = $data['ultima_empresa_referente']->ID_EMPRESA;
		 		//echo $data['id_empresa'];
		 		/*
		 		if(isset($data['ultima_empresa_referente']->ID_CRM_PERSONA_EMPRESA))
			 		$data['id_crm_persona_empresa'] = $data['ultima_empresa_referente']->ID_CRM_PERSONA_EMPRESA;*/
		 	} 

			$this->load->view('escuela_negocios/ver_referente', $data);
			$this->load->view('estructura/footer');

		endif;
	}

	/*
	public function ver_calendario_referente_empresa()
	{
		$data['id_crm_persona_empresa'] = $this->input->post('id_crm_persona_empresa');
		$data['id_crm_persona'] = $this->input->post('id_crm_persona');
		$data['ultima_empresa_referente'] = $this->Escuela_negocios_model->get_informacion_empresa_referente($this->input->post('id_crm_persona_empresa'));
  		$this->load->view('escuela_negocios/calendario_referente_empresa', $data);		
	}*/

	public function ver_calendario_referente_empresa()
	{
		$data['id_empresa'] = $this->input->post('id_empresa');
		$data['id_crm_persona'] = $this->input->post('id_crm_persona');
		$data['ultima_empresa_referente'] = $this->Escuela_negocios_model->get_informacion_empresa_referente( $this->input->post('id_empresa'), $this->input->post('id_crm_persona') );
  		$this->load->view('escuela_negocios/calendario_referente_empresa', $data);		
	}

	public function ver_empresa($id_empresa)
	{
		$_POST['id_empresa'] = $id_empresa;
		$this->form_validation->set_data($_POST);
		$this->form_validation->set_message('comprobar_empresa_crm_existente_validation', 'La empresa no existe.');
 

		if ($this->form_validation->run('ver_empresa') == FALSE):  //  
 

			chrome_log("No Paso validacion");

			$this->session->set_flashdata('mensaje', 'No paso la validacion.');
			redirect('home','refresh');

		else:

			chrome_log("Si Paso validacion");
			$data['mensaje'] = $this->session->flashdata('mensaje');
			$data['datos_empresa'] = $this->Empresa_model->get_datos_empresa($id_empresa);
			$data['referentes_empresa'] = $this->Empresa_model->get_referentes_empresa($id_empresa);
			$data['acciones_empresa'] = $this->Empresa_model->get_acciones_empresa($id_empresa);
			$data['empleados_empresa'] = $this->Empresa_model->get_empleados_empresa($id_empresa);
			$data['alarmas_empresa'] = $this->Empresa_model->get_alarmas_empresa($id_empresa);
			$data['acuerdo_empresa'] = $this->Empresa_model->get_acuerdo_empresa($id_empresa);
			$this->load->view('estructura/head'); 	 	
			$this->load->view('escuela_negocios/ver_empresa', $data);
			$this->load->view('estructura/footer');

		endif;
	}

	public function ver_camara($id_camara)
	{
		$_POST['id_camara'] = $id_camara;
		$this->form_validation->set_data($_POST);
		$this->form_validation->set_message('comprobar_camara_crm_existente_validation', 'La camara no existe.');
 
		if ($this->form_validation->run('ver_camara') == FALSE):  //  
 

			chrome_log("No Paso validacion");

			$this->session->set_flashdata('mensaje', 'No paso la validacion.');
			//redirect('home','refresh');

		else:
 
			$data['mensaje'] = $this->session->flashdata('mensaje');
			$data['datos_camara'] = $this->Empresa_model->get_datos_camara($id_camara);
			$data['referentes_camara'] = $this->Empresa_model->get_referentes_camara($id_camara);
			/*
			$data['empresas_camara'] = $this->Empresa_model->get_referentes_empresa($id_camara);
			*/
			

			$this->load->view('estructura/head'); 	 	
			$this->load->view('escuela_negocios/ver_camara', $data);
			$this->load->view('estructura/footer');

		endif;
	}

	public function alta_referente()
	{
		chrome_log("Escuela_negocios/alta_referente");

		if ($this->form_validation->run('alta_referente') == FALSE):

			chrome_log("No paso validacion alta_referente");
			$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');

		else:

			chrome_log("Paso validacion");

			$id_crm_persona = $this->Escuela_negocios_model->abm_referente('A', $this->input->post(), $cadena_resultado);

		 
			if( $id_crm_persona > 0):

				$this->session->set_flashdata('mensaje', $cadena_resultado );
			    redirect('escuela_negocios/ver_referente/'.$id_crm_persona ,'refresh');

			else:

				$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');
			 	redirect('escuela_negocios/index/' ,'refresh');

			endif; 


		endif;
	}

	public function baja_referente()
	{
		chrome_log("Escuela_negocios/baja_referente");

	 	$_POST['id_crm_persona'] = $this->input->post('id_crm_persona');

		if ($this->form_validation->run('eliminar_persona') == FALSE):

			$datos['error'] = true;

		else:

			chrome_log("paso validacion");

			$resultado = $this->Escuela_negocios_model->abm_referente('B', $this->input->post() );

			if( $resultado > 0):

				$this->session->set_flashdata('mensaje', 'Se ha eliminado el referente exitosamente');
				$datos['error'] = false;

			else:

				$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');
				$datos['error'] = true;

			endif;

		endif;

		print json_encode($datos);
	}

	public function alta_empresa_referente()
	{
		chrome_log("Escuela_negocios/alta_empresa_referente");

		if ($this->form_validation->run('alta_empresa_referente') == FALSE):

			chrome_log("No paso validacion alta_empresa_referente");
			$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');

		else:

			chrome_log("Paso validacion");
	 		
			$resultado = $this->Escuela_negocios_model->abm_empresa_referente('A', $this->input->post());

			if( $resultado > 0):

				$this->session->set_flashdata('mensaje', 'Se ha cargado la empresa al referente exitosamente');
			    redirect('escuela_negocios/ver_referente/'.$this->input->post('id_crm_persona') ,'refresh');

			else:

				$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');

			endif;
				 

		endif;
	}


	public function baja_empresa_referente()
	{
		chrome_log("Escuela_negocios/baja_empresa_referente");

	 	if ($this->form_validation->run('baja_empresa_referente') == FALSE):
	 		chrome_log("No paso validacion");
			$datos['error'] = true;

		else:

			chrome_log("paso validacion");

			$resultado = $this->Escuela_negocios_model->abm_empresa_referente('B', $this->input->post() );

			if( $resultado > 0):

				chrome_log("Modifico");
				$this->session->set_flashdata('mensaje', 'Se ha la empresa del referente exitosamente');
				$datos['error'] = false;

			else:

				chrome_log("Error");
				$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');
				$datos['error'] = true;

			endif;

		endif;

		print json_encode($datos);
	}

	public function get_informacion_accion()
	{
		chrome_log("Escuela_negocios/get_informacion_accion");
 
		$acciones_resultado = $this->Escuela_negocios_model->get_informacion_accion($this->input->post('id_crm_accion'));

		$cadena['error'] = FALSE;

 
 		$cadena['id_crm_accion'] = $acciones_resultado->ID_CRM_ACCION;
		$cadena['id_empresa'] = $acciones_resultado->ID_EMPRESA;
		$cadena['id_crm_persona'] = $acciones_resultado->ID_CRM_PERSONA;
		$cadena['alarma'] = $acciones_resultado->ALARMA;
		$cadena['fecha_accion'] = $acciones_resultado->FECHA_ACCION;
		$cadena['descripcion'] = $acciones_resultado->DESCRIPCION;
		$cadena['fecha_resultado'] = $acciones_resultado->FECHA_RESULTADO;
		$cadena['descripcion_resultado'] = $acciones_resultado->DESCRIPCION_RESULTADO; 
		       
		print json_encode($cadena);
	}

	public function get_todas_acciones()
	{
		chrome_log("Escuela_negocios/get_todas_acciones");
		$array_acciones = array();
 
		$acciones_resultado = $this->Escuela_negocios_model->get_all_acciones();

		foreach ($acciones_resultado as $row) 
		{
				$cadena['title'] = $row['APELLIDO'].", ".$row['NOMBRE'];
				$cadena['start'] = $row['FECHA_ACCION'];
				$cadena['constraint'] = $row['DESCRIPCION'];
				$cadena['id'] = $row['ID_CRM_PERSONA'];
				array_push($array_acciones, $cadena);
		}
 
			       
		print json_encode($array_acciones);
	}

	public function get_acciones_referente_empresa()
	{
		chrome_log("Escuela_negocios/get_acciones_referente_empresa");
		$array_acciones = array();
		//$acciones_resultado = $this->Escuela_negocios_model->get_acciones_empresa($this->input->post('id_empresa'));
		$acciones_resultado = $this->Escuela_negocios_model->get_acciones_empresa_referente($this->input->post('id_empresa'),$this->input->post('id_crm_persona'));

		chrome_log("Escuela_negocios/get_acciones_referente_empresa");

		foreach ($acciones_resultado as $row) 
		{
				chrome_log("ENTRO PRUEBA");
	 
				$cadena['id'] = $row['ID_CRM_ACCION'];
				$cadena['title'] = $row['DESCRIPCION'];
				$cadena['start'] = $row['FECHA_ACCION'];
				$cadena['constraint'] = $row['ALARMA'];

				if(isset( $row['FECHA_RESULTADO'])){
					$cadena['respuesta'] = $row['FECHA_RESULTADO']." - ".$row['DESCRIPCION_RESULTADO'];
				}
				else{
					$cadena['respuesta'] = ''; }

				array_push($array_acciones, $cadena); 
		} 
			       
		print json_encode($array_acciones);
	}


	
	public function alta_accion_empresa()
	{
		chrome_log("Escuela_negocios/alta_accion_empresa");

		if ($this->form_validation->run('alta_accion_empresa') == FALSE):

			chrome_log("No paso validacion alta_accion_empresa");
			$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');
			echo validation_errors();

		else:

			chrome_log("Paso validacion");
	  		
			$resultado = $this->Escuela_negocios_model->abm_accion_empresa('A', $this->input->post());

			if( $resultado > 0):

				$this->session->set_flashdata('mensaje', 'Se ha cargado la acción exitosamente');

				$this->load->library('user_agent');

				if( strpos($this->agent->referrer(), 'ver_referente' ) )
					//redirect('escuela_negocios/ver_referente/'.$this->input->post('id_crm_persona').'/'.$this->input->post('id_crm_persona_empresa')  ,'refresh');
					redirect('escuela_negocios/ver_referente/'.$this->input->post('id_crm_persona').'/'.$this->input->post('id_empresa')  ,'refresh');
				else
					redirect('escuela_negocios/ver_empresa/'.$this->input->post('id_empresa'));


			else:

				$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');

			endif; 
				 

		endif;
	}

	public function modifica_accion_empresa()
	{
		chrome_log("Escuela_negocios/modifica_accion_empresa");

		if ($this->form_validation->run('modifica_accion_empresa') == FALSE):

			chrome_log("No paso validacion modifica_accion_empresa");
			$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');
			chrome_log(validation_errors());

		else:

			chrome_log("Paso validacion");
	  		 
			$resultado = $this->Escuela_negocios_model->abm_accion_empresa('M', $this->input->post());

			if( $resultado > 0):

				$this->session->set_flashdata('mensaje', 'Se ha modificado la acción exitosamente');

				$this->load->library('user_agent');

				if( strpos($this->agent->referrer(), 'ver_referente' ) )
					redirect('escuela_negocios/ver_referente/'.$this->input->post('id_crm_persona').'/'.$this->input->post('id_crm_persona_empresa')  ,'refresh');
				elseif( strpos($this->agent->referrer(), 'ver_empresa' ) )
					redirect('escuela_negocios/ver_empresa/'.$this->input->post('id_empresa').'/');
				else
					redirect('escuela_negocios/index');
			    

			else:

				$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');

			endif; 
				 

		endif;

		redirect('escuela_negocios/index');
	}

	public function baja_accion_empresa()
	{
		chrome_log("Escuela_negocios/baja_accion_empresa");

		if ($this->form_validation->run('baja_accion_empresa') == FALSE):

			chrome_log("No paso validacion baja_accion_empresa");
			$data['error'] = true;
			$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');

		else:

			chrome_log("Paso validacion");
	  	 
			$resultado = $this->Escuela_negocios_model->abm_accion_empresa('B', $this->input->post());

			if( $resultado > 0):

				$this->session->set_flashdata('mensaje', 'Se ha eliminado la acción exitosamente');
				$data['error'] = false;

			else:

				$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');
				$data['error'] = true;

			endif; 
				 

		endif;

		echo json_encode($data);
	}


	// ABM ACUERDO -------------------------

	public function alta_acuerdo_empresa()
	{
		chrome_log("Escuela_negocios/alta_acuerdo_empresa");

		if ($this->form_validation->run('alta_acuerdo_empresa') == FALSE):

			chrome_log("No paso validacion alta_acuerdo_empresa");
			$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');
			echo validation_errors();

		else:

			chrome_log("Paso validacion");
	  		
			$resultado = $this->Empresa_model->abm_acuerdo_empresa('A', $this->input->post());

			if( $resultado > 0):

				$this->session->set_flashdata('mensaje', 'Se ha cargado el acuerdo exitosamente');

 				redirect('escuela_negocios/ver_empresa/'.$this->input->post('id_empresa'));


			else:

				$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');

			endif; 
				 

		endif;
	}

	public function modifica_acuerdo_empresa()
	{
		chrome_log("Escuela_negocios/modifica_acuerdo_empresa");

		if ($this->form_validation->run('modifica_acuerdo_empresa') == FALSE):

			chrome_log("No paso validacion modifica_acuerdo_empresa");
			$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');
			echo validation_errors();

		else:

			chrome_log("Paso validacion");

			var_dump($this->input->post());
	  		
			$resultado = $this->Empresa_model->abm_acuerdo_empresa('M', $this->input->post());


	 
			if( $resultado > 0):

				$this->session->set_flashdata('mensaje', 'Se ha modificado el acuerdo exitosamente');

 				redirect('escuela_negocios/ver_empresa/'.$this->input->post('id_empresa'));


			else:

				$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');

			endif; 
				 

		endif;
	}

	public function baja_acuerdo_empresa()
	{
		chrome_log("Escuela_negocios/baja_acuerdo_empresa");

		if ($this->form_validation->run('baja_acuerdo_empresa') == FALSE):

			chrome_log("No paso validacion baja_acuerdo_empresa");
			$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');
			$return["error"] = TRUE;

		else:

			chrome_log("Paso validacion");
	  		
			$resultado = $this->Empresa_model->abm_acuerdo_empresa('B', $this->input->post());

			if( $resultado > 0):

				$this->session->set_flashdata('mensaje', 'Se ha eliminado el acuerdo exitosamente');
				$return["error"] = FALSE;

			else:

				$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');
				$return["error"] = TRUE;

			endif; 
				 

			print json_encode($return);

		endif;
	}

	// FIN ABM ACUERDO -------------------------



	// ABM CAMARA -------------------------

	public function alta_camara()
	{
		chrome_log("Escuela_negocios/alta_camara");

		if ($this->form_validation->run('alta_camara') == FALSE):

			chrome_log("No paso validacion alta_camara");
			$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');
			echo validation_errors();

		else:

			chrome_log("Paso validacion");
	  		
			$resultado = $this->Escuela_negocios_model->abm_camara('A', $this->input->post());

			if( $resultado > 0):

				$this->session->set_flashdata('mensaje', 'Se ha cargado la camara exitosamente');

 				redirect('escuela_negocios/escuela_negocios/');


			else:

				$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');

			endif; 
				 

		endif;
	}

	public function modifica_camara()
	{
		chrome_log("Escuela_negocios/modifica_acuerdo_empresa");

		if ($this->form_validation->run('modifica_acuerdo_empresa') == FALSE):

			chrome_log("No paso validacion modifica_acuerdo_empresa");
			$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');
			echo validation_errors();

		else:

			chrome_log("Paso validacion");

			var_dump($this->input->post());
	  		
			$resultado = $this->Empresa_model->abm_acuerdo_empresa('M', $this->input->post());


	 
			if( $resultado > 0):

				$this->session->set_flashdata('mensaje', 'Se ha modificado el acuerdo exitosamente');

 				redirect('escuela_negocios/ver_empresa/'.$this->input->post('id_empresa'));


			else:

				$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');

			endif; 
				 

		endif;
	}

	public function baja_camara()
	{
		chrome_log("Escuela_negocios/baja_acuerdo_empresa");

		if ($this->form_validation->run('baja_acuerdo_empresa') == FALSE):

			chrome_log("No paso validacion baja_acuerdo_empresa");
			$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');
			$return["error"] = TRUE;

		else:

			chrome_log("Paso validacion");
	  		
			$resultado = $this->Empresa_model->abm_acuerdo_empresa('B', $this->input->post());

			if( $resultado > 0):

				$this->session->set_flashdata('mensaje', 'Se ha eliminado el acuerdo exitosamente');
				$return["error"] = FALSE;

			else:

				$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');
				$return["error"] = TRUE;

			endif; 
				 

			print json_encode($return);

		endif;
	}

	// FIN ABM CAMARA -------------------------






	// ABM RESULTADO ACCION -------------------------

	public function alta_accion_resultado()
	{	
		chrome_log("Escuela_negocios/alta_accion_resultado");
		chrome_log('alta_accion_resultado');
		chrome_log('id_crm_accion: '.$this->input->post('id_crm_accion') );
		chrome_log('descripcion_finalizar_alarma: '.$this->input->post('descripcion_finalizar_alarma'));
		chrome_log('id_crm_persona: '.$this->input->post('id_crm_persona'));
		
		$_POST['id_crm_accion'] = $this->input->post('id_crm_accion');
		$_POST['descripcion_finalizar_alarma'] = $this->input->post('descripcion_finalizar_alarma');
		$_POST['id_crm_persona'] = $this->input->post('id_crm_persona');
 		
 		$this->form_validation->set_data($_POST);

		if ($this->form_validation->run('alta_accion_resultado') == FALSE):

			chrome_log("No paso validacion alta_accion_resultado");
			$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');
			//echo validation_errors();
			$data['error'] = TRUE;
			$data['mensaje'] = "No paso validación";
			chrome_log(validation_errors());

		else:

			chrome_log("Paso validacion");
	  		
			$resultado = $this->Escuela_negocios_model->abm_accion_resultado('A', $this->input->post());

			if( $resultado > 0):

				$this->session->set_flashdata('mensaje', 'Se ha agregado el resultado exitosamente');
                $data['error'] = FALSE;
				$data['mensaje'] = "No paso validación";

			else:

				$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');
				$data['error'] = TRUE;
				$data['mensaje'] = "Error interno, por favor intente mas tarde";

			endif; 
				 

		endif;

		print(json_encode($data));
	}

	public function modifica_accion_resultado()
	{
		chrome_log("Escuela_negocios/modifica_acuerdo_empresa");

		if ($this->form_validation->run('modifica_acuerdo_empresa') == FALSE):

			chrome_log("No paso validacion modifica_acuerdo_empresa");
			$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');
			echo validation_errors();

		else:

			chrome_log("Paso validacion");

			var_dump($this->input->post());
	  		
			$resultado = $this->Empresa_model->abm_acuerdo_empresa('M', $this->input->post());


	 
			if( $resultado > 0):

				$this->session->set_flashdata('mensaje', 'Se ha modificado el acuerdo exitosamente');

 				redirect('escuela_negocios/ver_empresa/'.$this->input->post('id_empresa'));


			else:

				$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');

			endif; 
				 

		endif;
	}

	public function baja_accion_resultado()
	{
		chrome_log("Escuela_negocios/baja_acuerdo_empresa");

		if ($this->form_validation->run('baja_acuerdo_empresa') == FALSE):

			chrome_log("No paso validacion baja_acuerdo_empresa");
			$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');
			$return["error"] = TRUE;

		else:

			chrome_log("Paso validacion");
	  		
			$resultado = $this->Empresa_model->abm_acuerdo_empresa('B', $this->input->post());

			if( $resultado > 0):

				$this->session->set_flashdata('mensaje', 'Se ha eliminado el acuerdo exitosamente');
				$return["error"] = FALSE;

			else:

				$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');
				$return["error"] = TRUE;

			endif; 
				 

			print json_encode($return);

		endif;
	}

	// FIN ABM ACUERDO -------------------------




	public function existe_email_referente()  // Validar que no exista en login.js para registrarse
	{
		chrome_log("Escuela_negocios/existe_email");

		if(  $this->Contacto_model->existe_email_crm($this->input->post('email')))
		{
			chrome_log("TRUE");
			$datos['error'] = TRUE;
			$resultado = $this->Contacto_model->traer_informacion_crm_persona_by_email($this->input->post('email'));
			$datos['es_referente'] = $this->Escuela_negocios_model->persona_es_referente($resultado['ID_USUARIO']);
			chrome_log("ES REFE:"+$datos['es_referente']);
			$datos['id_crm_persona']=$resultado['ID_USUARIO'];
			$datos['nombre']=$resultado['NOMBRE'];
			$datos['apellido']=$resultado['APELLIDO'];
		}
		else
		{
			chrome_log("FALSE");
			$datos['error'] = FALSE;

		}
		
		print json_encode($datos);
	}

	public function comprobar_persona_crm_existente_validation($id_crm_persona=null)
	{
		if($this->Escuela_negocios_model->existe_refente_crm($id_crm_persona))
			return false;
		else
			return true;
	}

	public function comprobar_empresa_crm_existente_validation($id_empresa=null)
	{
		if($this->Empresa_model->existe_empresa_crm($id_empresa))
			return false;
		else
			return true;
	}

	public function comprobar_camara_crm_existente_validation($id_camara=null)
	{
		if($this->Empresa_model->existe_camara_crm($id_camara))
			return false;
		else
			return true;
	}

	public function get_empresas()
	{	
		
		chrome_log("Draw: ".$_POST['draw']);
		chrome_log("Start: ".$_POST['start']); // De donde empezar
		chrome_log("Orden: ".$_POST['order'][0]['column']); // Columna por la que ordena
		chrome_log("Cantidad: ".$_POST['length']); // Cuantos mostrar
		chrome_log("Orden: ".$_POST['order'][0]['dir']);
		chrome_log("Buscar: ".$_POST['search']['value']); 

		$start = $_POST['start'];
		$columna_orden = $_POST['order'][0]['column'];
		$cantidad = $_POST['length'];
		$sentido_orden = $_POST['order'][0]['dir'];
		$texto_buscar = $_POST['search']['value'];		
		/*
		chrome_log($_POST['length']); 
		chrome_log($_POST['order'][0]['column']); // Column index
		chrome_log($_POST['columns'][$columnIndex]['data']); // Column name
		chrome_log($_POST['order'][0]['dir']); // asc or desc
		chrome_log($_POST['search']['value']); // Search value*/

		$empresas_encontradas = $this->Empresa_model->get_empresas_filtradas($start, $columna_orden, $cantidad, $sentido_orden, $texto_buscar);

		if( count($empresas_encontradas) > 0 ):
 
			foreach ($empresas_encontradas as $row) 
			{
				 
			 	$data[] = array( 
			      "empresa_nombre" => $row['D_EMPRESA'],
			      "boton_empresa" => "	<a href='".base_url()."index.php/escuela_negocios/ver_empresa/".$row['N_ID_EMPRESA']."' >
					                      <button type='button' class='btn btn-warning btn-s btn-ver-referente'  data-toggle='tooltip' data-placement='top'
                      data-original-title='Ver empresa'>
					                        <i class='fa fa-search'></i> 
					                      </button>
					                    </a>"
			   	);
			} 

		else:

			$data = array();

		endif;

		/*
		$data[] = array( 
		      "empresa_nombre"=> "AAAAA"
		   );*/
		
		

		$json_data = array(
                "draw"            => intval( $_REQUEST['draw'] ),
                "recordsTotal"    => intval( 1 ),
                "iTotalRecords" =>  intval (0),
                "recordsFiltered" => intval( 1),
                "data"            => $data
            );
		print json_encode($json_data);
	}

	public function get_camaras()
	{	
		
		chrome_log("Draw: ".$_POST['draw']);
		chrome_log("Start: ".$_POST['start']); // De donde empezar
		chrome_log("Orden: ".$_POST['order'][0]['column']); // Columna por la que ordena
		chrome_log("Cantidad: ".$_POST['length']); // Cuantos mostrar
		chrome_log("Orden: ".$_POST['order'][0]['dir']);
		chrome_log("Buscar: ".$_POST['search']['value']); 

		$start = $_POST['start'];
		$columna_orden = $_POST['order'][0]['column'];
		$cantidad = $_POST['length'];
		$sentido_orden = $_POST['order'][0]['dir'];
		$texto_buscar = $_POST['search']['value'];		
		/*
		chrome_log($_POST['length']); 
		chrome_log($_POST['order'][0]['column']); // Column index
		chrome_log($_POST['columns'][$columnIndex]['data']); // Column name
		chrome_log($_POST['order'][0]['dir']); // asc or desc
		chrome_log($_POST['search']['value']); // Search value*/

		$empresas_encontradas = $this->Empresa_model->get_camaras_filtradas($start, $columna_orden, $cantidad, $sentido_orden, $texto_buscar);

		if( count($empresas_encontradas) > 0 ):
 
			foreach ($empresas_encontradas as $row) 
			{
				 
			 	$data[] = array( 
			      "empresa_nombre" => $row['NOMBRE'],
			      "boton_empresa" => "	<a href='".base_url()."index.php/escuela_negocios/ver_camara/".$row['ID_CAMARA']."' >
					                      <button type='button' class='btn btn-warning btn-s btn-ver-referente'  data-toggle='tooltip' data-placement='top'
                      data-original-title='Ver camara'>
					                        <i class='fa fa-search'></i> 
					                      </button>
					                    </a>"
			   	);
			} 

		else:

			$data = array();

		endif;

 

		$json_data = array(
                "draw"            => intval( $_REQUEST['draw'] ),
                "recordsTotal"    => intval( 1 ),
                "iTotalRecords" =>  intval (0),
                "recordsFiltered" => intval( 1),
                "data"            => $data
            );
		print json_encode($json_data);
	}
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */