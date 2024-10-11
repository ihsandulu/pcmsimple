<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class equipment_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";	
		session_write_close();
		//cek equipment
		$equipmentd["equip_id"]=$this->input->post("equip_id");
		$us=$this->db
		->get_where('equipment',$equipmentd);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $equipment){				
			foreach($this->db->list_fields('equipment') as $field)
			{
				$data[$field]=$equipment->$field;
			}			
		}
		}else{	
		
			foreach($this->db->list_fields('equipment') as $field)
			{
				$data[$field]="";
			}	
			
		}
		
		//upload image
		$data['uploadequipment_picture']="";
		if(isset($_FILES['equipment_picture'])&&$_FILES['equipment_picture']['name']!=""){
		$equipment_picture=str_replace(' ', '_',$_FILES['equipment_picture']['name']);
		$equipment_picture = date("H_i_s_").$equipment_picture;
		if(file_exists ('assets/images/equipment_picture/'.$equipment_picture)){
		unlink('assets/images/equipment_picture/'.$equipment_picture);
		}
		$config['file_name'] = $equipment_picture;
		$config['upload_path'] = 'assets/images/equipment_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('equipment_picture'))
		{
			$data['uploadequipment_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadequipment_picture']="Upload Success !";
			$input['equipment_picture']=$equipment_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("equipment",array("equip_id"=>$this->input->post("equip_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$this->db->insert("equipment",$input);
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='equipment_picture'){$input[$e]=$this->input->post($e);}}
			$this->db->update("equipment",$input,array("equip_id"=>$this->input->post("equip_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
