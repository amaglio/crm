<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Postulacion_model extends CI_Model {

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

function traer_roles($usuario)
{
	// CAMBIAR agregar OR para los demas ROLES que van a usar el sistema

	$resultado = $this->db->query("		SELECT granted_role as ROL
										FROM dba_role_privs
										WHERE 	granted_role = 'ROLE_DESARROLLO_PROF'
										AND	  grantee = '$usuario'
									");



	return $resultado;
}

function traer_informacion_persona($id_persona)
{
	chrome_log("traer_informacion_persona");


chrome_log( "	SELECT 	p.* ,
										      DEVUELVE_MAILS(p.n_id_persona) as emails,
										      DEVUELVE_TELEFONOS(p.n_id_persona) as telefonos
										FROM PERSONAS P
										     LEFT JOIN CORREOS c ON c.n_id_persona = p.n_id_persona
										     LEFT JOIN TELEFONOS t ON c.n_id_persona = t.n_id_persona
										WHERE p.n_id_persona = $id_persona ");

	$resultado = $this->db->query( "	SELECT 	p.* ,
										      DEVUELVE_MAILS(p.n_id_persona) as emails,
										      DEVUELVE_TELEFONOS(p.n_id_persona) as telefonos
										FROM PERSONAS P
										     LEFT JOIN CORREOS c ON c.n_id_persona = p.n_id_persona
										     LEFT JOIN TELEFONOS t ON c.n_id_persona = t.n_id_persona
										WHERE p.n_id_persona = $id_persona
									" );



	return $resultado->row();
}

function traer_informacion_academica($id_persona)
{

	$resultado = $this->db->query( "	SELECT 	p.* , SIGF_PROMEDIO_ALUMNO(p.c_identificacion,p.c_programa,p.c_orientacion, $id_persona ) as promedio
										FROM alumnos_programas aa, programas p
										WHERE 	aa.n_id_persona = $id_persona
										AND aa.c_identificacion = p.c_identificacion
										AND aa.c_programa = p.c_programa
										AND aa.c_orientacion = p.c_orientacion
										AND aa.m_vigencia = 'Si'
									" );

	return $resultado;
}

function traer_materias_alumno($id_usuario , $c_identificacion , $c_programa , $c_orientacion)
{
	chrome_log( "	SELECT AL.N_ID_MATERIA, AL.F_RINDE, AL.D_NOTA_LETRA, AL.N_NOTA_NUMERO, M.D_DESCRIP
					FROM ALUMNOS_LIBRETAS AL, MATERIAS M
					WHERE AL.N_ID_PERSONA = $id_usuario
					AND AL.C_IDENTIFICACION = $c_identificacion
					AND AL.C_PROGRAMA = $c_programa
					AND AL.C_ORIENTACION = $c_orientacion
					AND AL.n_id_materia = M.n_id_materia

				");

	$resultado = $this->db->query( "	SELECT AL.N_ID_MATERIA, AL.F_RINDE, AL.D_NOTA_LETRA, AL.N_NOTA_NUMERO, M.D_DESCRIP
										FROM ALUMNOS_LIBRETAS AL, PROGRAMAS P, MATERIAS M
										WHERE AL.N_ID_PERSONA = $id_usuario
										AND AL.C_IDENTIFICACION = P.C_IDENTIFICACION
										AND AL.C_ORIENTACION = P.C_ORIENTACION
										AND AL.C_PROGRAMA = P.C_PROGRAMA
										AND AL.C_IDENTIFICACION = $c_identificacion
										AND AL.C_PROGRAMA = $c_programa
										AND AL.C_ORIENTACION = $c_orientacion
										AND al.n_id_materia = m.n_id_materia

									" );

	return $resultado;
}

function traer_materias_sin_rendir($id_usuario , $c_identificacion , $c_programa , $c_orientacion)
{
	chrome_log( "	SELECT AC.F_INICIO, M.D_PUBLICA
					FROM ALUMNOS_CURSOS AC, MATERIAS M
					WHERE AC.N_ID_PERSONA = $id_usuario
					AND AC.C_IDENTIFICACION = $c_identificacion
					AND AC.C_PROGRAMA = $c_programa
					AND AC.C_ORIENTACION = $c_orientacion
					AND AC.n_id_materia = M.N_ID_MATERIA
					AND AC.N_ID_MATERIA NOT IN (  	SELECT DISTINCT(N_ID_MATERIA)
					                              	FROM ALUMNOS_LIBRETAS AL
					                              	WHERE  AL.N_ID_PERSONA = $id_usuario
					                            	AND AL.C_IDENTIFICACION = $c_identificacion
													AND AL.C_PROGRAMA = $c_programa
													AND AL.C_ORIENTACION = $c_orientacion )
					ORDER BY AC.N_ID_MATERIA

				");

	$resultado = $this->db->query( "	SELECT AC.F_INICIO, AC.F_FIN, M.D_PUBLICA
										FROM ALUMNOS_CURSOS AC, MATERIAS M
										WHERE AC.N_ID_PERSONA = $id_usuario
										AND AC.C_IDENTIFICACION = $c_identificacion
										AND AC.C_PROGRAMA = $c_programa
										AND AC.C_ORIENTACION = $c_orientacion
										AND AC.n_id_materia = M.N_ID_MATERIA
										AND AC.N_ID_MATERIA NOT IN (  	SELECT DISTINCT(N_ID_MATERIA)
										                              	FROM ALUMNOS_LIBRETAS AL
										                              	WHERE  AL.N_ID_PERSONA = $id_usuario
										                            	AND AL.C_IDENTIFICACION = $c_identificacion
																		AND AL.C_PROGRAMA = $c_programa
																		AND AL.C_ORIENTACION = $c_orientacion )
										ORDER BY AC.N_ID_MATERIA

									" );

	return $resultado;
}

function traer_materias_aprobadas_alumno($id_usuario , $c_identificacion , $c_programa , $c_orientacion)
{
	chrome_log( "	traer_materias_aprobadas_alumno ");

	chrome_log( "	SELECT AL.N_ID_MATERIA, AL.F_RINDE, AL.D_NOTA_LETRA, AL.N_NOTA_NUMERO, M.D_DESCRIP
					FROM ALUMNOS_LIBRETAS AL, MATERIAS M
					WHERE AL.N_ID_PERSONA = $id_usuario
					AND AL.C_IDENTIFICACION = $c_identificacion
					AND AL.C_PROGRAMA = $c_programa
					AND AL.C_ORIENTACION = $c_orientacion
					AND AL.n_id_materia = M.n_id_materia
					AND AL.N_NOTA_NUMERO >= 4

				");

	$resultado = $this->db->query( "	SELECT AL.N_ID_MATERIA, AL.F_RINDE, AL.D_NOTA_LETRA, AL.N_NOTA_NUMERO, M.D_DESCRIP
										FROM ALUMNOS_LIBRETAS AL, PROGRAMAS P, MATERIAS M
										WHERE AL.N_ID_PERSONA = $id_usuario
										AND AL.C_IDENTIFICACION = P.C_IDENTIFICACION
										AND AL.C_ORIENTACION = P.C_ORIENTACION
										AND AL.C_PROGRAMA = P.C_PROGRAMA
										AND AL.C_IDENTIFICACION = $c_identificacion
										AND AL.C_PROGRAMA = $c_programa
										AND AL.C_ORIENTACION = $c_orientacion
										AND al.n_id_materia = m.n_id_materia
										AND AL.N_NOTA_NUMERO >= 4

									" );

	return $resultado;
}

function traer_materias_desaprobadas_alumno($id_usuario , $c_identificacion , $c_programa , $c_orientacion)
{
	chrome_log( "traer_materias_desaprobadas_alumno");

	$resultado = $this->db->query( "	SELECT AL.N_ID_MATERIA, AL.F_RINDE, AL.D_NOTA_LETRA, AL.N_NOTA_NUMERO, M.D_DESCRIP
										FROM ALUMNOS_LIBRETAS AL, PROGRAMAS P, MATERIAS M
										WHERE AL.N_ID_PERSONA = $id_usuario
										AND AL.C_IDENTIFICACION = P.C_IDENTIFICACION
										AND AL.C_ORIENTACION = P.C_ORIENTACION
										AND AL.C_PROGRAMA = P.C_PROGRAMA
										AND AL.C_IDENTIFICACION = $c_identificacion
										AND AL.C_PROGRAMA = $c_programa
										AND AL.C_ORIENTACION = $c_orientacion
										AND al.n_id_materia = m.n_id_materia
										AND AL.N_NOTA_NUMERO < 4

									" );

	return $resultado;
}

function insertar_postulacion($id_persona, $c_identificacion , $id_tipo_postulacion)
{
    chrome_log( "insertar_postulacion");

    $this->db->set('ID_POSTULACION', "ID_POSTULACION.nextval", false);

	$array = array(
	        'id_persona' => $id_persona,
	        'ID_TIPO_POSTULACION' => $id_tipo_postulacion,
	        'c_identificacion' => $c_identificacion
	      );

	$fecha = date("Y-m-d");

	$this->db->set('fecha',"to_date('$fecha','yyyy/mm/dd')",false);

	$this->db->insert('postulacion',$array);

	$resultado = $this->db->query("SELECT ID_POSTULACION.CURRVAL as ID FROM postulacion" );

	return $resultado->row()->ID;
}

function insertar_rel_postulacion_experiencia($id_postulacion, $id_experiencia, $prioridad)
{
    chrome_log( "insertar_rel_postulacion_experiencia");

    $id_estado_postulacion = $this->traer_id_estado_postulacion('Postulado');

	$array = array(
	        'id_postulacion' => $id_postulacion,
	        'id_experiencia' => $id_experiencia,
	        'id_estado' => $id_estado_postulacion,
	        'prioridad' => $prioridad,
	      );


	$this->db->insert('rel_postulacion_experiencia',$array);
}

function cargar_materia($array)
{
    chrome_log("cargar_materia");

	$array_insert = array(
	        'id_postulacion' => $array['id_postulacion'],
	        'materia_externa' => $array['nombre_materia_externa']
	      );

	if(isset($array['id_materia_ucema']))
			$array_insert['id_materia'] = $array['id_materia_ucema'];

	if(isset($array['descripcion_materia_externa']))
			$array_insert['descripcion_mat_ext'] = $array['descripcion_materia_externa'];

	$this->db->insert('rel_postulacion_materia',$array_insert);
}


function eliminar_materia($array)
{
    chrome_log("eliminar_materia");

	$array_where = array(
	        'id_postulacion' => $array['id_postulacion'],
	        'materia_externa' => $array['materia_externa']
	      );

	$this->db->delete('rel_postulacion_materia',$array_where);
}

//-- ALUMNOS IN ----------

function cargar_alumno_in($array)
{
	chrome_log( "cargar_alumno_in" );

	$array_alumno_in =  array();

	$this->db->set('id_alumno_in', "ID_ALUMNO_IN.nextval", false);

	$array_alumno_in['apellidos'] = utf8_decode($array['apellidos']);
	$array_alumno_in['nombres'] = utf8_decode($array['nombres']);
	$array_alumno_in['id_univ_origen'] = utf8_decode($array['id_univ_origen']);
	$array_alumno_in['sexo'] = utf8_decode($array['sexo']);
	$array_alumno_in['email_1'] = utf8_decode($array['email_1']);


	// SI ES STUDY ABROAD

	if( isset($array['c_identificacion']) && !empty($array['c_identificacion']) ):

		 $array_alumno_in['c_identificacion'] = $array['c_identificacion'];

    endif;

     if( isset($array['id_tipo_experiencia']) && !empty($array['id_tipo_experiencia']) ):

		 $array_alumno_in['id_tipo_experiencia'] = $array['id_tipo_experiencia'];

    endif;

    // SI ES POR CONVENIO

    if( isset($array['id_experiencia_elegido']) && !empty($array['id_experiencia_elegido']) ):

		$array_alumno_in['id_experiencia'] = $array['id_experiencia_elegido'];

    endif;


	$array_alumno_in['id_estado_postulacion'] = 61;

	if( $array['fecha_nacimiento'] && !empty($array['fecha_nacimiento']) ):

		$fecha = $array['fecha_nacimiento'];
	    $this->db->set('fecha_nacimiento',"to_date('$fecha','yyyy/mm/dd')",false);

    endif;

    if( $array['pais_origen'] && !empty($array['pais_origen']) ):

		 $array_alumno_in['pais_origen'] = $array['pais_origen'];

    endif;



    if( $array['email_2'] && !empty($array['email_2']) ):

		 $array_alumno_in['email_2'] = utf8_decode($array['email_2']);

    endif;

    if( $array['pasaporte'] && !empty($array['pasaporte']) ):

		 $array_alumno_in['pasaporte'] = utf8_decode($array['pasaporte']);

    endif;

    if( $array['fecha_expira_pasa'] && !empty($array['fecha_expira_pasa']) ):

		$fecha = $array['fecha_expira_pasa'];
	    $this->db->set('fecha_expira_pasa',"to_date('$fecha','yyyy/mm/dd')",false);

    endif;

    if( $array['calle'] && !empty($array['calle']) ):

		$array_alumno_in['calle'] = utf8_decode($array['calle']);

    endif;

    if( $array['numero_calle'] && !empty($array['numero_calle']) ):

		$array_alumno_in['numero_calle'] = utf8_decode($array['numero_calle']);

    endif;

    if( $array['depto'] && !empty($array['depto']) ):

		$array_alumno_in['depto'] = utf8_decode($array['depto']);

    endif;

    if( $array['codigo_postal'] && !empty($array['codigo_postal']) ):

		$array_alumno_in['codigo_postal'] = utf8_decode($array['codigo_postal']);

    endif;

    if( $array['telefono'] && !empty($array['telefono']) ):

		$array_alumno_in['telefono'] = utf8_decode($array['telefono']);

    endif;

    if( $array['carrera'] && !empty($array['carrera']) ):

		$array_alumno_in['carrera'] = utf8_decode($array['carrera']);

    endif;

    if( $array['titulo'] && !empty($array['titulo']) ):

		$array_alumno_in['titulo'] = utf8_decode($array['titulo']);

    endif;

    if( $array['comentario'] && !empty($array['comentario']) ):

		$array_alumno_in['comentario'] = utf8_decode($array['comentario']);

    endif;


	$this->db->insert('alumnos_intercambio_in',$array_alumno_in);

	return $this->db->affected_rows();
}

function modificar_alumno_in($array)
{
	chrome_log( "modificar_alumno_in" );

	$array_alumno_in =  array();

	//$this->db->set('id_alumno_in', "ID_ALUMNO_IN.nextval", false);

	$array_alumno_in['apellidos'] = utf8_decode($array['apellidos']);
	$array_alumno_in['nombres'] = utf8_decode($array['nombres']);
	$array_alumno_in['id_univ_origen'] = utf8_decode($array['id_univ_origen']);

	if( $array['fecha_nacimiento'] && !empty($array['fecha_nacimiento']) ):

		$fecha = $array['fecha_nacimiento'];
	    $this->db->set('fecha_nacimiento',"to_date('$fecha','yyyy/mm/dd')",false);

    endif;

    $array_alumno_in['pais_origen'] = utf8_decode($array['pais_origen']);
    $array_alumno_in['email_1'] = utf8_decode($array['email_1']);


    // SI ES STUDY ABROAD

	if( isset($array['c_identificacion']) && !empty($array['c_identificacion']) ):

		$array_alumno_in['c_identificacion'] = $array['c_identificacion'];
		$array_alumno_in['id_experiencia'] = NULL;

    endif;

    if( isset($array['id_tipo_experiencia']) && !empty($array['id_tipo_experiencia']) ):

		$array_alumno_in['id_tipo_experiencia'] = $array['id_tipo_experiencia'];


    endif;

    // SI ES POR CONVENIO

    if( isset($array['id_experiencia_elegido']) && !empty($array['id_experiencia_elegido']) ):

		$array_alumno_in['id_experiencia'] = $array['id_experiencia_elegido'];
		$array_alumno_in['c_identificacion'] = NULL;
		$array_alumno_in['id_tipo_experiencia'] = NULL;

    endif;


    if( $array['sexo'] && !empty($array['sexo']) ):

		 $array_alumno_in['sexo'] = utf8_decode($array['sexo']);

    endif;

    if( $array['email_2'] && !empty($array['email_2']) ):

		 $array_alumno_in['email_2'] = utf8_decode($array['email_2']);

    endif;

    if( $array['fecha_expira_pasa'] && !empty($array['fecha_expira_pasa']) ):

		$fecha = $array['fecha_expira_pasa'];
	    $this->db->set('fecha_expira_pasa',"to_date('$fecha','yyyy/mm/dd')",false);

    endif;

    if( $array['calle'] && !empty($array['calle']) ):

		$array_alumno_in['calle'] = utf8_decode($array['calle']);

    endif;

    if( $array['numero_calle'] && !empty($array['numero_calle']) ):

		$array_alumno_in['numero_calle'] = utf8_decode($array['numero_calle']);

    endif;

    if( $array['depto'] && !empty($array['depto']) ):

		$array_alumno_in['depto'] = utf8_decode($array['depto']);

    endif;

    if( $array['codigo_postal'] && !empty($array['codigo_postal']) ):

		$array_alumno_in['codigo_postal'] = utf8_decode($array['codigo_postal']);

    endif;

    if( $array['telefono'] && !empty($array['telefono']) ):

		$array_alumno_in['telefono'] = utf8_decode($array['telefono']);

    endif;

    if( $array['carrera'] && !empty($array['carrera']) ):

		$array_alumno_in['carrera'] = utf8_decode($array['carrera']);

    endif;

    if( $array['titulo'] && !empty($array['titulo']) ):

		$array_alumno_in['titulo'] = utf8_decode($array['titulo']);

    endif;

    if( $array['comentario'] && !empty($array['comentario']) ):

		$array_alumno_in['comentario'] = utf8_decode($array['comentario']);

    endif;

	$this->db->where('id_alumno_in', $array['id_alumno_in']);
	$this->db->update('alumnos_intercambio_in', $array_alumno_in);

	return $this->db->affected_rows();
}

// No se usa mas
function buscar_alumno_in()
{
	chrome_log( "buscar_alumno_in" );

	$sql = 	" 	SELECT *
				FROM ALUMNOS_INTERCAMBIO_IN a
				     LEFT JOIN empresas emp ON a.ID_UNIV_ORIGEN = emp.N_ID_EMPRESA
				     LEFT JOIN
				        ( 	SELECT pai.*, ei.id_experiencia
				            FROM 	EXPERIENCIA_INTERNACIONAL ei,
				                periodo_academico_intercambio pai
				            WHERE
				                ei.id_periodo_academico = pai.id_periodo_intercambio
				                AND (ei.activo = 1 OR EI.ACTIVO iS NULL)
				        ) res
				        ON a.id_experiencia = res.id_experiencia
				ORDER BY ID_ALUMNO_IN DESC ";

	$query = $this->db->query( $sql );

	return $query;
}



function traer_postulaciones_in_asignadas_periodo($id_periodo)
{
  chrome_log("    SELECT  aii.ID_ALUMNO_IN ,
                      ei.C_IDENTIFICACION,
                       ei.ID_TIPO_EXPERIENCIA
              FROM ALUMNOS_INTERCAMBIO_IN aii,
                   EXPERIENCIA_INTERNACIONAL ei
              WHERE
                  aii.ID_EXPERIENCIA = ei.ID_EXPERIENCIA
              AND ei.ID_PERIODO_ACADEMICO = $id_periodo
              AND ( aii.ID_ESTADO_POSTULACION = 63 OR aii.ID_ESTADO_POSTULACION = 67)");


  $sql = "    SELECT  aii.ID_ALUMNO_IN ,
                      ei.C_IDENTIFICACION,
                       ei.ID_TIPO_EXPERIENCIA
              FROM ALUMNOS_INTERCAMBIO_IN aii,
                   EXPERIENCIA_INTERNACIONAL ei
              WHERE
                  aii.ID_EXPERIENCIA = ei.ID_EXPERIENCIA
              AND ei.ID_PERIODO_ACADEMICO = ?
              AND ( aii.ID_ESTADO_POSTULACION = 62 OR aii.ID_ESTADO_POSTULACION = 67)";

  $resultado = $this->db->query( $sql, array($id_periodo));

  return $resultado;
}



function traer_informacion_alumno_in( $id_alumno_in )
{
	chrome_log( "Model/traer_informacion_alumno_in ".$id_alumno_in);


	$sql = 	"	SELECT *
				FROM ALUMNOS_INTERCAMBIO_IN a
				     LEFT JOIN empresas emp ON a.ID_UNIV_ORIGEN = emp.N_ID_EMPRESA
				WHERE a.ID_ALUMNO_IN = '$id_alumno_in' ";

	$query = $this->db->query( $sql );

	//var_dump($query);

	chrome_log( "Cantidad: ".$query->num_rows());

	return $query->row();
}

function traer_ultimas_postulaciones_in()
{
	chrome_log( "traer_ultimas_postulaciones_in");

	$sql = 	"  	SELECT  res.*
				FROM (
							SELECT AII.*,
					       EI.C_IDENTIFICACION AS C_IDENTIFICACION_EXP,
					       EI.ID_TIPO_EXPERIENCIA  AS ID_TIPO_EXPERIENCIA_EXP,
					       DECODE(  EI.C_IDENTIFICACION,
					                NULL,
					                DECODE( AII.C_IDENTIFICACION, 1, 'G', 'PG' ) ,
					                DECODE( EI.C_IDENTIFICACION, 1, 'G', 'PG' )
					             ) AS C_IDENTIFICACION_DES,
					       DECODE(  EI.ID_TIPO_EXPERIENCIA,
					                NULL,
					                DECODE( AII.ID_TIPO_EXPERIENCIA, 21, 'PI', DECODE( AII.ID_TIPO_EXPERIENCIA, 22, 'CC', 'PP' ) ) ,
					                DECODE( EI.ID_TIPO_EXPERIENCIA,  21, 'PI', DECODE( EI.ID_TIPO_EXPERIENCIA, 22, 'CC', 'PP' ) )
					             ) AS DESCRIPCION

							FROM ALUMNOS_INTERCAMBIO_IN AII
							     LEFT JOIN EXPERIENCIA_INTERNACIONAL EI on AII.ID_EXPERIENCIA = EI.ID_EXPERIENCIA
							WHERE
									(ei.activo = 1 OR EI.ACTIVO iS NULL)
							ORDER BY ID_ALUMNO_IN DESC
					) res
				WHERE ROWNUM <=	 8 ";

	$query = $this->db->query( $sql );

	return $query;
}

function buscar_postulaciones_in()
{
	chrome_log( "buscar_postulaciones_in");

	$sql = 	"  	SELECT *
				FROM ALUMNOS_INTERCAMBIO_IN AII
					    LEFT JOIN  ( 	SELECT pai.periodo, ei2.* , emp.D_EMPRESA
						                FROM 	EXPERIENCIA_INTERNACIONAL ei2,
						                      	periodo_academico_intercambio pai,
						                      	contratos_ucema cu,
						              			EMPRESAS emp
						                WHERE
					                    		ei2.id_periodo_academico = pai.id_periodo_intercambio
					                    AND  	( ei2.activo = 1 OR EI2.ACTIVO iS NULL )
					                    AND  	pai.id_contrato_ucema = cu.n_id_contrato_ucema
						            	AND  	cu.n_id_empresa = emp.N_ID_EMPRESA
					            ) EI
					    ON AII.ID_EXPERIENCIA = EI.ID_EXPERIENCIA
				WHERE
				    ( ei.activo = 1 OR
				      ( ei.activo IS NULL AND aii.ID_UNIV_ORIGEN = -1)
				    )
				ORDER BY ID_ALUMNO_IN DESC ";

	$query = $this->db->query( $sql );

	return $query;
}



function modificar_estado_alumno_in($array)
{
	chrome_log( "modificar_estado_alumno_in" );

	$array_alumno_in =  array();

	$array_alumno_in['ID_ESTADO_POSTULACION'] = $array['id_estado_postulacion'];

	$this->db->where('id_alumno_in', $array['id_alumno_in']);
	$this->db->update('alumnos_intercambio_in', $array_alumno_in);

	return $this->db->affected_rows();
}


//-- Trae todas las postulaciones PI, CC y PP.
//-- De PI trae una de todas las opciones.

function traer_ultimas_postulaciones_out()
{
	chrome_log( "traer_ultimas_postulaciones");



	$sql = 	"  	SELECT *
				FROM (
						SELECT    	POS.ID_POSTULACION,
									POS.ID_PERSONA,
						          	POS.FECHA,
									POS.ID_TIPO_POSTULACION,
									EI.ID_TIPO_EXPERIENCIA,
									PE.D_APELLIDOS ,
									PE.D_NOMBRES,
									POS.c_identificacion,
									CASE TE.DESCRIPCION
										WHEN 'Programa Intercambio'	THEN 'PI'
										WHEN 'Curso Corto' THEN 'CC'
										ELSE 'PP'
									END as DESCRIPCION,
									CASE POS.c_identificacion
										WHEN 1 THEN 'G'
										WHEN 2 THEN 'PG'
										ELSE 'PE'
									END as C_IDENTIFICACION_DES
						FROM  EXPERIENCIA_INTERNACIONAL EI,
						      (
						        SELECT MAX(ID_POSTULACION) as ID_POSTULACION, MAX(ID_EXPERIENCIA) as ID_EXPERIENCIA
						        FROM REL_POSTULACION_EXPERIENCIA
						        GROUP BY ID_POSTULACION
						        ORDER BY ID_POSTULACION DESC
						      ) RES,
						      TIPO_EXPERIENCIA TE,
						      POSTULACION POS,
						      TIPO_POSTULACION TP,
						      PERSONAS PE
						WHERE  EI.ID_EXPERIENCIA = RES.ID_EXPERIENCIA
						AND EI.ID_TIPO_EXPERIENCIA = TE.ID_TIPO_EXPERIENCIA
						AND POS.ID_POSTULACION = RES.ID_POSTULACION
						AND POS.ID_TIPO_POSTULACION = TP.ID_TIPO_POSTULACION
						AND TP.DESCRIPCION = 'Outgoing'
						AND POS.ID_PERSONA = PE.N_ID_PERSONA
						AND EI.ACTIVO = 1
						ORDER BY POS.FECHA DESC
						) res
				WHERE ROWNUM <=	 20 ";

	$query = $this->db->query( $sql );

	return $query;
}

function traer_postulaciones_out()
{
	chrome_log( "traer_postulaciones");

	$sql = 	"	SELECT
				     p.FECHA,
				     p.ID_POSTULACION,
				     p.C_IDENTIFICACION,
				     pe.n_id_persona ,
				     MAX(ap.F_ALTA),
				     pr.D_DESCRED,
				     PE.D_APELLIDOS ,
				     PE.D_NOMBRES,
				     SIGF_PROMEDIO_ALUMNO(ap.c_identificacion,ap.c_programa,ap.c_orientacion, ap.n_id_persona ) as promedio
				FROM postulacion p,
				     TIPO_POSTULACION tp,
				     personas pe,
				     alumnos_programas ap,
				     programas pr
				WHERE
				     tp.ID_TIPO_POSTULACION = 22
				AND  p.ID_TIPO_POSTULACION = tp.ID_TIPO_POSTULACION
				AND  p.ID_PERSONA = pe.n_id_persona
				AND  p.ID_PERSONA = ap.N_ID_PERSONA
				AND  ap.C_IDENTIFICACION =  pr.C_IDENTIFICACION
				AND  ap.C_PROGRAMA =  pr.C_PROGRAMA
				AND  ap.C_ORIENTACION =  pr.C_ORIENTACION
				AND  AP.f_alta = (
				                    SELECT max(F_ALTA)
				                    FROM alumnos_programas ap2
				                    WHERE ap2.N_ID_PERSONA = p.ID_PERSONA
				                  )
				GROUP BY
				     p.FECHA,
				     p.ID_POSTULACION,
				     p.C_IDENTIFICACION,
				     pe.n_id_persona ,
				     pr.D_DESCRED,
				     PE.D_APELLIDOS ,
				     PE.D_NOMBRES,
				     SIGF_PROMEDIO_ALUMNO(ap.c_identificacion,ap.c_programa,ap.c_orientacion, ap.n_id_persona )
				ORDER BY p.FECHA DESC";

	$query = $this->db->query( $sql );

	return $query;
}

/*
function traer_esperiencias_postulacion($id_postulacion)
{
	chrome_log( "traer_esperiencias_postulacion");

	$sql = 	"	SELECT *
				FROM REL_POSTULACION_EXPERIENCIA rpe,
				     EXPERIENCIA_INTERNACIONAL ei,
				     ESTADO_POSTULACION ep
				WHERE rpe.ID_POSTULACION = $id_postulacion
				AND   rpe.ID_EXPERIENCIA = ei.ID_EXPERIENCIA
				AND   rpe.ID_ESTADO = ep.ID_ESTADO_POSTULACION";

	$query = $this->db->query( $sql );

	return $query;
}*/



function traer_ultimas_postulaciones_programas_intercambio($tipo_postulacion)
{
	// 1: Incoming | 2: Outgoing

	chrome_log( "traer_ultimas_postulaciones_programas_intercambio");

	$sql = 	"	SELECT
				       po.FECHA,
				       po.ID_POSTULACION,
				       rpe.PRIORIDAD,
				       ap.n_id_persona ,
				       max(ap.C_PLAN),
				       ap.C_IDENTIFICACION,
				       ap.C_PROGRAMA,
				       ap.C_ORIENTACION,
				       pr.D_DESCRED,
				       PE.D_APELLIDOS ,
				       PE.D_NOMBRES,
				       emp.D_EMPRESA,
				       ei.C_IDENTIFICACION,
				       ep.DESCRIPCION as estado_descripcion,
				       ep.ID_ESTADO_POSTULACION,
				       SIGF_PROMEDIO_ALUMNO(ap.c_identificacion,ap.c_programa,ap.c_orientacion, ap.n_id_persona ) as promedio,
				       ei.ID_EXPERIENCIA

				FROM  alumnos_programas ap,
				      programas pr,
				      postulacion po,
				      personas pe,
				      REL_POSTULACION_EXPERIENCIA rpe,
				      EXPERIENCIA_INTERNACIONAL ei,
				      contratos_ucema cu,
				      EMPRESAS emp,
				      TIPO_EXPERIENCIA te,
				      TIPO_POSTULACION tp,
				      estado_postulacion ep
				WHERE ap.C_IDENTIFICACION =  pr.C_IDENTIFICACION
				AND  ap.C_PROGRAMA =  pr.C_PROGRAMA
				AND  ap.C_ORIENTACION =  pr.C_ORIENTACION
				AND  po.ID_PERSONA = ap.N_ID_PERSONA
				AND  po.ID_PERSONA = PE.N_ID_PERSONA
				AND  rpe.ID_POSTULACION = po.ID_POSTULACION
				AND  rpe.ID_EXPERIENCIA = ei.ID_EXPERIENCIA
				AND  rpe.ID_ESTADO = ep.ID_ESTADO_POSTULACION
				AND  ei.id_convenio = cu.n_id_contrato_ucema
				AND  ei.ID_TIPO_EXPERIENCIA = te.ID_TIPO_EXPERIENCIA
				AND  te.DESCRIPCION = 'Programa Intercambio'
				AND  cu.n_id_empresa = emp.N_ID_EMPRESA
				AND  po.ID_TIPO_POSTULACION = tp.ID_TIPO_POSTULACION
				AND  tp.ID_TIPO_POSTULACION = ?
				AND  ei.ACTIVO = 1
				GROUP BY
				        po.FECHA,
				        po.ID_POSTULACION,
				        rpe.PRIORIDAD,
				        ap.n_id_persona,
				        ap.C_IDENTIFICACION,
				        ap.C_PROGRAMA,
				        ap.C_ORIENTACION,
				        pr.D_DESCRED,
				        PE.D_APELLIDOS ,
				        PE.D_NOMBRES,
				        emp.D_EMPRESA,
				        ei.C_IDENTIFICACION,
				        tp.DESCRIPCION,
				        ep.DESCRIPCION,
				        ep.ID_ESTADO_POSTULACION,
				        SIGF_PROMEDIO_ALUMNO(ap.c_identificacion,ap.c_programa,ap.c_orientacion, ap.n_id_persona ),
				        ei.ID_EXPERIENCIA

				ORDER BY po.FECHA DESC";

	$query = $this->db->query( $sql, array($tipo_postulacion) );

	return $query;
}

function traer_ultimas_postulaciones_curso_corto($tipo_postulacion)
{
	// 1: Incoming | 2: Outgoing

	chrome_log( "traer_ultimas_postulaciones_curso_corto");

	$sql = 	"	SELECT
				       po.FECHA,
				       po.ID_POSTULACION,
				       rpe.PRIORIDAD,
				       ap.n_id_persona ,
				       max(ap.C_PLAN),
				       ap.C_IDENTIFICACION,
				       ap.C_PROGRAMA,
				       ap.C_ORIENTACION,
				       pr.D_DESCRED,
				       PE.D_APELLIDOS ,
				       PE.D_NOMBRES,
				       emp.D_EMPRESA,
				       ei.C_IDENTIFICACION,
				       ei.TITULO,
				       ep.DESCRIPCION as estado_descripcion,
				       ep.ID_ESTADO_POSTULACION,
				       SIGF_PROMEDIO_ALUMNO(ap.c_identificacion,ap.c_programa,ap.c_orientacion, ap.n_id_persona ) as promedio,
				       ei.ID_EXPERIENCIA
				FROM  alumnos_programas ap,
				      programas pr,
				      postulacion po,
				      personas pe,
				      REL_POSTULACION_EXPERIENCIA rpe,
				      EXPERIENCIA_INTERNACIONAL ei,
				      contratos_ucema cu,
				      EMPRESAS emp,
				      TIPO_EXPERIENCIA te,
				      TIPO_POSTULACION tp,
				      estado_postulacion ep
				WHERE ap.C_IDENTIFICACION =  pr.C_IDENTIFICACION
				AND  ap.C_PROGRAMA =  pr.C_PROGRAMA
				AND  ap.C_ORIENTACION =  pr.C_ORIENTACION
				AND  po.ID_PERSONA = ap.N_ID_PERSONA
				AND  po.ID_PERSONA = PE.N_ID_PERSONA
				AND  rpe.ID_POSTULACION = po.ID_POSTULACION
				AND  rpe.ID_EXPERIENCIA = ei.ID_EXPERIENCIA
				AND  rpe.id_estado = ep.id_estado_postulacion
				AND  ei.id_convenio = cu.n_id_contrato_ucema
				AND  ei.ID_TIPO_EXPERIENCIA = te.ID_TIPO_EXPERIENCIA
				AND  te.DESCRIPCION = 'Curso Corto'
				AND  cu.n_id_empresa = emp.N_ID_EMPRESA
				AND  po.ID_TIPO_POSTULACION = tp.ID_TIPO_POSTULACION
				AND  tp.ID_TIPO_POSTULACION = 22
				AND  ei.ACTIVO = 1
				GROUP BY
				         po.FECHA,
				        po.ID_POSTULACION,
				        rpe.PRIORIDAD,
				        ap.n_id_persona,
				        ap.C_IDENTIFICACION,
				        ap.C_PROGRAMA,
				        ap.C_ORIENTACION,
				        pr.D_DESCRED,
				        PE.D_APELLIDOS ,
				        PE.D_NOMBRES,
				        emp.D_EMPRESA,
				        ei.C_IDENTIFICACION,
				        tp.DESCRIPCION,
				        ei.TITULO,
				        ep.DESCRIPCION,
				        ep.ID_ESTADO_POSTULACION,
				        SIGF_PROMEDIO_ALUMNO(ap.c_identificacion,ap.c_programa,ap.c_orientacion, ap.n_id_persona ),
				        ei.ID_EXPERIENCIA
				ORDER BY po.ID_POSTULACION, rpe.PRIORIDAD ";

	$query = $this->db->query( $sql, array($tipo_postulacion) );

	return $query;
}


function traer_ultimas_postulaciones_practica_profesional($tipo_postulacion)
{
	// 1: Incoming | 2: Outgoing

	chrome_log( "traer_ultimas_postulaciones_practica_profesional");

	$sql = 	"	SELECT
				       po.FECHA,
				       po.ID_POSTULACION,
				       rpe.PRIORIDAD,
				       ap.n_id_persona ,
				       max(ap.C_PLAN),
				       ap.C_IDENTIFICACION,
				       ap.C_PROGRAMA,
				       ap.C_ORIENTACION,
				       pr.D_DESCRED,
				       PE.D_APELLIDOS ,
				       PE.D_NOMBRES,
				       emp.D_EMPRESA,
				       ei.C_IDENTIFICACION,
				       ei.TITULO,
				       ep.DESCRIPCION as estado_descripcion,
				       ep.ID_ESTADO_POSTULACION,
				       SIGF_PROMEDIO_ALUMNO(ap.c_identificacion,ap.c_programa,ap.c_orientacion, ap.n_id_persona ) as promedio,
				       ei.ID_EXPERIENCIA
				FROM  alumnos_programas ap,
				      programas pr,
				      postulacion po,
				      personas pe,
				      REL_POSTULACION_EXPERIENCIA rpe,
				      EXPERIENCIA_INTERNACIONAL ei,
				      contratos_ucema cu,
				      EMPRESAS emp,
				      TIPO_EXPERIENCIA te,
				      TIPO_POSTULACION tp,
				      estado_postulacion ep
				WHERE ap.C_IDENTIFICACION =  pr.C_IDENTIFICACION
				AND  ap.C_PROGRAMA =  pr.C_PROGRAMA
				AND  ap.C_ORIENTACION =  pr.C_ORIENTACION
				AND  po.ID_PERSONA = ap.N_ID_PERSONA
				AND  po.ID_PERSONA = PE.N_ID_PERSONA
				AND  rpe.ID_POSTULACION = po.ID_POSTULACION
				AND  rpe.ID_EXPERIENCIA = ei.ID_EXPERIENCIA
				AND  rpe.id_estado = ep.id_estado_postulacion
				AND  ei.id_convenio = cu.n_id_contrato_ucema
				AND  ei.ID_TIPO_EXPERIENCIA = te.ID_TIPO_EXPERIENCIA
				AND  te.DESCRIPCION = 'Practica Profesional'
				AND  cu.n_id_empresa = emp.N_ID_EMPRESA
				AND  po.ID_TIPO_POSTULACION = tp.ID_TIPO_POSTULACION
				AND  tp.ID_TIPO_POSTULACION = 22
				AND  ei.ACTIVO = 1
				GROUP BY
				         po.FECHA,
				        po.ID_POSTULACION,
				        rpe.PRIORIDAD,
				        ap.n_id_persona,
				        ap.C_IDENTIFICACION,
				        ap.C_PROGRAMA,
				        ap.C_ORIENTACION,
				        pr.D_DESCRED,
				        PE.D_APELLIDOS ,
				        PE.D_NOMBRES,
				        emp.D_EMPRESA,
				        ei.C_IDENTIFICACION,
				        tp.DESCRIPCION,
				        ei.TITULO,
				        ep.DESCRIPCION,
				         ep.ID_ESTADO_POSTULACION,
				        SIGF_PROMEDIO_ALUMNO(ap.c_identificacion,ap.c_programa,ap.c_orientacion, ap.n_id_persona ),
				        ei.ID_EXPERIENCIA
				ORDER BY po.ID_POSTULACION, rpe.PRIORIDAD ";

	$query = $this->db->query( $sql, array($tipo_postulacion) );

	return $query;
}



function traer_postulaciones_usuario($id_usuario, $id_tipo_postulacion )
{
	chrome_log( "traer_postulaciones_usuario");

	chrome_log( "	SELECT  po.*, PRG.D_DESCRED
					FROM  	POSTULACION po
					        LEFT JOIN PROGRAMAS PRG ON 	po.c_identificacion = prg.c_identificacion
					                           AND  po.c_programa = prg.c_programa
					                           AND  po.c_orientacion = prg.c_orientacion
					WHERE
					      po.ID_PERSONA = ?
					AND   po.ID_TIPO_POSTULACION = ? ");

	$sql = 	"	SELECT  po.*, PRG.D_DESCRED
				FROM  	POSTULACION po
				        LEFT JOIN PROGRAMAS PRG ON 	po.c_identificacion = prg.c_identificacion
				                           AND  po.c_programa = prg.c_programa
				                           AND  po.c_orientacion = prg.c_orientacion
				WHERE
				      po.ID_PERSONA = ?
				AND   po.ID_TIPO_POSTULACION = ? ";

	$query = $this->db->query( $sql, array($id_usuario, $id_tipo_postulacion) );

	return $query;
}

function traer_postulaciones_out_experiencia($id_experiencia )
{
	chrome_log( "traer_postulaciones_out_experiencia");

	$sql = 	"	SELECT
				      po.FECHA,
				      po.ID_POSTULACION,
				      rpe.PRIORIDAD,
				      PE.D_APELLIDOS ,
				      PE.D_NOMBRES,
				      ep.DESCRIPCION as estado_descripcion,
				      rpe.ID_ESTADO,
				      PE.N_ID_PERSONA,
				      rpe.id_experiencia
				FROM
				    postulacion po,
				    personas pe,
				    REL_POSTULACION_EXPERIENCIA rpe,
				    ESTADO_POSTULACION ep
				WHERE
				      po.ID_PERSONA = pe.n_id_persona
				AND   rpe.ID_EXPERIENCIA = ?
				AND   rpe.ID_POSTULACION = po.ID_POSTULACION
				AND   rpe.ID_ESTADO = ep.ID_ESTADO_POSTULACION ";

	$query = $this->db->query( $sql, array($id_experiencia) );

	return $query;
}


function traer_postulaciones_in_experiencia($id_experiencia )
{
	chrome_log( "traer_postulaciones_in_experiencia");

	$sql = 	"	SELECT *
				FROM alumnos_intercambio_in aii,
				     estado_postulacion ep
				where aii.id_experiencia = ?
				AND aii.ID_ESTADO_POSTULACION = ep.id_estado_postulacion";

	$query = $this->db->query( $sql, array($id_experiencia) );

	return $query;
}

 /*
function traer_experiencias_postulacion($id_postulacion)
{
	chrome_log( "traer_postulaciones_usuario");

	$sql = 	"	SELECT  rpe.*,
				    	ei.*,
				    	emp.D_EMPRESA,
				    	te.descripcion as tipo_experiencia_des,
				    	ep.descripcion descripcion_estado,
				    	decode(ei.titulo, NULL, emp.D_EMPRESA, ei.titulo ) as titulo_exp -- Si es PI, muestro la empresa, sino el titulo
				FROM
						REL_POSTULACION_EXPERIENCIA rpe,
						EXPERIENCIA_INTERNACIONAL ei,
						TIPO_EXPERIENCIA te,
						contratos_ucema cu,
						EMPRESAS emp,
						ESTADO_POSTULACION ep
				WHERE
						rpe.ID_POSTULACION = ?
				AND   	rpe.ID_EXPERIENCIA = ei.ID_EXPERIENCIA
				AND   	ei.ID_TIPO_EXPERIENCIA = te.ID_TIPO_EXPERIENCIA
				AND   	rpe.ID_ESTADO = ep.id_estado_postulacion
				AND   	ei.id_convenio = cu.n_id_contrato_ucema
				AND   	cu.n_id_empresa = emp.N_ID_EMPRESA
				AND  	ei.ACTIVO = 1
				ORDER BY rpe.prioridad ASC";

	$query = $this->db->query( $sql, array($id_postulacion) );

	return $query;
}
 */

function traer_experiencias_postulacion($id_postulacion)
{
	chrome_log( "traer_experiencias_postulacion");

	$sql = 	"	SELECT  rpe.*,
				    	ei.*,
				    	ei.ID_TIPO_EXPERIENCIA as ID_TIPO_EXPERIENCIA,
				    	emp.D_EMPRESA,
				    	emp.N_ID_EMPRESA,
				    	te.descripcion as tipo_experiencia_des,
				    	ep.descripcion descripcion_estado,
				    	decode(ei.titulo, NULL, emp.D_EMPRESA, ei.titulo ) as titulo_exp,
				    	pai.periodo,
				    	pai.activo as periodo_activo
				FROM
						REL_POSTULACION_EXPERIENCIA rpe,
						EXPERIENCIA_INTERNACIONAL ei,
						TIPO_EXPERIENCIA te,
						contratos_ucema cu,
						EMPRESAS emp,
						ESTADO_POSTULACION ep,
						periodo_academico_intercambio pai
				WHERE
						rpe.ID_POSTULACION = ?
				AND   	rpe.ID_EXPERIENCIA = ei.ID_EXPERIENCIA
				AND   	ei.ID_TIPO_EXPERIENCIA = te.ID_TIPO_EXPERIENCIA
				AND   	rpe.ID_ESTADO = ep.ID_ESTADO_POSTULACION
				AND   	pai.id_contrato_ucema = cu.n_id_contrato_ucema
				AND 	pai.id_periodo_intercambio = ei.ID_PERIODO_ACADEMICO
				AND   	cu.n_id_empresa = emp.N_ID_EMPRESA
				AND  	ei.ACTIVO = 1
				ORDER BY rpe.prioridad ASC";

				chrome_log( "	SELECT  rpe.*,
				    	ei.*,
				    	ei.ID_TIPO_EXPERIENCIA as ID_TIPO_EXPERIENCIA,
				    	emp.D_EMPRESA,
				    	te.descripcion as tipo_experiencia_des,
				    	ep.descripcion descripcion_estado,
				    	decode(ei.titulo, NULL, emp.D_EMPRESA, ei.titulo ) as titulo_exp
				FROM
						REL_POSTULACION_EXPERIENCIA rpe,
						EXPERIENCIA_INTERNACIONAL ei,
						TIPO_EXPERIENCIA te,
						contratos_ucema cu,
						EMPRESAS emp,
						ESTADO_POSTULACION ep,
						periodo_academico_intercambio pai
				WHERE
						rpe.ID_POSTULACION = $id_postulacion
				AND   	rpe.ID_EXPERIENCIA = ei.ID_EXPERIENCIA
				AND   	ei.ID_TIPO_EXPERIENCIA = te.ID_TIPO_EXPERIENCIA
				AND   	rpe.ID_ESTADO = ep.ID_ESTADO_POSTULACION
				AND   	pai.id_contrato_ucema = cu.n_id_contrato_ucema
				AND 	pai.id_periodo_intercambio = ei.ID_PERIODO_ACADEMICO
				AND   	cu.n_id_empresa = emp.N_ID_EMPRESA
				AND  	ei.ACTIVO = 1
				ORDER BY rpe.prioridad ASC");

	$query = $this->db->query( $sql, array($id_postulacion) );

	return $query;
}

function traer_materias_postulacion($id_postulacion)
{
	chrome_log( "traer_materias_postulacion");

	$sql = 	"	SELECT *
				FROM REL_POSTULACION_MATERIA  RPM
					 LEFT JOIN MATERIAS M ON RPM.id_materia = M.N_ID_MATERIA
				WHERE rpm.id_postulacion = ? ";

	$query = $this->db->query( $sql, array($id_postulacion) );

	return $query;
}


function traer_archivos_postulacion( $id_postulacion )
{
	chrome_log( "traer_archivos_postulacion");

	chrome_log( 	"	SELECT *
				FROM postulacion_archivo pa
				WHERE pa.id_postulacion = $id_postulacion ");

	$sql = 	"	SELECT *
				FROM postulacion_archivo pa
				WHERE pa.id_postulacion = ? ";

	$query = $this->db->query( $sql, array($id_postulacion) );

	return $query;
}

function cargar_archivo($array, $nombre_archivo)
{
	chrome_log("cargar_materia");

	 $this->db->set('ID_ARCHIVO_POSTULACION', "ID_ARCHIVO_POSTULACION.nextval", false);

	$array_insert = array(
	        'id_postulacion' => $array['id_postulacion'],
	        'nombre_archivo' => $nombre_archivo
	      );

	if(isset($array['titulo_archivo']))
			$array_insert['titulo'] = $array['titulo_archivo'];

	if(isset($array['descripcion_archivo']))
			$array_insert['descripcion'] = $array['descripcion_archivo'];

	$this->db->insert('postulacion_archivo',$array_insert);
}

function eliminar_archivo($array)
{
	chrome_log("eliminar_archivo");

	$array_where = array(
	        'id_postulacion' => $array['id_postulacion'],
	        'nombre_archivo	' => $array['nombre_archivo']
	      );

	$this->db->delete('POSTULACION_ARCHIVO',$array_where);
}

function cambiar_estado_experiencia($array)
{
	chrome_log( "cambiar_estado_experiencia");


	// Si se cumple tengo que poner a todos las demas opciones como "Vacante no adjudicada"

	if( $array['id_estado_postulacion'] == $this->traer_id_estado_postulacion('Asignacion de Vacante') ||
		$array['id_estado_postulacion'] == $this->traer_id_estado_postulacion('Enviada al Partner') ||
		$array['id_estado_postulacion'] == $this->traer_id_estado_postulacion('Realizando el intercambio') ||
		$array['id_estado_postulacion'] == $this->traer_id_estado_postulacion('Realizando el intercambio')

	  ):

		$id_estado_no_adjudicada = $this->traer_id_estado_postulacion('Vacante no adjudicada');


		$sql = " 	UPDATE  REL_POSTULACION_EXPERIENCIA
					SET id_estado = ?
					WHERE 	id_postulacion = ?
					AND		ID_ESTADO != 82 ";

		$this->db->query($sql, array( $id_estado_no_adjudicada, $array['id_postulacion']));

	endif;

	// Si esta realizando el intercambio, pongo la fecha de comienzo en la postulacion
	if( $array['id_estado_postulacion'] == $this->traer_id_estado_postulacion('Realizando el intercambio') ):


		$fecha = date("Y-m-d");
		$this->db->set('FECHA_COM_INTERCAMBIO',"to_date('$fecha','yyyy/mm/dd')",false);

		$this->db->where('id_postulacion', $array['id_postulacion'] );
		$this->db->update('postulacion');

	endif;


	$array_where = array(  'id_postulacion' => $array['id_postulacion'],
						   'id_experiencia' => $array['id_experiencia']  );

	$array_estado['id_estado'] = $array['id_estado_postulacion'];

	$this->db->where($array_where);
	$this->db->update('REL_POSTULACION_EXPERIENCIA', $array_estado);

	return $this->db->affected_rows();
}

function elegir_programa_ucema_intercambio($array)
{
	chrome_log( "elegir_programa_ucema_intercambio");
	$array_where = array(  'id_postulacion' => $array['id_postulacion']  );

	$array_estado['c_identificacion'] = $array['c_identificacion'];
	$array_estado['c_programa'] = $array['c_programa'];
	$array_estado['c_orientacion'] = $array['c_orientacion'];

	$this->db->where($array_where);
	$this->db->update('postulacion', $array_estado);

	return $this->db->affected_rows();
}


// Traer Tipos -----

function traer_id_tipo_postulacion($string)
{
   	chrome_log( "traer_id_tipo_postulacion");

   	$sql = "   SELECT *
              FROM tipo_postulacion
              WHERE  descripcion =  '$string' ";

  	$query = $this->db->query( $sql );

  	return $query->row()->ID_TIPO_POSTULACION;
}

function traer_id_tipo_experiencia($string)
{
   	chrome_log( "traer_id_tipo_experiencia");

   	$sql = "   SELECT *
              FROM TIPO_EXPERIENCIA
              WHERE  descripcion =  '$string' ";

  	$query = $this->db->query( $sql );

  	return $query->row()->ID_TIPO_EXPERIENCIA;
}

function traer_id_estado_postulacion($string)
{
	chrome_log( "traer_id_estado_postulacion");

	$sql = "   	SELECT *
			  	FROM estado_postulacion
			 	WHERE  descripcion =  '$string' ";

	$query = $this->db->query( $sql );

	return $query->row()->ID_ESTADO_POSTULACION;
}

function traer_estados_postulacion()
{
	chrome_log( "traer_estados_postulacion");

	$sql = "   	SELECT *
			  	FROM ESTADO_POSTULACION
			  	WHERE ID_ESTADO_POSTULACION != 82 ";

	$query = $this->db->query( $sql );

	return $query;
}

function traer_tipos_experiencia()
{
	chrome_log( "traer_tipos_experiencia");

	$sql = "   	SELECT *
			  	FROM TIPO_EXPERIENCIA ";

	$query = $this->db->query( $sql );

	return $query;
}

function traer_cantidad_postulaciones_intecambio($tipo_experiencia)
{
    $sql = " 	SELECT
				      POS.ID_POSTULACION,
				      POS.ID_PERSONA,
				      POS.FECHA,
				      POS.ID_TIPO_POSTULACION,
				      EI.ID_TIPO_EXPERIENCIA,
				      EI.c_identificacion
				FROM  EXPERIENCIA_INTERNACIONAL EI,
				      (
				        SELECT MAX(ID_POSTULACION) as ID_POSTULACION, MAX(ID_EXPERIENCIA) as ID_EXPERIENCIA
				        FROM REL_POSTULACION_EXPERIENCIA
				        GROUP BY ID_POSTULACION
				        ORDER BY ID_POSTULACION DESC
				      ) RES,
				      TIPO_EXPERIENCIA TE,
				      POSTULACION POS,
				      TIPO_POSTULACION TP
				WHERE  EI.ID_EXPERIENCIA = RES.ID_EXPERIENCIA
				AND EI.ID_TIPO_EXPERIENCIA = TE.ID_TIPO_EXPERIENCIA
				AND POS.ID_POSTULACION = RES.ID_POSTULACION
				AND POS.ID_TIPO_POSTULACION = TP.ID_TIPO_POSTULACION
				AND TP.DESCRIPCION = 'Outgoing'
				AND TE.ID_TIPO_EXPERIENCIA = ?
				AND  ei.ACTIVO = 1
				ORDER BY EI.C_IDENTIFICACION ASC
          ";

    $query = $this->db->query( $sql, array( $tipo_experiencia ));

    return $query;
}

function enviar_alumnoin_sigeu($datos_alumno)
{
	$this->db->trans_start();

	// INGRESAR A PERSONA

		$id_persona = $this->db->query('SELECT id_persona.NEXTVAL as ID_PERSONA from dual')->row()->ID_PERSONA;

		$this->db->set('N_ID_PERSONA', $id_persona , false);

		$persona = array(
		        'PERSONA_TYPE' => 'Estudiante',
		        'C_TIPO_DOCUMENTO' => 'PA');

		if( isset( $datos_alumno->PASAPORTE ) && !empty($datos_alumno->PASAPORTE) ):
			$documento = preg_replace("/[A-Za-z]/", "", $datos_alumno->PASAPORTE);
	        $persona['N_DOCUMENTO'] = $documento;
	    	$persona['C_PASAPORTE'] = $datos_alumno->PASAPORTE;
	    else:
	    	$persona['N_DOCUMENTO'] = NULL;
	    	$persona['C_PASAPORTE'] = NULL;
	    endif;

	// Constraint NOT NULL

	    $persona['D_APELLIDOS'] = $datos_alumno->APELLIDOS;
	    $persona['D_NOMBRES'] = $datos_alumno->NOMBRES;
	    $persona['M_SEXO'] =  $datos_alumno->SEXO;
	    $this->db->set('F_ALTA',"TO_CHAR(SYSDATE)",false);
	    $persona['C_USUARIOALT'] = $this->session->userdata('usuario_crm');

	 	$this->db->insert('PERSONAS',$persona);

	// INGRESAR A EMAIL 1

	 	$email = array( );

		$email['N_ID_PERSONA'] = $id_persona;
		$email['C_CORREO'] = 'e-mail 1';
	    $email['C_EMAIL'] = $datos_alumno->EMAIL_1;
	    $this->db->set('F_ALTA',"TO_CHAR(SYSDATE)",false);
	    $persona['C_USUARIOALT'] = $this->session->userdata('usuario_crm');

 		$this->db->insert('CORREOS',$email);

 	// INGRESAR A EMAIL 2

 		if( isset( $datos_alumno->EMAIL_2  ) && !empty(  $datos_alumno->EMAIL_2  ) ):

		 	$email_2 = array( );

			$email_2['N_ID_PERSONA'] = $id_persona;
			$email_2['C_CORREO'] = 'e-mail 2';
		    $email_2['C_EMAIL'] = $datos_alumno->EMAIL_2;
		    $this->db->set('F_ALTA',"TO_CHAR(SYSDATE)",false);
		    $persona['C_USUARIOALT'] = $this->session->userdata('usuario_crm');

	 		$this->db->insert('CORREOS',$email_2);

	 	endif;


	// CAMBIAR ENABLED EN ALUMNO IN

		$alumno_in = array( );

		$alumno_in['ENABLED'] = 0;
	    $alumno_in['N_ID_PERSONA'] = $id_persona;

		$this->db->where('ID_ALUMNO_IN', $datos_alumno->ID_ALUMNO_IN);
		$this->db->update('alumnos_intercambio_in', $alumno_in);

	$this->db->trans_complete();

	return $this->db->trans_status();
}

public function existe_pasaporte($pasaporte)
{
	chrome_log("Login_model/existe_pasaporte/".$pasaporte);

	$sql = "	SELECT P.N_ID_PERSONA
				FROM PERSONAS P
				WHERE p.C_PASAPORTE = '$pasaporte' " ;

 	// PE , DNI ( por los uruguayos )
	$query = $this->db->query($sql);

	if($query->num_rows() > 0)
		return true;
	else
		return false;
}

public function existe_pasaporte_sigeu($pasaporte)
{
	chrome_log("Login_model/existe_pasaporte_sigeu/".$pasaporte);

	$pasaporte = preg_replace("/[A-Za-z]/", "", $pasaporte);

	$sql = "	SELECT P.N_ID_PERSONA
				FROM  PERSONAS P
				WHERE  ( p.c_tipo_documento = 'PA' AND p.C_PASAPORTE = ? )
				OR 		N_DOCUMENTO = ?		" ;

	$query = $this->db->query($sql, array($pasaporte, $pasaporte));

	if($query->num_rows() > 0)
		return true;
	else
		return false;
}


function traer_descripcion_estado_postulacion($string)
{
  $sql = "  SELECT *
            FROM ESTADO_POSTULACION ep
            WHERE ep.descripcion = ? ";

  $query = $this->db->query( $sql, array($string) );

  //echo "Cantidad: ".$query->num_rows();
  return $query->row()->ID_ESTADO_POSTULACION;
}

/*
function traer_postulaciones_periodo_estado($id_periodo, $id_estado)
{
	chrome_log("postulacion_model/traer_postulaciones_periodo_estado/");

	$sql = "	SELECT ei.*,
				       rpe.*,
				       pr.C_IDENTIFICACION as c_iden_carrera_elegida,
				       pr.c_programa as c_prg_carrera_elegida,
				       pr.c_orientacion as c_orin_carrera_elegida,
				       pr.D_descred
				FROM EXPERIENCIA_INTERNACIONAL ei,
				     REL_POSTULACION_EXPERIENCIA rpe,
				     postulacion p
				      LEFT JOIN programas pr ON p.C_IDENTIFICACION = pr.C_IDENTIFICACION
				                             AND p.c_programa = pr.c_programa
				                             AND p.c_orientacion = pr.c_orientacion
				WHERE ei.ID_PERIODO_ACADEMICO = ?
				AND rpe.ID_EXPERIENCIA = ei.ID_EXPERIENCIA
				AND rpe.id_postulacion = p.id_postulacion
				AND rpe.ID_ESTADO =  ?
				AND ei.activo = 1 " ;

	$query = $this->db->query($sql, array($id_periodo, $id_estado));

    return $query;

}*/

/*
81	Cancelado
61	Postulado
62	Postulacion Aceptada
63	Asignacion de Vacante
64	Enviada al Partner
65	Baja Voluntaria
66	Vacante no adjudicada
67	Realizando el intercambio
68	Llego el transfer/certificado
82	EI eliminada*/

function traer_postulaciones_out_asignadas_periodo($id_periodo)
{
	chrome_log("postulacion_model/traer_postulaciones_out_asignadas_periodo/");

	$sql = "	SELECT ei.*,
				       rpe.*,
				       pr.C_IDENTIFICACION as c_iden_carrera_elegida,
				       pr.c_programa as c_prg_carrera_elegida,
				       pr.c_orientacion as c_orin_carrera_elegida,
				       pr.D_descred
				FROM EXPERIENCIA_INTERNACIONAL ei,
				     REL_POSTULACION_EXPERIENCIA rpe,
				     postulacion p
				      LEFT JOIN programas pr ON p.C_IDENTIFICACION = pr.C_IDENTIFICACION
				                             AND p.c_programa = pr.c_programa
				                             AND p.c_orientacion = pr.c_orientacion
				WHERE ei.ID_PERIODO_ACADEMICO = ?
				AND rpe.ID_EXPERIENCIA = ei.ID_EXPERIENCIA
				AND rpe.id_postulacion = p.id_postulacion
				AND ( rpe.ID_ESTADO =  63 OR rpe.ID_ESTADO =  64 OR rpe.ID_ESTADO =  67 OR rpe.ID_ESTADO =  68 )
				AND ei.activo = 1 " ;

	$query = $this->db->query($sql, array($id_periodo));

    return $query;

}

function traer_archivos_postulacion_in($id_alumno_in)
{
	chrome_log("postulacion_model/traer_archivos_postulacion_in/");

	$sql = "	SELECT *
				FROM ALUMNO_INTERCAMBIO_IN_ARCHIVO aia
				WHERE aia.ID_ALUMNO_IN = ?" ;

	$query = $this->db->query($sql, array($id_alumno_in));

    return $query;
}

function cargar_archivo_in($array, $nombre_archivo)
{
	chrome_log("cargar_archivo_in");

	$this->db->set('ID_ARCHIVO_ALUMNO_IN', "ID_ARCHIVO_ALUMNO_IN.nextval", false);

	$array_insert = array(
	        'id_alumno_in' => $array['id_alumno_in'],
	        'nombre_archivo' => $nombre_archivo
	      );

	if(isset($array['titulo_archivo']))
			$array_insert['titulo'] = $array['titulo_archivo'];

	if(isset($array['descripcion_archivo']))
			$array_insert['descripcion'] = $array['descripcion_archivo'];

	$this->db->insert('ALUMNO_INTERCAMBIO_IN_ARCHIVO',$array_insert);
}


function eliminar_archivo_in($array)
{
	chrome_log("eliminar_archivo_in");

	$array_where = array(
	        'id_archivo_alumno_in' => $array['id_archivo_alumno_in'],
	        'nombre_archivo	' => $array['nombre_archivo']
	      );

	$this->db->delete('ALUMNO_INTERCAMBIO_IN_ARCHIVO',$array_where);
}


}


?>