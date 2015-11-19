<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Principal extends CI_Controller {
    
    public function index(){
        //animacion intro
        $this->load->view('include/header_waiting_view',array('title' => 'Maestría en Sociedades Sustentables','color' => false));
        $this->load->view('principal/waiting_view');
        $this->load->view('include/footer_view');
    }
    
    public function menu(){
        if ($this->session->userdata('user')){
            $data['session'] = TRUE;
        }
        $data['title'] = 'Maestría en Sociedades Sustentables';
        $data['color'] = false;
        $this->load->view('include/header_menu_view',$data);
        $this->load->model('menu_model');
        $menus = $this->menu_model->get_all();
        if ($menus){
            $data['menus'] = $menus;
            $this->load->view('principal/menu_view',$data);
        } else {
            $this->load->view('principal/menu_view',$data);
        }
        //dividir en dos los menus, del 0 a 5 en el arbol los demás aparecen debajo.
        $this->load->view('include/footer_view');
    }
}