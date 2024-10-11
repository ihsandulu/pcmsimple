<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class grupd_M extends CI_Model {

	public function ulang($b){
		$input["grup_id"]=$this->input->post("grup_id");			
		$input["customer_id"]=$b;
		$this->db->insert("grupd",$input);
		//echo $this->db->last_query(); die();
		
		$data["message"]="Insert Data Success";
		return $data["message"];
	}
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		
		//cek identity
		$identity=$this->db->get_where('identity');	
		if($identity->num_rows()>0)
		{
			foreach($identity->result() as $identity){		
						
				foreach($this->db->list_fields('identity') as $field)
				{
					$data[$field]=$identity->$field;
				}		
			}
		}else{				
			
			foreach($this->db->list_fields('identity') as $field)
			{
				$data[$field]="";
			}					
		}
		
		//cek grup
		$grupid["grup_id"]=$this->input->get("grup_id");
		$us=$this->db
		->get_where('grup',$grupid);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $grup){		
						
				foreach($this->db->list_fields('grup') as $field)
				{
					$data[$field]=$grup->$field;
				}		
			}
		}else{				
			
			foreach($this->db->list_fields('grup') as $field)
			{
				$data[$field]="";
			}					
		}
		
		//cek grupd
		if(isset($_POST['grupd_id'])){
			$grupdid["grupd_id"]=$this->input->post("grupd_id");
			$us=$this->db
			->join("customer","customer.customer_id=grupd.customer_id","left")
			->get_where('grupd',$grupdid);	
			//echo $this->db->last_query();die;	
			if($us->num_rows()>0)
			{
				foreach($us->result() as $grupd){	
					foreach($this->db->list_fields('grupd') as $field)
					{
						$data[$field]=$grupd->$field;
					}			
							
					foreach($this->db->list_fields('customer') as $field)
					{
						$data[$field]=$grupd->$field;
					}		
				}
			}else{		
				foreach($this->db->list_fields('grupd') as $field)
				{
					$data[$field]="";
				}		
				foreach($this->db->list_fields('customer') as $field)
				{
					$data[$field]="";
				}					
			}
		}
		
		//upload image
		$data['uploadgrupd_picture']="";
		if(isset($_FILES['grupd_picture'])&&$_FILES['grupd_picture']['name']!=""){
		$grupd_picture=str_replace(' ', '_',$_FILES['grupd_picture']['name']);
		$grupd_picture = date("H_i_s_").$grupd_picture;
		if(file_exists ('assets/images/grupd_picture/'.$grupd_picture)){
		unlink('assets/images/grupd_picture/'.$grupd_picture);
		}
		$config['file_name'] = $grupd_picture;
		$config['upload_path'] = 'assets/images/grupd_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('grupd_picture'))
		{
			$data['uploadgrupd_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadgrupd_picture']="Upload Success !";
			$input['grupd_picture']=$grupd_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("grupd",array("grupd_id"=>$this->input->post("grupd_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){	
			$customer_id=$this->input->post("customer_id");
			if($this->input->post("pilihcustomer")=="banyak"){
				foreach($customer_id as $a=>$b){
					$this->ulang($b);
				}		
			}else{
				$this->ulang($customer_id);
			}
		}
		
		
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='grupd_picture'){$input[$e]=$this->input->post($e);}}
		
			$this->db->update("grupd",$input,array("grupd_id"=>$this->input->post("grupd_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
