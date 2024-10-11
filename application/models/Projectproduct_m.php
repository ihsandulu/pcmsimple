<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class projectproduct_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		
		
		
		//cek projectproduct
		if(isset($_POST['projectproduct_id'])){	
			$projectproductd["projectproduct_id"]=$this->input->post("projectproduct_id");
			$us=$this->db
			->join("product","product.product_id=projectproduct.product_id","left")
			->join("project","project.project_id=projectproduct.project_id","left")
			->get_where('projectproduct',$projectproductd);	
			//echo $this->db->last_query();die;	
			if($us->num_rows()>0)
			{
				foreach($us->result() as $projectproduct){		
				foreach($this->db->list_fields('projectproduct') as $field)
				{
					$data[$field]=$projectproduct->$field;
				}		
				foreach($this->db->list_fields('product') as $field)
				{
					$data[$field]=$projectproduct->$field;
				}	
				foreach($this->db->list_fields('project') as $field)
				{
					$data[$field]=$projectproduct->$field;
				}	
			}
			}else{	
						
				
				foreach($this->db->list_fields('projectproduct') as $field)
				{
					$data[$field]="";
				}	
				foreach($this->db->list_fields('product') as $field)
				{
					$data[$field]="";
				}	
				foreach($this->db->list_fields('project') as $field)
				{
					$data[$field]="";
				}		
				
			}
		}
		
		//cek project
		if(isset($_POST['project_id'])){		
			$projectd["project_id"]=$this->input->post("project_id");
			$us=$this->db
			->get_where('project',$projectd);	
			//echo $this->db->last_query();die;	
			if($us->num_rows()>0)
			{
				foreach($us->result() as $projectproduct){		
				
					foreach($this->db->list_fields('project') as $field)
					{
						$data[$field]=$projectproduct->$field;
					}	
				}
			}else{	
				foreach($this->db->list_fields('project') as $field)
				{
					$data[$field]="";
				}		
				
			}
		}
		
		//upload image
		$data['uploadprojectproduct_picture']="";
		if(isset($_FILES['projectproduct_picture'])&&$_FILES['projectproduct_picture']['name']!=""){
		$projectproduct_picture=str_replace(' ', '_',$_FILES['projectproduct_picture']['name']);
		$projectproduct_picture = date("H_i_s_").$projectproduct_picture;
		if(file_exists ('assets/images/projectproduct_picture/'.$projectproduct_picture)){
		unlink('assets/images/projectproduct_picture/'.$projectproduct_picture);
		}
		$config['file_name'] = $projectproduct_picture;
		$config['upload_path'] = 'assets/images/projectproduct_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('projectproduct_picture'))
		{
			$data['uploadprojectproduct_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadprojectproduct_picture']="Upload Success !";
			$input['projectproduct_picture']=$projectproduct_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("projectproduct",array("projectproduct_id"=>$this->input->post("projectproduct_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$this->db->insert("projectproduct",$input);
			//echo $this->db->last_query();die;
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='projectproduct_picture'){$input[$e]=$this->input->post($e);}}
			$this->db->update("projectproduct",$input,array("projectproduct_id"=>$this->input->post("projectproduct_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
