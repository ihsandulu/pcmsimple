<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class supplierproduct_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		
		
		
		//cek supplierproduct
		if(isset($_POST['supplierproduct_id'])){	
			$supplierproductd["supplierproduct_id"]=$this->input->post("supplierproduct_id");
			$us=$this->db
			->join("product","product.product_id=supplierproduct.product_id","left")
			->join("supplier","supplier.supplier_id=supplierproduct.supplier_id","left")
			->get_where('supplierproduct',$supplierproductd);	
			//echo $this->db->last_query();die;	
			if($us->num_rows()>0)
			{
				foreach($us->result() as $supplierproduct){		
				foreach($this->db->list_fields('supplierproduct') as $field)
				{
					$data[$field]=$supplierproduct->$field;
				}		
				foreach($this->db->list_fields('product') as $field)
				{
					$data[$field]=$supplierproduct->$field;
				}	
				foreach($this->db->list_fields('supplier') as $field)
				{
					$data[$field]=$supplierproduct->$field;
				}	
			}
			}else{	
						
				
				foreach($this->db->list_fields('supplierproduct') as $field)
				{
					$data[$field]="";
				}	
				foreach($this->db->list_fields('product') as $field)
				{
					$data[$field]="";
				}	
				foreach($this->db->list_fields('supplier') as $field)
				{
					$data[$field]="";
				}		
				$data["product_buy"]="0";
			}
		}
		
		//cek supplier
		if(isset($_GET['supplier_id'])){		
			$supplierd["supplier_id"]=$this->input->get("supplier_id");
			$us=$this->db
			->get_where('supplier',$supplierd);	
			//echo $this->db->last_query();die;	
			if($us->num_rows()>0)
			{
				foreach($us->result() as $supplierproduct){		
				
					foreach($this->db->list_fields('supplier') as $field)
					{
						$data[$field]=$supplierproduct->$field;
					}	
				}
			}else{	
				foreach($this->db->list_fields('supplier') as $field)
				{
					$data[$field]="";
				}		
				
			}
		}
		
		//upload image
		$data['uploadsupplierproduct_picture']="";
		if(isset($_FILES['supplierproduct_picture'])&&$_FILES['supplierproduct_picture']['name']!=""){
		$supplierproduct_picture=str_replace(' ', '_',$_FILES['supplierproduct_picture']['name']);
		$supplierproduct_picture = date("H_i_s_").$supplierproduct_picture;
		if(file_exists ('assets/images/supplierproduct_picture/'.$supplierproduct_picture)){
		unlink('assets/images/supplierproduct_picture/'.$supplierproduct_picture);
		}
		$config['file_name'] = $supplierproduct_picture;
		$config['upload_path'] = 'assets/images/supplierproduct_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('supplierproduct_picture'))
		{
			$data['uploadsupplierproduct_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadsupplierproduct_picture']="Upload Success !";
			$input['supplierproduct_picture']=$supplierproduct_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("supplierproduct",array("supplierproduct_id"=>$this->input->post("supplierproduct_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$this->db->insert("supplierproduct",$input);
			$data["message"]="Insert Data Success";
		//echo $this->db->last_query();die;
		}
		
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='supplierproduct_picture'){$input[$e]=$this->input->post($e);}}
			$this->db->update("supplierproduct",$input,array("supplierproduct_id"=>$this->input->post("supplierproduct_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
