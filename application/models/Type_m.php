<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class type_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";	
		session_write_close();
		//cek type
		$typed["type_id"]=$this->input->post("type_id");
		$us=$this->db
		->get_where('type',$typed);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $type){		
			foreach($this->db->list_fields('type') as $field)
			{
				$data[$field]=$type->$field;
			}		
		}
		}else{	
			 		
			foreach($this->db->list_fields('type') as $field)
			{
				$data[$field]="";
			}
			
		}
		
		//upload image
		$data['uploadtype_picture']="";
		if(isset($_FILES['type_picture'])&&$_FILES['type_picture']['name']!=""){
		$type_picture=str_replace(' ', '_',$_FILES['type_picture']['name']);
		$type_picture = date("H_i_s_").$type_picture;
		if(file_exists ('assets/images/type_picture/'.$type_picture)){
		unlink('assets/images/type_picture/'.$type_picture);
		}
		$config['file_name'] = $type_picture;
		$config['upload_path'] = 'assets/images/type_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('type_picture'))
		{
			$data['uploadtype_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadtype_picture']="Upload Success !";
			$input['type_picture']=$type_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("type",array("type_id"=>$this->input->post("type_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$this->db->insert("type",$input);
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='type_picture'){$input[$e]=$this->input->post($e);}}
			$this->db->update("type",$input,array("type_id"=>$this->input->post("type_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
