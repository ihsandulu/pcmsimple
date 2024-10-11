<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class invproduct_M extends CI_Model {
	
		
		function kuren_url()
		{
			$CI =& get_instance();
		
			$url = $CI->config->site_url($CI->uri->uri_string());
			return $_SERVER['QUERY_STRING'] ? $url.'?'.$_SERVER['QUERY_STRING'] : $url;
		}
		
	public function data()
	{
	
		require_once("meta_m.php");
			
		$data=array();	
		$data["message"]="";
		//cek invproduct
		if(isset($_POST['invproduct_id'])){
		$invproductd["invproduct_id"]=$this->input->post("invproduct_id");
		$us=$this->db
		->join("product","product.product_id=invproduct.product_id","left")
		->get_where('invproduct',$invproductd);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $invproduct){		
			foreach($this->db->list_fields('invproduct') as $field)
			{
				$data[$field]=$invproduct->$field;
			}		
			foreach($this->db->list_fields('product') as $field)
			{
				$data[$field]=$invproduct->$field;
			}	
		}
		}else{	
			 		
			
			foreach($this->db->list_fields('invproduct') as $field)
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
		$data['uploadinvproduct_picture']="";
		if(isset($_FILES['invproduct_picture'])&&$_FILES['invproduct_picture']['name']!=""){
		$invproduct_picture=str_replace(' ', '_',$_FILES['invproduct_picture']['name']);
		$invproduct_picture = date("H_i_s_").$invproduct_picture;
		if(file_exists ('assets/images/invproduct_picture/'.$invproduct_picture)){
		unlink('assets/images/invproduct_picture/'.$invproduct_picture);
		}
		$config['file_name'] = $invproduct_picture;
		$config['upload_path'] = 'assets/images/invproduct_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('invproduct_picture'))
		{
			$data['uploadinvproduct_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadinvproduct_picture']="Upload Success !";
			$input['invproduct_picture']=$invproduct_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("invproduct",array("invproduct_id"=>$this->input->post("invproduct_id")));
			if($identity->identity_stok==1){
				$this->db->delete("gudang",array("gudang_id"=>$this->input->post("gudang_id")));
			}
			$data["message"]="Delete Success";
		}
		
		//insert BAP
		if($this->input->post("bap")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			
			$bap["bap_qty"]=$input["invproduct_qty"];
			$bap["bap_price"]=$input["invproduct_price"];
			$bap["bap_remarks"]=$input["bap_remarks"];
			$bap["product_id"]=$input["product_id"];
			$this->db->insert("bap",$bap);
			
			$where["invproduct_id"]=$input["invproduct_id"];
			$this->db->delete("invproduct",$where);
			//echo $this->db->last_query();die;
			redirect("invproduct?inv_no=".$this->input->get("inv_no")."&customer_id=".$this->input->get("customer_id"));
			$data["message"]="Insert Data Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			
			if($identity->identity_stok==1){
				$gudang["gudang_qty"]=$input["invproduct_qty"];
				$gudang["gudang_inout"]="out";
				$gudang["gudang_keterangan"]="Invoice".$input["inv_no"];
				$gudang["product_id"]=$input["product_id"];
				$gudang["inv_no"]=$this->input->get("inv_no");
				$this->db->insert("gudang",$gudang);
			}
			if($input["invproduct_qty"]<0.01){$input["invproduct_qty"]=1;}
			$input["gudang_id"]=$this->db->insert_id();
			$this->db->insert("invproduct",$input);
			//echo $this->db->last_query();die;
			redirect($this->kuren_url());
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='invproduct_picture'){$input[$e]=$this->input->post($e);}}
			if($input["invproduct_qty"]<0.01){$input["invproduct_qty"]=1;}
			$this->db->update("invproduct",$input,array("invproduct_id"=>$this->input->post("invproduct_id")));
			
			if($identity->identity_stok==1){
				$gudang["gudang_qty"]=$input["invproduct_qty"];
				$gudang["gudang_inout"]="out";
				$gudang["gudang_keterangan"]="Invoice".$input["inv_no"];
				$gudang["product_id"]=$input["product_id"];
				$where["gudang_id"]=$input["gudang_id"];
				redirect($this->kuren_url());
				$this->db->update("gudang",$gudang,$where);
			}
			
			
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
