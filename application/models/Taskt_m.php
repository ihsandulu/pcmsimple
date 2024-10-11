<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class taskt_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		//cek task
		if(isset($_POST['task_no'])){
		$taskd["task_no"]=$this->input->post("task_no");
		$us=$this->db
		->get_where('task',$taskd);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $task){		
				foreach($this->db->list_fields('task') as $field)
				{
					$data[$field]=$task->$field;
				}				
			}
		}else{	
			 		
			
			foreach($this->db->list_fields('task') as $field)
			{
				$data[$field]="";
			}		
			
		}
		}
		
		//upload image
		$data['uploadtask_picture']="";
		if(isset($_FILES['task_picture'])&&$_FILES['task_picture']['name']!=""){
		$task_picture=str_replace(' ', '_',$_FILES['task_picture']['name']);
		$task_picture = date("H_i_s_").$task_picture;
		if(file_exists ('assets/images/task_picture/'.$task_picture)){
		unlink('assets/images/task_picture/'.$task_picture);
		}
		$config['file_name'] = $task_picture;
		$config['upload_path'] = 'assets/images/task_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('task_picture'))
		{
			$data['uploadtask_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadtask_picture']="Upload Success !";
			$input['task_picture']=$task_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("task",array("task_no"=>$this->input->post("task_no")));			
			$this->db->delete("taskproduct",array("task_no"=>$this->input->post("task_no")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){		
		$sjno=$this->db
		->order_by("task_no","desc")
		->limit("1")
		->get("task");
		if($sjno->num_rows()>0){
		$task_no=$sjno->row()->task_no;
		$task_no="TSK".str_pad(substr($task_no,3)+1,5,"0",STR_PAD_LEFT);
		}else{
		$task_no="TSK00001";
		}
			$input["task_no"]=$task_no;
			foreach($this->input->post() as $e=>$f){
			if($e!='create'){
				$input[$e]=$this->input->post($e);				
				}
			}
			$this->db->insert("task",$input);			
			//echo $this->db->last_query();die;
			
			$data["message"]="Insert Data Success";
		}
		
		//update
		if($this->input->post("change")=="OK"){
		
			foreach($this->input->post() as $e=>$f){
			if($e!='change'){
				$input[$e]=$this->input->post($e);				
				}
			}			
			$this->db->update("task",$input,array("task_id"=>$this->input->post("task_id")));
			$data["message"]="Insert Data Success";
		}
		
		return $data;
	}
	
}
