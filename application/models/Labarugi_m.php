<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class labarugi_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		//cek branch
		$branchd["branch_id"]=$this->input->post("branch_id");
		$us=$this->db
		->get_where('branch',$branchd);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $branch){		
			foreach($this->db->list_fields('branch') as $field)
			{
				$data[$field]=$branch->$field;
			}		
		}
		}else{	
			 		
			
			foreach($this->db->list_fields('branch') as $field)
			{
				$data[$field]="";
			}		
			
		}
		
		//upload image
		$data['uploadbranch_picture']="";
		if(isset($_FILES['branch_picture'])&&$_FILES['branch_picture']['name']!=""){
		$branch_picture=str_replace(' ', '_',$_FILES['branch_picture']['name']);
		$branch_picture = date("H_i_s_").$branch_picture;
		if(file_exists ('assets/images/branch_picture/'.$branch_picture)){
		unlink('assets/images/branch_picture/'.$branch_picture);
		}
		$config['file_name'] = $branch_picture;
		$config['upload_path'] = 'assets/images/branch_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('branch_picture'))
		{
			$data['uploadbranch_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadbranch_picture']="Upload Success !";
			$input['branch_picture']=$branch_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("branch",array("branch_id"=>$this->input->post("branch_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$this->db->insert("branch",$input);
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='branch_picture'){$input[$e]=$this->input->post($e);}}
			$input["branch_name"]=htmlentities($input["branch_name"], ENT_QUOTES);
			$this->db->update("branch",$input,array("branch_id"=>$this->input->post("branch_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
