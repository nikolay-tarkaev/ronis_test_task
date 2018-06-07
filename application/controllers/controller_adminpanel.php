<?php

class controller_adminpanel extends Controller
{
	function __construct()
	{
		$this->view = new View();
		$this->model['banners'] = new banners();
        $this->template = "adminpanel_default.php";
	}

	function action_index()
	{	
        $this->is_admin();
        
		$this->view->generate('adminpanel_view.php', $this->template);
	}
	
	function action_banners()
	{	
        $this->is_admin();
        
        $count_banners = $this->model['banners']->count_banners();
        $count_status_on = $this->model['banners']->count_status_on();
        
        $get_all_banners = $this->model['banners']->get_all_banners($banners_limit, $banners_offset);
        $banners_on = array();
        $banners_off = array();
        foreach($get_all_banners as $banner){
            if($banner->banner_status == "on"){
                $banners_on[] = array('id'                  => $banner->id,
                                      'banner_name'         => $banner->banner_name,
                                      'banner_status'       => $banner->banner_status,
                                      'banner_url_protocol' => $banner->banner_url_protocol,
                                      'banner_url_link'     => $banner->banner_url_link,
                                      'banner_img'          => $banner->banner_img,
                                      'banner_position'     => $banner->banner_position);
            }
            else{
                $banners_off[] = array('id'                  => $banner->id,
                                       'banner_name'         => $banner->banner_name,
                                       'banner_status'       => $banner->banner_status,
                                       'banner_url_protocol' => $banner->banner_url_protocol,
                                       'banner_url_link'     => $banner->banner_url_link,
                                       'banner_img'          => $banner->banner_img,
                                       'banner_position'     => $banner->banner_position);
            }
        }
        usort($banners_on, function($a,$b){
            return ($a['banner_position']-$b['banner_position']);
        });
        usort($banners_off, function($a,$b){
            return ($a['id']-$b['id']);
        });
        $array_banners = array_merge($banners_on, $banners_off);
        
        $banners_limit = 15;
        $count_page = ceil($count_banners / $banners_limit);
        if(isset($_GET['page'])){
			$banners_page = htmlspecialchars(trim($_GET['page']));
			$banners_page = (int)$banners_page;
			if($banners_page > $count_page){
				$banners_page = $count_page;
			}
            elseif($banners_page < 1){
                $banners_page = 1;
            }
			$banners_offset = ($banners_page - 1) * $banners_limit;
		}
		else {
			$banners_offset = 0;
		}
        $pagination = new pagination($count_banners, $banners_limit, $banners_offset, "banners");
        
        $array_banners_output = array_slice($array_banners, $banners_offset, $banners_limit);
        
        $data = array('count_banners'    => $count_banners,
                      'count_status_on'  => $count_status_on,
                      'banners'          => $array_banners_output,
                      'pagination'       => $pagination);
        
		$this->view->generate('adminpanel_banners_view.php', $this->template, $data);
	}
	
	function action_ajax()
	{	
        $this->is_admin();
        
		if($_POST['modal_banner_mode'] == "new"){
            
            $this->banner_data($_POST['modal_banner_id'], $_POST['modal_banner_name'], $_POST['modal_banner_status'], $_POST['modal_banner_url_protocol'], $_POST['modal_banner_url_link'], $_FILES['modal_banner_file'], "new");
            
		}
        elseif($_POST['modal_banner_mode'] == "get"){
            
            
            $filtration = new filtration_input_data;
            
            $banner_id = $filtration->int_data($_POST['modal_banner_id']);
            $get_banner = $this->model['banners']->find(array('conditions' => array('id=?', $banner_id)));
            
            echo json_encode(array("banner_id"           => $get_banner->id,
                                   "banner_name"         => $get_banner->banner_name,
                                   "banner_status"       => $get_banner->banner_status,
                                   "banner_url_protocol" => $get_banner->banner_url_protocol,
                                   "banner_url_link"     => $get_banner->banner_url_link,
                                   "banner_img"          => $get_banner->banner_img,
                                   "banner_position"     => $get_banner->banner_position));
            
        }
        elseif($_POST['modal_banner_mode'] == "edit"){
            
            $this->banner_data($_POST['modal_banner_id'], $_POST['modal_banner_name'], $_POST['modal_banner_status'], $_POST['modal_banner_url_protocol'], $_POST['modal_banner_url_link'], $_FILES['modal_banner_file'], "edit", $_POST['modal_banner_file_current']);
            
        }
        elseif($_POST['modal_banner_mode'] == "delete"){
            
            $filtration = new filtration_input_data;
            
            $banner_id = $filtration->int_data($_POST['modal_banner_id']);
            $get_banner = $this->model['banners']->find(array('conditions' => array('id=?', $banner_id)));
            if(file_exists("../web/".$get_banner->banner_img)){
                unlink("../web/".$get_banner->banner_img);
            }
            $get_banner->delete();
            
            echo json_encode(array("error" => "0"));
            
        }
        elseif($_POST['button_banner_mode'] == "position"){
            
            $filtration = new filtration_input_data;
            
            $banner_position = $filtration->int_data($_POST['banner_position']);
            $banner_move = $filtration->str_data($_POST['banner_move']);
            $count_status_on = $this->model['banners']->count_status_on();
            
            if($banner_move == "up"){
                if($banner_position != 1 and $banner_position != 0){
                    $this->model['banners']->banner_move_up($banner_position);
                }
                else{
                    echo json_encode(array("error" => "1",
                                           "info"  => "Неизвестная ошибка"));
                    exit;
                }
            }
            elseif($banner_move == "down"){
                if($banner_position != $count_status_on  and $banner_position != 0){
                    $this->model['banners']->banner_move_down($banner_position);
                }
                else{
                    echo json_encode(array("error" => "1",
                                           "info"  => "Неизвестная ошибка"));
                    exit;
                }
            }
            else{
                echo json_encode(array("error" => "1",
                                       "info"  => "Неизвестная ошибка"));
                exit;
            }
            echo json_encode(array("error" => "0"));
        }
		else {
			Route::ErrorPage404();
		}
	}
    
