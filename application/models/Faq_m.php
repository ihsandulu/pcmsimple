<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class faq_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		//cek faq
		$faqid["faq_id"]=$this->input->post("faq_id");
		$us=$this->db
		->get_where('faq',$faqid);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $faq){
				foreach($this->db->list_fields('faq') as $field)
				{
					$data[$field]=$faq->$field;
				}		
			}
		}else{				
			foreach($this->db->list_fields('faq') as $field)
			{
				$data[$field]="";
			}				
		}
		
		//upload image
		$data['uploadfaq_picture']="";
		if(isset($_FILES['faq_picture'])&&$_FILES['faq_picture']['name']!=""){
		$faq_picture=str_replace(' ', '_',$_FILES['faq_picture']['name']);
		$faq_picture = date("H_i_s_").$faq_picture;
		if(file_exists ('assets/images/faq_picture/'.$faq_picture)){
		unlink('assets/images/faq_picture/'.$faq_picture);
		}
		$config['file_name'] = $faq_picture;
		$config['upload_path'] = 'assets/images/faq_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('faq_picture'))
		{
			$data['uploadfaq_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadfaq_picture']="Upload Success !";
			$input['faq_picture']=$faq_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("faq",array("faq_id"=>$this->input->post("faq_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$this->db->insert("faq",$input);			
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='faq_picture'){$input[$e]=$this->input->post($e);}}
			$this->db->update("faq",$input,array("faq_id"=>$this->input->post("faq_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
