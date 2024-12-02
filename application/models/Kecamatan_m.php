<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class kecamatan_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		//cek kecamatan
		$kecamatand["kecamatan_id"]=$this->input->post("kecamatan_id");
		$us=$this->db
		->get_where('kecamatan',$kecamatand);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $kecamatan){		
			foreach($this->db->list_fields('kecamatan') as $field)
			{
				$data[$field]=$kecamatan->$field;
			}		
		}
		}else{	
			 		
			
			foreach($this->db->list_fields('kecamatan') as $field)
			{
				$data[$field]="";
			}		
			
		}
		
		//upload image
		$data['uploadkecamatan_picture']="";
		if(isset($_FILES['kecamatan_picture'])&&$_FILES['kecamatan_picture']['name']!=""){
		$kecamatan_picture=str_replace(' ', '_',$_FILES['kecamatan_picture']['name']);
		$kecamatan_picture = date("H_i_s_").$kecamatan_picture;
		if(file_exists ('assets/images/kecamatan_picture/'.$kecamatan_picture)){
		unlink('assets/images/kecamatan_picture/'.$kecamatan_picture);
		}
		$config['file_name'] = $kecamatan_picture;
		$config['upload_path'] = 'assets/images/kecamatan_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('kecamatan_picture'))
		{
			$data['uploadkecamatan_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadkecamatan_picture']="Upload Success !";
			$input['kecamatan_picture']=$kecamatan_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("kecamatan",array("kecamatan_id"=>$this->input->post("kecamatan_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$this->db->insert("kecamatan",$input);
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='kecamatan_picture'){$input[$e]=$this->input->post($e);}}
			$input["kecamatan_name"]=htmlentities($input["kecamatan_name"], ENT_QUOTES);
			$this->db->update("kecamatan",$input,array("kecamatan_id"=>$this->input->post("kecamatan_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
