<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Consulta_model extends CI_Model {

//public $variable;

public function __construct()
{

	parent::__construct();
}

public function  traer_ultimas_consultas_importadas()
{
	chrome_log2("traer_ultimas_consultas_importadas");
	// Desde el home, ingresando en "Ver mas consultas" (http://crm/index.php/consulta)
	$sql =	"	SELECT *
				FROM
				          (	SELECT cc.id_crm_consulta, cc.fecha as fecha_consulta, cc.id_medio_consulta, cc.COMENTARIO_CONSULTA, cc.id_crm_persona,
				                  res.anio, res.id_periodo_ingreso, res.descripcion, cc.id_estado_consulta
				          	FROM v_crm_consulta_activa cc
				               	 LEFT JOIN CRM_MEDIO_CONSULTA mc ON cc.ID_MEDIO_CONSULTA = mc.ID_MEDIO_CONSULTA
				               	 LEFT JOIN (  SELECT *
				                            FROM CRM_CONS_PERIODO_INGRESO cpi,
				                                 CRM_PERIODO_INGRESO pi
				                            WHERE
				                                 cpi.ID_CRM_PERIODO = pi.ID_PERIODO_INGRESO) res ON cc.ID_CRM_CONSULTA = res.ID_CRM_CONSULTA,
								CRM_CONSULTA_ESTADO cec
							WHERE
								cec.id_estado_consulta = cc.id_estado_consulta
				          	ORDER BY cc.id_crm_consulta DESC)
				WHERE ROWNUM < 14"  ;

	$query = $this->db->query( $sql);

	return $query;
}

public function  traer_ultimas_consultas_a_cargo($id_operador)
{
	$sql =	"SELECT cc.id_crm_consulta, cc.fecha as fecha_consulta, cc.id_medio_consulta, cc.COMENTARIO_CONSULTA, cc.id_crm_persona,
				                  res.anio, res.id_periodo_ingreso, res.descripcion,
				                   get_programas_consulta(cc.id_crm_consulta) as programas_interesados,
				               get_nombre_apellido(cc.id_crm_persona) as nombre_apellido
				          FROM 	v_crm_consulta_activa cc
				               	LEFT JOIN CRM_MEDIO_CONSULTA mc ON cc.ID_MEDIO_CONSULTA = mc.ID_MEDIO_CONSULTA
				               	LEFT JOIN (  SELECT *
				                            FROM CRM_CONS_PERIODO_INGRESO cpi,
				                                 CRM_PERIODO_INGRESO pi
				                            WHERE
				                                 cpi.ID_CRM_PERIODO = pi.ID_PERIODO_INGRESO) res ON cc.ID_CRM_CONSULTA = res.ID_CRM_CONSULTA,
				                CRM_OPERADOR_A_CARGO oc
				           WHERE
				           			oc.id_crm_consulta = cc.id_crm_consulta
				           AND 		oc.n_id_persona = $id_operador
				          ORDER BY cc.id_crm_consulta DESC"  ;

	$query = $this->db->query( $sql);

	return $query->result_array();
}

/*
public function  traer_ultimas_consultas_de_mis_programas($id_operador)
{
	$sql =	"	SELECT *
				FROM
				    (
				        SELECT cc.id_crm_consulta, cc.fecha as fecha_consulta, cc.id_medio_consulta, cc.COMENTARIO_CONSULTA, cc.id_crm_persona,
				              res.anio, res.id_periodo_ingreso, res.descripcion, cc.id_estado_consulta,
				              oc.n_id_persona as operador_a_cargo,
				               get_programas_consulta(cc.id_crm_consulta) as programas_interesados,
				               get_nombre_apellido(cc.id_crm_persona) as nombre_apellido
				        FROM V_CRM_CONSULTA_ACTIVA cc
				             LEFT JOIN CRM_MEDIO_CONSULTA mc ON cc.ID_MEDIO_CONSULTA = mc.ID_MEDIO_CONSULTA
				             LEFT JOIN CRM_OPERADOR_A_CARGO oc ON cc.id_crm_consulta = oc.id_crm_consulta
				             LEFT JOIN (  SELECT *
				                        FROM CRM_CONS_PERIODO_INGRESO cpi,
				                             CRM_PERIODO_INGRESO pi
				                        WHERE
				                             cpi.ID_CRM_PERIODO = pi.ID_PERIODO_INGRESO) res ON cc.ID_CRM_CONSULTA = res.ID_CRM_CONSULTA,
							 CRM_CONSULTA_ESTADO cec
				        WHERE
							cec.id_estado_consulta = cc.id_estado_consulta

						AND

				        	EXISTS(

				                    SELECT cp.ID_CRM_CONSULTA
				                    FROM crm.crm_operador_programa op,
				                         crm_consulta_programa cp
				                    WHERE
				                         op.C_IDENTIFICACION = cp.ID_IDENTIFICACION
				                    AND  op.c_programa = cp.ID_programa
				                    AND  op.c_orientacion = cp.ID_orientacion
				                    AND  op.ID_PERSONA = $id_operador
				                    AND  cp.ID_CRM_CONSULTA = cc.id_crm_consulta

				                   )
				        ORDER BY cc.id_crm_consulta DESC
				      )
				WHERE ROWNUM < 20"  ;

	$query = $this->db->query( $sql);

	return $query->result_array();
}*/

public function  cantidad_consultas_de_mis_programas_sin_ver($id_operador)
{
	$sql =	"	SELECT count(distinct(ID_CRM_CONSULTA)) as cantidad
				FROM crm.crm_operador_programa op,
				     crm.crm_consulta_programa cp
				WHERE id_persona = ?
				AND   op.C_IDENTIFICACION = cp.ID_IDENTIFICACION
				AND  op.c_programa = cp.ID_programa
				AND  op.c_orientacion = cp.ID_orientacion
				AND  cp.visto = 0"  ;

	$query = $this->db->query( $sql, array($id_operador) );

	return $query->row()->CANTIDAD;
}

public function  traer_consultas_a_cargo($id_a_cargo)
{
 
	$sql =	"	SELECT cc.id_crm_consulta, cc.fecha as fecha_consulta, cc.id_medio_consulta, cc.COMENTARIO_CONSULTA, cc.id_crm_persona,
				                  res.anio, res.id_periodo_ingreso, res.descripcion
				          FROM 	v_crm_consulta_activa cc
				               	LEFT JOIN CRM_MEDIO_CONSULTA mc ON cc.ID_MEDIO_CONSULTA = mc.ID_MEDIO_CONSULTA
				               	LEFT JOIN (  SELECT *
				                            FROM CRM_CONS_PERIODO_INGRESO cpi,
				                                 CRM_PERIODO_INGRESO pi
				                            WHERE
				                                 cpi.ID_CRM_PERIODO = pi.ID_PERIODO_INGRESO) res ON cc.ID_CRM_CONSULTA = res.ID_CRM_CONSULTA,
				                CRM_OPERADOR_A_CARGO oc
				           WHERE
				           			oc.id_crm_consulta = cc.id_crm_consulta
				           AND 		oc.n_id_persona = $id_a_cargo
				          ORDER BY cc.id_crm_consulta DESC "  ;

	$query = $this->db->query( $sql );

	return $query;
}

public function  get_alarmas_consulta($id_crm_consulta)
{
 
	$sql =	"	SELECT *
				FROM CRM_CONSULTA_ALARMA
				WHERE ID_CRM_CONSULTA = ?"  ;

	$query = $this->db->query( $sql, array($id_crm_consulta) );

	return $query->result_array();
}





public function  traer_consultas_sin_asignar()
{
	chrome_log2("traer_consultas_sin_asignar");
 	// Devuelve todas las consultas sin asignar en la pantalla http://crm/index.php/consulta/asignar_consulta
 	
	$sql =	"	SELECT cc.id_crm_consulta, cc.fecha as fecha_consulta, cc.id_medio_consulta, cc.COMENTARIO_CONSULTA, cc.id_crm_persona,
	                  res.anio, res.id_periodo_ingreso, res.descripcion, cc.id_estado_consulta
	            FROM 	v_crm_consulta_activa cc
	                 	LEFT JOIN CRM_MEDIO_CONSULTA mc ON cc.ID_MEDIO_CONSULTA = mc.ID_MEDIO_CONSULTA
	                 	LEFT JOIN (  SELECT *
	                            FROM CRM_CONS_PERIODO_INGRESO cpi,
	                                 CRM_PERIODO_INGRESO pi
	                            WHERE
	                                 cpi.ID_CRM_PERIODO = pi.ID_PERIODO_INGRESO) res ON cc.ID_CRM_CONSULTA = res.ID_CRM_CONSULTA,
			        	CRM_CONSULTA_ESTADO cec
			    WHERE
			        cec.id_estado_consulta = cc.id_estado_consulta
			    AND cc.ID_CRM_CONSULTA NOT IN (	SELECT C2.id_crm_consulta
			                                    FROM   CRM_OPERADOR_A_CARGO C2) "  ;

	$query = $this->db->query( $sql);

	return $query;
}



public function  asignar_consulta($array)
{
	chrome_log2("asignar_consulta"); 
 	 

	$this->db->trans_start();

 	foreach ($array['id_consulta'] as $row)
 	{
 		
		$sql =	"	SELECT 	*
	    			FROM	CRM_OPERADOR_A_CARGO
	    			WHERE 	ID_CRM_CONSULTA = ?
	    			AND		N_ID_PERSONA = ? "  ;

		$query = $this->db->query( $sql, array( $array['id_persona'], $row ) );

		if( $query->num_rows() == 0): // Aun no la tomo

			$array_operador_cargo['ID_CRM_CONSULTA'] = $row;
			$array_operador_cargo['N_ID_PERSONA'] = $array['id_persona'];
			$this->db->insert('CRM_OPERADOR_A_CARGO',$array_operador_cargo);

		endif;

		$this->Consulta_model->insertar_log_consulta( 22, $row );

 	}

 	$this->db->trans_complete();


	if ($this->db->trans_status() === FALSE)
	{
	      $this->db->trans_rollback();
	      $flag = false;
	}
	else
	{
	      $this->db->trans_commit();
	      $flag = true;
	}

	return $flag;
 
}




public function  traer_consultas_estado($id_estado,$id_operador)
{
	chrome_log2("traer_consultas_estado");

	chrome_log2($sql =	"	SELECT cc.id_crm_consulta, cc.fecha as fecha_consulta, cc.id_medio_consulta, cc.COMENTARIO_CONSULTA, cc.id_crm_persona, cc.standby, cc.fecha_standby,
		              res.anio, res.id_periodo_ingreso, res.descripcion
		        FROM crm_consulta cc
		             LEFT JOIN CRM_MEDIO_CONSULTA mc ON cc.ID_MEDIO_CONSULTA = mc.ID_MEDIO_CONSULTA
		             LEFT JOIN (  SELECT *
		                        FROM CRM_CONS_PERIODO_INGRESO cpi,
		                             CRM_PERIODO_INGRESO pi
		                        WHERE
		                             cpi.ID_CRM_PERIODO = pi.ID_PERIODO_INGRESO) res ON cc.ID_CRM_CONSULTA = res.ID_CRM_CONSULTA
		        WHERE cc.id_estado_consulta = $id_estado
		        AND EXISTS(

		                    SELECT cp.ID_CRM_CONSULTA
		                    FROM crm_operador_programa op,
		                         crm_consulta_programa cp
		                    WHERE
		                         op.C_IDENTIFICACION = cp.ID_IDENTIFICACION
		                    AND  op.c_programa = cp.ID_programa
		                    AND  op.c_orientacion = cp.ID_orientacion
		                    AND  op.ID_PERSONA = $id_operador
		                    AND  cp.ID_CRM_CONSULTA = cc.id_crm_consulta

		                   )
				ORDER BY cc.fecha  DESC" );

	$sql =	"	SELECT cc.id_crm_consulta, cc.fecha as fecha_consulta, cc.id_medio_consulta, cc.COMENTARIO_CONSULTA, cc.id_crm_persona, cc.standby, cc.fecha_standby,
		              res.anio, res.id_periodo_ingreso, res.descripcion
		        FROM crm_consulta cc
		             LEFT JOIN CRM_MEDIO_CONSULTA mc ON cc.ID_MEDIO_CONSULTA = mc.ID_MEDIO_CONSULTA
		             LEFT JOIN (  SELECT *
		                        FROM CRM_CONS_PERIODO_INGRESO cpi,
		                             CRM_PERIODO_INGRESO pi
		                        WHERE
		                             cpi.ID_CRM_PERIODO = pi.ID_PERIODO_INGRESO) res ON cc.ID_CRM_CONSULTA = res.ID_CRM_CONSULTA
		        WHERE   EXISTS(

		                    SELECT cp.ID_CRM_CONSULTA
		                    FROM crm_operador_programa op,
		                         crm_consulta_programa cp
		                    WHERE
		                         op.C_IDENTIFICACION = cp.ID_IDENTIFICACION
		                    AND  op.c_programa = cp.ID_programa
		                    AND  op.c_orientacion = cp.ID_orientacion
		                    AND  op.ID_PERSONA = $id_operador
		                    AND  cp.ID_CRM_CONSULTA = cc.id_crm_consulta
		                    AND  cp.ID_ESTADO_CONS_PRG = $id_estado
		                   )
				ORDER BY cc.fecha  DESC"  ;

	$query = $this->db->query( $sql);

	return $query;
}

public function  traer_consultas_prg_estado($id_estado,$id_operador)
{
	chrome_log2("traer_consultas_prg_estado");

	 


	$sql =	"	SELECT cc.id_crm_consulta, cc.fecha as fecha_consulta, cc.id_medio_consulta, cc.COMENTARIO_CONSULTA, cc.id_crm_persona,
				       res.anio, res.id_periodo_ingreso, res.descripcion, cp.ID_ESTADO_CONS_PRG, cp.FECHA_STANDBY,
				       cp.id_crm_consulta_programa,
				       DEVUELVE_PROGRAMA(cp.id_identificacion, cp.id_programa, cp.id_orientacion) as programa
				FROM crm_operador_programa op,
				     crm_consulta_programa cp,
				     crm_consulta cc
				     LEFT JOIN CRM_MEDIO_CONSULTA mc ON cc.ID_MEDIO_CONSULTA = mc.ID_MEDIO_CONSULTA
				     LEFT JOIN (  SELECT *
				                  FROM CRM_CONS_PERIODO_INGRESO cpi,
				                       CRM_PERIODO_INGRESO pi
				                  WHERE
				                       cpi.ID_CRM_PERIODO = pi.ID_PERIODO_INGRESO) res ON cc.ID_CRM_CONSULTA = res.ID_CRM_CONSULTA
				WHERE
				     op.C_IDENTIFICACION = cp.ID_IDENTIFICACION
				AND  op.c_programa = cp.ID_programa
				AND  op.c_orientacion = cp.ID_orientacion
				
				AND  cp.ID_ESTADO_CONS_PRG = $id_estado
				AND  cp.ID_CRM_CONSULTA = cc.id_crm_consulta"  ;

	$query = $this->db->query( $sql);

	/*AND  op.ID_PERSONA = $id_operador*/

	return $query;
}

public function traer_programas_consulta($id_crm_consulta)
{
	//chrome_log2("traer_programas_consulta");

	$sql =	"	SELECT 	cp.* ,
						p.D_DESCRED, p.D_DESCINF, p.D_DESCRIP, p.C_IDENTIFICACION,  p.C_PROGRAMA, p.C_ORIENTACION,
						ecp.id_estado, ecp.DESCRIPCION as descripcion_estado
    			FROM	CRM_CONSULTA_PROGRAMA cp,
    					PROGRAMAS p,
    					CRM_ESTADO_CONSULTA_PRG ecp
    			WHERE 	cp.ID_CRM_CONSULTA = ?
    			AND		cp.ID_ESTADO_CONS_PRG = ecp.ID_ESTADO
    			AND		cp.ID_IDENTIFICACION = p.C_IDENTIFICACION
    			AND		cp.ID_PROGRAMA =  p.C_PROGRAMA
    			AND		cp.ID_ORIENTACION = p.C_ORIENTACION
    			ORDER BY p.D_DESCRED";

	$query = $this->db->query($sql, array($id_crm_consulta) );

	return $query;
}

public function traer_info_consulta_programa($id_crm_consulta_programa)
{
	chrome_log2("traer_info_consulta_programa");

	$sql =	"	SELECT 	cp.* ,
						p.D_DESCRED, p.D_DESCINF, p.D_DESCRIP, p.C_IDENTIFICACION,  p.C_PROGRAMA, p.C_ORIENTACION,
						ecp.id_estado, ecp.DESCRIPCION as descripcion_estado
    			FROM	CRM_CONSULTA_PROGRAMA cp,
    					PROGRAMAS p,
    					CRM_ESTADO_CONSULTA_PRG ecp
    			WHERE 	cp.ID_CRM_CONSULTA_PROGRAMA = ?
    			AND		cp.ID_ESTADO_CONS_PRG = ecp.ID_ESTADO
    			AND		cp.ID_IDENTIFICACION = p.C_IDENTIFICACION
    			AND		cp.ID_PROGRAMA =  p.C_PROGRAMA
    			AND		cp.ID_ORIENTACION = p.C_ORIENTACION"  ;

	$query = $this->db->query($sql, array($id_crm_consulta_programa) );

	return $query->row();
}

public function traer_contactenme_consulta($id_crm_consulta)
{
	chrome_log2("traer_contactenme_consulta");

	$sql =	"	SELECT 	cc.*, mc.DESCRIPCION
    			FROM	CRM_CONSULTA_CONTACTENME cc,
    					CRM_MEDIO_CONTACTENME mc
    			WHERE 	cc.ID_CRM_CONSULTA = ?
    			AND		cc.ID_MEDIO_CONTACTENME = mc.ID_CONTACTENME "  ;

	$query = $this->db->query($sql, array($id_crm_consulta) );

	return $query;
}


// ULTIMA

public function buscar_consulta($array, &$condiciones)
{
	//ini_set("memory_limit",5);

	// --- BUSCO LAS CONSULTAS ENTRE LAS FECHAS

	if( isset($array['fecha_desde']) ||  isset($array['fecha_hasta']) ):

		$sql_cons_fecha =	"	SELECT distinct(cc.id_crm_consulta)
					          	FROM crm_consulta cc
					            WHERE 1 = 1 ";

		if( isset($array['fecha_desde']) && !empty($array['fecha_desde'])):

			$sql_cons_fecha .= " AND cc.FECHA >= TO_DATE('".$array['fecha_desde']."','DD-MM-YYYY')";
			$condiciones['fecha_desde'] = $array['fecha_desde'];

		endif;

		if( isset($array['fecha_hasta']) && !empty($array['fecha_hasta'])):

			$sql_cons_fecha .= " AND cc.FECHA <= TO_DATE('".$array['fecha_hasta']."','DD-MM-YYYY')";
			$condiciones['fecha_hasta'] = $array['fecha_hasta'];

		endif;

	endif;

	// --- BUSCO LAS CONSULTAS ENTRE QUE TENGAN ESOS PROGRAMAS

	if( isset($array['programas_elegidos'])  ): // Si eligieron programas

		$sql_cons_prg =	"	SELECT distinct(cc.id_crm_consulta)
				          	FROM crm_consulta cc , crm_consulta_programa ccp
				            WHERE cc.id_crm_consulta = ccp.id_crm_consulta ";

		$i = 0;
		$x = 0;

		foreach ($array['programas_elegidos'] as $row):

	 		$vector = explode(",", $row);

			if($i == 0)
				$sql_cons_prg .= "AND (";
			else
				$sql_cons_prg .= " OR ";

			$sql_cons_prg .= "(     ccp.ID_IDENTIFICACION = ".$vector[0];
			$sql_cons_prg .= "  AND ccp.ID_PROGRAMA = ".$vector[1];
			$sql_cons_prg .= "  AND ccp.ID_ORIENTACION = ".$vector[2]." ) ";

			$i++;

			$sql_programa =	"	SELECT  *
				    			FROM	programas p
				    			WHERE 	p.C_IDENTIFICACION = ?
				    			AND 	p.C_PROGRAMA = ?
				    			AND 	p.C_ORIENTACION = ? "  ;

			$query_programa  = $this->db->query( $sql_programa, array($vector[0], $vector[1], $vector[2] ) );
			$condiciones['programas'][$x] = $query_programa->row()->D_DESCRED;
			$x++;

		endforeach;

		$sql_cons_prg .= " ) ";

	endif;

	// ---- ME FIJO SI TENGO QUE INTERCEPTAR LAS CONSULTAS O MANDAR ALGUNA SOLA

 	$sql_fusion_consultas = "";

	if( isset($array['programas_elegidos']) && ( isset($array['fecha_desde']) ||  isset($array['fecha_hasta']) ) ):

		$sql_fusion_consultas = $sql_cons_prg." INTERSECT ".$sql_cons_fecha ;

		elseif( isset($array['programas_elegidos'] )):

			$sql_fusion_consultas = $sql_cons_prg;

		else:

			$sql_fusion_consultas = $sql_cons_fecha ;

	endif;

	$sql_buscar_cons =	"	SELECT cc.id_crm_consulta, cce.descripcion as estado_consulta, cc.fecha as fecha_consulta, cc.id_medio_consulta, cc.COMENTARIO_CONSULTA, cc.id_crm_persona, res.anio, res.id_periodo_ingreso, res.descripcion
							FROM crm_consulta cc
								 INNER JOIN CRM_CONSULTA_ESTADO cce ON cc.id_estado_consulta = cce.id_estado_consulta
							     LEFT JOIN CRM_MEDIO_CONSULTA mc ON cc.ID_MEDIO_CONSULTA = mc.ID_MEDIO_CONSULTA
							     LEFT JOIN (  SELECT *
						  	                  FROM CRM_CONS_PERIODO_INGRESO cpi,
							                       CRM_PERIODO_INGRESO pi
							                  WHERE
							                        cpi.ID_CRM_PERIODO = pi.ID_PERIODO_INGRESO ) res ON cc.ID_CRM_CONSULTA = res.ID_CRM_CONSULTA
							WHERE 1  = 1
							AND cc.id_crm_consulta IN ( $sql_fusion_consultas ) ";

	$query_buscar_cons = $this->db->query($sql_buscar_cons);

	//echo $sql_buscar_cons;

	$consultas_informacion = array();
 	$i = 0;


	// USANDO ARRAY --------------------------------------

 	if( $query_buscar_cons->num_rows > 0): // Hay consultas

 		foreach ($query_buscar_cons->result_array() as $row) // Recorro las consultas
		{
			$informacion['consultas'] = $row;
			//$informacion['persona'] = $this->Contacto_model->traer_informacion_crm_sigeu_persona($row['ID_CRM_PERSONA']);
			$programas_consulta = $this->Consulta_model->traer_programas_consulta($row['ID_CRM_CONSULTA']);

			$array_consulta_programas = array();

			if($programas_consulta->num_rows() > 0): // Hay progamas asociados

				foreach ($programas_consulta->result_array() as $row2) // Recorro los programas asociados
				{
					$datos_array['programa'] = $row2;
					$datos_array['programas_comen'] = $this->Consulta_model->traer_comentarios_consultas_programa($row2['ID_CRM_CONSULTA_PROGRAMA']);
					array_push($array_consulta_programas, $datos_array);
				}

			endif;

			$informacion['programas'] = $array_consulta_programas;

			array_push($consultas_informacion, $informacion);


			$programas_consulta->free_result();

			// echo "<br>";
			// echo 'Memory in use: ' . memory_get_usage() . ' ('.  round(memory_get_usage()/1024/1024,2) .'M) <br>';
			// echo 'Peak usage: ' . memory_get_peak_usage() . ' ('.  round(memory_get_peak_usage()/1024/1024,2) .'M) <br>';
			// echo 'Memory limit: ' . ini_get('memory_limit') . '<br><br>';

		}

 	else:

 		return $consultas_informacion;

 	endif;



	return $consultas_informacion;
}



public function traer_info_interes_consulta($id_crm_consulta)
{
	chrome_log2("traer_info_interes_consulta");

	$sql =	"	SELECT 	cii.*, ii.DESCRIPCION
    			FROM	CRM_CONSULTA_INFO_INTERES cii,
    					CRM_INFORMACION_INTERES ii
    			WHERE 	cii.ID_CRM_CONSULTA = ?
    			AND		cii.ID_INFO_INTERES = ii.ID_INFO_INTERES "  ;

	$query = $this->db->query($sql, array($id_crm_consulta) );

	return $query;
}

public function traer_info_interes()
{
	chrome_log2("traer_info_interes");

	$sql =	"	SELECT 	*
    			FROM	CRM_INFORMACION_INTERES ii  ";

	$query = $this->db->query($sql);

	return $query;
}

public function traer_periodo_ingreso()
{
	chrome_log2("traer_periodo_ingreso");

	$sql =	"	SELECT 	*
    			FROM CRM_PERIODO_INGRESO pi  ";

	$query = $this->db->query($sql);

	return $query;
}

/*
public function traer_estado_consulta()
{
	chrome_log2("traer_estado_consulta");

	$sql =	"	SELECT 	*
    			FROM CRM_CONSULTA_ESTADO
    			ORDER BY id_estado asc";

	$query = $this->db->query($sql);

	return $query;
}*/

public function traer_estado_consulta_prg()
{
	chrome_log2("traer_estado_consulta_prg");

	$sql =	"	SELECT 	*
    			FROM crm.CRM_ESTADO_CONSULTA_PRG
    			ORDER BY id_estado asc";

	$query = $this->db->query($sql);

	return $query;
}

public function traer_estado_consulta()
{
	chrome_log2("traer_estado_consulta");

	$sql =	"	SELECT 	*
    			FROM CRM_CONSULTA_ESTADO
    			ORDER BY ID_ESTADO_CONSULTA asc";

	$query = $this->db->query($sql);

	return $query;
}

// No trae finalizado por que no es un estado operativo
public function traer_estado_consulta_pipeline()
{
	chrome_log2("traer_estado_consulta");

	$sql =	"	SELECT 	*
    			FROM CRM_ESTADO_CONSULTA_PRG
    			WHERE id_estado != 7
    			ORDER BY id_estado asc";

	$query = $this->db->query($sql);

	return $query;
}

public function traer_motivos_estado($id_estado)
{
	$sql =	"	SELECT 	cm.id_motivo,
						cm.descripcion as motivo
				FROM CRM_REL_MOTIVO_ESTADO rel, CRM_MOTIVO_ESTADO cm
				WHERE  rel.id_motivo = cm.id_motivo
				AND	rel.id_estado = '$id_estado' ";

	$query = $this->db->query($sql);

	return $query;
}

public function traer_como_contactar()
{
	chrome_log2("traer_como_contactar");

	$sql =	"	SELECT 	*
    			FROM CRM_MEDIO_CONTACTENME  ";

	$query = $this->db->query($sql);

	return $query;
}


public function traer_operadores_cargo($id_consulta)
{
	chrome_log2("traer_operadores_cargo");

	$sql =	"	SELECT p.USER_ORACLE
				FROM CRM_OPERADOR_A_CARGO opc, personas p
				WHERE opc.id_crm_consulta = ?
				AND opc.N_ID_PERSONA = p.N_ID_PERSONA";

	$query = $this->db->query($sql,array($id_consulta));

	return $query;
}

public function traer_informacion_consulta($id_crm_consulta)
{
	chrome_log2("traer_info_interes_consulta");

	$sql =	"	SELECT 	cc.id_crm_consulta, cc.fecha as fecha_consulta, cc.id_medio_consulta,
						cc.COMENTARIO_CONSULTA, cc.id_crm_persona, TO_CHAR(cc.F_FECHA_MODI, 'DD-MM-YYYY, HH24:MI') AS F_FECHA_MODI,
						cc.C_USUARIO_MODI, res.anio as anio_ingreso, res.id_periodo_ingreso, res.descripcion as PERIODO_INGRESO,
	                  	mc.descripcion, ec.descripcion as estado_consulta, cc.ID_ESTADO_CONSULTA
	          	FROM 	crm_consulta cc
	               		LEFT JOIN CRM_MEDIO_CONSULTA mc ON cc.ID_MEDIO_CONSULTA = mc.ID_MEDIO_CONSULTA
	               		LEFT JOIN (  SELECT *
	                             FROM CRM_CONS_PERIODO_INGRESO cpi,
	                                 CRM_PERIODO_INGRESO pi
	                            WHERE
	                                 cpi.ID_CRM_PERIODO = pi.ID_PERIODO_INGRESO ) res ON cc.ID_CRM_CONSULTA = res.ID_CRM_CONSULTA,
						CRM_CONSULTA_ESTADO ec
				WHERE cc.id_crm_consulta = ?
				AND   cc.id_estado_consulta = ec.id_estado_consulta
	          	ORDER BY cc.id_crm_consulta DESC "  ;

	$query = $this->db->query($sql, array($id_crm_consulta) );

	return $query->row();
}

public function asignar_info_interes($array)
{
	chrome_log2("asignar_info_interes");

	$this->db->trans_start();

	// Borro las relaciones anteriores

		$array_borrar_info['ID_CRM_CONSULTA'] = utf8_decode($array['id_crm_consulta']);
		$this->db->delete('CRM_CONSULTA_INFO_INTERES',$array_borrar_info);

	// Ingreso las nuevas relaciones

  		foreach ($array['id_info_interes'] as $value)
  		{
  			//chrome_log2("Value: ".$value."-".$array['id_crm_consulta']."<br>");
  			$array_insertar_info['ID_CRM_CONSULTA'] = utf8_decode($array['id_crm_consulta']);
  			$array_insertar_info['ID_INFO_INTERES'] = utf8_decode($value);
			$this->db->insert('CRM_CONSULTA_INFO_INTERES',$array_insertar_info);
  		}

  		$this->insertar_log_consulta( 9 , $array['id_crm_consulta'] );

	$this->db->trans_complete();


	if ($this->db->trans_status() === FALSE)
	{
	      $this->db->trans_rollback();
	      $flag = false;
	}
	else
	{
	      $this->db->trans_commit();
	      $flag = true;
	}

	return $flag;
}

public function modifica_periodo_ingreso($array)
{
	chrome_log2("modifica_periodo_ingreso");

	$this->db->trans_start();

	// Borro las relaciones anteriores

		$array_borrar_periodo['ID_CRM_CONSULTA'] = utf8_decode($array['id_crm_consulta']);
		$this->db->delete('CRM_CONS_PERIODO_INGRESO',$array_borrar_periodo);

	// Ingreso las nuevas relaciones

		$array_insertar_info['ID_CRM_CONSULTA'] = utf8_decode($array['id_crm_consulta']);
		$array_insertar_info['ANIO'] = utf8_decode($array['anio']);
		$array_insertar_info['ID_CRM_PERIODO'] = utf8_decode($array['id_periodo']);
		$this->db->insert('CRM_CONS_PERIODO_INGRESO',$array_insertar_info);
		$id_periodo = $array['id_periodo'];

		$periodo = $this->db->query("SELECT descripcion FROM CRM_PERIODO_INGRESO WHERE id_periodo_ingreso = $id_periodo");
		$periodo_texto = $periodo->result_array[0]['DESCRIPCION'];
		$texto = "Se modificó el período de ingreso: <strong> Año: ".$array['anio'].", Período: ".$periodo_texto."</strong>.";

		$this->Consulta_model->insertar_log_consulta( 5, $array['id_crm_consulta'], $texto );

	$this->db->trans_complete();


	if ($this->db->trans_status() === FALSE)
	{
	      $this->db->trans_rollback();
	      $flag = false;
	}
	else
	{
	      $this->db->trans_commit();
	      $flag = true;
	}

	return $flag;
}

public function tomar_consulta($id_crm_consulta)
{
	chrome_log2("tomar_consulta");

	$this->db->trans_start();

	$sql =	"	SELECT 	*
    			FROM	CRM_OPERADOR_A_CARGO
    			WHERE 	ID_CRM_CONSULTA = ?
    			AND		N_ID_PERSONA = ? "  ;

	$query = $this->db->query($sql, array( $id_crm_consulta, $this->session->userdata('id_persona') ) );

	if( $query->num_rows() == 0): // Aun no la tomo

		$array_operador_cargo['ID_CRM_CONSULTA'] = utf8_decode($id_crm_consulta);
		$array_operador_cargo['N_ID_PERSONA'] = utf8_decode($this->session->userdata('id_persona'));
		$this->db->insert('CRM_OPERADOR_A_CARGO',$array_operador_cargo);

	endif;

	$this->Consulta_model->insertar_log_consulta( 4, $id_crm_consulta );


	$this->db->trans_complete();


	if ($this->db->trans_status() === FALSE)
	{
	      $this->db->trans_rollback();
	      $flag = false;
	}
	else
	{
	      $this->db->trans_commit();
	      $flag = true;
	}

	return $flag;
}

public function modificar_estado_consulta($array)
{
	chrome_log2("modificar_estado_consulta");

	$this->db->trans_start();

		$array_where = array( 'ID_CRM_CONSULTA' => $array['id_crm_consulta'] );

	    $estado =  array();

	    $estado['ID_ESTADO_CONSULTA'] = $array['id_estado_consulta'] ;

	    $this->db->where($array_where);
		$this->db->update('CRM_CONSULTA', $estado);

		if ($estado['ID_ESTADO_CONSULTA'] == 1):
			$estado_consulta_texto = 'Activa';
		else:
			$estado_consulta_texto = 'Inactiva';
		endif;

		$texto = "El estado de la consulta cambió a <strong>".$estado_consulta_texto."</strong>";

    	$this->insertar_log_consulta( 20, $array['id_crm_consulta'], $texto );

	$this->db->trans_complete();


	if ($this->db->trans_status() === FALSE)
	{
	      $this->db->trans_rollback();
	      $flag = false;
	}
	else
	{
	      $this->db->trans_commit();
	      $flag = true;
	}

	return $flag;
}

public function modificar_estado_consulta_prg($array)
{
	chrome_log2("modificar_estado_consulta_prg");


	$array_where = array( 'ID_CRM_CONSULTA_PROGRAMA' => $array['id_crm_consulta_prg'] );

    $estado =  array();

    $estado['ID_ESTADO_CONS_PRG'] = $array['id_estado_cons_prg'] ;

    $this->db->where($array_where);
    $this->db->update('CRM_CONSULTA_PROGRAMA', $estado);


    // Traer informacion

    $desc_estado_consulta = $this->Consulta_model->traer_descripcion_estado_by_id($array['id_estado_cons_prg']);

    $id_crm_consulta = $this->Consulta_model->traer_id_consulta_by_consulta_prg( $array['id_crm_consulta_prg'] );

    $programa = $this->Consulta_model->traer_programa_consulta_by_consulta_prg($array['id_crm_consulta_prg']  );

    $texto = "El programa <strong>".$programa."</strong> cambió al estado <strong>".$desc_estado_consulta."</strong>";

    $this->insertar_log_consulta( 8 , $id_crm_consulta , $texto );

	if ( $this->db->affected_rows() > 0)
	      $flag = true;
	else
	      $flag = false;


	return $flag;
}

public function modificar_como_contactar($array)
{
	chrome_log2("modificar_como_contactar");

	$this->db->trans_start();

	// Borro las relaciones anteriores

		$borrar_como_contacto['ID_CRM_CONSULTA'] = utf8_decode($array['id_crm_consulta']);
		$this->db->delete('CRM_CONSULTA_CONTACTENME',$borrar_como_contacto);

	// Ingreso las nuevas relaciones

		$texto = 'Se modificaron los medios de contacto:</br>';

		foreach ($array['id_contactenme'] as $value)
  		{
  			$array_insertar_info['ID_CRM_CONSULTA'] = utf8_decode($array['id_crm_consulta']);
  			$array_insertar_info['ID_MEDIO_CONTACTENME'] = utf8_decode($value);

			if($value == 1) // Email
				$texto .= 'Email</br>';

  			if($value == 2 ) {// Telefono
				  $array_insertar_info['HORARIO'] = $array['horario_telefono'];
				  $texto .= "Teléfono: ".$array['horario_telefono']."</br>";
			};

  			if($value == 3 ) {// WhatsApp
				$array_insertar_info['HORARIO'] = $array['horario_what'];
				$texto .= "WhatsApp: ".$array['horario_what']."</br>";
			};
			$this->db->insert('CRM_CONSULTA_CONTACTENME', $array_insertar_info);

  		}


  		$this->Consulta_model->insertar_log_consulta( 7 , $array['id_crm_consulta'], $texto);

	$this->db->trans_complete();


	if ($this->db->trans_status() === FALSE)
	{
	      $this->db->trans_rollback();
	      $flag = false;
	}
	else
	{
	      $this->db->trans_commit();
	      $flag = true;
	}

	return $flag;
}

/*
public function modificar_programas_consulta($array)
{
	chrome_log2("modificar_programas_consulta");

	$this->db->trans_start();



	// Borro las relaciones anteriores con los programas

		$borrar_como_contacto['ID_CRM_CONSULTA'] = utf8_decode($array['id_crm_consulta']);
		$this->db->delete('CRM_CONSULTA_PROGRAMA',$borrar_como_contacto);

	// Ingreso las nuevas relaciones con los programas

		foreach ($array['id_codigo'] as $value)
  		{
  			$array_programas = explode("-", $value);

  			$this->db->set('ID_CRM_CONSULTA_PROGRAMA', "ID_CRM_CONSULTA_PROGRAMA.nextval", false);
  			$array_insertar_info['ID_CRM_CONSULTA'] = utf8_decode($array['id_crm_consulta']);
  			$array_insertar_info['ID_IDENTIFICACION'] = utf8_decode($array_programas[0]);
  			$array_insertar_info['ID_PROGRAMA'] = utf8_decode($array_programas[1]);
  			$array_insertar_info['ID_ORIENTACION'] = utf8_decode($array_programas[2]);

			$this->db->insert('CRM_CONSULTA_PROGRAMA',$array_insertar_info);
  		}

  		$this->Consulta_model->insertar_log_consulta( 6 , $array['id_crm_consulta']);

	$this->db->trans_complete();


	if ($this->db->trans_status() === FALSE)
	{
	      $this->db->trans_rollback();
	      $flag = false;
	}
	else
	{
	      $this->db->trans_commit();
	      $flag = true;
	}

	return $flag;
}
*/

public function modificar_programas_consulta($array)
{
	chrome_log2("modificar_programas_consulta");

	$mensaje = "";

	$this->db->trans_start();

	// Busco los programas que estaba antes

		$sql_prg_ant =	"	SELECT *
				          	FROM CRM_CONSULTA_PROGRAMA cp
							WHERE cp.id_crm_consulta = ? "  ;

		$query = $this->db->query($sql_prg_ant, array($array['id_crm_consulta']) );

		$prg_viejos = $query->result_array();


		// Recorro los nuevos y me fijo si estan, si no estan, los borro

		$array_nuevos_prg = array();

		foreach ($array['id_codigo'] as $value)
  		{
  			$array_programas = explode("-", $value);

  			$id_identificacion = $array_programas[0];
  			$id_programa = $array_programas[1];
  			$id_orientacion = $array_programas[2];

  			array_push($array_nuevos_prg, $value);

			// Me fijo si estan en los cargados

			$sql_prg_ant =	"	SELECT *
				          		FROM CRM_CONSULTA_PROGRAMA cp
								WHERE cp.id_crm_consulta = ?
								AND cp.id_identificacion = ?
								AND cp.id_programa = ?
								AND cp.id_orientacion = ?
							"  ;

			$query = $this->db->query($sql_prg_ant, array( $array['id_crm_consulta'],
														   $id_identificacion,
														   $id_programa,
														   $id_orientacion
														 )
									 );

			if( $query->num_rows() == 0 )
			{
				$this->db->set('ID_CRM_CONSULTA_PROGRAMA', "ID_CRM_CONSULTA_PROGRAMA.nextval", false);
	  			$array_insertar_info['ID_CRM_CONSULTA'] = utf8_decode($array['id_crm_consulta']);
	  			$array_insertar_info['ID_IDENTIFICACION'] = utf8_decode($id_identificacion);
	  			$array_insertar_info['ID_PROGRAMA'] = utf8_decode($id_programa);
	  			$array_insertar_info['ID_ORIENTACION'] = utf8_decode($id_orientacion);

				$this->db->insert('CRM_CONSULTA_PROGRAMA',$array_insertar_info);

				$programa = $this->traer_nombre_programa( $id_identificacion, $id_programa,$id_orientacion );

				$mensaje .= "Se agregó el programa <strong>".$programa."</strong>.</br> ";
			}

  		}

  		// Recorro los programas viejos y me fijo cual NO ESTA en los nuevos, y lo borro.

  		foreach ($prg_viejos as $key)
  		{
  			$programa_viejo = $key['ID_IDENTIFICACION']."-".$key['ID_PROGRAMA']."-".$key['ID_ORIENTACION'];

  			if (in_array($programa_viejo, $array_nuevos_prg))
  			{
			    echo "Existe Programa";
			}
			else
			{
				$borrar_programa['ID_CRM_CONSULTA'] = utf8_decode($array['id_crm_consulta']);
				$borrar_programa['ID_IDENTIFICACION'] = utf8_decode($key['ID_IDENTIFICACION']);
				$borrar_programa['ID_PROGRAMA'] = utf8_decode($key['ID_PROGRAMA']);
				$borrar_programa['ID_ORIENTACION'] = utf8_decode($key['ID_ORIENTACION']);
				$this->db->delete('CRM_CONSULTA_PROGRAMA',$borrar_programa);


				$programa = $this->traer_nombre_programa( $key['ID_IDENTIFICACION'], $key['ID_PROGRAMA'],$key['ID_ORIENTACION'] );
				$mensaje .= "Se elimino el programa <strong>".$programa."</strong>.</br> ";
			}


  		}

  		$this->Consulta_model->insertar_log_consulta( 6 , $array['id_crm_consulta'], $mensaje);

	$this->db->trans_complete();


	if ($this->db->trans_status() === FALSE)
	{
	      $this->db->trans_rollback();
	      $flag = false;
	}
	else
	{
	      $this->db->trans_commit();
	      $flag = true;
	}

	return $flag;
}

public function grabar_email_consulta($id_crm_consulta, $subject, $mensaje_resultado, $emails, $texto, $usuario_sender, $id_consulta_programa =NULL , $id_crm_email_plantilla =NULL )
{
	chrome_log2("grabar_email_consulta");

	$this->db->set('ID_CRM_EMAIL', "ID_CRM_EMAIL.nextval", false);

	$array_insertar_info['ID_CRM_CONSULTA'] = utf8_decode($id_crm_consulta);
	$array_insertar_info['DESTINATARIOS'] = utf8_decode($emails);
 
	$array_insertar_info['RESULTADO'] = utf8_decode( $mensaje_resultado);
	$array_insertar_info['SUBJECT'] = utf8_decode( $subject);
	$array_insertar_info['USUARIO_ORACLE'] = utf8_decode( $usuario_sender );


	$array_insertar_info['ID_CRM_CONSULTA_PROGRAMA'] = $id_consulta_programa;


	$array_insertar_info['ID_CRM_PLANTILLA'] =  $id_crm_email_plantilla;


	$this->db->insert('CRM_EMAIL_CONSULTA',$array_insertar_info);


	if ( $this->db->affected_rows() > 0)
	      $flag = true;
	else
	      $flag = false;


	return $flag;
}

/*
public function grabar_email_consulta($array, $mensaje_resultado, $emails, $texto, $usuario )
{
	chrome_log2("grabar_email_consulta");

	$this->db->set('ID_CRM_EMAIL', "ID_CRM_EMAIL.nextval", false);
	$array_insertar_info['ID_CRM_CONSULTA'] = utf8_decode($array['id_crm_consulta']);
	$array_insertar_info['DESTINATARIOS'] = utf8_decode($emails);
	$array_insertar_info['TEXTO'] = utf8_decode($texto);
	$array_insertar_info['RESULTADO'] = utf8_decode( $mensaje_resultado);
	$array_insertar_info['SUBJECT'] = utf8_decode( $array['subject']);
	$array_insertar_info['USUARIO_ORACLE'] = utf8_decode( $array['subject']);

	$this->db->insert('CRM_EMAIL_CONSULTA',$array_insertar_info);


	if ( $this->db->affected_rows() > 0)
	      $flag = true;
	else
	      $flag = false;


	return $flag;

}*/

public function agregar_comentario_programa($array)
{
	chrome_log2("agregar_comentario_programa");

	$this->db->set('ID_CRM_COMENTARIO', "ID_CRM_COMENTARIO.nextval", false);

	if(isset($array['id_crm_consulta_programa']))
		$array_insertar_info['ID_CRM_CONSULTA_PROGRAMA'] = $array['id_crm_consulta_programa'];

	if(isset($array['id_crm_consulta']))
		$array_insertar_info['ID_CRM_CONSULTA'] = $array['id_crm_consulta'];

	$array_insertar_info['COMENTARIO'] = $array['comentario'];
	$array_insertar_info['USUARIO_ORACLE'] = $this->session->userdata('usuario_crm');

	$this->db->insert('CRM_COMENTARIO_CONSUL_PRG',$array_insertar_info);


	if ( $this->db->affected_rows() > 0)
	      $flag = true;
	else
	      $flag = false;


	return $flag;
}


public function traer_comentarios_consultas_programa($id_crm_consulta_programa)
{
	//chrome_log2("traer_comentarios_consultas_programa");

	$sql =	utf8_decode("	SELECT *
				FROM 	CRM_COMENTARIO_CONSUL_PRG
    			WHERE	ID_CRM_CONSULTA_PROGRAMA = ? ")  ;

	$query = $this->db->query( $sql, array( $id_crm_consulta_programa ) );

	return $query->result_array();
}


public function traer_comentarios_generales_consulta($id_crm_consulta)
{
	$sql =	"	SELECT *
				FROM 	CRM_COMENTARIO_CONSUL_PRG
    			WHERE	ID_CRM_CONSULTA = ? "  ;

	$query = $this->db->query( $sql, array( $id_crm_consulta ) );

	return $query->result_array();
}




public function traer_email_consulta($id_crm_consulta)
{

	chrome_log2("traer_email_consulta");

	$sql =	"	SELECT *
				FROM 	CRM_EMAIL_CONSULTA
    			WHERE	ID_CRM_CONSULTA = ? "  ;

	$query = $this->db->query( $sql, array( $id_crm_consulta ) );

	return $query;
}

public function traer_eventos_linea_tiempo($id_crm_consulta_programa, $id_crm_consulta)
{

	chrome_log2("traer_eventos_linea_tiempo");

	$sql =	"	SELECT FECHA,
				       COMENTARIO as comentario,
				       'comentario' as tipo,
				       USUARIO_ORACLE
				FROM 	CRM_COMENTARIO_CONSUL_PRG
				WHERE	ID_CRM_CONSULTA_PROGRAMA = ?

				UNION


				SELECT FECHA,
				       TEXTO as comentario,
				       'email'  as tipo,
				       USUARIO_ORACLE
				FROM CRM_EMAIL_CONSULTA
				WHERE	ID_CRM_CONSULTA = ?

				ORDER BY FECHA DESC "  ;

	chrome_log2("	SELECT FECHA,
				       COMENTARIO as comentario,
				       'comentario' as tipo,
				       USUARIO_ORACLE
				FROM 	CRM_COMENTARIO_CONSUL_PRG
				WHERE	ID_CRM_CONSULTA_PROGRAMA = $id_crm_consulta_programa

				UNION


				SELECT FECHA,
				       TEXTO as comentario,
				       'email'  as tipo,
				       USUARIO_ORACLE
				FROM CRM_EMAIL_CONSULTA
				WHERE	ID_CRM_CONSULTA = $id_crm_consulta

				ORDER BY FECHA DESC ");

	$query = $this->db->query( $sql, array( $id_crm_consulta_programa, $id_crm_consulta ) );

	return $query;
}

public function traer_comentarios_consulta($id_crm_consulta_programa)
{

	chrome_log2("traer_email_consulta");

	$sql =	"	SELECT cc.fecha, cc.comentario, cc.USUARIO_ORACLE,
				       DEVUELVE_PROGRAMA(cp.id_identificacion, cp.id_programa, cp.id_orientacion) as programa
				FROM  CRM_COMENTARIO_CONSUL_PRG cc,
				      CRM_CONSULTA_PROGRAMA cp
				WHERE
				      cp.id_crm_consulta = ?
				AND   cp.ID_CRM_CONSULTA_PROGRAMA = cc.ID_CRM_CONSULTA_PROGRAMA
				ORDER BY programa "  ;

	$query = $this->db->query( $sql, array( $id_crm_consulta_programa ) );

	return $query;
}

// public function desestimar_programa($id_crm_consulta_programa)
// {
// 	chrome_log2("desestimar_programa");

//  	$fecha = date("d/m/Y");
//  	$this->db->set('FECHA_DESHABILITADO',"to_date('$fecha','dd/mm/yyyy')",false);

//	$data = array( 	'HABILITADO' 	=> 0  );

// 	$this->db->where('ID_CRM_CONSULTA_PROGRAMA', $id_crm_consulta_programa);
// 	$this->db->update('CRM_CONSULTA_PROGRAMA', $data);

// 	if ( $this->db->affected_rows() > 0)
// 	      $flag = true;
// 	else
// 	      $flag = false;


// 	return $flag;
// }

public function desestimar_programa($id_crm_consulta_programa)
{
	chrome_log2("desestimar_programa");


	$array_where = array( 'ID_CRM_CONSULTA_PROGRAMA' => $id_crm_consulta_programa );

    $estado =  array();

    $estado['ID_ESTADO_CONS_PRG'] =  3 ;

    $this->db->where($array_where);
    $this->db->update('CRM_CONSULTA_PROGRAMA', $estado);


    // Traer informacion

    $desc_estado_consulta = $this->Consulta_model->traer_descripcion_estado_by_id( 3 );

    $id_crm_consulta = $this->Consulta_model->traer_id_consulta_by_consulta_prg( $id_crm_consulta_programa);

    $programa = $this->Consulta_model->traer_programa_consulta_by_consulta_prg( $id_crm_consulta_programa );

    $texto = "El programa <strong>".$programa."</strong> cambió al estado <strong>".$desc_estado_consulta."</strong>";
    //$texto = "aa";

    //chrome_log2("desestimar_programa");

    $this->insertar_log_consulta( 8 , $id_crm_consulta , $texto );

	if ( $this->db->affected_rows() > 0)
	      $flag = true;
	else
	      $flag = false;


	return $flag;
}


public function alta_consulta($datos_persona, $datos_consulta)
{
	chrome_log2("alta_consulta");

	$this->db->trans_start();

	if($datos_persona->accion == 'nuevo'): // CONTACTO ES NUEVO

		// 	Alta persona
			$id_crm_persona = $this->Contacto_model->alta_crm_persona( 	utf8_decode($datos_persona->apellido),
																	utf8_decode($datos_persona->nombre)
																);

		//  Alta intresado

			$array_interesado_crm['ID_CRM_PERSONA'] = utf8_decode($id_crm_persona);
			$this->db->insert('CRM_INTERESADO',$array_interesado_crm);

		// 	Alta email

			$array_email['id_crm_persona'] = $id_crm_persona;
			$array_email['email'] = $datos_persona->email;
			$array_email['id_tipo_email'] = 4;
			$this->Contacto_model->abm_email(  'A', $array_email  );

		// 	Alta Telefono

			if( isset($datos_persona->telefono) && !empty($datos_persona->telefono)  ):

				$array_telefono['id_crm_persona'] = $id_crm_persona;
				$array_telefono['telefono'] = $datos_persona->telefono;
				$array_telefono['id_tipo_telefono'] = 1;
				$this->Contacto_model->abm_telefono(  'A', $array_telefono  );

			endif;

		// 	Alta Educacion

			if(  ( isset($datos_persona->id_educacion) && !empty($datos_persona->id_educacion) ) ||
				 ( isset($datos_persona->educacion_manual) && !empty($datos_persona->educacion_manual) )
			  ):

				$array_educacion['id_crm_persona'] = $id_crm_persona;

				if(isset($datos_persona->id_educacion))
					$array_educacion['id_educacion'] = $datos_persona->id_educacion;

				if(isset($datos_persona->educacion_manual))
					$array_educacion['educacion_manual'] = $datos_persona->educacion_manual;

				if(isset($datos_persona->id_nivel))
					$array_educacion['id_nivel_educacion'] = $datos_persona->id_nivel;

				$this->Contacto_model->abm_educacion(  'A', $array_educacion  );

			endif;

		//	Alta experiencia laboral


			if(  ( isset($datos_persona->id_empresa) && !empty($datos_persona->id_empresa) ) ||
				 ( isset($datos_persona->empresa_manual) && !empty($datos_persona->empresa_manual) )
			  ):

				$array_empresa['id_crm_persona'] = $id_crm_persona;

				if(isset($datos_persona->id_empresa))
					$array_empresa['id_empresa'] = $datos_persona->id_empresa;

				if(isset($datos_persona->empresa_manual))
					$array_empresa['empresa_manual'] = $datos_persona->empresa_manual;

				if(isset($datos_persona->cargo))
					$array_empresa['cargo'] = $datos_persona->cargo;

				$this->Contacto_model->abm_experiencia_laboral(  'A', $array_empresa  );

			endif;


	elseif($datos_persona->accion == 'fusionar'): // CONTACTO ELEGIDO DE UNA COINCIDENCIA

		// Fusionar con SIGEU
		if($datos_persona->origen == 'SIGEU'):


			// Como esta en SIGEU no se fusiona educacion ni empresa

			$id_crm_persona = $this->Contacto_model->fusionar_sigeu( 	$datos_persona->id_usuario,
			 															$datos_persona->email,
																		$datos_persona->telefono
																	);

		// Fusionar con CRM
		else:

			$id_crm_persona = $this->Contacto_model->fusionar_crm( 		$datos_persona->id_usuario	,
		 																$datos_persona->email,
																		$datos_persona->telefono
																	);

			$id_crm_persona = $datos_persona->id_usuario;

		 	// ALTA EDUCACION

		 	if(  ( isset($datos_persona->id_educacion) && !empty($datos_persona->id_educacion) ) ||
			 	 ( isset($datos_persona->educacion_manual) && !empty($datos_persona->educacion_manual) )
		  		):

					$array_educacion['id_crm_persona'] = $id_crm_persona;

					if(isset($datos_persona->id_educacion))
						$array_educacion['id_educacion'] = $datos_persona->id_educacion;

					if(isset($datos_persona->educacion_manual))
						$array_educacion['educacion_manual'] = $datos_persona->educacion_manual;

					$this->Contacto_model->abm_educacion(  'A', $array_educacion  );

			endif;


			//  ALTA EMPRESA

			if(  ( isset($datos_persona->id_empresa) && !empty($datos_persona->id_empresa) ) ||
				 ( isset($datos_persona->empresa_manual) && !empty($datos_persona->empresa_manual) )
			  	):

					$array_empresa['id_crm_persona'] = $id_crm_persona;

					if(isset($datos_persona->id_empresa))
						$array_empresa['id_empresa'] = $datos_persona->id_empresa;

					if(isset($datos_persona->empresa_manual))
						$array_empresa['empresa_manual'] = $datos_persona->empresa_manual;

					if(isset($datos_persona->cargo))
						$array_empresa['cargo'] = $datos_persona->cargo;

					$this->Contacto_model->abm_experiencia_laboral(  'A', $array_empresa  );

			endif;

		endif;

	else:  // CARGAR CONSULTA

		if($datos_persona->origen == 'SIGEU'): // Si viene de SIGEU


			$id_crm_persona = $this->Contacto_model->fusionar_sigeu( 	$datos_persona->id_usuario,
			 															NULL,
																		NULL
																	);

		else: // Si viene de CRM

			$id_crm_persona = $datos_persona->id_usuario;

		endif;

	endif;


	// Alta de la consulta

	$id_consulta = $this->alta_crm_consulta( 	$id_crm_persona,
								$datos_consulta['id_codigo'],
								$datos_consulta['id_contactenme'],
								$datos_consulta['horario_telefono'],
								$datos_consulta['horario_what'],
								$datos_consulta['anio'],
								$datos_consulta['id_periodo'],
								$datos_consulta['comentario'],
								$datos_consulta['id_info_interes']
							);


	$this->db->trans_complete();


	if ($this->db->trans_status() === FALSE)
	{
	      $this->db->trans_rollback();
	      $flag = false;
	}
	else
	{
	      $this->db->trans_commit();
	      $flag = $id_consulta ;
	}

	return $flag;
}

public function alta_crm_consulta( 	$id_crm_persona,
									$id_programas=NULL,
									$id_contactenme=NULL,
									$horario_telefono=NULL,
									$horario_what=NULL,
									$id_anio=NULL,
									$id_periodo=NULL,
									$comentario=NULL,
									$id_info_interes=NULL
									)
{
	chrome_log2( "alta_crm_consulta" );

	$this->db->trans_start();

	//var_dump($id_programas);

	//---  INSERTAR A CRM_CONSULTA ----

		$this->db->set('ID_CRM_CONSULTA', "ID_CRM_CONSULTA.nextval", false);

		$fecha = date("d/m/Y");
 		$this->db->set('FECHA',"to_date('$fecha','dd/mm/yyyy')",false);

		$array_consulta_crm['ID_CRM_PERSONA'] = utf8_decode($id_crm_persona );

		if(isset($comentario) && !empty($comentario))
			$array_consulta_crm['COMENTARIO_CONSULTA'] = utf8_decode($comentario);

		$array_consulta_crm['ID_MEDIO_CONSULTA'] = 1; // PERSONAL
		//$array_consulta_crm['ID_ESTADO_CONSULTA'] = 1; // NUEVO

		$this->db->insert('CRM_CONSULTA',$array_consulta_crm);

		$id_consulta = $this->db->query("SELECT ID_CRM_CONSULTA.CURRVAL as ID FROM CRM_CONSULTA" )->row()->ID;

	//---  INSERTAR A CRM_CONSULTA_PROGRAMA ----

		$array_consulta_programa_crm['ID_CRM_CONSULTA'] = utf8_decode($id_consulta );


		if(isset($id_programas) && !empty($id_programas)):

			foreach ($id_programas as $row):

				$codigo_prg = explode("-", $row);

				$this->db->set('ID_CRM_CONSULTA_PROGRAMA', "ID_CRM_CONSULTA_PROGRAMA.nextval", false);
				$array_consulta_programa_crm['ID_IDENTIFICACION'] = utf8_decode($codigo_prg[0]);
				$array_consulta_programa_crm['ID_PROGRAMA'] = utf8_decode($codigo_prg[1]);
				$array_consulta_programa_crm['ID_ORIENTACION'] = utf8_decode($codigo_prg[2]);
		 		$this->db->insert('CRM_CONSULTA_PROGRAMA',$array_consulta_programa_crm);

			endforeach;

		endif;

	//---  INSERTAR A CRM_CONS_PERIODO_INGRESO ----

		if( ( isset($id_periodo) && !empty($id_periodo) ) || isset($id_anio) && !empty($id_anio) ):


			$array_consulta_periodo_ingreso['ID_CRM_CONSULTA'] = utf8_decode($id_consulta);

			if(	isset($id_periodo) && !empty($id_periodo) )
				$array_consulta_periodo_ingreso['ID_CRM_PERIODO'] = utf8_decode($id_periodo);

			if(	isset($id_anio) && !empty($id_anio) )
				$array_consulta_periodo_ingreso['ANIO'] = utf8_decode($id_anio);

	 		$this->db->insert('CRM_CONS_PERIODO_INGRESO',$array_consulta_periodo_ingreso);

		endif;

	//---  INSERTAR A CRM_CONSULTA_CONTACTENME ----


		if( ( isset($id_contactenme) && !empty($id_contactenme) ) ):

			//var_dump($id_contactenme);

			foreach ($id_contactenme as $row):

				$array_consulta_contactenme['ID_CRM_CONSULTA'] = utf8_decode($id_consulta);


				if($row == 2): // Telefono

					if( ( isset($horario_telefono) && !empty($horario_telefono) ) )
						$array_consulta_contactenme['HORARIO'] = utf8_decode($horario_telefono);

				endif;

				if($row == 3): // what

					if( ( isset($horario_what) && !empty($horario_what) ) )
						$array_consulta_contactenme['HORARIO'] = utf8_decode($horario_what);

				endif;

			 	$array_consulta_contactenme['ID_MEDIO_CONTACTENME'] = utf8_decode($row);
			 	$this->db->insert('CRM_CONSULTA_CONTACTENME',$array_consulta_contactenme);

			endforeach;

		endif;

	//---  INSERTAR A CRM_CONSULTA_INFO_INTERES ----

		if( ( isset($id_info_interes) && !empty($id_info_interes) ) ):

			foreach ( $id_info_interes as $row):

				$array_consulta_inf_interes['ID_CRM_CONSULTA'] = utf8_decode($id_consulta);
				$array_consulta_inf_interes['ID_INFO_INTERES'] = utf8_decode($row);

		 		$this->db->insert('CRM_CONSULTA_INFO_INTERES',$array_consulta_inf_interes);

	 		endforeach;


		endif;


		$this->insertar_log_consulta( 1, $id_consulta );
		$this->Contacto_model->insertar_log_persona( 1, $id_crm_persona, $id_consulta );


	return $id_consulta;


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
	    	return $id_consulta;
	    else
	    	return false;

	}
}

public function eliminar_consulta($id_crm_consulta)
{
	chrome_log2("eliminar_consulta");

	$this->db->trans_start();

		$this->db->delete('CRM_CONS_PERIODO_INGRESO', array('ID_CRM_CONSULTA' => $id_crm_consulta));
		$this->db->delete('CRM_CONSULTA_CONTACTENME', array('ID_CRM_CONSULTA' => $id_crm_consulta));
		$this->db->delete('CRM_CONSULTA_INFO_INTERES', array('ID_CRM_CONSULTA' => $id_crm_consulta));
		$this->db->delete('CRM_CONS_PERIODO_INGRESO', array('ID_CRM_CONSULTA' => $id_crm_consulta));
		$this->db->delete('CRM_OPERADOR_A_CARGO', array('ID_CRM_CONSULTA' => $id_crm_consulta));
		$this->db->delete('CRM_CONSULTA_PROGRAMA', array('ID_CRM_CONSULTA' => $id_crm_consulta));
		$this->db->delete('CRM_CONSULTA', array('ID_CRM_CONSULTA' => $id_crm_consulta));


	$this->db->trans_complete();


	if ($this->db->trans_status() === FALSE)
	{
	      $this->db->trans_rollback();
	      $flag = false;
	}
	else
	{
	      $this->db->trans_commit();
	      $flag = true ;
	}

	return $flag;
}

public function existe_consulta($id_consulta)
{
	chrome_log2("Consulta_model/existe_consulta");

	$sql =	"	SELECT  *
    			FROM	CRM_CONSULTA cc
    			WHERE 	cc.ID_CRM_CONSULTA = ? "  ;

	$query = $this->db->query($sql, array($id_consulta));

	if($query->num_rows() > 0)
		return false;
	else
		return true;
}

public function buscar_id_persona_consulta($id_consulta)
{
	chrome_log2("Consulta_model/buscar_id_persona_consulta");

	chrome_log2("SELECT  *
    			FROM	CRM_CONSULTA cc
    			WHERE 	cc.ID_CRM_CONSULTA = $id_consulta ");

	$sql =	"	SELECT  *
    			FROM	CRM_CONSULTA cc
    			WHERE 	cc.ID_CRM_CONSULTA = ?  "  ;

	$query = $this->db->query($sql, array($id_consulta));

	return $query->row()->ID_CRM_PERSONA;
}

public function enviar_stand_by_consulta_prg($id_crm_consulta_prg, $fecha_standby)
{
	chrome_log2("enviar_stand_by_consulta");

	$data = array();

	$this->db->set('FECHA_STANDBY',"to_date('$fecha_standby','dd/mm/yyyy')",false);

	$this->db->where('ID_CRM_CONSULTA_PROGRAMA', $id_crm_consulta_prg);
	$this->db->update('CRM_CONSULTA_PROGRAMA', $data);

	if ( $this->db->affected_rows() > 0)
	      $flag = true;
	else
	      $flag = false;


	return $flag;
}

public function sacar_consulta_standby($id_crm_consulta_prg)
{
	chrome_log2("enviar_stand_by_consulta");

	$data = array( 'FECHA_STANDBY' 	=>  NULL );

	$this->db->where('ID_CRM_CONSULTA_PROGRAMA', $id_crm_consulta_prg);
	$this->db->update('CRM_CONSULTA_PROGRAMA', $data);

	if ( $this->db->affected_rows() > 0)
	      $flag = true;
	else
	      $flag = false;


	return $flag;
}

public function traer_entrevistas_consulta($id_crm_consulta)
{
	chrome_log2("traer_entrevistas_consulta");

	$sql =	"	SELECT 	*
    			FROM	ENTREVISTAS E
    			WHERE 	E.ID_CRM_CONSULTA = ?  "  ;

	$query = $this->db->query($sql, array($id_crm_consulta) );

	return $query;
}

public function traer_sol_admision_consulta($id_crm_consulta_consulta)
{
	chrome_log2("traer_entrevistas_consulta");
	 

	$sql =	"	SELECT cc.*, sa.*, P.D_Descinf, aa.*
				FROM CRM_CON_PRG_SOLICITUD cc,
				     Solicitudes_Admision sa,
				     Programas p,
				     ALUMNOS_ADMISION aa 
				where cc.ID_CRM_CONSULTA_PRG = ?
				AND	cc.Id_Solicitud = sa.N_Id_Solicitud
				AND p.c_identificacion = sa.c_identificacion
				AND p.c_programa = sa.c_programa
				AND p.c_orientacion = sa.c_orientacion
				AND sa.n_id_persona = aa.n_id_persona
				AND aa.c_identificacion = sa.c_identificacion
				AND aa.c_programa = sa.c_programa
				AND aa.c_orientacion = sa.c_orientacion 
				AND aa.C_PLAN = aa.C_PLAN"  ;		

	$query = $this->db->query($sql, array($id_crm_consulta_consulta) );

	return $query;
}
 

public function traer_id_consulta_by_consulta_prg($id_consulta_prg)
{
	chrome_log2("traer_id_consulta_by_consulta_prg");

	chrome_log2("SELECT ID_CRM_CONSULTA
				FROM CRM_consulta_programa
				WHERE id_crm_consulta_programa = $id_consulta_prg ");

	$sql =	"	SELECT ID_CRM_CONSULTA
				FROM CRM_consulta_programa
				WHERE id_crm_consulta_programa = ?  "  ;

	$query = $this->db->query($sql, array($id_consulta_prg));

	return $query->row()->ID_CRM_CONSULTA;
}


public function traer_descripcion_estado_by_id($id_estado_cons_prg)
{
	chrome_log2("traer_descripcion_estado_by_id");

	$sql =	"	SELECT DESCRIPCION
				FROM crm_estado_consulta_prg
				WHERE ID_ESTADO = ?  "  ;

	$query = $this->db->query($sql, array($id_estado_cons_prg));

	return $query->row()->DESCRIPCION;
}

public function traer_programa_consulta_by_consulta_prg($id_consulta_prg)
{
	chrome_log2("traer_programa_consulta_by_consulta_prg");


	$sql =	"	SELECT D_DESCRED
				FROM CRM_consulta_programa cp, programas p
				where ID_IDENTIFICACION = P.C_Identificacion
				AND ID_PROGRAMA = P.C_Programa
				AND ID_ORIENTACION = P.C_Orientacion
				AND id_crm_consulta_programa = ?  "  ;

	$query = $this->db->query($sql, array($id_consulta_prg));

	return $query->row()->D_DESCRED;
}


public function insertar_log_consulta($id_tipo_log, $id_consulta, $texto =NULL )
{
	$this->db->set('ID_CRM_LOG_CONSULTA', "ID_CRM_LOG_CONSULTA.nextval", false);
	$array_log['ID_TIPO_LOG_CONSULTA'] = $id_tipo_log;
	$array_log['ID_CRM_CONSULTA'] = $id_consulta;
	$array_log['USUARIO'] = $this->session->userdata('usuario_crm');

	if(isset($texto))
		$array_log['TEXTO'] =  $texto;

	$this->db->insert('CRM_CONSULTA_LOG',$array_log);
}


public function traer_log_consulta($id_crm_consulta)
{
	chrome_log2("traer_log_consulta");

	$sql =	"	SELECT *
				FROM CRM_CONSULTA_LOG cl, CRM_TIPO_LOG ctl
				WHERE ID_CRM_CONSULTA = ?
				AND cl.ID_TIPO_LOG_CONSULTA = ctl.ID_TIPO_LOG_CONSULTA
				ORDER BY FECHA ASC"  ;

	$query = $this->db->query($sql, array($id_crm_consulta));

	return $query;
}


public function actualiza_consulta_vista($id_crm_consulta, $id_operador)
{
	// Traigo las consultas del usuario

	$sql_prg =	"	SELECT C_IDENTIFICACION, C_PROGRAMA, C_ORIENTACION
				FROM crm_operador_programa op
				WHERE  ID_PERSONA = $id_operador "  ;

	$query_prg = $this->db->query( $sql_prg);

	// Recorro las consultas_progtramas de la consulta y

	foreach ($query_prg->result() as $row):

		$array_where = array( 	'ID_CRM_CONSULTA' => $id_crm_consulta,
		 					 	'ID_IDENTIFICACION' => $row->C_IDENTIFICACION,
		 					 	'ID_PROGRAMA' => $row->C_PROGRAMA,
		 					 	'ID_ORIENTACION' => $row->C_ORIENTACION,
		 					);

		$consulta_prg['VISTO'] = 1;

		$this->db->where($array_where);
      	$this->db->update('crm_consulta_programa', $consulta_prg);


	endforeach;
}

public function traer_nombre_programa($id_identificacion, $id_programa, $id_orientacion)
{
	// Traigo las consultas del usuario

	$sql_prg =	"	SELECT D_DESCRIP
					FROM   programas
					WHERE  C_IDENTIFICACION = $id_identificacion
					AND    C_PROGRAMA = $id_programa
					AND	   C_ORIENTACION = $id_orientacion "  ;

	$query_prg = $this->db->query( $sql_prg);

	return $query_prg->row()->D_DESCRIP;
}

public function  existe_consulta_activa($array)
{
	chrome_log2("existe_consulta_activa"); 

	if(isset($array['id_consulta']))
		$consulta = "AND id_crm_consulta != ".$array['id_consulta'];
	else
		$consulta = "";

	if( $array['origen'] == 'CRM' ) // Esta en CRM
	{
		$sql =	"	SELECT *
					FROM crm_persona p
					     INNER JOIN crm_consulta c ON p.id_crm_persona = c.id_crm_persona
					WHERE c.ID_CRM_PERSONA = ?
					AND c.ID_ESTADO_CONSULTA = 1 
					$consulta "  ;

		$query = $this->db->query( $sql, array($array['id']) );
	}
	else // Esta en SIGEU
	{
		$sql =	"	SELECT *
					FROM crm_persona p
					     INNER JOIN crm_consulta c ON p.id_crm_persona = c.id_crm_persona
					WHERE p.ID_PERSONA = ?
					AND c.ID_ESTADO_CONSULTA = 1 
					$consulta "  ;

		$query = $this->db->query( $sql, array($array['id']) );
	}
    
   //chrome_log2("existe_consulta_activa".$sql); 

	if($query->num_rows > 0)
		return true;
	else
		return false;
}
 
public function abm_alarma($accion, $array)
{

  switch ($accion):

    case 'A':

      $this->db->set('ID_CRM_CONSULTA_ALARMA', "ID_CRM_CONSULTA_ALARMA.nextval", false);

      $educacion['ID_CRM_CONSULTA'] = $array['id_crm_consulta'];
      $educacion['FECHA'] = $array['fecha_alarma'];
      $educacion['DESCRIPCION'] = $array['descripcion'];

      return $this->db->insert('CRM_CONSULTA_ALARMA', $educacion);


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

      $this->db->where('ID_CRM_CONSULTA_ALARMA', $array['id_crm_consulta_alarma']);
      $this->db->delete('CRM_CONSULTA_ALARMA');

      return $this->db->affected_rows();

      break;

  endswitch;


  return $this->db->affected_rows();
}






}
?>