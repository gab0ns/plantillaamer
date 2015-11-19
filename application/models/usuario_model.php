<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario_model extends CI_Model {
    function __construct(){
        parent::__construct();
        $this->load->database();
    }
    
    function insert($data){
        return ($this->db->insert('usuario', $data)) ? $this->db->insert_id() : FALSE;   
    }
    
    function delete($id){
        $this->db->where('id', $id);
        return $this->db->delete('usuario');
    }
    
    function edit($id,$data){
        $this->db->where('id', $id);
        return $this->db->update('usuario', $data);
    }
    
    function get($id){
        $this->db->select('*');
        $this->db->from('usuario');
        $this->db->where('id', $id);
        $this->db->limit(1);
        $result = $this->db->get();
        return ($result->num_rows() > 0) ? $result->row_array() : FALSE;
    }
    function check_user($user,$pass){
        $this->db->select('*');
        $this->db->from('usuario');
        $this->db->where('usuario', $user);
        $this->db->where('password', $pass);
        $this->db->limit(1);
        $result = $this->db->get();
        return ($result->num_rows() > 0) ? $result->row_array() : FALSE;
    }
    
    function get_all(){
        $this->db->select('*');
        $this->db->from('usuario');
        $result = $this->db->get();
        return ($result->num_rows() > 0) ? $result->result_array() : FALSE;
    }
}