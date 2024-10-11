<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class activity_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";	
		session_write_close();
		//cek activity
		$activityd["activity_id"]=$this->input->post("activity_id");
		$us=$this->db
		->get_where('activity',$activityd);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $activity){		
			foreach($this->db->list_fields('activity') as $field)
			{
				$data[$field]=$activity->$field;
			}		
		}
		}else{	
			 		
			foreach($this->db->list_fields('activity') as $field)
			{
				$data[$field]="";
			}
			
		}
		
		//upload image
		$data['uploadactivity_picture']="";
		if(isset($_FILES['activity_picture'])&&$_FILES['activity_picture']['name']!=""){
		$activity_picture=str_replace(' ', '_',$_FILES['activity_picture']['name']);
		$activity_picture = date("H_i_s_").$activity_picture;
		if(file_exists ('assets/images/activity_picture/'.$activity_picture)){
		unlink('assets/images/activity_picture/'.$activity_picture);
		}
		$config['file_name'] = $activity_picture;
		$config['upload_path'] = 'assets/images/activity_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('activity_picture'))
		{
			$data['uploadactivity_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadactivity_picture']="Upload Success !";
			$input['activity_picture']=$activity_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("activity",array("activity_id"=>$this->input->post("activity_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$this->db->insert("activity",$input);
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='activity_picture'){$input[$e]=$this->input->post($e);}}
			$this->db->update("activity",$input,array("activity_id"=>$this->input->post("activity_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
