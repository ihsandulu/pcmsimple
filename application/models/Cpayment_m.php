<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class cpayment_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		//cek invpayment
		if(isset($_POST['invpayment_id'])){
		$invpaymentd["invpayment_id"]=$this->input->post("invpayment_id");
		$us=$this->db
		->join("methodpayment","methodpayment.methodpayment_id=invpayment.methodpayment_id","left")
		->get_where('invpayment',$invpaymentd);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $invpayment){		
			foreach($this->db->list_fields('invpayment') as $field)
			{
				$data[$field]=$invpayment->$field;
			}		
			foreach($this->db->list_fields('methodpayment') as $field)
			{
				$data[$field]=$invpayment->$field;
			}	
		}
		}else{	
			 		
			
			foreach($this->db->list_fields('invpayment') as $field)
			{
				$data[$field]="";
			}	
			foreach($this->db->list_fields('methodpayment') as $field)
			{
				$data[$field]="";
			}		
			
		}
		}
		
		//upload image
		$data['uploadinvpayment_picture']="";
		if(isset($_FILES['invpayment_picture'])&&$_FILES['invpayment_picture']['name']!=""){
		$invpayment_picture=str_replace(' ', '_',$_FILES['invpayment_picture']['name']);
		$invpayment_picture = date("H_i_s_").$invpayment_picture;
		if(file_exists ('assets/images/invpayment_picture/'.$invpayment_picture)){
		unlink('assets/images/invpayment_picture/'.$invpayment_picture);
		}
		$config['file_name'] = $invpayment_picture;
		$config['upload_path'] = 'assets/images/invpayment_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('invpayment_picture'))
		{
			$data['uploadinvpayment_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadinvpayment_picture']="Upload Success !";
			$input['invpayment_picture']=$invpayment_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("invpayment",array("invpayment_id"=>$this->input->post("invpayment_id")));
			$this->db->delete("gudang",array("invpayment_id"=>$this->input->post("invpayment_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$this->db->insert("invpayment",$input);
			
			$gudang["payment_id"]=$this->input->post("payment_id");
			$gudang["gudang_qty"]=$this->input->post("invpayment_qty");
			$gudang["gudang_inout"]="out";
			$gudang["invpayment_id"]=$this->db->insert_id();
			$gudang["inv_no"]=$this->input->post("inv_no");
			$this->db->insert("gudang",$gudang);
			//echo $this->db->last_query();die;
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='invpayment_picture'){$input[$e]=$this->input->post($e);}}
			$this->db->update("invpayment",$input,array("invpayment_id"=>$this->input->post("invpayment_id")));
			
			
			$gudang["payment_id"]=$this->input->post("payment_id");
			$gudang["gudang_qty"]=$this->input->post("invpayment_qty");
			$this->db->update("gudang",$gudang,array("invpayment_id"=>$this->input->post("invpayment_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
