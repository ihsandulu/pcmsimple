<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class poproduct_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		//cek poproduct
		if(isset($_POST['poproduct_id'])){
		$poproductd["poproduct_id"]=$this->input->post("poproduct_id");
		$us=$this->db
		->join("product","product.product_id=poproduct.product_id","left")
		->get_where('poproduct',$poproductd);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $poproduct){		
			foreach($this->db->list_fields('poproduct') as $field)
			{
				$data[$field]=$poproduct->$field;
			}		
			foreach($this->db->list_fields('product') as $field)
			{
				$data[$field]=$poproduct->$field;
			}	
		}
		}else{	
			 		
			
			foreach($this->db->list_fields('poproduct') as $field)
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
		$data['uploadpoproduct_picture']="";
		if(isset($_FILES['poproduct_picture'])&&$_FILES['poproduct_picture']['name']!=""){
		$poproduct_picture=str_replace(' ', '_',$_FILES['poproduct_picture']['name']);
		$poproduct_picture = date("H_i_s_").$poproduct_picture;
		if(file_exists ('assets/images/poproduct_picture/'.$poproduct_picture)){
		unlink('assets/images/poproduct_picture/'.$poproduct_picture);
		}
		$config['file_name'] = $poproduct_picture;
		$config['upload_path'] = 'assets/images/poproduct_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('poproduct_picture'))
		{
			$data['uploadpoproduct_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadpoproduct_picture']="Upload Success !";
			$input['poproduct_picture']=$poproduct_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("poproduct",array("poproduct_id"=>$this->input->post("poproduct_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$this->db->insert("poproduct",$input);
			//echo $this->db->last_query();die;
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='poproduct_picture'){$input[$e]=$this->input->post($e);}}
			$this->db->update("poproduct",$input,array("poproduct_id"=>$this->input->post("poproduct_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
