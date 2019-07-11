<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Consulta extends CI_Controller {


public function __construct()
{
	parent::__construct();
	$this->load->model('Consulta_model');
	$this->load->model('Contacto_model');
	$this->load->model('Configuracion_model');
	$this->load->model('Login_model');
	$this->load->model('Operador_model');
	$this->load->model('Alarma_model');
	$this->load->library('user_agent');
	$this->db = $this->load->database($this->session->userdata('DB'),TRUE, TRUE);

	// Cuando lo activo, no funciona el AJAX de mostrar programas
	//$this->output->enable_profiler(TRUE);
}

 
public function index()
{
	chrome_log("Consulta/index");

	// Traer ultimas consultas
	$consultas = $this->Consulta_model->traer_ultimas_consultas_importadas();
	$consultas_informacion = array();
	foreach ($consultas->result() as $row ):

		$informacion['consultas'] = $row;
		$informacion['persona'] = $this->Contacto_model->traer_informacion_crm_sigeu_persona($row->ID_CRM_PERSONA);
		$informacion['programas'] = $this->Consulta_model->traer_programas_consulta($row->ID_CRM_CONSULTA);
		array_push($consultas_informacion, $informacion);

	endforeach;

	$datos['consultas'] = $consultas_informacion;

	//sleep(10);
	$this->load->view('estructura/head');
	$this->load->view('consulta/consultas',$datos);
	$this->load->view('estructura/footer');
}

public function mis_consultas()
{
	// Traer ultimas consultas a cargo

	$consultas_a_cargo_query = $this->Consulta_model->traer_consultas_a_cargo($this->session->userdata('id_persona'));
	$consultas_a_cargo = array();
	$datos['mensaje'] = $this->session->flashdata('mensaje');
	 
	foreach ($consultas_a_cargo_query->result() as $row ):

		$informacion_a_cargo['consultas'] = $row;
		$informacion_a_cargo['persona'] = $this->Contacto_model->traer_informacion_crm_sigeu_persona($row->ID_CRM_PERSONA);

		$programas_consulta = $this->Consulta_model->traer_programas_consulta($row->ID_CRM_CONSULTA);

		// RECORRER LOS PROGRAMAS Y TRAER LOS COMENTARIOS

		$array_consulta_programas = array();

		foreach ($programas_consulta->result() as $row2)
		{
			$informacion_programa['programa'] = $row2;
			$informacion_programa['programas_comen'] = $this->Consulta_model->traer_comentarios_consultas_programa($row2->ID_CRM_CONSULTA_PROGRAMA);

			array_push($array_consulta_programas, $informacion_programa);
		}

		$informacion_a_cargo['programas'] = $array_consulta_programas;

		array_push($consultas_a_cargo, $informacion_a_cargo);

	endforeach;

	$datos['consultas_a_cargo'] = $consultas_a_cargo;
	$datos['estado_consulta'] = $this->Consulta_model->traer_estado_consulta_prg();
 
	$this->load->view('estructura/head');
	$this->load->view('consulta/mis_consultas',$datos);
	$this->load->view('estructura/footer');
}


public function asignar_consultas($flag_programas = NULL )
{
	chrome_log("Consulta/asignar_consultas");


	$consultas_sin_asignar = $this->Consulta_model->traer_consultas_sin_asignar();
	$array_consultas = array();
	$datos['mensaje'] = $this->session->flashdata('mensaje');
 	 
	foreach ($consultas_sin_asignar->result() as $row ):
	 
		$consultas['consultas'] = $row;
		$consultas['persona'] = $this->Contacto_model->traer_informacion_crm_sigeu_persona($row->ID_CRM_PERSONA);
		$consultas['programas'] = $this->Consulta_model->traer_programas_consulta($row->ID_CRM_CONSULTA);


 		if( isset( $flag_programas ) )
		{
			if( $flag_programas == 1)
			{
				if( $consultas['programas']->num_rows() == 1  )
				{
					array_push($array_consultas, $consultas);
				}
			}
			else
			{
				if( $consultas['programas']->num_rows() > 1  )
				{
					array_push($array_consultas, $consultas);
				}
			}
		}
		else
		{
			array_push($array_consultas, $consultas);	
		}


	endforeach; 

	$datos['consultas'] = $array_consultas;

	// Traer operadores
	$datos['operadores'] = $this->Operador_model->get_operadores();

	$datos['opeadores_cantidad'] = $this->Operador_model->get_consultas_asignadas_por_operadores();


	//var_dump($datos['opeadores_cantidad']);

	
	$this->load->view('estructura/head');
	$this->load->view('consulta/consultas_sin_asignar',$datos);
	$this->load->view('estructura/footer');
}

public function pipeline($id_estado = NULL)
{
	chrome_log("Consulta/pipeline");

	$datos['estado_consulta'] = $estados['estado_consulta'] = $this->Consulta_model->traer_estado_consulta_prg();
	$estados['id_estado'] = $id_estado;
	$datos['mensaje'] = $this->session->flashdata('mensaje');

	$array_pipeline = array();
	foreach ($estados['estado_consulta']->result() as $row):

			$pipeline['estado'] = $row;
			$pipeline['cantidad'] = $consultas_estado[$row->DESCRIPCION] = $this->Consulta_model->traer_consultas_prg_estado($row->ID_ESTADO, $this->session->userdata('id_persona'))->num_rows();
			array_push($array_pipeline, $pipeline ); 
		
	endforeach;

	$data_botonera['array_pipeline'] = $array_pipeline;


 	$this->load->view('estructura/head');

 
 	if(isset($id_estado)): // Traigo todas las consultas del estado en particular

		$estados['id_estado'] = $id_estado;

		$consultas = $this->Consulta_model->traer_consultas_prg_estado($id_estado, $this->session->userdata('id_persona'));

		//var_dump($consultas);

		$estados['cantidad_consultas'] = $consultas->num_rows();

		if($consultas->num_rows() > 0): // Si hay consultas del estado

			$consultas_informacion = array();

			foreach ($consultas->result() as $row):

				if( $id_estado == 5): // Entrevistas

					$informacion['entrevista'] = $this->Consulta_model->traer_entrevistas_consulta($row->ID_CRM_CONSULTA);

				elseif( $id_estado == 6): // Solicitud de admision

					$informacion['solicitud_admision'] = $this->Consulta_model->traer_sol_admision_consulta($row->ID_CRM_CONSULTA_PROGRAMA);


				endif;

				$informacion['consulta_programa'] = $row;
 				$informacion['persona'] = $this->Contacto_model->traer_informacion_crm_sigeu_persona($row->ID_CRM_PERSONA);
 				$informacion['comentarios'] = $this->Consulta_model->traer_comentarios_consultas_programa($row->ID_CRM_CONSULTA_PROGRAMA);

 				array_push($consultas_informacion, $informacion);

			endforeach;

			$datos['consultas'] = $consultas_informacion;

		endif;

 

	endif;
 
	//var_dump($datos);

	$datos['botonera'] = $this->load->view('consulta/botonera_pipeline',$data_botonera, TRUE);
	$this->load->view('consulta/pipeline',$datos);
 	$this->load->view('estructura/footer');
}

public function ver_consulta($id_consulta)
{
	chrome_log("Consulta/ver_consulta");

	$_POST['id_consulta'] = $id_consulta;
	$this->form_validation->set_message('comprobar_consulta_existente_validation', 'La consulta no existe.');

	if ( $this->form_validation->run('ver_consulta') == FALSE ):

		chrome_log("No paso validacion");
		//$datos['mensaje'] = $this->session->flashdata('mensaje');
		//echo validation_errors();
		redirect('home','refresh');

	else:
		chrome_log("Paso validacion");

		$datos['mensaje'] = $this->session->flashdata('mensaje');

		// Cambia el bool de visto a las consultas_programs que el operador tiene  acargo
		$this->Consulta_model->actualiza_consulta_vista( $id_consulta, $this->session->userdata('id_persona') );

		$datos['informacion_interes'] = $this->Consulta_model->traer_info_interes();
		$datos['periodo_ingreso'] = $this->Consulta_model->traer_periodo_ingreso();

		$datos['estado_consulta_prg'] = $this->Consulta_model->traer_estado_consulta_prg();
		$datos['estado_consulta'] = $this->Consulta_model->traer_estado_consulta();

		$datos['como_contactar'] = $this->Consulta_model->traer_como_contactar();
		$datos['operador_cargo'] = $this->Consulta_model->traer_operadores_cargo($id_consulta);
		$datos['alarmas'] = $this->Consulta_model->get_alarmas_consulta($id_consulta);
		$datos['consulta'] = $this->Consulta_model->traer_informacion_consulta($id_consulta);
		$datos['persona'] = $this->Contacto_model->traer_informacion_crm_sigeu_persona($datos['consulta']->ID_CRM_PERSONA);
		$datos['contactenme_consulta'] = $this->Consulta_model->traer_contactenme_consulta($id_consulta);
		$datos['informacion_interes_consulta'] = $this->Consulta_model->traer_info_interes_consulta($id_consulta);

		$datos['log_consulta'] = $this->Consulta_model->traer_log_consulta($id_consulta);

		$datos['programas_consulta'] = $this->Consulta_model->traer_programas_consulta($id_consulta);

		$programas_consulta = array();

		$datos['comentarios_generales_consulta'] = $this->Consulta_model->traer_comentarios_generales_consulta($id_consulta);

		foreach ($datos['programas_consulta']->result() as $row):

			$datos['informacion_programa'] = $row;
			$datos['comentarios_programa'] = $this->Consulta_model->traer_comentarios_consultas_programa($row->ID_CRM_CONSULTA_PROGRAMA);
			$datos['eventos_linea_tiempo'] = $this->Consulta_model->traer_eventos_linea_tiempo($row->ID_CRM_CONSULTA_PROGRAMA, $id_consulta);
			$datos['solicitud_admision_con_prg'] = $this->Consulta_model->traer_sol_admision_consulta($row->ID_CRM_CONSULTA_PROGRAMA);

			array_push($programas_consulta, $datos);

		endforeach;

		$datos['programas'] = $programas_consulta;

		$datos['emails_consulta'] = $this->Consulta_model->traer_email_consulta($id_consulta);

		$this->load->view('estructura/head');
		$this->load->view('consulta/ver_consulta',$datos);
		$this->load->view('estructura/footer');


	endif;
}

public function ver_alta_consulta_1()
{
	chrome_log("Consulta/ver_alta_consulta");

	$datos['mensaje'] = $this->session->flashdata('mensaje');
	$datos['niveles_educacion'] = $this->Contacto_model->traer_niveles_educacion();
	$datos['mensaje'] = $this->session->flashdata('mensaje');

	$this->load->view('estructura/head');
	$this->load->view('consulta/ver_alta_consulta_1',$datos);
	$this->load->view('estructura/footer');
}

public function ver_alta_consulta_2()
{
	chrome_log("Consulta/ver_alta_consulta_2");

	if ($this->form_validation->run('ver_alta_consulta_2') == FALSE):

		chrome_log("No paso validacion");
		$this->session->set_flashdata('mensaje', validation_errors() );

		redirect('consulta/ver_alta_consulta_1/','refresh');

	else:

		chrome_log("Paso validacion");

	 	$array_coincidencias = array();

		// BUSCAR COINCIDENCIAS EN SIGEU --------------------------------

		//var_dump($this->input->post("id_nivel"));

	 	$usuario = new \stdClass;

	 	$usuario->APELLIDO = $this->input->post("apellido");
	 	$usuario->NOMBRE = $this->input->post("nombre");
	 	$usuario->EMAIL = $this->input->post("email");
	 	$usuario->TELEFONO = $this->input->post("telefono");
	 	$usuario->EMPRESA = $this->input->post("empresa");
	 	//$usuario->CARGO = $this->input->post("cargo");



	 	// EDUCACION

	 	if( $this->input->post("id_educacion") ): // Eligio educacion SIGEU

	 		$usuario->ID_EDUCACION = $this->input->post("id_educacion");

	 	elseif( $this->input->post("educacion_manual") ): // Escribio una educacion MANUAL

	 		$usuario->EDUCACION_MANUAL = $this->input->post("educacion_manual");

	 	endif;

	 	if(	$this->input->post("id_nivel_sigeu") OR $this->input->post("id_nivel_sigeu") == 0 ):

	 		$usuario->ID_NIVEL = $this->input->post("id_nivel_sigeu");

	 	endif;

	 	if(	$this->input->post("id_nivel_manual") OR $this->input->post("id_nivel_manual") == 0  ):

	 		$usuario->ID_NIVEL = $this->input->post("id_nivel_manual");

	 	endif;

	 	// EMPRESA

	 	if( $this->input->post("id_empresa") ): // Eligio empresa SIGEU

	 		$usuario->ID_EMPRESA = $this->input->post("id_empresa");


	 	elseif( $this->input->post("empresa_manual") ): // Escribio una empresa MANUAL

	 		$usuario->EMPRESA_MANUAL = $this->input->post("empresa_manual");

	 	endif;

	 	if( $this->input->post("cargo_manual") ):

	 		$usuario->CARGO = $this->input->post("cargo_manual");

	 	elseif( $this->input->post("cargo_sigeu") ):

	 		$usuario->CARGO = $this->input->post("cargo_sigeu");

	 	endif;



 		if($resultado = $this->Contacto_model->buscar_coincidencia_en_sigeu($usuario) ):

			if( $resultado->num_rows() > 0):

		 		foreach ($resultado->result() as $row):

		 			$datos_usuario_econtrado['datos_usuario'] = $datos_usuario = $this->Contacto_model->traer_informacion_persona($row->N_ID_PERSONA);
		 		 	$datos_usuario_econtrado['imagen_usuario'] = NULL;
		 		 	$datos_usuario_econtrado['coincidencias'] =  $row;
					array_push($array_coincidencias,$datos_usuario_econtrado);

		 		endforeach;

			endif;

		endif;

		// BUSCAR COINCIDENCIAS EN CRM -----------------------------------

		if($resultado = $this->Contacto_model->buscar_coincidencia_en_crm($usuario) ):

			if( $resultado->num_rows() > 0):

		 		foreach ($resultado->result() as $row):

		 			$datos_usuario_econtrado['datos_usuario'] = $datos_usuario = $this->Contacto_model->traer_informacion_crm_persona($row->ID_CRM_PERSONA);
		 			$datos_usuario_econtrado['imagen_usuario'] = NULL;
		 		 	$datos_usuario_econtrado['coincidencias'] =  $row;

					array_push($array_coincidencias,$datos_usuario_econtrado);

		 		endforeach;

			endif;

		endif;

	 	$datos['usuario_buscado'] = $usuario;
	 	$datos['array_coincidencias'] =$array_coincidencias;

		$datos['informacion_interes'] = $this->Consulta_model->traer_info_interes();
		$datos['periodo_ingreso'] = $this->Consulta_model->traer_periodo_ingreso();
		$datos['estado_consulta'] = $this->Consulta_model->traer_estado_consulta_prg();
		$datos['como_contactar'] = $this->Consulta_model->traer_como_contactar();

	 	$this->load->view('estructura/head');
		$this->load->view('consulta/ver_alta_consulta_2',$datos);
		$this->load->view('estructura/footer');


	endif;
}


public function ver_alta_consulta_3()
{
	chrome_log("Consulta/ver_alta_consulta_3");

	if ($this->form_validation->run('ver_alta_consulta_3') == FALSE):

		chrome_log("No paso validacion");
		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');
		redirect('consulta/ver_alta_consulta_1/','refresh');

	else:

		chrome_log("Paso validacion");

		$datos['informacion_interes'] = $this->Consulta_model->traer_info_interes();
		$datos['periodo_ingreso'] = $this->Consulta_model->traer_periodo_ingreso();
		$datos['estado_consulta'] = $this->Consulta_model->traer_estado_consulta_prg();
		$datos['como_contactar'] = $this->Consulta_model->traer_como_contactar();

		$datos['datos_persona'] = $this->input->post('datos_persona');


		$datos_per =  str_replace( "&", "\"",  $this->input->post('datos_persona'));
  		$datos_per = json_decode($datos_per);
  		//var_dump($datos_per);

  		if(isset($datos_per->id_educacion)):
  			$datos['id_educacion'] = $datos_per->id_educacion;
  			$datos['nombre_educacion'] = $this->Contacto_model->traer_nombre_educacion($datos_per->id_educacion);

  		elseif(isset($datos_per->educacion_manual)):

  			$datos['educacion_manual'] = $datos_per->educacion_manual;

  		endif;

  		if(isset($datos_per->id_nivel)):
  			$datos['id_nivel'] = $datos_per->id_nivel;
  		endif;


  		if(isset($datos_per->id_empresa)):
  			$datos['id_empresa'] = $datos_per->id_empresa;
  			$datos['nombre_empresa'] = $this->Contacto_model->traer_nombre_educacion	($datos_per->id_empresa);

  		elseif(isset($datos_per->empresa_manual)):

  			$datos['empresa_manual'] = $datos_per->empresa_manual;

  		endif;



  		//var_dump($datos);
	 	$this->load->view('estructura/head');
		$this->load->view('consulta/ver_alta_consulta_3',$datos);
		$this->load->view('estructura/footer');


	endif;

	//redirect('consulta/ver_consulta/'.$this->input->post('id_crm_consulta') ,'refresh');
}

public function alta_consulta()
{
	chrome_log("Consulta/alta_consulta");

	if ($this->form_validation->run('alta_consulta') == FALSE):

		chrome_log("No paso validacion");
		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');

	else:

		chrome_log("Paso validacion");


		// Datos de la persona

			$datos_persona =  str_replace( "&", "\"", $this->input->post('datos_persona'));
			$datos_persona = json_decode($datos_persona);


		// Datos de la consulta

			$datos_consulta = array (	'id_codigo' => $this->input->post('id_codigo', TRUE),
										'id_contactenme' => $this->input->post('id_contactenme', TRUE),
										'horario_telefono' => $this->input->post('horario_telefono', TRUE),
										'horario_what' => $this->input->post('horario_what', TRUE),
										'anio' => $this->input->post('anio', TRUE),
										'id_periodo' => $this->input->post('id_periodo', TRUE),
										'comentario' => $this->input->post('comentario', TRUE),
										'id_info_interes' => $this->input->post('id_info_interes', TRUE)
									);

			//var_dump($datos_persona);

		if( $id_consulta = $this->Consulta_model->alta_consulta($datos_persona, $datos_consulta)):

			$this->session->set_flashdata('mensaje', 'Consulta cargada exitosamente');

		else:

			$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');

		endif;

	endif;

	redirect('consulta/ver_consulta/'.$id_consulta ,'refresh');
}

public function buscar_consulta($post = NULL)
{
	//chrome_log("Consulta/buscar_consulta");

	ini_set('memory_limit', '-1');

	if(isset($post)):

		$cadena = rawurldecode($post);
		$cadena_post_json = json_decode($cadena);
		$filtros = (array) $cadena_post_json;

	else:

		if($this->input->post())
			$filtros =  $this->input->post();
		else
			redirect('home' ,'refresh');
	endif;


	$datos['mensaje'] = $this->session->flashdata('mensaje');
	$condiciones = null;

	$consultas_informacion = array();

	$consultas = $this->Consulta_model->buscar_consulta( $filtros, $condiciones ); // Condiciones va por referencia


	$datos['condiciones_programas'] = $condiciones;
	$datos['consultas'] = $consultas;
	$datos['estado_consulta'] = $this->Consulta_model->traer_estado_consulta_prg();

	$cadena_post_json = json_encode($filtros);
	$datos['variable_post'] = rawurlencode($cadena_post_json);

	$this->load->view('estructura/head');
	$this->load->view('consulta/resultado_busqueda_consulta',$datos);
	$this->load->view('estructura/footer');
}

public function ver_enviar_email_masivo()
{

	chrome_log("Consulta/ver_enviar_email_masivo");

	if ($this->form_validation->run('ver_enviar_email_masivo') == FALSE):

		chrome_log("No paso validacion");
		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');
		redirect('home');

	else:

		chrome_log("Paso validacion");

	 	$array_personas = array();

		foreach ($this->input->post('id_consulta') as $key => $value):

			$informacion['id_consulta'] = $value;
			$id_persona = $this->Consulta_model->buscar_id_persona_consulta( $value );

			$informacion['informacion_persona'] = $this->Contacto_model->traer_informacion_crm_sigeu_persona($id_persona);
		   	array_push($array_personas, $informacion);

		endforeach;

		$datos['personas_consulta'] = $array_personas;
		$datos['emails_plantillas'] = $this->Configuracion_model->traer_emails_plantillas();

		$this->load->library('user_agent');
		$datos['url_referer'] = $this->agent->referrer();


		$this->load->view('estructura/head');
		$this->load->view('consulta/ver_enviar_email_masivo',$datos);
		$this->load->view('estructura/footer');


	endif;
}

// La diferencia con el aanterior es que aca se manda por consulta_programa
// y no por consulta entonces la valicacion es por id_consulta_prg

public function ver_enviar_email_masivo_prg()
{

	chrome_log("Consulta/ver_enviar_email_masivo_prg");

	if ($this->form_validation->run('ver_enviar_email_masivo_prg') == FALSE):

		chrome_log("No paso validacion");
		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');
		//redirect('home');

	else:

		chrome_log("Paso validacion");


	 	$array_personas = array();

		foreach ($this->input->post('id_consulta_prg') as $key => $value):

			$informacion['id_consulta_prg'] = $value;
		    $informacion['id_consulta'] = $this->Consulta_model->traer_id_consulta_by_consulta_prg( $value );


			$id_persona = $this->Consulta_model->buscar_id_persona_consulta( $informacion['id_consulta'] );

			$informacion['informacion_persona'] = $this->Contacto_model->traer_informacion_crm_sigeu_persona($id_persona);
		   	array_push($array_personas, $informacion);

		endforeach;

		$datos['personas_consulta'] = $array_personas;
		$datos['emails_plantillas'] = $this->Configuracion_model->traer_emails_plantillas();

		$this->load->library('user_agent');
		$datos['url_referer'] = $this->agent->referrer();


		$this->load->view('estructura/head');
		$this->load->view('consulta/ver_enviar_email_masivo',$datos);
		$this->load->view('estructura/footer');


	endif;
}


public function asignar_info_interes()
{
	chrome_log("Consulta/asignar_info_interes");

	if ($this->form_validation->run('asignar_info_interes') == FALSE):

		chrome_log("No paso validacion");
		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');

	else:

		chrome_log("Paso validacion");

		$resultado = $this->Consulta_model->asignar_info_interes($this->input->post());

		if( $resultado > 0):

			$this->session->set_flashdata('mensaje', 'Informacion de interes cargada exitosamente');

		else:

			$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');

		endif;


	endif;

	redirect('consulta/ver_consulta/'.$this->input->post('id_crm_consulta') ,'refresh');
}


public function modifica_periodo_ingreso()
{
	chrome_log("Consulta/modifica_periodo_ingreso");

	if ($this->form_validation->run('modifica_periodo_ingreso') == FALSE):

		chrome_log("No paso validacion");
		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');

	else:

		chrome_log("Paso validacion");

		$resultado = $this->Consulta_model->modifica_periodo_ingreso($this->input->post());

		if( $resultado > 0):

			$this->session->set_flashdata('mensaje', 'Periodo modificado exitosamente');

		else:

			$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');

		endif;


	endif;

	redirect('consulta/ver_consulta/'.$this->input->post('id_crm_consulta') ,'refresh');
}


public function tomar_consulta($id_crm_consulta)
{
	chrome_log("Consulta/tomar_consulta");

	$_POST['id_crm_consulta'] = $id_crm_consulta;
   	$this->form_validation->set_data($_POST);

	if ($this->form_validation->run('tomar_consulta') == FALSE):

		chrome_log("No paso validacion");
		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');

	else:

		chrome_log("Paso validacion");

		$resultado = $this->Consulta_model->tomar_consulta($id_crm_consulta);

		if( $resultado > 0):

			$this->session->set_flashdata('mensaje', 'Consulta tomada exitosamente');

		else:

			$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');

		endif;


	endif;

	redirect('consulta/ver_consulta/'.$id_crm_consulta ,'refresh');
}

public function desestimar_programa()
{
	chrome_log("Consulta/desestimar_programa/".$this->input->post('id_crm_consulta_programa'));

	if ($this->form_validation->run('desestimar_programa') == FALSE):

		chrome_log("No paso validacion");
		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');
		$return["error"] = TRUE;

	else:

		chrome_log("Paso validacion");

		$resultado = $this->Consulta_model->desestimar_programa( $this->input->post('id_crm_consulta_programa'));

		if( $resultado > 0):

			$return["error"] = FALSE;
			$this->session->set_flashdata('mensaje', 'Programa desestimado exitosamente');

		else:

			$return["error"] = TRUE;
			$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');

		endif;


	endif;

	print json_encode($return);
}


public function procesa_cambiar_estado_consulta()
{
	chrome_log("Consulta/procesa_cambiar_estado_consulta");
		

	if ($this->form_validation->run('modificar_estado_consulta') == FALSE):

		chrome_log("No paso validacion");
		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');

	else:

		chrome_log("Paso validacion");

		$resultado = $this->Consulta_model->modificar_estado_consulta($this->input->post());

		if( $resultado > 0):

			$this->session->set_flashdata('mensaje', 'Estado modificado exitosamente');

		else:

			$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');

		endif;


	endif;

	redirect('consulta/ver_consulta/'.$this->input->post('id_crm_consulta') ,'refresh');
}

public function modificar_como_contactar()
{
	chrome_log("Consulta/modificar_como_contactar");

	if ($this->form_validation->run('modificar_como_contactar') == FALSE):

		chrome_log("No paso validacion");
		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');
		echo validation_errors();

	else:

		chrome_log("Paso validacion");


		$resultado = $this->Consulta_model->modificar_como_contactar($this->input->post());

		if( $resultado > 0):

			$this->session->set_flashdata('mensaje', 'Como contactarlo modificado exitosamente');

		else:

			$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');

		endif;


	endif;

	redirect('consulta/ver_consulta/'.$this->input->post('id_crm_consulta') ,'refresh');
}


public function modificar_programas()
{
	chrome_log("Consulta/modificar_programas");

	if ($this->form_validation->run('modificar_programas') == FALSE):

		chrome_log("No paso validacion");
		$this->session->set_flashdata('mensaje', 'Error: no paso validación');

	else:

		chrome_log("Paso validacion");

		$resultado = $this->Consulta_model->modificar_programas_consulta($this->input->post());

		if( $resultado > 0):

			$this->session->set_flashdata('mensaje', 'Programas modificados exitosamente');

		else:

			$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');

		endif;


	endif;

	redirect('consulta/ver_consulta/'.$this->input->post('id_crm_consulta') ,'refresh');
}

public function enviar_email_consulta()
{
	chrome_log("Consulta/enviar_email_consulta");

	var_dump($this->input->post('mensaje_email'));

	if ($this->form_validation->run('enviar_email_consulta') == FALSE):

		chrome_log("No paso validacion");

	else:

		chrome_log("Paso validacion");

		$email_operador = $this->Login_model->traer_email_persona($this->session->userdata('id_persona'));

		$mensaje_resultado = '';
		$mensaje_final = '';

		$email_operador = $this->Login_model->traer_email_persona($this->session->userdata('id_persona'));
		$nombre_operador = $this->Login_model->traer_nombre_persona_by_id($this->session->userdata('id_persona'));


	 
		foreach ($this->input->post('email') as $email_to):

			//$mensaje_resultado = enviar_email( $email_to, $email_operador, $this->input->post('subject'), $this->input->post('mensaje_email') );

			$nombre_persona = $this->Login_model->traer_nombre_persona_by_id_consulta($this->input->post('id_crm_consulta'));
			/*
			$mensaje_resultado = enviar_email( 	$email_to,
												$email_operador,
												$this->input->post('subject'),
												$this->input->post('mensaje_email'),
												$nombre_operador,
												$nombre_persona
											);*/

		 
			$this->Consulta_model->grabar_email_consulta(	$this->input->post('id_crm_consulta') ,
															$this->input->post('subject') ,
															$mensaje_resultado,
															$email_to,
															$this->input->post('mensaje_email'),
															$this->session->userdata('usuario_crm') ); 


			$mensaje_final .= $mensaje_resultado;

			$this->Consulta_model->insertar_log_consulta( 3, $this->input->post('id_crm_consulta'),$this->input->post('mensaje_email') );

		endforeach;

		$this->session->set_flashdata('mensaje', $mensaje_resultado); 
		// echo $mensaje_resultado;

	endif;

	//redirect('consulta/ver_consulta/'.$this->input->post('id_crm_consulta') ,'refresh');
}

public function enviar_email_masivo()
{
	chrome_log("Consulta/enviar_email_masivo");

	if ($this->form_validation->run('enviar_email_masivo') == FALSE):

		chrome_log("No paso validacion");
		echo validation_errors();

	else:

		chrome_log("Paso validacion");
		//print_r($this->input->post());

		$email_operador = $this->Login_model->traer_email_persona($this->session->userdata('id_persona'));
		$nombre_operador = $this->Login_model->traer_nombre_persona_by_id($this->session->userdata('id_persona'));


 		$mensaje_resultado = '';
		$mensaje_final = '';

		foreach ($this->input->post('email') as $cadena):

			$array = explode("[|]", $cadena);

			$email = $array[0];
			$id_crm_consulta = $array[1];

			if(isset($array[2]))
				$id_consulta_programa = $array[2];
			else
				$id_consulta_programa = NULL;

			if( $this->input->post('id_crm_email_plantilla_elegida') ):
				chrome_log("ELEGIDO");
				$id_crm_email_plantilla = $this->input->post('id_crm_email_plantilla_elegida');
			else:
				chrome_log("NO ELEGIDO");
				$id_crm_email_plantilla = NULL;
			endif;

			$email_to = $email;

			$nombre_persona = $this->Login_model->traer_nombre_persona_by_id_consulta($id_crm_consulta);

			$mensaje_resultado = enviar_email( $email_to, $email_operador, $this->input->post('asunto'), $this->input->post('mensaje_email'), $nombre_operador, $nombre_persona );


			$this->Consulta_model->grabar_email_consulta(	$id_crm_consulta ,
															$this->input->post('asunto') ,
															$mensaje_resultado,
															$email,
															$this->input->post('mensaje_email'),
															$this->session->userdata('usuario_crm'),
															$id_consulta_programa,
															$id_crm_email_plantilla );


			$mensaje_final .= $mensaje_resultado;

			$this->Consulta_model->insertar_log_consulta( 10 , $id_crm_consulta, $this->input->post('mensaje_email') );

		endforeach;


		 $this->session->set_flashdata('mensaje', $mensaje_final);

	endif;

	if( strpos($this->input->post('url_referer'), '/mis_consultas') > 0 )
		redirect('consulta/mis_consultas');
 	elseif( strpos($this->input->post('url_referer'), '/buscar_consulta') > 0 )
 		redirect('consulta/index');
 	elseif( strpos($this->input->post('url_referer'), '/pipeline') > 0 )
 	{

 		$url_cortada = explode("/", $this->input->post('url_referer'));
 		redirect('consulta/pipeline/'.$url_cortada[7]);
 	}

}



public function procesa_cambiar_estado_cons_prg()
{
	chrome_log("Consulta/procesa_cambiar_estado_cons_prg");

	if ($this->form_validation->run('procesa_cambiar_estado_cons_prg') == FALSE):

		chrome_log("No paso validacion");
		$return["error"] = true;

	else:

		chrome_log("Paso validacion");

		chrome_log($this->input->post('id_crm_consulta_programa'));

		$resultado = $this->Consulta_model->modificar_estado_consulta_prg($this->input->post());


		if( $resultado ):

			chrome_log("FALSE");

			$return["error"] = false;
			$this->session->set_flashdata('mensaje', 'Estado modificado exitosamente');

		else:

			chrome_log("TRUE");

			$return["error"] = true;
			$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');

		endif;

	endif;

	print json_encode($return);
	//redirect('consulta/ver_consulta/'.$this->input->post('id_crm_consulta') ,'refresh');
}

/*
public function enviar_email_consulta()
{
	chrome_log("Consulta/enviar_email_consulta");

	if ($this->form_validation->run('enviar_email_consulta') == FALSE):

		chrome_log("No paso validacion");
		echo validation_errors();

	else:

		chrome_log("Paso validacion");

		$this->load->library("email"); //cargamos la libreria email de ci

		$email_operador = $this->Login_model->traer_email_persona($this->session->userdata('id_persona'));


		// $config_ucema = array(
		// 	'protocol' => 'smtp',
		// 	'smtp_host' => 'ssl://smtp.googlemail.com',
		// 	'smtp_port' => 465,
		// 	'smtp_user' => 'digipayargentina@gmail.com',
		// 	'smtp_pass' => 'digipay2016',
		// 	'mailtype' => 'html',
		// 	'charset' => 'utf-8',
		// 	'newline' => "\r\n"
		// );

		// Configuracion para produccion

		$config_ucema = array(
			'protocol' => 'smtp',
			'smtp_host' => 'spop.ucema.edu.ar',
			'smtp_port' => 25,
			'smtp_user' => '',
			'smtp_pass' => '',
			'mailtype' => 'html',
			'charset' => 'utf-8',
			'newline' => "\r\n"
		);

		//Cargamos la configuración
		$this->email->initialize($config_ucema);
		$this->email->from($email_operador);
		$this->email->subject($this->input->post('subject'));

		$texto = html_entity_decode( $this->input->post('mensaje_email') , ENT_QUOTES, "UTF-8");
        $this->email->message($texto);

        $mensaje_resultado = '';
        $exito_email = 0;
        $emails = '';

		foreach ($this->input->post('email') as $value):

			$this->email->to($value);

			$emails .= $value.";";

			if( $this->email->send() ):

				$exito_email = 1;

			else:

				$exito_email = 0;

	 		endif;

	 		if($exito_email == 1): // Lo envio


 				$mensaje_resultado .= "El email a ".$value." fue enviado exitosamente. <br>";

 			else: // No lo envio

 				$mensaje_resultado .= "Error al enviar el email a ".$value.", intente mas tarde. <br>";

	 		endif;


       		$exito_email = 0;

		endforeach;

		$this->session->set_flashdata('mensaje', $mensaje_resultado);

 		$this->Consulta_model->grabar_email_consulta($this->input->post(), $mensaje_resultado, $emails,$texto, $this->session->userdata('usuario_crm') );


	endif;

	redirect('consulta/ver_consulta/'.$this->input->post('id_crm_consulta') ,'refresh');
}
*/

public function ajax_programa()
{
	chrome_log("ajax_programa");

	$buscar = $this->input->get('term');

	if( isset($buscar) && strlen($buscar) > 1 )
	{
		$buscar = strtoupper($buscar);
		$buscar = str_replace(" ", "%", $buscar);
		$buscar = str_replace("ñ", "Ñ", $buscar);

			chrome_log("  	SELECT  C_IDENTIFICACION|| '-'|| C_PROGRAMA||'-'|| C_ORIENTACION as id,
																D_DESCRIP as value,
																D_DESCRED
											            FROM PROGRAMAS
											            WHERE
											            	 ( 	TRANSLATE(upper(D_DESCRIP),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE '%$buscar%'

											              	    OR

											              	    TRANSLATE(upper(D_DESCRED),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE '%$buscar%'
											              	  )
											            ORDER BY d_descrip ");

			$query=$this->db->query(("  	SELECT  C_IDENTIFICACION|| '-'|| C_PROGRAMA||'-'|| C_ORIENTACION as id,
																D_DESCRIP as value,
																D_DESCRED
											            FROM PROGRAMAS
											            WHERE
											            	 ( 	TRANSLATE(upper(D_DESCRIP),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE '%$buscar%'

											              	    OR

											              	    TRANSLATE(upper(D_DESCRED),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE '%$buscar%'
											              	  )
											            ORDER BY d_descrip "));


			if($query->num_rows() > 0)
			{
				foreach ($query->result() as $row)
				{
					$codigo = $row->ID;
					$id = rand();

					$prg =  "	<div class='form-group eliminar_programa' id='".$id."' >
			                        <div class='input-group date' style='z-index:0'>
			                          <div class='input-group-addon'>
			                            <i class='fa fa-trash' aria-hidden='true'></i>
			                          </div>
			                              <input readonly='readonly' class='form-control' type='text' name='programa[]' id='programa' value='".$row->D_DESCRED."'>
			                              <input readonly='readonly' class='form-control' type='hidden' name='id_codigo[]' id='id_codigo' value='".$codigo."'>
			                        </div>
			                    </div>"  ;

					$result[]= array( 	"codigo" => $row->ID ,
										"value" => $row->VALUE,
										"mensaje" => $prg
									);


				}
			}

			echo json_encode($result);
		}
}

public function ajax_educacion()
{
	chrome_log("ajax_educacion: " );

	$buscar = $this->input->get('term');

	if( isset($buscar) && strlen($buscar) > 1 )
	{
		$buscar = strtoupper($buscar);
		$buscar = str_replace(" ", "%", $buscar);
		$buscar = str_replace("ñ", "Ñ", $buscar);


 		chrome_log("  SELECT 	e.N_ID_EMPRESA,
														DECODE(ed.D_DIRECCION,  NULL, UPPER(e.D_EMPRESA) , UPPER(e.D_EMPRESA) || ' ( '|| lower(ed.D_DIRECCION)  || ':'|| ed.N_DOMICILIO || ' )') as value,
														e.D_REDUCIDA,
														e.D_DESC_COM,
														e.D_ALIAS_COLEGIO
												FROM 	empresas e
														LEFT JOIN  empresas_domicilios ed ON e.N_ID_EMPRESA = ed.N_ID_EMPRESA
												WHERE ( e.c_rubro = 'Universitario'
												OR e.c_rubro = 'Secundario' )
												AND (
												   	TRANSLATE(upper(e.D_EMPRESA),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE '%$buscar%'
												OR  TRANSLATE(upper(e.D_DESC_COM),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE '%$buscar%'
												OR  TRANSLATE(upper(e.D_REDUCIDA),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE '%$buscar%'
												OR  TRANSLATE(upper(e.D_DESC_COM),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE '%$buscar%'
												OR  TRANSLATE(upper(e.D_ALIAS_COLEGIO),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE '%$buscar%'
												)
												ORDER BY e.D_EMPRESA");

		$query=$this->db->query(("  SELECT 	e.N_ID_EMPRESA,
														DECODE(ed.D_DIRECCION,  NULL, UPPER(e.D_EMPRESA) , UPPER(e.D_EMPRESA) || ' ( '|| lower(ed.D_DIRECCION)  || ':'|| ed.N_DOMICILIO || ' )') as value,
														e.D_REDUCIDA,
														e.D_DESC_COM,
														e.D_ALIAS_COLEGIO
												FROM 	empresas e
														LEFT JOIN  empresas_domicilios ed ON e.N_ID_EMPRESA = ed.N_ID_EMPRESA
												WHERE ( e.c_rubro = 'Universitario'
												OR e.c_rubro = 'Secundario' )
												AND (
												   	TRANSLATE(upper(e.D_EMPRESA),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE '%$buscar%'
												OR  TRANSLATE(upper(e.D_DESC_COM),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE '%$buscar%'
												OR  TRANSLATE(upper(e.D_REDUCIDA),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE '%$buscar%'
												OR  TRANSLATE(upper(e.D_DESC_COM),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE '%$buscar%'
												OR  TRANSLATE(upper(e.D_ALIAS_COLEGIO),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE '%$buscar%'
												)
												ORDER BY e.D_EMPRESA"
											)
								);


		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{


				$result[]= array( 	"id_empresa" => utf8_encode($row->N_ID_EMPRESA) ,
									"value" => utf8_encode($row->VALUE)
								);


			}
		}

		echo json_encode($result);
	}
}

public function ajax_empresa()
{
	chrome_log("ajax_empresa: " );

	$buscar = $this->input->get('term');

	if( isset($buscar) && strlen($buscar) > 1 )
	{
		$buscar = strtoupper($buscar);
		$buscar = str_replace(" ", "%", $buscar);
		$buscar = str_replace("ñ", "Ñ", $buscar);

		/*
		$query=$this->db->query((utf8_decode("  SELECT 	e.N_ID_EMPRESA,
														DECODE(ed.D_DIRECCION,  NULL, UPPER(e.D_EMPRESA) , UPPER(e.D_EMPRESA) || ' ( '|| lower(ed.D_DIRECCION)  || ':'|| ed.N_DOMICILIO || ' )') as value,
														e.D_REDUCIDA,
														e.D_DESC_COM,
														e.D_ALIAS_COLEGIO
												FROM 	empresas e
														LEFT JOIN  empresas_domicilios ed ON e.N_ID_EMPRESA = ed.N_ID_EMPRESA
												WHERE ( e.c_rubro = 'Empresas'  )
												AND (
												   	TRANSLATE(upper(e.D_EMPRESA),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE '%$buscar%'
												OR  TRANSLATE(upper(e.D_DESC_COM),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE '%$buscar%'
												OR  TRANSLATE(upper(e.D_REDUCIDA),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE '%$buscar%'
												OR  TRANSLATE(upper(e.D_DESC_COM),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE '%$buscar%'
												OR  TRANSLATE(upper(e.D_ALIAS_COLEGIO),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE '%$buscar%'
												)
												ORDER BY e.D_EMPRESA"
											)
								));*/
		
		// Sque el  e.c_rubro = 'Empresas' porque hay empresas como SANTANDER RIO que no aparece porque esta como "ente financiero"

		$query=$this->db->query(("  SELECT 	e.N_ID_EMPRESA,
														DECODE(ed.D_DIRECCION,  NULL, UPPER(e.D_EMPRESA) , UPPER(e.D_EMPRESA) || ' ( '|| lower(ed.D_DIRECCION)  || ':'|| ed.N_DOMICILIO || ' )') as value,
														e.D_REDUCIDA,
														e.D_DESC_COM,
														e.D_ALIAS_COLEGIO
												FROM 	empresas e
														LEFT JOIN  empresas_domicilios ed ON e.N_ID_EMPRESA = ed.N_ID_EMPRESA
												WHERE  
												   	TRANSLATE(upper(e.D_EMPRESA),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE '%$buscar%'
												OR  TRANSLATE(upper(e.D_DESC_COM),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE '%$buscar%'
												OR  TRANSLATE(upper(e.D_REDUCIDA),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE '%$buscar%'
												OR  TRANSLATE(upper(e.D_DESC_COM),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE '%$buscar%'
												OR  TRANSLATE(upper(e.D_ALIAS_COLEGIO),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE '%$buscar%'
												ORDER BY e.D_EMPRESA"
											
								));


	 

		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{


				$result[]= array( 	"id_empresa" => $row->N_ID_EMPRESA ,
									"value" => $row->VALUE
								);


			}
		}

		echo json_encode($result);
	}
}

public function existe_consulta_activa()
{
	chrome_log("existe_consulta_activa".$this->input->post('id').'-'.$this->input->post('origen') );

	if ($this->form_validation->run('existe_consulta_activa') == FALSE):

		chrome_log("No paso validacion");
		$return["error"] = true;

	else:

		chrome_log("Paso validacion"); 
		$resultado = $this->Consulta_model->existe_consulta_activa($this->input->post());

		if( $resultado ):

			chrome_log("Hay consulta activa");
			$return["error"] = true; 

		else:

			chrome_log("No hay consulta activa");
			$return["error"] = false; 

		endif;

	endif;
	 

	echo json_encode($return);	 
}

public function agregar_comentario_programa()
{
	chrome_log("Consulta/agregar_comentario_programa");

	if ($this->form_validation->run('agregar_comentario_programa') == FALSE):

		chrome_log("No paso validacion");
		//echo validation_errors();
	$this->session->set_flashdata('mensaje', 'Error: no paso la validación.');

	else:

		chrome_log("Paso validacion");

		$resultado = $this->Consulta_model->agregar_comentario_programa($this->input->post());


		if( $resultado > 0):

			$this->session->set_flashdata('mensaje', 'Comentario ingresado exitosamente');

		else:

			$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');

		endif;


	endif;

	$this->load->library('user_agent');

	if( strpos($this->agent->referrer(), 'buscar_consulta' ) )
	{
		redirect('consulta/buscar_consulta/'.$this->input->post('variable_post') ,'refresh');
		//redirect($this->agent->referrer());
	}
	elseif( strpos($this->agent->referrer(), 'mis_consultas' ) )
		redirect($this->agent->referrer());
	elseif( strpos($this->agent->referrer(), 'pipeline' ) )
		redirect($this->agent->referrer());
	else
		redirect('consulta/ver_consulta/'.$this->input->post('id_crm_consulta') ,'refresh');
}

public function agregar_comentario_general()
{
	chrome_log("Consulta/agregar_comentario_general");

	if ($this->form_validation->run('agregar_comentario_general') == FALSE):

		chrome_log("No paso validacion");
 
		$this->session->set_flashdata('mensaje', 'Error: no paso la validación.');

	else:

		chrome_log("Paso validacion");

		$resultado = $this->Consulta_model->agregar_comentario_programa($this->input->post());


		if( $resultado > 0):

			$this->session->set_flashdata('mensaje', 'Comentario ingresado exitosamente');

		else:

			$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');

		endif;


	endif;

	redirect('consulta/ver_consulta/'.$this->input->post('id_crm_consulta') ,'refresh');
}


public function agregar_mis_programas_consulta()
{

	chrome_log("agregar_mis_programas_consulta");

	$query = $this->Configuracion_model->traer_programas_universidad( $this->session->userdata('id_persona') );

	if($query->num_rows() > 0)
	{
		chrome_log("entro: ".$query->num_rows());

		$prg = "";
		foreach ($query->result() as $row)
		{

			$codigo = $row->ID;
			$id = rand();

			$prg .=  "	<div class='form-group eliminar_programa' id='".$id."' >
	                        <div class='input-group date' style='z-index:0'>
	                          <div class='input-group-addon'>
	                            <i class='fa fa-trash' aria-hidden='true'></i>
	                          </div>
	                              <input readonly='readonly' class='form-control' type='text' name='programa[]' id='programa' value='".$row->PROGRAMA."'>
	                              <input readonly='readonly' class='form-control' type='hidden' name='id_codigo[]' id='id_codigo' value='".$codigo."'>
	                        </div>
	                    </div>"  ;


		}

		$result["mensaje"] = $prg;
		$result["error"] = FALSE;

	}
	else
	{
		$prg =  'Aun ha cargado sus programas' ;
		$result["mensaje"] = $prg;
		$result["error"] = TRUE;
	}

	echo json_encode($result);
}

public function buscar_programas_consulta()
{
	chrome_log('buscar_programas_consulta');

 	$datos = null;

	if ($this->form_validation->run('buscar_programas_consulta') == FALSE):

		chrome_log("No paso validacion");

	else:

		chrome_log("Paso validacion");

		$resultado = $this->Consulta_model->traer_programas_consulta($this->input->post('id_consulta'));
		$i = 0;
		foreach ($resultado->result() as $row):

				/*$datos[$i]['c_identificacion'] = $row->C_IDENTIFICACION;
				$datos[$i]['c_programa'] = $row->C_PROGRAMA;
				$datos[$i]['c_orientacion'] = $row->C_ORIENTACION;*/
				$datos[$i]['id_crm_consulta_programa'] = $row->ID_CRM_CONSULTA_PROGRAMA;
				$datos[$i]['programa'] = $row->D_DESCRED;
				$i++;

		endforeach;

	 	echo json_encode($datos);

	endif;
}

public function buscar_info_consulta_programa()
{
	chrome_log('buscar_info_consulta_programa');

 	$datos = null;

	if ($this->form_validation->run('buscar_info_consulta_programa') == FALSE):

		chrome_log("No paso validacion");

	else:

		chrome_log("Paso validacion: ".$this->input->post('id_consulta_programa'));


		$resultado = $this->Consulta_model->traer_info_consulta_programa($this->input->post('id_consulta_programa'));

 		$datos['id_crm_consulta_programa'] = $resultado->ID_CRM_CONSULTA_PROGRAMA;
		$datos['programa'] = $resultado->D_DESCRED;
		$datos['id_estado_cons_prg'] = $resultado->ID_ESTADO;

	 	print json_encode($datos);

	endif;
}


public function procesa_asignar_consulta()
{
	chrome_log("Consulta/procesa_asignar_consulta");

	if ($this->form_validation->run('asignar_consulta') == FALSE):

		chrome_log("No paso validacion");
		$this->session->set_flashdata('mensaje', 'No paso validacion');

	else: 
		chrome_log("Paso validacion");


		$resultado = $this->Consulta_model->asignar_consulta($this->input->post());

		if( $resultado ):

			$this->session->set_flashdata('mensaje', 'Consultas asignadas exitosamente');

		else:

			$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');

		endif;

	endif;

	redirect('/consulta/asignar_consultas','refresh');

}


public function procesar_cambiar_consulta_pipeline()
{
	chrome_log("Consulta/procesar_cambiar_consulta_pipeline");

	//var_dump($this->input->post());

	if ($this->form_validation->run('cambiar_consulta_pipeline') == FALSE):

		chrome_log("No paso validacion");
		$this->session->set_flashdata('mensaje', 'No paso validacion');
		//echo validation_errors();

	else:

		//if($this->input->post('submit_email') == NULL): //  Cambia de estado

		//	chrome_log("Cambiar estado");


			if($this->input->post('id_estado') == -1 ): // Enviar a StandBy

					chrome_log("STANDBY");

					foreach ($this->input->post('id_consulta_prg') as $key => $value)
					{

						$resultado = $this->Consulta_model->enviar_stand_by_consulta_prg($value,$this->input->post('fecha_standby'));

						if( $resultado > 0):

							$this->session->set_flashdata('mensaje', 'Consultas modificadas correctamente');

						else:

							$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');

						endif;

					}

					$this->load->library('user_agent');
					redirect($this->agent->referrer());

			else: // Enviar a otro estado

					foreach ($this->input->post('id_consulta_prg') as $key => $value)
					{

						$array['id_crm_consulta_prg'] = $value;
						$array['id_estado_cons_prg']= $this->input->post('id_estado');

						if($this->input->post('id_motivo'))
							$array['id_motivo']= $this->input->post('id_motivo');
						else
							$array['id_motivo']= NULL;

						$resultado = $this->Consulta_model->modificar_estado_consulta_prg($array);

						if( $resultado > 0):

							$this->session->set_flashdata('mensaje', 'Consultas modificadas correctamente');

						else:

							$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');

						endif;

					}

					redirect('consulta/pipeline/'.$this->input->post('id_estado') ,'refresh');

			endif;

		/*
		else: // Envia email masivo

			chrome_log("Enviar email masivo");

			/*
			if ($this->form_validation->run('ver_enviar_email_masivo') == FALSE):

				chrome_log("No paso validacion");
				$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');
				redirect('home');

			else:

				chrome_log("Paso validacion");

			 	$array_personas = array();

				foreach ($this->input->post('id_consulta_prg') as $key => $value):

					$informacion['id_consulta_prg'] = $id_consulta_prg = $value;
					$informacion['id_consulta'] = $this->Consulta_model->traer_id_consulta_by_consulta_prg($id_consulta_prg);

					$id_persona = $this->Consulta_model->buscar_id_persona_consulta( $informacion['id_consulta'] );

					$informacion['informacion_persona'] = $this->Contacto_model->traer_informacion_crm_sigeu_persona($id_persona);
				   	array_push($array_personas, $informacion);

				endforeach;


				$datos['personas_consulta'] = $array_personas;
				$datos['emails_plantillas'] = $this->Configuracion_model->traer_emails_plantillas();
				$this->load->library('user_agent');
				$datos['url_referer'] = $this->agent->referrer();

				$this->load->view('estructura/head');
				$this->load->view('consulta/ver_enviar_email_masivo',$datos);
				$this->load->view('estructura/footer');


			endif;

		endif; */

	endif;
}

public function sacar_consulta_standby()
{
	chrome_log("Consulta/sacar_consulta_standby");

	if ($this->form_validation->run('sacar_consulta_standby') == FALSE):

		chrome_log("No paso validacion");
		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');

	else:

		chrome_log("Paso validacion");

		//var_dump($this->input->post('id_consulta_prg') );

		foreach ( $this->input->post('id_consulta_prg') as $key => $value)
		{

			$resultado = $this->Consulta_model->sacar_consulta_standby($value);

			if( $resultado > 0):

				$this->session->set_flashdata('mensaje', 'Consultas modificadas correctamente');

			else:

				$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');

			endif;

		}

	endif;

	$this->load->library('user_agent');
	redirect($this->agent->referrer());
}


public function comprobar_consulta_existente_validation($id_consulta=null)
{
	if($this->Consulta_model->existe_consulta($id_consulta))
		return false;
	else
		return true;
}

public function ver_texto_email($id_crm_email_plantilla=NULL)
{
	chrome_log("ver_texto_email ".$id_crm_email_plantilla);

	if($id_crm_email_plantilla != -1 ):

		$datos['info_email'] = $this->Configuracion_model->traer_informacion_email_plantilla($id_crm_email_plantilla);
		$datos['id_crm_email_plantilla_elegida'] = $id_crm_email_plantilla;
		$this->load->view('consulta/ver_email_plantilla',$datos);

	else:

		$this->load->view('consulta/ver_email_vacio');

	endif;
}

/*
public function buscar_programas_consulta()
{
	chrome_log($this->input->post('id_consulta'));


	$resultado = $this->Consulta_model->traer_programas_consulta($this->input->post('id_consulta'));
	$i = 0;
	foreach ($resultado->result() as $row):

			$datos[$i]['c_identificacion'] = $row->C_IDENTIFICACION;
			$datos[$i]['c_programa'] = $row->C_PROGRAMA;
			$datos[$i]['c_orientacion'] = $row->C_ORIENTACION;
			$datos[$i]['programa'] = $row->D_DESCRED;
			$i++;

	endforeach;


 	$a = json_encode($datos);

 	echo json_encode($datos);

}*/

public function traer_motivos_estado()
{
	//chrome_log("traer_motivos_estado");

	$motivos = $this->Consulta_model->traer_motivos_estado($this->input->post('id_estado'));

    $aux["mensaje"] =  "<div><select class='form-control' name='id_motivo' id='id_motivo'>";

	foreach ( $motivos->result() as $row ):

				$motivo = utf8_encode($row->MOTIVO);
				$id_motivo = utf8_encode($row->ID_MOTIVO);
				$aux["mensaje"] .= "<option value='$id_motivo' >$motivo</option>";

	endforeach;

	$aux["mensaje"] .= "</select></div> ";

	$return["error"] = FALSE;
    $return["data"] = $aux;

    print json_encode($return);
}

public function alta_alarma()
{
	chrome_log("Consulta/alta_alarma");

	if ($this->form_validation->run('alta_alarma') == FALSE):

		chrome_log("No paso validacion");
		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');
		echo validation_errors();

	else:

		chrome_log("Paso validacion");
 
		$resultado = $this->Consulta_model->abm_alarma('A', $this->input->post());

		if( $resultado > 0):

			$this->session->set_flashdata('mensaje', 'Alarma cargada exitosamente');

		else:

			$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');

		endif; 


	endif;

	redirect('consulta/ver_consulta/'.$this->input->post('id_crm_consulta') ,'refresh');
}

public function baja_alarma()
{
	chrome_log("Consulta/baja_alarma");

	if ($this->form_validation->run('baja_alarma') == FALSE):

		chrome_log("No paso validacion");
		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');
		$data['error'] = true;

	else:

		chrome_log("Paso validacion");
 
		$resultado = $this->Consulta_model->abm_alarma('B', $this->input->post());

		if( $resultado > 0):

			$this->session->set_flashdata('mensaje', 'Alarma eliminada exitosamente');
			$data['error'] = false;

		else:

			$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');
			$data['error'] = false;

		endif; 

	endif;

	print json_encode($data); 
}

public function mis_alarmas()
{
	chrome_log("Consulta/mis_alarmas");
 	
 	$datos['tipos_alarmas'] = $this->Alarma_model->get_tipos_de_alarmas();
	$datos['mis_alarmas'] = $this->Alarma_model->get_mis_alarmas();

	$this->load->view('estructura/head');
	$this->load->view('consulta/mis_alarmas',$datos);
	$this->load->view('estructura/footer');
 
}


public function buscar_alarmas()
{
	chrome_log("Consulta/buscar_alarmas");
 	
 	$datos['mis_alarmas'] = $this->Alarma_model->buscar_alarmas($this->input->post(), $filtros );
 	$datos['tipos_alarmas'] = $this->Alarma_model->get_tipos_de_alarmas();
 	$datos['filtros'] = $filtros;
 
	$this->load->view('estructura/head');
	$this->load->view('consulta/mis_alarmas',$datos);
	$this->load->view('estructura/footer');
 
}

}

?>