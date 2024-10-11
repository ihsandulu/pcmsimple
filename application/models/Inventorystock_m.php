<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class inventorystock_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		//cek inventorylog
		$inventorylogd["inventorylog_id"]=$this->input->post("inventorylog_id");
		$us=$this->db
		->get_where('inventorylog',$inventorylogd);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $inventorylog){		
			foreach($this->db->list_fields('inventorylog') as $field)
			{
				$data[$field]=$inventorylog->$field;
			}				foreach($this->db->list_fields('inventorylog') as $field)
			{
				$data[$field]=$inventorylog->$field;
			}		
		}
		}else{	
			 		
			
			foreach($this->db->list_fields('inventorylog') as $field)
			{
				$data[$field]="";
			}		
			
		}
		
		//upload image
		$data['uploadinventorylog_picture']="";
		if(isset($_FILES['inventorylog_picture'])&&$_FILES['inventorylog_picture']['name']!=""){
		$inventorylog_picture=str_replace(' ', '_',$_FILES['inventorylog_picture']['name']);
		$inventorylog_picture = date("H_i_s_").$inventorylog_picture;
		if(file_exists ('assets/images/inventorylog_picture/'.$inventorylog_picture)){
		unlink('assets/images/inventorylog_picture/'.$inventorylog_picture);
		}
		$config['file_name'] = $inventorylog_picture;
		$config['upload_path'] = 'assets/images/inventorylog_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('inventorylog_picture'))
		{
			$data['uploadinventorylog_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadinventorylog_picture']="Upload Success !";
			$input['inventorylog_picture']=$inventorylog_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("inventorylog",array("inventorylog_id"=>$this->input->post("inventorylog_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$this->db->insert("inventorylog",$input);
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='inventorylog_picture'){$input[$e]=$this->input->post($e);}}
			$this->db->update("inventorylog",$input,array("inventorylog_id"=>$this->input->post("inventorylog_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
