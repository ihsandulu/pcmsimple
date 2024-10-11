<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class invsproduct_M extends CI_Model {
	
	public function data()
	{	
		require_once("meta_m.php");
		
		$data=array();	
		$data["message"]="";
		//cek invsproduct
		if(isset($_POST['invsproduct_id'])){
		$invsproductd["invsproduct_id"]=$this->input->post("invsproduct_id");
		$us=$this->db
		->join("product","product.product_id=invsproduct.product_id","left")
		->get_where('invsproduct',$invsproductd);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $invsproduct){		
			foreach($this->db->list_fields('invsproduct') as $field)
			{
				$data[$field]=$invsproduct->$field;
			}		
			foreach($this->db->list_fields('product') as $field)
			{
				$data[$field]=$invsproduct->$field;
			}	
		}
		}else{	
			 		
			
			foreach($this->db->list_fields('invsproduct') as $field)
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
		$data['uploadinvsproduct_picture']="";
		if(isset($_FILES['invsproduct_picture'])&&$_FILES['invsproduct_picture']['name']!=""){
		$invsproduct_picture=str_replace(' ', '_',$_FILES['invsproduct_picture']['name']);
		$invsproduct_picture = date("H_i_s_").$invsproduct_picture;
		if(file_exists ('assets/images/invsproduct_picture/'.$invsproduct_picture)){
		unlink('assets/images/invsproduct_picture/'.$invsproduct_picture);
		}
		$config['file_name'] = $invsproduct_picture;
		$config['upload_path'] = 'assets/images/invsproduct_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('invsproduct_picture'))
		{
			$data['uploadinvsproduct_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadinvsproduct_picture']="Upload Success !";
			$input['invsproduct_picture']=$invsproduct_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("invsproduct",array("invsproduct_id"=>$this->input->post("invsproduct_id")));
			if($identity->identity_stok==1){
				$this->db->delete("gudang",array("gudang_id"=>$this->input->post("gudang_id")));
			}
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			
			if($identity->identity_stok==1){
				$gudang["gudang_qty"]=$input["invsproduct_qty"];
				$gudang["gudang_inout"]="in";
				$gudang["gudang_keterangan"]="Invoice".$input["invs_no"];
				$gudang["product_id"]=$input["product_id"];
				$this->db->insert("gudang",$gudang);
			}
			
			$input["gudang_id"]=$this->db->insert_id();
			$this->db->insert("invsproduct",$input);
			//echo $this->db->last_query();die;
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='invsproduct_picture'){$input[$e]=$this->input->post($e);}}
			$this->db->update("invsproduct",$input,array("invsproduct_id"=>$this->input->post("invsproduct_id")));
			
			if($identity->identity_stok==1){
				$gudang["gudang_qty"]=$input["invsproduct_qty"];
				$gudang["gudang_inout"]="in";
				$gudang["gudang_keterangan"]="Invoice".$input["invs_no"];
				$gudang["product_id"]=$input["product_id"];
				$where["gudang_id"]=$input["gudang_id"];
				$this->db->update("gudang",$gudang,$where);
			}
			
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
