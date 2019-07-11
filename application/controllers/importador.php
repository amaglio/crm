<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Importador extends CI_Controller {

public function __construct()
{
	parent::__construct();
	$this->load->model('Importador_model');
	$this->load->model('Contacto_model');
	$this->load->model('Login_model');
	$this->load->model('Evento_model');
	$this->db = $this->load->database($this->session->userdata('DB'),TRUE, TRUE);

	//$this->output->enable_profiler(TRUE);
}

public function index_web( $flag_programas = NULL )
{
	$contactos_web = $this->Importador_model->traer_contactos_a_importar();
	$datos['mensaje'] = $this->session->flashdata('mensaje');

	$array_contactos_web = array();

	foreach ($contactos_web->result() as $row):

		$contacto_web['contacto'] = $row;
		$contacto_web['programas_interes'] =$this->Importador_model->traer_programas_interes_contacto($row->ID_CONTACTO_WEB);
		$contacto_web['periodo_ingreso'] =$this->Importador_model->traer_periodo_ingreso_contacto($row->ID_CONTACTO_WEB);
		$contacto_web['como_contactarlo'] =$this->Importador_model->traer_como_contactarlo($row->ID_CONTACTO_WEB);
		$contacto_web['info_interes'] =$this->Importador_model->traer_info_interes($row->ID_CONTACTO_WEB);

		if( isset( $flag_programas ) )
		{
			if( $flag_programas == 1)
			{
				if( $contacto_web['programas_interes']->num_rows() == 1  )
				{
					array_push($array_contactos_web, $contacto_web);
				}
			}
			else
			{
				if( $contacto_web['programas_interes']->num_rows() > 1  )
				{
					array_push($array_contactos_web, $contacto_web);
				}
			}
		}
		else
		{
			array_push($array_contactos_web, $contacto_web);	
		}

	endforeach;

	$datos['contactos_web'] = $array_contactos_web;

	$this->load->view('estructura/head');
	$this->load->view('importador/index_web',$datos);
	$this->load->view('estructura/footer');
}

public function index_excel()
{

	$datos['mensaje'] = $this->session->flashdata('mensaje');
 	$datos['eventos'] = $this->Evento_model->get_eventos();

	$array_contactos_web = array();

	$this->load->view('estructura/head');
	$this->load->view('importador/index_excel',$datos);
	$this->load->view('estructura/footer');
}

public function pre_importar()
{
	 
 	chrome_log("pre_importar");

 	//var_dump($this->input->post());

	if( $this->input->post('submit') == 'Importar' ):

		$array_contactos = array();

		foreach ($this->input->post('contactos_chequeados') as $id_contacto_web):

			$usuario = $this->Contacto_model->traer_informacion_contacto_web($id_contacto_web); // 1- traigo la informacion del usuario
			$informacion['usuario_buscado'] = $usuario;
			$array_repetidos = array();

			// SIGEU --------------------------------


				if($resultado = $this->Contacto_model->buscar_coincidencia_en_sigeu($usuario) ):

					if( $resultado->num_rows() > 0):

					 		foreach ($resultado->result() as $row):

					 			$datos_usuario_econtrado['datos_usuario'] = $datos_usuario = $this->Contacto_model->traer_informacion_persona($row->N_ID_PERSONA);
					 		 	//$datos_usuario_econtrado['imagen_usuario'] = buscar_foto_persona($row->N_ID_PERSONA);
					 			$datos_usuario_econtrado['imagen_usuario'] = NULL;
					 		 	$datos_usuario_econtrado['coincidencias'] =  $row;

								array_push($array_repetidos,$datos_usuario_econtrado);

					 		endforeach;

					endif;


				endif;



			// CRM -----------------------------------


				if($resultado = $this->Contacto_model->buscar_coincidencia_en_crm($usuario) ):

					 if( $resultado->num_rows() > 0):

					 		foreach ($resultado->result() as $row):

					 			$datos_usuario_econtrado['datos_usuario'] = $datos_usuario = $this->Contacto_model->traer_informacion_crm_persona($row->ID_CRM_PERSONA);
					 		 	//$datos_usuario_econtrado['imagen_usuario'] = buscar_foto_persona($row->ID_CRM_PERSONA);
					 			$datos_usuario_econtrado['imagen_usuario'] = NULL;
					 		 	$datos_usuario_econtrado['coincidencias'] =  $row;

								array_push($array_repetidos,$datos_usuario_econtrado);

					 		endforeach;

					 endif;

				endif;

			$informacion['repetidos'] = $array_repetidos;
			array_push($array_contactos,$informacion);

		endforeach;

		$datos['contactos_a_importar'] = $array_contactos;
		$this->load->view('estructura/head');
		$this->load->view('importador/pre_importar',$datos);
		$this->load->view('estructura/footer');

		chrome_log("Importar");

	elseif( $this->input->post('submit') == 'Eliminar' ):

		foreach ($this->input->post('contactos_chequeados') as $id_contacto_web):

			//$resultado =
			if($this->Contacto_model->eliminar_contacto_web($id_contacto_web)):
				echo "borro";
				$this->session->set_flashdata('mensaje', 'Contactos eliminados exitosamente');
			else:
				echo "No borro";
				$this->session->set_flashdata('mensaje', 'No se pudo eliminar a los contactos, intente mas tarde');

			endif;

		endforeach;

		redirect('importador/index_web/');

		chrome_log("Eliminar");

	endif;
}

public function pre_importar_excel()
{
 	chrome_log("Importador/pre_importar_excel");

 	$_POST['archivo'] = $_FILES['archivo']['name'];

	if ( $this->form_validation->run('pre_importar_excel') == FALSE ):

		chrome_log("No paso validacion 2");

	else:

		chrome_log("Paso validacion 2");

		//echo $_POST['archivo'] = $_FILES['archivo']['name'];

		$config['upload_path'] = 'assets/excel_importar';
		$config['allowed_types'] = 'xls';
		$config['file_name'] = time();

		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		$this->upload->set_allowed_types('*');

	 	if (!$this->upload->do_upload('archivo')):

	 		chrome_log("No subio la foto al servidor");
	 		echo $this->upload->display_errors();

	 	else:

	 		chrome_log("Si subio la foto al servidor");
	 		$datos= $this->upload->data();
			$nombre_archivo = $datos['file_name'];

			$file = './assets/excel_importar/'.$nombre_archivo;
			$this->load->library('excel');
			$objPHPExcel = PHPExcel_IOFactory::load($file);
			//$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
			$sheetObj = $objPHPExcel->getActiveSheet();

			$ultima_fila = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
			$array_contactos = array();

			foreach( $sheetObj->getRowIterator(2, $ultima_fila) as $row )
			{

			    $i = 0;
			    $datos_usuario = new stdClass;

			    foreach( $row->getCellIterator() as $cell )
			    {

			    	switch ($i)
			    	{
			    		case 0:
			    			$datos_usuario->APELLIDO = utf8_encode($cell->getValue());
			    			break;

			    		case 1:
			    			$datos_usuario->NOMBRE = utf8_encode($cell->getValue());
			    			break;

			    		case 2:
			    			$datos_usuario->EMAIL = utf8_encode($cell->getValue());
			    			break;

			    		case 3:
			    			$datos_usuario->TELEFONO = utf8_encode($cell->getValue());
			    			break;

			    		case 4:
			    			$datos_usuario->COLEGIO = utf8_encode($cell->getValue());
			    			break;

			    		case 5:
			    			$datos_usuario->EMPRESA = utf8_encode($cell->getValue());
			    			break;

			    		case 6:
			    			$datos_usuario->PROGRAMAS = utf8_encode($cell->getValue());
			    			break;

			    		case 7:
			    			$datos_usuario->PERIODO = utf8_encode($cell->getValue());
			    			break;

			    		case 8:
			    			$datos_usuario->ANIO = utf8_encode($cell->getValue());
			    			break;

			    		case 9:
			    			$datos_usuario->COMENTARIO = utf8_encode($cell->getValue());
			    			break;

			    	}
			    	$i++;

			    }

			    //echo "ID EVENATO:".$this->input->post('id_evento');

			    if($this->input->post('id_evento'))
			    	$datos_usuario->ID_EVENTO = $this->input->post('id_evento');

			    //var_dump($datos_usuario);
			    //echo "<br><br>";
			    $informacion['usuario_buscado'] = $datos_usuario;
				$array_repetidos = array();

				// SIGEU --------------------------------

				if($resultado = $this->Contacto_model->buscar_coincidencia_en_sigeu($datos_usuario) ):

					if( $resultado->num_rows() > 0):

					 		foreach ($resultado->result() as $row):

					 			$datos_usuario_econtrado['datos_usuario'] = $this->Contacto_model->traer_informacion_persona($row->N_ID_PERSONA);
					 			$datos_usuario_econtrado['imagen_usuario'] = NULL;
					 		 	$datos_usuario_econtrado['coincidencias'] =  $row;

								array_push($array_repetidos,$datos_usuario_econtrado);

					 		endforeach;

					endif;


				endif;


				// CRM -----------------------------------


				if($resultado = $this->Contacto_model->buscar_coincidencia_en_crm($datos_usuario) ):

					 if( $resultado->num_rows() > 0):

					 		foreach ($resultado->result() as $row):

					 			$datos_usuario_econtrado['datos_usuario'] = $this->Contacto_model->traer_informacion_crm_persona($row->ID_CRM_PERSONA);
					 		 	//$datos_usuario_econtrado['imagen_usuario'] = buscar_foto_persona($row->ID_CRM_PERSONA);
					 			$datos_usuario_econtrado['imagen_usuario'] = NULL;
					 		 	$datos_usuario_econtrado['coincidencias'] =  $row;

								array_push($array_repetidos,$datos_usuario_econtrado);

					 		endforeach;

					 endif;

				endif;

				$informacion['repetidos'] = $array_repetidos;
				array_push($array_contactos,$informacion);


			}

			$datos['contactos_a_importar'] = $array_contactos;

			 if($this->input->post('id_evento'))
			    	$datos['id_evento'] = $this->input->post('id_evento');

			$this->load->view('estructura/head');
			$this->load->view('importador/pre_importar_excel',$datos);
			$this->load->view('estructura/footer');



	 	endif;



	endif;
}

public function importar()
{
	//var_dump($this->input->post());
	$contactos_importados = array();

	$resultado_mensaje = "<strong> Resultado de la Importacion: </strong> <br><br><br>";

 	foreach ($this->input->post()  as $key => $value):

 			$datos =  str_replace( "&", "\"", $value );
 		    $datos = json_decode($datos);
 		    //var_dump($datos);
			//echo "Id: ".$datos->id_contacto_web;

 		    $datos_contactos = $this->Contacto_model->traer_informacion_contacto_web($datos->id_contacto_web);

 		    $resultado_mensaje .=  "<br><i class='fa fa-chevron-circle-right'></i> ".utf8_encode($datos_contactos->APELLIDO." ,".$datos_contactos->NOMBRE). ": ";

 		    //echo $resultado_mensaje;

 		    if( $datos->tipo == 'sin_coincidencias' ): // Contacto sin coincidencias, es nuevo.

 		    	//echo 'sin_coincidencias';

	    		if($id_crm_persona = $this->Contacto_model->alta_contacto_crm_importado($datos->id_contacto_web, $resultado_mensaje)):

	    			$resultado_mensaje .= "<strong> Contacto importado como nuevo exitosamente. </strong>"." <a href=".base_url()."index.php/contacto/ver_contacto/".$id_crm_persona."><i style='color:#357ca5;  padding-left:20opx' class='fa fa-binoculars' aria-hidden='true'> ver </i> </a>";

	    		else:

	    			$resultado_mensaje .= "<strong> Error: no ha podido ser importado.</strong>";

	    		endif;

 		    elseif( $datos->tipo == 'con_coincidencias' ): // Usuario que tenia coincidencias

 		    	//echo 'con_coincidencias';

 		    	if( $datos->accion == 'nuevo' ): // Usuario con coincidencias pero cargado como nuevo

 		    		if($id_crm_persona = $this->Contacto_model->alta_contacto_crm_importado($datos->id_contacto_web, $resultado_mensaje)):

		    			$resultado_mensaje .= "<strong> Contacto importado como nuevo exitosamente. </strong>"." <a href=".base_url()."index.php/contacto/ver_contacto/".$id_crm_persona."><i style='color:#357ca5;  padding-left:20opx' class='fa fa-binoculars' aria-hidden='true'> ver </i> </a>";

		    		else:

		    			$resultado_mensaje .= "<strong> Error: no ha podido ser importado.</strong>";

		    		endif;

 		    	elseif ( $datos->accion == 'fusionar' ): // Usuario con coincidencias a fusionar


 		    		$array['id'] = $datos->id_usuario_coincidente;
					$array['origen'] = $datos->origen;

					//var_dump($array);
 
					if( !$this->Consulta_model->existe_consulta_activa($array) ):  // Me fijo si tiene consulta activa

	 		    		if( $datos->origen == 'SIGEU' ): // Usuario con coincidencias a fusionar con SIGEU

	 		    			if( $id_crm_persona = $this->Contacto_model->fusionar_contacto_sigeu($datos->id_contacto_web, $datos->id_usuario_coincidente)):

				    			$resultado_mensaje .= "<strong> Contacto fusionado con SIGEU exitosamente.</strong>"." <a href=".base_url()."index.php/contacto/ver_contacto/".$id_crm_persona."><i style='color:#357ca5;  padding-left:20opx' class='fa fa-binoculars' aria-hidden='true'> ver </i> </a>";

				    		else:

				    			$resultado_mensaje .= "<strong> Error: no ha podido ser importado.</strong>";

				    		endif;

	 		    		else: // Usuario con coincidencias a fusionar con CRM


	 		    			if( $id_crm_persona = $this->Contacto_model->fusionar_contacto_crm($datos->id_contacto_web, $datos->id_usuario_coincidente)):

				    			$resultado_mensaje .= "<strong> Contacto fusionado con CRM exitosamente.</strong>"." <a href=".base_url()."index.php/contacto/ver_contacto/".$id_crm_persona."><i style='color:#357ca5;  padding-left:20opx' class='fa fa-binoculars' aria-hidden='true'> ver </i> </a>";

				    		else:

				    			$resultado_mensaje .= "<strong> Error: no ha podido ser importado.</strong>";

				    		endif;

	 		    		endif;

	 		    	else:

	 		    		$resultado_mensaje .= "<strong> ERROR: el usuario no puede ser seleccionado. El usuario ya tiene una consulta activa.</strong>"." <a href=".base_url()."index.php/contacto/ver_contacto/".$datos->id_usuario_coincidente."><i style='color:#357ca5;  padding-left:20opx' class='fa fa-binoculars' aria-hidden='true'> ver </i> </a>";

	 		    	endif;

 		    	endif;

 		    endif;

 		    if( $datos_contactos->ID_EVENTO ): // Si tiene ID se lo asigna al evento

 		    	if ( $this->Evento_model->alta_asistente_crm($id_crm_persona, $datos_contactos->ID_EVENTO) )

 		    		$resultado_mensaje .= "<strong>- Se inscribir exitosamenta al evento </strong> <a href=".base_url()."index.php/evento/ver_evento/".$datos_contactos->ID_EVENTO."><i style='color:#357ca5;  padding-left:20opx' class='fa fa-binoculars' aria-hidden='true'> ver </i> </a>";
 		    	else

 		    		$resultado_mensaje .= "<strong> No se pudo inscribir al contacto al Evento:".$datos_contactos->ID_EVENTO."</strong>";

 		    endif;

 		    $resultado_mensaje .= "<br><br>";

 	endforeach;


 	$datos_enviar['mensaje'] = $resultado_mensaje ;

	$this->load->view('estructura/head');
	$this->load->view( 'importador/resultado_importacion', $datos_enviar );
	$this->load->view('estructura/footer');
}

public function importar_excel()
{
	//var_dump($this->input->post());
	$contactos_importados = array();

	$resultado_mensaje = "<strong> Resultado de la Importacion: </strong> <br><br><br>";

	//var_dump($this->input->post());


 	foreach ($this->input->post()  as $key => $value):

 			$datos =  str_replace( "&", "\"", $value );
 		    $datos = json_decode($datos);

 		    //var_dump($datos->datos_usuario);


			$resultado_mensaje .=  "<br><i class='fa fa-chevron-circle-right'></i> ".utf8_encode($datos->datos_usuario->APELLIDO." ,".$datos->datos_usuario->NOMBRE). ": ";


 	 		if( $datos->tipo == 'sin_coincidencias' ): // Conracto sin coincidencias, es nuevo.

 	 			if($id_crm_persona = $this->Contacto_model->alta_contacto_crm_importado_excel($value, $resultado_mensaje)):

	    			$resultado_mensaje .= "<strong> Contacto importado como nuevo exitosamente. </strong>"." <a href=".base_url()."index.php/contacto/ver_contacto/".$id_crm_persona."><i style='color:#357ca5;  padding-left:20opx' class='fa fa-binoculars' aria-hidden='true'> ver </i> </a> <br>";

	    		else:

	    			$resultado_mensaje .= "<strong> Error: no ha podido ser importado.</strong> <br>";

	    		endif;


 	 		elseif( $datos->tipo == 'con_coincidencias' ): // Usuario que tenia coincidencias

 	 			if( $datos->accion == 'nuevo' ): // Usuario con coincidencias pero cargado como nuevo

 	 				if($id_crm_persona = $this->Contacto_model->alta_contacto_crm_importado_excel($value, $resultado_mensaje)):

		    			$resultado_mensaje .= "<strong> Contacto importado como nuevo exitosamente. </strong>"." <a href=".base_url()."index.php/contacto/ver_contacto/".$id_crm_persona."><i style='color:#357ca5;  padding-left:20opx' class='fa fa-binoculars' aria-hidden='true'> ver </i> </a><br>";

		    		else:

		    			$resultado_mensaje .= "<strong> Error: no ha podido ser importado.</strong><br>";

		    		endif;


 		    	elseif ( $datos->accion == 'fusionar' ): // Usuario con coincidencias a fusionar

 		    		if( $datos->origen == 'SIGEU' ): // Usuario con coincidencias a fusionar con SIGEU

 		    			if( $id_crm_persona = $this->Contacto_model->fusionar_contacto_sigeu_excel($value, $datos->id_usuario_coincidente)):

			    			$resultado_mensaje .= "<strong> Contacto fusionado con SIGEU exitosamente.</strong>"." <a href=".base_url()."index.php/contacto/ver_contacto/".$id_crm_persona."><i style='color:#357ca5;  padding-left:20opx' class='fa fa-binoculars' aria-hidden='true'> ver </i> </a><br>";

			    		else:

			    			$resultado_mensaje .= "<strong> Error: no ha podido ser importado.</strong><br>";

			    		endif;

 		    		else: // Usuario con coincidencias a fusionar con CRM


 		    			if( $id_crm_persona = $this->Contacto_model->fusionar_contacto_crm_excel($value, $datos->id_usuario_coincidente)):

			    			$resultado_mensaje .= "<strong> Contacto fusionado con CRM exitosamente.</strong>"." <a href=".base_url()."index.php/contacto/ver_contacto/".$id_crm_persona."><i style='color:#357ca5;  padding-left:20opx' class='fa fa-binoculars' aria-hidden='true'> ver </i> </a><br>";

			    		else:

			    			$resultado_mensaje .= "<strong> Error: no ha podido ser importado.</strong><br>";

			    		endif;


 		    		endif;

 		    	endif;

 	 		endif;


 	 		if(isset($datos->id_evento)):

		    	if ( $this->Evento_model->alta_asistente_crm($id_crm_persona, $datos->id_evento ) )

		    		$resultado_mensaje .= "<strong>- Se inscribir exitosamenta al evento </strong> <a href=".base_url()."index.php/evento/ver_evento/".$datos->id_evento."><i style='color:#357ca5;  padding-left:20opx' class='fa fa-binoculars' aria-hidden='true'> ver </i> </a> <br>";
		    	else

		    		$resultado_mensaje .= "<strong> No se pudo inscribir al contacto al Evento:".$datos->id_evento."</strong><br>";

		    endif;




 	endforeach;

 	$datos_enviar['mensaje'] = $resultado_mensaje ;

	$this->load->view('estructura/head');
	$this->load->view( 'importador/resultado_importacion', $datos_enviar );
	$this->load->view('estructura/footer');


}

/*
public function probar_excel()
{

	$file = './assets/archivo_excel.xlsx';

	//load the excel library
	$this->load->library('excel');

	//read file from path
	$objPHPExcel = PHPExcel_IOFactory::load($file);


	//get only the Cell Collection
	$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();

	//extract to a PHP readable array format
	foreach ($cell_collection as $cell)
	{
	    $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn(); // Columna actual
	    $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow(); // Fila actual
	    $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();

	    echo $column."-".$row."-".$data_value."<br>" ;


	    // $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
	    // $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();

	    // //header will/should be in row 1 only. of course this can be modified to suit your need.
	    // if ($row == 1) {
	    //     $header[$row][$column] = $data_value;
	    // } else {
	    //     $arr_data[$row][$column] = $data_value;
	    // }

	    // echo $data_value;
	}

}*/




}

/* End of file login.php */
/* Location: ./application/controllers/login.php */
