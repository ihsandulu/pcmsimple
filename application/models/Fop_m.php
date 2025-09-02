<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class fop_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		
		$identity=$this->db->get("identity")->row();
		//cek inv
		if(isset($_POST['new'])||isset($_POST['edit'])){
			$invd["inv_no"]=$this->input->post("inv_no");
			$us=$this->db
			//->select("*,inv.customer_id AS cid")
			->join("customer","customer.customer_id=inv.customer_id","left")
			->get_where('inv',$invd);	
			//echo $this->db->last_query();die;	
			if($us->num_rows()>0)
			{
				foreach($us->result() as $inv){		
					foreach($this->db->list_fields('inv') as $field)
					{
						$data[$field]=$inv->$field;
					}	
					foreach($this->db->list_fields('customer') as $field)
					{
						$data[$field]=$inv->$field;
					}
					if($identity->identity_simple==1){
						//payment
						$invpayment=$this->db
						->where("inv_no",$inv->inv_no)
						->get("invpayment");
						foreach($invpayment->result() as $invpayment){
							foreach($this->db->list_fields('invpayment') as $field)
							{
								$data[$field]=$invpayment->$field;
							}
						}
						
					
						//sjkeluar
						$sjkeluar=$this->db
						->where("inv_no",$inv->inv_no)
						->get("sjkeluar");
						foreach($sjkeluar->result() as $sjkeluar){
							foreach($this->db->list_fields('sjkeluar') as $field)
							{
								 $data[$field]=$sjkeluar->$field;
							}//echo $data["customer_id"];
						}
					}					
				}
			}else{	
				foreach($this->db->list_fields('inv') as $field)
				{
					$data[$field]="";
				}
				foreach($this->db->list_fields('customer') as $field)
				{
					$data[$field]="";
				}	
				if($identity->identity_simple==1){
					//payment
					foreach($this->db->list_fields('invpayment') as $field)
					{
						$data[$field]="";
					}					
					
					//sjkeluar
					foreach($this->db->list_fields('sjkeluar') as $field)
					{
						$data[$field]="";
					}
				}	
				$data["inv_payment"]=$identity->identity_payment;
				$data["inv_note"]=$identity->identity_note;	
			}
			//die();
		}
		
		//upload image
		$data['uploadinv_picture']="";
		if(isset($_FILES['inv_picture'])&&$_FILES['inv_picture']['name']!=""){
		$inv_picture=str_replace(' ', '_',$_FILES['inv_picture']['name']);
		$inv_picture = date("H_i_s_").$inv_picture;
		if(file_exists ('assets/images/inv_picture/'.$inv_picture)){
		unlink('assets/images/inv_picture/'.$inv_picture);
		}
		$config['file_name'] = $inv_picture;
		$config['upload_path'] = 'assets/images/inv_picture/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('inv_picture'))
		{
			$data['uploadinv_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadinv_picture']="Upload Success !";
			$input['inv_picture']=$inv_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			//cek ada produk g
			$cek=$this->db
			->where("inv_no",$this->input->post("inv_no"))
			->get("invproduct");				
			if($identity->identity_simple==1){
				$this->db->delete("sjkeluar",array("inv_no"=>$this->input->post("inv_no")));
				$this->db->delete("invpayment",array("inv_no"=>$this->input->post("inv_no")));
				$this->db->delete("inv",array("inv_no"=>$this->input->post("inv_no")));
				$data["message"]="Delete Success";
			}else{
				if($cek->num_rows()>0){
					$data["message"]="Delete Failed.<br/>Please remove product!";			
				}else{
					//cek payment
						$c=$this->db
						->where("inv_no",$this->input->post("inv_no"))
						->get("invpayment");
						if($c->num_rows()>0){
							$data["message"]="Please delete the payment first!";
						}else{
							$this->db->delete("inv",array("inv_no"=>$this->input->post("inv_no")));
							$data["message"]="Delete Success";
						}
					}
			}
		}
		
		//bulan romawi		
		$array_bulan = array(1=>"I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
		$bulan = $array_bulan[date('n')];    
		
		//insert
		if($this->input->post("create")=="OK"){
		
		$nosura=$this->db
		->where("nomor_name","Invoice")
		->get("nomor");
		if($nosura->num_rows()>0){
			$nosurat=$nosura->row()->nomor_no."-";
		}else{
			$nosurat="QTH-INV-";
		}
		
		$quno=$this->db
		->order_by("inv_id","desc")
		->limit("1")
		->get("inv");
		if($quno->num_rows()>0){
			//caribulan
			$invterakhir=$quno->row()->inv_no;
			$blinv=explode("-",$invterakhir);
			$blninv=$blinv[1];
			$noterakhir=end($blinv);
			$identity_number=$this->db->get("identity")->row()->identity_number;
			if($identity_number=="Monthly"){
				if($blninv!=$bulan){
					$inv_no=1;
				}else{
					$inv_no=$noterakhir+1;
					//$inv_no=1;
				}
			}
			if($identity_number=="Yearly"){
				if($blinv[2]!=date("Y")){
				$inv_no=1;
			}else{
				$inv_no=$noterakhir+1;
				//$inv_no=1;
				}
			}
		}else{
			$inv_no=1;
		}
		$inv_no=$nosurat.$bulan.date("-Y-").str_pad($inv_no,5,"0",STR_PAD_LEFT);
		if($identity->identity_simple==0){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$input["inv_no"]=$inv_no;
			$this->db->insert("inv",$input);		
		}
		if($_SESSION['branch_id']==null){$branch_id=0;}else{$branch_id=$_SESSION['branch_id'];}		
		$input_update["branch_id"]=$branch_id;
		$input_update["inv_discount"]=$this->input->post("inv_discount");
		$input_update["user_id"]=$_SESSION['user_id'];
		$input_update["inv_date"]=$this->input->post("inv_date");
		$input_update["inv_duedate"]=$this->input->post("inv_duedate");	
		if(isset($_POST['customer_id'])){
			$input_update["customer_id"]=$this->input->post("customer_id");
		}
		if(isset($_POST['vendor_id'])){
			$input_update["vendor_id"]=$this->input->post("vendor_id");	
		}
		
		
		if($identity->identity_simple==0){
			$input_update["project_id"]="0";
			$where["inv_no"]=$inv_no;	
			$this->db->update("inv",$input_update,$where);
			//echo $this->db->last_query();die;
		}else{
			$input_update["inv_no"]=$inv_no;
			$this->db->insert("inv",$input_update);
			
			
			
			//******masukin payment********		
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
				$identity_number=$this->db->get("identity")->row()->identity_number;
				if($identity_number=="Monthly"){
					if($blnno!=$bulan){
						$inno=1;
					}else{
						$inno=$noterakhir+1;
						//$inno=1;
					}
				}
				if($identity_number=="Yearly"){
					if($blno[2]!=date("Y")){
						$inno=1;
					}else{
						$inno=$noterakhir+1;
						//$inno=1;
					}
				}
			}else{
				$inno=1;
			}
			$sno=$nosurat.$bulan.date("-Y-").str_pad($inno,5,"0",STR_PAD_LEFT);
			$inputpayment["invpayment_no"]=$sno;
			$inputpayment["invpayment_date"]=$input_update["inv_date"];
			$inputpayment["methodpayment_id"]=$this->input->post("methodpayment_id");
			$inputpayment["inv_no"]=$input_update["inv_no"];
			$this->db->insert("invpayment",$inputpayment);
			 $this->db->last_query();
			
			//SJ Keluar
			$nosura=$this->db
			->where("nomor_name","SJ Keluar")
			->get("nomor");
			if($nosura->num_rows()>0){
				$nosurat=$nosura->row()->nomor_no."-";
			}else{
				$nosurat="SJK-";
			}			
				
			$sjno=$this->db
			->order_by("sjkeluar_id","desc")
			->limit("1")
			->get("sjkeluar");
			if($sjno->num_rows()>0){
				//caribulan
				$terakhir=$sjno->row()->sjkeluar_no;
				$blno=explode("-",$terakhir);
				$blnno=$blno[1];
				$noterakhir=end($blno);
				$identity_number=$this->db->get("identity")->row()->identity_number;
				if($identity_number=="Monthly"){
					if($blnno!=$bulan){
						$inno=1;
					}else{
						$inno=$noterakhir+1;
						//$inno=1;
					}
				}
				if($identity_number=="Yearly"){
					if($blno[2]!=date("Y")){
						$inno=1;
					}else{
						$inno=$noterakhir+1;
						//$inno=1;
					}
				}
			}else{
				$inno=1;
			}
			$sno=$nosurat.$bulan.date("-Y-").str_pad($inno,5,"0",STR_PAD_LEFT);
			$inputsjkeluar["sjkeluar_no"]=$sno;
			$inputsjkeluar["sjkeluar_pengirim"]=$this->input->post("sjkeluar_pengirim");
			$inputsjkeluar["sjkeluar_penerima"]=$this->input->post("sjkeluar_penerima");
			$inputsjkeluar["sjkeluar_date"]=$input_update["inv_date"];
			$inputsjkeluar["sjkeluar_ekspedisi"]=$this->input->post("sjkeluar_ekspedisi");
			$inputsjkeluar["sjkeluar_nopol"]=$this->input->post("sjkeluar_nopol");
			$inputsjkeluar["inv_no"]=$input_update["inv_no"];
			$inputsjkeluar["branch_id"]=$branch_id;	
			$inputsjkeluar["project_id"]=$input_update["project_id"];
			if(isset($_POST['customer_id'])){
			$inputsjkeluar["customer_id"]=$input_update["customer_id"];
			}
			$this->db->insert("sjkeluar",$inputsjkeluar);
			
			$data["message"]="Insert Data Success";
			
			
		
		}
		
			
			$data["message"]="Insert Data Success";
			//$data["message"]=$this->db->last_query();
		}
		
		//update
		if($this->input->post("change")=="OK"){
			if($identity->identity_simple==0){
				foreach($this->input->post() as $e=>$f){if($e!='change'){$input[$e]=$this->input->post($e);}}
				$this->db->update("inv",$input,array("inv_no"=>$this->input->post("inv_no")));
				//echo $this->db->last_query();die;
			}else{
			
			
				$input_update["inv_discount"]=$this->input->post("inv_discount");
				$input_update["inv_date"]=$this->input->post("inv_date");
				$input_update["inv_duedate"]=$this->input->post("inv_duedate");	
				$input_update["inv_no"]=$this->input->post("inv_no1");	
				if(isset($_POST['customer_id'])){
					$input_update["customer_id"]=$this->input->post("customer_id");
				}
				if(isset($_POST['vendor_id'])){
					$input_update["vendor_id"]=$this->input->post("vendor_id");	
				}
				$where["inv_no"]=$this->input->post("inv_no");	
				$this->db->update("inv",$input_update,$where);
				//echo $this->db->last_query();die;
				/*if($identity->identity_pelunasan==1){
					$inputp["methodpayment_id"]=$this->input->post("methodpayment_id");
					$inputp["invpayment_date"]=$this->input->post("inv_date");	
					
					$inputp["inv_no"]=$this->input->post("inv_no");
					$this->db->update("invpayment",$inputp,array("inv_no"=>$this->input->post("inv_no")));		
				}*/
				
				
				
				
				//******masukin payment********	
				$inputpayment["invpayment_date"]=$input_update["inv_date"];
				$inputpayment["methodpayment_id"]=$this->input->post("methodpayment_id");
				$this->db->update("invpayment",$inputpayment,$where);
				//echo $this->db->last_query();die();
				
				//SJ Keluar
				$inputsjkeluar["sjkeluar_pengirim"]=$this->input->post("sjkeluar_pengirim");
				$inputsjkeluar["sjkeluar_penerima"]=$this->input->post("sjkeluar_penerima");
				$inputsjkeluar["sjkeluar_date"]=$input_update["inv_date"];
				$inputsjkeluar["sjkeluar_ekspedisi"]=$this->input->post("sjkeluar_ekspedisi");
				$inputsjkeluar["sjkeluar_nopol"]=$this->input->post("sjkeluar_nopol");
				if(isset($_POST['customer_id'])){
				$inputsjkeluar["customer_id"]=$input_update["customer_id"];
				}
				$this->db->update("sjkeluar",$inputsjkeluar,$where);
				//echo $this->db->last_query();die();
				$data["message"]="Insert Data Success";
			
			}
		}
		
		return $data;
	}
	
}
