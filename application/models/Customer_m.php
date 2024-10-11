<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class customer_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		//cek customer
		$customerd["customer_id"]=$this->input->post("customer_id");
		$us=$this->db
		->get_where('customer',$customerd);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $customer){		
			foreach($this->db->list_fields('customer') as $field)
			{
				$data[$field]=$customer->$field;
			}				foreach($this->db->list_fields('customer') as $field)
			{
				$data[$field]=$customer->$field;
			}		
		}
		}else{	
			 		
			
			foreach($this->db->list_fields('customer') as $field)
			{
				$data[$field]="";
			}		
			
		}
		
		//upload image
		$data['uploadcustomer_picture']="";
		if(isset($_FILES['customer_picture'])&&$_FILES['customer_picture']['name']!=""){
		$customer_picture=str_replace(' ', '_',$_FILES['customer_picture']['name']);
		$customer_picture = date("H_i_s_").$customer_picture;
		if(file_exists ('assets/images/customer_picture/'.$customer_picture)){
		unlink('assets/images/customer_picture/'.$customer_picture);
		}
		$config['file_name'] = $customer_picture;
		$config['upload_path'] = 'assets/images/customer_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('customer_picture'))
		{
			$data['uploadcustomer_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadcustomer_picture']="Upload Success !";
			$input['customer_picture']=$customer_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("customer",array("customer_id"=>$this->input->post("customer_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$this->db->insert("customer",$input);
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='customer_picture'){$input[$e]=$this->input->post($e);}}
			$input["customer_name"]=htmlentities($input["customer_name"], ENT_QUOTES);
			$this->db->update("customer",$input,array("customer_id"=>$this->input->post("customer_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
