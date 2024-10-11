<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class pettyprint_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		//cek petty
		if(isset($_POST['petty_id'])){
		$pettyd["petty_id"]=$this->input->post("petty_id");
		$us=$this->db
		->get_where('petty',$pettyd);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $petty){		
				foreach($this->db->list_fields('petty') as $field)
				{
					$data[$field]=$petty->$field;
				}				
			}
		}else{	
			 		
			
			foreach($this->db->list_fields('petty') as $field)
			{
				$data[$field]="";
			}		
			
		}
		}
		
		$identit=$this->db
		->get("identity");
		foreach($identit->result() as $identity){
			foreach($this->db->list_fields('identity') as $field){
				$data[$field]=$identity->$field;
			}
		}
		
		//upload image
		$data['uploadpetty_picture']="";
		if(isset($_FILES['petty_picture'])&&$_FILES['petty_picture']['name']!=""){
		$petty_picture=str_replace(' ', '_',$_FILES['petty_picture']['name']);
		$petty_picture = date("H_i_s_").$petty_picture;
		if(file_exists ('assets/images/petty_picture/'.$petty_picture)){
		unlink('assets/images/petty_picture/'.$petty_picture);
		}
		$config['file_name'] = $petty_picture;
		$config['upload_path'] = 'assets/images/petty_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('petty_picture'))
		{
			$data['uploadpetty_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadpetty_picture']="Upload Success !";
			$input['petty_picture']=$petty_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("petty",array("petty_id"=>$this->input->post("petty_id")));			
			$this->db->delete("pettyproduct",array("petty_id"=>$this->input->post("petty_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){		
		foreach($this->input->post() as $e=>$f){
			if($e!='create'){
				$input[$e]=$this->input->post($e);				
				}
			}			
			$this->db->insert("petty",$input);			
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
			$this->db->update("petty",$input,array("petty_id"=>$this->input->post("petty_id")));
			$data["message"]="Insert Data Success";
		}
		
		return $data;
	}
	
}
