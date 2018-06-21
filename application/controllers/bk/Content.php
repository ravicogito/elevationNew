<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Content extends CI_Controller {
	private $data;
	private $theme;
	public $elements;
	public $elements_data;
	
	public function __construct(){
		parent::__construct();
		$this->elements 					= array();
		$this->elements_data 				= array();
		$this->data 						= array();	
		$this->load->model(array('model_content','model_home'));		
		$this->data['home_banner']					= $this->model_home->getBanner();
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


		//Counter

		$filePath =  getcwd().'/assets/counter.txt';
            $handle = fopen($filePath, "r");
            if(!$handle){
            	$this->data['counterData'] = 0;
            } 
            else { 
            	
            	$counter = (int) fread ($handle,20) ;
             	fclose ($handle) ;
             	
             	$counter++ ;
             	//echo " <span> ". $counter . " < /span > " ;
             	             	$this->data['counterData'] = $counter;
             	$handle = fopen($filePath, "w" ) ; 
             	fwrite($handle,$counter) ; 
             	fclose ($handle) ; 
           }


		
		$this->elements['contentHtml']           	= $this->data['themePath'].'content/content';	
		$this->elements_data['contentHtml']      	= $this->data;		
		
        $this->templatelayout->setLayout($this->data['themePath'].'templatesInner');
        $this->templateView();
	}
	
	public function pages($id = ''){
		
		$page			= $this->model_content->getPageContent($id);
		$this->data['page_title']		= $page['page_title'];
		$this->data['page_content']		= $page['page_description'];
		//$this->data['page_id']			= $page['page_id'];
		//pr($page['page_id']);

		//Counter

		$filePath =  getcwd().'/assets/counter.txt';
            $handle = fopen($filePath, "r");
            if(!$handle){
            	$this->data['counterData'] = 0;
            } 
            else { 
            	
            	$counter = (int) fread ($handle,20) ;
             	fclose ($handle) ;
             	
             	$counter++ ;
             	//echo " <span> ". $counter . " < /span > " ;
             	             	$this->data['counterData'] = $counter;
             	$handle = fopen($filePath, "w" ) ; 
             	fwrite($handle,$counter) ; 
             	fclose ($handle) ; 
           }

		if($page['page_id'] == 6)
		{
			$this->data['main_mid_cont']			= 'prvet';
			$this->data['inner_cont_extraclass']	= 'privacy';
		}
		
		$this->data['frmaction']					= base_url()."registration/chk_user/";
		$this->data['errmsg']						= $this->session->userdata('errmsg');
		$this->data['succmsg']						= $this->session->userdata('succmsg');
		
		$this->session->set_userdata("errmsg", "");
		$this->session->set_userdata("succmsg", "");
		
		$this->elements['contentHtml']           	= $this->data['themePath'].'content/pages';	
		$this->elements_data['contentHtml']      	= $this->data;		
		
		

        $this->templatelayout->setLayout($this->data['themePath'].'templatesInner');
        $this->templateView();
	}
	
	public function galleryPage($id){
		
		//$id = 15;
		$gallery_content			= $this->model_content->getGalleryContent($id);
		$gallery_image_content		= $this->model_content->getGalleryimageContent($id);
		
		$this->data['page_name']		    = $gallery_content['page_title'];
		$this->data['page_description']		= $gallery_content['page_description'];
		
		$this->data['image_contents']		= $gallery_image_content;
		
		$this->data['frmaction']					= base_url()."registration/chk_user/";
		$this->data['errmsg']						= $this->session->userdata('errmsg');
		$this->data['succmsg']						= $this->session->userdata('succmsg');
		
		$this->session->set_userdata("errmsg", "");
		$this->session->set_userdata("succmsg", "");
		
		$this->elements['contentHtml']           	= $this->data['themePath'].'content/gallery';	
		$this->elements_data['contentHtml']      	= $this->data;	


		//Counter

		$filePath =  getcwd().'/assets/counter.txt';
            $handle = fopen($filePath, "r");
            if(!$handle){
            	$this->data['counterData'] = 0;
            } 
            else { 
            	
            	$counter = (int) fread ($handle,20) ;
             	fclose ($handle) ;
             	
             	$counter++ ;
             	//echo " <span> ". $counter . " < /span > " ;
             	             	$this->data['counterData'] = $counter;
             	$handle = fopen($filePath, "w" ) ; 
             	fwrite($handle,$counter) ; 
             	fclose ($handle) ; 
           }	
		
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

/* End of file Registration.php */
/* Location: ./application/controllers/registration.php */