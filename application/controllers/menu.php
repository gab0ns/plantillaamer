<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends CI_Controller {
    
    public function id(){
        $menu_id = $this->input->post('id');
        $this->load->model('menu_model');
        $menu = $this->menu_model->get($menu_id);
        if ($menu){
            if ($this->session->userdata('user')){
                $data['session'] = TRUE;
            }
            $data['submenus'] = $this->menu_model->get_submenus($menu_id);
            $data['menu'] = $menu_id;
            $json_data = array('status' => 'OK','msg' => $this->load->view('submenu/submenu_view',$data,TRUE));
        } else {
            $json_data = array('status' => 'ERROR','msg' => 'La página solicitada no existe.');
        }
        echo json_encode($json_data);
    }
    
    public function contenido(){
        $submenu_id = $this->input->post('id');
        $this->load->model('submenu_model');
        $submenu = $this->submenu_model->get($submenu_id);
        if ($submenu){
            if ($this->session->userdata('user')){
                $data['session'] = TRUE;
            }
            $content = $this->submenu_model->get_content($submenu_id);
            $data['content'] = $content;
            echo json_encode(array('status' => 'OK','msg' => $this->load->view('submenu/content_view',$data,TRUE)));
        } else {
            echo json_encode(array('status' => 'ERROR','msg' => 'La página solicitada no existe.'));
        }
    }
    
    public function contenidoid(){
        $submenu_id = $this->input->post('id');
        $this->load->model('submenu_model');
        $submenu = $this->submenu_model->get($submenu_id);
        if ($submenu){
            if ($this->session->userdata('user')){
                $data['session'] = TRUE;
            }
            $content = $this->submenu_model->get_content($submenu_id);
            echo json_encode(array('status' => 'OK','msg' => $content));
        } else {
            echo json_encode(array('status' => 'ERROR','msg' => 'La página solicitada no existe.'));
        }
    }
}