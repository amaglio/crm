<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Universidad_model extends CI_Model {

public $variable;

public function __construct()
{

	parent::__construct();
}

//------ Universidad

function traer_informacion_universidad($id_universidad)
{

	$resultado = $this->db->query("	SELECT *
				    			FROM empresas p
				    			WHERE n_id_empresa = '$id_universidad' "
				    		);

	return $resultado->row();
}

//------ Convenio

function traer_convenios_universidad($id_universidad)
{

	$sql = "	SELECT *
	    			FROM contratos_ucema cu
	    			WHERE CU.N_ID_EMPRESA = ? " ;

  return $this->db->query( $sql, array($id_universidad) );
}

function traer_ultimo_convenio($id_universidad)
{
  chrome_log("modificar_estado_alumno_in");
  $sql = "  SELECT *
            FROM contratos_ucema cu
            WHERE CU.N_ID_EMPRESA = ?
            AND ROWNUM = 1
            ORDER BY N_ID_CONTRATO_UCEMA DESC  " ;

   $query = $this->db->query( $sql, array($id_universidad) );

   return $query->row()->N_ID_CONTRATO_UCEMA;
}

function traer_informacion_convenio($id_convenio)
{

  $sql = "  SELECT cu.n_id_contrato_ucema, cu.f_inicio, cu.F_FIN, cu.tema, cu.n_id_empresa, e.d_empresa
            FROM contratos_ucema cu, empresas e
            WHERE CU.N_ID_EMPRESA = e.n_id_empresa
            AND cu.n_id_contrato_ucema = ? " ;

  $query = $this->db->query( $sql, array($id_convenio));

  return $query->row();
}

//------ Contactos

function traer_contactos_universidad($id_universidad)
{

  $sql =  "  SELECT *
            FROM contacto_universidad cu
            WHERE cu.id_universidad = ?
            AND activo = 1 " ;

  return $this->db->query( $sql, array($id_universidad) );
}

function insertar_contacto($form)
{

  $array_convenio = array(
                'id_universidad' => $form['id_universidad']
              );

  $this->db->set('id_contacto_uni', "ID_CONTACTO_UNI.nextval", false);

  if($form['apellido'])
    $array_convenio['apellido'] = utf8_decode($form['apellido']);

  if($form['nombre'])
    $array_convenio['nombre'] = utf8_decode($form['nombre']);

  if($form['puesto'])
    $array_convenio['puesto'] = utf8_decode($form['puesto']);

  if($form['email'])
    $array_convenio['email'] = utf8_decode($form['email']);

  if($form['telefono'])
    $array_convenio['telefono'] = utf8_decode($form['telefono']);

  if($form['direccion_postal'])
    $array_convenio['direccion_postal'] = utf8_decode($form['direccion_postal']);

  $this->db->insert('contacto_universidad',$array_convenio);

  return $this->db->affected_rows();
}

function eliminar_contacto($form)
{
  $array_where = array(  'id_contacto_uni' => $form['id_contacto'] );

  $array_datos['activo'] = 0;

  $this->db->where($array_where);
  $this->db->update('contacto_universidad', $array_datos);

  return $this->db->affected_rows();
}

function editar_contacto($form)
{
  $array_where = array(  'id_contacto_uni' => $form['id_contacto'] );

  $array_datos = array();

  if($form['apellido'])
    $array_datos['apellido'] = utf8_decode($form['apellido']);

  if($form['nombre'])
    $array_datos['nombre'] = utf8_decode($form['nombre']);

  if($form['puesto'])
    $array_datos['puesto'] = utf8_decode($form['puesto']);

  if($form['email'])
    $array_datos['email'] = utf8_decode($form['email']);

  if($form['telefono'])
    $array_datos['telefono'] = $form['telefono'];

  if($form['direccion_postal'])
    $array_datos['direccion_postal'] = $form['direccion_postal'];


  $this->db->where($array_where);
  $this->db->update('contacto_universidad', $array_datos);

  return $this->db->affected_rows();
}

//------ Certificado - Experiencia

function traer_certificados_experiencia($id_experiencia)
{

  $sql = "   SELECT *
            FROM CERTIFICADO_IDIOMA_EXPERIENCIA rec, certificado_idioma ci
            WHERE rec.id_experiencia = ?
            AND   rec.id_certificado = ci.id_certificado" ;

  return $this->db->query( $sql, array($id_experiencia) );
}


function insertar_certificado_experiencia($form)
{
  $array = array(
                'id_experiencia' => $form['id_experiencia'],
                'id_certificado' => $form['id_certificado'],
                'puntaje' => utf8_decode($form['puntaje'])
              );

  if($form['escritura'] && !empty($form['escritura'] ))
      $array['escritura'] = utf8_decode($form['escritura']);

  if($form['lectura'] && !empty($form['lectura'] ) )
      $array['lectura'] = utf8_decode($form['lectura']);


  $this->db->insert('CERTIFICADO_IDIOMA_EXPERIENCIA',$array);

  return $this->db->affected_rows();
}

function editar_certificado_experiencia($form)
{

  $array = array();

  $array_where = array(
                'id_experiencia' => $form['id_experiencia'],
                'id_certificado' => $form['id_certificado'],
              );

    $array['puntaje'] = $form['puntaje'];

  if($form['escritura'])
      $array['escritura'] = $form['escritura'];

  if($form['lectura'])
      $array['lectura'] = $form['lectura'];

  $this->db->where($array_where);
  $this->db->update('CERTIFICADO_IDIOMA_EXPERIENCIA', $array);

  return $this->db->affected_rows();
}

function eliminar_certificado_experiencia($form)
{
  $array_where = array(
                'id_experiencia' => $form['id_experiencia'],
                'id_certificado' => $form['id_certificado']
              );

  $this->db->where($array_where);
  $this->db->delete('CERTIFICADO_IDIOMA_EXPERIENCIA');

  return $this->db->affected_rows();
}


//------ Varias

function traer_tipos_intecambio()
{
  return $this->db->query(" SELECT *
                            FROM TIPO_EXPERIENCIA");
}

function traer_descripcion_tipo_experiencia($string)
{
  $sql = "  SELECT *
            FROM TIPO_EXPERIENCIA te
            WHERE te.descripcion = ? ";

  $query = $this->db->query( $sql, array($string) );

  return $query->row()->ID_TIPO_EXPERIENCIA;
}

//------ Experiencias internacionales

function crear_experiencia_internacional($form)
{

  $array_experiencia = array(
                'id_periodo_academico' => $form['id_periodo'],
                'id_tipo_experiencia' => $form['id_tipo_experiencia'],
                'c_identificacion'  => $form['c_identificacion']
              );

  $this->db->set('ID_EXPERIENCIA', "ID_EXPERIENCIA.nextval", false);

  if($form['titulo'] && !empty($form['titulo']) )
    $array_experiencia['titulo'] = utf8_decode($form['titulo']);

  //echo $form['deadline'];

   if($form['deadline'] && !empty($form['deadline']) )
  {
    $deadline = $form['deadline'];
    //$this->db->set('deadline',"to_date('$deadline','yyyy/mm/dd')",false);
    $this->db->set('deadline',"to_date('$deadline','dd/mm/yyyy')",false);
  }

  if($form['mes_intercambio']  && !empty($form['mes_intercambio']) )
    $array_experiencia['mes_intercambio'] = $form['mes_intercambio'];

  if($form['anio_intercambio'] && !empty($form['anio_intercambio']) )
    $array_experiencia['anio_intercambio'] = $form['anio_intercambio'];

  if($form['duracion']  && !empty($form['duracion']) )
    $array_experiencia['duracion'] = $form['duracion'];


  $this->db->insert('experiencia_internacional',$array_experiencia);

  return $this->db->affected_rows();
}

function editar_experiencia_internacional($form)
{

  $array_where = array(  'id_experiencia' => $form['id_experiencia'] );

  $array_experiencia['c_identificacion'] = $form['c_identificacion'];

  if(isset($form['titulo']))
    $array_experiencia['titulo'] = utf8_decode($form['titulo']);

  if(isset($form['id_tipo_experiencia']))
    $array_experiencia['id_tipo_experiencia'] = $form['id_tipo_experiencia'];

  if(isset($form['deadline']))
  {
    $deadline = $form['deadline'];
    $this->db->set('deadline',"to_date('$deadline','dd/mm/yyyy')",false);
  }

  if(isset($form['mes_intercambio']))
    $array_experiencia['mes_intercambio'] = $form['mes_intercambio'];

  if(isset($form['anio_intercambio']))
    $array_experiencia['anio_intercambio'] = $form['anio_intercambio'];

  if(isset($form['duracion']))
    $array_experiencia['duracion'] = $form['duracion'];


  $this->db->where($array_where);
  $this->db->update('experiencia_internacional', $array_experiencia);

  return $this->db->affected_rows();
}

function eliminar_experiencia_internacional($form)
{
  $this->db->trans_start();

  // Desactivo la experiencia

  $array_where = array(  'id_experiencia' => $form['id_experiencia'] );
  $array_experiencia['activo'] = 0;

  $this->db->where($array_where);
  $this->db->update('experiencia_internacional', $array_experiencia);

  // Miro si es IN o OUT --

  $sql_postulacion_out = "  SELECT *
                            FROM rel_postulacion_experiencia
                            WHERE  id_experiencia = ?  ";

  $res = $this->db->query( $sql_postulacion_out, array($form['id_experiencia']) );

  if( $res->num_rows() > 0 ): // Es postulacion OUT

    // Pongo como eliminada la EI (No elimino la relacion)

    $array_where = array(  'id_experiencia' => $form['id_experiencia'] );
    $array_postulaciones['id_estado'] = 82;

    $this->db->where($array_where);
    $this->db->update('rel_postulacion_experiencia', $array_postulaciones);


  else: // es postulacion IN

      $array_where = array(  'id_experiencia' => $form['id_experiencia'] );
      $array_postulaciones['id_estado_postulacion'] = 82;

      $this->db->where($array_where);
      $this->db->update('ALUMNOS_INTERCAMBIO_IN', $array_postulaciones);

  endif;

  $this->db->trans_complete();

  chrome_log("Estado: ".$this->db->trans_status());

  return $this->db->trans_status();
}

function traer_informacion_experiencia($id_experiencia)
{
  $sql = "  SELECT ei.*,
                   to_char(ei.deadline, 'DD/MM/YYYY' ) as deadline,
                   tp.descripcion,
                   cu.f_inicio as fecha_inicio_convenio,
                   cu.f_fin as fecha_fin_convenio,
                   cu.tema,
                   cu.N_ID_CONTRATO_UCEMA,
                   emp.D_EMPRESA as universidad,
                   emp.N_ID_EMPRESA,
                   CASE ei.id_tipo_experiencia
                        WHEN 1 THEN 'Programa Intercambio'
                        WHEN 2 THEN 'Curso Corto'
                        ELSE 'Practica Profesional'
                   END as descripcion_tipo_experiencia,
                  CASE ei.c_identificacion
                        WHEN 1 THEN 'Grado'
                        WHEN 2 THEN 'Posgrado'
                   END as descripcion_c_identificacion,
                  pai.periodo,
                  pai.vacantes_in,
                  pai.vacantes_out,
                  pai.id_periodo_intercambio,
                  pai.activo as periodo_activo
            FROM experiencia_internacional ei,
                 tipo_experiencia tp,
                 contratos_ucema cu,
                 empresas emp,
                 periodo_academico_intercambio pai
            WHERE ei.id_experiencia = ?
            AND ei.id_tipo_experiencia = tp.id_tipo_experiencia
            AND pai.ID_CONTRATO_UCEMA = cu.n_id_contrato_ucema
            AND pai.id_periodo_intercambio = ei.id_periodo_academico
            AND CU.N_ID_EMPRESA = emp.n_id_empresa
            AND ei.activo = 1";

  $query = $this->db->query( $sql, array($id_experiencia) );

  return $query->row();
}


//------ Programas

function traer_programas_habilitados($id_experiencia)
{

  $sql = "  SELECT *
            FROM experiencia_prg_habilitado eph, programas p
            WHERE eph.id_experiencia = ?
            AND eph.c_identificacion = p.c_identificacion
            AND eph.c_programa = p.c_programa
            AND eph.c_orientacion = p.c_orientacion ";

  $query = $this->db->query( $sql, array($id_experiencia) );

  return $query;

}

function traer_programas()
{
  $sql = "  SELECT *
            FROM programas
            WHERE ( c_identificacion = 1
            OR c_identificacion = 2 )
            AND c_orientacion = 0
            AND D_DESCRIP NOT LIKE '%Materias%Grado%'
            AND D_DESCRIP != 'Licenciaturas'
            AND D_DESCRIP != 'Licenciatura Ciclo Común'
            AND D_DESCRIP NOT LIKE '%Posg%'
            AND D_DESCRIP NOT LIKE '%Master%'
            ORDER BY c_identificacion, d_descred ";

  $query = $this->db->query( $sql  );
  return $query;
}

//------ Programa - experiencia

function insertar_experiencia_programa($form)
{

  $array = array(
                'id_experiencia' => $form['id_experiencia'],
                'c_identificacion' => $form['c_identificacion'],
                'c_programa' => $form['c_programa'],
                'c_orientacion' => $form['c_orientacion']
              );

  $this->db->insert('experiencia_prg_habilitado',$array);

  return $this->db->affected_rows();
}

function eliminar_programa_experiencia($form)
{

  $array_where = array(
                'id_experiencia' => $form['id_experiencia'],
                'c_identificacion' => $form['c_identificacion'],
                'c_programa' => $form['c_programa'],
                'c_orientacion' => $form['c_orientacion']
              );

  $this->db->where($array_where);
  $this->db->delete('experiencia_prg_habilitado');

  return $this->db->affected_rows();
}

// --- EXPERIENCIAS INTERNACIONALES --

function traer_programas_intercambio()
{
  $id_tipo_experiencia = $this->traer_id_tipo_programa_intercambio('Programa Intercambio');

  $sql =     "SELECT ei.*,
                     e.D_EMPRESA || ' - ' || ei.titulo || ' (' || pai.periodo || ')'  as D_EMPRESA
              FROM  experiencia_internacional ei,
                    contratos_ucema cu,
                    empresas e,
                    PERIODO_ACADEMICO_INTERCAMBIO pai
              WHERE  ei.id_tipo_experiencia = $id_tipo_experiencia
              AND pai.ID_CONTRATO_UCEMA = cu.n_id_contrato_ucema
              AND pai.ID_PERIODO_INTERCAMBIO = ei.ID_PERIODO_ACADEMICO
              and CU.N_ID_EMPRESA = e.N_ID_EMPRESA
              AND ei.activo = 1
              AND pai.activo = 1 ";

  $query = $this->db->query( $sql  );
  return $query;
}


function traer_cursos_cortos()
{
  $id_tipo_experiencia = $this->traer_id_tipo_programa_intercambio('Curso Corto');

  $sql = "    SELECT *
              FROM experiencia_internacional
              WHERE  id_tipo_experiencia =  $id_tipo_experiencia
              AND activo = 1 ";

  $query = $this->db->query( $sql  );
  return $query;
}

function traer_practicas_profesionales()
{
  $id_tipo_experiencia = $this->traer_id_tipo_programa_intercambio('Practica Profesional');

  $sql = "    SELECT *
              FROM experiencia_internacional
              WHERE  id_tipo_experiencia =  $id_tipo_experiencia
              AND activo = 1 ";

  $query = $this->db->query( $sql  );
  return $query;

}

function traer_id_tipo_programa_intercambio($string)
{
  $sql = "   SELECT *
              FROM tipo_experiencia
              WHERE  descripcion =  '$string' ";

  $query = $this->db->query( $sql );

  return $query->row()->ID_TIPO_EXPERIENCIA;
}

function traer_ultimas_experiencias_deadline()
{
  $sql = " SELECT   emp.N_ID_EMPRESA,
                    ei.titulo,
                    ei.id_experiencia,
                    emp.D_EMPRESA,
                    cu.f_fin,
                    ei.deadline,
                    cu.N_ID_CONTRATO_UCEMA,
                    pai.periodo,
                    pai.VACANTES_IN,
                    pai.VACANTES_OUT,
                    CASE TE.DESCRIPCION
                      WHEN 'Programa Intercambio' THEN 'PI'
                      WHEN 'Curso Corto' THEN 'CC'
                      ELSE 'PP'
                    END as DESCRIPCION,
                    CASE ei.c_identificacion
                      WHEN 1 THEN 'Grado'
                      ELSE 'Posgrado'
                    END as descripcion_c_identificacion
            FROM
                 EXPERIENCIA_INTERNACIONAL ei,
                 contratos_ucema CU,
                 empresas emp,
                 PERIODO_ACADEMICO_INTERCAMBIO pai,
                 TIPO_EXPERIENCIA te
            WHERE
                pai.ID_CONTRATO_UCEMA = cu.n_id_contrato_ucema
            AND emp.N_ID_EMPRESA = CU.N_ID_EMPRESA
            AND pai.ID_PERIODO_INTERCAMBIO = ei.ID_PERIODO_ACADEMICO
            AND ei.ID_TIPO_EXPERIENCIA = te.ID_TIPO_EXPERIENCIA
            AND ei.activo = 1
            AND pai.activo = 1
            ORDER BY n_id_empresa, DESCRIPCION  DESC ";

  $query = $this->db->query( $sql );

  return $query;
}


// --- Universidad ----


function traer_ultimas_universidades()
{
  // Buscar las ultimas postulaciones y trae las empresas/universidad a las que es postularon

    $sql = "SELECT distinct(res.n_id_empresa) as id, res.d_empresa as nombre_universidad
            FROM
            (
                select emp.*
                from
                     EXPERIENCIA_INTERNACIONAL ei,
                     contratos_ucema CU,
                     empresas emp,
                     periodo_academico_intercambio pai
                WHERE
                    pai.ID_CONTRATO_UCEMA = cu.n_id_contrato_ucema
                AND pai.ID_PERIODO_INTERCAMBIO = ei.ID_PERIODO_ACADEMICO
                AND emp.N_ID_EMPRESA = CU.N_ID_EMPRESA
                AND ei.activo = 1
                ORDER BY ei.ID_EXPERIENCIA DESC
            ) res
            WHERE
            rownum < 10";

    $query = $this->db->query( $sql );

    return $query;
}


function traer_universidades_con_convenio()
{
  // Buscar las ultimas postulaciones y trae las empresas/universidad a las que es postularon

    $sql = "SELECT distinct(res.id) as id, res.nombre_universidad as nombre_universidad
            FROM
            (
                SELECT emp.N_ID_EMPRESA as id,  emp.d_empresa as nombre_universidad
                FROM
                     contratos_ucema CU,
                     empresas emp
                WHERE
                    emp.N_ID_EMPRESA = CU.N_ID_EMPRESA
                AND CU.tipo = 'INTERCAM'
                AND ( CU.F_FIN IS NULL OR CU.F_FIN > SYSDATE )
                ORDER BY emp.d_empresa ASC
            ) res
            ORDER BY res.nombre_universidad
            ";

    $query = $this->db->query( $sql );

    return $query;
}


function ver_experiencias_universidad($id_universidad)
{
  $sql = "  SELECT ei.titulo,
                 pai.periodo,
                 CASE TE.DESCRIPCION
                    WHEN 'Programa Intercambio' THEN 'PI'
                    WHEN 'Curso Corto' THEN 'CC'
                    ELSE 'PP'
                  END as DESCRIPCION,
                  CASE ei.C_IDENTIFICACION
                    WHEN 1  THEN 'G'
                    WHEN 2 THEN 'PG'
                  END as nivel,
                  ei.ID_EXPERIENCIA
            FROM CONTRATOS_UCEMA cu,
                 PERIODO_ACADEMICO_INTERCAMBIO pai,
                 EXPERIENCIA_INTERNACIONAL ei,
                 TIPO_EXPERIENCIA te
            WHERE cu.n_id_empresa = ?
            AND cu.n_id_contrato_ucema = pai.id_contrato_ucema
            AND pai.ID_PERIODO_INTERCAMBIO = ei.ID_PERIODO_ACADEMICO
            AND ei.ID_TIPO_EXPERIENCIA = te.ID_TIPO_EXPERIENCIA
            AND ei.activo = 1
            AND pai.activo = 1 ";

  $query = $this->db->query( $sql, array($id_universidad) );

  return $query;
}


function traer_periodos_convenio($id_convenio)
{

  $sql = "    SELECT  pai.*,
                     decode(pai.activo, '1', 'Habilitado', 'Deshabilitado') as activo_descripcion
              FROM periodo_academico_intercambio pai
              WHERE pai.ID_CONTRATO_UCEMA = $id_convenio
              AND pai.enabled = 1  " ;

  return $this->db->query( $sql );
}

// --- Periodo ----


function insertar_periodo($form)
{

  $array_periodo = array(
                'ID_CONTRATO_UCEMA' => $form['id_convenio']
              );

  $this->db->set('ID_PERIODO_INTERCAMBIO', "ID_PERIODO_INTERCAMBIO.nextval", false);

  if(isset($form['vacantes_in']))
    $array_periodo['VACANTES_IN'] = $form['vacantes_in'];

  if(isset($form['vacantes_out']))
    $array_periodo['VACANTES_OUT'] = $form['vacantes_out'];

  if( $form['periodo_1'] && $form['periodo_2'] )
    $array_periodo['periodo'] = $form['periodo_1']."/".$form['periodo_2'];

  if(isset($form['comentario_periodo']))
    $array_periodo['COMENTARIO'] = utf8_decode($form['comentario_periodo']);

  $this->db->insert('periodo_academico_intercambio',$array_periodo);

  return $this->db->affected_rows();
}


function editar_periodo($form)
{
  $array = array();

  var_dump($form);

  $array_where = array(

                'ID_PERIODO_INTERCAMBIO' => $form['ID_PERIODO_INTERCAMBIO']

              );

  if($form['vacantes_in'])
      $array['VACANTES_IN'] = $form['vacantes_in'];

  if($form['vacantes_out'])
      $array['VACANTES_OUT'] = $form['vacantes_out'];

  if($form['estado_periodo'] == 'on')
    $array['activo'] = 1;
  else
    $array['activo'] = 0;

  $array['periodo'] = $form['periodo_1']."/".$form['periodo_2'];

  if(isset($form['comentario_periodo']))
    $array['COMENTARIO'] = utf8_decode($form['comentario_periodo']);

  $this->db->where($array_where);
  $this->db->update('periodo_academico_intercambio', $array);

  return $this->db->affected_rows();

}

function eliminar_periodo($form)
{

  $array_where = array( 'id_periodo_intercambio' => $form['id_periodo_intercambio'] );
  $array_periodo['activo'] = 0;

  $this->db->where($array_where);
  $this->db->update('periodo_academico_intercambio', $array_periodo);

  return $this->db->affected_rows();
}

function traer_informacion_periodo($id_periodo)
{

  $sql = "   SELECT *
              FROM periodo_academico_intercambio pai,
                   contratos_ucema cu,
                   empresas emp
              WHERE pai.ID_PERIODO_INTERCAMBIO = $id_periodo
              AND   pai.ID_CONTRATO_UCEMA = cu.n_id_contrato_ucema
              AND   cu.N_ID_EMPRESA = emp.n_id_empresa ";

  $resultado = $this->db->query( $sql );

  return $resultado->row();
}


function traer_tipos_experiencias_periodo($id_periodo_intercambio, $id_tipo_intercambio)
{
  $sql = "  SELECT  ei.*,
                    to_char( ei.deadline, 'DD/MM/YYYY' ) as deadline,
                    CASE ei.c_identificacion
                      WHEN 1 THEN 'Grado'
                      ELSE 'Posgrado'
                    END as descripcion_c_identificacion
            FROM experiencia_internacional ei
            WHERE ei.id_periodo_academico = ?
            AND ei.id_tipo_experiencia = ?
            AND ei.activo = 1" ;

  return $this->db->query( $sql, array($id_periodo_intercambio, $id_tipo_intercambio) );
}


function traer_experiencias_por_tipo ($id_tipo_intercambio)
{
  $sql = " SELECT   emp.N_ID_EMPRESA,
                    ei.titulo,
                    ei.id_experiencia,
                    ei.deadline,
                    emp.D_EMPRESA,
                    cu.f_fin,
                    cu.N_ID_CONTRATO_UCEMA,
                    pai.periodo,
                    pai.VACANTES_IN,
                    pai.VACANTES_OUT,
                    CASE TE.DESCRIPCION
                      WHEN 'Programa Intercambio' THEN 'PI'
                      WHEN 'Curso Corto' THEN 'CC'
                      ELSE 'PP'
                    END as DESCRIPCION,
                    CASE ei.c_identificacion
                      WHEN 1 THEN 'Grado'
                      ELSE 'Posgrado'
                    END as descripcion_c_identificacion
            FROM
                 EXPERIENCIA_INTERNACIONAL ei,
                 contratos_ucema CU,
                 empresas emp,
                 PERIODO_ACADEMICO_INTERCAMBIO pai,
                 TIPO_EXPERIENCIA te
            WHERE
                pai.ID_CONTRATO_UCEMA = cu.n_id_contrato_ucema
            AND emp.N_ID_EMPRESA = CU.N_ID_EMPRESA
            AND pai.ID_PERIODO_INTERCAMBIO = ei.ID_PERIODO_ACADEMICO
            AND ei.ID_TIPO_EXPERIENCIA = te.ID_TIPO_EXPERIENCIA
            AND ei.activo = 1
            AND pai.activo = 1
            AND ei.ID_TIPO_EXPERIENCIA = ?
            ORDER BY n_id_empresa, DESCRIPCION  DESC" ;

  return $this->db->query( $sql, array( $id_tipo_intercambio) );
}

function existe_experiencia($id_experiencia)
{
  $sql = "  SELECT *
            FROM experiencia_internacional ei
            WHERE ei.id_experiencia = ?
            AND ei.activo = 1" ;

  $resultado = $this->db->query( $sql, array($id_experiencia) );

  if( $resultado->num_rows() > 0 )
    return true;
  else
    return false;

}



}

/* End of file  */
/* Location: ./application/models/ */