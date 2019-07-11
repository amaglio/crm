<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();

	}


	function traer_id_persona($usuario_oracle)
    {

    	$resultado = $this->db->query("	SELECT p.n_id_persona
						    			FROM personas p
						    			WHERE p.user_oracle = '$usuario_oracle' " );

    	return $resultado->row();
    }


	function traer_info_persona($usuario_oracle)
    {

    	$resultado = $this->db->query("	SELECT p.n_id_persona, p.d_nombres, p.d_apellidos
						    			FROM personas p
						    			WHERE p.user_oracle = '$usuario_oracle' " );

    	return $resultado->row();
    }

    function traer_roles($usuario)
	{	

		$resultado = $this->db->query("		SELECT granted_role as ROL
											FROM dba_role_privs
											WHERE ( granted_role = 'CRM_ADMISIONES'	OR 
												    granted_role = 'CRM_ESCUELA_DE_NEGOCIOS' )
											AND	 grantee = '$usuario'
										");

		return $resultado;
	}

	function traer_email_persona($id_persona)
    {

    	$resultado = $this->db->query("	SELECT DEVUELVE_CORREO_INTERNO($id_persona) as email
										FROM dual" );

    	return $resultado->row()->EMAIL;
    }

	function traer_nombre_persona_by_id($id_persona)
    {

    	$resultado = $this->db->query("	SELECT D_APELLIDOS  || ', ' || D_NOMBRES as nombre
										FROM PERSONAS
										WHERE N_ID_PERSONA = $id_persona" );

    	return $resultado->row()->NOMBRE;
    }

    function traer_nombre_persona_by_email($email)
    {

    	$resultado = $this->db->query("	SELECT D_APELLIDOS  || ', ' || D_NOMBRES as nombre
										FROM CORREOS C, PERSONAS P
										WHERE C.N_ID_PERSONA = p.N_ID_PERSONA
										AND C.C_EMAIL = '$email'

										UNION

										SELECT APELLIDO  || ', ' || NOMBRE as nombre
										FROM Crm_Persona_Email e, crm_persona p
										WHERE e.ID_CRM_PERSONA = p.ID_CRM_PERSONA
										AND E.EMAIL = '$email' " );

    	return $resultado->row()->NOMBRE;
    }

	function traer_nombre_persona_by_id_consulta($id_consulta)
    {

    	$resultado = $this->db->query("	SELECT APELLIDO  || ', ' || NOMBRE as nombre
										FROM CRM_CONSULTA c, CRM_PERSONA P
										WHERE c.Id_Crm_Persona = P.Id_Crm_Persona
										AND C.Id_Crm_Consulta = $id_consulta" );

    	return $resultado->row()->NOMBRE;
    }


	function traer_id_controlador($nombre_controlador)
    {	
    	$nombre_controlador= strtoupper($nombre_controlador);

    	$resultado = $this->db->query("	SELECT id_crm_controlador
										FROM CRM_CONTROLADOR
										WHERE NOMBRE = '$nombre_controlador' " );

    	if( $resultado->num_rows() > 0 )
    		return $resultado->row()->ID_CRM_CONTROLADOR; 
    	else
    		return false;
    }


	function tiene_permiso($nombre_controlador)
    {	
    	$nombre_controlador = strtoupper($nombre_controlador);

        $array_roles  = $this->session->userdata('roles');
        foreach ($array_roles as $row) 
        {
        	
        	$controlador = $this->db->query("	SELECT *
												FROM CRM_CONTROLADOR cc
											     	 INNER JOIN CRM.Crm_Controlador_Rol cr ON cc.ID_CRM_CONTROLADOR = cr.ID_CRM_CONTROLADOR
												WHERE cr.ROL = ?
												AND cc.nombre = ? ", array($row, $nombre_controlador ) );

        	if( $controlador->num_rows() > 0 ){
        		return true;
        	}
        }

        return false;

   	 
    }

}

/* End of file  */
/* Location: ./application/models/ */