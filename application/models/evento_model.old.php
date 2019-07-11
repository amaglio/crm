<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Evento_model extends CI_Model {


public function __construct()
{
  $this->load->model('Contacto_model');
	parent::__construct();
}


function traer_eventos()
{

	$resultado = $this->db->query("	SELECT *
                				    			FROM CRM_EVENTO ce,
                                       CRM_TIPO_EVENTO cte
                                  WHERE ce.id_tipo_evento = cte.id_tipo_evento
                                  AND activo = 1
                                  ORDER BY id_crm_evento DESC"
                				    		);

	return $resultado;
}


function traer_info_evento($id_crm_evento)
{

  $resultado = $this->db->query(" SELECT *
                                  FROM CRM_EVENTO ce,
                                       CRM_TIPO_EVENTO cte
                                  WHERE ce.id_tipo_evento = cte.id_tipo_evento
                                  AND id_crm_evento = $id_crm_evento
                                  ORDER BY id_crm_evento DESC"
                                );

  return $resultado->row();
}

function traer_tipos_evento()
{

  $resultado = $this->db->query(" SELECT *
                                  FROM CRM_TIPO_EVENTO cte "
                                );

  return $resultado;
}

function traer_inscriptos_evento($id_crm_evento)
{

  $resultado = $this->db->query(" SELECT distinct( cep.id_crm_persona ),
                                         DECODE( cp.nombre, NULL, p.D_NOMBRES,cp.nombre) as nombres,
                                         DECODE( cp.apellido, NULL, p.D_APELLIDOS, cp.apellido) as apellidos
                                  FROM crm_evento_persona cep,
                                       crm_persona cp
                                       LEFT JOIN personas p ON cp.ID_PERSONA = p.n_id_persona
                                  WHERE
                                        cep.id_crm_evento =  $id_crm_evento
                                  AND   cep.id_crm_persona = cp.id_crm_persona"
                                );

  return $resultado;
}

function traer_fechas_inscriptos_evento($id_crm_evento)
{

  $resultado = $this->db->query(" SELECT DECODE( cp.nombre, NULL, p.D_NOMBRES,cp.nombre) as nombres,
                                         DECODE( cp.apellido, NULL, p.D_APELLIDOS, cp.apellido) as apellidos,
                                         cep.id_crm_persona,
                                         cep.id_crm_evento
                                  FROM crm_evento_persona cep,
                                       crm_persona cp
                                       LEFT JOIN personas p ON cp.ID_PERSONA = p.n_id_persona
                                  WHERE
                                        cep.id_crm_evento = $id_crm_evento
                                  AND   cep.id_crm_persona = cp.id_crm_persona"
                                );

  return $resultado;
}


function traer_inscriptos_fecha_evento($id_crm_evento, $fecha)
{

  $resultado = $this->db->query(" SELECT distinct( cep.id_crm_persona ),
                                         UPPER(DECODE( cp.nombre, NULL, p.D_NOMBRES,cp.nombre)) as nombres,
                                         UPPER(DECODE( cp.apellido, NULL, p.D_APELLIDOS, cp.apellido)) as apellidos,
                                         cep.asistio,
                                         cep.id_crm_evento
                                  FROM crm_evento_persona cep,
                                       crm_persona cp
                                       LEFT JOIN personas p ON cp.ID_PERSONA = p.n_id_persona
                                  WHERE
                                        cep.id_crm_evento =  $id_crm_evento
                                  AND   cep.id_crm_persona = cp.id_crm_persona
                                  AND   cep.fecha_evento = TO_DATE('$fecha','YYYYMMDD') "
                                );

  return $resultado;
}

public function modificar_asistencia_evento($array)
{
    // Pongo todos los ASISTIO en 0 para ese evento y esa fecha

    $fecha = $array['fecha'];
    $id_crm_evento = $array['id_crm_evento'];

    $sql = "UPDATE CRM_EVENTO_PERSONA
            SET ASISTIO = 0
            WHERE FECHA_EVENTO =  TO_DATE($fecha,'YYYYMMDD')
            AND ID_CRM_EVENTO = $id_crm_evento" ;

    $this->db->query($sql);


    // Pongo todos los ASISTIO en 1 para ese evento y esa fecha a los que chequearon


    foreach ($array['id_asistio'] as $key => $value)
    {
       // Pongo todos los ASISTIO en 0 para ese evento y esa fecha

      $fecha = $array['fecha'];
      $id_crm_evento = $array['id_crm_evento'];

      $sql = "UPDATE CRM_EVENTO_PERSONA
              SET ASISTIO = 1
              WHERE FECHA_EVENTO =  TO_DATE($fecha,'YYYYMMDD')
              AND ID_CRM_EVENTO = $id_crm_evento
              AND ID_CRM_PERSONA =  $value " ;

      $this->db->query($sql);

    }

    return $this->db->affected_rows();
}


function traer_fechas_evento($id_crm_evento)
{

  $resultado = $this->db->query(" SELECT  to_char(cte.FECHA, 'DD/MM/YYYY' ) as FECHA,
                                          to_char(cte.FECHA, 'YYYYMMDD' ) as FECHA_ENVIAR
                                  FROM CRM_EVENTO_FECHA cte
                                  WHERE id_crm_evento = $id_crm_evento"
                                );

  return $resultado;
}


public function abm_evento($accion, $array)
{

  switch ($accion):

    case 'A':

        $this->db->set('ID_CRM_EVENTO', "ID_CRM_EVENTO.nextval", false);

        $evento['NOMBRE'] = utf8_decode($array['nombre']);
        $evento['ID_TIPO_EVENTO'] = utf8_decode($array['id_tipo_evento']);
        $this->db->insert('CRM_EVENTO', $evento);

        $id_crm_evento = $this->db->query("SELECT ID_CRM_EVENTO.CURRVAL as ID FROM CRM_EVENTO" )->row()->ID;

        if($array['fecha_evento']):

            foreach ($array['fecha_evento'] as $key => $value)
            {
                $fecha = $value;
                $this->db->set('FECHA',"to_date('$fecha','DD-MM-YYYY')",false);
                $fecha_evento['ID_CRM_EVENTO'] = $id_crm_evento;
                $this->db->insert('CRM_EVENTO_FECHA', $fecha_evento);
            }

        endif;


        break;

    case 'M':

      $array_where = array( 'ID_CRM_EVENTO' => $array['id_crm_evento'] );

      $evento =  array();
      $evento['NOMBRE'] = utf8_decode($array['nombre']);
      $evento['ID_TIPO_EVENTO'] = utf8_decode($array['id_tipo_evento']);

      $this->db->where($array_where);
      $this->db->update('CRM_EVENTO', $evento);

      break;

    case 'B':

      $this->db->where('ID_CRM_EVENTO', $array['id_crm_evento']);
      $this->db->delete('CRM_EVENTO');


      break;

  endswitch;


  return $this->db->affected_rows();
}

public function abm_inscripto($accion, $array)
{

  switch ($accion):

    case 'A':

        foreach ($array['fechas_elegidas'] as $key => $value):

          $fecha = $value;
          $this->db->set('FECHA_EVENTO',"to_date('$fecha','DD-MM-YYYY')",false);
          $evento['ID_CRM_EVENTO'] = utf8_decode($array['id_crm_evento']);
          $evento['ID_CRM_PERSONA'] = utf8_decode($array['id_crm_persona']);
          $this->db->insert('CRM_EVENTO_PERSONA', $evento);

        endforeach;

        // Log anotado en un evento
        $this->Contacto_model->insertar_log_persona( 14 , $array['id_crm_persona'], NULL, NULL,$array['id_crm_evento']  );

    case 'B':

      /*
      $this->db->where('ID_CRM_EVENTO', $array['id_crm_evento']);
      $this->db->delete('CRM_EVENTO'); */


      break;

  endswitch;


  return $this->db->affected_rows();
}

}

/* End of file  */
/* Location: ./application/models/ */