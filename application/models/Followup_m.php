<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class followup_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		//cek followup
		if(isset($_POST['followup_id'])){
		$followupd["followup_id"]=$this->input->post("followup_id");
		$us=$this->db
		->get_where('followup',$followupd);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $followup){		
				foreach($this->db->list_fields('followup') as $field)
				{
					$data[$field]=$followup->$field;
				}	
			}
		}else{	
			foreach($this->db->list_fields('followup') as $field)
			{
				$data[$field]="";
			}
		}
		}
		
		//upload image
		$data['uploadfollowup_picture']="";
		if(isset($_FILES['followup_picture'])&&$_FILES['followup_picture']['name']!=""){
		$followup_picture=str_replace(' ', '_',$_FILES['followup_picture']['name']);
		$followup_picture = date("H_i_s_").$followup_picture;
		if(file_exists ('assets/images/followup_picture/'.$followup_picture)){
		unlink('assets/images/followup_picture/'.$followup_picture);
		}
		$config['file_name'] = $followup_picture;
		$config['upload_path'] = 'assets/images/followup_picture/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('followup_picture'))
		{
			$data['uploadfollowup_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadfollowup_picture']="Upload Success !";
			$input['followup_picture']=$followup_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("followup",array("followup_id"=>$this->input->post("followup_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$input['followup_date']=date("Y-m-d");
			$this->db->insert("followup",$input);
			//echo $this->db->last_query();die;
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='followup_picture'){$input[$e]=$this->input->post($e);}}
			$this->db->update("followup",$input,array("followup_id"=>$this->input->post("followup_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
