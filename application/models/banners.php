<?php

class banners extends Model
{
	
	public function add_banner($banner_name, $banner_status, $banner_url_protocol, $banner_url_link, $banner_img, $banner_position, $banner_date){
        
        $this->banner_name         = $banner_name;
        $this->banner_status       = $banner_status;
        $this->banner_url_protocol = $banner_url_protocol;
        $this->banner_url_link     = $banner_url_link;
        $this->banner_img          = $banner_img;
        $this->banner_position     = $banner_position;
        $this->banner_date         = $banner_date;
        
        $this->save();
    }
    
    public function edit_banner($banner_id, $banner_name, $banner_status, $banner_url_protocol, $banner_url_link, $banner_img, $banner_position, $banner_date){
        
        $banner = $this->find(array('conditions' => array('id=?', $banner_id)));
        
        $banner->banner_name         = $banner_name;
        $banner->banner_status       = $banner_status;
        $banner->banner_url_protocol = $banner_url_protocol;
        $banner->banner_url_link     = $banner_url_link;
        
        if($banner_img != "continue"){
            $banner->banner_img      = $banner_img;
        }
        
        $banner->banner_position     = $banner_position;
        $banner->banner_date         = $banner_date;
        
        $banner->save();
    }
    
    public function change_position_banner($banner_position_changed, $banner_position_changeable){
        $banner = $this->find(array('conditions' => array('banner_position=?', $banner_position_changeable)));
        $banner->banner_position = $banner_position_changed;
        $banner->save();
    }
    
    public function get_status_position_banner($banner_id){
        return $this->find(array('conditions' => array('id=?', $banner_id),
                                 'select'     => 'id, banner_status, banner_position'));
    }
    
    public function get_on_banners(){
        return $this->find('all',array('conditions' => array('banner_status=?', 'on')));
    }
    
    public function get_all_banners(){
        return $this->all();
    }
    
    public function count_banners(){
        return $this->count();
    }
    
    public function count_status_on(){
        return $this->count(array('conditions' => array('banner_status=?', 'on')));
    }
    
    public function banner_move_up($position){
        $current_position = $position;
        $new_position = $current_position - 1;
        
        $banner1 = $this->find(array('conditions' => array('banner_position=?', $current_position)));
        $banner2 = $this->find(array('conditions' => array('banner_position=?', $new_position)));
        $banner1->banner_position = $new_position;
        $banner2->banner_position = $current_position;
        $banner1->save();
        $banner2->save();
        
    }
    
    public function banner_move_down($position){
        $current_position = $position;
        $new_position = $current_position + 1;
        
        $banner1 = $this->find(array('conditions' => array('banner_position=?', $current_position)));
        $banner2 = $this->find(array('conditions' => array('banner_position=?', $new_position)));
        $banner1->banner_position = $new_position;
        $banner2->banner_position = $current_position;
        $banner1->save();
        $banner2->save();
    }
}