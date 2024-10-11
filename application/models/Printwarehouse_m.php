<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class Printwarehouse_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		//cek gudang
		$gudangd["gudang_id"]=$this->input->post("gudang_id");
		$us=$this->db
		->get_where('gudang',$gudangd);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $gudang){		
			foreach($this->db->list_fields('gudang') as $field)
			{
				$data[$field]=$gudang->$field;
			}				foreach($this->db->list_fields('gudang') as $field)
			{
				$data[$field]=$gudang->$field;
			}		
		}
		}else{	
			 		
			
			foreach($this->db->list_fields('gudang') as $field)
			{
				$data[$field]="";
			}		
			
		}
		
		//upload image
		$data['uploadgudang_picture']="";
		if(isset($_FILES['gudang_picture'])&&$_FILES['gudang_picture']['name']!=""){
		$gudang_picture=str_replace(' ', '_',$_FILES['gudang_picture']['name']);
		$gudang_picture = date("H_i_s_").$gudang_picture;
		if(file_exists ('assets/images/gudang_picture/'.$gudang_picture)){
		unlink('assets/images/gudang_picture/'.$gudang_picture);
		}
		$config['file_name'] = $gudang_picture;
		$config['upload_path'] = 'assets/images/gudang_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('gudang_picture'))
		{
			$data['uploadgudang_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadgudang_picture']="Upload Success !";
			$input['gudang_picture']=$gudang_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("gudang",array("gudang_id"=>$this->input->post("gudang_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$this->db->insert("gudang",$input);
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='gudang_picture'){$input[$e]=$this->input->post($e);}}
			$this->db->update("gudang",$input,array("gudang_id"=>$this->input->post("gudang_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
