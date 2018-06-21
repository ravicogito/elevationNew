<?php  
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Layout
{
    public $obj;
    public $layout;
	private $adminId;
	private $themeFolder = "theme-v-1/";
	private $themePath = '';
    
    function __construct($layout = "layout")
    {
        $this->obj =& get_instance();
        $this->layout = $layout;
		$this->themePath = base_url().$this->themeFolder;
	}

    function setLayout($layout)
    {
      $this->layout =$layout;
    }

    function view($view, $data=null, $return=false)
    {
		$loadedData = array();
        $loadedData['layout_content'] 		= $this->obj->load->view($view,$data,true);		
		$loadedData['layout_header'] 		= $this->getHeader();
		$loadedData['layout_footer'] 		= $this->getFooter();			
		$loadedData['innerlayout_header'] 	= $this->getInnerHeader();
		$loadedData['innerlayout_footer'] 	= $this->getInnerFooter();

		
		if($return)
        {
            $output = $this->obj->load->view($this->layout, $loadedData, true);
            return $output;
        }
        else
        {
            $this->obj->load->view($this->layout, $loadedData, false);
        }
    }
	
		

	private function commonData(){
		$data['themePath'] = $this->themePath ;
		return $data;
	}
	
	private function getHeader(){
		$data = $this->commonData();
		$retData = $this->obj->load->view('common/header',$data,true);

		return $retData;
	}			
	
    private function getFooter(){
		$data = $this->commonData();
		$retData = $this->obj->load->view('common/footer',$data,true);

		return $retData;
	}

	private function getInnerHeader(){
		$data = $this->commonData();
		$retData = $this->obj->load->view('common/inner_header',$data,true);

		return $retData;
	}
	
	private function getInnerFooter(){
		$data = $this->commonData();
		$retData = $this->obj->load->view('common/inner_footer',$data,true);

		return $retData;
	}	
}
?>