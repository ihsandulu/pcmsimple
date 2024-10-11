<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class biaya_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		//cek biaya
		$biayad["biaya_id"]=$this->input->post("biaya_id");
		$us=$this->db
		->get_where('biaya',$biayad);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $biaya){		
			foreach($this->db->list_fields('biaya') as $field)
			{
				$data[$field]=$biaya->$field;
			}		
		}
		}else{	
			 		
			
			foreach($this->db->list_fields('biaya') as $field)
			{
				$data[$field]="";
			}		
			
		}
		
		//upload image
		$data['uploadbiaya_picture']="";
		if(isset($_FILES['biaya_picture'])&&$_FILES['biaya_picture']['name']!=""){
		$biaya_picture=str_replace(' ', '_',$_FILES['biaya_picture']['name']);
		$biaya_picture = date("H_i_s_").$biaya_picture;
		if(file_exists ('assets/images/biaya_picture/'.$biaya_picture)){
		unlink('assets/images/biaya_picture/'.$biaya_picture);
		}
		$config['file_name'] = $biaya_picture;
		$config['upload_path'] = 'assets/images/biaya_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('biaya_picture'))
		{
			$data['uploadbiaya_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadbiaya_picture']="Upload Success !";
			$input['biaya_picture']=$biaya_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("biaya",array("biaya_id"=>$this->input->post("biaya_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$this->db->insert("biaya",$input);
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='biaya_picture'){$input[$e]=$this->input->post($e);}}
			$input["biaya_name"]=htmlentities($input["biaya_name"], ENT_QUOTES);
			$this->db->update("biaya",$input,array("biaya_id"=>$this->input->post("biaya_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
