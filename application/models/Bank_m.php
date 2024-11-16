<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class bank_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		//cek bank
		$bankd["bank_id"]=$this->input->post("bank_id");
		$us=$this->db
		->get_where('bank',$bankd);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $bank){		
			foreach($this->db->list_fields('bank') as $field)
			{
				$data[$field]=$bank->$field;
			}		
		}
		}else{	
			 		
			
			foreach($this->db->list_fields('bank') as $field)
			{
				$data[$field]="";
			}		
			
		}
		
		//upload image
		$data['uploadbank_picture']="";
		if(isset($_FILES['bank_picture'])&&$_FILES['bank_picture']['name']!=""){
		$bank_picture=str_replace(' ', '_',$_FILES['bank_picture']['name']);
		$bank_picture = date("H_i_s_").$bank_picture;
		if(file_exists ('assets/images/bank_picture/'.$bank_picture)){
		unlink('assets/images/bank_picture/'.$bank_picture);
		}
		$config['file_name'] = $bank_picture;
		$config['upload_path'] = 'assets/images/bank_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('bank_picture'))
		{
			$data['uploadbank_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadbank_picture']="Upload Success !";
			$input['bank_picture']=$bank_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("bank",array("bank_id"=>$this->input->post("bank_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$this->db->insert("bank",$input);
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='bank_picture'){$input[$e]=$this->input->post($e);}}
			$input["bank_name"]=htmlentities($input["bank_name"], ENT_QUOTES);
			$this->db->update("bank",$input,array("bank_id"=>$this->input->post("bank_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
