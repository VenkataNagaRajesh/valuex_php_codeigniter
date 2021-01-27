<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common_m extends CI_Model {

    function __construct() {
		parent::__construct();
    }
    
    function insert($table,$data){
        $this->db->insert($table,$data);
        return $this->db->insert_id();
    }

    function update($table,$data,$id){
        $this->db->where('id',$id);
        $this->db->update($table,$data);
        return $id;
    }

    function delete($table,$id){
        $this->db->where('id',$id);
        $this->db->delete($table);
        return $id;
    }

    function delete_where($table,$where){
        if($where){
            $this->db->where($where);
        }
        $this->db->delete($table);
        return $id;
    }

    function get_single($table,$id){
        $this->db->select('*')->from($table);
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row_array();
    }
    function get_single_where($table,$where=array()){
        $this->db->select('*')->from($table);
        if($where){
            $this->db->where($where);
        }
        $query = $this->db->get();
        return $query->row_array();
    }

    function get_multi($table){
        $this->db->select('*')->from($table);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_multi_where($table,$where=array()){
        $this->db->select('*')->from($table);
        if($where){
            $this->db->where($where);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    function tot_count($table,$where=array()){
        if($where){
            $this->db->where($where);
        }
        return $this->db->count_all_results($table);
    }
}