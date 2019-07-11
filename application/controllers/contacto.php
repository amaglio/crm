<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contacto extends CI_Controller {


public function __construct()
{
	parent::__construct();
	$this->load->model('Contacto_model');
	$this->load->model('Evento_model');
	$this->load->model('Consulta_model');
	$this->db = $this->load->database($this->session->userdata('DB'),TRUE, TRUE);
	//$this->output->enable_profiler(TRUE);
}

public function index()
{
	chrome_log("Contacto/index");

	$datos['contactos'] = $this->Contacto_model->traer_ultimos_contactos_consultaron();
	$datos['mensaje'] = $this->session->flashdata('mensaje');

	$this->load->view('estructura/head');
	$this->load->view('contacto/contactos',$datos);
	$this->load->view('estructura/footer');
}

public function ver_contacto($id_crm_persona)
{
	$datos['mensaje'] = $this->session->flashdata('mensaje');
 	$_POST['id_crm_persona'] = $id_crm_persona;
	$this->form_validation->set_data($_POST);
	$this->form_validation->set_message('comprobar_persona_crm_existente_validation', 'La persona no existe o ha sido dada de baja');

	if ($this->form_validation->run('ver_contacto') == FALSE):  // libxml_set_streams_context(streams_context)

		chrome_log("No Paso validacion");

		$this->session->set_flashdata('mensaje', 'No paso la validacion.');
		redirect('home','refresh');

	else:

		chrome_log("Si Paso validacion");

		$datos['info_persona'] = $this->Contacto_model->traer_informacion_crm_sigeu_persona($id_crm_persona);
		$datos['consultas_persona'] = $this->Contacto_model->traer_informacion_consultas_persona($id_crm_persona);
		$datos['niveles_educacion'] = $this->Contacto_model->traer_niveles_educacion();
		$datos['tipos_email'] = $this->Contacto_model->traer_tipos_email();
		$datos['consultas_persona'] = $this->Contacto_model->traer_consultas_crm_persona($id_crm_persona);
		$log_persona = $this->Contacto_model->traer_log_persona($id_crm_persona);


		if($log_persona->num_rows() > 0):

			$array_log = array();

			foreach ($log_persona->result() as $row):

				$info_log = NULL ;

				$info_log['informacion_log'] = $row;

				switch ($row->ID_TIPO_LOG_CONSULTA)
				{

					case 14: // Evento

						$info_log['id_crm_evento'] = $row->ID_CRM_EVENTO ;

						$informacion_evento = $this->Evento_model->traer_info_evento($row->ID_CRM_EVENTO);

						$texto = "	<table class='table table-striped table-bordered'>
										<tr>
											<th>ID evento</th>
											<td>".$row->ID_CRM_EVENTO."</td>
										</tr>
										<tr>
											<th>Nombre</th>
											<td>".$informacion_evento->NOMBRE."</td>
										</tr>
										<tr>
											<th>Tipo</th>
											<td>".$informacion_evento->DESCRIPCION."</td>
										</tr>
									</table>";

						$info_log['comentario'] =  $texto ;

						break;

					case 1: // Nueva consulta

						$info_log['id_crm_consulta'] = $row->ID_CRM_CONSULTA ;
						$informacion_consulta = $this->Consulta_model->traer_informacion_consulta($row->ID_CRM_CONSULTA);
						$programas_consulta = $this->Consulta_model->traer_programas_consulta($row->ID_CRM_CONSULTA);

						$texto = "	<table class='table table-striped table-bordered'>
										<tr>
											<th>ID Consulta</th>
											<td>".$row->ID_CRM_CONSULTA."</td>
										</tr>
										<tr>
											<th>Fecha</th>
											<td>".$informacion_consulta->FECHA_CONSULTA."</td>
										</tr>";

									if($programas_consulta->num_rows() > 0):

										$texto .= "<tr>";
										$texto .= 	"<td> Programas </td>";
										$texto .= 	"<td>";

										foreach ($programas_consulta->result() as $row):

											$texto .= $row->D_DESCRED."<br>";

										endforeach;

										$texto .= 	"</td>";
										$texto .= "</tr>";

									else:


									endif;

						$texto .=	"</table>";

						$info_log['log_consulta'] = $this->Consulta_model->traer_log_consulta($row->ID_CRM_CONSULTA);
						$info_log['comentario'] =  $texto ;

						break;

					default:

						$info_log['comentario'] = NULL;
						break;
				}

				array_push($array_log, $info_log);

			endforeach;

			$datos['log_persona'] = $array_log;

		else:

			$datos['log_persona'] = NULL;

		endif;



		if( $datos['info_persona']['datos_usuario']->ID_PERSONA ) : // Esta en CRM


				$datos_id['id'] = $datos['info_persona']['datos_usuario']->ID_PERSONA;
				$datos_id['origen'] = "SIGEU";
				$valores = json_encode($datos_id);
				$valores = str_replace("\"", "&", $valores);
		else:

				$datos_id['id'] = $datos['info_persona']['datos_usuario']->ID_CRM_PERSONA;
				$datos_id['origen'] = "CRM";
				$valores = json_encode($datos_id);
				$valores = str_replace("\"", "&", $valores);

		endif;

		$datos['valores'] = $valores;


		$this->load->view('estructura/head');
		$this->load->view('contacto/ver_contacto',$datos);
		$this->load->view('estructura/footer');

	endif;
}

public function ver_modificar_contacto($id_crm_persona)
{

 	$_POST['id_crm_persona'] = $id_crm_persona;
	$this->form_validation->set_data($_POST);
	$this->form_validation->set_message('comprobar_persona_crm_existente_validation', 'La persona no existe o ha sido dada de baja');

	if ($this->form_validation->run('ver_contacto') == FALSE):  // libxml_set_streams_context(streams_context)

		chrome_log("No Paso validacion");
		$this->session->set_flashdata('mensaje', 'No paso la validacion.');
		redirect('home','refresh');

	else:

		chrome_log("Si Paso validacion");

		$datos['info_persona'] = $this->Contacto_model->traer_informacion_crm_sigeu_persona($id_crm_persona);
		$datos['niveles_educacion'] = $this->Contacto_model->traer_niveles_educacion();
		$datos['tipos_email'] = $this->Contacto_model->traer_tipos_email();
		$datos['tipos_telefono'] = $this->Contacto_model->traer_tipos_telefono();
		$datos['tipos_documentos'] = $this->Contacto_model->traer_tipos_documento();
		$datos['mensaje'] = $this->session->flashdata('mensaje');

		$datos_id['id'] = $id_crm_persona;
		$datos_id['origen'] = "CRM";
		$valores = json_encode($datos_id);
		$valores = str_replace("\"", "&", $valores);

		$datos['valores'] = $valores;

		$this->load->view('estructura/head');
		$this->load->view('contacto/ver_modificar_contacto',$datos);
		$this->load->view('estructura/footer');

	endif;
}


/*
En la busqueda de contactos, una persona puede estar en CRM y/o SIGEU (no fue mi culpa)
Entonces, yo busco en ambas tablas y traigo todas las coincidencias.
Luego, si es de CRM pregunto si tiene ID_SIGEU, si tiene, significa que ya lo encontre en la busqueda
entonces lo dejo pasar y no lo muestro en la busqueda, ya que apareceria por SIGEU.
*/

public function buscar_contacto()
{
	chrome_log("Contacto/buscar_contacto");

	if ($this->form_validation->run('buscar_contacto') == FALSE):

		chrome_log("No paso validacion");
		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');

	else:

		chrome_log("Paso validacion");
		$contactos_encontrados = array();
		$contactos = $this->Contacto_model->buscar_contactos($this->input->post());

		//print_r($contactos );

		foreach( $contactos->result() as $row ):

			if($row->ORIGEN == 'crm')
			{

				$datos_contacto_crm = $this->Contacto_model->traer_informacion_crm_persona($row->ID);

 				// Si no esta seteado ID_PERSONA lo agrego, sino uso el de SIGEU (por que lo encuentra 2 veces)
 				if(!isset($datos_contacto_crm->ID_PERSONA))
 				{
 					$datos['informacion_personal'] = $datos_contacto_crm;
 					array_push($contactos_encontrados, $datos);
 				}
			}
			else
			{

				$datos['informacion_personal'] = $this->Contacto_model->traer_informacion_persona($row->ID);
				array_push($contactos_encontrados, $datos);
			}

		endforeach;


		$datos['datos_contactos'] = $contactos_encontrados;
		$datos['dato_buscado'] = $this->input->post('dato_buscado');

		$this->load->view('estructura/head');
		$this->load->view('contacto/busqueda_contactos',$datos);
		$this->load->view('estructura/footer');


	endif;
}

public function procesar_contactos_encontrados()
{

	chrome_log("Contacto/procesar_contactos_encontrados");

	//echo "POST:".$this->input->post('cargar_consulta');

	//var_dump($_POST);

	//print_r($_POST);

	//---- FUSIONAR

	if( $this->input->post('fusionar') != FALSE ):

		chrome_log("fusionar");

		$array = str_replace("&", "\"", $this->input->post('id_contacto'));

		if( count($array) == 2 ):

			$error = 0;
			$i = 0;
			$contactos = array();

			foreach ($array as $key => $value):

				$datos = json_decode($value);
				$id_crm_persona = $datos->id;
				$origen = $datos->origen;

				$datos_contacto['informacion_personal'] = $this->Contacto_model->traer_informacion_crm_persona($id_crm_persona);
				$datos_contacto['emails'] = $this->Contacto_model->traer_emails_crm($id_crm_persona);
				$datos_contacto['telefonos'] = $this->Contacto_model->traer_telefonos_crm($id_crm_persona);
				$datos_contacto['documentos'] = $this->Contacto_model->traer_documentos_crm($id_crm_persona);

				array_push($contactos, $datos_contacto);

				if($origen == 'sigeu'): // Error envio uno de SIGEU

					$this->session->set_flashdata('mensaje', 'Los contactos a fusionar deben ser ambos de CRM.');
					redirect('contacto','refresh');

				endif;

			endforeach;

			// Llamar a funcion o a vista para fusionar

			$datos_enviar['contactos'] = $contactos;

			$this->load->view('estructura/head');
			$this->load->view('contacto/pre_fusionar_contactos',$datos_enviar);
			$this->load->view('estructura/footer');

		else:

			$this->session->set_flashdata('mensaje', 'Error: la cantidad de contactos a fusionar es erronea.');

		endif;


	//---- VINCULAR

	elseif(  $this->input->post('vincular')  != FALSE): // VINCULAR

		chrome_log("vincular");

		$array = str_replace("&", "\"", $this->input->post('id_contacto'));

		if( count($array) == 2 ):

			$crm = 0;
			$sigeu = 0;
			$contactos = array();

			foreach ($array as $key => $value):

				$datos = json_decode($value);
				$id_crm_persona = $datos->id;
				$origen = $datos->origen;

				if($origen == 'CRM'): // Si viene desde CRM

					$datos_contacto['informacion_personal'] = $this->Contacto_model->traer_informacion_crm_persona($id_crm_persona);
					$datos_contacto['emails'] = $this->Contacto_model->traer_emails_crm($id_crm_persona);
					$datos_contacto['telefonos'] = $this->Contacto_model->traer_telefonos_crm($id_crm_persona);
					$datos_contacto['documentos'] = $this->Contacto_model->traer_documentos_crm($id_crm_persona);
					$crm++;

				endif;

				if($origen == 'SIGEU'):  // Si viene desde SIGEU ($id_crm_persona en realidad es el N_ID_PERSONA de sigeu )

					$datos_contacto['informacion_personal'] = $this->Contacto_model->traer_informacion_persona($id_crm_persona);
					$datos_contacto['emails'] = $this->Contacto_model->traer_emails_sigeu($id_crm_persona);
					$datos_contacto['telefonos'] = $this->Contacto_model->traer_telefonos_sigeu($id_crm_persona);
					$datos_contacto['documentos'] = $this->Contacto_model->traer_documentos_sigeu($id_crm_persona);

					$sigeu++;

				endif;

				array_push($contactos, $datos_contacto);

			endforeach;

			if( $crm == 1 && $sigeu == 1 ):

				$datos_enviar['contactos'] = $contactos;

				$this->load->view('estructura/head');
				$this->load->view('contacto/pre_vincular_contactos',$datos_enviar);
				$this->load->view('estructura/footer');

			else:

				$this->session->set_flashdata('mensaje', 'Error: un contacto tiene que ser de CRM y otro de SIGEU. ');

			endif;

		else:

			$this->session->set_flashdata('mensaje', 'Error: la cantidad de contactos a vincular es erronea.');

		endif;


	//---- ELIMINAR

	elseif(  $this->input->post('eliminar')  != FALSE ): // ELIMINAR

	 	chrome_log("eliminar");

	 	// Recorro, si hay alguno de SIGEU no elimino nada

		$array = str_replace("&", "\"", $this->input->post('id_contacto'));

 		foreach ($array as $key => $value):

			$datos = json_decode($value);
			$id_crm_persona = $datos->id;
			$origen = $datos->origen;

			if($origen == 'sigeu'): // Error envio uno de SIGEU

					$this->session->set_flashdata('mensaje', 'Los contactos a eliminar deben ser todos de CRM.');
					redirect('contacto','refresh');

			endif;

		endforeach;

		// Recorro, si hay alguno de SIGEU no elimino nada
 		foreach ($array as $key => $value):

			$datos = json_decode($value);
			$id_crm_persona = $datos->id;

			$resultado = $this->Contacto_model->eliminar_contacto_crm($id_crm_persona);


		endforeach;


		if( $resultado > 0):

			$this->session->set_flashdata('mensaje', 'Contactos eliminados exitosamente.');

		else:

			$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');

		endif;

		redirect('contacto/index/');


	//---- CARGAR CONSULTA

	elseif(  $this->input->post('cargar_consulta')  != FALSE ):

		chrome_log("Contacto/cargar_consulta");

		//var_dump($this->input->post('id_contacto'));

		$array = str_replace("&", "\"", $this->input->post('id_contacto'));
		$datos_array = $array[0];
		$datos_array = json_decode($datos_array);
		$id = $datos_array->id;
		$origen = $datos_array->origen;


 		if($origen == 'CRM'): // Si viene desde CRM

			$datos_contacto['informacion_personal'] = $this->Contacto_model->traer_informacion_crm_persona($id);
			$datos_contacto['emails'] = $this->Contacto_model->traer_emails_crm($id);
			$datos_contacto['telefonos'] = $this->Contacto_model->traer_telefonos_crm($id);
			$datos_contacto['documentos'] = $this->Contacto_model->traer_documentos_crm($id);
		endif;

		if($origen == 'SIGEU'):  // Si viene desde SIGEU ($id en realidad es el N_ID_PERSONA de sigeu )

			$datos_contacto['informacion_personal'] = $this->Contacto_model->traer_informacion_persona($id);
			$datos_contacto['emails'] = $this->Contacto_model->traer_emails_sigeu($id);
			$datos_contacto['telefonos'] = $this->Contacto_model->traer_telefonos_sigeu($id);
			$datos_contacto['documentos'] = $this->Contacto_model->traer_documentos_sigeu($id);

		endif;


		$datos_coincidentes['apellido'] = utf8_encode($datos_contacto['informacion_personal']->APELLIDO);
		$datos_coincidentes['nombre'] = utf8_encode($datos_contacto['informacion_personal']->NOMBRE);

		if(isset($datos_contacto['emails']['EMAIL']))
			$datos_coincidentes['email'] = $datos_contacto['emails']['EMAIL'];
		else
			$datos_coincidentes['email'] = null;

		if(isset($datos_contacto['telefonos']['TELEFONO']))
			$datos_coincidentes['telefono'] = $datos_contacto['telefonos']['TELEFONO'];
		else
			$datos_coincidentes['telefono'] = "";

		$datos_coincidentes['educacion'] = "";
		$datos_coincidentes['empresa'] = "";
		$datos_coincidentes['cargo'] = "";
		$datos_coincidentes['origen'] = $origen;
		$datos_coincidentes['id_usuario'] = $id;
		$datos_coincidentes['accion'] = 'Cargar consulta';


		//var_dump($datos_coincidentes);

		$datos_json_coincidentes = json_encode($datos_coincidentes);
		$datos_json_coincidentes = str_replace("\"", "&", $datos_json_coincidentes);


		//var_dump($datos_json_coincidentes);

		//echo "aaa";

		$datos['informacion_interes'] = $this->Consulta_model->traer_info_interes();
		$datos['periodo_ingreso'] = $this->Consulta_model->traer_periodo_ingreso();
		$datos['estado_consulta'] = $this->Consulta_model->traer_estado_consulta_prg();
		$datos['como_contactar'] = $this->Consulta_model->traer_como_contactar();
		$datos['datos_persona'] = $datos_json_coincidentes;

		//var_dump($datos['informacion_interes']);

		$array['id'] = $id;
		$array['origen'] = $origen;
		if( $this->Consulta_model->existe_consulta_activa($array)) 
		{	
			$datos['mensaje'] = "El usuario tiene una consulta activa. Solamente se puede tener una consulta activa por usuario.<br>
			                     <strong style='font-size:17px'><a href='".base_url()."index.php/contacto/ver_contacto/".$id."'>Ir al usuario</a></strong>";
			
			$this->load->view('estructura/head');
			$this->load->view('consulta/mensaje_error',$datos);
			$this->load->view('estructura/footer');
		}
		else
		{
			$this->load->view('estructura/head');
			$this->load->view('consulta/ver_alta_consulta_3',$datos);
			$this->load->view('estructura/footer');
		}


	 

	endif;
}


public function fusionar_contactos()
{
	chrome_log("Contacto/fusionar_contactos");

	if ($this->form_validation->run('fusionar_contactos') == FALSE):

		chrome_log("No paso validacion");
		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');
		echo validation_errors();

	else:

		chrome_log("Paso validacion");

		$resultado = $this->Contacto_model->fusionar_contactos($this->input->post());

		//echo "$resultado: ".$resultado;

		if( $resultado > 0):

			$this->session->set_flashdata('mensaje', 'Contactos fusionados exitosamente');

		else:

			$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');

		endif;


	endif;

	redirect('contacto/ver_contacto/'.$resultado ,'refresh');

}

public function vincular_contactos()
{
	chrome_log("Contacto/vincular_contactos");

	if ($this->form_validation->run('vincular_contactos') == FALSE):

		chrome_log("No paso validacion");
		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');
		echo validation_errors();

	else:

		chrome_log("Paso validacion");

		$id_crm_persona = $this->Contacto_model->vincular_contactos($this->input->post());

		if( $id_crm_persona > 0):

			$this->session->set_flashdata('mensaje', 'Contactos vinculados exitosamente');

		else:

			$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');

		endif;


	endif;

	redirect('contacto/ver_contacto/'.$id_crm_persona ,'refresh');

}

//-------------- EDUCACION -----------

public function alta_educacion_contacto()
{
	chrome_log("Contacto/alta_educacion_contacto");

	if ($this->form_validation->run('alta_educacion_contacto') == FALSE):

		chrome_log("No paso validacion 222");
		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');

	else:

		chrome_log("Paso validacion");

		$resultado = $this->Contacto_model->abm_educacion('A', $this->input->post());

		if( $resultado > 0):

			$this->session->set_flashdata('mensaje', 'Educacion cargada exitosamente');

		else:

			$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');

		endif;


	endif;

	redirect('contacto/ver_modificar_contacto/'.$this->input->post('id_crm_persona')."/4" ,'refresh');
}

public function modifica_educacion_contacto()
{
	chrome_log("Contacto/alta_educacion_contacto");

	if ($this->form_validation->run('modifica_educacion_contacto') == FALSE):

		chrome_log("No paso validacion 222");
		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');

	else:

		chrome_log("Paso validacion");

		$resultado = $this->Contacto_model->abm_educacion('M', $this->input->post());

		if( $resultado > 0):

			$this->session->set_flashdata('mensaje', 'Educacion modificado exitosamente');

		else:

			$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');

		endif;


	endif;

	$id_crm_persona = $this->input->post('id_crm_persona');
	redirect("contacto/ver_modificar_contacto/$id_crm_persona/4" ,'refresh');
}

public function baja_educacion_contacto()
{
	chrome_log("Contacto/baja_educacion_contacto");

	if ($this->form_validation->run('baja_educacion_contacto') == FALSE):

		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');
		$return["error"] = TRUE;

	else:

		chrome_log("Paso validacion");

		$resultado = $this->Contacto_model->abm_educacion('B', $this->input->post());

		if( $resultado > 0):

			$this->session->set_flashdata('mensaje', 'Educacion eliminada exitosamente');
			$return["error"] = FALSE;

		else:

			$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');
			$return["error"] = TRUE;

		endif;


	endif;


	print json_encode($return);
}

//-------------- EMAIL -----------

public function alta_email_contacto()
{
	chrome_log("Contacto/alta_email_contacto");

	 	$this->form_validation->set_message('existe_email_validation', 'Error, el email ya existe');


	if ($this->form_validation->run('alta_email_contacto') == FALSE):

		chrome_log("No paso validacion 222");
		$this->session->set_flashdata('mensaje', validation_errors() );

	else:

		chrome_log("Paso validacion");

		$resultado = $this->Contacto_model->abm_email('A', $this->input->post());

		if( $resultado > 0):

			$this->session->set_flashdata('mensaje', 'Email cargado exitosamente');

		else:

			$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');

		endif;


	endif;

	redirect('contacto/ver_modificar_contacto/'.$this->input->post('id_crm_persona')."/1" ,'refresh');
}

public function modifica_email_contacto()
{
	chrome_log("Contacto/alta_educacion_contacto");

	if ($this->form_validation->run('modifica_email_contacto') == FALSE):

		chrome_log("No paso validacion 222");
		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');

	else:

		chrome_log("Paso validacion");

		$resultado = $this->Contacto_model->abm_email('M', $this->input->post());

		if( $resultado > 0):

			$this->session->set_flashdata('mensaje', 'Email modificado exitosamente');

		else:

			$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');

		endif;


	endif;

	$id_crm_persona = $this->input->post('id_crm_persona');

	//echo validation_errors();
	redirect("contacto/ver_modificar_contacto/$id_crm_persona"."/1" ,'refresh');
}

public function baja_email_contacto()
{
	chrome_log("Contacto/baja_email_contacto");

	if ($this->form_validation->run('baja_email_contacto') == FALSE):

		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');
		$return["error"] = TRUE;

	else:

		chrome_log("Paso validacion");

		$resultado = $this->Contacto_model->abm_email('B', $this->input->post());

		if( $resultado > 0):

			$this->session->set_flashdata('mensaje', 'Email eliminado exitosamente');
			$return["error"] = FALSE;

		else:

			$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');
			$return["error"] = TRUE;

		endif;


	endif;


	print json_encode($return);
}


//-------------- TELEFONO -----------

public function alta_telefono_contacto()
{
	chrome_log("Contacto/alta_telefono_contacto");

	if ($this->form_validation->run('alta_telefono_contacto') == FALSE):

		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');

	else:

		chrome_log("Paso validacion");

		$resultado = $this->Contacto_model->abm_telefono('A', $this->input->post());

		if( $resultado > 0):

			$this->session->set_flashdata('mensaje', 'Telefono cargado exitosamente');

		else:

			$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');

		endif;


	endif;

	redirect('contacto/ver_modificar_contacto/'.$this->input->post('id_crm_persona')."/2" ,'refresh');
}

public function modifica_telefono_contacto()
{
	chrome_log("Contacto/modifica_telefono_contacto");

	if ($this->form_validation->run('modifica_telefono_contacto') == FALSE):

		chrome_log("No paso validacion 222");
		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');

	else:

		chrome_log("Paso validacion");

		$resultado = $this->Contacto_model->abm_telefono('M', $this->input->post());

		if( $resultado > 0):

			$this->session->set_flashdata('mensaje', 'Telefono modificado exitosamente');

		else:

			$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');

		endif;


	endif;

	$id_crm_persona = $this->input->post('id_crm_persona');

	//echo validation_errors();
	redirect("contacto/ver_modificar_contacto/$id_crm_persona"."/2" ,'refresh');
}

public function baja_telefono_contacto()
{
	chrome_log("Contacto/baja_telefono_contacto");

	if ($this->form_validation->run('baja_telefono_contacto') == FALSE):

		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');
		$return["error"] = TRUE;

	else:

		chrome_log("Paso validacion");

		$resultado = $this->Contacto_model->abm_telefono('B', $this->input->post());

		if( $resultado > 0):

			$this->session->set_flashdata('mensaje', 'Telefono eliminado exitosamente');
			$return["error"] = FALSE;

		else:

			$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');
			$return["error"] = TRUE;

		endif;


	endif;


	print json_encode($return);
}


//-------------- Documento -----------

public function alta_documento_contacto()
{
	chrome_log("Contacto/alta_documento_contacto");

	if ($this->form_validation->run('alta_documento_contacto') == FALSE):

		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');

	else:

		chrome_log("Paso validacion");


		$resultado = $this->Contacto_model->abm_documento('A', $this->input->post());

		if( $resultado > 0):

			$this->session->set_flashdata('mensaje', 'Documento cargado exitosamente');

		else:

			$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');

		endif;


	endif;

	redirect('contacto/ver_modificar_contacto/'.$this->input->post('id_crm_persona')."/3" ,'refresh');
}

public function modifica_documento_contacto()
{
	chrome_log("Contacto/modifica_documento_contacto");

	if ($this->form_validation->run('modifica_documento_contacto') == FALSE):

		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');

	else:

		chrome_log("Paso validacion");

		$resultado = $this->Contacto_model->abm_documento('M', $this->input->post());

		if( $resultado > 0):

			$this->session->set_flashdata('mensaje', 'Documento modificado exitosamente');

		else:

			$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');

		endif;


	endif;

	$id_crm_persona = $this->input->post('id_crm_persona');

	//echo validation_errors();
	redirect("contacto/ver_modificar_contacto/$id_crm_persona"."/3" ,'refresh');
}

public function baja_documento_contacto()
{
	chrome_log("Contacto/baja_documento_contacto");

	if ($this->form_validation->run('baja_documento_contacto') == FALSE):

		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');
		$return["error"] = TRUE;

	else:

		chrome_log("Paso validacion");

		$resultado = $this->Contacto_model->abm_documento('B', $this->input->post());

		if( $resultado > 0):

			$this->session->set_flashdata('mensaje', 'Documento eliminado exitosamente');
			$return["error"] = FALSE;

		else:

			$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');
			$return["error"] = TRUE;

		endif;


	endif;


	print json_encode($return);
}


//-------------- EXPERIENCIA LABORAL -----------

public function alta_experiencia_laboral()
{
	chrome_log("Contacto/alta_experiencia_laboral");

	if ($this->form_validation->run('alta_experiencia_laboral') == FALSE):

		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');

	else:

		chrome_log("Paso validacion");

		$resultado = $this->Contacto_model->abm_experiencia_laboral('A', $this->input->post());

		if( $resultado > 0):

			$this->session->set_flashdata('mensaje', 'Experiencia laboral cargada exitosamente');

		else:

			$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');

		endif;


	endif;

	redirect('contacto/ver_modificar_contacto/'.$this->input->post('id_crm_persona')."/5" ,'refresh');
}
 
public function modifica_experiencia_laboral()
{
	chrome_log("Contacto/modifica_experiencia_laboral");

	if ($this->form_validation->run('modifica_experiencia_laboral') == FALSE):

		chrome_log("No paso validacion 222");
		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');

	else:

		chrome_log("Paso validacion");

		$resultado = $this->Contacto_model->abm_experiencia_laboral('M', $this->input->post());

		if( $resultado > 0):

			$this->session->set_flashdata('mensaje', 'Experiencia laboral modificada exitosamente');

		else:

			$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');

		endif;


	endif;

	$id_crm_persona = $this->input->post('id_crm_persona');
	redirect("contacto/ver_modificar_contacto/$id_crm_persona"."/5" ,'refresh');
}
 

public function baja_experiencia_laboral()
{
	chrome_log("Contacto/baja_experiencia_laboral");

	if ($this->form_validation->run('baja_experiencia_laboral') == FALSE):

		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');
		$return["error"] = TRUE;

	else:

		chrome_log("Paso validacion");

		$resultado = $this->Contacto_model->abm_experiencia_laboral('B', $this->input->post());

		if( $resultado > 0):

			$this->session->set_flashdata('mensaje', 'Experiencia laboral eliminada exitosamente');
			$return["error"] = FALSE;

		else:

			$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');
			$return["error"] = TRUE;

		endif;


	endif;


	print json_encode($return);
}

public function existe_persona_empresa()  // Validar que no exista en login.js para registrarse
{
	chrome_log("Contacto/existe_persona_empresa".$this->input->post('id_crm_persona')."-".$this->input->post('id_empresa'));

 
	if ($this->form_validation->run('existe_persona_empresa') == FALSE):

		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');
		$return["error"] = TRUE;

	else:

		chrome_log("Paso validacion");
 

		if(  $this->Contacto_model->existe_empresa_persona_crm( $this->input->post('id_crm_persona') , $this->input->post('id_empresa') ) ):

			//chrome_log("FALSE");
			$this->session->set_flashdata('mensaje', 'El usuario ya tiene la empresa');
			$return["error"] = FALSE;

		else:

			//chrome_log("TRUE");

			$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');
			$return["error"] = TRUE;

		endif;


	endif; 


	print json_encode($return);
}


//////////////////////////////////////////////////////////////////////////////////////



public function comprobar_persona_crm_existente_validation($id_crm_persona=null)
{
	if($this->Contacto_model->existe_persona_crm($id_crm_persona))
		return false;
	else
		return true;
}

public function eliminar_persona($id_crm_persona)
{
	chrome_log("eliminar_persona");

 	if(!isset($id_crm_persona))
 		redirect('home','refresh');


 	$_POST['id_crm_persona'] = $id_crm_persona;

	if ($this->form_validation->run('eliminar_persona') == FALSE):

		chrome_log("No paso validacion");
		echo  validation_errors();

	else:

		chrome_log("paso validacion");

		$resultado = $this->Contacto_model->eliminar_contacto_crm($id_crm_persona);


		if( $resultado > 0):

			$this->session->set_flashdata('mensaje', 'Se ha eliminado la persona y todas sus consultas');

		else:

			$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');

		endif;

	endif;

	redirect("contacto/contacto/index" ,'refresh');
}


public function modifica_datos_crm_persona()
{
	chrome_log("Contacto/modifica_contacto");

	if ($this->form_validation->run('modifica_datos_crm_persona') == FALSE):

		chrome_log("No paso validacion");
		$this->session->set_flashdata('mensaje', 'Error: no paso la validacion.');
		echo validation_errors();

	else:

		chrome_log("Paso validacion");

		$resultado = $this->Contacto_model->modifica_datos_crm_persona($this->input->post());

		if( $resultado > 0):

			$this->session->set_flashdata('mensaje', 'Datos modificados exitosamente');

		else:

			$this->session->set_flashdata('mensaje', 'Error interno, por favor intente mas tarde');

		endif;


	endif;

	$id_crm_persona = $this->input->post('id_crm_persona');

	redirect("contacto/ver_modificar_contacto/$id_crm_persona" ,'refresh');
}


public function ajax_contacto_crm()
{
	$buscar = $this->input->get('term');
	chrome_log("ajax_contacto_crm");

	if( isset($buscar) && strlen($buscar) > 2)
	{
		$buscar = strtoupper($buscar);
		$buscar = str_replace(" ", "%", $buscar);
		$buscar = str_replace("ñ", "Ñ", $buscar);

		chrome_log("	SELECT DISTINCT(p.ID_CRM_PERSONA),
												       DECODE( p.nombre, NULL, pe.D_NOMBRES,p.nombre) as nombres,
												       DECODE( p.apellido, NULL, pe.D_APELLIDOS, p.apellido) as apellidos,
												       DECODE( p.apellido, NULL, pe.C_EMAIL, cpe.EMAIL) as email
												FROM 	CRM_PERSONA p
												  LEFT JOIN CRM_PERSONA_EMAIL cpe ON p.id_crm_persona = cpe.id_crm_persona
												  LEFT JOIN CRM_PERSONA_TELEFONO cpt ON p.id_crm_persona = cpt.id_crm_persona
												  LEFT JOIN ( SELECT P.N_ID_PERSONA, P.D_APELLIDOS, P.D_NOMBRES, C.C_EMAIL
												              FROM PERSONAS P, CORREOS C
												              WHERE P.N_ID_PERSONA = C.N_ID_PERSONA) pe ON p.ID_PERSONA = pe.N_ID_PERSONA
												WHERE cpe.EMAIL like '%$buscar%'
												OR  TRANSLATE(upper(P.APELLIDO),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE '%$buscar%'
												OR  TRANSLATE(upper(P.NOMBRE),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE '%$buscar%'
												OR  TRANSLATE(upper(Pe.D_APELLIDOS),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE '%$buscar%'
												OR  TRANSLATE(upper(Pe.D_NOMBRES),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE '%$buscar%'
												OR  TRANSLATE(upper(Pe.C_EMAIL),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE '%$buscar%'");

		$query=$this->db->query((utf8_decode("	SELECT DISTINCT(p.ID_CRM_PERSONA),
												       DECODE( p.nombre, NULL, pe.D_NOMBRES,p.nombre) as nombres,
												       DECODE( p.apellido, NULL, pe.D_APELLIDOS, p.apellido) as apellidos,
												       DECODE( p.apellido, NULL, pe.C_EMAIL, cpe.EMAIL) as email
												FROM 	CRM_PERSONA p
												  LEFT JOIN CRM_PERSONA_EMAIL cpe ON p.id_crm_persona = cpe.id_crm_persona
												  LEFT JOIN CRM_PERSONA_TELEFONO cpt ON p.id_crm_persona = cpt.id_crm_persona
												  LEFT JOIN ( SELECT P.N_ID_PERSONA, P.D_APELLIDOS, P.D_NOMBRES, C.C_EMAIL
												              FROM PERSONAS P, CORREOS C
												              WHERE P.N_ID_PERSONA = C.N_ID_PERSONA) pe ON p.ID_PERSONA = pe.N_ID_PERSONA
												WHERE cpe.EMAIL like '%$buscar%'
												OR  TRANSLATE(upper(P.APELLIDO),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE '%$buscar%'
												OR  TRANSLATE(upper(P.NOMBRE),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE '%$buscar%'
												OR  TRANSLATE(upper(Pe.D_APELLIDOS),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE '%$buscar%'
												OR  TRANSLATE(upper(Pe.D_NOMBRES),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE '%$buscar%'
												OR  TRANSLATE(upper(Pe.C_EMAIL),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE '%$buscar%'" )));

		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$result[]= array(
									"value" => utf8_encode($row->ID_CRM_PERSONA.": ".$row->APELLIDOS.", ".$row->NOMBRES." [".$row->EMAIL."]"),
									"id_crm_persona" =>  $row->ID_CRM_PERSONA,
									"nombre_completo" =>  utf8_encode($row->APELLIDOS.", ".$row->NOMBRES),
									"email" =>  utf8_encode($row->EMAIL)
								);
			}
		}

		echo json_encode($result);
	}
}

public function comprobar_existe_dni_sigeu($dni=null)
{
	if($this->Contacto_model->existe_dni_sigeu($dni))
		return false;
	else
		return true;
}

public function comprobar_existe_id_sigeu($id_crm_persona=null)
{
	if($this->Contacto_model->existe_id_persona($id_crm_persona))
		return false;
	else
		return true;
}

public function existe_email_validation($email=null)
{
	if($this->Contacto_model->existe_email_crm($email))
		return false;
	else
		return true;
}

public function existe_email()  // Validar que no exista en login.js para registrarse
{
	if($this->Contacto_model->existe_email_crm($this->input->post('email')))
		echo "false";
	else
		echo "true";  // Duplicado
}

public function enviar_persona_sigeu($id_crm_persona)
{
	chrome_log("enviar_persona_sigeu");

 	if(!isset($id_crm_persona)): // Valido que haya enviado un ID de crm persona

 		$this->session->set_flashdata('mensaje', 'Error: no envio la persona');
 		redirect( 'contacto/ver_contacto/'.$id_crm_persona, 'refresh');

 	endif;

 	if( ! ($dni = $this->Contacto_model->existe_dni_crm($id_crm_persona) ) ): // Valido que tengo DNI

 		$this->session->set_flashdata('mensaje', 'Error: el usuario no tiene DNI');
 		redirect( 'contacto/ver_contacto/'.$id_crm_persona, 'refresh');

 	endif;

 	if( $this->Contacto_model->existe_sexo_persona($id_crm_persona) ): // Valido que tengo SEXO

 		$this->session->set_flashdata('mensaje', 'Error: el usuario no tiene SEXO seleccionado');
 		redirect( 'contacto/ver_contacto/'.$id_crm_persona, 'refresh');

 	endif;


	$_POST['id_crm_persona'] = $id_crm_persona;
	$_POST['dni'] = $dni;

 	$this->form_validation->set_message('comprobar_existe_dni_sigeu', 'Error, hay una persona en SIGEU con el mismo DNI');
 	$this->form_validation->set_message('comprobar_existe_id_sigeu', 'Error, esta persona ya tiene un ID PERSONA de SIGEU');

	$this->form_validation->set_data($_POST);

	if ($this->form_validation->run('enviar_sigeu') == FALSE):

		chrome_log("No paso validacion");

		$this->session->set_flashdata('mensaje', validation_errors());
 		redirect( 'contacto/ver_contacto/'.$id_crm_persona, 'refresh');

	else:

		chrome_log("paso validacion");
		$result = $this->Contacto_model->enviar_persona_sigeu( $id_crm_persona );

 		if($result != FALSE)
		{
		    chrome_log("Inserto");
		    $return["error"] = FALSE;
			$this->session->set_flashdata('mensaje', 'Se envio a SIGEU exitosamente. El usuario sera de solo lectura y modificable desde SIGEU');
		}
		else
		{
			chrome_log("No Inserto");
			$return["error"] = TRUE;
			$this->session->set_flashdata('mensaje', 'Ocurrio un error, no se envio a SIGEU, intente nuevamente');
		}

	endif;

	redirect( 'contacto/ver_contacto/'.$id_crm_persona, 'refresh');
}


}

?>