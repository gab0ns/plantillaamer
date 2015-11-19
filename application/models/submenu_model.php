<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Submenu_model extends CI_Model {
    function __construct(){
        parent::__construct();
        $this->load->database();
    }
    
    function insert($data){
        return ($this->db->insert('submenu', $data)) ? $this->db->insert_id() : FALSE;   
    }
    
    function delete($id){
        $this->db->where('id', $id);
        return $this->db->delete('submenu');
    }
    
    function edit($id,$data){
        $this->db->where('id', $id);
        return $this->db->update('submenu', $data);
    }
    
    function get_all(){
        $this->db->select('*');
        $this->db->from('submenu');
        $result = $this->db->get();
        return ($result->num_rows() > 0) ? $result->result_array() : FALSE;
    }
    
    function get($id){
        $this->db->select('*');
        $this->db->from('submenu');
        $this->db->where('id',$id);
        $this->db->limit(1);
        $result = $this->db->get();
        return ($result->num_rows() > 0) ? $result->row_array() : FALSE;
    }
    
    function get_content($id){
        $this->db->select('*');
        $this->db->from('contenido');
        $this->db->where('submenu_id',$id);
        $this->db->limit(1);
        $result = $this->db->get();
        return ($result->num_rows() > 0) ? $result->row_array() : FALSE;
    }
    
    function edit_content($id,$data){
        $this->db->where('submenu_id', $id);
        return $this->db->update('contenido', $data);
    }
    
    function delete_content($id){
        $this->db->where('submenu_id', $id);
        return $this->db->delete('contenido');
    }
    
    function add_content($data){
        return ($this->db->insert('contenido', $data)) ? $this->db->insert_id() : FALSE;   
    }
}