<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class access_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		//cek access
		$accessd["access_id"]=$this->input->post("access_id");
		$us=$this->db
		->get_where('access',$accessd);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $access){		
				foreach($this->db->list_fields('access') as $field)
				{
					$data[$field]=$access->$field;
				}		
			}
		}else{	
			foreach($this->db->list_fields('access') as $field)
			{
				$data[$field]="";
			}	
		}
		
		//upload image
		$data['uploadaccess_picture']="";
		if(isset($_FILES['access_picture'])&&$_FILES['access_picture']['name']!=""){
		$access_picture=str_replace(' ', '_',$_FILES['access_picture']['name']);
		$access_picture = date("H_i_s_").$access_picture;
		if(file_exists ('assets/images/access_picture/'.$access_picture)){
		unlink('assets/images/access_picture/'.$access_picture);
		}
		$config['file_name'] = $access_picture;
		$config['upload_path'] = 'assets/images/access_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('access_picture'))
		{
			$data['uploadaccess_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadaccess_picture']="Upload Success !";
			$input['access_picture']=$access_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("access",array("access_id"=>$this->input->post("access_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$this->db->insert("access",$input);
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='access_picture'){$input[$e]=$this->input->post($e);}}
			$this->db->update("access",$input,array("access_id"=>$this->input->post("access_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
