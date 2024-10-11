<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class sjmasuk_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		//cek sjmasuk
		if(isset($_POST['sjmasuk_id'])){
		$sjmasukd["sjmasuk_id"]=$this->input->post("sjmasuk_id");
		$us=$this->db
		->get_where('sjmasuk',$sjmasukd);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $sjmasuk){		
				foreach($this->db->list_fields('sjmasuk') as $field)
				{
					$data[$field]=$sjmasuk->$field;
				}				
			}
		}else{	
			 		
			
			foreach($this->db->list_fields('sjmasuk') as $field)
			{
				$data[$field]="";
			}		
			
		}
		}
		
		//upload image
		$data['uploadsjmasuk_picture']="";
		if(isset($_FILES['sjmasuk_picture'])&&$_FILES['sjmasuk_picture']['name']!=""){
		$sjmasuk_picture=str_replace(' ', '_',$_FILES['sjmasuk_picture']['name']);
		$sjmasuk_picture = date("H_i_s_").$sjmasuk_picture;
		if(file_exists ('assets/images/sjmasuk_picture/'.$sjmasuk_picture)){
		unlink('assets/images/sjmasuk_picture/'.$sjmasuk_picture);
		}
		$config['file_name'] = $sjmasuk_picture;
		$config['upload_path'] = 'assets/images/sjmasuk_picture/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('sjmasuk_picture'))
		{
			$data['uploadsjmasuk_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadsjmasuk_picture']="Upload Success !";
			$input['sjmasuk_picture']=$sjmasuk_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$cek=$this->db
			->where("sjmasuk_no",$this->input->post("sjmasuk_no"))
			->get("sjmasukproduct");
			if($cek>0){$data["message"]="Silahkan delete terlebih dahulu semua product di List Product";}else{
				$this->db->delete("sjmasuk",array("sjmasuk_no"=>$this->input->post("sjmasuk_no")));
				$this->db->delete("sjmasukproduct",array("sjmasuk_no"=>$this->input->post("sjmasuk_no")));
				$this->db->update("invs",array("sjmasuk_no"=>"","sjmasuk_id"=>"0"),array("sjmasuk_no"=>$this->input->post("sjmasuk_no")));
				$this->db->update("invsproduct",array("sjmasuk_id"=>"0"),array("sjmasuk_id"=>$this->input->post("sjmasuk_id")));
				$data["message"]="Delete Success";
			}
		}
		
		//insert
		if($this->input->post("create")=="OK"){		
		
			foreach($this->input->post() as $e=>$f){
			if($e!='create'){
				$input[$e]=$this->input->post($e);				
				}
			}
			$this->db->insert("sjmasuk",$input);			
			//echo $this->db->last_query();die;
			
			$data["message"]="Insert Data Success";
		}
		
		//update
		if($this->input->post("change")=="OK"){
		
			foreach($this->input->post() as $e=>$f){
			if($e!='change'){
				$input[$e]=$this->input->post($e);				
				}
			}			
			$this->db->update("sjmasuk",$input,array("sjmasuk_id"=>$this->input->post("sjmasuk_id")));
			$data["message"]="Insert Data Success";
		}
		
		return $data;
	}
	
}
