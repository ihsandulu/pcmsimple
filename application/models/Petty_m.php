<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class petty_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		//cek petty
		if(isset($_POST['petty_id'])){
		$pettyd["petty_id"]=$this->input->post("petty_id");
		$us=$this->db
		->join("customer","customer.customer_id=petty.customer_id","left")
		->get_where('petty',$pettyd);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $petty){		
				foreach($this->db->list_fields('petty') as $field)
				{
					$data[$field]=$petty->$field;
				}					
				foreach($this->db->list_fields('customer') as $field)
				{
					$data[$field]=$petty->$field;
				}				
			}
		}else{	
			 foreach($this->db->list_fields('petty') as $field)
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
		$data['uploadpetty_picture']="";
		if(isset($_FILES['petty_picture'])&&$_FILES['petty_picture']['name']!=""){
		$petty_picture=str_replace(' ', '_',$_FILES['petty_picture']['name']);
		$petty_picture = date("H_i_s_").$petty_picture;
		if(file_exists ('assets/images/petty_picture/'.$petty_picture)){
		unlink('assets/images/petty_picture/'.$petty_picture);
		}
		$config['file_name'] = $petty_picture;
		$config['upload_path'] = 'assets/images/petty_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('petty_picture'))
		{
			$data['uploadpetty_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadpetty_picture']="Upload Success !";
			$input['petty_picture']=$petty_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			if($this->input->post("kas_id")>0){$this->db->delete("kas",array("kas_id"=>$this->input->post("kas_id")));}	
			if(isset($_POST['customer_id'])&&$_POST['customer_id']>0){
				$saldo=$this->db
				->where("customer_id",$this->input->post("customer_id"))
				->get("customer")
				->row()
				->customer_saldo;
				$jmlsblm=$this->db
				->where("petty_id",$this->input->post("petty_id"))
				->get("petty")
				->row()
				->petty_amount;
				$inputcustomer["customer_saldo"]=$saldo-$jmlsblm;
				$wherecustomer["customer_id"]=$this->input->post("customer_id");
				$this->db->update("customer",$inputcustomer,$wherecustomer);
			}		
			$this->db->delete("petty",array("petty_id"=>$this->input->post("petty_id")));		
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){		
			foreach($this->input->post() as $e=>$f){
				if($e!='create'){
					$input[$e]=$this->input->post($e);				
				}
			}	
			
			//cek apakah diambil dari kas besar
			if($input["kas_id"]>-1){
				$inputkas["kas_count"]=$input["petty_amount"];
				$inputkas["kas_inout"]="out";
				$inputkas["kas_remarks"]=$input["petty_remarks"];
				$inputkas["kas_date"]=$input["petty_date"];
				$this->db->insert("kas",$inputkas);
				$input["kas_id"]=$this->db->insert_id();
			}
			if($input["kas_id"]==-2){
				$saldo=$this->db
				->where("customer_id",$this->input->post("customer_id"))
				->get("customer")
				->row()
				->customer_saldo;
				$inputcustomer["customer_saldo"]=$saldo+$this->input->post("petty_amount");
				$wherecustomer["customer_id"]=$this->input->post("customer_id");
				$this->db->update("customer",$inputcustomer,$wherecustomer);
			}
			$this->db->insert("petty",$input);			
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
			//cek apakah diambil dari kas besar
			if($input["kas_id"]!=-1){
				$inputkas["kas_count"]=$input["petty_amount"];
				$inputkas["kas_inout"]="out";
				$inputkas["kas_remarks"]=$input["petty_remarks"];
				$inputkas["kas_date"]=$input["petty_date"];
				if($input["kas_id"]>0){
					$this->db->update("kas",$inputkas,array("kas_id"=>$this->input->post("kas_id")));
				}else{
					$this->db->insert("kas",$inputkas);
					$input["kas_id"]=$this->db->insert_id();
				}
			}		
			if(isset($_POST['customer_id'])&&$_POST['customer_id']>0){
				$saldo=$this->db
				->where("customer_id",$this->input->post("customer_id"))
				->get("customer")
				->row()
				->customer_saldo;
				$jmlsblm=$this->db
				->where("petty_id",$input["petty_id"])
				->get("petty")
				->row()
				->petty_amount;
				$inputcustomer["customer_saldo"]=$saldo-$jmlsblm+$this->input->post("petty_amount");
				$wherecustomer["customer_id"]=$this->input->post("customer_id");
				$this->db->update("customer",$inputcustomer,$wherecustomer);
			}				
			$this->db->update("petty",$input,array("petty_id"=>$this->input->post("petty_id")));
			$data["message"]="Insert Data Success";
		}
		
		return $data;
	}
	
}
