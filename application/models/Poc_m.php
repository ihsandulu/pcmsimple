<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class poc_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		//cek poc
		if(isset($_POST['poc_id'])){
		$pocd["poc_id"]=$this->input->post("poc_id");
		$us=$this->db
		->get_where('poc',$pocd);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $poc){		
				foreach($this->db->list_fields('poc') as $field)
				{
					$data[$field]=$poc->$field;
				}				
			}
		}else{	
			 		
			
			foreach($this->db->list_fields('poc') as $field)
			{
				$data[$field]="";
			}		
			
		}
		}
		
		//upload image
		$data['uploadpoc_picture']="";
		if(isset($_FILES['poc_picture'])&&$_FILES['poc_picture']['name']!=""){
		$poc_picture=str_replace(' ', '_',$_FILES['poc_picture']['name']);
		$poc_picture = date("H_i_s_").$poc_picture;
		if(file_exists ('assets/images/poc_picture/'.$poc_picture)){
		unlink('assets/images/poc_picture/'.$poc_picture);
		}
		$config['file_name'] = $poc_picture;
		$config['upload_path'] = 'assets/images/poc_picture/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('poc_picture'))
		{
			$data['uploadpoc_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadpoc_picture']="Upload Success !";
			$input['poc_picture']=$poc_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("poc",array("poc_no"=>$this->input->post("poc_no")));
			$this->db->delete("pocproduct",array("poc_no"=>$this->input->post("poc_no")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){		
		
			foreach($this->input->post() as $e=>$f){
			if($e!='create'){
				$input[$e]=$this->input->post($e);				
				}
			}
			$this->db->insert("poc",$input);			
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
			$this->db->update("poc",$input,array("poc_id"=>$this->input->post("poc_id")));
			$data["message"]="Insert Data Success";
		}
		
		return $data;
	}
	
}
