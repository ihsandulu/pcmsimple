<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class kota_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		//cek kota
		$kotad["kota_id"]=$this->input->post("kota_id");
		$us=$this->db
		->get_where('kota',$kotad);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $kota){		
			foreach($this->db->list_fields('kota') as $field)
			{
				$data[$field]=$kota->$field;
			}		
		}
		}else{	
			 		
			
			foreach($this->db->list_fields('kota') as $field)
			{
				$data[$field]="";
			}		
			
		}
		
		//upload image
		$data['uploadkota_picture']="";
		if(isset($_FILES['kota_picture'])&&$_FILES['kota_picture']['name']!=""){
		$kota_picture=str_replace(' ', '_',$_FILES['kota_picture']['name']);
		$kota_picture = date("H_i_s_").$kota_picture;
		if(file_exists ('assets/images/kota_picture/'.$kota_picture)){
		unlink('assets/images/kota_picture/'.$kota_picture);
		}
		$config['file_name'] = $kota_picture;
		$config['upload_path'] = 'assets/images/kota_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('kota_picture'))
		{
			$data['uploadkota_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadkota_picture']="Upload Success !";
			$input['kota_picture']=$kota_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("kota",array("kota_id"=>$this->input->post("kota_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$this->db->insert("kota",$input);
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='kota_picture'){$input[$e]=$this->input->post($e);}}
			$input["kota_name"]=htmlentities($input["kota_name"], ENT_QUOTES);
			$this->db->update("kota",$input,array("kota_id"=>$this->input->post("kota_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
