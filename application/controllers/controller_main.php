<?php

class controller_main extends Controller
{
	function __construct()
	{
		$this->view = new View();
        $this->model['banners'] = new banners();
        $this->template = "default.php";
	}

	function action_index()
	{	
        $get_banners = $this->model['banners']->get_on_banners();
        $array_banners = array();
        foreach($get_banners as $banner){
                list($banner_img_width, $banner_img_height) = getimagesize($banner->banner_img);
            
                $array_banners[] = array('banner_name'         => $banner->banner_name,
                                         'banner_url_protocol' => $banner->banner_url_protocol,
                                         'banner_url_link'     => $banner->banner_url_link,
                                         'banner_img'          => $banner->banner_img,
                                         'banner_img_width'    => $banner_img_width,
                                         'banner_img_height'   => $banner_img_height,
                                         'banner_position'     => $banner->banner_position);
        }
        usort($array_banners, function($a,$b){
            return ($a['banner_position']-$b['banner_position']);
        });
        $data = array('banners' => $array_banners);
		
		$this->view->generate('main_view.php', $this->template, $data);
	}
}