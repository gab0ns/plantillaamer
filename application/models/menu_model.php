<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu_model extends CI_Model {
    function __construct(){
        parent::__construct();
        $this->load->database();
    }
    
    function insert($data){
        return ($this->db->insert('menu', $data)) ? $this->db->insert_id() : FALSE;   
    }
    
    function delete($id){
        $this->db->where('id', $id);
        return $this->db->delete('menu');
    }
    
    function edit($id,$data){
        $this->db->where('id', $id);
        return $this->db->update('menu', $data);
    }
    
    function get_all(){
        $this->db->select('*');
        $this->db->from('menu');
        $result = $this->db->get();
        return ($result->num_rows() > 0) ? $result->result_array() : FALSE;
    }
    
    function get($menu){
        $this->db->select('*');
        $this->db->from('menu');
        $this->db->where('id',$menu);
        $this->db->limit(1);
        $result = $this->db->get();
        return ($result->num_rows() > 0) ? $result->row_array() : FALSE;
    }
    
    function get_submenus($menu){
        $this->db->select('*');
        $this->db->from('submenu');
        $this->db->where('menu_id',$menu);
        $result = $this->db->get();
        return ($result->num_rows() > 0) ? $result->result_array() : FALSE;
    }
}