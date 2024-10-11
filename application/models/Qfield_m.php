<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class qfield_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		
		
		//upload image
		$data['uploadqfield_picture']="";
		if(isset($_FILES['qfield_picture'])&&$_FILES['qfield_picture']['name']!=""){
		$qfield_picture=str_replace(' ', '_',$_FILES['qfield_picture']['name']);
		$qfield_picture = date("H_i_s_").$qfield_picture;
		if(file_exists ('assets/images/qfield_picture/'.$qfield_picture)){
		unlink('assets/images/qfield_picture/'.$qfield_picture);
		}
		$config['file_name'] = $qfield_picture;
		$config['upload_path'] = 'assets/images/qfield_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('qfield_picture'))
		{
			$data['uploadqfield_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadqfield_picture']="Upload Success !";
			$input['qfield_picture']=$qfield_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("qfield",array("qfield_id"=>$this->input->post("qfield_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$this->db->insert("qfield",$input);
			$data["message"]="Insert Data Success";
		}
		//echo $this->db->last_query();die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='qfield_picture'){$input[$e]=$this->input->post($e);}}
			$this->db->update("qfield",$input);
			//echo $this->db->last_query();die;
			$data["message"]="Update Success";
		}
		
		//cek qfield
		$us=$this->db->get('qfield');	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $qfield){		
				foreach($this->db->list_fields('qfield') as $field)
				{
					$data[$field]=$qfield->$field;
				}				
				foreach($this->db->list_fields('qfield') as $field)
				{
					$data[$field]=$qfield->$field;
				}		
			}
		}else{	
			foreach($this->db->list_fields('qfield') as $field)
			{
				$data[$field]="";
			}	
		}
		
		return $data;
	}
	
}
