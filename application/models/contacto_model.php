<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contacto_model extends CI_Model {

//public $variable;

public function __construct()
{

	parent::__construct();
	$this->load->model('Consulta_model');
}


//----------- CONTACTO WEB --------------------------

public function traer_informacion_contacto_web($id_contacto_web)
{
	//
	$sql =	"	SELECT cw.*, pi.id_periodo, pi.anio
				FROM  CRM_CONTACTO_WEB cw
					  LEFT JOIN  CRM_CONTACTO_WEB_PER_ING pi ON pi.ID_CONTACTO_WEB = cw.ID_CONTACTO_WEB
				WHERE cw.ID_CONTACTO_WEB = ? "  ;


	$query = $this->db->query( $sql , array($id_contacto_web) );

	return $query->row();
}

public function traer_informacion_crm_sigeu_persona($id_crm_persona) // Trae informacion de un contacto sea de CRM o de SIGEU.
{
	$this->db->trans_start();

	//---- Informacion de usuario ----

	$datos_usuario = $this->traer_informacion_crm_persona($id_crm_persona);
	$datos_usuario->ID_CRM_PERSONA = $id_crm_persona;

 	if(isset($datos_usuario->ID_PERSONA) && !empty($datos_usuario->ID_PERSONA)): 	//  --- SIGEU ---

 		$datos_usuario = $this->traer_informacion_persona($datos_usuario->ID_PERSONA);
 		$datos_usuario->ID_CRM_PERSONA = $id_crm_persona;

 		// Educacion
 		$datos_educacion = $this->traer_educacion_sigeu($datos_usuario->ID_PERSONA);

 		// Emails
 		$datos_emails = $this->traer_emails_sigeu($datos_usuario->ID_PERSONA);

 		// Telefono
 		$datos_telefonos = $this->traer_telefonos_sigeu($datos_usuario->ID_PERSONA);

		// Documentos
 		$datos_documentos = $this->traer_documentos_sigeu($datos_usuario->ID_PERSONA);

 		// Experiencia laboral
 		$datos_experiencia_laboral = $this->traer_experiencia_laboral_sigeu($datos_usuario->ID_PERSONA);

 	else: 																			// --- CRM ---

 		// Educacion
 		$datos_educacion = $this->traer_educacion_crm($id_crm_persona);

 		// Emails
 		$datos_emails = $this->traer_emails_crm($id_crm_persona);

 		// Telefono
 		$datos_telefonos = $this->traer_telefonos_crm($id_crm_persona);

 		// Documentos
 		$datos_documentos = $this->traer_documentos_crm($id_crm_persona);

		// Experiencia laboral
 		$datos_experiencia_laboral = $this->traer_experiencia_laboral_crm($id_crm_persona);

 	endif;

 	$informacion['datos_usuario'] = $datos_usuario;
 	$informacion['datos_educacion'] = $datos_educacion;
 	$informacion['datos_emails'] = $datos_emails;
 	$informacion['datos_telefonos'] = $datos_telefonos;
 	$informacion['datos_documentos'] = $datos_documentos;
 	$informacion['datos_experiencia_laboral'] = $datos_experiencia_laboral;

 	//print_r($datos_usuario);

	$this->db->trans_complete();

	if ($this->db->trans_status() === FALSE)
	{
	    return false;
	}
	else
	{
   		return $informacion;
	}
}

public function traer_informacion_consultas_persona($id_crm_persona)
{
	$this->db->trans_start();

	//---- Informacion de las consultas ----

 	$array_consultas_usuario = array();

 	$consultas = $this->traer_consultas_crm_persona($id_crm_persona);

 	//var_dump($consultas);

 	if( $consultas->num_rows() > 0 ):

 		foreach($consultas->result() as $row):

 			//var_dump($row);
 			// Informacion consulta
 			//echo "CONSULTA: ".$row->ID_CRM_CONSULTA;
 			$consultas_array['informacion_consulta'] = $row;

 			// Programas de la consulta
 			$consultas_array['programas_consulta'] = $this->Consulta_model->traer_programas_consulta($row->ID_CRM_CONSULTA);

 			// Contactenme consulta
 			$consultas_array['contactenme_consulta'] = $this->Consulta_model->traer_contactenme_consulta($row->ID_CRM_CONSULTA);

 			// Informacion de interes
 			$consultas_array['info_interes_consulta'] = $this->Consulta_model->traer_info_interes_consulta($row->ID_CRM_CONSULTA);

 			array_push($array_consultas_usuario, $consultas_array);

	 	endforeach;

 	endif;

 	$this->db->trans_complete();

	if ($this->db->trans_status() === FALSE)
	{
	    $this->db->trans_rollback();
	    return false;
	}
	else
	{
	    $this->db->trans_commit();
    	return $array_consultas_usuario;
	}
}

//---------- CONTACTO WEB ----------

public function traer_prg_interes_contacto($id_contacto)
{

	$sql =	"	SELECT *
				FROM CRM_CONTACTO_WEB_PRG_INT pi
				WHERE pi.ID_CONTACTO_WEB =  ? "  ;

	$query = $this->db->query( $sql , array($id_contacto) );

	return $query;
}

public function traer_contactenlo_contacto($id_contacto)
{

	$sql =	"	SELECT *
				FROM CRM_CONTACTO_WEB_CONTACTENLO cwc
				WHERE cwc.ID_CONTACTO_WEB =  ? "  ;

	$query = $this->db->query( $sql , array($id_contacto) );

	return $query;
}

public function traer_info_interes_contacto($id_contacto)
{

	$sql =	"	SELECT *
				FROM CRM_CONTACTO_WEB_INFO_INTERES cwii
				WHERE cwii.ID_CONTACTO_WEB =  ? "  ;

	$query = $this->db->query( $sql , array($id_contacto) );

	return $query;
}

public function eliminar_contacto_web($id_contacto_web)
{

	$this->db->trans_start();

	// BORRAR LAS INFORMACIONES DE INTERES
	$this->db->delete('CRM_CONTACTO_WEB_INFO_INTERES', array('id_contacto_web' => $id_contacto_web));

	// BORRAR LAS FORMAS DE CONTACTO
	$this->db->delete('CRM_CONTACTO_WEB_CONTACTENLO', array('id_contacto_web' => $id_contacto_web));

	// BORRAR LOS PROGRAMAS DE ITNERES
	$this->db->delete('CRM_CONTACTO_WEB_PRG_INT', array('id_contacto_web' => $id_contacto_web));

	// BORRAR EL PERIODO DE INGRESO
	$this->db->delete('CRM_CONTACTO_WEB_PER_ING', array('id_contacto_web' => $id_contacto_web));

	// BORRAR EL CONTACTO WEB
	$this->db->delete('CRM_CONTACTO_WEB', array('id_contacto_web' => $id_contacto_web));


 	$this->db->trans_complete();

 	if ($this->db->trans_status() === FALSE)
	{
	    $this->db->trans_rollback();
	    return false;
	}
	else
	{
	    $this->db->trans_commit();
	    return true;
	}
}

//----- BUSCAR EN SIGEU ----

public function buscar_email_en_sigeu($email)
{

	$sql =	utf8_decode("	SELECT c.N_ID_PERSONA
			    			FROM CORREOS c
			    			WHERE c.C_EMAIL = ? ")  ;

	$query = $this->db->query( $sql , array($email) );


	if($query->num_rows() > 0)
		return $query->row()->N_ID_PERSONA;
	else
		return false;
}

public function buscar_telefono_en_sigeu($telefono)
{

	$sql =	utf8_decode("	SELECT t.N_ID_PERSONA
			    			FROM TELEFONOS t
			    			WHERE replace(TRANSLATE(t.N_TELEFONO,'-()','   '),' ','') = ? ");

	$query = $this->db->query( $sql , array($telefono) );


	if($query->num_rows() > 0)
		return $query->row()->N_ID_PERSONA;
	else
		return false;
}

public function buscar_nombre_apellido_en_sigeu($apellido, $nombre)
{
	$apellido = limpiar_cadena($apellido);
	$apellido = strtoupper($apellido);
	$apellido = str_replace(" ", "%", $apellido);
	$apellido = str_replace("ñ", "Ñ", $apellido);

	$nombre = limpiar_cadena($nombre);
	$nombre = strtoupper($nombre);
	$nombre = str_replace(" ", "%", $nombre);
	$nombre = str_replace("ñ", "Ñ", $nombre);


	$sql =	utf8_decode("	SELECT p.N_ID_PERSONA
			    			FROM personas p
			    			WHERE TRANSLATE(upper(P.d_apellidos),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE '%$apellido%'
			    			AND   TRANSLATE(upper(P.d_nombres),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE '%$nombre%'  ");

	$query = $this->db->query( $sql );

	//echo $query->row()->N_ID_PERSONA;

	if($query->num_rows() > 0)
		return $query->row()->N_ID_PERSONA;
	else
		return false;
}

public function traer_informacion_persona($id_persona)
{
	$sql =	"	SELECT 	p.N_ID_PERSONA as ID_USUARIO,
						p.D_NOMBRES as nombre,
						p.D_APELLIDOS as apellido,
						p.F_NACIMIENTO as fecha_nacimiento,
						p.N_DOCUMENTO as documento,
						BUSCO_TELEFONOS(p.N_ID_PERSONA) as telefonos,
						DEVUELVE_MAILS(p.N_ID_PERSONA) as emails,
						'SIGEU' as origen,
						p.N_ID_PERSONA as ID_PERSONA,
						F_ALTA as FECHA_ALTA,
						cp.ID_CRM_PERSONA,
						M_SEXO as SEXO
    			FROM personas p
    				 LEFT JOIN crm_persona cp ON p.N_ID_PERSONA = cp.ID_PERSONA
    			WHERE p.N_ID_PERSONA = ? "  ;

	$query = $this->db->query( $sql , array($id_persona) );



	return $query->row();
}



public function buscar_coincidencia_en_sigeu($usuario)
{
 	chrome_log2("buscar_coincidencia_en_sigeu");

	$apellido = limpiar_cadena($usuario->APELLIDO);
	$apellido = strtoupper($apellido);
	$apellido = str_replace(" ", "%", $apellido);
	$apellido = str_replace("ñ", "Ñ", $apellido);

	$nombre = limpiar_cadena($usuario->NOMBRE);
	$nombre = strtoupper($nombre);
	$nombre = str_replace(" ", "%", $nombre);
	$nombre = str_replace("ñ", "Ñ", $nombre);

	$email = utf8_decode($usuario->EMAIL);

	$telefono = preg_replace("/[^0-9]/", "", $usuario->TELEFONO);

	chrome_log2("	SELECT  DISTINCT(p.n_id_persona)
							FROM 	personas p
									LEFT JOIN correos c ON c.N_ID_PERSONA = p.N_ID_PERSONA
							  		LEFT JOIN telefonos t ON t.N_ID_PERSONA = p.N_ID_PERSONA
							WHERE c.C_EMAIL = '$email'
							OR 	  REGEXP_REPLACE(  t.N_TELEFONO, '[^0-9]', '') = '$telefono'
							OR    (           TRANSLATE(upper(P.D_APELLIDOS),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE '%$apellido%'
							             AND  TRANSLATE(upper(P.D_NOMBRES),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE '%$nombre%'
							      )
						");


	$sql =	utf8_decode(
						"	SELECT  DISTINCT(p.n_id_persona)
							FROM 	personas p
									LEFT JOIN correos c ON c.N_ID_PERSONA = p.N_ID_PERSONA
							  		LEFT JOIN telefonos t ON t.N_ID_PERSONA = p.N_ID_PERSONA
							WHERE c.C_EMAIL = '$email'
							OR 	  REGEXP_REPLACE(  t.N_TELEFONO, '[^0-9]', '') = '$telefono'
							OR    (           TRANSLATE(upper(P.D_APELLIDOS),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE '%$apellido%'
							             AND  TRANSLATE(upper(P.D_NOMBRES),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE '%$nombre%'
							      )
						" )  ;

	$query = $this->db->query( $sql );


	if($query->num_rows() > 0)
		return $query;
	else
		return false;
}

public function traer_educacion_sigeu($id_persona)
{
	$sql =	   "	SELECT
				      	decode(ed.N_ID_ESTABLEC, NULL, ed.D_ESTABLECIMIENTO, em.D_EMPRESA) as NOMBRE,
				      	decode(c_nivel, 'Secundario', 0, decode(c_nivel,'Universitario', 1,2)) as ID_NIVEL_EDUCACION,
				      	c_nivel as descripcion,
				      	C_CARRERA as carrera
				FROM 	educacion ed
				     	LEFT JOIN EMPRESAS em ON ed.N_ID_ESTABLEC = em.N_ID_EMPRESA
				WHERE
						ed.N_ID_PERSONA = ? "  ;

	$query = $this->db->query( $sql , array($id_persona) );

	return $query->result_array();
}

public function traer_experiencia_laboral_sigeu($id_persona)
{
	$sql =	utf8_decode("	SELECT  decode(o.N_ID_EMPRESA, NULL, o.D_EMPRESA, em.D_EMPRESA) as NOMBRE,
									N_ID_OCUPACION as id,
									D_CARGO as cargo,
									D_DESCRIP as descripcion_cargo
							FROM 	ocupaciones o
							     	LEFT JOIN EMPRESAS em ON o.N_ID_EMPRESA = em.N_ID_EMPRESA
							WHERE
									o.N_ID_PERSONA = ? " ) ;

	$query = $this->db->query( $sql , array($id_persona) );

	return $query->result_array();
}

public function traer_emails_sigeu($id_persona)
{
	$sql =	utf8_decode("	SELECT C_EMAIL as email
			    			FROM CORREOS
			    			WHERE N_ID_PERSONA = ? ")  ;

	$query = $this->db->query( $sql , array($id_persona) );

	return $query->result_array();
}

public function traer_telefonos_sigeu($id_persona)
{
	$sql =	utf8_decode("	SELECT N_TELEFONO as telefono
			    			FROM TELEFONOS
			    			WHERE N_ID_PERSONA = ? ")  ;

	$query = $this->db->query( $sql , array($id_persona) );

	return $query->result_array();
}

public function traer_documentos_sigeu($id_persona)
{
	$sql =	utf8_decode("	SELECT C_TIPO_DOCUMENTO as tipo, N_DOCUMENTO as numero, C_PASAPORTE
							FROM personas
							WHERE N_ID_PERSONA = ? ")  ;

	$query = $this->db->query( $sql , array($id_persona) );

	return $query->result_array();

}
public function traer_nombre_educacion($id_educacion)
{
	$sql =	utf8_decode("	SELECT D_EMPRESA
							FROM empresas
							WHERE N_ID_EMPRESA = ? ")  ;

	$query = $this->db->query( $sql , array($id_educacion) );

	return $query->row()->D_EMPRESA;
}



//---- BUSCAR EN CRM ----

public function buscar_email_en_crm($email)
{
	chrome_log2("buscar_email_en_crm");

	chrome_log2("SELECT c.ID_CRM_PERSONA
			    			FROM CRM_PERSONA_EMAIL c
			    			WHERE c.EMAIL = $email");

	$sql =	utf8_decode("	SELECT c.ID_CRM_PERSONA
			    			FROM CRM_PERSONA_EMAIL c
			    			WHERE c.EMAIL = ? ")  ;

	$query = $this->db->query( $sql , array($email) );


	if($query->num_rows() > 0)
		return $query->row()->ID_CRM_PERSONA;
	else
		return false;
}

public function buscar_telefono_en_crm($telefono)
{
	chrome_log2("buscar_telefono_en_crm");


	$sql =	utf8_decode("SELECT t.ID_CRM_PERSONA
			    			FROM CRM_PERSONA_TELEFONO t
			    			WHERE t.TELEFONO = ? ")  ;

	$query = $this->db->query( $sql , array($telefono) );


	if($query->num_rows() > 0)
		return $query->row()->ID_CRM_PERSONA;
	else
		return false;
}

public function buscar_nombre_apellido_en_crm($apellido, $nombre)
{
	$apellido = limpiar_cadena($apellido);
	$apellido = strtoupper($apellido);
	$apellido = str_replace(" ", "%", $apellido);
	$apellido = str_replace("ñ", "Ñ", $apellido);

	$nombre = limpiar_cadena($nombre);
	$nombre = strtoupper($nombre);
	$nombre = str_replace(" ", "%", $nombre);
	$nombre = str_replace("ñ", "Ñ", $nombre);


	$sql =	utf8_decode("	SELECT p.ID_CRM_PERSONA
			    			FROM CRM_PERSONA p
			    			WHERE TRANSLATE(upper(P.apellido),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE '%$apellido%'
			    			AND   TRANSLATE(upper(P.nombre),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE '%$nombre%' ");

	$query = $this->db->query( $sql );


	if($query->num_rows() > 0)
		return $query->row()->ID_CRM_PERSONA;
	else
		return false;
}

public function traer_informacion_crm_persona($id_crm_persona)
{
	$sql =	"	SELECT
				    cp.ID_CRM_PERSONA as ID_USUARIO,
				    cp.NOMBRE as nombre,
				    cp.APELLIDO as apellido,
				    NULL as fecha_nacimiento,
				    BUSCO_TELEFONOS_CRM(cp.ID_CRM_PERSONA) as telefonos,
				    DEVUELVE_MAILS_CRM(cp.ID_CRM_PERSONA) as emails,
				    'CRM' as origen,
				    CP.ID_PERSONA,
				    CP.FECHA_ALTA,
				    cp.ID_CRM_PERSONA,
				    SEXO
				FROM CRM_PERSONA cp
    			WHERE cp.ID_CRM_PERSONA = ?  "  ;

	$query = $this->db->query( $sql , array($id_crm_persona) );

	return $query->row();
}

public function traer_informacion_crm_persona_by_email($email)
{
	$sql =	"	SELECT
				    cp.ID_CRM_PERSONA as ID_USUARIO,
				    cp.NOMBRE as nombre,
				    cp.APELLIDO as apellido
				FROM CRM_PERSONA cp
					 INNER JOIN CRM_PERSONA_EMAIL CPE ON cp.id_crm_persona = cpe.id_crm_persona
    			WHERE cpe.email = ?  "  ;
 

	$query = $this->db->query( $sql , array($email) );

	return $query->row_array();
}

public function traer_educacion_crm($id_crm_persona)
{
	$sql =	utf8_decode("	SELECT  decode(pe.nombre, NULL, e.D_EMPRESA, pe.nombre ) as nombre,
				        pe.ID_EDUCACION_CRM, ne.descripcion, pe.id_nivel_educacion,
				        pe.ID_EMPRESA,
				        pe.CARRERA
				FROM CRM_PERSONA_EDUCACION pe
				     LEFT JOIN CRM_PERSONA_EDUCACION_NIVEL ne ON pe.ID_NIVEL_EDUCACION = ne.ID_NIVEL_EDUCACION
				     LEFT JOIN empresas e ON e.n_id_empresa = pe.id_empresa
    			WHERE pe.ID_CRM_PERSONA = ? ")  ;

	$query = $this->db->query( $sql , array($id_crm_persona) );

	return $query->result_array();
}

public function traer_experiencia_laboral_crm($id_crm_persona)
{
	$sql =	utf8_decode("	SELECT  decode(cpe.ID_EMPRESA, NULL, cpe.EMPRESA, e.D_EMPRESA) as NOMBRE,
									ID_CRM_PERSONA_EMPRESA as id,
									CARGO,
									DESCRIPCION as descripcion_cargo,
									EMPRESA,
									cpe.ID_EMPRESA
							FROM CRM_PERSONA_EMPRESA cpe
							     LEFT JOIN empresas e ON e.n_id_empresa = cpe.id_empresa
			    			WHERE cpe.ID_CRM_PERSONA = ? 
			    			AND    cpe.enabled = 1")  ;

	$query = $this->db->query( $sql , array($id_crm_persona) );

	return $query->result_array();
}

public function traer_emails_crm($id_crm_persona)
{
	$sql =	utf8_decode("	SELECT EMAIL, ID_EMAIL_CRM, ID_TIPO_EMAIL
			    			FROM CRM_PERSONA_EMAIL
			    			WHERE ID_CRM_PERSONA = ? ")  ;

	$query = $this->db->query( $sql , array($id_crm_persona) );

	return $query->result_array();
}

public function traer_telefonos_crm($id_crm_persona)
{
	$sql =	utf8_decode("	SELECT TELEFONO, ID_TELEFONO_CRM, ID_TIPO_TELEFONO
			    			FROM CRM_PERSONA_TELEFONO
			    			WHERE ID_CRM_PERSONA = ? ")  ;

	$query = $this->db->query( $sql , array($id_crm_persona) );

	return $query->result_array();
}

public function traer_documentos_crm($id_crm_persona)
{
	$sql =	utf8_decode("	SELECT cd.ID_CRM_DOCUMENTO, cd.ID_TIPO_DOCUMENTO , cd.NUMERO, td.descripcion as TIPO
			    			FROM CRM_PERSONA_DOCUMENTO cd, CRM_PERSONA_DOCUMENTO_TIPO td
			    			WHERE cd.ID_CRM_PERSONA = ?
							AND cd.ID_TIPO_DOCUMENTO = td.ID_TIPO_DOCUMENTO ")  ;

	$query = $this->db->query( $sql , array($id_crm_persona) );

	return $query->result_array();
}


//----- SIGEU Y CRM -----------------

public function traer_experiencia_laboral_by_id_empresa($id_crm_persona)
{
	$sql =	utf8_decode("	SELECT cd.ID_CRM_DOCUMENTO, cd.ID_TIPO_DOCUMENTO , cd.NUMERO, td.descripcion as TIPO
			    			FROM CRM_PERSONA_DOCUMENTO cd, CRM_PERSONA_DOCUMENTO_TIPO td
			    			WHERE cd.ID_CRM_PERSONA = ?
							AND cd.ID_TIPO_DOCUMENTO = td.ID_TIPO_DOCUMENTO ")  ;

	$query = $this->db->query( $sql , array($id_crm_persona) );

	return $query->result_array();
}


//----- CONTSULTAS---

public function traer_consultas_crm_persona($id_crm_persona)
{
	$sql =	"	SELECT cc.id_crm_consulta, cc.fecha as fecha_consulta, cc.id_medio_consulta, cc.COMENTARIO_CONSULTA, cc.id_crm_persona, ce.descripcion as estado_consulta,
	                 	 res.anio, res.id_periodo_ingreso, res.descripcion
	          	FROM crm_consulta cc
	          			INNER JOIN crm_consulta_estado ce ON cc.ID_ESTADO_CONSULTA = ce.ID_ESTADO_CONSULTA
	              	 	LEFT JOIN CRM_MEDIO_CONSULTA mc ON cc.ID_MEDIO_CONSULTA = mc.ID_MEDIO_CONSULTA
	              		LEFT JOIN (  SELECT *
	                    	        FROM CRM_CONS_PERIODO_INGRESO cpi,
	                        	         CRM_PERIODO_INGRESO pi
	                            	WHERE
	                                	cpi.ID_CRM_PERIODO = pi.ID_PERIODO_INGRESO) res ON cc.ID_CRM_CONSULTA = res.ID_CRM_CONSULTA
    			WHERE cc.ID_CRM_PERSONA = ?
    			ORDER BY cc.id_crm_consulta DESC"  ;

	$query = $this->db->query( $sql , array($id_crm_persona) );

	return $query;
}


public function buscar_coincidencia_en_crm($usuario)
{
 	chrome_log2("buscar_en_crm");

	$apellido = limpiar_cadena($usuario->APELLIDO);
	$apellido = strtoupper($apellido);
	$apellido = str_replace(" ", "%", $apellido);
	$apellido = str_replace("ñ", "Ñ", $apellido);

	$nombre = limpiar_cadena($usuario->NOMBRE);
	$nombre = strtoupper($nombre);
	$nombre = str_replace(" ", "%", $nombre);
	$nombre = str_replace("ñ", "Ñ", $nombre);

	$email = $usuario->EMAIL;
	$telefono = preg_replace("/[^0-9]/", "", $usuario->TELEFONO);

	$sql =	utf8_decode("	SELECT   	DISTINCT(p.ID_CRM_PERSONA)
			    			FROM 	CRM_PERSONA p
									LEFT JOIN CRM_PERSONA_EMAIL cpe ON p.id_crm_persona = cpe.id_crm_persona
									LEFT JOIN CRM_PERSONA_TELEFONO cpt ON p.id_crm_persona = cpt.id_crm_persona
			    			WHERE cpe.EMAIL = '$email'
			    			OR 	  REGEXP_REPLACE(  cpt.TELEFONO, '[^0-9]', '') = '$telefono'
			    			OR    (      TRANSLATE(upper(P.apellido),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE '%$apellido%'
			    					 AND TRANSLATE(upper(P.nombre),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE '%$nombre%'
			    				   )" )  ;

	$query = $this->db->query( $sql );


	if($query->num_rows() > 0)
		return $query;
	else
		return false;
}



public function buscar_contactos($array)
{
	$dato_buscado = $array['dato_buscado'];

	$buscar = strtoupper($dato_buscado);
	$buscar = str_replace(" ", "%", $buscar);
	$buscar = str_replace("ñ", "Ñ", $buscar);

	chrome_log2("SELECT DISTINCT res.Id, res.origen
			FROM
			    (
			    	SELECT  cp.ID_CRM_PERSONA as Id,
			            cp.NOMBRE as nombre,
			            cp.APELLIDO as apellido,
			            cpe.email as email,
			            'crm'as origen
				    FROM crm_persona cp
				         LEFT JOIN CRM_PERSONA_EMAIL cpe ON cpe.id_crm_persona = cp.id_crm_persona
				    WHERE
				          ( TRANSLATE(upper(cp.NOMBRE ),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE  '%$buscar%' )
				    OR    ( TRANSLATE(upper(cp.APELLIDO ),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE  '%$buscar%' )
				    OR    ( TRANSLATE(upper(cpe.email ),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE  '%$buscar%' )

				    UNION

				    SELECT  p.N_ID_PERSONA as id,
				            p.D_NOMBRES as nombre,
				            p.D_APELLIDOS as apellido,
				            c.C_EMAIL as email,
				            'sigeu' as origen
				    FROM personas p
				         LEFT JOIN correos c ON p.n_id_persona = c.n_id_persona
				    WHERE
					      ( TRANSLATE(upper(p.D_NOMBRES ),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE  '%$buscar%' )
				    OR    ( TRANSLATE(upper(p.D_APELLIDOS ),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE  '%$buscar%' )
				    OR    ( TRANSLATE(upper(c.C_EMAIL ),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE  '%$buscar%' )

				) res");


	$sql =" SELECT DISTINCT res.Id, res.origen
			FROM
			    (
			    	SELECT  cp.ID_CRM_PERSONA as Id,
			            cp.NOMBRE as nombre,
			            cp.APELLIDO as apellido,
			            cpe.email as email,
			            'crm'as origen
				    FROM crm_persona cp
				         LEFT JOIN CRM_PERSONA_EMAIL cpe ON cpe.id_crm_persona = cp.id_crm_persona
				    WHERE
				          ( TRANSLATE(upper(cp.NOMBRE ),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE  '%$buscar%' )
				    OR    ( TRANSLATE(upper(cp.APELLIDO ),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE  '%$buscar%' )
				    OR    ( TRANSLATE(upper(cpe.email ),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE  '%$buscar%' )

				    UNION

				    SELECT  p.N_ID_PERSONA as id,
				            p.D_NOMBRES as nombre,
				            p.D_APELLIDOS as apellido,
				            c.C_EMAIL as email,
				            'sigeu' as origen
				    FROM personas p
				         LEFT JOIN correos c ON p.n_id_persona = c.n_id_persona
				    WHERE
					      ( TRANSLATE(upper(p.D_NOMBRES ),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE  '%$buscar%' )
				    OR    ( TRANSLATE(upper(p.D_APELLIDOS ),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE  '%$buscar%' )
				    OR    ( TRANSLATE(upper(c.C_EMAIL ),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE  '%$buscar%' )

				) res"	;

	$query = $this->db->query( $sql);

	return $query;
}

public function  traer_ultimos_contactos_consultaron()
{
	// Traigo las ultimas consultas
	$consultas = $this->Consulta_model->traer_ultimas_consultas_importadas();

	$i = 0;
	$array_personas = array();
	$datos_personas = NULL;

	foreach ($consultas->result() as $row ):

		if(!in_array($row->ID_CRM_PERSONA, $array_personas)): // Si ya esta en el array, no busco la informacion (El dinstinct del)

			array_push($array_personas, $row->ID_CRM_PERSONA);
			$datos_personas[$i] = $this->Contacto_model->traer_informacion_crm_sigeu_persona($row->ID_CRM_PERSONA);
			$i++;

		endif;

	endforeach;

 	return $datos_personas;
}

public function  traer_cantidad_contactos_web_pendientes()
{
	chrome_log2("traer_cantidad_contactos_web_pendientes");

	$sql =	"	SELECT count(distinct(ID_CONTACTO_WEB)) as cantidad
				FROM CRM_CONTACTO_WEB "  ;

	$query = $this->db->query( $sql);

	return $query->row()->CANTIDAD;
}

public function  traer_cantidad_asistentes_web_pendientes()
{
	chrome_log2("traer_cantidad_asistentes_web_pendientes");

	$sql =	"	SELECT count(distinct(ID_CONTACTO_WEB)) as cantidad
				FROM CRM_CONTACTO_WEB
				WHERE id_evento IS NOT NULL"  ;

	$query = $this->db->query( $sql);

	return $query->row()->CANTIDAD;
}


public function traer_niveles_educacion()
{
	chrome_log2("traer_info_interes_consulta");

	$sql =	"	SELECT 	 *
    			FROM  CRM_PERSONA_EDUCACION_NIVEL"  ;

	$query = $this->db->query($sql);

	return $query;

}

public function traer_tipos_email()
{
	chrome_log2("traer_tipos_email");

	$sql =	"	SELECT 	 *
    			FROM  CRM_PERSONA_EMAIL_TIPO"  ;

	$query = $this->db->query($sql);

	return $query;
}

public function traer_tipos_telefono()
{
	chrome_log2("traer_tipos_telefono");

	$sql =	"	SELECT 	 *
    			FROM  CRM_PERSONA_TELEFONO_TIPO "  ;

	$query = $this->db->query($sql);

	return $query;
}

public function traer_tipos_documento()
{
	chrome_log2("traer_tipos_documento");

	$sql =	"	SELECT 	 *
    			FROM  CRM_PERSONA_DOCUMENTO_TIPO "  ;

	$query = $this->db->query($sql);

	return $query;
}

public function abm_educacion($accion, $array)
{
	switch ($accion):

		case 'A':

			$this->db->set('ID_EDUCACION_CRM', "ID_EDUCACION_CRM.nextval", false);

			$educacion['ID_CRM_PERSONA'] = utf8_decode($array['id_crm_persona']);

			if(isset($array['educacion_manual']))
				$educacion['NOMBRE'] = utf8_decode($array['educacion_manual']);

			if(isset($array['carrera']))
				$educacion['CARRERA'] = utf8_decode($array['carrera']);

			if(isset($array['id_nivel']))
				$educacion['ID_NIVEL_EDUCACION'] = utf8_decode($array['id_nivel']);

			if(isset($array['id_educacion']))
				$educacion['ID_EMPRESA'] = utf8_decode($array['id_educacion']);

			$educacion['ID_CRM_PERSONA'] = utf8_decode($array['id_crm_persona']);

			$this->db->insert('CRM_PERSONA_EDUCACION', $educacion);

			break;

		case 'M':

			$array_where = array( 'ID_EDUCACION_CRM' => $array['id_educacion_crm'] );

			$educacion =  array();

			if($array['nombre'])
				$educacion['NOMBRE'] = utf8_decode($array['nombre']);

			if($array['carrera'])
				$educacion['CARRERA'] = utf8_decode($array['carrera']);

			$educacion['ID_NIVEL_EDUCACION'] = utf8_decode($array['id_nivel']);

			$this->db->where($array_where);
			$this->db->update('CRM_PERSONA_EDUCACION', $educacion);

			break;

		case 'B':

			$this->db->where('ID_EDUCACION_CRM', $array['id_educacion_crm']);
			$this->db->delete('CRM_PERSONA_EDUCACION');


			break;

	endswitch;


	return $this->db->affected_rows();
}

public function abm_email($accion, $array)
{
	switch ($accion):

		case 'A':

			$this->db->set('ID_EMAIL_CRM', "ID_EMAIL_CRM.nextval", false);

			$email['EMAIL'] = utf8_decode($array['email']);
			$email['ID_TIPO_EMAIL'] = utf8_decode($array['id_tipo_email']);
			$email['ID_CRM_PERSONA'] = utf8_decode($array['id_crm_persona']);

			$this->db->insert('CRM_PERSONA_EMAIL', $email);

			break;

		case 'M':

			$array_where = array( 'ID_EMAIL_CRM' => $array['id_email_crm'] );

			$email =  array();

			if($array['email'])
				$email['EMAIL'] = utf8_decode($array['email']);

			$email['ID_TIPO_EMAIL'] = utf8_decode($array['id_tipo_email']);

			$this->db->where($array_where);
			$this->db->update('CRM_PERSONA_EMAIL', $email);

			break;

		case 'B':

			$this->db->where('ID_EMAIL_CRM', $array['id_email_crm']);
			$this->db->delete('CRM_PERSONA_EMAIL');


			break;

	endswitch;


	return $this->db->affected_rows();
}

public function abm_telefono($accion, $array)
{
	switch ($accion):

		case 'A':

			$this->db->set('ID_TELEFONO_CRM', "ID_TELEFONO_CRM.nextval", false);

			$telefono['TELEFONO'] = utf8_decode($array['telefono']);
			$telefono['ID_TIPO_TELEFONO'] = utf8_decode($array['id_tipo_telefono']);
			$telefono['ID_CRM_PERSONA'] = utf8_decode($array['id_crm_persona']);

			$this->db->insert('CRM_PERSONA_TELEFONO', $telefono);

			break;

		case 'M':

			$array_where = array( 'ID_TELEFONO_CRM' => $array['id_telefono_crm'] );

			$telefono =  array();

			if($array['telefono'])
				$telefono['TELEFONO'] = utf8_decode($array['telefono']);

			$telefono['ID_TIPO_TELEFONO'] = utf8_decode($array['id_tipo_telefono']);

			$this->db->where($array_where);
			$this->db->update('CRM_PERSONA_TELEFONO', $telefono);

			break;

		case 'B':

			$this->db->where('ID_TELEFONO_CRM', $array['id_telefono_crm']);
			$this->db->delete('CRM_PERSONA_TELEFONO');

			break;

	endswitch;


	return $this->db->affected_rows();
}

public function abm_documento($accion, $array)
{
	switch ($accion):

		case 'A':

			$this->db->set('ID_CRM_DOCUMENTO', "ID_CRM_DOCUMENTO.nextval", false);

			$telefono['NUMERO'] = utf8_decode($array['documento']);
			$telefono['ID_TIPO_DOCUMENTO'] = utf8_decode($array['id_tipo_documento']);
			$telefono['ID_CRM_PERSONA'] = utf8_decode($array['id_crm_persona']);

			$this->db->insert('CRM_PERSONA_DOCUMENTO', $telefono);

			break;

		case 'M':

			$array_where = array( 'ID_CRM_DOCUMENTO' => $array['id_documento_crm'] );

			$telefono =  array();

			if($array['documento'])
				$telefono['NUMERO'] = utf8_decode($array['documento']);

			$telefono['ID_TIPO_DOCUMENTO'] = utf8_decode($array['id_tipo_documento']);

			$this->db->where($array_where);
			$this->db->update('CRM_PERSONA_DOCUMENTO', $telefono);

			break;

		case 'B':

			$this->db->where('ID_CRM_DOCUMENTO', $array['id_documento_crm']);
			$this->db->delete('CRM_PERSONA_DOCUMENTO');

			break;

	endswitch;


	return $this->db->affected_rows();
}

public function abm_experiencia_laboral($accion, $array, $mensaje = null)
{
	switch ($accion):

		case 'A':


			if(isset($array['id_empresa']) && !empty($array['id_empresa']) ){

				$sql =	"	SELECT 	 *
	    					FROM  CRM_PERSONA_EMPRESA
	    					WHERE  ID_CRM_PERSONA = ?
	    					AND ID_EMPRESA = ?"  ;

				$query = $this->db->query($sql, array( $array['id_crm_persona'],  $array['id_empresa'] ) );

				if( $query->num_rows() > 0 )
				{
					break;
				}
				else
				{
					$empresa['ID_EMPRESA'] = $array['id_empresa'];
				}
				
				
			}

			$this->db->set('ID_CRM_PERSONA_EMPRESA', "ID_CRM_PERSONA_EMPRESA.nextval", false);

			$empresa['ID_CRM_PERSONA'] = $array['id_crm_persona'];

			if(isset($array['empresa_manual']))
				$empresa['EMPRESA'] = utf8_decode($array['empresa_manual']);

			if(isset($array['cargo']) && !empty($array['cargo']) )
				$empresa['CARGO'] = utf8_decode($array['cargo']);

			if(isset($array['descripcion']) && !empty($array['descripcion']) )
				$empresa['DESCRIPCION'] = utf8_decode($array['descripcion']);

			$this->db->insert('CRM_PERSONA_EMPRESA', $empresa);

			break;

		case 'M':

			$array_where = array( 'ID_CRM_PERSONA_EMPRESA' => $array['id_crm_persona_empresa'] );

			$empresa =  array();


			if(isset($array['empresa_manual']))
				$empresa['EMPRESA'] = utf8_decode($array['empresa_manual']);

			if(isset($array['cargo']) && !empty($array['cargo']) )
				$empresa['CARGO'] = utf8_decode($array['cargo']);

			if(isset($array['descripcion']) && !empty($array['descripcion']) )
				$empresa['DESCRIPCION'] = utf8_decode($array['descripcion']);

			if(isset($array['id_empresa']) && !empty($array['id_empresa']) )
				$empresa['ID_EMPRESA'] = $array['id_empresa'];

			$this->db->where($array_where);
			$this->db->update('CRM_PERSONA_EMPRESA', $empresa);

			break;

		case 'B':

			$array_where = array( 'ID_CRM_PERSONA_EMPRESA' => $array['id_crm_persona_empresa'] );
 			$empresa['ENABLED'] = 0;
			$this->db->where($array_where);
			$this->db->update('CRM_PERSONA_EMPRESA', $empresa);
			
			//$this->db->where('ID_CRM_PERSONA_EMPRESA', $array['id_crm_persona_empresa']);
			//$this->db->delete('CRM_PERSONA_EMPRESA');

			break;

	endswitch;


	return $this->db->affected_rows();
}

public function modifica_datos_crm_persona($array)
{
	$array_where = array( 'ID_CRM_PERSONA' => $array['id_crm_persona'] );

	$datos_persona =  array();
	$datos_persona['NOMBRE'] = utf8_decode($array['nombre']);
	$datos_persona['APELLIDO'] = utf8_decode($array['apellido']);
	$datos_persona['SEXO'] = utf8_decode($array['sexo']);

	$this->db->where($array_where);
	$this->db->update('CRM_PERSONA', $datos_persona);

	return $this->db->affected_rows();
}



//------ Fusionar ------------------


public function fusionar_contacto_sigeu( $id_contacto_web, $id_persona_sigeu )
{
	$this->db->trans_start();

	$datos_contactos = $this->traer_informacion_contacto_web($id_contacto_web);
	$prg_interes_contactos = $this->traer_prg_interes_contacto($id_contacto_web);
	$contactenlo_contactos = $this->traer_contactenlo_contacto($id_contacto_web);
	$info_interes_contactos = $this->traer_info_interes_contacto($id_contacto_web);

	$id_persona_crm = 	$this->fusionar_sigeu( 	$id_persona_sigeu,
												$datos_contactos->EMAIL,
												$datos_contactos->TELEFONO,
												$datos_contactos->INSTITUCION,
												$datos_contactos->EMPRESA,
												$datos_contactos->CARGO);

	// Armo el array de programas

			$array_programas = null;
			$i = 0;

			foreach ($prg_interes_contactos->result() as $row):

				$array_programas[$i] = $row->C_IDENTIFICACION."-".$row->C_PROGRAMA."-".$row->C_ORIENTACION;
				$i++;

			endforeach;

	// Armo el array de formas de contacto

		$array_id_contactacteme = null;
		$horario_telefono = null;
		$horario_what = null;
		$j = 0;

		if( $contactenlo_contactos->num_rows > 0  ):

			foreach ( $contactenlo_contactos->result() as $row):

				$array_id_contactacteme[$j] = $row->ID_MEDIO_CONTACTENME;

				if( $row->ID_MEDIO_CONTACTENME == 2 && isset($row->HORARIO) ):
					$horario_telefono = $row->HORARIO;
				endif;

				if( $row->ID_MEDIO_CONTACTENME == 3 && isset($row->HORARIO) ):
					$horario_what = $row->HORARIO;
				endif;

				$j++;

	 		endforeach;

		endif;

	// Armo el array de infor de interes

		$array_info_interes = null;
		$k = 0;

		if( $info_interes_contactos->num_rows > 0  ):

			foreach ( $info_interes_contactos->result() as $row):

				$array_info_interes[$k] = $row->ID_INFO_INTERES;
				$k++;

	 		endforeach;

		endif;

	$id_consulta = $this->Consulta_model->alta_crm_consulta( 	$id_persona_crm,
																$array_programas,
																$array_id_contactacteme,
																$horario_telefono,
																$horario_what,
																$datos_contactos->ANIO,
																$datos_contactos->ID_PERIODO,
																$datos_contactos->COMENTARIO,
																$array_info_interes
															);

	$this->eliminar_contacto_web($id_contacto_web);

		$this->insertar_log_persona( 2 , $id_persona_crm, $id_consulta ); //

	$this->db->trans_complete();

	if ($this->db->trans_status() === FALSE)
	{
	    $this->db->trans_rollback();
	    return false;
	}
	else
	{
	    $this->db->trans_commit();

	    if($this->db->affected_rows() > 0)
	    	return $id_persona_crm;
	    else
	    	return false;

	}
}

public function fusionar_contacto_crm( $id_contacto_web, $id_persona_crm )
{
	$this->db->trans_start();

	chrome_log2("fusionar_contacto_crm");

	$datos_contactos = $this->traer_informacion_contacto_web($id_contacto_web);
	$prg_interes_contactos = $this->traer_prg_interes_contacto($id_contacto_web);
	$contactenlo_contactos = $this->traer_contactenlo_contacto($id_contacto_web);
	$info_interes_contactos = $this->traer_info_interes_contacto($id_contacto_web);

	$this->fusionar_crm( 	$id_persona_crm,
							$datos_contactos->EMAIL,
							$datos_contactos->TELEFONO,
							$datos_contactos->INSTITUCION,
							$datos_contactos->EMPRESA,
							$datos_contactos->CARGO );

	// Armo el array de programas

			$array_programas = null;
			$i = 0;

			foreach ($prg_interes_contactos->result() as $row):

				$array_programas[$i] = $row->C_IDENTIFICACION."-".$row->C_PROGRAMA."-".$row->C_ORIENTACION;
				$i++;

			endforeach;

	// Armo el array de formas de contacto

		$array_id_contactacteme = null;
		$horario_telefono = null;
		$horario_what = null;
		$j = 0;

		if( $contactenlo_contactos->num_rows > 0  ):

			foreach ( $contactenlo_contactos->result() as $row):

				$array_id_contactacteme[$j] = $row->ID_MEDIO_CONTACTENME;

				if( $row->ID_MEDIO_CONTACTENME == 2 && isset($row->HORARIO) ):
					$horario_telefono = $row->HORARIO;
				endif;

				if( $row->ID_MEDIO_CONTACTENME == 3 && isset($row->HORARIO) ):
					$horario_what = $row->HORARIO;
				endif;

				$j++;

	 		endforeach;

		endif;

	// Armo el array de infor de interes

		$array_info_interes = null;
		$k = 0;

		if( $info_interes_contactos->num_rows > 0  ):

			foreach ( $info_interes_contactos->result() as $row):

				$array_info_interes[$k] = $row->ID_INFO_INTERES;
				$k++;

	 		endforeach;

		endif;

	$id_consulta = $this->Consulta_model->alta_crm_consulta( 	$id_persona_crm	,
																$array_programas,
																$array_id_contactacteme,
																$horario_telefono,
																$horario_what,
																$datos_contactos->ANIO,
																$datos_contactos->ID_PERIODO,
																$datos_contactos->COMENTARIO,
																$array_info_interes
															);

	$this->eliminar_contacto_web($id_contacto_web);


		$this->insertar_log_persona( 15 , $id_persona_crm, $id_consulta ); // Se lo fusiono con un contacto web
		//$this->insertar_log_persona( 1 , $id_persona_crm, $id_consulta ); // Se cargo una consulta

	$this->db->trans_complete();


	if ($this->db->trans_status() === FALSE)
	{
	    $this->db->trans_rollback();
	    return false;
	}
	else
	{
	    $this->db->trans_commit();

	    if($this->db->affected_rows() > 0)
	    	return $id_persona_crm;
	    else
	    	return false;

	}
}


public function fusionar_sigeu( $id_persona_sigeu, $email, $telefono=NULL )
{
	// Fusionar SIGEU no fusiona educacion ni empresa por que estan en SIGEU.

	$this->db->trans_start();

	//--- PREGUNTO SI ESTA EN CRM_PERSONA ---

		$sql_crm =	"	SELECT ID_CRM_PERSONA
						FROM CRM_PERSONA
						WHERE ID_PERSONA = ? "  ;

		$query_crm = $this->db->query( $sql_crm , array( $id_persona_sigeu ) );

		if( $query_crm->num_rows() == 0): // Si no existe el contacto CRM, inserto en CRM_PERSONA

				//---  INSERTAR A CRM_PERSONA ----

				$this->db->set('ID_CRM_PERSONA', "ID_CRM_PERSONA.nextval", false);
				$array_contacto_crm['ID_PERSONA'] = utf8_decode($id_persona_sigeu);
				$this->db->insert('CRM_PERSONA',$array_contacto_crm);

				$id_persona_crm = $this->db->query("SELECT ID_CRM_PERSONA.CURRVAL as ID FROM CRM_PERSONA" )->row()->ID;

				//---  INSERTAR A CRM_INTERESADO ----

				$array_interesado_crm['ID_CRM_PERSONA'] = utf8_decode($id_persona_crm);
				$this->db->insert('CRM_INTERESADO',$array_interesado_crm);

		else: // Si existe traigo el id_crm_persona

				$id_persona_crm = $query_crm->row()->ID_CRM_PERSONA;

		endif;

	//---  EMAIL --- Agrego el emails a personas

		if(isset($email) && !empty($email)):

			$sql =	"	SELECT *
						FROM correos
						WHERE C_EMAIL = ?
						AND N_ID_PERSONA = ?"  ;

			$query_email = $this->db->query( $sql , array($email, $id_persona_sigeu ) );

			if( $query_email->num_rows() == 0): // Si el email no esta, lo inserto

				// Busco el ultimo Tipo de email

				$sql =	"	SELECT max(C_CORREO) as tipo
							FROM correos
							WHERE C_CORREO like 'e-mail%'
							AND N_ID_PERSONA = ?"  ;


				$query_tipo_email = $this->db->query( $sql , array( $id_persona_sigeu ) );

				//echo "cantidad ".var_dump($query_tipo_email->row());

				if( $query_tipo_email->num_rows() == 0): // Si no tiene ninguno, creo el email 1

					$c_correo = "e-mail 1";

				else:

					$array_tipo = explode(" ",$query_tipo_email->row()->TIPO); // Si tiene, le saco el numero y lo incremento
					$numero = ++$array_tipo[1];
					$c_correo = "e-mail ".$numero;
					//echo ' c_correo: '.$c_correo;
				endif;


				$array_contacto_email['N_ID_PERSONA'] = utf8_decode($id_persona_sigeu );
				$array_contacto_email['C_EMAIL'] = utf8_decode($email);
				$array_contacto_email['C_CORREO'] = utf8_decode($c_correo);

				$this->db->insert('CORREOS',$array_contacto_email);

			endif;

		endif;

	//---  TELEFONO ---

		if(isset($telefono) && !empty($telefono)):

			$sql =	"	SELECT *
						FROM telefonos t
						WHERE replace(TRANSLATE(t.N_TELEFONO,'-()','   '),' ','') = ?
						AND N_ID_PERSONA = ?"  ;

			$query_tel = $this->db->query( $sql , array($telefono, $id_persona_sigeu ) );

			if( $query_tel->num_rows() == 0): // Si el telefono no esta, lo inserto

				// Busco el ultimo Tipo de email

				$sql =	"	SELECT max(C_TELEFONO) as tipo
							FROM telefonos
							WHERE C_TELEFONO like 'Particular%'
							AND N_ID_PERSONA = ?"  ;


				$query_tipo_telefono = $this->db->query( $sql , array( $id_persona_sigeu ) );

				//echo "cantidad ".var_dump($query_tipo_telefono->row());

				if( $query_tipo_telefono->num_rows() == 0): // Si no tiene ninguno, creo el email 1

					$c_telefono = "Particular 1";

				else:

					$array_tipo = explode(" ",$query_tipo_telefono->row()->TIPO); // Si tiene, le saco el numero y lo incremento
					if(isset($array_tipo[1])):
						$numero = $array_tipo[1]++;
						$c_telefono = "Particularl ".$numero;
					else:
						$c_telefono = "Particularl 100";
					endif;

				endif;

				$array_contacto_telefono['N_ID_PERSONA'] = utf8_decode($id_persona_sigeu );
				$array_contacto_telefono['N_TELEFONO'] = utf8_decode($telefono);
				$array_contacto_telefono['C_TELEFONO'] = utf8_decode($c_telefono);

				$this->db->insert('TELEFONOS',$array_contacto_telefono);

			endif;

		endif;


		$this->insertar_log_persona( 17 , $id_persona_crm ); // Se lo fusiono con un contacto SIGEU

	$this->db->trans_complete();

	if ($this->db->trans_status() === FALSE)
	{
	    $this->db->trans_rollback();
	    return false;
	}
	else
	{
	    $this->db->trans_commit();

 		return $id_persona_crm;

	}
}

public function fusionar_crm( $id_persona_crm , $email, $telefono=NULL, $educacion=NULL, $empresa=NULL, $cargo=NULL )
{
	$this->db->trans_start();

	chrome_log2("fusionar_crm: ".$id_persona_crm);

 	//---  EMAIL ---

		$sql =	"	SELECT *
					FROM 	CRM_PERSONA_EMAIL
					WHERE   ID_CRM_PERSONA = ? "  ;

		$query_email = $this->db->query( $sql , array( $id_persona_crm ) );

		if( $query_email->num_rows() == 0): // Si el email no esta, lo inserto

			$this->db->set('ID_EMAIL_CRM', "ID_EMAIL_CRM.nextval", false);
			$array_contacto_email['ID_CRM_PERSONA'] = utf8_decode($id_persona_crm );
			$array_contacto_email['EMAIL'] = utf8_decode($email);

			$this->db->insert('CRM_PERSONA_EMAIL',$array_contacto_email);

		endif;

	//---  TELEFONO ---

		if( isset($telefono) && !empty($telefono) ):

			chrome_log2("Entro a telefono ");

			$telefono = preg_replace("/[^0-9]/", "", $telefono);

			$sql =	"	SELECT *
						FROM 	CRM_PERSONA_TELEFONO t
						WHERE 	REGEXP_REPLACE(  t.TELEFONO, '[^0-9]', '') = ?
						AND 	t.ID_CRM_PERSONA = ? "  ;

			$query_email = $this->db->query( $sql , array($telefono, $id_persona_crm ) );



			if( $query_email->num_rows() == 0): // Si el telefono no esta, lo inserto

				chrome_log2("telefono no esta ");

				$this->db->set('ID_TELEFONO_CRM', "ID_TELEFONO_CRM.nextval", false);
				$array_contacto_telefono['ID_CRM_PERSONA'] = utf8_decode($id_persona_crm );
				$array_contacto_telefono['TELEFONO'] = utf8_decode($telefono);

				$this->db->insert('CRM_PERSONA_TELEFONO',$array_contacto_telefono);

			endif;

		endif;



		$this->insertar_log_persona( 18 , $id_persona_crm ); // Se lo fusiono con un contacto SIGEU

	$this->db->trans_complete();


	if ($this->db->trans_status() === FALSE)
	{
	    $this->db->trans_rollback();
	    return false;
	}
	else
	{
	    $this->db->trans_commit();


	   	return true;


	}
}

public function fusionar_contactos($array)
{
	$this->db->trans_start();

		// Id usuario ---------

		if( $array['id_usuario'] == $array['id_usuario_1'] ):

			$id_usuario_elegido = $array['id_usuario_1'];
			$id_usuario_borrado = $array['id_usuario_2'];

		else:

			$id_usuario_elegido = $array['id_usuario_2'];
			$id_usuario_borrado = $array['id_usuario_1'];

		endif;

		$nombre = utf8_decode($array['nombre']);
		$apellido = utf8_decode($array['apellido']);

		// Persona: actualizar Nombre y apellido -----

		$array_where = array( 'ID_CRM_PERSONA' => $id_usuario_elegido );

		$array_persona['NOMBRE'] = $nombre;
		$array_persona['APELLIDO'] = $apellido;

		$this->db->where($array_where);
		$this->db->update('CRM_PERSONA', $array_persona);


		// Emails ---------

			// Borro los emails de ambos
			$this->db->delete('CRM_PERSONA_EMAIL', array('ID_CRM_PERSONA' => $id_usuario_elegido));
			$this->db->delete('CRM_PERSONA_EMAIL', array('ID_CRM_PERSONA' => $id_usuario_borrado));

		if( isset($array['email']) && !empty($array['email']) ):

			foreach ($array['email'] as $row)
			{
				$this->db->set('ID_EMAIL_CRM', "ID_EMAIL_CRM.nextval", false);
				$info_email['EMAIL'] = utf8_decode($row);
				$info_email['ID_CRM_PERSONA'] = utf8_decode($id_usuario_elegido);
		 		$this->db->insert('CRM_PERSONA_EMAIL',$info_email);
			}

		endif;

		// Telefonos ---------

			// Borro los telefonos de ambos
			$this->db->delete('CRM_PERSONA_TELEFONO', array('ID_CRM_PERSONA' => $id_usuario_elegido));
			$this->db->delete('CRM_PERSONA_TELEFONO', array('ID_CRM_PERSONA' => $id_usuario_borrado));

		if( isset($array['telefono']) && !empty($array['telefono']) ):

			foreach ($array['telefono'] as $row)
			{
				$this->db->set('ID_TELEFONO_CRM', "ID_TELEFONO_CRM.nextval", false);
				$info_telefono['TELEFONO'] = utf8_decode($row);
				$info_telefono['ID_CRM_PERSONA'] = utf8_decode($id_usuario_elegido);
		 		$this->db->insert('CRM_PERSONA_TELEFONO',$info_telefono);
			}

		endif;

		// Documento ---------


			// Borro los documentos de ambos
			$this->db->delete('CRM_PERSONA_DOCUMENTO', array('ID_CRM_PERSONA' => $id_usuario_elegido));
			$this->db->delete('CRM_PERSONA_DOCUMENTO', array('ID_CRM_PERSONA' => $id_usuario_borrado));

		if( isset($array['documento']) && !empty($array['documento']) ):

			foreach ($array['documento'] as $row)
			{
				$docu = explode("-", $row);

				$this->db->set('ID_CRM_DOCUMENTO', "ID_CRM_DOCUMENTO.nextval", false);
				$info_documento['ID_TIPO_DOCUMENTO'] = utf8_decode($docu[0]);
				$info_documento['NUMERO'] = utf8_decode($docu[1]);
				$info_documento['ID_CRM_PERSONA'] = utf8_decode($id_usuario_elegido);
		 		$this->db->insert('CRM_PERSONA_DOCUMENTO',$info_documento);
			}

		endif;

		// Consultas: actualizar consultas al nuevo owner -----

		$array_where = array( 'ID_CRM_PERSONA' => $id_usuario_borrado );

		$consulta['ID_CRM_PERSONA'] = $id_usuario_elegido;

		$this->db->where($array_where);
		$this->db->update('CRM_CONSULTA', $consulta);

		// Borrar todo lo del USUARIO no elegido


		$this->db->delete('CRM_PERSONA', array('ID_CRM_PERSONA' => $id_usuario_borrado));
		$this->db->delete('CRM_PERSONA_EDUCACION', array('ID_CRM_PERSONA' => $id_usuario_borrado));
		$this->db->delete('CRM_PERSONA_EMPRESA', array('ID_CRM_PERSONA' => $id_usuario_borrado));
		$this->db->delete('CRM_INTERESADO', array('ID_CRM_PERSONA' => $id_usuario_borrado));

		// LOG

		$this->insertar_log_persona( 18 , $id_usuario_elegido ); // Se lo fusiono con un contacto CRM

		// actualizo el log del del log viejo con el nuevo
			$array_log = array( 'ID_CRM_PERSONA' => $id_usuario_borrado );

			$log['ID_CRM_PERSONA'] = $id_usuario_elegido;

			$this->db->where($array_log);
			$this->db->update('CRM_PERSONA_LOG', $log);


	$this->db->trans_complete();

	//echo "usuarios elegido: ".$id_usuario_elegido."<br>";
	//echo "trans_status: ".$this->db->trans_status()."<br>";

	if ($this->db->trans_status() === FALSE)
	{
	    $this->db->trans_rollback();
	    return false;
	}
	else
	{
	    $this->db->trans_commit();
    	return $id_usuario_elegido;
	}
}

public function vincular_contactos($array)
{
	$this->db->trans_start();

		// Al vincular contactos no le paso los emails del CRM a SIGEU

		// Id usuario ---------

		$usuario_1 = explode("-", $array['id_usuario_1']);
		$usuario_2 = explode("-", $array['id_usuario_2']);

		if( $usuario_1[0] == 'CRM'):

			$array_where = array( 'ID_CRM_PERSONA' => $usuario_1[1] );
			$persona['ID_PERSONA'] = $usuario_2[1];
			$id_crm_persona =  $usuario_1[1];

		else:

			$array_where = array( 'ID_CRM_PERSONA' => $usuario_2[1] );
			$persona['ID_PERSONA'] = $usuario_1[1];
			$id_crm_persona =  $usuario_2[1];

		endif;

		// Pongo los datos en NULL

	    $persona['APELLIDO'] = NULL;
		$persona['NOMBRE'] = NULL;
		$persona['SEXO'] = NULL;

		$this->db->where($array_where);
		$this->db->update('CRM_PERSONA', $persona);

		// Borro los emails

		$this->db->where('ID_CRM_PERSONA', $id_crm_persona);
      	$this->db->delete('CRM_PERSONA_EMAIL');

		// Borro los telefonos

		$this->db->where('ID_CRM_PERSONA', $id_crm_persona);
      	$this->db->delete('CRM_PERSONA_TELEFONO');

		// Borro los educacion

		$this->db->where('ID_CRM_PERSONA', $id_crm_persona);
      	$this->db->delete('CRM_PERSONA_EDUCACION');

      	// Borro las documentos

	    $this->db->where('ID_CRM_PERSONA', $id_crm_persona);
  		$this->db->delete('CRM_PERSONA_DOCUMENTO');

  		// Borro las empresa

	    $this->db->where('ID_CRM_PERSONA', $id_crm_persona);
  		$this->db->delete('CRM_PERSONA_EMPRESA');



		$this->insertar_log_persona( 16 , $id_crm_persona ); // Se lo vinculos con un contacto SIGEU

	$this->db->trans_complete();

	if ($this->db->trans_status() === FALSE)
	{
	    $this->db->trans_rollback();
	    return false;
	}
	else
	{
	    $this->db->trans_commit();

	    if($this->db->affected_rows() > 0)
	    	return $id_crm_persona;
	    else
	    	return false;

	}
}


public function fusionar_contacto_sigeu_excel( $json_recibido, $id_persona_sigeu )
{
	$this->db->trans_start();

	$datos =  str_replace( "&", "\"", $json_recibido );
 	$datos = json_decode($datos);

	$id_crm_persona = 	$this->fusionar_sigeu( 	$id_persona_sigeu,
												$datos->datos_usuario->EMAIL,
												$datos->datos_usuario->TELEFONO,
												$datos->datos_usuario->COLEGIO,
												$datos->datos_usuario->EMPRESA,
												NULL);

	// Armo el array de programas

		$array_programas = null;
		$i = 0;

		if( isset($datos->datos_usuario->PROGRAMAS) && !empty($datos->datos_usuario->PROGRAMAS)):

			$programa = explode(",", $datos->datos_usuario->PROGRAMAS);

			foreach ($programa as $key => $value)
			{
				$value = trim($value);

				$sql =	"	SELECT  *
			    			FROM	programas p
			    			WHERE 	p.D_DESCRED = ?  "  ;

				$query = $this->db->query($sql, array($value));

				if($query->num_rows() > 0):

					$array_programas[$i] = $query->row()->C_IDENTIFICACION."-".$query->row()->C_PROGRAMA."-".$query->row()->C_ORIENTACION;
					$i++;

				endif;


			}

			//var_dump($array_programas);

		endif;

		//--- Armo el array de formas de contacto

		$array_id_contactacteme = null;
		$horario_telefono = null;
		$horario_what = null;
		$array_info_interes = null;
		$id_periodo = null;
		$anio = null;


		if(  isset($datos->datos_usuario->PERIODO) && !empty($datos->datos_usuario->PERIODO) ):

					$periodo = trim($datos->datos_usuario->PERIODO);

				$sql =	"	SELECT  *
			    			FROM	CRM_PERIODO_INGRESO cpi
			    			WHERE 	cpi.descripcion = ?  "  ;

				$query = $this->db->query($sql, array($periodo));

				if($query->num_rows() > 0)
				 	$id_periodo = $query->row()->ID_PERIODO_INGRESO;
				else
					$id_periodo = NULL;


		endif;


		if(  isset($datos->datos_usuario->ANIO) && !empty($datos->datos_usuario->ANIO) )
					 $anio = $datos->datos_usuario->ANIO;

			if(  isset($datos->datos_usuario->COMENTARIO) && !empty($datos->datos_usuario->COMENTARIO) )
					 $comentario = $datos->datos_usuario->COMENTARIO;



		$id_consulta = $this->Consulta_model->alta_crm_consulta( 	$id_crm_persona,
																	$array_programas,
																	$array_id_contactacteme,
																	$horario_telefono,
																	$horario_what,
																	$anio,
																	$id_periodo,
																	$comentario,
																	$array_info_interes
															);

		// 2- Se importó la consulta

		$this->Consulta_model->insertar_log_consulta( 19, $id_consulta );
		$this->Contacto_model->insertar_log_persona( 20, $id_crm_persona );


	$this->db->trans_complete();

	if ($this->db->trans_status() === FALSE)
	{
	    $this->db->trans_rollback();
	    return false;
	}
	else
	{
	    $this->db->trans_commit();

	    if($this->db->affected_rows() > 0)
	    	return $id_crm_persona;
	    else
	    	return false;

	}
}

public function fusionar_contacto_crm_excel( $json_recibido, $id_crm_persona )
{
	$this->db->trans_start();

	chrome_log2("fusionar_contacto_crm");

	$datos =  str_replace( "&", "\"", $json_recibido );
 	$datos = json_decode($datos);

	$this->fusionar_crm( 	$id_crm_persona,
							$datos->datos_usuario->EMAIL,
							$datos->datos_usuario->TELEFONO,
							$datos->datos_usuario->COLEGIO,
							$datos->datos_usuario->EMPRESA,
							NULL);

	// Armo el array de programas

		$array_programas = null;
		$i = 0;

		if( isset($datos->datos_usuario->PROGRAMAS) && !empty($datos->datos_usuario->PROGRAMAS)):

			$programa = explode(",", $datos->datos_usuario->PROGRAMAS);

			foreach ($programa as $key => $value)
			{
				$value = trim($value);

				$sql =	"	SELECT  *
			    			FROM	programas p
			    			WHERE 	p.D_DESCRED = ?  "  ;

				$query = $this->db->query($sql, array($value));

				if($query->num_rows() > 0):

					$array_programas[$i] = $query->row()->C_IDENTIFICACION."-".$query->row()->C_PROGRAMA."-".$query->row()->C_ORIENTACION;
					$i++;

				endif;


			}

			//var_dump($array_programas);

		endif;

		//--- Armo el array de formas de contacto

		$array_id_contactacteme = null;
		$horario_telefono = null;
		$horario_what = null;
		$array_info_interes = null;
		$id_periodo = null;
		$anio = null;


		if(  isset($datos->datos_usuario->PERIODO) && !empty($datos->datos_usuario->PERIODO) ):

					$periodo = trim($datos->datos_usuario->PERIODO);

				$sql =	"	SELECT  *
			    			FROM	CRM_PERIODO_INGRESO cpi
			    			WHERE 	cpi.descripcion = ?  "  ;

				$query = $this->db->query($sql, array($periodo));

				if($query->num_rows() > 0)
				 	$id_periodo = $query->row()->ID_PERIODO_INGRESO;
				else
					$id_periodo = NULL;


		endif;


		if(  isset($datos->datos_usuario->ANIO) && !empty($datos->datos_usuario->ANIO) )
					 $anio = $datos->datos_usuario->ANIO;

			if(  isset($datos->datos_usuario->COMENTARIO) && !empty($datos->datos_usuario->COMENTARIO) )
					 $comentario = $datos->datos_usuario->COMENTARIO;



		$id_consulta = $this->Consulta_model->alta_crm_consulta( 	$id_crm_persona,
																	$array_programas,
																	$array_id_contactacteme,
																	$horario_telefono,
																	$horario_what,
																	$anio,
																	$id_periodo,
																	$comentario,
																	$array_info_interes
															);

		// 2- Se importó la consulta

		$this->Consulta_model->insertar_log_consulta( 19, $id_consulta );
		$this->Contacto_model->insertar_log_persona( 21, $id_crm_persona );


	$this->db->trans_complete();

	if ($this->db->trans_status() === FALSE)
	{
	    $this->db->trans_rollback();
	    return false;
	}
	else
	{
	    $this->db->trans_commit();

	    if($this->db->affected_rows() > 0)
	    	return $id_crm_persona;
	    else
	    	return false;

	}
}



//------ ABM contactos crm ---



public function alta_contacto_crm_importado($id_contacto_web, &$mensaje)
{
	chrome_log2( "alta_contacto_crm_importado" );

	$this->db->trans_start();

		$datos_contactos = $this->traer_informacion_contacto_web($id_contacto_web);
		$prg_interes_contactos = $this->traer_prg_interes_contacto($id_contacto_web);
		$contactenlo_contactos = $this->traer_contactenlo_contacto($id_contacto_web);
		$info_interes_contactos = $this->traer_info_interes_contacto($id_contacto_web);

		$id_crm_persona = $this->alta_crm_persona(	$datos_contactos->APELLIDO,
													$datos_contactos->NOMBRE
												);


		// ALTA EMAIL

			// Busco si existe el email

			$sql =	"	SELECT  *
		    			FROM	CRM_PERSONA_EMAIL pe
		    			WHERE 	pe.EMAIL = ? "  ;

			$query = $this->db->query($sql, array($datos_contactos->EMAIL));

			if($query->num_rows() == 0): // No existe , lo creo.

				$array_email['id_crm_persona'] = $id_crm_persona;
				$array_email['email'] = $datos_contactos->EMAIL;
				$array_email['id_tipo_email'] = 4;
				$this->Contacto_model->abm_email(  'A', $array_email  );

			else:

				$mensaje .= "<span style='color:red; font-size:10px'>[El email ".$datos_contactos->EMAIL." ya se encuentra en el sistema, no fue importado.]</span>";

			endif;

		// ALTA TELEFONO

			if( isset($datos_contactos->TELEFONO) && !empty($datos_contactos->TELEFONO)  ):

				$array_telefono['id_crm_persona'] = $id_crm_persona;
				$array_telefono['telefono'] = $datos_contactos->TELEFONO;
				$array_telefono['id_tipo_telefono'] = 1;
				$this->Contacto_model->abm_telefono(  'A', $array_telefono  );

			endif;

		// ALTA EDUCACION

			if(  isset($datos_contactos->INSTITUCION) && !empty($datos_contactos->INSTITUCION) ):

				$array_educacion['id_crm_persona'] = $id_crm_persona;

				if(isset($datos_contactos->INSTITUCIONl))
					$array_educacion['educacion_manual'] = $datos_contactos->INSTITUCION;

				$this->Contacto_model->abm_educacion(  'A', $array_educacion  );

			endif;



		//----------------- Alta de la consulta


		// Armo el array de programas

			$array_programas = null;
			$i = 0;

			foreach ($prg_interes_contactos->result() as $row):

				$array_programas[$i] = $row->C_IDENTIFICACION."-".$row->C_PROGRAMA."-".$row->C_ORIENTACION;
				$i++;

			endforeach;

		// Armo el array de formas de contacto

			$array_id_contactacteme = null;
			$horario_telefono = null;
			$horario_what = null;
			$j = 0;

			if( $contactenlo_contactos->num_rows > 0  ):

				foreach ( $contactenlo_contactos->result() as $row):

					$array_id_contactacteme[$j] = $row->ID_MEDIO_CONTACTENME;

					if( $row->ID_MEDIO_CONTACTENME == 2 && isset($row->HORARIO) ):
						$horario_telefono = $row->HORARIO;
					endif;

					if( $row->ID_MEDIO_CONTACTENME == 3 && isset($row->HORARIO) ):
						$horario_what = $row->HORARIO;
					endif;

					$j++;

		 		endforeach;

			endif;

		// Armo el array de infor de interes

			$array_info_interes = null;
			$k = 0;

			if( $info_interes_contactos->num_rows > 0  ):

				foreach ( $info_interes_contactos->result() as $row):

					$array_info_interes[$k] = $row->ID_INFO_INTERES;
					$k++;

		 		endforeach;

			endif;

		$id_consulta = $this->Consulta_model->alta_crm_consulta( 	$id_crm_persona,
																	$array_programas,
																	$array_id_contactacteme,
																	$horario_telefono,
																	$horario_what,
																	$datos_contactos->ANIO,
																	$datos_contactos->ID_PERIODO,
																	$datos_contactos->COMENTARIO,
																	$array_info_interes
																);

		// 2- Se importó la consulta

		$this->Consulta_model->insertar_log_consulta( 2, $id_consulta );

		echo "Id persona: ".$id_crm_persona;
		$this->Contacto_model->insertar_log_persona( 2, $id_crm_persona );

 		//----------------- Baja consulta web

 		$this->eliminar_contacto_web($id_contacto_web);


	$this->db->trans_complete();


	if ($this->db->trans_status() === FALSE)
	{
	    $this->db->trans_rollback();
	    return false;
	}
	else
	{
	    $this->db->trans_commit();

	    if($this->db->affected_rows() > 0)
	    	return $id_crm_persona;
	    else
	    	return false;

	}
}

public function alta_contacto_crm_importado_excel($json_recibido, &$mensaje)
{
	chrome_log2( "alta_contacto_crm_importado_excel" );

	$datos =  str_replace( "&", "\"", $json_recibido );
 	$datos = json_decode($datos);

	$this->db->trans_start();

		//var_dump($datos);


		$id_crm_persona = $this->alta_crm_persona(	$datos->datos_usuario->APELLIDO,
																	$datos->datos_usuario->NOMBRE
																);


		// ALTA EMAIL

			// Busco si existe el email

			$sql =	"	SELECT  *
		    			FROM	CRM_PERSONA_EMAIL pe
		    			WHERE 	pe.EMAIL = ? "  ;

			$query = $this->db->query($sql, array($datos->datos_usuario->EMAIL));

			if($query->num_rows() == 0): // No existe , lo creo.

				$array_email['id_crm_persona'] = $id_crm_persona;
				$array_email['email'] = $datos->datos_usuario->EMAIL;
				$array_email['id_tipo_email'] = 4;
				$this->Contacto_model->abm_email(  'A', $array_email  );

			else:

				$mensaje .= "<span style='color:red; font-size:10px'>[El email ".$datos->datos_usuario->EMAIL." ya se encuentra en el sistema, no fue importado.]</span>";

			endif;


		// ALTA TELEFONO

			if( isset($datos->datos_usuario->TELEFONO) && !empty($datos->datos_usuario->TELEFONO)  ):

				$array_telefono['id_crm_persona'] = $id_crm_persona;
				$array_telefono['telefono'] =$datos->datos_usuario->TELEFONO;
				$array_telefono['id_tipo_telefono'] = 1;
				$this->Contacto_model->abm_telefono(  'A', $array_telefono  );

			endif;


		// ALTA EDUCACION

			if(  isset($datos->datos_usuario->COLEGIO) && !empty($datos->datos_usuario->COLEGIO) ):

				$array_educacion['id_crm_persona'] = $id_crm_persona;

				if(isset($datos->datos_usuario->COLEGIO))
					$array_educacion['educacion_manual'] = $datos->datos_usuario->COLEGIO;

				$this->Contacto_model->abm_educacion(  'A', $array_educacion  );

			endif;


		//----------------- Alta de la consulta

			//--- Programas

			$array_programas = null;
			$i = 0;

			if( isset($datos->datos_usuario->PROGRAMAS) && !empty($datos->datos_usuario->PROGRAMAS)):

				$programa = explode(",", $datos->datos_usuario->PROGRAMAS);

				foreach ($programa as $key => $value)
				{
					$value = trim($value);

					$sql =	"	SELECT  *
				    			FROM	programas p
				    			WHERE 	p.D_DESCRED = ?  "  ;

					$query = $this->db->query($sql, array($value));

					if($query->num_rows() > 0):

						$array_programas[$i] = $query->row()->C_IDENTIFICACION."-".$query->row()->C_PROGRAMA."-".$query->row()->C_ORIENTACION;
						$i++;

					endif;


				}

				//var_dump($array_programas);

			endif;


			//--- Armo el array de formas de contacto

			$array_id_contactacteme = null;
			$horario_telefono = null;
			$horario_what = null;
			$array_info_interes = null;
			$id_periodo = null;
			$anio = null;


			if(  isset($datos->datos_usuario->PERIODO) && !empty($datos->datos_usuario->PERIODO) ):

 					$periodo = trim($datos->datos_usuario->PERIODO);

					$sql =	"	SELECT  *
				    			FROM	CRM_PERIODO_INGRESO cpi
				    			WHERE 	cpi.descripcion = ?  "  ;

					$query = $this->db->query($sql, array($periodo));

					if($query->num_rows() > 0)
					 	$id_periodo = $query->row()->ID_PERIODO_INGRESO;
					else
						$id_periodo = NULL;


			endif;


			if(  isset($datos->datos_usuario->ANIO) && !empty($datos->datos_usuario->ANIO) )
 					 $anio = $datos->datos_usuario->ANIO;

 			if(  isset($datos->datos_usuario->COMENTARIO) && !empty($datos->datos_usuario->COMENTARIO) )
 					 $comentario = $datos->datos_usuario->COMENTARIO;



			$id_consulta = $this->Consulta_model->alta_crm_consulta( 	$id_crm_persona,
																		$array_programas,
																		$array_id_contactacteme,
																		$horario_telefono,
																		$horario_what,
																		$anio,
																		$id_periodo,
																		$comentario,
																		$array_info_interes
																);

		// 2- Se importó la consulta

		$this->Consulta_model->insertar_log_consulta( 19, $id_consulta );
		$this->Contacto_model->insertar_log_persona( 19, $id_crm_persona );



	$this->db->trans_complete();


	if ($this->db->trans_status() === FALSE)
	{
	    $this->db->trans_rollback();
	    return false;
	}
	else
	{
	    $this->db->trans_commit();

	    if($this->db->affected_rows() > 0)
	    	return $id_crm_persona;
	    else
	    	return false;

	}
}

public function alta_crm_persona( 	$apellido,
								  	$nombre  )
{
	chrome_log2( "alta_crm_persona" );

	$this->db->trans_start();

	//---  INSERTAR A ID_CRM_PERSONA ----

		$this->db->set('ID_CRM_PERSONA', "CRM.ID_CRM_PERSONA.nextval", false);

		$array_contacto_crm['nombre'] = $nombre;
		$array_contacto_crm['apellido'] = $apellido;

		$this->db->insert('CRM_PERSONA',$array_contacto_crm);

		$id_persona_crm = $this->db->query("SELECT CRM.ID_CRM_PERSONA.CURRVAL as ID FROM CRM_PERSONA" )->row()->ID;

		//echo "Id_persona 1: ".$id_persona_crm;

		$this->Contacto_model->insertar_log_persona( 12, utf8_decode($id_persona_crm) );

	//---  INSERTAR A CRM_INTERESADO ----


		//$array_interesado_crm['ID_CRM_PERSONA'] = utf8_decode($id_persona_crm);
		//$this->db->insert('CRM_INTERESADO',$array_interesado_crm);

	$this->db->trans_complete();

	if ($this->db->trans_status() === FALSE)
	{
		chrome_log2( "FALSE" );
	    $this->db->trans_rollback();
	    return false;
	}
	else
	{
	    $this->db->trans_commit();
 	
	   	return $id_persona_crm;
 

	}
}

/*
public function eliminar_contacto_crm($id_crm_persona)
{
	chrome_log2(" eliminar_contacto_crm: ".$id_crm_persona);
	
	$this->db->trans_start();

	// Elimino informacion de la PERSONA

	/*
	$this->db->delete('CRM_PERSONA_EMAIL', array('ID_CRM_PERSONA' => $id_crm_persona));
	$this->db->delete('CRM_PERSONA_TELEFONO', array('ID_CRM_PERSONA' => $id_crm_persona));
	$this->db->delete('CRM_PERSONA_EDUCACION', array('ID_CRM_PERSONA' => $id_crm_persona));
	$this->db->delete('CRM_REFERENTE_EMPRESA', array('ID_CRM_PERSONA' => $id_crm_persona));
	$this->db->delete('CRM_PERSONA_EMPRESA', array('ID_CRM_PERSONA' => $id_crm_persona));
	$this->db->delete('CRM_PERSONA_EMPRESA', array('ID_CRM_PERSONA' => $id_crm_persona));
	$this->db->delete('CRM_INTERESADO', array('ID_CRM_PERSONA' => $id_crm_persona));
	$this->db->delete('CRM_PERSONA_DOCUMENTO', array('ID_CRM_PERSONA' => $id_crm_persona));
	$this->db->delete('CRM_PERSONA', array('ID_CRM_PERSONA' => $id_crm_persona));*/
	//$this->db->delete('CRM_CONSULTA', array('ID_CRM_PERSONA' => $id_crm_persona));

	/*
	// Elimino informacion de la CONSULTA

	//$sql =	"	SELECT  ID_CRM_CONSULTA
	//			FROM 	CRM_CONSULTA
	//			WHERE   ID_CRM_PERSONA = ? " ;

	//$query_consultas = $this->db->query( $sql , array( $id_crm_persona ) );

	//if( $query_consultas->num_rows() > 0):


	//	foreach ($query_consultas->result() as $row):


	//			$this->Consulta_model->eliminar_consulta($row->ID_CRM_CONSULTA);

	//	endforeach;


	//endif;

	$this->db->trans_complete();


	if ($this->db->trans_status() === FALSE)
	{
	    $this->db->trans_rollback();
	    return false;
	}
	else
	{
	    $this->db->trans_commit();

	    if($this->db->affected_rows() > 0)
	    	return true;
	    else
	    	return false;

	}

}*/

public function eliminar_contacto_crm($id_crm_persona)
{
	chrome_log2(" eliminar_contacto_crm: ".$id_crm_persona);
	$array_where = array( 'ID_CRM_PERSONA' => $id_crm_persona );

	$persona['ENABLED'] = 0;
	$this->db->where($array_where);
	$this->db->update('CRM_PERSONA', $persona);

	if($this->db->affected_rows() > 0)
	    	return true;
	    else
	    	return false;

}



public function existe_persona_crm($id_crm_persona)
{
	chrome_log2("Consulta_model/existe_persona_crm");

	$sql =	"	SELECT  *
    			FROM	CRM_PERSONA cp
    			WHERE 	cp.ID_CRM_PERSONA = ?
    			AND 	cp.ENABLED = 1 "  ;

	$query = $this->db->query($sql, array($id_crm_persona));

	if($query->num_rows() > 0)
		return false;
	else
		return true;
}


public function existe_dni_crm($id_crm_persona)
{
	chrome_log2("existe_dni_crm");

	chrome_log2("	SELECT cd.NUMERO
				FROM CRM_PERSONA_DOCUMENTO cd, CRM_PERSONA_DOCUMENTO_TIPO ctp
				WHERE cd.ID_TIPO_DOCUMENTO = ctp.ID_TIPO_DOCUMENTO
				AND ctp.DESCRIPCION = 'DNI'
				AND cd.ID_CRM_PERSONA =  $id_crm_persona ");

	$sql = "	SELECT cd.NUMERO
				FROM CRM_PERSONA_DOCUMENTO cd, CRM_PERSONA_DOCUMENTO_TIPO ctp
				WHERE cd.ID_TIPO_DOCUMENTO = ctp.ID_TIPO_DOCUMENTO
				AND ctp.DESCRIPCION = 'DNI'
				AND cd.ID_CRM_PERSONA =  ? " ;

	$query = $this->db->query($sql, array($id_crm_persona));


	if($query->num_rows() > 0)
		return $query->row()->NUMERO;
	else
		return false;
}

public function existe_dni_sigeu($dni)
{
	chrome_log2("existe_dni_sigeu");

	chrome_log2("SELECT *
				FROM PERSONAS p
				WHERE  p.N_DOCUMENTO = $dni ");

	$sql = "	SELECT *
				FROM PERSONAS p
				WHERE  p.N_DOCUMENTO = ? " ;

	$query = $this->db->query($sql, array($dni));

	if($query->num_rows() > 0)
		return true;
	else
		return false;
}

public function existe_empresa_persona_crm($id_crm_persona, $id_empresa)
{
	chrome_log2("existe_empresa_persona_crm");

 
	$sql = "	SELECT *
				FROM CRM_PERSONA_EMPRESA pe
				WHERE  pe.ID_CRM_PERSONA = ? 
				AND pe.ID_EMPRESA = ? " ;

	$query = $this->db->query($sql, array($id_crm_persona,$id_empresa ));

	if($query->num_rows() > 0)
		return true;
	else
		return false;
}



public function existe_sexo_persona($id_crm_persona)
{
	chrome_log2("Consulta_model/existe_sexo_persona");

	chrome_log2("	SELECT  *
    			FROM	CRM_PERSONA cp
    			WHERE 	cp.ID_CRM_PERSONA = $id_crm_persona
    			AND 	cp.SEXO IS NOT NULL ");

	$sql =	"	SELECT  *
    			FROM	CRM_PERSONA cp
    			WHERE 	cp.ID_CRM_PERSONA = ?
    			AND 	cp.SEXO IS NOT NULL "  ;

	$query = $this->db->query($sql, array($id_crm_persona));

	if($query->num_rows() > 0)
		return false;
	else
		return true;
}


public function existe_id_persona($id_crm_persona)
{
	chrome_log2("existe_dni_sigeu");


	$sql =	"	SELECT  *
    			FROM	CRM_PERSONA cp
    			WHERE 	cp.ID_CRM_PERSONA = ?
    			AND 	cp.ENABLED = 1
    			AND 	cp.ID_PERSONA IS NOT NULL"  ;

	$query = $this->db->query($sql, array($id_crm_persona));

	if($query->num_rows() > 0)
		return true;
	else
		return false;
}

public function existe_email_crm($email)
{
	chrome_log2("existe_email_crm");

	$sql =	"	SELECT  *
    			FROM	CRM_PERSONA_EMAIL ce
    			WHERE 	ce.EMAIL = ? "  ;

	$query = $this->db->query($sql, array($email));

	if($query->num_rows() > 0)
		return true;
	else
		return false;
}

//[CAMBIAR BUSQUEDA DE EMAILS]
public function enviar_persona_sigeu($id_crm_persona)
{
	chrome_log2("enviar_alumno_sigeu");

	$this->db->trans_start();

		// Datos persona
		$datos_persona = $this->traer_informacion_crm_persona($id_crm_persona);

		$id_crm_persona = $datos_persona->ID_CRM_PERSONA;

	//------------------- INGRESAR A PERSONAS -----------------------

		// CONSTRAINT:
		// 1. Apellido, nombre, sexo, f_alta, c_usuario_alta: NOT null
		// 2. N_id_persona = PK
		// 3. C_TIPO_DOC y N_DOC = unique
		// 4. C_USUARIO_WEB = fk

		$id_persona = $this->db->query('SELECT id_persona.NEXTVAL as ID_PERSONA from dual')->row()->ID_PERSONA;

		$this->db->set('N_ID_PERSONA', $id_persona , false);
    	$this->db->set('F_ALTA',"TO_CHAR(SYSDATE)",false);

		$persona = array(  	'D_APELLIDOS' => $datos_persona->APELLIDO,
							'D_NOMBRES' => $datos_persona->NOMBRE,
					        'PERSONA_TYPE' => 'Estudiante',
							'M_SEXO' => $datos_persona->SEXO,
					        'C_VINCULO' => 'A',
					        'C_USUARIOALT' => $this->session->userdata('usuario_crm')
					    );

		// --- Documentos---
 		$datos_documentos = $this->traer_documentos_crm($id_crm_persona);

		if( count($datos_documentos) > 0): // Existe el DNI

			foreach ($datos_documentos as $row_dni)
			{
				if($row_dni['TIPO'] == 'DNI'):

					$persona['C_TIPO_DOCUMENTO'] = 'DNI';
					$persona['N_DOCUMENTO'] = $row_dni['NUMERO'];

				endif;

			}

		endif;

		$this->db->insert('PERSONAS',$persona);

		// Actualizar crm_persona

		$this->actualizar_persona_enviada_sigeu($id_crm_persona,$id_persona);


	//------------------- INGRESAR A CORREOS -----------------------

		$datos_emails = $this->traer_emails_crm($id_crm_persona);

		if( count($datos_emails) > 0 ):

			$x = 1;

			foreach ($datos_emails  as $row_email)
			{
				$c_correo = "e-mail ".$x;

				$this->db->set('F_ALTA',"TO_CHAR(SYSDATE)",false);

				$correo = array(  	'N_ID_PERSONA' => $id_persona,
									'C_CORREO' => $c_correo,
									'C_EMAIL' => $row_email['EMAIL'],
									'C_USUARIOALT' => $this->session->userdata('usuario_crm')
							    );

				$x++;

				$this->db->insert('CORREOS',$correo);

			}

			// Borro los correos de CRM

		    $this->db->where('ID_CRM_PERSONA', $id_crm_persona);
      		$this->db->delete('CRM_PERSONA_EMAIL');

		endif;

	//------------------- INGRESAR A TELEFONO -----------------------

		$datos_telefonos = $this->traer_telefonos_crm($id_crm_persona);

		if( count($datos_telefonos) > 0 ):

			$y = 1;

			foreach ($datos_telefonos  as $row_telefono)
			{
				$c_telefono = "Particular ".$y;

				$this->db->set('F_ALTA',"TO_CHAR(SYSDATE)",false);

				$telefono = array(  	'N_ID_PERSONA' => $id_persona,
										'C_TELEFONO' => $c_telefono,
										'N_TELEFONO' => $row_telefono['TELEFONO'],
										'C_USUARIOALT' => $this->session->userdata('usuario_crm')
							    );

				$y++;

				$this->db->insert('TELEFONOS',$telefono);

			}

			// Borro los correos de CRM

		    $this->db->where('ID_CRM_PERSONA', $id_crm_persona);
      		$this->db->delete('CRM_PERSONA_TELEFONO');

		endif;


 	//------------------- INGRESAR EDUCACION -----------------------

		$datos_educacion = $this->traer_educacion_crm($id_crm_persona);

		if( count($datos_educacion) > 0 ):

			foreach ($datos_educacion as $row_educacion)
			{
				$n_id_educacion = $this->db->query('SELECT ID_EDUCACION.NEXTVAL as N_ID_EDUCACION from dual')->row()->N_ID_EDUCACION;
				$this->db->set('N_ID_EDUCACION', $n_id_educacion , false);
				$this->db->set('F_ALTA',"TO_CHAR(SYSDATE)",false);

				$id_nivel = $row_educacion['ID_NIVEL_EDUCACION'];
				$descripcion_nivel = $this->db->query("SELECT DESCRIPCION FROM CRM_PERSONA_EDUCACION_NIVEL WHERE ID_NIVEL_EDUCACION = '$id_nivel' ")->row()->DESCRIPCION;

				$educaciones = array(  	'N_ID_PERSONA' => $id_persona,
										'C_USUARIOALT' => $this->session->userdata('usuario_crm'),
										'C_NIVEL' => $descripcion_nivel
							    );

				if(isset($row_educacion['ID_EMPRESA']))
					$educaciones['N_ID_ESTABLEC'] =  $row_educacion['ID_EMPRESA'];

				if(isset($row_educacion['NOMBRE']))
					$educaciones['D_ESTABLECIMIENTO'] =  $row_educacion['NOMBRE'];

				$this->db->insert('EDUCACION',$educaciones);

			}

			// Borro los correos de CRM

		    $this->db->where('ID_CRM_PERSONA', $id_crm_persona);
      		$this->db->delete('CRM_PERSONA_EDUCACION');

		endif;

	//------------------- INGRESAR EMPRESA -----------------------


		$datos_experiencia_laboral = $this->traer_experiencia_laboral_crm($id_crm_persona);

		if( count($datos_experiencia_laboral) > 0 ):

			foreach ($datos_experiencia_laboral as $row_experiencia_laboral)
			{
				$n_id_ocupacion = $this->db->query('SELECT ID_OCUPACION.NEXTVAL as N_ID_OCUPACION from dual')->row()->N_ID_OCUPACION;
				$this->db->set('N_ID_OCUPACION', $n_id_ocupacion , false);
				$this->db->set('F_ALTA',"TO_CHAR(SYSDATE)",false);

				$experiencia_laboral = array(  	'N_ID_PERSONA' => $id_persona,
										'C_USUARIOALT' => $this->session->userdata('usuario_crm'),
										'M_ACTUAL' => 'No'
							    );

				if(isset($row_experiencia_laboral['ID_EMPRESA']))
					$experiencia_laboral['N_ID_EMPRESA'] =  $row_experiencia_laboral['ID_EMPRESA'];

				if(isset($row_experiencia_laboral['EMPRESA']))
					$experiencia_laboral['D_EMPRESA'] =  $row_experiencia_laboral['EMPRESA'];

				if(isset($row_experiencia_laboral['CARGO']))
					$experiencia_laboral['D_CARGO'] =  $row_experiencia_laboral['CARGO'];

				if(isset($row_experiencia_laboral['DESCRIPCION_CARGO']))
					$experiencia_laboral['D_DESCRIP'] =  $row_experiencia_laboral['DESCRIPCION_CARGO'];


				$this->db->insert('OCUPACIONES',$experiencia_laboral);

			}

			// Borro los correos de CRM

		    $this->db->where('ID_CRM_PERSONA', $id_crm_persona);
      		$this->db->delete('CRM_PERSONA_EMPRESA');



		endif;

		$this->Contacto_model->insertar_log_persona( 13 , $id_crm_persona ); // Enviar a SIGEU

	$this->db->trans_complete();

	return $this->db->trans_status();
}


public function actualizar_persona_enviada_sigeu($id_crm_persona, $id_persona)
{
	chrome_log2("Consulta_model/borar_datos_crm_persona");

	$where_id_persona = array( 'ID_CRM_PERSONA' => $id_crm_persona );
    $persona['ID_PERSONA'] = $id_persona;
    $persona['APELLIDO'] = NULL;
	$persona['NOMBRE'] = NULL;
	$persona['SEXO'] = NULL;

    $this->db->where($where_id_persona);
    $this->db->update('CRM_PERSONA', $persona);

	return $this->db->affected_rows();
}

public function insertar_log_persona($id_tipo_log, $id_crm_persona, $id_consulta=NULL, $texto =NULL,  $id_evento=NULL )
{
	$this->db->set('ID_CRM_LOG_PERSONA', "ID_CRM_LOG_PERSONA.NEXTVAL", false);

	$array_log['ID_TIPO_LOG_CONSULTA'] = $id_tipo_log;
	$array_log['ID_CRM_PERSONA'] = $id_crm_persona;
	$array_log['USUARIO'] = $this->session->userdata('usuario_crm');

	if(isset($texto))
		$array_log['TEXTO'] =  $texto;

	if(isset($id_consulta))
		$array_log['ID_CRM_CONSULTA'] =  utf8_decode($id_consulta);

	if(isset($id_evento))
		$array_log['ID_CRM_EVENTO'] =  utf8_decode($id_evento);

	$this->db->insert('CRM_PERSONA_LOG',$array_log);
}


public function traer_log_persona($id_crm_persona)
{
	chrome_log2("traer_log_consulta");

	$sql =	"	SELECT *
				FROM CRM_PERSONA_LOG cl, CRM_TIPO_LOG ctl
				WHERE ID_CRM_PERSONA = ?
				AND cl.ID_TIPO_LOG_CONSULTA = ctl.ID_TIPO_LOG_CONSULTA
				ORDER BY FECHA ASC"  ;

	$query = $this->db->query($sql, array($id_crm_persona));

	return $query;
}

}
?>