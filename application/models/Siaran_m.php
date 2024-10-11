<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class siaran_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";	
		session_write_close();
		//cek type
		$siarand["siaran_id"]=$this->input->post("siaran_id");
		$us=$this->db
		->get_where('siaran',$siarand);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $siaran){		
			foreach($this->db->list_fields('siaran') as $field)
			{
				$data[$field]=$siaran->$field;
			}		
		}
		}else{	
			 		
			foreach($this->db->list_fields('siaran') as $field)
			{
				$data[$field]="";
			}
			
		}
		
		//upload image
		$data['uploadsiaran_picture']="";
		if(isset($_FILES['siaran_picture'])&&$_FILES['siaran_picture']['name']!=""){
		$siaran_picture=str_replace(' ', '_',$_FILES['siaran_picture']['name']);
		$siaran_picture = date("H_i_s_").$siaran_picture;
		if(file_exists ('assets/images/siaran_picture/'.$siaran_picture)){
		unlink('assets/images/siaran_picture/'.$siaran_picture);
		}
		$config['file_name'] = $siaran_picture;
		$config['upload_path'] = 'assets/images/siaran_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('siaran_picture'))
		{
			$data['uploadsiaran_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadsiaran_picture']="Upload Success !";
			$input['siaran_picture']=$siaran_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("siaran",array("siaran_id"=>$this->input->post("siaran_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$this->db->insert("siaran",$input);
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='siaran_picture'){$input[$e]=$this->input->post($e);}}
			$this->db->update("siaran",$input,array("siaran_id"=>$this->input->post("siaran_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
