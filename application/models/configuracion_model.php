<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Configuracion_model extends CI_Model {

public $variable;

public function __construct()
{

	parent::__construct();
}

//------ Universidad

function traer_programas_universidad($id_usuario)
{

	$resultado = $this->db->query("	SELECT DEVUELVE_PROGRAMA(op.c_identificacion, op.c_programa, op.c_orientacion) as programa, op.*,
                                         op.c_identificacion|| '-'||  op.c_programa ||'-'|| op.c_orientacion as id
                				    			FROM CRM_OPERADOR_PROGRAMA op
                				    			WHERE op.id_persona = $id_usuario
                                  ORDER BY programa"
                				    		);

	return $resultado;
}

function traer_emails_plantillas()
{

  $resultado = $this->db->query(" SELECT *
                                  FROM CRM_EMAIL_PLANTILLA "
                                );

  return $resultado;
}

function traer_informacion_email_plantilla($id_crm_email_plantilla)
{

  $resultado = $this->db->query(" SELECT *
                                  FROM CRM_EMAIL_PLANTILLA
                                  WHERE id_crm_email_plantilla = $id_crm_email_plantilla "
                                );

  return $resultado->row();
}


function agregar_programa($array)
{
  $this->db->trans_start();

    // Me fijo si ya existe el programa

    $id_persona = $array['id_persona'];

    $sql = "  SELECT 1
              FROM CRM_OPERADOR_PROGRAMA op
              WHERE op.id_persona = ?
              AND c_identificacion = ?
              AND c_programa = ?
              AND c_orientacion = ? " ;

    $resultado = $this->db->query($sql, array( $array['id_persona'], $array['c_identificacion'], $array['c_programa'],$array['c_orientacion']) );

    if($resultado->num_rows() == 0 ): // No existe, entonces la agrego

      $array_agregar_programa['c_identificacion'] = utf8_decode($array['c_identificacion']);
      $array_agregar_programa['c_programa'] = utf8_decode($array['c_programa']);
      $array_agregar_programa['c_orientacion'] = utf8_decode($array['c_orientacion']);
      $array_agregar_programa['id_persona'] = utf8_decode($array['id_persona']);

      $this->db->insert('CRM_OPERADOR_PROGRAMA',$array_agregar_programa);

      $flag = 1;

    else: // Ya existe la relacion

      $flag = 2;

    endif;

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

  return $flag;
}


function eliminar_programa($array)
{
  $this->db->trans_start();

    // Me fijo si ya existe el programa

    $id_persona = $array['id_persona'];

    $sql = "  SELECT 1
              FROM CRM_OPERADOR_PROGRAMA op
              WHERE op.id_persona = ?
              AND c_identificacion = ?
              AND c_programa = ?
              AND c_orientacion = ? " ;

    $resultado = $this->db->query($sql, array( $array['id_persona'], $array['c_identificacion'], $array['c_programa'],$array['c_orientacion']) );

    if($resultado->num_rows() > 0 ): // Existe, entonces la elimino

      $array_agregar_programa['c_identificacion'] = utf8_decode($array['c_identificacion']);
      $array_agregar_programa['c_programa'] = utf8_decode($array['c_programa']);
      $array_agregar_programa['c_orientacion'] = utf8_decode($array['c_orientacion']);
      $array_agregar_programa['id_persona'] = utf8_decode($array['id_persona']);


      $this->db->delete('CRM_OPERADOR_PROGRAMA',  $array_agregar_programa );

      $flag = 1;

    else: // Ya existe la relacion

      $flag = 2;

    endif;

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

  return $flag;
}

public function abm_educacion($accion, $array)
{

  switch ($accion):

    case 'A':

      $this->db->set('ID_EDUCACION_CRM', "ID_EDUCACION_CRM.nextval", false);

      $educacion['NOMBRE'] = utf8_decode($array['nombre']);
      $educacion['CARRERA'] = utf8_decode($array['carrera']);
      $educacion['ID_NIVEL_EDUCACION'] = utf8_decode($array['id_nivel']);
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

public function abm_email_plantilla($accion, $array)
{
  switch ($accion):

    case 'A':

      $this->db->set('ID_CRM_EMAIL_PLANTILLA', "ID_CRM_EMAIL_PLANTILLA.nextval", false);

      $email['TITULO'] = utf8_decode($array['nombre']);
      $email['ASUNTO'] = utf8_decode($array['asunto']);
      $email['TEXTO'] = utf8_decode($array['texto']);

      $this->db->insert('CRM_EMAIL_PLANTILLA', $email);

      break;

    case 'M':

      $array_where = array( 'ID_CRM_EMAIL_PLANTILLA' => $array['id_crm_email_plantilla'] );

      $email =  array();

      $email['TITULO'] = utf8_decode($array['nombre']);
      $email['ASUNTO'] = utf8_decode($array['asunto']);
      $email['TEXTO'] = utf8_decode($array['texto2']);

      $this->db->where($array_where);
      $this->db->update('CRM_EMAIL_PLANTILLA', $email);

      break;

    case 'B':

      $this->db->where('ID_CRM_EMAIL_PLANTILLA', $array['id_crm_email_plantilla']);
      $this->db->delete('CRM_EMAIL_PLANTILLA');


      break;

  endswitch;


  return $this->db->affected_rows();
}

public function abm_tipo_evento($accion, $array)
{
  switch ($accion):

    case 'A':

      $this->db->set('ID_TIPO_EVENTO', "ID_TIPO_EVENTO.nextval", false);

      $email['DESCRIPCION'] = utf8_decode($array['nombre']);

      $this->db->insert('CRM_TIPO_EVENTO', $email);

      break;

    case 'M':

      $array_where = array( 'ID_TIPO_EVENTO' => $array['id_tipo_evento'] );

      $email =  array();

      $email['DESCRIPCION'] = utf8_decode($array['nombre']);

      $this->db->where($array_where);
      $this->db->update('CRM_TIPO_EVENTO', $email);

      break;

    case 'B':

      $this->db->where('ID_TIPO_EVENTO', $array['id_tipo_evento']);
      $this->db->delete('CRM_TIPO_EVENTO');


      break;

  endswitch;


  return $this->db->affected_rows();
}


}

/* End of file  */
/* Location: ./application/models/ */