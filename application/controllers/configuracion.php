<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Configuracion extends CI_Controller {


public function __construct()
{
	parent::__construct();
	$this->load->model('Configuracion_model');
	$this->load->model('Evento_model');
	$this->db = $this->load->database($this->session->userdata('DB'),TRUE, TRUE);

	//$this->output->enable_profiler(TRUE);
}

public function programas()
{
	$datos['programas_usuario'] = $this->Configuracion_model->traer_programas_universidad($this->session->userdata('id_persona'));
	$datos['mensaje'] = $this->session->flashdata('mensaje');

	$this->load->view('estructura/head');
	$this->load->view('configuracion/programas',$datos);
	$this->load->view('estructura/footer');
}

public function emails()
{
	$datos['emails_plantillas'] = $this->Configuracion_model->traer_emails_plantillas();
	$datos['mensaje'] = $this->session->flashdata('mensaje');

	$this->load->view('estructura/head');
	$this->load->view('configuracion/emails',$datos);
	$this->load->view('estructura/footer');
}

public function eventos()
{
	$datos['tipos_eventos'] = $this->Evento_model->traer_tipos_evento();
	$datos['mensaje'] = $this->session->flashdata('mensaje');

	$this->load->view('estructura/head');
	$this->load->view('configuracion/tipos_eventos',$datos);
	$this->load->view('estructura/footer');
}
// ABM programas

public function agregar_programa()
{
	$_POST['id_persona'] = $this->session->userdata('id_persona');
	$this->form_validation->set_data($_POST);

	if ($this->form_validation->run('agregar_programa') == FALSE):

		chrome_log("No paso validacion");
		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');

	else:
		chrome_log("Paso validacion");


		$result = $this->Configuracion_model->agregar_programa( $this->input->post() );

		if($result != FALSE)
		{
			chrome_log("No hubo problemas");

		    if( $result == 1 ):
				$this->session->set_flashdata('mensaje', 'Programa agregado exitosamente');
				chrome_log("Programa agregado");
			else:
				$this->session->set_flashdata('mensaje', 'Error: ya tiene ese programa');
				chrome_log("Programa repetido");
			endif;
		}
		else
		{
			chrome_log("No Inserto");
			$this->session->set_flashdata('mensaje', 'No se pudo agregar el programa, intentelo nuevamente mas tarde');
		}

	endif;

	redirect('configuracion/programas','refresh');
}

public function eliminar_programa_usuario()
{
	$_POST['id_persona'] = $this->session->userdata('id_persona');
	$this->form_validation->set_data($_POST);

	if ($this->form_validation->run('eliminar_programa') == FALSE):

		chrome_log("No paso validacion");
		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');

	else:
		chrome_log("Paso validacion");

		$result = $this->Configuracion_model->eliminar_programa( $this->input->post() );

		if($result != FALSE)
		{
			chrome_log("No hubo problemas");

		    if( $result == 1 ):
				$this->session->set_flashdata('mensaje', 'Programa eliminado exitosamente');
				chrome_log("Programa eliminado");
				$return["error"] = FALSE;
			else:
				$this->session->set_flashdata('mensaje', 'Error: el usuario no tiene ese programa');
				chrome_log("Programa que no tiene el usuario");
				$return["error"] = TRUE;
			endif;
		}
		else
		{
			chrome_log("No Inserto");
			$this->session->set_flashdata('mensaje', 'No se pudo eliminar el programa, intentelo nuevamente mas tarde');
			$return["error"] = TRUE;
		}

	endif;

	print json_encode($return);
	//redirect('configuracion/index','refresh');
}

public function ajax_programa()
{
	$buscar = $this->input->get('term');
	chrome_log("aaaaaaaaaaaaaaaa");

	if( isset($buscar) && strlen($buscar) > 2)
	{
		$buscar = strtoupper($buscar);
		$buscar = str_replace(" ", "%", $buscar);
		$buscar = str_replace("ñ", "Ñ", $buscar);

 		$query=$this->db->query(("	SELECT p.C_IDENTIFICACION,  p.C_PROGRAMA ,   p.C_ORIENTACION,  p.D_DESCRED,  p.D_DESCRED || ' | ' ||  p.D_DESCRIP AS value
												FROM programas p
												WHERE   (  TRANSLATE(upper(p.D_DESCRED),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE '%$buscar%' OR
												           TRANSLATE(upper(p.D_DESCRIP),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE '%$buscar%'
												        )" ));



		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$result[]= array(   "C_IDENTIFICACION" => $row->C_IDENTIFICACION ,
									"C_PROGRAMA" => $row->C_PROGRAMA ,
									"C_ORIENTACION" => $row->C_ORIENTACION ,
									"D_DESCRED" => $row->D_DESCRED ,
									"value" => $row->VALUE
								);
			}
		}

		echo json_encode($result);
	}
}

// ABM emails
public function alta_email_plantilla()
{
	if ($this->form_validation->run('alta_email_plantilla') == FALSE):

		chrome_log("No paso validacion");
		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');
		echo validation_errors();

	else:
		chrome_log("Paso validacion");

		$result = $this->Configuracion_model->abm_email_plantilla( 'A', $this->input->post() );

		if($result != FALSE)
		{
			chrome_log("No hubo problemas");

		    if( $result == 1 ):
				$this->session->set_flashdata('mensaje', 'Email agregado exitosamente');
				chrome_log("Programa agregado");
			else:
				$this->session->set_flashdata('mensaje', 'Error: ya no se pudo agregar el email');
				chrome_log("Programa repetido");
			endif;
		}
		else
		{
			chrome_log("No Inserto");
			$this->session->set_flashdata('mensaje', 'No se pudo agregar el email, intentelo nuevamente mas tarde');
		}

	endif;

	redirect('configuracion/emails','refresh');
}

public function baja_email_plantilla()
{
	if ($this->form_validation->run('baja_email_plantilla') == FALSE):

		chrome_log("No paso validacion");
		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');
		$return["error"] = TRUE;

	else:
		chrome_log("Paso validacion");

		$result = $this->Configuracion_model->abm_email_plantilla( 'B', $this->input->post() );

		if($result != FALSE)
		{
			chrome_log("No hubo problemas");

		    if( $result == 1 ):
				$this->session->set_flashdata('mensaje', 'Email eliminado exitosamente');
				$return["error"] = FALSE;
			else:
				$this->session->set_flashdata('mensaje', 'Error: ya no se pudo eliminar el email');
				$return["error"] = TRUE;
			endif;
		}
		else
		{
			$return["error"] = TRUE;
			$this->session->set_flashdata('mensaje', 'No se pudo eliminar el email, intentelo nuevamente mas tarde');
		}

	endif;

	print json_encode($return);
}

public function modifica_email_plantilla()
{
	if ($this->form_validation->run('modifica_email_plantilla') == FALSE):

		chrome_log("No paso validacion");
		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');
		echo validation_errors();

	else:
		chrome_log("Paso validacion");

		$result = $this->Configuracion_model->abm_email_plantilla( 'M', $this->input->post() );

		if($result != FALSE)
		{
			chrome_log("No hubo problemas");

		    if( $result == 1 ):
				$this->session->set_flashdata('mensaje', 'Email editado exitosamente');
				chrome_log("Programa agregado");
			else:
				$this->session->set_flashdata('mensaje', 'Error: no se pudo editar el email');
				chrome_log("Programa repetido");
			endif;
		}
		else
		{
			chrome_log("No edito");
			$this->session->set_flashdata('mensaje', 'No se pudo editar el email, intentelo nuevamente mas tarde');
		}

	endif;

	redirect('configuracion/emails','refresh');
}

// ABM tipos eventos
public function alta_tipo_evento()
{
	if ($this->form_validation->run('alta_tipo_evento') == FALSE):

		chrome_log("No paso validacion");
		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');
		echo validation_errors();

	else:
		chrome_log("Paso validacion");

		$result = $this->Configuracion_model->abm_tipo_evento( 'A', $this->input->post() );

		if($result != FALSE)
		{
		    if( $result == 1 ):
				$this->session->set_flashdata('mensaje', 'Tipo de evento agregado exitosamente');

			else:
				$this->session->set_flashdata('mensaje', 'Error: ya no se pudo agregar el tipo de evento');

			endif;
		}
		else
		{
			chrome_log("No Inserto");
			$this->session->set_flashdata('mensaje', 'No se pudo agregar el tipo de evento, intentelo nuevamente mas tarde');
		}

	endif;

	redirect('configuracion/eventos','refresh');
}

public function baja_tipo_evento()
{
	if ($this->form_validation->run('baja_tipo_evento') == FALSE):

		chrome_log("No paso validacion");
		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');
		$return["error"] = TRUE;

	else:
		chrome_log("Paso validacion");

		$result = $this->Configuracion_model->abm_tipo_evento( 'B', $this->input->post() );

		if($result != FALSE)
		{
			chrome_log("No hubo problemas");

		    if( $result == 1 ):
				$this->session->set_flashdata('mensaje', 'Tipo de email eliminado exitosamente');
				$return["error"] = FALSE;
			else:
				$this->session->set_flashdata('mensaje', 'Error: ya no se pudo eliminar el tipo de email');
				$return["error"] = TRUE;
			endif;
		}
		else
		{
			$return["error"] = TRUE;
			$this->session->set_flashdata('mensaje', 'No se pudo eliminar el tipo de email, intentelo nuevamente mas tarde');
		}

	endif;

	print json_encode($return);
}

public function modifica_tipo_evento()
{
	if ($this->form_validation->run('modifica_email_plantilla') == FALSE):

		chrome_log("No paso validacion");
		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');
		echo validation_errors();

	else:
		chrome_log("Paso validacion");

		$result = $this->Configuracion_model->abm_tipo_evento( 'M', $this->input->post() );

		if($result != FALSE)
		{
			chrome_log("No hubo problemas");

		    if( $result == 1 ):
				$this->session->set_flashdata('mensaje', 'Tipo de evento editado exitosamente');
				chrome_log("Programa agregado");
			else:
				$this->session->set_flashdata('mensaje', 'Error: no se pudo editar el Tipo de evento');
				chrome_log("Programa repetido");
			endif;
		}
		else
		{
			chrome_log("No edito");
			$this->session->set_flashdata('mensaje', 'No se pudo editar el tipo de evento, intentelo nuevamente mas tarde');
		}

	endif;

	redirect('configuracion/eventos','refresh');
}


}

/* End of file login.php */
/* Location: ./application/controllers/login.php */