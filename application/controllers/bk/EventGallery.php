<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class EventGallery extends CI_Controller {
	private $data;
	private $theme;
	public $elements;
	public $elements_data;
	
	public function __construct(){
		parent::__construct();
		
		
		$this->elements 					= array();
		$this->elements_data 				= array();
		$this->data 						= array();	
		$this->load->model(array('model_registration', 'model_submission','model_login','model_home'));		
		//$this->data['themePath'] 			= $this->config->item('theme');
		$this->data['home_banner']					= $this->model_home->getBanner();
		$this->layout->setLayout('front_layout');
	}
	public function index()
	{
		$this->data['eventCategory']				= $this->model_submission->eventGalleryCategoryList();
		//print_r($this->data['eventCategory']);exit;
        $this->layout->view('templates/dashboard/gallery',$this->data);
	}
	public function eventGalleryList($catId)
	{
		$event_gallery_info							= $this->model_submission->getEventGalleryList($catId);
		//print_r($event_gallery_info);exit;
		$this->data['event_gallery_info']			= $event_gallery_info;
		$this->data['cat_id']						= $catId;
		$this->layout->view('templates/dashboard/gallery_list',$this->data);
	}
}