    function banner_data($uploaded_id, $uploaded_name, $uploaded_status, $uploaded_url_protocol, $uploaded_url_link, $uploaded_file, $mode, $uploaded_file_current = "0")
    {
        
        $filtration = new filtration_input_data;
            
        $banner_id = $filtration->int_data($uploaded_id);
        $banner_name = $filtration->str_data($uploaded_name);
        $banner_status = $filtration->str_data($uploaded_status);
        $banner_url_protocol = $filtration->str_data($uploaded_url_protocol);
        $banner_url_link = $filtration->str_data($uploaded_url_link);
        $banner_url = $banner_url_protocol . "://" . $banner_url_link;
        $banner_file = $uploaded_file;
        $banner_file_current = $filtration->str_data($uploaded_file_current);
        $banner_position = 0;
        $banner_data = date("Y-m-d H:i:s");
            
        $prepare_banner = new prepare_banner($banner_name, $banner_url, $banner_status, $banner_file);
            
        $is_entered_banner_data = $prepare_banner->is_entered_banner_data($mode);
        if($is_entered_banner_data['error'] != "0"){
            echo json_encode(array("error" => "1",
                                   "info"  => $is_entered_banner_data['info']));
            exit;
        }
        
        if($mode == "edit" and empty($banner_file['tmp_name'])){
            $banner_img = "continue";
        }
        else {
               
            $move_to_tmp = $prepare_banner->move_to_tmp_banner_img();

            $file_name = $move_to_tmp['new_name'];
            $file_tmp = $move_to_tmp['new_tmp'];
            $file_extension = $move_to_tmp['extension'];
            $file_width = $move_to_tmp['width'];
            $file_height = $move_to_tmp['height'];

            if($move_to_tmp['error'] != "0"){
                unlink($file_tmp);
                echo json_encode(array("error" => "1",
                                       "info"  => "Неизвестная ошибка"));
                exit;
            }
            if($file_width < "300" and $file_height < "250"){
                unlink($file_tmp);
                echo json_encode(array("error" => "1",
                                       "info"  => "Изображение слишком маленькое"));
                exit;
            }
            elseif($file_width > "300" or $file_height > "250"){

                $w = $file_width / 6;
                $h = $w * 5;

                $resize_image = new resize_image;
                $resize_image->load($file_tmp);

                if($h < $file_height){
                    $resize_image->resize_to_height(250);
                }
                else {
                    $resize_image->resize_to_width(300);
                }

                $resize_image->save($file_tmp);

                $get_new_size = $prepare_banner->get_size_banner_img($file_tmp);
                if($get_new_size['width'] > "300" or $get_new_size['height'] > "250"){
                    unlink($file_tmp);
                    echo json_encode(array("error" => "1",
                                           "info"  => "Неизвестная ошибка"));
                    exit;
                }
            }

            $move_to_banners_directory = $prepare_banner->move_to_banners_directory($file_name);
            if($move_to_banners_directory['error'] != "0"){
                unlink($file_tmp);
                echo json_encode(array("error" => "1",
                                       "info"  => "Неизвестная ошибка"));
                exit;
            }
        }
        
        if($mode == "new"){
            if($banner_status == "on"){
                $banner_position = $this->model['banners']->count_status_on() + 1;
            }
            $e = $this->model['banners']->add_banner($banner_name, $banner_status, $banner_url_protocol, $banner_url_link, $prepare_banner->url_banner_directory.$file_name, $banner_position, $banner_data);
            echo json_encode(array("error" => "0",
                                   "info"  => "success"));
        }
        elseif($mode == "edit"){
            if($banner_img != "continue"){
                $banner_img = $prepare_banner->url_banner_directory.$file_name;
                
                if(file_exists("../web/".$banner_file_current)){
                    unlink("../web/".$banner_file_current);
                }
            }
            
            $banner_status_position_current = $this->model['banners']->get_status_position_banner($banner_id);
            $banner_status_current = $banner_status_position_current->banner_status;
            $banner_position_current = $banner_status_position_current->banner_position;
            $count_status_on = $this->model['banners']->count_status_on();
            
            if($banner_status_current == $banner_status){
                $banner_position = $banner_position_current;
            }
            elseif($banner_status_current == "off" and $banner_status == "on"){
                $banner_position = $count_status_on + 1;
            }
            
            $e = $this->model['banners']->edit_banner($banner_id, $banner_name, $banner_status, $banner_url_protocol, $banner_url_link, $banner_img, $banner_position, $banner_data);
            
            if($banner_status_current == "on" and $banner_status == "off"){
                $banner_position_changed = $banner_position_current;
                $banner_position_changeable = $banner_position_changed + 1;
                for($i = 1; $i = $count_status_on-$banner_position_changed; $i++){
                    $this->model['banners']->change_position_banner($banner_position_changed, $banner_position_changeable);
                    $banner_position_changed++;
                    $banner_position_changeable++;
                }
            }
            echo json_encode(array("error" => "0",
                                   "info"  => "success"));
        }
        else{
            echo json_encode(array("error" => "1",
                                   "info"  => "Неизвестная ошибка"));
            exit;
        }
    }
    
    function is_admin()
    {
        if(isset($_SESSION['auth'])){
            if($_SESSION['auth']['status'] != "admin"){
                Route::ErrorPage404();
            }
		}
        else{
            Route::ErrorPage404();
        }
    }
}