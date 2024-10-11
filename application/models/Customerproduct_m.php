<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class customerproduct_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		
		
		
		//cek customerproduct
		if(isset($_POST['customerproduct_id'])){	
			$customerproductd["customerproduct_id"]=$this->input->post("customerproduct_id");
			$us=$this->db
			->join("product","product.product_id=customerproduct.product_id","left")
			->join("customer","customer.customer_id=customerproduct.customer_id","left")
			->get_where('customerproduct',$customerproductd);	
			//echo $this->db->last_query();die;	
			if($us->num_rows()>0)
			{
				foreach($us->result() as $customerproduct){		
				foreach($this->db->list_fields('customerproduct') as $field)
				{
					$data[$field]=$customerproduct->$field;
				}		
				foreach($this->db->list_fields('product') as $field)
				{
					$data[$field]=$customerproduct->$field;
				}	
				foreach($this->db->list_fields('customer') as $field)
				{
					$data[$field]=$customerproduct->$field;
				}	
			}
			}else{	
						
				
				foreach($this->db->list_fields('customerproduct') as $field)
				{
					$data[$field]="";
				}	
				foreach($this->db->list_fields('product') as $field)
				{
					$data[$field]="";
				}	
				foreach($this->db->list_fields('customer') as $field)
				{
					$data[$field]="";
				}		
				
			}
		}
		
		//cek customer
		if(isset($_POST['customer_id'])){		
			$customerd["customer_id"]=$this->input->post("customer_id");
			$us=$this->db
			->get_where('customer',$customerd);	
			//echo $this->db->last_query();die;	
			if($us->num_rows()>0)
			{
				foreach($us->result() as $customerproduct){		
				
					foreach($this->db->list_fields('customer') as $field)
					{
						$data[$field]=$customerproduct->$field;
					}	
				}
			}else{	
				foreach($this->db->list_fields('customer') as $field)
				{
					$data[$field]="";
				}		
				
			}
		}
		
		//upload image
		$data['uploadcustomerproduct_picture']="";
		if(isset($_FILES['customerproduct_picture'])&&$_FILES['customerproduct_picture']['name']!=""){
		$customerproduct_picture=str_replace(' ', '_',$_FILES['customerproduct_picture']['name']);
		$customerproduct_picture = date("H_i_s_").$customerproduct_picture;
		if(file_exists ('assets/images/customerproduct_picture/'.$customerproduct_picture)){
		unlink('assets/images/customerproduct_picture/'.$customerproduct_picture);
		}
		$config['file_name'] = $customerproduct_picture;
		$config['upload_path'] = 'assets/images/customerproduct_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('customerproduct_picture'))
		{
			$data['uploadcustomerproduct_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadcustomerproduct_picture']="Upload Success !";
			$input['customerproduct_picture']=$customerproduct_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("customerproduct",array("customerproduct_id"=>$this->input->post("customerproduct_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$this->db->insert("customerproduct",$input);
			//echo $this->db->last_query();die;
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='customerproduct_picture'){$input[$e]=$this->input->post($e);}}
			$this->db->update("customerproduct",$input,array("customerproduct_id"=>$this->input->post("customerproduct_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
