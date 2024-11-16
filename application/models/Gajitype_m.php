<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class gajitype_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		//cek gajitype
		$gajityped["gajitype_id"]=$this->input->post("gajitype_id");
		$us=$this->db
		->get_where('gajitype',$gajityped);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $gajitype){		
			foreach($this->db->list_fields('gajitype') as $field)
			{
				$data[$field]=$gajitype->$field;
			}		
		}
		}else{	
			 		
			
			foreach($this->db->list_fields('gajitype') as $field)
			{
				$data[$field]="";
			}		
			
		}
		
		//upload image
		$data['uploadgajitype_picture']="";
		if(isset($_FILES['gajitype_picture'])&&$_FILES['gajitype_picture']['name']!=""){
		$gajitype_picture=str_replace(' ', '_',$_FILES['gajitype_picture']['name']);
		$gajitype_picture = date("H_i_s_").$gajitype_picture;
		if(file_exists ('assets/images/gajitype_picture/'.$gajitype_picture)){
		unlink('assets/images/gajitype_picture/'.$gajitype_picture);
		}
		$config['file_name'] = $gajitype_picture;
		$config['upload_path'] = 'assets/images/gajitype_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('gajitype_picture'))
		{
			$data['uploadgajitype_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadgajitype_picture']="Upload Success !";
			$input['gajitype_picture']=$gajitype_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("gajitype",array("gajitype_id"=>$this->input->post("gajitype_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$this->db->insert("gajitype",$input);
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='gajitype_picture'){$input[$e]=$this->input->post($e);}}
			$input["gajitype_name"]=htmlentities($input["gajitype_name"], ENT_QUOTES);
			$this->db->update("gajitype",$input,array("gajitype_id"=>$this->input->post("gajitype_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
