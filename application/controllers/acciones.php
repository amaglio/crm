<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Acciones extends CI_Controller {


public function __construct()
{
	parent::__construct();
	$this->load->model('Consulta_model');
	$this->load->model('Contacto_model');
	$this->load->model('Configuracion_model');
	$this->load->model('Login_model');
	//$this->load->model('Bd_accciones');
	$this->db = $this->load->database($this->session->userdata('DB'),TRUE, TRUE);

	// Cuando lo activo, no funciona el AJAX de mostrar programas
	//$this->output->enable_profiler(TRUE);
}

public function index()
{
	for($z=0 ; $z < 100; $z++):

		$this->db->trans_start();

		//  BUSCAR APELLIDO

		do{

			$sql_personas = '	SELECT D_APELLIDOS
								FROM personas
								WHERE N_ID_PERSONA = trunc(dbms_random.value(30000,38000))  ';

			$query = $this->db->query( $sql_personas);

		}while( !isset($query->row()->D_APELLIDOS));


		$apellido = $query->row()->D_APELLIDOS;

	 	//  BUSCAR NOMBRE

	 	do{

			$sql_personas = '	SELECT D_NOMBRES
								FROM personas
								WHERE N_ID_PERSONA = trunc(dbms_random.value(30000,38000))  ';

			$query = $this->db->query( $sql_personas);

		}while( !isset($query->row()->D_NOMBRES));


		$nombre = $query->row()->D_NOMBRES;

	 	//  BUSCAR EMAIL

	 	$ran_correo = mt_rand( 1 , 2 );

	 	if( $ran_correo == 1 ): // traigo uno de la tabla de correos


			 	do{

					$sql_email = '	SELECT C_EMAIL
										FROM correos
										WHERE N_ID_PERSONA = trunc(dbms_random.value(30000,38000))
										and C_EMAIL is not null
										and ROWNUM = 1  ';

					$query = $this->db->query( $sql_email);

				}while( !isset($query->row()->C_EMAIL));

				$email = $query->row()->C_EMAIL;
	 	else:

	 			$email = "email_".gmdate('U')."@email.com";

	 	endif;

	 	//  BUSCAR TELEFONO

	 	$ran_telefono = mt_rand( 1 , 2 );

	 	if( $ran_telefono == 1 ): // traigo uno de la tabla de correos


			 	do{

					$sql_telefono = '	SELECT N_TELEFONO
										FROM telefonos
										WHERE N_ID_PERSONA = trunc(dbms_random.value(30000,38000))
										and C_TELEFONO is not null
										and ROWNUM = 1  ';

					$query = $this->db->query( $sql_telefono);

				}while( !isset($query->row()->N_TELEFONO));

				$telefono = "'".$query->row()->N_TELEFONO."'";
	 	else:

	 			$telefono = "15".gmdate('U');

	 	endif;


		$institucion ="NULL";
		$empresa="NULL ";
		$cargo="NULL ";
		$comentario=" NULL";


		$sql_contacto = "INSERT INTO crm_contacto_web
	                            (   ID_CONTACTO_WEB,
	                                NOMBRE,
	                                APELLIDO,
	                                EMAIL,
	                                TELEFONO,
	                                INSTITUCION,
	                                EMPRESA,
	                                CARGO,
	                                REFERRER,
	                                COMENTARIO
	                            )
	                    VALUES
	                            (     ID_CONTACTO_WEB.nextval,
	                                  '$nombre',
	                                  '$apellido',
	                                  '$email',
	                                   $telefono,
	                                 $institucion,
	                                 $empresa,
	                                 $cargo,
	                                 'HTTP:CONTACTO.COM',
	                                 $comentario
	                            )";

		$this->db->query( $sql_contacto);


		$sql_id = "SELECT MAX(ID_CONTACTO_WEB) AS ID_CONTACTO_WEB FROM crm_contacto_web";
		$query = $this->db->query( $sql_id);

	    $id_contacto_web = $query->row()->ID_CONTACTO_WEB;


	    // PROGRAMAS

	    $ran_programa = mt_rand( 1 , 2 );
	    $ran_cantidad = mt_rand( 1 , 5 );

	    for($x=0; $x <= $ran_cantidad; $x++)
	    {
		    switch ( $ran_programa)
			{

		    	case '1': // Programas  de grado

		    		do{

						$sql_programa = '	SELECT C_IDENTIFICACION, C_PROGRAMA, C_ORIENTACION
		 									FROM programas
											WHERE c_identificacion = 1
											AND c_programa = trunc(dbms_random.value(0,12))
											AND c_orientacion = trunc(dbms_random.value(0,5))  ';

						$query = $this->db->query( $sql_programa);

					}while( !isset($query->row()->C_IDENTIFICACION) && !isset($query->row()->C_PROGRAMA) && !isset($query->row()->C_ORIENTACION));

					$c_identificacion =  $query->row()->C_IDENTIFICACION;
					$c_programa =  $query->row()->C_PROGRAMA;
					$c_orientacion =  $query->row()->C_ORIENTACION;

		    		break;

		    	case '2': // Programas  de posgrado

		    		do{

						$sql_programa = '	SELECT C_IDENTIFICACION, C_PROGRAMA, C_ORIENTACION
		 									FROM programas
											WHERE c_identificacion = 2
											AND c_programa = trunc(dbms_random.value(0,17))
											AND c_orientacion = trunc(dbms_random.value(0,5))  ';

						$query = $this->db->query( $sql_programa);

					}while( !isset($query->row()->C_IDENTIFICACION) && !isset($query->row()->C_PROGRAMA) && !isset($query->row()->C_ORIENTACION));

					$c_identificacion =  $query->row()->C_IDENTIFICACION;
					$c_programa =  $query->row()->C_PROGRAMA;
					$c_orientacion =  $query->row()->C_ORIENTACION;

		    		break;

		    	case '3': // Programas  de posgrado

		    		do{

						$sql_programa = '	SELECT C_IDENTIFICACION, C_PROGRAMA, C_ORIENTACION
		 									FROM programas
											WHERE c_identificacion = 1
											AND c_programa = trunc(dbms_random.value(0,29))
											AND c_orientacion = trunc(dbms_random.value(0,5))  ';

						$query = $this->db->query( $sql_programa);

					}while( !isset($query->row()->C_IDENTIFICACION) && !isset($query->row()->C_PROGRAMA) && !isset($query->row()->C_ORIENTACION));

					$c_identificacion =  $query->row()->C_IDENTIFICACION;
					$c_programa =  $query->row()->C_PROGRAMA;
					$c_orientacion =  $query->row()->C_ORIENTACION;

		    		break;
		    }

		    $sql_prg_inte = "INSERT INTO CRM_CONTACTO_WEB_PRG_INT
	                                (     ID_CONTACTO_WEB,
	                                    C_IDENTIFICACION,
	                                    C_PROGRAMA,
	                                    C_ORIENTACION
	                                )
	                        VALUES
	                                (     '$id_contacto_web',
	                                      '$c_identificacion',
	                                      '$c_programa',
	                                      '$c_orientacion'
	                                )";

		    $query = $this->db->query( $sql_prg_inte);

		}

		// PERIODO DE INGRESO

		$anio = '2017';

		if($c_identificacion = 1)
			$id_periodo = mt_rand( 1 , 2 );
		else
			$id_periodo = mt_rand( 3, 5);

		$sql_prg_inte = "INSERT INTO CRM_CONTACTO_WEB_PER_ING
	                                (
	                                    ID_CONTACTO_WEB,
	                                    ANIO,
	                                    ID_PERIODO
	                                )
	                        VALUES
	                                (     '$id_contacto_web',
	                                      '$anio',
	                                      '$id_periodo'
	                                )";

		$query = $this->db->query( $sql_prg_inte);


		//----- INSERTAR COMO CONTACTARLO

	   $id_medio = mt_rand( 1 , 3 );

	   if( $id_medio == 2  || $id_medio == 3 )
	   		$horario   = '9 a 18';
	   	else
	   		$horario   = "NULL";

	   	$sql_como_contac = "INSERT INTO CRM_CONTACTO_WEB_CONTACTENLO
	                            (
	                                ID_CONTACTO_WEB,
	                                ID_MEDIO_CONTACTENME,
	                                HORARIO
	                            )
	                    VALUES
	                            (     '$id_contacto_web',
	                                  '$id_medio',
	                                  '$horario'
	                            )";

		$query = $this->db->query( $sql_como_contac);

		//----- INSERTAR COMO INFORMACION INTERES ---- ( 1 o N )

	        $medios_cant = mt_rand( 1 , 3 );
	        $id_info_interes =  mt_rand( 1 , 5 );

	        for($x = 0; $x< $medios_cant; $x++):

		        $sql_inte = "INSERT INTO CRM_CONTACTO_WEB_INFO_INTERES
		                                (
		                                    ID_CONTACTO_WEB,
		                                    ID_INFO_INTERES
		                                )
		                            VALUES
		                                (     '$id_contacto_web',
		                                      '$id_info_interes'
		                                )";

				$query = $this->db->query( $sql_inte);

			endfor;


	 	$this->db->trans_complete();


		if ($this->db->trans_status() === FALSE)
		{
		      $this->db->trans_rollback();
		      $flag = false;
		}
		else
		{
		      $this->db->trans_commit();
		}

	endfor;
}


}

?>