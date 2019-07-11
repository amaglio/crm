<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Escuela_negocios_model extends CI_Model {


	public function __construct()
	{
		parent::__construct();
	}

	public function get_referentes()
	{
		$sql =	"	SELECT  *
					FROM 	V_CRM_REFERENTES"  ;

		$query = $this->db->query( $sql );

		return $query->result_array();
	}
 	
 	public function get_referentes_camara()
	{
		$sql =	"	SELECT  *
					FROM 	V_CRM_REFERENTES_CAMARA"  ;

		$query = $this->db->query( $sql );

		return $query->result_array();
	}


	public function get_ultima_empresa_referente($id_crm_persona)
	{
		$sql =	"	SELECT max(ID_CRM_PERSONA), id_empresa, id_crm_persona, D_EMPRESA
					FROM CRM_REFERENTE_EMPRESA re
					     INNER JOIN EMPRESAS e on re.id_empresa = e.n_id_empresa
					WHERE  re.id_crm_persona = ?
					GROUP BY id_crm_persona, id_empresa, id_crm_persona, D_EMPRESA  "  ;

		$query = $this->db->query( $sql, array($id_crm_persona) );

		return $query->row();
	}

	/*
	public function get_ultima_empresa_referente($id_crm_persona)
	{
		$sql =	"	SELECT em.* , decode(em.ID_EMPRESA, NULL, em.EMPRESA, e.D_EMPRESA) as NOMBRE
					FROM CRM_PERSONA_EMPRESA em
					     INNER JOIN (
					                  SELECT MAX(id_crm_persona_empresa) as id_crm_persona_empresa
					                  FROM 	V_CRM_REFERENTES re
					                        INNER JOIN CRM_PERSONA_EMPRESA pe ON pe.id_crm_persona = re.id_crm_persona 
					                  WHERE
					                       re.id_crm_persona = ?
					                ) ul ON ul.id_crm_persona_empresa  =  em.id_crm_persona_empresa
					     INNER JOIN empresas e ON em.id_empresa = e.n_id_empresa
									   	"  ;

		$query = $this->db->query( $sql, array($id_crm_persona) );

		return $query->row();
	} 
	*/

	/*
	public function get_informacion_empresa_referente($id_crm_persona_empresa)
	{
		$sql =	"	SELECT *
					FROM CRM_PERSONA_EMPRESA em 
						INNER JOIN empresas e ON em.id_empresa = e.n_id_empresa
					WHERE em.id_crm_persona_empresa =  ?
				"  ;

		$query = $this->db->query( $sql, array($id_crm_persona_empresa) );

		return $query->row();
	}
	*/

	public function get_informacion_empresa_referente( $id_empresa, $id_crm_persona )
	{
		$sql =	"	SELECT *
					FROM CRM_REFERENTE_EMPRESA em 
						INNER JOIN empresas e ON em.id_empresa = e.n_id_empresa
					WHERE em.id_empresa =  ?
					AND em.id_crm_persona = ?
				"  ;

		$query = $this->db->query( $sql, array( $id_empresa, $id_crm_persona ) );

		return $query->row();
	}




	public function get_alarmas()
	{
		$sql =	"	SELECT ea.*, TO_CHAR(ea.FECHA, 'YYYY-MM-DD') as fecha_accion, p.NOMBRE, p.APELLIDO, e.D_EMPRESA 
					FROM CRM_ACCION ea
					     LEFT JOIN CRM_PERSONA p ON ea.ID_CRM_PERSONA = p.ID_CRM_PERSONA
					     LEFT JOIN CRM_ACCION_RESULTADO ear ON ea.id_crm_accion = ear.id_crm_accion
					     LEFT JOIN EMPRESAS e ON ea.id_empresa = e.N_ID_EMPRESA
					WHERE
					     	ea.alarma = 1 
					AND		ear.fecha IS NULL"  ;


		$query = $this->db->query( $sql );

		return $query->result_array();
	}

	public function get_all_acciones()
	{
		$sql =	"	SELECT  ea.*, TO_CHAR(ea.FECHA, 'YYYY-MM-DD') as fecha_accion, pe.NOMBRE, pe.APELLIDO 
					FROM 	CRM_ACCION ea
					        INNER JOIN V_CRM_REFERENTES pe ON ea.ID_CRM_PERSONA = pe.ID_CRM_PERSONA
					  "  ;
 

		$query = $this->db->query( $sql );

		return $query->result_array();
	}

	public function get_ultimas_acciones()
	{
		$sql =	"	SELECT  ea.*, TO_CHAR(ea.FECHA, 'YYYY-MM-DD') as fecha_accion, 
							pe.NOMBRE, pe.APELLIDO,
							ear.descripcion as descripcion_resultado, ear.fecha as fecha_resultado 
					FROM 	CRM_ACCION ea
					        LEFT JOIN CRM_ACCION_RESULTADO ear ON ea.id_crm_accion = ear.id_crm_accion
					    	LEFT JOIN EMPRESAS e ON ea.id_empresa = e.N_ID_EMPRESA
					        LEFT JOIN CRM_PERSONA pe ON ea.ID_CRM_PERSONA = pe.ID_CRM_PERSONA
					ORDER BY ea.fecha DESC
					OFFSET 0 ROWS FETCH NEXT 500 ROWS ONLY"  ;
 

		$query = $this->db->query( $sql );

		return $query->result_array();
	}



	public function get_informacion_accion($id_crm_accion)
	{
		$sql =	"	SELECT  ea.*, TO_CHAR(ea.FECHA, 'YYYY-MM-DD') as fecha_accion, pe.NOMBRE, pe.APELLIDO, ear.descripcion as descripcion_resultado, ear.fecha as fecha_resultado 
					FROM 	CRM_ACCION ea
					        LEFT JOIN CRM_PERSONA pe ON ea.ID_CRM_PERSONA = pe.ID_CRM_PERSONA
					        LEFT JOIN CRM_ACCION_RESULTADO ear ON ea.id_crm_accion = ear.id_crm_accion
					    	LEFT JOIN EMPRESAS e ON ea.id_empresa = e.N_ID_EMPRESA
					WHERE 
					        ea.id_crm_accion = ?
					  "  ;
 

		$query = $this->db->query( $sql, array( $id_crm_accion ) );

		return $query->row();
	}


	public function traer_referencias_persona($id_persona)
	{
		$sql =	"	SELECT  *
					FROM  CRM_REFERENTE_EMPRESA re,
					      empresas e
					WHERE 
					      	re.id_empresa = e.n_id_empresa
					AND		re.id_crm_persona = ?
				"  ;
 

		$query = $this->db->query( $sql , array($id_persona) );

		return $query->result_array();
	}



	public function get_acciones_empresa($id_empresa)
	{
		$sql =	"	SELECT  ea.*, TO_CHAR(ea.FECHA, 'YYYY-MM-DD') as fecha_accion
					FROM 	CRM_ACCION ea
				   	WHERE   ea.id_empresa = ? "  ; 
		
		$query = $this->db->query( $sql, array($id_empresa) );

		chrome_log(	"	SELECT  ea.*, TO_CHAR(ea.FECHA, 'YYYY-MM-DD') as fecha_accion
					FROM 	CRM_ACCION ea
				   	WHERE   ea.id_empresa =   ".$id_empresa);

		return $query->result_array();
	}

	public function get_acciones_referente($id_crm_persona)
	{
		$sql =	"	SELECT  ea.*, TO_CHAR(ea.FECHA, 'YYYY-MM-DD') as fecha_accion, 
		                     ear.fecha as fecha_resultado, ear.descripcion as descripcion_resultado,
		                     e.D_EMPRESA
					FROM 	CRM_ACCION ea
							LEFT JOIN CRM_ACCION_RESULTADO ear ON ea.id_crm_accion = ear.id_crm_accion
					    	LEFT JOIN EMPRESAS e ON ea.id_empresa = e.N_ID_EMPRESA
				   	WHERE   ea.id_crm_persona = ? 
				   	ORDER BY fecha_accion DESC"  ; 
		
		$query = $this->db->query( $sql, array($id_crm_persona) );

 

		return $query->result_array();
	}


	public function get_acciones_empresa_referente($id_empresa, $id_crm_persona)
	{
		$sql =	"	SELECT  ea.*, TO_CHAR(ea.FECHA, 'YYYY-MM-DD') as fecha_accion, ear.fecha as fecha_resultado, ear.descripcion as descripcion_resultado
					FROM 	CRM_ACCION ea
					        LEFT JOIN CRM_ACCION_RESULTADO ear ON ea.id_crm_accion = ear.id_crm_accion
				   	WHERE   ea.id_empresa = ? 
				   	AND     ea.id_crm_persona = ? "  ; 
		
		$query = $this->db->query( $sql, array($id_empresa, $id_crm_persona) );
 

		return $query->result_array();
	}

	public function abm_referente($accion, $array, &$cadena = null)
	{
		$cadena = "";

		switch ($accion):

			case 'A':

					$this->load->model('Contacto_model');
					$CI =& get_instance();

					// Esta en CRM
					if( isset($array['id_crm_persona_encontrado']) && !empty($array['id_crm_persona_encontrado'])   ):

						$cadena .= "El usuario ya estaba en CRM.";

						$id_crm_persona = $array['id_crm_persona_encontrado'];

						if($array['flag_no_es_referente']): // NO ES REFERENTE
							
							$cadena .= " El usuario ya era referente.";

							//  Alta referente
							$array_referente['id_crm_persona'] = $array['id_crm_persona_encontrado'];
							
							if( isset($array['id_empresa']) && !empty($array['id_empresa']) ){
								$this->db->insert('CRM_REFERENTE_EMPRESA',$array_referente);
								$array_referente['id_empresa'] = $array['id_empresa']; 
							}
							else
								$array_referente['id_camara'] = $array['id_camara']; 

							

						endif;

					else: // No esta en CRM

						// 	Alta persona
						$id_crm_persona = $CI->Contacto_model->alta_crm_persona( 	$array['apellido'],
																	    			$array['nombre']
																				);

						// 	Alta email
						if( isset($array['email']) && !empty($array['email'])  ):

							$array_email['id_crm_persona'] = $id_crm_persona;
							$array_email['email'] = $array['email'];
							$array_email['id_tipo_email'] = 4;
							$this->Contacto_model->abm_email(  'A', $array_email  );

						endif;

						// 	Alta Telefono
						if( isset($array['telefono']) && !empty($array['telefono'])  ):


							$array_telefono['id_crm_persona'] = $id_crm_persona;
							$array_telefono['telefono'] =  $array['telefono'];
							$array_telefono['id_tipo_telefono'] = 1;
							$this->Contacto_model->abm_telefono(  'A', $array_telefono  );

						endif;

						//  Alta referente
						$array_referente['id_crm_persona'] = $id_crm_persona;
						
						if( isset($array['id_empresa']) && !empty($array['id_empresa']) )
							$array_referente['id_empresa'] = $array['id_empresa']; 
						else
							$array_referente['id_camara'] = $array['id_camara']; 


						if( $this->db->insert('CRM_REFERENTE_EMPRESA',$array_referente))
							$cadena .= "Usuario cargado exitosamente.";
						else
							$cadena .= "Error al cargar el usuario, intente más tarde.";

				
					endif;

					$CI->Contacto_model->insertar_log_persona( 21 , $id_crm_persona );

					return  $id_crm_persona;

					break;

			case 'B':

					$array_where = array(  'id_crm_persona' => $array['id_crm_persona'] );

					$array_datos = array();

					$array_datos['ENABLED'] = 0;

					$this->db->where($array_where);
					$this->db->update('CRM_REFERENTE_EMPRESA', $array_datos);

					return $this->db->affected_rows();
				
					break;

		endswitch;


		return $this->db->affected_rows();
	}
	/*
	public function abm_referente($accion, $array, &$cadena = null)
	{
		$cadena = "";

		switch ($accion):

			case 'A':

					$this->load->model('Contacto_model');
					$CI =& get_instance();

					// Esta en CRM
					if( isset($array['id_crm_persona_encontrado']) && !empty($array['id_crm_persona_encontrado'])   ):

						$cadena .= "El usuario ya estaba en CRM.";

						$id_crm_persona = $array['id_crm_persona_encontrado'];

						if($array['flag_no_es_referente']): // NO ES REFERENTE
							
							$cadena .= " El usuario ya era referente.";

							//  Alta referente
							$array_referente['id_crm_persona'] = $array['id_crm_persona_encontrado'];
							$this->db->insert('CRM_REFERENTE_EMPRESA',$array_referente);

						endif;

					else: // No esta en CRM

						// 	Alta persona
						$id_crm_persona = $CI->Contacto_model->alta_crm_persona( 	$array['apellido'],
																	    			$array['nombre']
																				);

						//  Alta referente
						$array_referente['id_crm_persona'] = $id_crm_persona;

						if( $this->db->insert('CRM_REFERENTE_EMPRESA',$array_referente))
							$cadena .= "Usuario cargado exitosamente.";
						else
							$cadena .= "Error al cargar el usuario, intente más tarde.";

						// 	Alta email
						if( isset($array['email']) && !empty($array['email'])  ):

							$array_email['id_crm_persona'] = $id_crm_persona;
							$array_email['email'] = $array['email'];
							$array_email['id_tipo_email'] = 4;
							$this->Contacto_model->abm_email(  'A', $array_email  );

						endif;

						// 	Alta Telefono
						if( isset($array['telefono']) && !empty($array['telefono'])  ):


							$array_telefono['id_crm_persona'] = $id_crm_persona;
							$array_telefono['telefono'] =  $array['telefono'];
							$array_telefono['id_tipo_telefono'] = 1;
							$this->Contacto_model->abm_telefono(  'A', $array_telefono  );

						endif;

					endif;


					// 	Alta empresa referente

					if( isset($array['id_empresa']) && !empty($array['id_empresa'])  ):

						if( ! $this->Contacto_model->existe_empresa_persona_crm($id_crm_persona, $array['id_empresa']) ):

							$array_empresa['id_crm_persona'] = $id_crm_persona;
							$array_empresa['id_empresa'] =  $array['id_empresa']; 
							$array_empresa['cargo'] =  $array['cargo']; 
							$this->Contacto_model->abm_experiencia_laboral('A', $array_empresa); 

						else:

							$cadena .= "El usuario ya tiene cargada la empresa. ";

						endif;


					endif;

					$CI->Contacto_model->insertar_log_persona( 21 , $id_crm_persona );

					return  $id_crm_persona;

					break;

			case 'B':

					$array_where = array(  'id_crm_persona' => $array['id_crm_persona'] );

					$array_datos = array();

					$array_datos['ENABLED'] = 0;

					$this->db->where($array_where);
					$this->db->update('CRM_REFERENTE_EMPRESA', $array_datos);

					return $this->db->affected_rows();
				
					break;

		endswitch;


		return $this->db->affected_rows();
	}*/
	/*

	public function abm_empresa_referente($accion, $array)
	{
		switch ($accion):

			case 'A':

				// Busco el id_crm_persona_empresa  

					$this->load->model('Contacto_model');
					$CI =& get_instance();

				// 	Alta persona
					$id_crm_persona = $CI->Contacto_model->alta_crm_persona( 	$array['apellido'],
																			    $array['nombre']
																			);

				//  Alta referente

					$array_referente['id_crm_persona'] = $id_crm_persona;
					$this->db->insert('CRM_ACCION',$array_referente);


				// 	Alta email

					if( isset($array['email']) && !empty($array['email'])  ):

						$array_email['id_crm_persona'] = $id_crm_persona;
						$array_email['email'] = $array['email'];
						$array_email['id_tipo_email'] = 4;
						$this->Contacto_model->abm_email(  'A', $array_email  );

					endif;

				// 	Alta Telefono

					if( isset($array['telefono']) && !empty($array['telefono'])  ):

						$array_telefono['id_crm_persona'] = $id_crm_persona;
						$array_telefono['telefono'] =  $array['telefono'];
						$array_telefono['id_tipo_telefono'] = 1;
						$this->Contacto_model->abm_telefono(  'A', $array_telefono  );

					endif;

					return  $id_crm_persona;

				break;

		endswitch;


		return $this->db->affected_rows();
	}*/

	public function abm_empresa_referente($accion, $array)
	{
		switch ($accion):

			case 'A':

 				//  Alta referente

					$array_referente['id_crm_persona'] = $array['id_crm_persona'];
					$array_referente['id_empresa'] = $array['id_empresa'];

					if( isset($array['cargo']) && !empty($array['cargo'])  )
						$array_referente['CARGO'] = $array['cargo'] ;


					if( $this->db->insert('CRM_REFERENTE_EMPRESA',$array_referente) )
						return true;
					else
						return false;

				break;

			case 'B':

					$array_where = array(  
							'ID_EMPRESA' => $array['id_empresa'],
							'ID_CRM_PERSONA' => $array['id_crm_persona']
						);

					$array_datos = array();

					$array_datos['ENABLED'] = 0;
 
					$this->db->where($array_where);
					$this->db->update('CRM_REFERENTE_EMPRESA', $array_datos);

					return $this->db->affected_rows();

				break;

		endswitch;


		return $this->db->affected_rows();
	}

	public function abm_accion_empresa($accion, $array)
	{
		switch ($accion):

			case 'A':

					$this->db->set('ID_CRM_ACCION', "id_crm_accion.nextval", false);
			
					$fecha= $array['fecha_accion'] ;
					$this->db->set('FECHA',"to_date('$fecha','yyyy-mm-dd')",false);
					$array_accion['DESCRIPCION'] = $array['descripcion'];

					if( isset($array['id_empresa']) && !empty($array['id_empresa'])  )
						$array_accion['ID_EMPRESA'] = $array['id_empresa'] ;

					if( isset($array['id_camara']) && !empty($array['id_camara'])  )
						$array_accion['ID_CAMARA'] = $array['id_camara'] ;

					// 	Alarma

					if( isset($array['alarma']) && !empty($array['alarma']) )
						$array_accion['ALARMA'] = 1 ;


					if( isset($array['id_crm_persona']) && !empty($array['id_crm_persona'])  )
						$array_accion['ID_CRM_PERSONA'] = $array['id_crm_persona'] ;
					
					$resultado = $this->db->insert('CRM_ACCION',$array_accion);

					return  $resultado;

				break;

			case 'M':

					$array_where = array(  'id_crm_accion' => $array['id_crm_accion'] );

					$array_datos = array();

					$array_datos['DESCRIPCION'] = $array['descripcion'];

					if( isset($array['alarma']) && !empty($array['alarma'])  ):

						$array_datos['ALARMA'] = 1 ;

					else:

						$array_datos['ALARMA'] = 0 ;

					endif;


					$this->db->where($array_where);
					$this->db->update('CRM_ACCION', $array_datos);

					return $this->db->affected_rows();

				break;

			case 'B':

					$array_where = array(  'id_crm_accion' => $array['id_crm_accion'] );
 
					$this->db->delete('CRM_ACCION', $array_where);

					return $this->db->affected_rows();
				
				break;

		endswitch;


		return $this->db->affected_rows();
	}

	public function abm_camara($accion, $array)
	{
		switch ($accion):

			case 'A':

					$this->db->set('ID_CAMARA', "ID_CAMARA.nextval", false);

					$array_camara['NOMBRE'] = $array['nombre'] ;
					
					$resultado = $this->db->insert('CRM_CAMARA_ASOCIACION',$array_camara);

					return  $resultado;

				break;

			case 'M':

					$array_where = array(  'ID_CAMARA' => $array['id_camara'] );

					$array_datos = array();

					$array_datos['NOMBRE'] = $array['NOMBRE'];
 
					$this->db->where($array_where);
					$this->db->update('CRM_CAMARA_ASOCIACION', $array_datos);

					return $this->db->affected_rows();

				break;

			case 'B':

					$array_where = array(  'id_crm_accion' => $array['id_crm_accion'] );
 
					$this->db->delete('CRM_CAMARA_ASOCIACION', $array_where);

					return $this->db->affected_rows();
				
				break;

		endswitch;


		return $this->db->affected_rows();
	}

	public function persona_es_referente($id_crm_persona)
	{
		$sql =	"	SELECT  *
					FROM 	V_CRM_REFERENTES re
					WHERE   re.id_crm_persona = ? "  ;

		$query = $this->db->query( $sql , array( $id_crm_persona ) );

		if($query->num_rows() > 0)
			return true;
		else
			return false;
	}

	
 	public function abm_accion_resultado($accion, $array)
	{
		switch ($accion):

			case 'A':
					chrome_log("abm_accion_resultado A");

					$this->db->set('ID_CRM_ACCION_RESULTADO', "ID_CRM_ACCION_RESULTADO.nextval", false);
					$array_accion['ID_CRM_ACCION'] = $array['id_crm_accion'] ;

					// 	DESCRIPCION
					if( isset($array['descripcion_finalizar_alarma']) && !empty($array['descripcion_finalizar_alarma'])  ):

						$array_accion['DESCRIPCION'] = $array['descripcion_finalizar_alarma'] ;

					endif;
 					
					
					$resultado = $this->db->insert('CRM_ACCION_RESULTADO',$array_accion);

					return  $resultado;

				break;

			case 'M':

					$array_where = array(  'ID_CRM_ACCION_RESULTADO' => $array['id_crm_accion_resultado'] );

					$array_datos = array();

					$array_datos['DESCRIPCION'] = $array['descripcion'];

					if( isset($array['alarma']) && !empty($array['alarma'])  ):

						$array_datos['ALARMA'] = 1 ;

					else:

						$array_datos['ALARMA'] = 0 ;

					endif;


					$this->db->where($array_where);
					$this->db->update('CRM_ACCION', $array_datos);

					return $this->db->affected_rows();

				break;

			case 'B':

					$array_where = array(  'id_crm_accion' => $array['id_crm_accion'] );
 
					$this->db->delete('CRM_ACCION', $array_where);

					return $this->db->affected_rows();
				
				break;

		endswitch;


		return $this->db->affected_rows();
	}

	public function existe_refente_crm($id_crm_persona)
	{
		chrome_log("Consulta_model/existe_persona_crm");

		$sql =	"	SELECT  *
	    			FROM	V_CRM_REFERENTES re
	    			WHERE 	re.ID_CRM_PERSONA = ?
	    			AND 	re.ENABLED = 1 "  ;

		$query = $this->db->query($sql, array($id_crm_persona));

		if($query->num_rows() > 0)
			return false;
		else
			return true;
	}

}

/* End of file  */
/* Location: ./application/models/ */