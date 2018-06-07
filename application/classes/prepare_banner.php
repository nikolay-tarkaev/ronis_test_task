<?php

/**
 * @Note Панель администратора
 */

    class prepare_banner{
        
        public $tmp_directory;
        public $url_banner_directory;
        public $banner_directory;
        public $banner_name;
        public $banner_url;
        public $banner_status;
        public $banner_file;
        
        public function __construct($name, $url, $status, $file){
            $this->banner_name = $name;
            $this->banner_url = $url;
            $this->banner_status = $status;
            $this->banner_file = $file;
            
            $this->tmp_directory = "../tmp/";
            $this->url_banner_directory = "images/banners/";
            $this->banner_directory = "../web/" . $this->url_banner_directory;
        }
        
		public function is_entered_banner_data($mode){
            $types = array('image/gif', 'image/png', 'image/jpeg');
            
            if(empty($this->banner_name)){
                return array("error" => "1", "info" => "Введите название");
                exit;
            }
            if(empty($this->banner_url)){
                return array("error" => "1", "info" => "Введите URL");
                exit;
            }
            elseif(!preg_match("/(https?:\/\/)?(www\.)?([-а-яa-zёЁцушщхъфырэчстью0-9_\.]{2,}\.)(рф|[a-z]{2,6})((\/[-а-яёЁцушщхъфырэчстьюa-z0-9_]{1,})?\/?([a-z0-9_-]{2,}\.[a-z]{2,6})?(\?[a-z0-9_]{2,}=[-0-9]{1,})?((\&[a-z0-9_]{2,}=[-0-9]{1,}){1,})?)/i", $this->banner_url)){
                return array("error" => "1", "info" => "Некорректный URL");
                exit;
            }
            if(empty($this->banner_status)){
                return array("error" => "1", "info" => "Выберите статус");
                exit;
            }
            elseif($this->banner_status == "off" or $this->banner_status == "on"){
            }
            else {
                return array("error" => "1", "info" => "Выберите статус");
                exit;
            }
            if($mode == "new"){
                if(empty($this->banner_file['tmp_name'])){
                    return array("error" => "1", "info" => "Выберите файл");
                    exit;
                }
                if(!in_array($this->banner_file['type'], $types)){
                    return array("error" => "1", "info" => "Недопустимый формат файла");
                    exit;
                }
            }
            elseif($mode == "edit" and !empty($this->banner_file['tmp_name'])){
                if(!in_array($this->banner_file['type'], $types)){
                    return array("error" => "1", "info" => "Недопустимый формат файла");
                    exit;
                }
            }
            
            return array("error" => "0");
            
        }
        
        public function move_to_tmp_banner_img(){
            
            $result = array("error"      => "",
                            "info"       => "Success",
                            "width"      => "",
                            "height"     => "",
                            "new_name"   => "",
                            "extension"  => "",
                            "new_tmp"    => "");
            
            $current_tmp = $this->banner_file['tmp_name'];
            $explode_name = explode(".", $this->banner_file['name']);
            $result['extension'] = $explode_name[count($explode_name)-1];
            $result['new_name'] = time() . "_" . rand(000000000, 999999999) . "." . $result['extension'];
            $result['new_tmp'] = $this->tmp_directory . $result['new_name'];
            
            if(!move_uploaded_file($current_tmp, $result['new_tmp'])){
                $result['error'] = "1";
                $result['info'] = "Error move_uploaded_file";
                return $result;
                exit;
            }
            
            if(!$get_size = $this->get_size_banner_img($result['new_tmp'])){
                $result['error'] = "1";
                $result['info'] = "Error getimagesize";
                return $result;
                exit;
            }
            else {
                $result['width'] = $get_size['width'];
                $result['height'] = $get_size['height'];
            }
            
            $result['error'] = "0";
            return $result;
        }
        
        public function get_size_banner_img($img_url){
            list($result['width'], $result['height']) = getimagesize($img_url);
            return $result;
        }
        
        public function move_to_banners_directory($img_name){
            if(file_exists($this->banner_directory . $img_name)){
                return array("error" => "1",
                             "info"  => "File exists");
            }
            else {
                rename($this->tmp_directory.$img_name, $this->banner_directory.$img_name);
                if(file_exists($this->banner_directory . $img_name)){
                    return array("error" => "0",
                                 "info"  => "move_to_banners_directory success");
                }
                else {
                    return array("error" => "1",
                                 "info"  => "move_to_banners_directory error");
                }
            }
        }
    }

?>