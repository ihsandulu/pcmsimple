<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class quotationproduct_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		$identity=$this->db->get("identity")->row();
		//cek quotationproduct
		if(isset($_POST['quotationproduct_id'])){
		$quotationproductd["quotationproduct_id"]=$this->input->post("quotationproduct_id");
		$us=$this->db
		->join("product","product.product_id=quotationproduct.product_id","left")
		->get_where('quotationproduct',$quotationproductd);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $quotationproduct){		
			foreach($this->db->list_fields('quotationproduct') as $field)
			{
				$data[$field]=$quotationproduct->$field;
			}		
			foreach($this->db->list_fields('product') as $field)
			{
				$data[$field]=$quotationproduct->$field;
			}	
		}
		}else{	
			 		
			
			foreach($this->db->list_fields('quotationproduct') as $field)
			{
				$data[$field]="";
			}	
			foreach($this->db->list_fields('product') as $field)
			{
				$data[$field]="";
			}		
			
		}
		}
		
		//upload image
		$data['uploadquotationproduct_picture']="";
		if(isset($_FILES['quotationproduct_picture'])&&$_FILES['quotationproduct_picture']['name']!=""){
		$quotationproduct_picture=str_replace(' ', '_',$_FILES['quotationproduct_picture']['name']);
		$quotationproduct_picture = date("H_i_s_").$quotationproduct_picture;
		if(file_exists ('assets/images/quotationproduct_picture/'.$quotationproduct_picture)){
		unlink('assets/images/quotationproduct_picture/'.$quotationproduct_picture);
		}
		$config['file_name'] = $quotationproduct_picture;
		$config['upload_path'] = 'assets/images/quotationproduct_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('quotationproduct_picture'))
		{
			$data['uploadquotationproduct_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadquotationproduct_picture']="Upload Success !";
			$input['quotationproduct_picture']=$quotationproduct_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			if($identity->identity_lockproduct==1){
			$product_id=$this->db
			->where("quotationproduct_id",$this->input->post("quotationproduct_id"))
			->get("quotationproduct")
			->row()
			->product_id;
			
			$inputd["product_id"]=$product_id;
			$inputd["customer_id"]=$this->input->get('customer_id');
			$inputd["user_id"]=$this->session->userdata("user_id");
			$this->db->delete("access",$inputd);
			}
			
			$this->db->delete("quotationproduct",array("quotationproduct_id"=>$this->input->post("quotationproduct_id")));
			
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			
			if($identity->identity_lockproduct==1){
				$access=$this->db
				->where("product_id",$input['product_id'])
				->where("customer_id",$this->input->get('customer_id'))
				->get("access");
				//echo $this->db->last_query();die;
				$user_id=0; $ada=0;
				if($access->num_rows()>0){
					$user_id=$access->row()->user_id;
					$ada=1;
				}
				//echo $ada."==".$user_id."==".$this->session->userdata("user_id");die;
				if($ada==0||($ada==1&&$user_id==$this->session->userdata("user_id"))){
					$this->db->insert("quotationproduct",$input);
					if($ada==0){
						$inputa["product_id"]=$input['product_id'];
						$inputa["customer_id"]=$this->input->get('customer_id');
						$inputa["user_id"]=$this->session->userdata("user_id");
						$this->db->insert("access",$inputa);
					}
					//echo $this->db->last_query();die;
					$data["message"]="Insert Data Success";
				}else{
					$data["message"]="Product is not allowed";
				}
			}else{
				$this->db->insert("quotationproduct",$input);
				$data["message"]="Insert Data Success";
			}
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='quotationproduct_picture'){$input[$e]=$this->input->post($e);}}
			if($identity->identity_lockproduct==1){
				$access=$this->db
				->where("product_id",$input['product_id'])
				->where("customer_id",$this->input->get('customer_id'))
				->get("access");
				//echo $this->db->last_query();
				$user_id=0; $ada=0;
				if($access->num_rows()>0){
					$user_id=$access->row()->user_id;
					$ada=1;
				}
				//echo $ada."==".$user_id."==".$this->session->userdata("user_id");die;
				if($ada==0||($ada==1&&$user_id==$this->session->userdata("user_id"))){
					$product_id=$this->db
					->where("quotationproduct_id",$this->input->post("quotationproduct_id"))
					->get("quotationproduct")
					->row()
					->product_id;
					$this->db->update("quotationproduct",$input,array("quotationproduct_id"=>$this->input->post("quotationproduct_id")));
					$data["message"]="Update Success";
					//echo $this->db->last_query();die;
					if($ada==0){
						$inputd["product_id"]=$product_id;
						$inputd["customer_id"]=$this->input->get('customer_id');
						$inputd["user_id"]=$this->session->userdata("user_id");
						$this->db->delete("access",$inputd);
						$inputa["product_id"]=$input['product_id'];
						$inputa["customer_id"]=$this->input->get('customer_id');
						$inputa["user_id"]=$this->session->userdata("user_id");
						$this->db->insert("access",$inputa);
					}
				}else{
					$data["message"]="Product is not allowed";
				}
			}else{			
				$this->db->update("quotationproduct",$input,array("quotationproduct_id"=>$this->input->post("quotationproduct_id")));
				$data["message"]="Update Success";
			}
		}
		return $data;
	}
	
}
