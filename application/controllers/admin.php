<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
    public function index(){
        if (!$this->session->userdata('user')) {
            $this->load->view('include/header_admin_view',array('title' => 'Administración - Acceso'));
            $this->load->view('admin/admin_login_view');
            $this->load->view('include/footer_view');
        } else {
            $this->load->view('include/header_admin_view',array('title' => 'Administración'));
            $this->load->view('admin/admin_view');
            $this->load->view('include/footer_view');
        }
    }
    
    //logea al usuario
    public function login() {
        if (!$this->session->userdata('user')) {
            if ($this->validate_data()) {
                $user = $this->input->post('user');
                $pass = $this->input->post('pass');
                $this->load->model('usuario_model');
                $data_usuario = $this->usuario_model->check_user($user, md5($pass));
                if ($data_usuario) {
                    $this->session->set_userdata('user',$data_usuario);
                    $json_data = array('status' => 'OK', 'msg' => 'Inició sesión correctamente. Redirigiendo...');
                } else {
                    $json_data = array('status' => 'ERROR', 'msg' => 'Los datos ingresados son incorrectos.');
                }
            } else {
                $json_data = array('status' => 'ERROR', 'msg' => validation_errors());
            }
            echo json_encode($json_data);
        } else {
            redirect(base_url() . 'admin');
        }
    }

    //Cierra sesion
    public function logout() {
        $this->session->sess_destroy();
        redirect(base_url() . 'admin');
    }
    
    //Valida correo
    function validate_data() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('user', 'Usuario', 'required|trim|xss_clean');
        $this->form_validation->set_rules('pass', 'Contraseña', 'required|trim|xss_clean');
        return ($this->form_validation->run() == FALSE) ? false : true;
    }
    
    //lista de usuarios
    function list_users(){
        $this->load->model('usuario_model');
        $users = $this->usuario_model->get_all();
        if ($users){
            $this->load->view('include/header_admin_view',array('title' => 'Usuarios'));
            $this->load->view('admin/list_users_view',array('users' => $users));
            $this->load->view('include/footer_view');
        } else {
            show_error('No hay usuarios para mostrar.');
        }
    }
    
    function user(){
        $this->load->model('usuario_model');
        $user = $this->usuario_model->get($this->input->post('id'));
        if ($user){
            $json_data = array('status' => 'OK','msg' => $this->load->view('admin/edit_user_view',array('user' => $user),TRUE));
        } else 
            $json_data = array('status' => 'ERROR','msg' => 'No existe el usuario solicitado');
        echo json_encode($json_data);
    }
    
    function save_user(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nombre', 'Nombre', 'required|trim|xss_clean');
        $this->form_validation->set_rules('usuario', 'Usuario', 'required|trim|xss_clean');
        $this->form_validation->set_rules('password', 'Contraseña', 'matches[rpassword]|trim|xss_clean');
        $this->form_validation->set_rules('rpassword', 'Repetir Contraseña', 'trim|xss_clean');
        if($this->form_validation->run() != FALSE){
            $id = $this->input->post('id');
            $data['nombre'] = $this->input->post('nombre');
            $data['usuario'] = $this->input->post('usuario');
            if ($this->input->post('password'))
                $data['password'] = md5($this->input->post('password'));
            $this->load->model('usuario_model');
            if ($this->usuario_model->edit($id,$data)){
                $json_data = array('status' => 'OK','msg' => 'Se actualizó correctamente');
            } else {
                $json_data = array('status' => 'ERROR','msg' => 'No se ha podido actualizar');
            }
        } else {
            $json_data = array('status' => 'ERROR','msg' => validation_errors('<div>', '</div>'));
        }
        echo json_encode($json_data);
    }
    
    function insert_user(){
        echo json_encode(array('status' => 'OK','msg' => $this->load->view('admin/add_user_view','',TRUE)));
    }
    
    function add_user(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nombre', 'Nombre', 'required|trim|xss_clean');
        $this->form_validation->set_rules('usuario', 'Usuario', 'required|trim|xss_clean');
        $this->form_validation->set_rules('password', 'Contraseña', 'matches[rpassword]|required|trim|xss_clean');
        $this->form_validation->set_rules('rpassword', 'Repetir Contraseña', 'required|trim|xss_clean');
        if($this->form_validation->run() != FALSE){
            $data['nombre'] = $this->input->post('nombre');
            $data['usuario'] = $this->input->post('usuario');
            $data['password'] = md5($this->input->post('password'));
            $this->load->model('usuario_model');
            if ($this->usuario_model->insert($data)){
                $json_data = array('status' => 'OK','msg' => 'Se agregó correctamente');
            } else {
                $json_data = array('status' => 'ERROR','msg' => 'No se ha podido agregar');
            }
        } else {
            $json_data = array('status' => 'ERROR','msg' => validation_errors('<div>', '</div>'));
        }
        echo json_encode($json_data);
    }
    
    function delete_user(){
        $id = $this->input->post('id');
        $this->load->model('usuario_model');
        if ($this->usuario_model->delete($id)){
            $json_data = array('status' => 'OK','msg' => 'Se eliminó correctamente');
        } else {
            $json_data = array('status' => 'ERROR','msg' => 'No se ha podido eiminar');
        }
        echo json_encode($json_data);
    }
    
    /////////MENU//////////
    function new_menu(){
        echo json_encode(array('status' => 'OK','msg' => $this->load->view('admin/add_menu_view','',TRUE)));
    }
    
    function edit_menu(){
        $id = $this->input->post('id');
        $this->load->model('menu_model');
        $menus = $this->menu_model->get($id);
        if ($menus){
            $msg = $this->load->view('admin/edit_menu_view',array('menu' => $menus),TRUE);
            echo json_encode(array('status' => 'OK','msg' => $msg));
        } else {
            echo json_encode(array('status' => 'ERROR','msg' => 'El elemento es incorrecto.'));
        }
    }
    
    function delete_menu(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('id', '', 'integer|trim|required|xss_clean');
        if ($this->form_validation->run() != FALSE) {
            $this->load->model('menu_model');
            $id = $this->input->post('id');
            if($this->menu_model->delete($id)){
                $json_data = array('status' => 'OK','msg' => 'Se ha eliminado correctamente el elemento.');
            } else {
                $json_data = array('status' => 'ERROR','msg' => 'No se ha podido eliminado el elemento.');
            }
        } else {
            $json_data = array('status' => 'ERROR','msg' => validation_errors('<div>', '</div>'));
        }
        echo json_encode($json_data);
    }
    
    function update_menu(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('id', '', 'integer|trim|required|xss_clean');
        $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|xss_clean');
        $this->form_validation->set_rules('tipo', 'Tipo', 'is_natural|trim|required|xss_clean');
        if($this->input->post('tipo') == 1)
            $this->form_validation->set_rules('url', 'Url', 'prep_url|trim|xss_clean');
        else
            $this->form_validation->set_rules('url', 'Url', 'required|prep_url|trim|xss_clean');
        $this->form_validation->set_rules('color', 'Color', 'alpha|required|trim|xss_clean');
        if ($this->form_validation->run() != FALSE) {
            $id = $this->input->post('id');
            $data['nombre'] = $this->input->post('nombre');
            $data['tipo'] = $this->input->post('tipo');
            $data['url'] = ($this->input->post('url'))?$this->input->post('url'):'';
            $data['color'] = $this->input->post('color');
            $this->load->model('menu_model');
            if($this->menu_model->edit($id,$data)){
                $json_data = array('status' => 'OK','msg' => 'Se ha actualizado correctamente el elemento.');
            } else {
                $json_data = array('status' => 'ERROR','msg' => 'No se ha podido actualizar el elemento.');
            }
        } else {
            $json_data = array('status' => 'ERROR','msg' => validation_errors('<div>', '</div>'));
        }
        echo json_encode($json_data);
    }
    function save_menu(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|xss_clean');
        $this->form_validation->set_rules('tipo', 'Tipo', 'is_natural|trim|required|xss_clean');
        if($this->input->post('tipo') == 1)
            $this->form_validation->set_rules('url', 'Url', 'prep_url|trim|xss_clean');
        else
            $this->form_validation->set_rules('url', 'Url', 'required|prep_url|trim|xss_clean');
        $this->form_validation->set_rules('color', 'Color', 'alpha|required|trim|xss_clean');
        if ($this->form_validation->run() != FALSE) {
            $data['nombre'] = $this->input->post('nombre');
            $data['tipo'] = $this->input->post('tipo');
            $data['url'] = ($this->input->post('url'))?$this->input->post('url'):'';
            $data['color'] = $this->input->post('color');
            $this->load->model('menu_model');
            if($this->menu_model->insert($data)){
                $json_data = array('status' => 'OK','msg' => 'Se ha agregado correctamente el elemento.');
            } else {
                $json_data = array('status' => 'ERROR','msg' => 'No se ha podido agregar el elemento.');
            }
        } else {
            $json_data = array('status' => 'ERROR','msg' => validation_errors('<div>', '</div>'));
        }
        echo json_encode($json_data);
    }
    
    /////////SUBMENU//////////
    function new_submenu(){
        $data['menu'] = $this->input->post('menu_id');
        echo json_encode(array('status' => 'OK','msg' => $this->load->view('admin/add_submenu_view',$data,TRUE)));
    }
    
    function edit_submenu(){
        $id = $this->input->post('id');
        $this->load->model('submenu_model');
        $submenu = $this->submenu_model->get($id);
        if ($submenu){
            $data['submenu'] = $submenu;
            if($submenu['tipo'] == 1){
                $contenido = $this->submenu_model->get_content($id);
                if($contenido)
                    $data['submenu']['contenido'] = $contenido['contenido'];
            }
            $msg = $this->load->view('admin/edit_submenu_view',$data,TRUE);
            echo json_encode(array('status' => 'OK','msg' => $msg));
        } else {
            echo json_encode(array('status' => 'ERROR','msg' => 'El elemento es incorrecto.'));
        }
    }
    
    function delete_submenu(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('id', '', 'integer|trim|required|xss_clean');
        if ($this->form_validation->run() != FALSE) {
            $this->load->model('submenu_model');
            $id = $this->input->post('id');
            $this->submenu_model->delete_content($id);
            if($this->submenu_model->delete($id)){
                $json_data = array('status' => 'OK','msg' => 'Se ha eliminado correctamente el elemento.');
            } else {
                $json_data = array('status' => 'ERROR','msg' => 'No se ha podido eliminado el elemento.');
            }
        } else {
            $json_data = array('status' => 'ERROR','msg' => validation_errors('<div>', '</div>'));
        }
        echo json_encode($json_data);
    }
    
    function update_submenu(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('id', '', 'integer|trim|required|xss_clean');
        $this->form_validation->set_rules('menu_id', '', 'integer|trim|required|xss_clean');
        $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|xss_clean');
        $this->form_validation->set_rules('tipo', 'Tipo', 'is_natural|trim|required|xss_clean');
        if($this->input->post('tipo') == 1)
            $this->form_validation->set_rules('url', 'Url', 'prep_url|trim|xss_clean');
        else
            $this->form_validation->set_rules('url', 'Url', 'required|prep_url|trim|xss_clean');
        $this->form_validation->set_rules('contenido', 'Contenido', 'xss_clean');
        if ($this->form_validation->run() != FALSE) {
            $id = $this->input->post('id');
            $data['nombre'] = $this->input->post('nombre');
            $data['tipo'] = $this->input->post('tipo');
            $data['url'] = ($this->input->post('url'))?$this->input->post('url'):'';
            $this->load->model('submenu_model');
            if($this->submenu_model->edit($id,$data)){
                if($this->input->post('tipo') == 1){
                    $contenido = $this->submenu_model->get_content($id);
                    if ($contenido){
                        $dataC['nombre'] = $this->input->post('nombre');;
                        $dataC['contenido'] = $this->input->post('contenido');
                        if($this->submenu_model->edit_content($id,$dataC)){
                            $json_data = array('status' => 'OK','msg' => 'Se ha actualizado correctamente el elemento.');
                        }
                    } else {
                        $dataC['nombre'] = $this->input->post('nombre');;
                        $dataC['contenido'] = $this->input->post('contenido');
                        $dataC['submenu_id'] = $id;
                        if($this->submenu_model->add_content($dataC)){
                            $json_data = array('status' => 'OK','msg' => 'Se ha actualizado correctamente el elemento.');
                        }
                    }
                } else {
                    $json_data = array('status' => 'OK','msg' => 'Se ha actualizado correctamente el elemento.');
                }
            } else {
                $json_data = array('status' => 'ERROR','msg' => 'No se ha podido actualizar el elemento.');
            }
        } else {
            $json_data = array('status' => 'ERROR','msg' => validation_errors('<div>', '</div>'));
        }
        echo json_encode($json_data);
    }
    function save_submenu(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('menu_id', 'Menu', 'integer|trim|required|xss_clean');
        $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|xss_clean');
        $this->form_validation->set_rules('tipo', 'Tipo', 'is_natural|trim|required|xss_clean');
        if($this->input->post('tipo') == 1){
            $this->form_validation->set_rules('url', 'Url', 'prep_url|trim|xss_clean');
        } else if($this->input->post('tipo') == 0){
            $this->form_validation->set_rules('url', 'Url', 'required|prep_url|trim|xss_clean');
        }
        $this->form_validation->set_rules('contenidoText', 'Contenido', 'xss_clean');
        if ($this->form_validation->run() != FALSE) {
            $dataUpload = $this->uploadDoc();
                if($dataUpload['status'] == 'OK'){
                $data['nombre'] = $this->input->post('nombre');
                $data['tipo'] = $this->input->post('tipo');
                $data['url'] = ($this->input->post('url'))?$this->input->post('url'):'';
                $data['menu_id'] = $this->input->post('menu_id');
                $this->load->model('submenu_model');
                $submenu_id = $this->submenu_model->insert($data);
                if($submenu_id){
                    if ($this->input->post('tipo') !== 0){
                        $dataC['nombre'] = $this->input->post('nombre');;
                        $dataC['contenido'] = $this->input->post('contenido');
                        $dataC['submenu_id'] = $submenu_id;
                        $content_id = $this->submenu_model->add_content($dataC);
                        if($content_id){
                            if($this->input->post('tipo') == 2){
                                if (rename("./docs/99999.pdf", "./docs/".$content_id.".pdf")){
                                    $json_data = array('status' => 'OK','msg' => 'Se ha agregado correctamente el elemento.');
                                } else {
                                    $json_data = array('status' => 'ERROR','msg' => 'No se ha podido agregar el elemento.');
                                }
                            } else {
                                $json_data = array('status' => 'OK','msg' => 'Se ha agregado correctamente el elemento.');
                            }
                        } else {
                            $json_data = array('status' => 'ERROR','msg' => 'No se pudo agregar el contenido en el elemento.');
                        }
                    } else {
                        $json_data = array('status' => 'OK','msg' => 'Se ha agregado correctamente el elemento.');
                    }

                } else {
                    $json_data = array('status' => 'ERROR','msg' => 'No se ha podido agregar el elemento.');
                }
            } else {
                $json_data = array('status' => 'ERROR','msg' => $dataUpload['msg']);
            }
        } else {
            $json_data = array('status' => 'ERROR','msg' => validation_errors('<div>', '</div>'));
        }
        echo json_encode($json_data);
    }
    
    public function uploadDoc(){
        if($this->input->post('tipo') == 2){
            $this->load->library('upload');
            $config = array(
                'upload_path' => './docs/',
                'overwrite' => true,
                'file_name' => '99999',
                'allowed_types' => 'pdf',
                'max_size' => '10000',
                'remove_spaces' => true
            );
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('doc')){
                return array('status' => 'ERROR','msg' => $this->upload->display_errors('<div>', '</div>'));
            } else {
                return array('status' => 'OK','msg' => $this->upload->data());
            }
        } else {
            return array('status' => 'OK','msg' => 'ok');
        }
            
    }
}