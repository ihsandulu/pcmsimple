<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class sjkeluarproduct_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		
		$identity=$this->db->get("identity")->row();
		
		
		//cek sjkeluarproduct
		if(isset($_POST['sjkeluarproduct_id'])){
		$sjkeluarproductd["sjkeluarproduct_id"]=$this->input->post("sjkeluarproduct_id");
		$us=$this->db
		->join("product","product.product_id=sjkeluarproduct.product_id","left")
		->get_where('sjkeluarproduct',$sjkeluarproductd);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $sjkeluarproduct){		
			foreach($this->db->list_fields('sjkeluarproduct') as $field)
			{
				$data[$field]=$sjkeluarproduct->$field;
			}		
			foreach($this->db->list_fields('product') as $field)
			{
				$data[$field]=$sjkeluarproduct->$field;
			}	
		}
		}else{	
			 		
			
			foreach($this->db->list_fields('sjkeluarproduct') as $field)
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
		$data['uploadsjkeluarproduct_picture']="";
		if(isset($_FILES['sjkeluarproduct_picture'])&&$_FILES['sjkeluarproduct_picture']['name']!=""){
		$sjkeluarproduct_picture=str_replace(' ', '_',$_FILES['sjkeluarproduct_picture']['name']);
		$sjkeluarproduct_picture = date("H_i_s_").$sjkeluarproduct_picture;
		if(file_exists ('assets/images/sjkeluarproduct_picture/'.$sjkeluarproduct_picture)){
		unlink('assets/images/sjkeluarproduct_picture/'.$sjkeluarproduct_picture);
		}
		$config['file_name'] = $sjkeluarproduct_picture;
		$config['upload_path'] = 'assets/images/sjkeluarproduct_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('sjkeluarproduct_picture'))
		{
			$data['uploadsjkeluarproduct_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadsjkeluarproduct_picture']="Upload Success !";
			$input['sjkeluarproduct_picture']=$sjkeluarproduct_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("sjkeluarproduct",array("sjkeluarproduct_id"=>$this->input->post("sjkeluarproduct_id")));
			
			if($identity->identity_stok==0){
				$this->db->delete("gudang",array("sjkeluarproduct_id"=>$this->input->post("sjkeluarproduct_id")));
			}
			
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$this->db->insert("sjkeluarproduct",$input);
			
			if($identity->identity_stok==0){
				$gudang["product_id"]=$this->input->post("product_id");
				$gudang["gudang_qty"]=$this->input->post("sjkeluarproduct_qty");
				$gudang["gudang_inout"]="out";
				$gudang["branch_id"]=$this->session->userdata("branch_id");
				$gudang["sjkeluarproduct_id"]=$this->db->insert_id();
				$gudang["sjkeluar_no"]=$this->input->post("sjkeluar_no");
				$this->db->insert("gudang",$gudang);
			}
			//echo $this->db->last_query();die;
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='sjkeluarproduct_picture'){$input[$e]=$this->input->post($e);}}
			$this->db->update("sjkeluarproduct",$input,array("sjkeluarproduct_id"=>$this->input->post("sjkeluarproduct_id")));
			
			
			if($identity->identity_stok==0){
				$gudang["product_id"]=$this->input->post("product_id");
				$gudang["gudang_qty"]=$this->input->post("sjkeluarproduct_qty");
				$gudang["branch_id"]=$this->session->userdata("branch_id");
				$this->db->update("gudang",$gudang,array("sjkeluarproduct_id"=>$this->input->post("sjkeluarproduct_id")));
			}
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
