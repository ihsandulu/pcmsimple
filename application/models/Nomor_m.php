<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class nomor_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		//cek nomor
		$nomord["nomor_id"]=$this->input->post("nomor_id");
		$us=$this->db
		->get_where('nomor',$nomord);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $nomor){		
			foreach($this->db->list_fields('nomor') as $field)
			{
				$data[$field]=$nomor->$field;
			}		
		}
		}else{	
			 		
			
			foreach($this->db->list_fields('nomor') as $field)
			{
				$data[$field]="";
			}		
			
		}
		
		//upload image
		$data['uploadnomor_picture']="";
		if(isset($_FILES['nomor_picture'])&&$_FILES['nomor_picture']['name']!=""){
		$nomor_picture=str_replace(' ', '_',$_FILES['nomor_picture']['name']);
		$nomor_picture = date("H_i_s_").$nomor_picture;
		if(file_exists ('assets/images/nomor_picture/'.$nomor_picture)){
		unlink('assets/images/nomor_picture/'.$nomor_picture);
		}
		$config['file_name'] = $nomor_picture;
		$config['upload_path'] = 'assets/images/nomor_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('nomor_picture'))
		{
			$data['uploadnomor_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadnomor_picture']="Upload Success !";
			$input['nomor_picture']=$nomor_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("nomor",array("nomor_id"=>$this->input->post("nomor_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$this->db->insert("nomor",$input);
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='nomor_picture'){$input[$e]=$this->input->post($e);}}
			$input["nomor_name"]=htmlentities($input["nomor_name"], ENT_QUOTES);
			$this->db->update("nomor",$input,array("nomor_id"=>$this->input->post("nomor_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
