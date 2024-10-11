<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class product_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		//cek product
		$productd["product_id"]=$this->input->post("product_id");
		$us=$this->db
		->join("unit","unit.unit_id=product.unit_id","left")
		->get_where('product',$productd);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $product){		
			foreach($this->db->list_fields('product') as $field)
			{
				$data[$field]=$product->$field;
			}		
			foreach($this->db->list_fields('unit') as $field)
			{
				$data[$field]=$product->$field;
			}	
		}
		}else{	
			 		
			
			foreach($this->db->list_fields('product') as $field)
			{
				$data[$field]="";
			}	
			foreach($this->db->list_fields('unit') as $field)
			{
				$data[$field]="";
			}		
			
		}
		
		//upload image
		$data['uploadproduct_picture']="";
		if(isset($_FILES['product_picture'])&&$_FILES['product_picture']['name']!=""){
		$product_picture=str_replace(' ', '_',$_FILES['product_picture']['name']);
		$product_picture = date("H_i_s_").$product_picture;
		if(file_exists ('assets/images/product_picture/'.$product_picture)){
		unlink('assets/images/product_picture/'.$product_picture);
		}
		$config['file_name'] = $product_picture;
		$config['upload_path'] = 'assets/images/product_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('product_picture'))
		{
			$data['uploadproduct_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadproduct_picture']="Upload Success !";
			$input['product_picture']=$product_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("product",array("product_id"=>$this->input->post("product_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$this->db->insert("product",$input);
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='product_picture'){$input[$e]=$this->input->post($e);}}
			$input["product_name"]=htmlentities($input["product_name"], ENT_QUOTES);
			$this->db->update("product",$input,array("product_id"=>$this->input->post("product_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
