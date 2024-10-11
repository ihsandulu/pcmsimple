<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class supplier_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		//cek supplier
		$supplierd["supplier_id"]=$this->input->post("supplier_id");
		$us=$this->db
		->get_where('supplier',$supplierd);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $supplier){		
			foreach($this->db->list_fields('supplier') as $field)
			{
				$data[$field]=$supplier->$field;
			}				foreach($this->db->list_fields('supplier') as $field)
			{
				$data[$field]=$supplier->$field;
			}		
		}
		}else{	
			 		
			
			foreach($this->db->list_fields('supplier') as $field)
			{
				$data[$field]="";
			}		
			
		}
		
		//upload image
		$data['uploadsupplier_picture']="";
		if(isset($_FILES['supplier_picture'])&&$_FILES['supplier_picture']['name']!=""){
		$supplier_picture=str_replace(' ', '_',$_FILES['supplier_picture']['name']);
		$supplier_picture = date("H_i_s_").$supplier_picture;
		if(file_exists ('assets/images/supplier_picture/'.$supplier_picture)){
		unlink('assets/images/supplier_picture/'.$supplier_picture);
		}
		$config['file_name'] = $supplier_picture;
		$config['upload_path'] = 'assets/images/supplier_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('supplier_picture'))
		{
			$data['uploadsupplier_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadsupplier_picture']="Upload Success !";
			$input['supplier_picture']=$supplier_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("supplier",array("supplier_id"=>$this->input->post("supplier_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$this->db->insert("supplier",$input);
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='supplier_picture'){$input[$e]=$this->input->post($e);}}
			$input["supplier_name"]=htmlentities($input["supplier_name"], ENT_QUOTES);
			$this->db->update("supplier",$input,array("supplier_id"=>$this->input->post("supplier_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
