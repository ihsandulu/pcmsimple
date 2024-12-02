<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class provinsi_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		//cek provinsi
		$provinsid["provinsi_id"]=$this->input->post("provinsi_id");
		$us=$this->db
		->get_where('provinsi',$provinsid);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $provinsi){		
			foreach($this->db->list_fields('provinsi') as $field)
			{
				$data[$field]=$provinsi->$field;
			}		
		}
		}else{	
			 		
			
			foreach($this->db->list_fields('provinsi') as $field)
			{
				$data[$field]="";
			}		
			
		}
		
		//upload image
		$data['uploadprovinsi_picture']="";
		if(isset($_FILES['provinsi_picture'])&&$_FILES['provinsi_picture']['name']!=""){
		$provinsi_picture=str_replace(' ', '_',$_FILES['provinsi_picture']['name']);
		$provinsi_picture = date("H_i_s_").$provinsi_picture;
		if(file_exists ('assets/images/provinsi_picture/'.$provinsi_picture)){
		unlink('assets/images/provinsi_picture/'.$provinsi_picture);
		}
		$config['file_name'] = $provinsi_picture;
		$config['upload_path'] = 'assets/images/provinsi_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('provinsi_picture'))
		{
			$data['uploadprovinsi_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadprovinsi_picture']="Upload Success !";
			$input['provinsi_picture']=$provinsi_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("provinsi",array("provinsi_id"=>$this->input->post("provinsi_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$this->db->insert("provinsi",$input);
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='provinsi_picture'){$input[$e]=$this->input->post($e);}}
			$input["provinsi_name"]=htmlentities($input["provinsi_name"], ENT_QUOTES);
			$this->db->update("provinsi",$input,array("provinsi_id"=>$this->input->post("provinsi_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
