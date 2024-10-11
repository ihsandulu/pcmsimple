<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class parameter_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		
		
		//cek parameter
		if(isset($_POST['new'])||isset($_POST['edit'])){
			$parameterd["parameter_id"]=$this->input->post("parameter_id");
			
			$us=$this->db
			->join("equipment","equipment.equip_id=parameter.equip_id","left")
			->join("header","header.header_id=equipment.header_id","left")
			->get_where('parameter',$parameterd);	
			//echo $this->db->last_query();die;	
			if($us->num_rows()>0)
			{
				foreach($us->result() as $parameter){	
				//$eq=$this->db->get_where("equipment",array("equip_id"=>$parameter->equip_id));
				//foreach($eq->result() as $equipment){
					foreach($this->db->list_fields('equipment') as $field)
					{
						$data[$field]=$parameter->$field;
					}	
					foreach($this->db->list_fields('header') as $field)
					{
						$data[$field]=$parameter->$field;
					}	
				//}
					foreach($this->db->list_fields('parameter') as $field)
					{
						$data[$field]=$parameter->$field;
					}		
				}
			}else{	
				 foreach($this->db->list_fields('equipment') as $field)
				{
					$data[$field]="";
				}	 
				foreach($this->db->list_fields('header') as $field)
				{
					$data[$field]="";
				}		
				foreach($this->db->list_fields('parameter') as $field)
				{
					$data[$field]="";
				}
			
			}
		}
		
		//upload image
		$data['uploadparameter_picture']="";
		if(isset($_FILES['parameter_picture'])&&$_FILES['parameter_picture']['name']!=""){
		$parameter_picture=str_replace(' ', '_',$_FILES['parameter_picture']['name']);
		$parameter_picture = date("H_i_s_").$parameter_picture;
		if(file_exists ('assets/images/parameter_picture/'.$parameter_picture)){
		unlink('assets/images/parameter_picture/'.$parameter_picture);
		}
		$config['file_name'] = $parameter_picture;
		$config['upload_path'] = 'assets/images/parameter_picture/';
		$config['allowed_parameters'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('parameter_picture'))
		{
			$data['uploadparameter_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadparameter_picture']="Upload Success !";
			$input['parameter_picture']=$parameter_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("parameter",array("parameter_id"=>$this->input->post("parameter_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$this->db->insert("parameter",$input);
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='parameter_picture'){$input[$e]=$this->input->post($e);}}
			$this->db->update("parameter",$input,array("parameter_id"=>$this->input->post("parameter_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
