<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class header_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";	
		session_write_close();
		//cek header
		$headerd["header_id"]=$this->input->post("header_id");
		$us=$this->db
		->get_where('header',$headerd);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $header){		
			foreach($this->db->list_fields('header') as $field)
			{
				$data[$field]=$header->$field;
			}		
		}
		}else{	
			 		
			foreach($this->db->list_fields('header') as $field)
			{
				$data[$field]="";
			}
			
		}
		
		//upload image
		$data['uploadheader_picture']="";
		if(isset($_FILES['header_picture'])&&$_FILES['header_picture']['name']!=""){
		$header_picture=str_replace(' ', '_',$_FILES['header_picture']['name']);
		$header_picture = date("H_i_s_").$header_picture;
		if(file_exists ('assets/images/header_picture/'.$header_picture)){
		unlink('assets/images/header_picture/'.$header_picture);
		}
		$config['file_name'] = $header_picture;
		$config['upload_path'] = 'assets/images/header_picture/';
		$config['allowed_headers'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('header_picture'))
		{
			$data['uploadheader_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadheader_picture']="Upload Success !";
			$input['header_picture']=$header_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("header",array("header_id"=>$this->input->post("header_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$this->db->insert("header",$input);
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='header_picture'){$input[$e]=$this->input->post($e);}}
			$this->db->update("header",$input,array("header_id"=>$this->input->post("header_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
