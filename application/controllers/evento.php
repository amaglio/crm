<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Evento extends CI_Controller {


public function __construct()
{
	parent::__construct();
	$this->load->model('Evento_model');
	$this->db = $this->load->database($this->session->userdata('DB'),TRUE, TRUE);

}

public function index()
{
	$datos['mensaje'] = $this->session->flashdata('mensaje');
	$datos['tipos_eventos'] = $this->Evento_model->get_tipos_eventos();
	$eventos = $this->Evento_model->get_eventos();

	$eventos_array = array();

	if( count($eventos)  > 0):

		foreach ($eventos as $row):

			$informacion['informacion_evento'] = $row;
		  	$informacion['fechas_evento'] = $this->Evento_model->get_evento_fechas($row['ID_EVENTO']);
		  	array_push($eventos_array, $informacion);

		endforeach;

	endif;

	$datos['eventos'] = $eventos_array;

	$this->load->view('estructura/head');
	$this->load->view('evento/index',$datos);
	$this->load->view('estructura/footer');
}

public function ver_evento($id_crm_evento)
{
	$data['mensaje'] = $this->session->flashdata('mensaje');

	$data['tipos_eventos'] = $this->Evento_model->get_tipos_eventos();

	$data['evento'] = $this->Evento_model->get_datos_evento($id_crm_evento);

	$data['fecha_evento'] = $this->Evento_model->get_evento_fechas($id_crm_evento);

	$data['asistentes_a_importar'] = $this->Evento_model->get_asistentes_a_importar($id_crm_evento);

	$asistentes_evento = $this->Evento_model->get_evento_asistentes($id_crm_evento);

	$array_asistentes = array();

	foreach ($asistentes_evento as $row_asistente)
	{
		if( $row_asistente['ID_CRM_PERSONA'] == NULL ):

			$info['nombre'] = $row_asistente['NOMBRE'];
			$info['apellido'] = $row_asistente['APELLIDO'];
			$info['email'] = $row_asistente['EMAIL'];
			$info['telefono'] = $row_asistente['TELEFONO'];
			$info['empresa'] = $row_asistente['EMPRESA'];
			$info['cargo'] = $row_asistente['CARGO'];

		else:

			$datos = $this->Contacto_model->traer_informacion_crm_sigeu_persona( $row_asistente['ID_CRM_PERSONA'] );

			$info['nombre'] = $datos['datos_usuario']->NOMBRE;
			$info['apellido'] = $datos['datos_usuario']->APELLIDO;

			// Emails

			$emails = $datos['datos_emails'];

			$cadena_email = '';

			foreach ($emails as $row_email)
				 $cadena_email .= $row_email['EMAIL']."<br>";

			$info['email'] = $cadena_email;

			// Telefonos

			$telefonos = $datos['datos_telefonos'];

			$cadena_telefono = '';

			foreach ($telefonos as $row_telefono)
				 $cadena_telefono .= $row_telefono['TELEFONO']."<br>";

			$info['telefono'] = $cadena_telefono;

			// Empresa y Cargo

			$experiencia_laboral = $datos['datos_experiencia_laboral'];

			$cadena_empresa = '';
			$cadena_cargo = '';

			foreach ($experiencia_laboral as $row_experiencia)
			{
				$cadena_empresa .= $row_experiencia['NOMBRE']."<br>";
				$cadena_cargo .= $row_experiencia['CARGO']."<br>";
			}

			$info['empresa'] = $cadena_empresa;
			$info['cargo'] = $cadena_cargo;

		endif;


		$info['id_asistente_evento'] = $row_asistente['ID_ASISTENTE_EVENTO'];
		$info['id_crm_persona'] = $row_asistente['ID_CRM_PERSONA'];

		array_push($array_asistentes, $info);
	}

	$data['evento_asistentes'] = $array_asistentes;

 	//$datos['fechas_inscriptos_evento'] = $this->Evento_model->traer_fechas_inscriptos_evento($id_crm_evento);

 	//$datos['inscriptos_evento'] = $this->Evento_model->traer_inscriptos_evento($id_crm_evento);


	$this->load->view('estructura/head');
	$this->load->view('evento/ver_evento',$data);
	$this->load->view('estructura/footer');
}

public function alta_evento()
{
	chrome_log("alta_evento");

	if ($this->form_validation->run('alta_evento') == FALSE):

		chrome_log("No paso validacion");
		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');
		redirect('home','refresh');

	else:

		chrome_log("Paso validacion");

		$result = $this->Evento_model->abm_evento( 'A', $this->input->post() );


		if($result != FALSE)
		{
			$this->session->set_flashdata('mensaje', 'Evento creado exitosamente');
			chrome_log("Programa agregado");

		}
		else
		{
			chrome_log("No Inserto");
			$this->session->set_flashdata('mensaje', 'No se pudo agregar el evento, intentelo nuevamente mas tarde');
		}

	endif;

	redirect('evento/index','refresh');
}

public function baja_evento()
{
 	chrome_log("baja_evento");

		if ($this->form_validation->run('baja_evento') == FALSE):

		chrome_log("No paso validacion");
		$return["error"] = FALSE;

	else:

		chrome_log("Paso validacion");

		if( $this->Evento_model->abm_evento( 'B', $this->input->post()) ):

			$return["error"] = FALSE;
		else:

			$return["error"] = TRUE;

		endif;


	endif;

	print json_encode($return);
}

public function modifica_evento()
{
 	chrome_log("modifica_evento");

	if ($this->form_validation->run('modifica_evento') == FALSE):

		chrome_log("No paso validacion");
		$this->session->set_flashdata('mensaje', 'No paso validacion, intentelo nuevamente mas tarde');

	else:

		chrome_log("Paso validacion");

		if( $this->Evento_model->abm_evento( 'M', $this->input->post()) ):

			$this->session->set_flashdata('mensaje', 'Evento modificado exitosamente');
		    chrome_log("FALSE");

		else:

			$this->session->set_flashdata('mensaje', 'No se pudo modificar el evento, intentelo nuevamente mas tarde');
			chrome_log("TRUE");

		endif;


	endif;

	redirect('evento/ver_evento/'.$this->input->post('id_crm_evento'),'refresh');
}

public function alta_asistente()
{
	chrome_log("alta_asistente");

	if ($this->form_validation->run('alta_asistente') == FALSE):

		chrome_log("No paso validacion");
		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');
		redirect('home','refresh');

	else:

		chrome_log("Paso validacion");

		$result = $this->Evento_model->alta_asistente_crm( $this->input->post('id_crm_persona'), $this->input->post('id_evento') );


		if($result != FALSE)
		{
			$this->session->set_flashdata('mensaje', 'Inscripción realizada correctamente');
			chrome_log("Programa agregado");

		}
		else
		{
			chrome_log("No Inserto");
			$this->session->set_flashdata('mensaje', 'No se pudo realizar la inscripcion, intentelo nuevamente mas tarde');
		}

	endif;

	redirect('evento/ver_evento/'.$this->input->post('id_evento'),'refresh');
}

public function baja_asistente()
{
	if ($this->form_validation->run('baja_asistente') == FALSE):

		chrome_log("No paso validacion baja_asistente");
		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');
		$return["error"] = TRUE;

	else:

		chrome_log("Paso validacion baja_asistente");

		$result = $this->Evento_model->baja_asistente( $this->input->post() );

		if($result != FALSE)
		{
			chrome_log("Elimino el asistente");
			$this->session->set_flashdata('mensaje', 'Asistente eliminado exitosamente');
			chrome_log("Programa agregado");
			$return["error"] = FALSE;

		}
		else
		{
			chrome_log("No agrego la tematica");
			$this->session->set_flashdata('mensaje', 'No se pudo eliminar el asistente, intentelo nuevamente mas tarde');
			$return["error"] = TRUE;
		}

	endif;

	print json_encode($return);
}

public function modificar_asistencia_evento()
{
	chrome_log("modificar_asistencia_evento");

	if ($this->form_validation->run('modificar_asistencia_evento') == FALSE):

		chrome_log("No paso validacion");
		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');

	else:

		chrome_log("Paso validacion");


		$result = $this->Evento_model->modificar_asistencia_evento( $this->input->post() );

		if($result != FALSE)
		{
			$this->session->set_flashdata('mensaje', 'Asistencias de la fecha modificadas exitosamente');
			chrome_log("Programa agregado");

		}
		else
		{
			chrome_log("No Inserto");
			$this->session->set_flashdata('mensaje', 'No se pudo realizar la modificación, intentelo nuevamente mas tarde');
		}

	endif;

	redirect('evento/ver_evento/'.$this->input->post('id_crm_evento'),'refresh');
}


public function ver_fechas_inscriptos_evento($id_crm_evento, $fecha)
{
	$datos['id_crm_evento'] = $id_crm_evento ;
	$datos['fecha'] = $fecha ;
	$datos['inscriptos_fecha'] = $this->Evento_model->traer_inscriptos_fecha_evento($id_crm_evento,$fecha);

	$this->load->view('evento/ver_fechas_inscriptos_evento',$datos);
}



}

/* End of file login.php */
/* Location: ./application/controllers/login.php */