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

      function deletePivotUserDepartment($table,$id){
        $this->db->where('user_id',$id);
        $this->db->delete($table);
        return $this->db->affected_rows();
    }
    function deleteRow($table,$id){
        $this->db->where('ID',$id);
        $this->db->delete($table);
        return $this->db->affected_rows();
    }
    function deleteTask($order_no){
        $this->db->where('order_no',$order_no);
        $this->db->delete('chamton_tasks');
        return $this->db->affected_rows();
    }
    function editRow($table,$condition,$data){
        $result=$this->db->update($table,$data,$condition);
        return $result;
        //return $data;
    }

    function productList(){
        $this->db->select('product_list.*,product_types.CODE');
        $this->db->from('product_list');
        $this->db->join('product_types','product_list.PRODUCT_TYPE = product_types.ID','left');
        $this->db->order_by('product_list.ID','desc');
        $rows=$this->db->get()->result_array();
        return $rows;
    }
}