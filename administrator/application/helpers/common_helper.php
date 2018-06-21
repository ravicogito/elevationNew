<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		Sunav Chaudhury
 * @copyright	Copyright (c) 2008, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Download Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/download_helper.html
 */

// ------------------------------------------------------------------------

/**
 * Custom Force Download
 *
 * Based on the CodeIgniter Force Download function
 * This works also for XLSx, DOCx, Windows-ZIP and
 * other binary files
 *
 * Generates headers that force a download to happen
 *
 * @access	public
 * @param	string	filename
 * @param	mixed	the data to be downloaded
 * @return	void
 */
if ( ! function_exists('pr')) {
    function pr($arr,$e=1) {
        if(is_array($arr)) {
            echo "<pre>";
            print_r($arr);
            echo "</pre>";
        } else {
            echo "<br>Not an array...<br>";
            echo "<pre>";
            var_dump($arr);
            echo "</pre>";
        }
        if($e==1)
            exit();
        else
            echo "<br>";
    }
}


if( ! function_exists('sub_string')) {
    function sub_string($str='',$count=''){
        $len = strlen($str);
        if($len > $count){
            $sub_str = substr($str,0,$count)."...";
        }else{
            $sub_str = $str;
        }
        return stripslashes($sub_str);
    }
}

if( ! function_exists('sub_word')) {
    function sub_word($str, $limit) {
        $text = explode(' ', $str, $limit);
        if (count($text)>=$limit)  {
            array_pop($text);
            $text = implode(" ",$text).'...';
        } else {
            $text = implode(" ",$text);
        }
        $text = preg_replace('`\[[^\]]*\]`','',$text);
        return $text;
    }
}

/**
 * Thumb()
 * A TimThumb-style function to generate image thumbnails on the fly.
 *
 * @access public
 * @param string $fullname
 * @param int $width
 * @param int $height
 * @param string $image_thumb
 * @return String
 *
 */
    function thumb($fullname, $width, $height) {
    	
    	$CI = &get_instance();	
    	$userID = $CI->session->userdata('customer_id');
        // Path to image thumbnail in your root
        $dir = './uploads/customerImg_'.$userID."/";
        $url = base_url() . 'uploads/customerImg_'.$userID."/";
        // Get the CodeIgniter super object
       
        // get src file's extension and file name
        $extension = pathinfo($fullname, PATHINFO_EXTENSION);
        $filename = pathinfo($fullname, PATHINFO_FILENAME);
        $image_org = $dir . $filename . "." . $extension;
        $image_thumb = $dir . $filename . "-" . $height . '_' . $width . "." . $extension;
        $image_returned = $url . $filename . "-" . $height . '_' . $width . "." . $extension;

        if (!file_exists($image_thumb)) {
            // LOAD LIBRARY
            $CI->load->library('image_lib');
            // CONFIGURE IMAGE LIBRARY
            $config['source_image'] = $image_org;
            $config['new_image'] = $image_thumb;
            $config['width'] = $width;
            $config['height'] = $height;
            $CI->image_lib->initialize($config);
            $CI->image_lib->resize();
            $CI->image_lib->clear();
        }
        return $image_returned;
    }
	
	function thumbcreate($fullname, $fullPath = '', $width, $height) {
    	
    	$CI = &get_instance();	
		$front_Url = $CI->config->item('front_url');
    	$userID = $CI->session->userdata('customer_id');
        // Path to image thumbnail in your root
        //$dir = './uploads/customerImg_'.$userID."/";
        $dir =  '../uploads/'. $fullPath;
        //$url = base_url() . 'uploads/customerImg_'.$userID."/";
        $url = $front_Url. './uploads/'.$fullPath;
        // Get the CodeIgniter super object
       
        // get src file's extension and file name
        $extension = pathinfo($fullname, PATHINFO_EXTENSION);
        $filename = pathinfo($fullname, PATHINFO_FILENAME);
        $image_org = $dir . $filename . "." . $extension;
        $image_thumb = $dir . $filename . "-" . $height . '_' . $width . "." . $extension;
        $image_returned = $url . $filename . "-" . $height . '_' . $width . "." . $extension;

        if (!file_exists($image_thumb)) {
            // LOAD LIBRARY
            $CI->load->library('image_lib');
            // CONFIGURE IMAGE LIBRARY
            $config['source_image'] = $image_org;
            $config['new_image'] = $image_thumb;
            $config['width'] = $width;
            $config['height'] = $height;
            $CI->image_lib->initialize($config);
            $CI->image_lib->resize();
            $CI->image_lib->clear();
        }
        return $image_returned;
    }
    
    function cnt_cart() {
    	$CI = &get_instance();	
    	$userID = $CI->session->userdata('customer_id');
		$cntCart			= 0;
    	if(array_key_exists('cart', $_SESSION)) {
			if(array_key_exists('event', $_SESSION['cart'])) {
				foreach($_SESSION['cart']['event'] as $key => $eventArr) {
					foreach($eventArr as $j => $val) {
						if(is_numeric($j)) {
							$cntCart++;
						}
					}
				}
			}
			
			if(array_key_exists('ind', $_SESSION['cart'])) {
				foreach($_SESSION['cart']['ind'] as $keyInd => $indArr) {
					foreach($indArr as $k => $indval) {
						if(is_numeric($k)) {
							$cntCart++;
						}
					}
				}
			}
				
		} else {
			//
		}
		return $cntCart;
	}