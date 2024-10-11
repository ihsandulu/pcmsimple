<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class estimasi_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		//cek estimasi
		if(isset($_POST['estimasi_id'])){
		$estimasid["estimasi_id"]=$this->input->post("estimasi_id");
		$us=$this->db
		->get_where('estimasi',$estimasid);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $estimasi){		
				foreach($this->db->list_fields('estimasi') as $field)
				{
					$data[$field]=$estimasi->$field;
				}			
			}
		}else{	
			 		
			
			foreach($this->db->list_fields('estimasi') as $field)
			{
				$data[$field]="";
			}		
			$data["estimasi_type"]=$this->input->post("estimasi_type");
			$data["project_id"]=$this->input->post("project_id");	
			
		}
		}
		
		//upload image
		$data['uploadestimasi_picture']="";
		if(isset($_FILES['estimasi_picture'])&&$_FILES['estimasi_picture']['name']!=""){
		$estimasi_picture=str_replace(' ', '_',$_FILES['estimasi_picture']['name']);
		$estimasi_picture = date("H_i_s_").$estimasi_picture;
		if(file_exists ('assets/images/estimasi_picture/'.$estimasi_picture)){
		unlink('assets/images/estimasi_picture/'.$estimasi_picture);
		}
		$config['file_name'] = $estimasi_picture;
		$config['upload_path'] = 'assets/images/estimasi_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('estimasi_picture'))
		{
			$data['uploadestimasi_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadestimasi_picture']="Upload Success !";
			$input['estimasi_picture']=$estimasi_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("estimasi",array("estimasi_id"=>$this->input->post("estimasi_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){		
		
			foreach($this->input->post() as $e=>$f){
			if($e!='create'){
				$input[$e]=$this->input->post($e);				
				}
			}
			$this->db->insert("estimasi",$input);			
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
			$this->db->update("estimasi",$input,array("estimasi_id"=>$this->input->post("estimasi_id")));
			$data["message"]="Insert Data Success";
		}
		
		return $data;
	}
	
}
