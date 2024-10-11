<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class pocproduct_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		//cek pocproduct
		if(isset($_POST['pocproduct_id'])){
		$pocproductd["pocproduct_id"]=$this->input->post("pocproduct_id");
		$us=$this->db
		->join("product","product.product_id=pocproduct.product_id","left")
		->get_where('pocproduct',$pocproductd);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $pocproduct){		
			foreach($this->db->list_fields('pocproduct') as $field)
			{
				$data[$field]=$pocproduct->$field;
			}		
			foreach($this->db->list_fields('product') as $field)
			{
				$data[$field]=$pocproduct->$field;
			}	
		}
		}else{	
			 		
			
			foreach($this->db->list_fields('pocproduct') as $field)
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
		$data['uploadpocproduct_picture']="";
		if(isset($_FILES['pocproduct_picture'])&&$_FILES['pocproduct_picture']['name']!=""){
		$pocproduct_picture=str_replace(' ', '_',$_FILES['pocproduct_picture']['name']);
		$pocproduct_picture = date("H_i_s_").$pocproduct_picture;
		if(file_exists ('assets/images/pocproduct_picture/'.$pocproduct_picture)){
		unlink('assets/images/pocproduct_picture/'.$pocproduct_picture);
		}
		$config['file_name'] = $pocproduct_picture;
		$config['upload_path'] = 'assets/images/pocproduct_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('pocproduct_picture'))
		{
			$data['uploadpocproduct_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadpocproduct_picture']="Upload Success !";
			$input['pocproduct_picture']=$pocproduct_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("pocproduct",array("pocproduct_id"=>$this->input->post("pocproduct_id")));
			$this->db->delete("gudang",array("pocproduct_id"=>$this->input->post("pocproduct_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$this->db->insert("pocproduct",$input);
			
			$gudang["product_id"]=$this->input->post("product_id");
			$gudang["gudang_qty"]=$this->input->post("pocproduct_qty");
			$gudang["gudang_inout"]="out";
			$gudang["pocproduct_id"]=$this->db->insert_id();
			$gudang["poc_no"]=$this->input->post("poc_no");
			$this->db->insert("gudang",$gudang);
			//echo $this->db->last_query();die;
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='pocproduct_picture'){$input[$e]=$this->input->post($e);}}
			$this->db->update("pocproduct",$input,array("pocproduct_id"=>$this->input->post("pocproduct_id")));
			
			
			$gudang["product_id"]=$this->input->post("product_id");
			$gudang["gudang_qty"]=$this->input->post("pocproduct_qty");
			$this->db->update("gudang",$gudang,array("pocproduct_id"=>$this->input->post("pocproduct_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
