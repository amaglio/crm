<?php
if (!defined( 'BASEPATH')) exit('No direct script access allowed');

class Chequear extends CI_Controller
{

	public function check_login()
	{
		$CI =& get_instance();

		!$CI->load->library('session') ? $CI->load->library('session') : false;
		!$CI->load->helper('url') ? $CI->load->helper('url') : false;

        if($CI->session->userdata('usuario_crm') == false && $CI->uri->segment(1) != 'login' )
        {
        	redirect(base_url('index.php/login'));
        }

	}

	public function check_permisos()
	{	
 		$CI =& get_instance(); 


		if( $CI->uri->segment(1) != 'home' && $CI->uri->segment(1) != 'login'):

			!$CI->load->library('session') ? $CI->load->library('session') : false;
			!$CI->load->helper('url') ? $CI->load->helper('url') : false; 
			$CI->db = $CI->load->database($CI->session->userdata('DB'),TRUE, TRUE);
			
			//$id_controlador =  $CI->Login_model->tiene_permiso($CI->uri->segment(1));
						

			if(!$CI->Login_model->tiene_permiso($CI->uri->segment(1))):

				redirect(base_url('index.php/home'));

			endif; 

		endif; 		
		 
	}

}
/*
/end hooks/home.php
*/