<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Alarma_model extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();

	}
 

	function get_mis_alarmas()
	{
		chrome_log("Alarma_model/get_mis_alarmas"); 

		$resultado = $this->db->query(" SELECT ca.id_crm_consulta_alarma, ca.descripcion, ca.fecha,ca.id_crm_consulta,
										       get_nombre_apellido(id_crm_persona) as nombre_apellido
										FROM CRM_CONSULTA_ALARMA ca
										     INNER JOIN CRM_CONSULTA cc ON ca.id_crm_consulta = cc.id_crm_consulta
										WHERE  ca.C_USUARIO_ALTA = ? ", array( $this->session->userdata('usuario_crm') ) );

		return $resultado->result_array();
 
	}

	function get_tipos_de_alarmas()
	{
		chrome_log("Alarma_model/get_tipos_de_alarmas"); 

		$resultado = $this->db->query(" SELECT *
										FROM CRM_CONSULTA_ALARMA_TIPO " ) ;

		return $resultado->result_array();
 
	}

	function get_descripcion_tipo_alarma_by_id($id_tipo_alarma)
	{
		chrome_log("Alarma_model/get_tipos_de_alarmas".$id_tipo_alarma); 

		$resultado = $this->db->query(" SELECT *
										FROM CRM_CONSULTA_ALARMA_TIPO 
										WHERE id_tipo_alarma = ? " , array( $id_tipo_alarma ) ) ;

		return $resultado->row()->DESCRIPCION;
 
	}


	function buscar_alarmas($array, &$filtros )
	{
		chrome_log("Alarma_model/get_tipos_de_alarmas"); 
		$variables = array( $this->session->userdata('usuario_crm') );
		$filtros = '<ul class="list-group">';

		$sql = "SELECT ca.id_crm_consulta_alarma, ca.descripcion, ca.fecha,ca.id_crm_consulta,
       				  get_nombre_apellido(id_crm_persona) as nombre_apellido
				FROM CRM_CONSULTA_ALARMA ca
				     INNER JOIN CRM_CONSULTA cc ON ca.id_crm_consulta = cc.id_crm_consulta
				WHERE   ca.C_USUARIO_ALTA = ?  ";


	    if(isset($array['fecha_desde']) && !empty($array['fecha_desde']) ):
	    	$sql .= "AND  ca.fecha >= ? ";
	    	array_push($variables, $array['fecha_desde']);
	    	$filtros .= '<li class="list-group-item"  > <strong> Fecha desde: </strong>'. $array['fecha_desde']."</li>";
	    endif;


	    if(isset($array['fecha_hasta']) && !empty($array['fecha_hasta'])):
	    	$sql .= "AND  ca.fecha <= ? ";
	    	array_push($variables, $array['fecha_hasta']);
	    	$filtros .= '<li class="list-group-item"  > <strong> Fecha hasta: </strong>'. $array['fecha_hasta']."</li>";
	    endif;

	    if( $array['id_tipo_alarma'] != -1 ):
	    	$sql .= "AND  ca.id_tipo_alarma = ?";
	   		array_push($variables, $array['id_tipo_alarma']);
	   		$filtros .= '<li class="list-group-item"  >  <strong> Tipo Alarma: </strong>'.$this->get_descripcion_tipo_alarma_by_id($array['id_tipo_alarma'])."</li>";
	    endif;

	    $filtros .= '</ul>';


	    $resultado = $this->db->query( $sql, $variables );

	    return $resultado->result_array();


	}

}

/* End of file  */
/* Location: ./application/models/ */