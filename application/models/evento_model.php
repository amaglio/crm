<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Evento_model extends CI_Model {


public function __construct()
{
  $this->load->model('Contacto_model');
	parent::__construct();
}

public function get_eventos()
{
    //
    $sql =  "   SELECT  ee.*,
                        ete.DESCRIPCION as DESCRIPCION_TIPO,
                        DECODE(ee.TIENE_INSCRIPCIONES, 1, 'si', 'no') as TIENE_INSCRIPCIONES,
                        DECODE(ee.MOSTRAR_WEB, 1, 'si', 'no') as MOSTRAR_WEB
                FROM    EVE_EVENTO ee,
                        EVE_TIPO_EVENTO ete
                WHERE   ee.ID_TIPO_EVENTO = ete.ID_TIPO_EVENTO "  ;

    $query = $this->db->query( $sql );

    return $query->result_array();
}

public function get_evento_fechas($id_evento)
{
    //
    $sql =  "   SELECT *
                FROM  EVE_EVENTO_FECHA
                WHERE ID_EVENTO = ? "  ;

    $query = $this->db->query( $sql, array($id_evento) );

    return $query->result_array();
}

public function get_tipos_eventos()
{
    //
    $sql =  "   SELECT *
                FROM  EVE_TIPO_EVENTO "  ;

    $query = $this->db->query( $sql );

    return $query->result_array();
}

public function get_datos_evento($id_evento)
{
    //
    $sql =  "   SELECT ee.*, ete.DESCRIPCION as DESCRIPCION_TIPO
                FROM    EVE_EVENTO ee,
                        EVE_TIPO_EVENTO ete
                WHERE   ee.ID_TIPO_EVENTO = ete.ID_TIPO_EVENTO
                AND     ee.id_evento = ? "  ;

    $query = $this->db->query( $sql, array($id_evento) );

    return $query->row_array();
}

public function get_asistentes_a_importar($id_evento)
{
    //
    $sql =  "   SELECT *
                FROM CRM_CONTACTO_WEB
                WHERE IMPORTADO = 0
                AND ID_EVENTO = ?
                ORDER BY FECHA_ALTA DESC "  ;

    $query = $this->db->query( $sql, array($id_evento) );

    return $query->result_array();
}

public function get_evento_asistentes($id_evento)
{

    $sql =  "   SELECT ea.*
                FROM EVE_EVENTO_ASISTENTE ea
                WHERE ea.ID_EVENTO  = ? "  ;

    $query = $this->db->query( $sql, array($id_evento) );

    return $query->result_array();
}

public function alta_asistente_crm($id_crm_persona, $id_evento)
{
    $this->db->set('ID_ASISTENTE_EVENTO', "ID_ASISTENTE_EVENTO.nextval", false);

    $array_asistente['ID_CRM_PERSONA'] = utf8_decode($id_crm_persona);
    $array_asistente['ID_EVENTO'] = utf8_decode($id_evento);

    if( $this->db->insert('EVE_EVENTO_ASISTENTE',$array_asistente) )
        return TRUE;
    else
        return FALSE;


}

public function baja_asistente($array)
{

    $this->db->where('ID_ASISTENTE_EVENTO', $array['id_asistente_evento'] );

    if($this->db->delete('EVE_EVENTO_ASISTENTE'))
        return true;
    else
        return false;
}


}

/* End of file  */
/* Location: ./application/models/ */