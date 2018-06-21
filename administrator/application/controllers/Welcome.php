<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	 
	private $data;
	private $theme;
	public $elements;
	public $elements_data;
	
	 function __construct(){
		
		parent::__construct();
		
		$this->elements 							= array();
		$this->elements_data 						= array();
		$this->data 								= array();	
        
		$this->load->helper('download');	

	}
	
	
	public function index()
	{
		$this->load->view('welcome_message');
	}
	
	public function download($customer_id,$fileName) {   
	   if ($fileName) {
		$file = "uploads/customerImg_".$customer_id."/org/". $fileName;
		// check file exists 
		
		if (file_exists ( $file )) {
			$imgArr 		= explode(".",$fileName);
			$extension 		= end($imgArr);
			$dwnFile		= "download.".$extension;	
		 // get file content
		 $data = file_get_contents ( $file );
		 //echo $data; exit;
		 //force download
		 force_download ( $dwnFile, $data );
		} else {
		 // Redirect to base url
		 redirect ( base_url () );
		}
	}
	}
}
