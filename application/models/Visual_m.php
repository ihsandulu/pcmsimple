<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class monitoring_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";	
		session_write_close();
		//cek type
		$monitoringd["monitoring_id"]=$this->input->post("visual_id");
		$us=$this->db
		->get_where('visual',$visuald);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $visual){		
			foreach($this->db->list_fields('visual') as $field)
			{
				$data[$field]=$visual->$field;
			}		
		}
		}else{	
			 		
			foreach($this->db->list_fields('visual') as $field)
			{
				$data[$field]="";
			}
			
		}
		
		//upload image
		$data['uploadvisual_picture']="";
		if(isset($_FILES['visual_picture'])&&$_FILES['visual_picture']['name']!=""){
		$visual_picture=str_replace(' ', '_',$_FILES['visual_picture']['name']);
		$visual_picture = date("H_i_s_").$visual_picture;
		if(file_exists ('assets/images/visual_picture/'.$visual_picture)){
		unlink('assets/images/visual_picture/'.$visual_picture);
		}
		$config['file_name'] = $visual_picture;
		$config['upload_path'] = 'assets/images/visual_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('visual_picture'))
		{
			$data['uploadvisual_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadvisual_picture']="Upload Success !";
			$input['visual_picture']=$visual_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("visual",array("visual_id"=>$this->input->post("visual_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$this->db->insert("visual",$input);
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='visual_picture'){$input[$e]=$this->input->post($e);}}
			$this->db->update("visual",$input,array("visual_id"=>$this->input->post("visual_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
