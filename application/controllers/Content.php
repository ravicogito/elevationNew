<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Content extends CI_Controller {

	private $data;
	private $theme;
	public $elements;
	public $elements_data;
	
	 function __construct(){
		
		parent::__construct();
		$this->elements 							= array();
		$this->elements_data 						= array();
		$this->data 								= array();	

		$this->load->model(array('model_test','Model_home','Model_other'));
		$this->data['themePath'] 					= $this->config->item('theme');					
		$this->layout->setLayout('inner_layout');
	}
	
	public function page($page_id = "") {
		
		$questionlist						= array();
		
		$banner					= $this->Model_home->getBannerData($page_id);
		
		$page					= $this->model_test->getPageContent($page_id);
		//print_r($page);
		$this->data['contentTitle']			= $page['page_meta_title'];
		$this->data['contentKeywords']		= $page['page_meta_keywords'];	
		if($page_id == 'faq'){
			$questionlist				= $this->Model_home->getFaqData();
			$this->data['questionlist']			= $questionlist;
			
		}
		if($page_id == 'privacy-policy'){
			$questionlist			= $this->Model_home->getpolicyData();
			$this->data['questionlistpolicy']		= $questionlist;
		}
		
		$this->data['banner_info']		= $banner;
		$this->data['page_content']		= $page;
		
		$this->layout->view('templates/Content/pages',$this->data);
	}
	
	
}
?>	