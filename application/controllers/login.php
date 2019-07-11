<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {


	public function __construct()
	{
		parent::__construct();

	}

	//
	public function index()
	{
		if(!isset($_POST['usuario'])):


			$this->load->view('login');

		else:

			chrome_log("Ingreso submit");

			if ( $this->form_validation->run('loguearse') == FALSE ): // INVALIDO

				chrome_log("Invalido");
				sleep(5);
				show_error("No paso validacion ", 500);

			else: // VALIDO

				chrome_log("Valido");
				putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8"); 
        		header('Content-Type: text/html; charset=utf-8');

 
				$c['hostname'] = "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=pluton.ucema.edu.ar)(PORT=1521))(CONNECT_DATA=(SERVICE_NAME=pdbpluton.ucema.edu.ar)))";
				//$c['hostname'] = "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=localhost)(PORT=11521))(CONNECT_DATA=(SID=CEMA)))";
				$c['database'] = "cema";

 

				//----- Servidor de produccion nuevo----//

				//$c['hostname'] = "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=neptuno.ucema.edu.ar)(PORT=1521))(CONNECT_DATA=(SERVICE_NAME=cema.ucema.edu.ar)))";
				//$c['hostname'] = "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=localhost)(PORT=1521))(CONNECT_DATA=(SID=CEMA)))";
				//$c['database'] = "cema";

				$c['username'] = $_POST['usuario'];
				$c['password'] = $_POST['clave'];
				$c['dbdriver'] = "oci8";
				$c['dbprefix'] = "";
				$c['pconnect'] = FALSE;
				$c['db_debug'] = TRUE;
				$c['cache_on'] = FALSE;
				$c['cachedir'] = "";
				//$c['char_set'] = "WE8ISO8859P1";
				//$c['dbcollat'] = "";
				$active_record = TRUE;


				//  Conexion a la DB ------------------------------------------------------

				$this->session->set_userdata('DB',$c);
				$this->db = $this->load->database($c, TRUE, TRUE);


				// ROLES --------------------------------------------------------------------

				$this->load->model('Login_model'); // Cargo el modelo

				$roles = $this->Login_model->traer_roles(strtoupper($_POST['usuario'])); // Busco los roles

				if( $roles->num_rows() > 0 )	//
				{
					chrome_log("Encontro roles");

					$usuario_oracle = strtoupper($_POST['usuario']);

					$persona = $this->Login_model->traer_info_persona($usuario_oracle);


					// Variables de session
	        		$this->session->set_userdata('usuario_crm',$usuario_oracle);
	        		$this->session->set_userdata('id_persona', $persona->N_ID_PERSONA );
	        		$this->session->set_userdata('nombre', utf8_encode($persona->D_NOMBRES.",".$persona->D_APELLIDOS) );

	        		$email = $this->Login_model->traer_email_persona($persona->N_ID_PERSONA);

	        		$this->session->set_userdata('email', $email );

	        		$array_roles = array();

	        		foreach($roles->result() as $row):

	        			array_push($array_roles, $row->ROL);

	        		endforeach;

	        		$this->session->set_userdata('roles', $array_roles );

	        		sleep(2);
	        		redirect(base_url()."index.php/home");
				}
				else
				{
 
					sleep(5);
					show_error("No tiene <strong>ROLES</strong> para ingresar al sistema, comuniquese con sistemas. ", 500);

				}

			endif;


		endif;


	}

	/*
	function traer_email_persona($id_persona)
    {

    	$resultado = $this->db->query("	SELECT DEVUELVE_CORREO_INTERNO($id_persona) as email
										FROM dual" );

    	return $resultado->row()->EMAIL;
    }*/

	// Desloguea al usuario

	public function logout()
	{
		$this->session->unset_userdata('usuario_crm');
		$this->session->unset_userdata('id_persona');
		$this->session->unset_userdata('DB');

		$this->db->close();
		session_destroy();
		redirect(base_url()."index.php/login");

	}


}

/* End of file login.php */
/* Location: ./application/controllers/login.php */
?>