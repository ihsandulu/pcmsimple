<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class invcost_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		//cek invcost
		if(isset($_POST['invcost_id'])){
		$invcostd["invcost_id"]=$this->input->post("invcost_id");
		$us=$this->db
		->get_where('invcost',$invcostd);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $invcost){		
				foreach($this->db->list_fields('invcost') as $field)
				{
					$data[$field]=$invcost->$field;
				}	
			}
		}else{	
			 		
			
			foreach($this->db->list_fields('invcost') as $field)
			{
				$data[$field]="";
			}		
			
		}
		}
		
		//upload image
		$data['uploadinvcost_picture']="";
		if(isset($_FILES['invcost_picture'])&&$_FILES['invcost_picture']['name']!=""){
		$invcost_picture=str_replace(' ', '_',$_FILES['invcost_picture']['name']);
		$invcost_picture = date("H_i_s_").$invcost_picture;
		if(file_exists ('assets/images/invcost_picture/'.$invcost_picture)){
		unlink('assets/images/invcost_picture/'.$invcost_picture);
		}
		$config['file_name'] = $invcost_picture;
		$config['upload_path'] = 'assets/images/invcost_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('invcost_picture'))
		{
			$data['uploadinvcost_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadinvcost_picture']="Upload Success !";
			$input['invcost_picture']=$invcost_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("invcost",array("invcost_id"=>$this->input->post("invcost_id")));
			$data["message"]="Delete Success";
		}
		
		//date payment
		if($this->input->post("create")=="OK"||$this->input->post("change")=="OK"){
		$dp=$this->db
		->where("invpayment_no",$this->input->post("invpayment_no"))
		->get("invpayment")
		->row()
		->invpayment_date;
		;
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}	
			
			$this->db->insert("invcost",$input);			
			
			//echo $this->db->last_query();die;
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='invcost_picture'){$input[$e]=$this->input->post($e);}}			
			$this->db->update("invcost",$input,array("invcost_id"=>$this->input->post("invcost_id")));			
			
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
