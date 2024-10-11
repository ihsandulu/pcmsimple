<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class saran_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		//cek saran
		$saranid["saran_id"]=$this->input->post("saran_id");
		$us=$this->db
		->get_where('saran',$saranid);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $saran){
				foreach($this->db->list_fields('saran') as $field)
				{
					$data[$field]=$saran->$field;
				}		
			}
		}else{				
			foreach($this->db->list_fields('saran') as $field)
			{
				$data[$field]="";
			}				
		}
		
		//upload image
		$data['uploadsaran_picture']="";
		if(isset($_FILES['saran_picture'])&&$_FILES['saran_picture']['name']!=""){
		$saran_picture=str_replace(' ', '_',$_FILES['saran_picture']['name']);
		$saran_picture = date("H_i_s_").$saran_picture;
		if(file_exists ('assets/images/saran_picture/'.$saran_picture)){
		unlink('assets/images/saran_picture/'.$saran_picture);
		}
		$config['file_name'] = $saran_picture;
		$config['upload_path'] = 'assets/images/saran_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('saran_picture'))
		{
			$data['uploadsaran_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadsaran_picture']="Upload Success !";
			$input['saran_picture']=$saran_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("saran",array("saran_id"=>$this->input->post("saran_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$this->db->insert("saran",$input);			
			$data["message"]="Insert Data Success";
			//echo $this->db->last_query();die;
		}
		
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='saran_picture'){$input[$e]=$this->input->post($e);}}
			$this->db->update("saran",$input,array("saran_id"=>$this->input->post("saran_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
