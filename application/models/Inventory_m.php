<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class inventory_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		//cek inventory
		$inventoryd["inventory_id"]=$this->input->post("inventory_id");
		$us=$this->db
		->join("unit","unit.unit_id=inventory.unit_id","left")
		->get_where('inventory',$inventoryd);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $inventory){		
			foreach($this->db->list_fields('inventory') as $field)
			{
				$data[$field]=$inventory->$field;
			}		
			foreach($this->db->list_fields('unit') as $field)
			{
				$data[$field]=$inventory->$field;
			}	
		}
		}else{	
			 		
			
			foreach($this->db->list_fields('inventory') as $field)
			{
				$data[$field]="";
			}	
			foreach($this->db->list_fields('unit') as $field)
			{
				$data[$field]="";
			}		
			
		}
		
		//upload image
		$data['uploadinventory_picture']="";
		if(isset($_FILES['inventory_picture'])&&$_FILES['inventory_picture']['name']!=""){
		$inventory_picture=str_replace(' ', '_',$_FILES['inventory_picture']['name']);
		$inventory_picture = date("H_i_s_").$inventory_picture;
		if(file_exists ('assets/images/inventory_picture/'.$inventory_picture)){
		unlink('assets/images/inventory_picture/'.$inventory_picture);
		}
		$config['file_name'] = $inventory_picture;
		$config['upload_path'] = 'assets/images/inventory_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('inventory_picture'))
		{
			$data['uploadinventory_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadinventory_picture']="Upload Success !";
			$input['inventory_picture']=$inventory_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("inventory",array("inventory_id"=>$this->input->post("inventory_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$this->db->insert("inventory",$input);
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='inventory_picture'){$input[$e]=$this->input->post($e);}}
			$input["inventory_name"]=htmlentities($input["inventory_name"], ENT_QUOTES);
			$this->db->update("inventory",$input,array("inventory_id"=>$this->input->post("inventory_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
