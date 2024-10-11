<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class spayment_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		//cek invspayment
		if(isset($_POST['invspayment_id'])){
		$invspaymentd["invspayment_id"]=$this->input->post("invspayment_id");
		$us=$this->db
		->join("methodpayment","methodpayment.methodpayment_id=invspayment.methodpayment_id","left")
		->get_where('invspayment',$invspaymentd);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $invspayment){		
			foreach($this->db->list_fields('invspayment') as $field)
			{
				$data[$field]=$invspayment->$field;
			}		
			foreach($this->db->list_fields('methodpayment') as $field)
			{
				$data[$field]=$invspayment->$field;
			}	
		}
		}else{	
			 		
			
			foreach($this->db->list_fields('invspayment') as $field)
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
		$data['uploadinvspayment_picture']="";
		if(isset($_FILES['invspayment_picture'])&&$_FILES['invspayment_picture']['name']!=""){
		$invspayment_picture=str_replace(' ', '_',$_FILES['invspayment_picture']['name']);
		$invspayment_picture = date("H_i_s_").$invspayment_picture;
		if(file_exists ('assets/images/invspayment_picture/'.$invspayment_picture)){
		unlink('assets/images/invspayment_picture/'.$invspayment_picture);
		}
		$config['file_name'] = $invspayment_picture;
		$config['upload_path'] = 'assets/images/invspayment_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('invspayment_picture'))
		{
			$data['uploadinvspayment_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadinvspayment_picture']="Upload Success !";
			$input['invspayment_picture']=$invspayment_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("invspayment",array("invspayment_id"=>$this->input->post("invspayment_id")));
			$this->db->delete("gudang",array("invspayment_id"=>$this->input->post("invspayment_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$this->db->insert("invspayment",$input);
			
			$gudang["payment_id"]=$this->input->post("payment_id");
			$gudang["gudang_qty"]=$this->input->post("invspayment_qty");
			$gudang["gudang_inout"]="out";
			$gudang["invspayment_id"]=$this->db->insert_id();
			$gudang["invs_no"]=$this->input->post("invs_no");
			$this->db->insert("gudang",$gudang);
			//echo $this->db->last_query();die;
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='invspayment_picture'){$input[$e]=$this->input->post($e);}}
			$this->db->update("invspayment",$input,array("invspayment_id"=>$this->input->post("invspayment_id")));
			
			
			$gudang["payment_id"]=$this->input->post("payment_id");
			$gudang["gudang_qty"]=$this->input->post("invspayment_qty");
			$this->db->update("gudang",$gudang,array("invspayment_id"=>$this->input->post("invspayment_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
