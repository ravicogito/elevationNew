<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Error extends CI_Controller {
	private $data;
	private $theme;
	public $elements;
	public $elements_data;
	
	public function __construct(){
		parent::__construct();
		$this->elements 					= array();
		$this->elements_data 				= array();
		$this->data 						= array();	
		
		$this->load->model(array('model_registration','model_submission'));		
		$this->data['themePath'] 			= $this->config->item('theme');
	}	
	
	public function index() {		    
		// SEO WORK
		$this->data['contentTitle']					= 'The Bengal Association, Chennai';
		$this->data['contentKeywords']				= '';
		$this->data['contentDescription']			= 'Durgapuja.';
		// END SEO WORK		
		
		$this->data['frmaction']					= base_url()."registration/chk_user/";
		$this->data['errmsg']						= $this->session->userdata('errmsg');
		$this->data['succmsg']						= $this->session->userdata('succmsg');
		
		$this->session->set_userdata("errmsg", "");
		$this->session->set_userdata("succmsg", "");
		
		$this->elements['contentHtml']           	= $this->data['themePath'].'content/error';	
		$this->elements_data['contentHtml']      	= $this->data;		
		
        $this->templatelayout->setLayout($this->data['themePath'].'templatesInner');
        $this->templateView();
	}
	
	
	
	private function templateView(){		
		$this->templatelayout->seo();
		$this->templatelayout->header_inner();
		$this->templatelayout->footer();
		$this->templatelayout->multiple_view($this->elements,$this->elements_data);
	}	
	
}

/* End of file 404.php */
/* Location: ./application/controllers/404.php */