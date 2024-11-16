<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class hunian_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		//cek hunian
		$huniand["hunian_id"]=$this->input->post("hunian_id");
		$us=$this->db
		->get_where('hunian',$huniand);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $hunian){		
			foreach($this->db->list_fields('hunian') as $field)
			{
				$data[$field]=$hunian->$field;
			}		
		}
		}else{	
			 		
			
			foreach($this->db->list_fields('hunian') as $field)
			{
				$data[$field]="";
			}		
			
		}
		
		//upload image
		$data['uploadhunian_picture']="";
		if(isset($_FILES['hunian_picture'])&&$_FILES['hunian_picture']['name']!=""){
		$hunian_picture=str_replace(' ', '_',$_FILES['hunian_picture']['name']);
		$hunian_picture = date("H_i_s_").$hunian_picture;
		if(file_exists ('assets/images/hunian_picture/'.$hunian_picture)){
		unlink('assets/images/hunian_picture/'.$hunian_picture);
		}
		$config['file_name'] = $hunian_picture;
		$config['upload_path'] = 'assets/images/hunian_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('hunian_picture'))
		{
			$data['uploadhunian_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadhunian_picture']="Upload Success !";
			$input['hunian_picture']=$hunian_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("hunian",array("hunian_id"=>$this->input->post("hunian_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$this->db->insert("hunian",$input);
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='hunian_picture'){$input[$e]=$this->input->post($e);}}
			$input["hunian_name"]=htmlentities($input["hunian_name"], ENT_QUOTES);
			$this->db->update("hunian",$input,array("hunian_id"=>$this->input->post("hunian_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
