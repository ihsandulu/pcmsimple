<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class subparameter_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		
		
		//cek subparameter
		if(isset($_POST['new'])||isset($_POST['edit'])){
			$subparameterd["subparameter_id"]=$this->input->post("subparameter_id");
			
			$us=$this->db
			->join("parameter","parameter.parameter_id=subparameter.parameter_id","left")
			->join("equipment","equipment.equip_id=parameter.equip_id","left")
			->get_where('subparameter',$subparameterd);	
			//echo $this->db->last_query();die;	
			if($us->num_rows()>0)
			{
				foreach($us->result() as $subparameter){	
				//$eq=$this->tt->get_where("equipment",array("equip_id"=>$subparameter->equip_id));
				//foreach($eq->result() as $equipment){
					foreach($this->tt->list_fields('equipment') as $field)
					{
						$data[$field]=$subparameter->$field;
					}	
				//}
					foreach($this->db->list_fields('parameter') as $field)
					{
						$data[$field]=$subparameter->$field;
					}
					foreach($this->db->list_fields('subparameter') as $field)
					{
						$data[$field]=$subparameter->$field;
					}	
				}
			}else{	
				 foreach($this->tt->list_fields('equipment') as $field)
				{
					$data[$field]="";
				}		
				foreach($this->db->list_fields('parameter') as $field)
				{
					$data[$field]="";
				}
				foreach($this->db->list_fields('subparameter') as $field)
				{
					$data[$field]="";
				}
			}
		}
		
		//upload image
		$data['uploadsubparameter_picture']="";
		if(isset($_FILES['subparameter_picture'])&&$_FILES['subparameter_picture']['name']!=""){
		$subparameter_picture=str_replace(' ', '_',$_FILES['subparameter_picture']['name']);
		$subparameter_picture = date("H_i_s_").$subparameter_picture;
		if(file_exists ('assets/images/subparameter_picture/'.$subparameter_picture)){
		unlink('assets/images/subparameter_picture/'.$subparameter_picture);
		}
		$config['file_name'] = $subparameter_picture;
		$config['upload_path'] = 'assets/images/subparameter_picture/';
		$config['allowed_subparameters'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('subparameter_picture'))
		{
			$data['uploadsubparameter_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadsubparameter_picture']="Upload Success !";
			$input['subparameter_picture']=$subparameter_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("subparameter",array("subparameter_id"=>$this->input->post("subparameter_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$this->db->insert("subparameter",$input);
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='subparameter_picture'){$input[$e]=$this->input->post($e);}}
			$this->db->update("subparameter",$input,array("subparameter_id"=>$this->input->post("subparameter_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
