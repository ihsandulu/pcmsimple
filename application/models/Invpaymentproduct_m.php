<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class invpaymentproduct_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		$identity=$this->db->get("identity")->row();
		//cek invpaymentproduct
		$data["tagihan"]=0;
		if(isset($_POST['invpaymentproduct_id'])){
			//tagihan
			if($identity->identity_project==1){
				$this->db->join("project","project.project_id=inv.project_id","left");
			}
			$inva=$this->db
			->where("inv_no",$this->input->get("inv_no"))
			->get("inv");
			
			$tagihan=$this->db
			->where("inv_no",$this->input->get("inv_no"))
			->get("invproduct");
			//pembayaran total
			$pembayaran=$this->db
			->select("SUM(invpaymentproduct_qty*invpaymentproduct_amount)AS pembayaran")
			->join("invpaymentproduct","invpaymentproduct.invpayment_no=invpayment.invpayment_no","left")
			->where("inv_no",$this->input->get("inv_no"))
			->get("invpayment");
			//echo $this->db->last_query();die;	
			if($pembayaran->num_rows()>0){$bayaran=$pembayaran->row()->pembayaran;}else{$bayaran=0;}
			$data["tagihan"]=0;
			$to=0;
			if($inva->num_rows()>0){
				if($identity->identity_project==1){
					$project_budget=$inva->row()->project_budget;
				}
				$inv_showproduct=$inva->row()->inv_showproduct;
				$discount=$inva->row()->inv_discount;
				if($inva->row()->inv_ppn==1){
					$inv_ppn=10/100;
				}else{
					$inv_ppn=0;
				}
				if($inva->row()->inv_pph==1){
					$inv_pph=2/100;
				}else{
					$inv_pph=0;
				}
			}else{
				$inv_showproduct=0;
				$discount=0;
				$inv_ppn=0;
				$inv_pph=0;
				$project_budget=0;
			}
			if($inv_showproduct<=1){
				foreach($tagihan->result() as $i){
					$to+=($i->invproduct_qty*$i->invproduct_price);
				}
			}else{
				$to=$project_budget;
			}
			
			$to-=$discount;
			$inv_ppn=$to*$inv_ppn;
			$invoice=$to+$inv_ppn;
			
			if(isset($_POST['edit'])){
				//pembayaran sekarang
				$pembayaransekarang=$this->db
				->where("invpaymentproduct_id",$this->input->post("invpaymentproduct_id"))
				->get("invpaymentproduct")
				->row()
				->invpaymentproduct_amount;
				$data["tagihan"]=($invoice)-($bayaran)+($pembayaransekarang);
			}else{
				$data["tagihan"]=($invoice)-($bayaran);
			}
			
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
		$data['cukup']=0;
		if($identity->identity_saldocustomer==1){
			$data["customer_saldo"]=$this->db
			->where("customer_id",$_GET['customer_id'])
			->get("customer")
			->row()
			->customer_saldo;
			if($data["customer_saldo"]>$data["tagihan"]){$data['cukup']=1;}
		}
		
		//upload image
		$data['uploadinvpaymentproduct_picture']="";
		if(isset($_FILES['invpaymentproduct_picture'])&&$_FILES['invpaymentproduct_picture']['name']!=""){
		$invpaymentproduct_picture=str_replace(' ', '_',$_FILES['invpaymentproduct_picture']['name']);
		$invpaymentproduct_picture = date("H_i_s_").$invpaymentproduct_picture;
		if(file_exists ('assets/images/invpaymentproduct_picture/'.$invpaymentproduct_picture)){
		unlink('assets/images/invpaymentproduct_picture/'.$invpaymentproduct_picture);
		}
		$config['file_name'] = $invpaymentproduct_picture;
		$config['upload_path'] = 'assets/images/invpaymentproduct_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('invpaymentproduct_picture'))
		{
			$data['uploadinvpaymentproduct_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadinvpaymentproduct_picture']="Upload Success !";
			$input['invpaymentproduct_picture']=$invpaymentproduct_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			if($this->input->post("invpaymentproduct_source")=="kas_id"){
				$this->db->delete("kas",array("kas_id"=>$this->input->post("kas_id")));
			}else{
				$this->db->delete("petty",array("petty_id"=>$this->input->post("petty_id")));
			}
			if($identity->identity_saldocustomer==1){
				$customer_saldo=$this->db
				->where("customer_id",$this->input->get("customer_id"))
				->get("customer")
				->row()
				->customer_saldo;
				$pembayaran=$this->db
				->select("SUM(invpaymentproduct_amount*invpaymentproduct_qty)AS pembayaran")
				->where("invpaymentproduct_id",$this->input->post("invpaymentproduct_id"))
				->get("invpaymentproduct")
				->row()
				->pembayaran;
				$icustomer["customer_saldo"]=$customer_saldo+$pembayaran;
				$wcustomer["customer_id"]=$this->input->get("customer_id");
				$this->db->update("customer",$icustomer,$wcustomer);
				//echo $this->db->last_query();die;
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
			
			if(isset($_POST['invpaymentproduct_source'])&&$input["invpaymentproduct_source"]=="kas_id"){
							
				$inputkas["kas_count"]=$input["invpaymentproduct_amount"]*$input["invpaymentproduct_qty"];
				$inputkas["kas_inout"]="in";
				$inputkas["kas_remarks"]=$input["invpaymentproduct_description"];
				$inputkas["kas_date"]=$dp;
				$inputkas["project_id"]=$project_id;
				if($identity->identity_saldocustomer==1){
					$inputkas["customer_id"]=$this->input->get("customer_id");
				}
				$this->db->insert("kas",$inputkas);	
				//echo $this->db->last_query();die;
				$input["kas_id"]=$this->db->insert_id();
			}
			
			if(isset($_POST['invpaymentproduct_source'])&&$input["invpaymentproduct_source"]=="petty_id"){
				$inputpetty["petty_amount"]=$input["invpaymentproduct_amount"]*$input["invpaymentproduct_qty"];
				$inputpetty["petty_inout"]="in";
				$inputpetty["petty_remarks"]=$input["invpaymentproduct_description"];
				$inputpetty["petty_date"]=$dp;
				$inputpetty["project_id"]=$project_id;
				if($identity->identity_saldocustomer==1){
					$inputpetty["kas_id"]=-2;
					$inputpetty["customer_id"]=$this->input->get("customer_id");
				}
				$this->db->insert("petty",$inputpetty);	
				$input["petty_id"]=$this->db->insert_id();
			}
			//echo $this->db->last_query();die;
			
			if($identity->identity_saldocustomer==1&&$_GET['methodpayment_id']==-1){
				$customer_saldo=$this->db
				->where("customer_id",$this->input->get("customer_id"))
				->get("customer")
				->row()
				->customer_saldo;
				$icustomer["customer_saldo"]=$customer_saldo-($input["invpaymentproduct_amount"]*$input["invpaymentproduct_qty"]);
				$wcustomer["customer_id"]=$this->input->get("customer_id");
				$this->db->update("customer",$icustomer,$wcustomer);
				//echo $this->db->last_query();die;
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
			
			if(isset($_POST['invpaymentproduct_source'])&&$input["invpaymentproduct_source"]=="kas_id"){
				$inputkas["kas_count"]=$input["invpaymentproduct_amount"]*$input["invpaymentproduct_qty"];
				$inputkas["kas_inout"]="in";
				$inputkas["kas_remarks"]=$input["invpaymentproduct_description"];
				$inputkas["kas_date"]=$dp;
				$inputkas["project_id"]=$project_id;
				if($identity->identity_saldocustomer==1){
					$inputkas["customer_id"]=$this->input->get("customer_id");
				}
				if($input["kas_id"]!="0"){
					$this->db->update("kas",$inputkas,array("kas_id"=>$input["kas_id"]));	
				}else{
					$this->db->insert("kas",$inputkas);	
					$input["kas_id"]=$this->db->insert_id();
				}
			}
			
			if(isset($_POST['invpaymentproduct_source'])&&$input["invpaymentproduct_source"]=="petty_id"){
				$inputpetty["petty_amount"]=$input["invpaymentproduct_amount"]*$input["invpaymentproduct_qty"];
				$inputpetty["petty_inout"]="in";
				$inputpetty["petty_remarks"]=$input["invpaymentproduct_description"];
				$inputpetty["petty_date"]=$dp;
				$inputpetty["project_id"]=$project_id;
				if($identity->identity_saldocustomer==1){
					$inputpetty["kas_id"]=-2;
					$inputpetty["customer_id"]=$this->input->get("customer_id");
				}
				if(isset($_POST['biaya_id'])){
					$inputpetty["biaya_id"]=$input["biaya_id"];
				}
				if($input["petty_id"]!="0"){
					$this->db->update("petty",$inputpetty,array("petty_id"=>$input["petty_id"]));	
				}else{
					$this->db->insert("petty",$inputpetty);	
					$input["petty_id"]=$this->db->insert_id();
				}
			}	
			
			
			if($identity->identity_saldocustomer==1){
				$customer_saldo=$this->db
				->where("customer_id",$this->input->get("customer_id"))
				->get("customer")
				->row()
				->customer_saldo;
				$pembayaran=$this->db
				->select("SUM(invpaymentproduct_amount*invpaymentproduct_qty)AS pembayaran")
				->where("invpaymentproduct_id",$this->input->post("invpaymentproduct_id"))
				->get("invpaymentproduct")
				->row()
				->pembayaran;
				$icustomer["customer_saldo"]=$customer_saldo+$pembayaran-($input["invpaymentproduct_amount"]*$input["invpaymentproduct_qty"]);
				$wcustomer["customer_id"]=$this->input->get("customer_id");
				$this->db->update("customer",$icustomer,$wcustomer);
				//echo $this->db->last_query();die;
			}		
			
			$this->db->update("invpaymentproduct",$input,array("invpaymentproduct_id"=>$this->input->post("invpaymentproduct_id")));			
			
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
