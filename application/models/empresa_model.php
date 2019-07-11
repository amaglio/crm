<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Empresa_model extends CI_Model {


    public function __construct()
    {
      
    	parent::__construct();
    }

    public function existe_empresa_crm($id_empresa)
    {
        chrome_log("Escuela_negocio_model/existe_empresa_crm");

        $sql =  "   SELECT  *
                    FROM    EMPRESAS E
                    WHERE   E.N_ID_EMPRESA = ? "  ;

        $query = $this->db->query($sql, array($id_empresa));

        if($query->num_rows() > 0)
            return false;
        else
            return true;
    }
    
    public function get_datos_empresa($id_empresa)
    {
        //
        $sql =  "   SELECT  e.*
                    FROM empresas e
                    WHERE   e.N_ID_EMPRESA = ? "  ;

        $query = $this->db->query( $sql, array ($id_empresa) );

        return $query->row_array();
    }

    public function get_datos_camara($id_camara)
    {
        //
        $sql =  "   SELECT  *
                    FROM CRM_CAMARA_ASOCIACION 
                    WHERE  id_camara = ? "  ;

        $query = $this->db->query( $sql, array($id_camara) );

        return $query->row_array();
    }

     public function get_referentes_empresa($id_empresa)
    {
        $sql =  "   SELECT *
                    FROM CRM_REFERENTE_EMPRESA re 
                         INNER JOIN CRM_PERSONA p ON re.id_crm_persona = p.id_crm_persona
                    WHERE re.id_empresa = ? "  ;

        $query = $this->db->query( $sql, array($id_empresa) );

        return $query->result_array();
    }

    /*
    public function get_referentes_empresa($id_empresa)
    {
        $sql =  "  SELECT cp.*
                    FROM crm_persona_empresa pe
                         INNER JOIN crm_referente_empresa re ON pe.id_crm_persona = re.id_crm_persona
                         INNER JOIN crm_persona cp ON pe.id_crm_persona = cp.id_crm_persona
                    WHERE pe.id_empresa = ? "  ;

        $query = $this->db->query( $sql, array($id_empresa) );

        return $query->result_array();
    }*/

     public function get_referentes_camara($id_camara)
    {
        $sql =  "  SELECT cp.*
                    FROM crm_persona_empresa pe
                         INNER JOIN crm_referente_empresa re ON pe.id_crm_persona = re.id_crm_persona
                         INNER JOIN crm_persona cp ON pe.id_crm_persona = cp.id_crm_persona
                    WHERE pe.id_empresa = ? "  ;

        $query = $this->db->query( $sql, array($id_camara) );

        return $query->result_array();
    }




    public function get_empresas()
    {
        $sql =  "   SELECT D_EMPRESA, N_ID_EMPRESA
                    FROM EMPRESAS E 
                    WHERE c_rubro != 'Actividades Independientes' "  ;

        $query = $this->db->query( $sql );

        return $query->result_array();
    }

    public function get_empresas_filtradas($start, $columna_orden, $cantidad, $sentido_orden, $texto_buscar)
    {   
        $cadena = '';

        if(isset($texto_buscar)):
            
            $texto_buscar = strtoupper($texto_buscar);
            $texto_buscar = str_replace(" ", "%", $texto_buscar);
            $texto_buscar = str_replace("ñ", "Ñ", $texto_buscar);

            $cadena .= "    TRANSLATE(upper(D_EMPRESA),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE '%$texto_buscar%' ";

        else:

            $cadena = 1;

        endif;

        $sql =  "   SELECT * 
                    FROM   EMPRESAS
                    WHERE $cadena
                    ORDER BY d_empresa $sentido_orden
                    OFFSET $start ROWS FETCH NEXT $cantidad ROWS ONLY "  ;

        $query = $this->db->query( $sql );

        return $query->result_array();
    }

    
    public function get_camaras_filtradas($start, $columna_orden, $cantidad, $sentido_orden, $texto_buscar)
    {   
        $cadena = '';

        if(isset($texto_buscar)):
            
            $texto_buscar = strtoupper($texto_buscar);
            $texto_buscar = str_replace(" ", "%", $texto_buscar);
            $texto_buscar = str_replace("ñ", "Ñ", $texto_buscar);

            $cadena .= "    TRANSLATE(upper(NOMBRE),'ÁÉÍÓÚÀÈÌÒÙÄËÏÖÜÂÊÎÔÛÑñ','AEIOUAEIOUAEIOUAEIOUÑÑ') LIKE '%$texto_buscar%' ";

        else:

            $cadena = 1;

        endif;

        $sql =  "   SELECT * 
                    FROM   CRM_CAMARA_ASOCIACION
                    WHERE $cadena
                    ORDER BY NOMBRE $sentido_orden
                    OFFSET $start ROWS FETCH NEXT $cantidad ROWS ONLY "  ;

        chrome_log($sql);

        $query = $this->db->query( $sql );

        return $query->result_array();
    }



    public function get_empleados_empresa($id_empresa)
    {
        $sql =  "   SELECT p.apellido,
                           p.nombre, 
                           p.id_crm_persona as id,
                           'crm' as origen
                    FROM Crm_Persona_empresa pe
                         inner join crm_persona p on pe.id_crm_persona = p.id_crm_persona
                    where  id_empresa = ?
                    and id_persona IS NULL

                    union
 
                    SELECT p.d_apellidos as apellido,
                           p.d_nombres as nombre,
                           p.n_id_persona as id,
                           'sigeu' as origen
                    FROM  cemap.ocupaciones o
                          inner join personas p ON o.n_id_persona = p.n_id_persona
                          left join crm_persona cp ON cp.id_persona = p.n_id_persona
                    where  n_id_empresa = ? "  ; 

        $query = $this->db->query( $sql, array($id_empresa, $id_empresa) );

        return $query->result_array();
    }
 
    public function get_acciones_empresa($id_empresa)
    {
        $sql =  "   SELECT ea.*, TO_CHAR(ea.FECHA, 'YYYY-MM-DD') as fecha_accion, cp.NOMBRE, cp.APELLIDO, ear.descripcion as descripcion_resultado, ear.fecha as fecha_resultado 
                    FROM  CRM_ACCION ea
                          LEFT JOIN crm_persona cp ON cp.id_crm_persona = ea.id_crm_persona
                          LEFT JOIN CRM_ACCION_RESULTADO ear ON ea.id_crm_accion = ear.id_crm_accion
                    WHERE ea.id_empresa = ? 
                    ORDER BY ea.fecha desc"  ;

        $query = $this->db->query( $sql, array($id_empresa) );

        return $query->result_array();
    }

    public function get_alarmas_empresa($id_empresa)
    {
        $sql =  "   SELECT ea.*, TO_CHAR(ea.FECHA, 'YYYY-MM-DD') as fecha_accion, p.NOMBRE, p.APELLIDO 
                    FROM CRM_ACCION ea
                         LEFT JOIN CRM_PERSONA p ON ea.ID_CRM_PERSONA = p.ID_CRM_PERSONA
                         LEFT JOIN CRM_ACCION_RESULTADO ear ON ea.id_crm_accion = ear.id_crm_accion
                    WHERE
                         ea.alarma = 1 
                    AND  ea.id_empresa = ? 
                    AND  ear.fecha IS NULL"  ;

         $query = $this->db->query( $sql, array($id_empresa) );

        return $query->result_array();
    }


    public function get_acuerdo_empresa($id_empresa)
    {
        //
        $sql =  "   SELECT  ea.*
                    FROM CRM_ACUERDO ea
                    WHERE   ea.ID_EMPRESA = ? "  ;

        $query = $this->db->query( $sql, array($id_empresa) );

        return $query->row_array();
    }

    public function abm_acuerdo_empresa($accion, $array)
    {
        switch ($accion):

            case 'A':

                    $this->db->set('ID_CRM_EMPRESA_ACUERDO', "ID_CRM_EMPRESA_ACUERDO.nextval", false);
            
                    
                    $array_acuerdo['DESCRIPCION'] = $array['descripcion'] ;
                    $array_acuerdo['ID_EMPRESA'] = $array['id_empresa'] ;
                    $array_acuerdo['VIGENTE'] = $array['vigente'] ;
                    
                    $resultado = $this->db->insert('CRM_ACUERDO',$array_acuerdo);

                    return  $resultado;

                break;

            case 'M':

                    $array_where = array(  'id_crm_empresa_acuerdo' => $array['id_crm_empresa_acuerdo'] );

 

                    $array_acuerdo['DESCRIPCION'] = $array['descripcion'];

                    if( $array['vigente'] == 1  ):

                        $array_acuerdo['VIGENTE'] = 1;

                    else:

                         $array_acuerdo['VIGENTE'] = 0;

                    endif;

                    $this->db->where($array_where);
                    $this->db->update('CRM_ACUERDO', $array_acuerdo);

                    return $this->db->affected_rows();

                break;

            case 'B':

                    $array_where = array(  'ID_CRM_EMPRESA_ACUERDO' => $array['id_crm_empresa_acuerdo'] );
 
                    $this->db->delete('CRM_ACUERDO', $array_where);

                    return $this->db->affected_rows();
                
                break;

        endswitch;


        return $this->db->affected_rows();
    }

    public function existe_camara_crm($id_camara)
    {
        chrome_log("Escuela_negocio_model/existe_camara_crm");

        $sql =  "   SELECT  *
                    FROM    CRM_CAMARA_ASOCIACION
                    WHERE   ID_CAMARA = ? "  ;

        $query = $this->db->query($sql, array($id_camara));

        if($query->num_rows() > 0)
            return false;
        else
            return true;
    }


}

/* End of file  */
/* Location: ./application/models/ */