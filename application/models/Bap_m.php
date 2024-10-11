<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class bap_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		//cek bap
		$bapd["bap_id"]=$this->input->post("bap_id");
		$us=$this->db
		->get_where('bap',$bapd);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $bap){		
			foreach($this->db->list_fields('bap') as $field)
			{
				$data[$field]=$bap->$field;
			}		
		}
		}else{	
			 		
			
			foreach($this->db->list_fields('bap') as $field)
			{
				$data[$field]="";
			}		
			
		}
		
		//upload image
		$data['uploadbap_picture']="";
		if(isset($_FILES['bap_picture'])&&$_FILES['bap_picture']['name']!=""){
		$bap_picture=str_replace(' ', '_',$_FILES['bap_picture']['name']);
		$bap_picture = date("H_i_s_").$bap_picture;
		if(file_exists ('assets/images/bap_picture/'.$bap_picture)){
		unlink('assets/images/bap_picture/'.$bap_picture);
		}
		$config['file_name'] = $bap_picture;
		$config['upload_path'] = 'assets/images/bap_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('bap_picture'))
		{
			$data['uploadbap_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadbap_picture']="Upload Success !";
			$input['bap_picture']=$bap_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("bap",array("bap_id"=>$this->input->post("bap_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$this->db->insert("bap",$input);
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='bap_picture'){$input[$e]=$this->input->post($e);}}
			$input["bap_name"]=htmlentities($input["bap_name"], ENT_QUOTES);
			$this->db->update("bap",$input,array("bap_id"=>$this->input->post("bap_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
