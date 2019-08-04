<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class LoginModel extends CI_Model
{
	 function insertSignup($table,$data){
        $this->db->insert($table,$data);
        return $this->db->insert_id();
    } 

     function getUser($table,$data){
        $rows=$this->db->get_where($table,$data)->result_array();
        return $rows;
    }  

    function uploadImage($data){

    	$this->db->insert('image',$data);

    } 
}