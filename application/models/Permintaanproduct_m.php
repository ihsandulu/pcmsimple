<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class permintaanproduct_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		
		$identity=$this->db->get("identity")->row();
		
		
		//cek permintaanproduct
		if(isset($_POST['permintaanproduct_id'])){
		$permintaanproductd["permintaanproduct_id"]=$this->input->post("permintaanproduct_id");
		$us=$this->db
		->join("project","project.project_id=permintaanproduct.project_id","left")
		->join("product","product.product_id=permintaanproduct.product_id","left")
		->get_where('permintaanproduct',$permintaanproductd);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $permintaanproduct){		
			foreach($this->db->list_fields('permintaanproduct') as $field)
			{
				$data[$field]=$permintaanproduct->$field;
			}		
			foreach($this->db->list_fields('product') as $field)
			{
				$data[$field]=$permintaanproduct->$field;
			}			
			foreach($this->db->list_fields('project') as $field)
			{
				$data[$field]=$permintaanproduct->$field;
			}	
		}
		}else{	
			 		
			
			foreach($this->db->list_fields('permintaanproduct') as $field)
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
		
		//upload image
		$data['uploadpermintaanproduct_picture']="";
		if(isset($_FILES['permintaanproduct_picture'])&&$_FILES['permintaanproduct_picture']['name']!=""){
		$permintaanproduct_picture=str_replace(' ', '_',$_FILES['permintaanproduct_picture']['name']);
		$permintaanproduct_picture = date("H_i_s_").$permintaanproduct_picture;
		if(file_exists ('assets/images/permintaanproduct_picture/'.$permintaanproduct_picture)){
		unlink('assets/images/permintaanproduct_picture/'.$permintaanproduct_picture);
		}
		$config['file_name'] = $permintaanproduct_picture;
		$config['upload_path'] = 'assets/images/permintaanproduct_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('permintaanproduct_picture'))
		{
			$data['uploadpermintaanproduct_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadpermintaanproduct_picture']="Upload Success !";
			$input['permintaanproduct_picture']=$permintaanproduct_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("permintaanproduct",array("permintaanproduct_id"=>$this->input->post("permintaanproduct_id")));
			
			if($identity->identity_stok==0){
				$this->db->delete("gudang",array("permintaanproduct_id"=>$this->input->post("permintaanproduct_id")));
			}
			
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$this->db->insert("permintaanproduct",$input);
			
			
			//echo $this->db->last_query();die;
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='permintaanproduct_picture'){$input[$e]=$this->input->post($e);}}
			$this->db->update("permintaanproduct",$input,array("permintaanproduct_id"=>$this->input->post("permintaanproduct_id")));
			
			
			
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
