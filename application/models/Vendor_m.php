<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class vendor_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		//cek vendor
		$vendord["vendor_id"]=$this->input->post("vendor_id");
		$us=$this->db
		->get_where('vendor',$vendord);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $vendor){		
			foreach($this->db->list_fields('vendor') as $field)
			{
				$data[$field]=$vendor->$field;
			}				foreach($this->db->list_fields('vendor') as $field)
			{
				$data[$field]=$vendor->$field;
			}		
		}
		}else{	
			 		
			
			foreach($this->db->list_fields('vendor') as $field)
			{
				$data[$field]="";
			}		
			
		}
		
		//upload image
		$data['uploadvendor_picture']="";
		if(isset($_FILES['vendor_picture'])&&$_FILES['vendor_picture']['name']!=""){
		$vendor_picture=str_replace(' ', '_',$_FILES['vendor_picture']['name']);
		$vendor_picture = date("H_i_s_").$vendor_picture;
		if(file_exists ('assets/images/vendor_picture/'.$vendor_picture)){
		unlink('assets/images/vendor_picture/'.$vendor_picture);
		}
		$config['file_name'] = $vendor_picture;
		$config['upload_path'] = 'assets/images/vendor_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('vendor_picture'))
		{
			$data['uploadvendor_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadvendor_picture']="Upload Success !";
			$input['vendor_picture']=$vendor_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("vendor",array("vendor_id"=>$this->input->post("vendor_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$this->db->insert("vendor",$input);
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='vendor_picture'){$input[$e]=$this->input->post($e);}}
			$input["vendor_name"]=htmlentities($input["vendor_name"], ENT_QUOTES);
			$this->db->update("vendor",$input,array("vendor_id"=>$this->input->post("vendor_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
