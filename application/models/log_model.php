<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Log_model extends CI_Model {
    function construct(){
        $this->load->database();
    }
    
    function insert($data){
        return ($this->db->insert('log', $data)) ? $this->db->insert_id() : FALSE;   
    }
    
    function delete($id){
        $this->db->where('id', $id);
        return $this->db->delete('log');
    }
    
    function edit($id,$data){
        $this->db->where('id', $id);
        return $this->db->update('log', $data);
    }
}