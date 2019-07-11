<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ubicacion_model extends CI_Model {


	public function __construct()
	{

		parent::__construct();
	}


	public function abm_zonas($post, $accion)
	{
		if($accion == 'alta ';
			$sql =	"	INSERT "  ;

		if($accion == 'baja ';
			$sql =	"	DELETE "  ;

		if($accion == 'modifica ';
			$sql =	"	UPDATE "  ;

		$query = $this->db->query( $sql , array($post) );

		return $query;

	}

	public function abm_localidades($post, $accion)
	{
		if($accion == 'alta ';
			$sql =	"	INSERT "  ;

		if($accion == 'baja ';
			$sql =	"	DELETE "  ;

		if($accion == 'modifica ';
			$sql =	"	UPDATE "  ;

		$query = $this->db->query( $sql , array($post) );

		return $query;

	}

	public function abm_barrios($post, $accion)
	{
		if($accion == 'alta ';
			$sql =	"	INSERT "  ;

		if($accion == 'baja ';
			$sql =	"	DELETE "  ;

		if($accion == 'modifica ';
			$sql =	"	UPDATE "  ;

		$query = $this->db->query( $sql , array($post) );

		return $query;

	}

}