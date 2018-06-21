<?php  
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Image
{
    public $obj;    

    function __construct() {
        $this->obj = &get_instance();
        $this->obj->load->library('image_lib');
    }   

    function imageUpload(&$config, &$noThumb=array(), $manipulation='') {
        $this->doUpload($config, $noThumb, $manipulation);
    }

    private function doUpload(&$config, &$noThumb=array(), $manipulation='') {
        $this->obj->load->library('upload');
        
		if( ! is_dir($config['upload_path_dis'])) {
            mkdir($config['upload_path_dis'],DIR_READ_MODE);
        }
		if( ! is_dir($config['upload_path'])) {
            mkdir($config['upload_path'],DIR_READ_MODE);
        }        
        $config['upload_path'] = $config['upload_path'];
        $config['encrypt_name'] = TRUE;
        $this->obj->upload->initialize($config);
        $this->obj->upload->do_upload($config['input_name'],true);
		//pr($this->obj->upload->data(),0);
        if($this->obj->upload->display_errors() != "") {
            $config['img_err'] = $this->obj->upload->display_errors();
        } else {
			
			$imageData				= $this->obj->upload->data();
            $config['imageName'] 	= $this->obj->upload->file_name;
			$config['imageRawName'] = $imageData['raw_name'];
            $config['imageType'] 	= $imageData['file_ext'];
			
			$disPath				= $config['upload_path'].$config['imageName'];
			$waterMarkImgPath		= $config['upload_path_dis'].$config['imageName'];
			/*copy($disPath, $waterMarkImgPath);
			$this->imgWatermark($config);*/
			$this->createWaterMark($disPath,$waterMarkImgPath,strtolower($config['imageType']));
            if($manipulation == 'R') {
                if( ! count($noThumb) > 0) {
                    $noThumb[0]['width'] = 0;
                    $noThumb[0]['height'] = 0;
                }
                $this->resize($config,$noThumb);
            }
            if($manipulation == 'C') {
                $this->crop($config);
            }
        }
    }    
	
	private function createWaterMark($src, $fileName, $ext) {
		$stamp = imagecreatefrompng('./../uploads/overlay/img-w.png');
		if($ext == '.png') {
			$im = imagecreatefrompng($src);
		} else {
			$im = imagecreatefromjpeg($src);
		}
		
		$marge_right = 10;
		$marge_bottom = 10;
		$sx = imagesx($stamp);
		$sy = imagesy($stamp);

		// Copy the stamp image onto our photo using the margin offsets and the photo 
		// width to calculate positioning of the stamp. 
		imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));

		// Output and free memory
		/*header('Content-type: image/png');
		imagepng($im);*/
		//$filename = $new_name;
		imagepng($im, $fileName);
		imagedestroy($im);
		return true;
	}
	
    private function resize($config,&$noThumb) {
        
        if( ! is_dir($config['upload_path_dis']."thumb/")) {
            mkdir($config['upload_path_dis']."thumb/",DIR_READ_MODE);
        }
        $manipulationConfig 							= array(
															'image_library'     => 'gd2',
															'create_thumb'      => TRUE,
															'maintain_ratio'    => TRUE,
															'source_image'      =>$config['upload_path_dis'].$config['imageName'],
															'new_image'         => $config['upload_path_dis']."thumb/"
															);									
        for( $i=0; $i<count($noThumb); $i++ ) {
            $manipulationConfig['width']                = $noThumb[$i]['width'];
            $manipulationConfig['height']               = $noThumb[$i]['height'];
			$manipulationConfig['master_dim']			= 'height';
            $manipulationConfig['thumb_marker']         = "-".$noThumb[$i]['width']."X".$noThumb[$i]['height'];
            //pr($manipulationConfig,0);
            $this->obj->image_lib->initialize($manipulationConfig);
            if( ! $this->obj->image_lib->resize()) {
                $noThumb[$i]['err']         			= $this->obj->image_lib->display_errors();
                $noThumb[$i]['success']     			= FALSE;
                $noThumb[$i]['name']        			= '';
                $this->obj->image_lib->clear();
            } else {
                $noThumb[$i]['err']         			= '';
                $noThumb[$i]['success']     			= TRUE;
                $noThumb[$i]['name']        			= $config['imageName'];
            }
        }
    }

    private function crop($config,$manipulationConfig) {
        if( ! is_dir($config['upload_path']."crop/")) {
            mkdir($config['upload_path']."crop/",DIR_READ_MODE);
        }
        $manipulationConfig['source_image'] = $config['upload_path'].$config['imageName'];
        $manipulationConfig['new_image'] = $config['upload_path']."crop/";
        $this->obj->load->library('image_lib',$manipulationConfig);
        if( ! $this->obj->image_lib->crop()) {
            echo "hi - ".$this->obj->image_lib->display_errors(); exit;
        }
    }
	
	private function imgWatermark($config) {//
		//$this->obj->load->library('image_lib');
		$manipulationConfig						= array();
		$manipulationConfig['image_library'] 	= 'gd2';
		$manipulationConfig['source_image'] 	= $config['upload_path_dis'].$config['imageName'];
		$manipulationConfig['wm_text'] 			= 'Copyright 2018 - '.$config['photographer'];
		$manipulationConfig['wm_font_path'] 	= '../assets/fonts/Action_Force.ttf';
		$manipulationConfig['wm_type'] 			= 'text';
		$manipulationConfig['wm_font_size'] 	= '48';	
		$manipulationConfig['wm_font_color'] 	= '000000';
		
		/*$manipulationConfig['wm_type'] 			= 'overlay';
		$manipulationConfig['wm_overlay_path'] 	= './../uploads/overlay/img-w.png';*/
		
		$manipulationConfig['wm_vrt_alignment'] = 'M';
		$manipulationConfig['wm_hor_alignment'] = 'C';
		$manipulationConfig['wm_padding'] 		= '20';
		//$manipulationConfig['dynamic_output'] 		= TRUE;
		
		$this->obj->image_lib->initialize($manipulationConfig);
		
		$this->obj->image_lib->watermark();
		$this->obj->image_lib->clear();
		/*if($config['cnt'] >= 1) {
			echo "<pre>";
			print_r($manipulationConfig);
			exit;
		}*/
		/*if (!$this->obj->image_lib->watermark()) {
			echo $this->image_lib->display_errors();exit;
		} else {
			$watermark_img = "../".$config['upload_path_dis']. $config['imageName'];
			echo "<img src='".$watermark_img."'>";
		}exit;*/
	}
}
?>