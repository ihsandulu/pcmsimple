<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class vendorproduct_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		
		
		
		//cek vendorproduct
		if(isset($_POST['vendorproduct_id'])){	
			$vendorproductd["vendorproduct_id"]=$this->input->post("vendorproduct_id");
			$us=$this->db
			->join("product","product.product_id=vendorproduct.product_id","left")
			->join("vendor","vendor.vendor_id=vendorproduct.vendor_id","left")
			->get_where('vendorproduct',$vendorproductd);	
			//echo $this->db->last_query();die;	
			if($us->num_rows()>0)
			{
				foreach($us->result() as $vendorproduct){		
				foreach($this->db->list_fields('vendorproduct') as $field)
				{
					$data[$field]=$vendorproduct->$field;
				}		
				foreach($this->db->list_fields('product') as $field)
				{
					$data[$field]=$vendorproduct->$field;
				}	
				foreach($this->db->list_fields('vendor') as $field)
				{
					$data[$field]=$vendorproduct->$field;
				}	
			}
			}else{	
						
				
				foreach($this->db->list_fields('vendorproduct') as $field)
				{
					$data[$field]="";
				}	
				foreach($this->db->list_fields('product') as $field)
				{
					$data[$field]="";
				}	
				foreach($this->db->list_fields('vendor') as $field)
				{
					$data[$field]="";
				}		
				
			}
		}
		
		//cek vendor
		if(isset($_POST['vendor_id'])){		
			$vendord["vendor_id"]=$this->input->post("vendor_id");
			$us=$this->db
			->get_where('vendor',$vendord);	
			//echo $this->db->last_query();die;	
			if($us->num_rows()>0)
			{
				foreach($us->result() as $vendorproduct){		
				
					foreach($this->db->list_fields('vendor') as $field)
					{
						$data[$field]=$vendorproduct->$field;
					}	
				}
			}else{	
				foreach($this->db->list_fields('vendor') as $field)
				{
					$data[$field]="";
				}		
				
			}
		}
		
		//upload image
		$data['uploadvendorproduct_picture']="";
		if(isset($_FILES['vendorproduct_picture'])&&$_FILES['vendorproduct_picture']['name']!=""){
		$vendorproduct_picture=str_replace(' ', '_',$_FILES['vendorproduct_picture']['name']);
		$vendorproduct_picture = date("H_i_s_").$vendorproduct_picture;
		if(file_exists ('assets/images/vendorproduct_picture/'.$vendorproduct_picture)){
		unlink('assets/images/vendorproduct_picture/'.$vendorproduct_picture);
		}
		$config['file_name'] = $vendorproduct_picture;
		$config['upload_path'] = 'assets/images/vendorproduct_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('vendorproduct_picture'))
		{
			$data['uploadvendorproduct_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadvendorproduct_picture']="Upload Success !";
			$input['vendorproduct_picture']=$vendorproduct_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("vendorproduct",array("vendorproduct_id"=>$this->input->post("vendorproduct_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$this->db->insert("vendorproduct",$input);
			//echo $this->db->last_query();die;
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='vendorproduct_picture'){$input[$e]=$this->input->post($e);}}
			$this->db->update("vendorproduct",$input,array("vendorproduct_id"=>$this->input->post("vendorproduct_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
