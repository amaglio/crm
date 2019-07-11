<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Importador_model extends CI_Model {

public $variable;

public function __construct()
{

	parent::__construct();
}

function traer_contactos_a_importar()
{

	$resultado = $this->db->query("	SELECT *
					    			FROM CRM_CONTACTO_WEB
					    			WHERE IMPORTADO = 0
					    			ORDER BY FECHA_ALTA DESC " );

	return $resultado;
}

function traer_programas_interes_contacto($id_contacto_web)
{

	$sql =  "	SELECT pi.C_PROGRAMA, pi.C_ORIENTACION, pi.C_IDENTIFICACION, pr.D_DESCRIP, pr.D_DESCRED
				FROM CRM_CONTACTO_WEB_PRG_INT pi, PROGRAMAS pr
				WHERE pi.C_IDENTIFICACION = pr.C_IDENTIFICACION
				AND pi.C_PROGRAMA = pr.C_PROGRAMA
				AND pi.C_ORIENTACION = pr.C_ORIENTACION
				AND pi.ID_CONTACTO_WEB = ? " ;

	$resultado = $this->db->query( $sql, array($id_contacto_web) );

	return $resultado;
}

function traer_periodo_ingreso_contacto($id_contacto_web)
{

	$sql =  "	SELECT cwp.anio, pi.descripcion
				FROM CRM_CONTACTO_WEB_PER_ING cwp, CRM_PERIODO_INGRESO pi
				WHERE cwp.ID_PERIODO = pi.ID_PERIODO_INGRESO
				AND cwp.ID_CONTACTO_WEB = ? " ;

	$resultado = $this->db->query( $sql, array($id_contacto_web) );

	return $resultado->row();
}

function traer_como_contactarlo($id_contacto_web)
{

	$sql =  "	SELECT  cwc.horario, mc.*
				FROM CRM_CONTACTO_WEB_CONTACTENLO cwc, CRM_MEDIO_CONTACTENME mc
				WHERE cwc.ID_MEDIO_CONTACTENME = mc.ID_CONTACTENME
				AND ID_CONTACTO_WEB = ?  " ;

	$resultado = $this->db->query( $sql, array($id_contacto_web) );

	return $resultado;
}

function traer_info_interes($id_contacto_web)
{

	$sql =  "	SELECT ii.*
				FROM CRM_CONTACTO_WEB_INFO_INTERES cwi, CRM_INFORMACION_INTERES ii
				WHERE ii.ID_INFO_INTERES = cwi.ID_INFO_INTERES
				AND ID_CONTACTO_WEB = ?  " ;

	$resultado = $this->db->query( $sql, array($id_contacto_web) );

	return $resultado;
}




}

/* End of file  */
/* Location: ./application/models/ */