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
		$monitoringd["monitoring_id"]=$this->input->post("monitoring_id");
		$us=$this->db
		->get_where('monitoring',$monitoringd);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $monitoring){		
			foreach($this->db->list_fields('monitoring') as $field)
			{
				$data[$field]=$monitoring->$field;
			}		
		}
		}else{	
			 		
			foreach($this->db->list_fields('monitoring') as $field)
			{
				$data[$field]="";
			}
			
		}
		
		//upload image
		$data['uploadmonitoring_picture']="";
		if(isset($_FILES['monitoring_picture'])&&$_FILES['monitoring_picture']['name']!=""){
		$monitoring_picture=str_replace(' ', '_',$_FILES['monitoring_picture']['name']);
		$monitoring_picture = date("H_i_s_").$monitoring_picture;
		if(file_exists ('assets/images/monitoring_picture/'.$monitoring_picture)){
		unlink('assets/images/monitoring_picture/'.$monitoring_picture);
		}
		$config['file_name'] = $monitoring_picture;
		$config['upload_path'] = 'assets/images/monitoring_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('monitoring_picture'))
		{
			$data['uploadmonitoring_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadmonitoring_picture']="Upload Success !";
			$input['monitoring_picture']=$monitoring_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("monitoring",array("monitoring_id"=>$this->input->post("monitoring_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$this->db->insert("monitoring",$input);
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='monitoring_picture'){$input[$e]=$this->input->post($e);}}
			$this->db->update("monitoring",$input,array("monitoring_id"=>$this->input->post("monitoring_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
