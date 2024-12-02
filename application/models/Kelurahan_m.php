<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class kelurahan_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		//cek kelurahan
		$kelurahand["kelurahan_id"]=$this->input->post("kelurahan_id");
		$us=$this->db
		->get_where('kelurahan',$kelurahand);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $kelurahan){		
			foreach($this->db->list_fields('kelurahan') as $field)
			{
				$data[$field]=$kelurahan->$field;
			}		
		}
		}else{	
			 		
			
			foreach($this->db->list_fields('kelurahan') as $field)
			{
				$data[$field]="";
			}		
			
		}
		
		//upload image
		$data['uploadkelurahan_picture']="";
		if(isset($_FILES['kelurahan_picture'])&&$_FILES['kelurahan_picture']['name']!=""){
		$kelurahan_picture=str_replace(' ', '_',$_FILES['kelurahan_picture']['name']);
		$kelurahan_picture = date("H_i_s_").$kelurahan_picture;
		if(file_exists ('assets/images/kelurahan_picture/'.$kelurahan_picture)){
		unlink('assets/images/kelurahan_picture/'.$kelurahan_picture);
		}
		$config['file_name'] = $kelurahan_picture;
		$config['upload_path'] = 'assets/images/kelurahan_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('kelurahan_picture'))
		{
			$data['uploadkelurahan_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadkelurahan_picture']="Upload Success !";
			$input['kelurahan_picture']=$kelurahan_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("kelurahan",array("kelurahan_id"=>$this->input->post("kelurahan_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$this->db->insert("kelurahan",$input);
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='kelurahan_picture'){$input[$e]=$this->input->post($e);}}
			$input["kelurahan_name"]=htmlentities($input["kelurahan_name"], ENT_QUOTES);
			$this->db->update("kelurahan",$input,array("kelurahan_id"=>$this->input->post("kelurahan_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
