<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class invpayment_M extends CI_Model {
	
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
		$config['allowed_types'] = 'gif|jpg|jpeg|png|xls|xlsx|pdf|doc|docx';
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
			//cek ada data produk nggak
			$c=$this->db
			->where("invpayment_no",$this->input->post("invpayment_no"))
			->get("invpaymentproduct");
			if($c->num_rows()>0){
			$data["message"]="Please delete the product data first!";
			}else{
			$this->db->delete("invpayment",array("invpayment_id"=>$this->input->post("invpayment_id")));
			$data["message"]="Delete Success";
			}
		}
			
		//bulan romawi		
		$array_bulan = array(1=>"I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
		$bulan = $array_bulan[date('n')];
		
		//insert
		if($this->input->post("create")=="OK"){
			$nosura=$this->db
			->where("nomor_name","Payment Invoice Customer")
			->get("nomor");
			if($nosura->num_rows()>0){
				$nosurat=$nosura->row()->nomor_no."-";
			}else{
				$nosurat="PIC-";
			}
			
			$quno=$this->db
			->order_by("invpayment_id","desc")
			->limit("1")
			->get("invpayment");
			if($quno->num_rows()>0){
				//caribulan
				$terakhir=$quno->row()->invpayment_no;
				$blno=explode("-",$terakhir);
				$blnno=$blno[1];
				$noterakhir=end($blno);
				if($blnno!=$bulan){
					$inno=1;
				}else{
					$inno=$noterakhir+1;
					//$inno=1;
				}
			}else{
				$inno=1;
			}
			$sno=$nosurat.$bulan.date("-Y-").str_pad($inno,5,"0",STR_PAD_LEFT);
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$input["invpayment_no"]=$sno;
			$this->db->insert("invpayment",$input);
			//echo $this->db->last_query();die();
			header("Location:".current_url()."?".$_SERVER['QUERY_STRING']);
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='invpayment_picture'){$input[$e]=$this->input->post($e);}}
			//cek nomor payment ada nggak
			$cp=$this->db
			->where("invpayment_id",$this->input->post("invpayment_id"))
			->get("invpayment");
			if($cp->row()->invpayment_no==""){$input["invpayment_no"]=$invpayment_no;}
			$this->db->update("invpayment",$input,array("invpayment_id"=>$this->input->post("invpayment_id")));			
			
		
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		
		///////////////////////////////////////////////////////////
		
		//cek invpaymentproduct
		if(isset($_POST['invpaymentproduct_id'])){
		$invpaymentproductd["invpaymentproduct_id"]=$this->input->post("invpaymentproduct_id");
		$us=$this->db
		->get_where('invpaymentproduct',$invpaymentproductd);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $invpaymentproduct){		
				foreach($this->db->list_fields('invpaymentproduct') as $field)
				{
					$data[$field]=$invpaymentproduct->$field;
				}	
			}
		}else{	
			 		
			
			foreach($this->db->list_fields('invpaymentproduct') as $field)
			{
				$data[$field]="";
			}		
			
		}
		}
		
		//delete
		if($this->input->post("delete")=="OK"){
			if($this->input->post("invpaymentproduct_source")=="kas_id"){
				$this->db->delete("kas",array("kas_id"=>$this->input->post("kas_id")));
			}else{
				$this->db->delete("petty",array("petty_id"=>$this->input->post("petty_id")));
			}
			//echo $this->db->last_query();die;
			$this->db->delete("invpaymentproduct",array("invpaymentproduct_id"=>$this->input->post("invpaymentproduct_id")));
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
						
			$projectid=$this->db
			->join("inv","inv.inv_no=invpayment.inv_no","left")
			->where("invpayment_no",$this->input->get("invpayment_no"))
			->limit(1)
			->get("invpayment");
			if($projectid->num_rows()>0){$project_id=$projectid->row()->project_id;}else{$project_id=0;}
			
			if($input["invpaymentproduct_source"]=="kas_id"){
				$inputkas["kas_count"]=$input["invpaymentproduct_amount"]*$input["invpaymentproduct_qty"];
				$inputkas["kas_inout"]="in";
				$inputkas["kas_remarks"]=$input["invpaymentproduct_description"];
				$inputkas["kas_date"]=$dp;
				$inputkas["project_id"]=$project_id;
				$this->db->insert("kas",$inputkas);	
				$input["kas_id"]=$this->db->insert_id();
			}
			
			if($input["invpaymentproduct_source"]=="petty_id"){
				$inputpetty["petty_amount"]=$input["invpaymentproduct_amount"]*$input["invpaymentproduct_qty"];
				$inputpetty["petty_inout"]="in";
				$inputpetty["petty_remarks"]=$input["invpaymentproduct_description"];
				$inputpetty["petty_date"]=$dp;
				$inputpetty["project_id"]=$project_id;
				$this->db->insert("petty",$inputpetty);	
				$input["petty_id"]=$this->db->insert_id();
			}
			
			$this->db->insert("invpaymentproduct",$input);			
			
			//echo $this->db->last_query();die;
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='invpaymentproduct_picture'){$input[$e]=$this->input->post($e);}}
			
			
			$projectid=$this->db
			->join("inv","inv.inv_no=invpayment.inv_no","left")
			->where("invpayment_no",$this->input->get("invpayment_no"))
			->limit(1)
			->get("invpayment");
			if($projectid->num_rows()>0){$project_id=$projectid->row()->project_id;}else{$project_id=0;}
			
			
			if($input["invpaymentproduct_source"]=="kas_id"){
				$inputkas["kas_count"]=$input["invpaymentproduct_amount"]*$input["invpaymentproduct_qty"];
				$inputkas["kas_inout"]="in";
				$inputkas["kas_remarks"]=$input["invpaymentproduct_description"];
				$inputkas["kas_date"]=$dp;
				$inputkas["project_id"]=$project_id;
				if($input["kas_id"]!="0"){
				$this->db->update("kas",$inputkas,array("kas_id"=>$input["kas_id"]));	
				}else{
				$this->db->insert("kas",$inputkas);	
				$input["kas_id"]=$this->db->insert_id();
				}
			}
			
			if($input["invpaymentproduct_source"]=="petty_id"){
				$inputpetty["petty_amount"]=$input["invpaymentproduct_amount"]*$input["invpaymentproduct_qty"];
				$inputpetty["petty_inout"]="in";
				$inputpetty["petty_remarks"]=$input["invpaymentproduct_description"];
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
			
			
			$this->db->update("invpaymentproduct",$input,array("invpaymentproduct_id"=>$this->input->post("invpaymentproduct_id")));			
			
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		
		return $data;
	}
	
}
