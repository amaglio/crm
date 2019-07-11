<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Operador_model extends CI_Model {
 
  public function __construct()
  {

  	parent::__construct();
  }
   

  function get_operadores()
  {

  	$resultado = $this->db->query("SELECT *
                                    FROM DBA_ROLE_PRIVS r
                                         INNER JOIN personas p ON r.GRANTEE = p.user_oracle
                                    WHERE r.granted_role like '%CRM_ADMISIONES%'
                                    AND GRANTEE != 'CEMAP'  "
                  				    		);

  	return $resultado->result_array();
  }

  function get_consultas_asignadas_por_operadores()
  {

    $resultado = $this->db->query(" SELECT r.GRANTEE, count(cc.id_crm_consulta) as cantidad
                                    FROM DBA_ROLE_PRIVS r
                                         INNER JOIN personas p ON r.GRANTEE = p.user_oracle
                                         LEFT JOIN CRM_OPERADOR_A_CARGO oc on oc.n_id_persona = p.n_id_persona
                                         LEFT JOIN v_crm_consulta_activa cc on oc.id_crm_consulta = cc.id_crm_consulta
                                    WHERE r.granted_role like '%CRM_ADMISIONES%'
                                    AND r.GRANTEE != 'CEMAP'
                                    GROUP BY r.GRANTEE"
                                  );

    return $resultado->result_array();
  }


}

/* End of file  */
/* Location: ./application/models/ */