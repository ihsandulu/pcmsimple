<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class position_menu_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		//cek position_menu
		if(isset($_POST['new'])||isset($_POST['edit'])){
			$position_menud["position_menu_id"]=$this->input->post("position_menu_id");
			$us=$this->db
			->get_where('position_menu',$position_menud);	
			//echo $this->db->last_query();die;	
			if($us->num_rows()>0)
			{
				foreach($us->result() as $position_menu){		
				foreach($this->db->list_fields('position_menu') as $field)
				{
					$data[$field]=$position_menu->$field;
				}	
			}
			}else{	
						
				foreach($this->db->list_fields('position_menu') as $field)
				{
					$data[$field]="";
				}	
				
			}
		}
		
		//cek posisi
		$positiond["position_id"]=$this->input->get("position_id");
			$us=$this->db
			->get_where('position',$positiond);	
			//echo $this->db->last_query();die;	
			if($us->num_rows()>0)
			{
				foreach($us->result() as $position){		
				foreach($this->db->list_fields('position') as $field)
				{
					$data[$field]=$position->$field;
				}	
			}
			}else{	
						
				foreach($this->db->list_fields('position') as $field)
				{
					$data[$field]="";
				}	
				
			}
		
		//upload image
		$data['uploadposition_menu_picture']="";
		if(isset($_FILES['position_menu_picture'])&&$_FILES['position_menu_picture']['name']!=""){
		$position_menu_picture=str_replace(' ', '_',$_FILES['position_menu_picture']['name']);
		$position_menu_picture = date("H_i_s_").$position_menu_picture;
		if(file_exists ('assets/images/position_menu_picture/'.$position_menu_picture)){
		unlink('assets/images/position_menu_picture/'.$position_menu_picture);
		}
		$config['file_name'] = $position_menu_picture;
		$config['upload_path'] = 'assets/images/position_menu_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('position_menu_picture'))
		{
			$data['uploadposition_menu_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadposition_menu_picture']="Upload Success !";
			$input['position_menu_picture']=$position_menu_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("position_menu",array("position_menu_id"=>$this->input->post("position_menu_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			
				$this->db->insert("position_menu",$input);
				//echo $this->db->last_query();die;
		
			$data["message"]="Insert Data Success";
		}
		
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='position_menu_picture'){$input[$e]=$this->input->post($e);}}
			$input["position_menu_name"]=htmlentities($input["position_menu_name"], ENT_QUOTES);
			$this->db->update("position_menu",$input,array("position_menu_id"=>$this->input->post("position_menu_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
