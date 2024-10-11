<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class tasktproduct_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		//cek taskproduct
		if(isset($_POST['taskproduct_id'])){
		$taskproductd["taskproduct_id"]=$this->input->post("taskproduct_id");
		$us=$this->db
		->join("product","product.product_id=taskproduct.product_id","left")
		->get_where('taskproduct',$taskproductd);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $taskproduct){		
			foreach($this->db->list_fields('taskproduct') as $field)
			{
				$data[$field]=$taskproduct->$field;
			}		
			foreach($this->db->list_fields('product') as $field)
			{
				$data[$field]=$taskproduct->$field;
			}	
		}
		}else{	
			 		
			
			foreach($this->db->list_fields('taskproduct') as $field)
			{
				$data[$field]="";
			}	
			foreach($this->db->list_fields('product') as $field)
			{
				$data[$field]="";
			}		
			
		}
		}
		
		//upload image
		$data['uploadtaskproduct_picture']="";
		if(isset($_FILES['taskproduct_picture'])&&$_FILES['taskproduct_picture']['name']!=""){
		$taskproduct_picture=str_replace(' ', '_',$_FILES['taskproduct_picture']['name']);
		$taskproduct_picture = date("H_i_s_").$taskproduct_picture;
		if(file_exists ('assets/images/taskproduct_picture/'.$taskproduct_picture)){
		unlink('assets/images/taskproduct_picture/'.$taskproduct_picture);
		}
		$config['file_name'] = $taskproduct_picture;
		$config['upload_path'] = 'assets/images/taskproduct_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('taskproduct_picture'))
		{
			$data['uploadtaskproduct_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadtaskproduct_picture']="Upload Success !";
			$input['taskproduct_picture']=$taskproduct_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("taskproduct",array("taskproduct_id"=>$this->input->post("taskproduct_id")));
			$this->db->delete("gudang",array("taskproduct_id"=>$this->input->post("taskproduct_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$this->db->insert("taskproduct",$input);
			
			$gudang["product_id"]=$this->input->post("product_id");
			$gudang["gudang_qty"]=$this->input->post("taskproduct_qty");
			$gudang["gudang_inout"]="out";
			$gudang["taskproduct_id"]=$this->db->insert_id();
			$gudang["task_no"]=$this->input->post("task_no");
			$this->db->insert("gudang",$gudang);
			//echo $this->db->last_query();die;
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='taskproduct_picture'){$input[$e]=$this->input->post($e);}}
			$this->db->update("taskproduct",$input,array("taskproduct_id"=>$this->input->post("taskproduct_id")));
			
			
			
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
