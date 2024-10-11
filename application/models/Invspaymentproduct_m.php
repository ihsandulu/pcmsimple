<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class invspaymentproduct_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		//cek invspaymentproduct
		if(isset($_POST['invspaymentproduct_id'])){
		$invspaymentproductd["invspaymentproduct_id"]=$this->input->post("invspaymentproduct_id");
		$us=$this->db
		->get_where('invspaymentproduct',$invspaymentproductd);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $invspaymentproduct){		
				foreach($this->db->list_fields('invspaymentproduct') as $field)
				{
					$data[$field]=$invspaymentproduct->$field;
				}	
			}
		}else{	
			 		
			
			foreach($this->db->list_fields('invspaymentproduct') as $field)
			{
				$data[$field]="";
			}		
			
		}
		}
		
		//upload image
		$data['uploadinvspaymentproduct_picture']="";
		if(isset($_FILES['invspaymentproduct_picture'])&&$_FILES['invspaymentproduct_picture']['name']!=""){
		$invspaymentproduct_picture=str_replace(' ', '_',$_FILES['invspaymentproduct_picture']['name']);
		$invspaymentproduct_picture = date("H_i_s_").$invspaymentproduct_picture;
		if(file_exists ('assets/images/invspaymentproduct_picture/'.$invspaymentproduct_picture)){
		unlink('assets/images/invspaymentproduct_picture/'.$invspaymentproduct_picture);
		}
		$config['file_name'] = $invspaymentproduct_picture;
		$config['upload_path'] = 'assets/images/invspaymentproduct_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('invspaymentproduct_picture'))
		{
			$data['uploadinvspaymentproduct_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadinvspaymentproduct_picture']="Upload Success !";
			$input['invspaymentproduct_picture']=$invspaymentproduct_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			if($this->input->post("invspaymentproduct_source")=="kas_id"){
				$this->db->delete("kas",array("kas_id"=>$this->input->post("kas_id")));
			}else{
				$this->db->delete("petty",array("petty_id"=>$this->input->post("petty_id")));
			}
			//echo $this->db->last_query();die;
			$this->db->delete("invspaymentproduct",array("invspaymentproduct_id"=>$this->input->post("invspaymentproduct_id")));
			echo $data["message"]="Delete Success";
		}
		
		//date payment
		if($this->input->post("cu")=="create"||$this->input->post("cu")=="change"){
		$dp=$this->db
		->where("invspayment_no",$this->input->post("invspayment_no"))
		->get("invspayment")
		->row()
		->invspayment_date;
		;
		}
		
		//insert
		if($this->input->post("cu")=="create"){
			foreach($this->input->post() as $e=>$f){if($e!='cu'){$input[$e]=$this->input->post($e);}}
			
			$project_id=$this->db
			->where("invspayment_no",$this->input->get("invspayment_no"))
			->get("invspayment")
			->row()
			->project_id;
			
			if($input["invspaymentproduct_source"]=="kas_id"){
				$inputkas["kas_count"]=$input["invspaymentproduct_amount"]*$input["invspaymentproduct_qty"];
				$inputkas["kas_inout"]="out";
				$inputkas["kas_remarks"]=$input["invspaymentproduct_description"];
				$inputkas["kas_date"]=$dp;
				$inputkas["project_id"]=$project_id;
				$inputkas["biaya_id"]=$input["biaya_id"];
				$this->db->insert("kas",$inputkas);	
				$input["kas_id"]=$this->db->insert_id();
			}
			
			if($input["invspaymentproduct_source"]=="petty_id"){
				$inputpetty["petty_amount"]=$input["invspaymentproduct_amount"]*$input["invspaymentproduct_qty"];
				$inputpetty["petty_inout"]="out";
				$inputpetty["petty_remarks"]=$input["invspaymentproduct_description"];
				$inputpetty["petty_date"]=$dp;
				$inputpetty["project_id"]=$project_id;
				$inputpetty["biaya_id"]=$input["biaya_id"];
				$this->db->insert("petty",$inputpetty);	
				$input["petty_id"]=$this->db->insert_id();
			}
			
			$this->db->insert("invspaymentproduct",$input);			
			
			//echo $this->db->last_query();die;
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("cu")=="change"){
			foreach($this->input->post() as $e=>$f){if($e!='cu'&&$e!='invspaymentproduct_picture'){$input[$e]=$this->input->post($e);}}
			
			$project_id=$this->db
			->where("invspayment_no",$this->input->get("invspayment_no"))
			->get("invspayment")
			->row()
			->project_id;
			
			if($input["invspaymentproduct_source"]=="kas_id"){
				$inputkas["kas_count"]=$input["invspaymentproduct_amount"]*$input["invspaymentproduct_qty"];
				$inputkas["kas_inout"]="out";
				$inputkas["kas_remarks"]=$input["invspaymentproduct_description"];
				$inputkas["kas_date"]=$dp;
				$inputkas["project_id"]=$project_id;
				$inputkas["biaya_id"]=$input["biaya_id"];
				if($input["kas_id"]!="0"){
				$this->db->update("kas",$inputkas,array("kas_id"=>$input["kas_id"]));	
				}else{
				$this->db->insert("kas",$inputkas);	
				$input["kas_id"]=$this->db->insert_id();
				}
			}
			
			if($input["invspaymentproduct_source"]=="petty_id"){
				$inputpetty["petty_amount"]=$input["invspaymentproduct_amount"]*$input["invspaymentproduct_qty"];
				$inputpetty["petty_inout"]="out";
				$inputpetty["petty_remarks"]=$input["invspaymentproduct_description"];
				$inputpetty["petty_date"]=$dp;
				$inputpetty["project_id"]=$project_id;
				$inputpetty["biaya_id"]=$input["biaya_id"];
				if($input["petty_id"]!="0"){
				$this->db->update("petty",$inputpetty,array("petty_id"=>$input["petty_id"]));	
				}else{
				$this->db->insert("petty",$inputpetty);	
				$input["petty_id"]=$this->db->insert_id();
				}
			}
			
			
			$this->db->update("invspaymentproduct",$input,array("invspaymentproduct_id"=>$this->input->post("invspaymentproduct_id")));			
			
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
