<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class methodpayment_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		//cek methodpayment
		if(isset($_POST['methodpayment_id'])){
		$methodpaymentd["methodpayment_id"]=$this->input->post("methodpayment_id");
		$us=$this->db
		->get_where('methodpayment',$methodpaymentd);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $methodpayment){		
				foreach($this->db->list_fields('methodpayment') as $field)
				{
					$data[$field]=$methodpayment->$field;
				}				
			}
		}else{	
			 		
			
			foreach($this->db->list_fields('methodpayment') as $field)
			{
				$data[$field]="";
			}		
			
		}
		}
		
		//upload image
		$data['uploadmethodpayment_picture']="";
		if(isset($_FILES['methodpayment_picture'])&&$_FILES['methodpayment_picture']['name']!=""){
		$methodpayment_picture=str_replace(' ', '_',$_FILES['methodpayment_picture']['name']);
		$methodpayment_picture = date("H_i_s_").$methodpayment_picture;
		if(file_exists ('assets/images/methodpayment_picture/'.$methodpayment_picture)){
		unlink('assets/images/methodpayment_picture/'.$methodpayment_picture);
		}
		$config['file_name'] = $methodpayment_picture;
		$config['upload_path'] = 'assets/images/methodpayment_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('methodpayment_picture'))
		{
			$data['uploadmethodpayment_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadmethodpayment_picture']="Upload Success !";
			$input['methodpayment_picture']=$methodpayment_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("methodpayment",array("methodpayment_id"=>$this->input->post("methodpayment_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){		
		$sjno=$this->db
		->order_by("methodpayment_id","desc")
		->limit("1")
		->get("methodpayment");
		if($sjno->num_rows()>0){
		$methodpayment_id=$sjno->row()->methodpayment_id;
		$methodpayment_id="SJK".str_pad(substr($methodpayment_id,3)+1,5,"0",STR_PAD_LEFT);
		}else{
		$methodpayment_id="SJK00001";
		}
			$input["methodpayment_id"]=$methodpayment_id;
			foreach($this->input->post() as $e=>$f){
			if($e!='create'){
				$input[$e]=$this->input->post($e);				
				}
			}
			$this->db->insert("methodpayment",$input);			
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
			$this->db->update("methodpayment",$input,array("methodpayment_id"=>$this->input->post("methodpayment_id")));
			$data["message"]="Insert Data Success";
		}
		
		return $data;
	}
	
}
