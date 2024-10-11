<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class projectreport_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		//cek project
		if(isset($_POST['project_id'])){
		$projectd["project_id"]=$this->input->post("project_id");
		$us=$this->db
		->get_where('project',$projectd);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $project){		
				foreach($this->db->list_fields('project') as $field)
				{
					$data[$field]=$project->$field;
				}				
			}
		}else{	
			 		
			
			foreach($this->db->list_fields('project') as $field)
			{
				$data[$field]="";
			}		
			
		}
		}
		
		//upload image
		$data['uploadproject_picture']="";
		if(isset($_FILES['project_picture'])&&$_FILES['project_picture']['name']!=""){
		$project_picture=str_replace(' ', '_',$_FILES['project_picture']['name']);
		$project_picture = date("H_i_s_").$project_picture;
		if(file_exists ('assets/images/project_picture/'.$project_picture)){
		unlink('assets/images/project_picture/'.$project_picture);
		}
		$config['file_name'] = $project_picture;
		$config['upload_path'] = 'assets/images/project_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('project_picture'))
		{
			$data['uploadproject_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadproject_picture']="Upload Success !";
			$input['project_picture']=$project_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("project",array("project_id"=>$this->input->post("project_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){		
		$sjno=$this->db
		->order_by("project_id","desc")
		->limit("1")
		->get("project");
		if($sjno->num_rows()>0){
		$project_id=$sjno->row()->project_id;
		$project_id="SJK".str_pad(substr($project_id,3)+1,5,"0",STR_PAD_LEFT);
		}else{
		$project_id="SJK00001";
		}
			$input["project_id"]=$project_id;
			foreach($this->input->post() as $e=>$f){
			if($e!='create'){
				$input[$e]=$this->input->post($e);				
				}
			}
			$this->db->insert("project",$input);			
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
			$this->db->update("project",$input,array("project_id"=>$this->input->post("project_id")));
			$data["message"]="Insert Data Success";
		}
		
		return $data;
	}
	
}
