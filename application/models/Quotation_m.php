<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class quotation_M extends CI_Model {

	public function ulang($b){
	
		$identity=$this->db->get("identity");
		foreach($identity->result() as $identity){		
			foreach($this->db->list_fields('identity') as $field)
			{
				$data[$field]=$identity->$field;
			}
		}
		
		if($b!=""){
			$this->db->where("customer_id",$b);
		}else{		
			$this->db->where("customer_id",$this->input->post("customer_id"));
		}
		$customer=$this->db->get("customer");
		foreach($customer->result() as $customer){		
			foreach($this->db->list_fields('customer') as $field)
			{
				$data[$field]=$customer->$field;
			}
		}
		
		
		//bulan romawi		
		$array_bulan = array(1=>"I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
		$bulan = $array_bulan[date('n')];  
		
		$nosura=$this->db
		->where("nomor_name","Quotation")
		->get("nomor");
		if($nosura->num_rows()>0){
			$nosurat=$nosura->row()->nomor_no."-";
		}else{
			$nosurat="QUO-";
		}
		
		$quno=$this->db
		->order_by("quotation_id","desc")
		->limit("1")
		->get("quotation");
		if($quno->num_rows()>0){
			//caribulan
			$terakhir=$quno->row()->quotation_no;
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
			$customer_id="";
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$input["quotation_no"]=$sno;
			$input["quotation_date"]=date("Y-m-d");
			if($b!=""){
				$input["customer_id"]=$b;
			}else{		
				$input["customer_id"]=$this->input->post("customer_id");
			}
				
			$customer_id=$this->input->post("customer_id");
			$this->db->insert("quotation",$input);
			//echo $this->db->last_query(); die();
			$insertid=$this->db->insert_id();
		
			//echo $this->db->last_query();die;
		
		
			
			$data["message"]="Insert Data Success";
			
			
		
			return $data["message"];
	}
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		
		$identity=$this->db->get("identity");
		foreach($identity->result() as $identity){		
			foreach($this->db->list_fields('identity') as $field)
			{
				$data[$field]=$identity->$field;
			}
		}
		
		if(isset($_GET['product_id'])){
			$product=$this->db
			->where("product_id",$_GET['product_id'])
			->get("product");
			foreach($product->result() as $product){		
				foreach($this->db->list_fields('product') as $field)
				{
					$data[$field]=$product->$field;
				}
			}
		}else{
			foreach($this->db->list_fields('product') as $field)
			{
				$data[$field]="";
			}	
		}
		
		//cek quotation
		if(isset($_POST['quotation_id'])||isset($_POST['quotation_no'])){
		if(isset($_POST['quotation_id'])){
			$quotationd["quotation_id"]=$this->input->post("quotation_id");
		}
		if(isset($_POST['quotation_no'])){
			$quotationd["quotation_no"]=$this->input->post("quotation_no");
		}
		$us=$this->db
		->join("customer","customer.customer_id=quotation.customer_id","left")
		->join("project","project.project_id=quotation.project_id","left")
		->get_where('quotation',$quotationd);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $quotation){		
				foreach($this->db->list_fields('quotation') as $field)
				{
					$data[$field]=$quotation->$field;
				}
								
				foreach($this->db->list_fields('project') as $field)
				{
					$data[$field]=$quotation->$field;
				}	
								
				foreach($this->db->list_fields('customer') as $field)
				{
					$data[$field]=$quotation->$field;
				}		
			}
		}else{	
			 		
				foreach($this->db->list_fields('quotation') as $field)
				{
					$data[$field]="";
				}	
				$qfield=$this->db->get("qfield");
				foreach($qfield->result() as $qfield){
					foreach($this->db->list_fields('qfield') as $field)
					{
						$data[$field]=$qfield->$field;
					}	
				}		
				
				foreach($this->db->list_fields('project') as $field)
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
		$data['uploadquotation_picture']="";
		if(isset($_FILES['quotation_picture'])&&$_FILES['quotation_picture']['name']!=""){
		$quotation_picture=str_replace(' ', '_',$_FILES['quotation_picture']['name']);
		$quotation_picture = date("H_i_s_").$quotation_picture;
		if(file_exists ('assets/images/quotation_picture/'.$quotation_picture)){
		unlink('assets/images/quotation_picture/'.$quotation_picture);
		}
		$config['file_name'] = $quotation_picture;
		$config['upload_path'] = 'assets/images/quotation_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('quotation_picture'))
		{
			$data['uploadquotation_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadquotation_picture']="Upload Success !";
			$input['quotation_picture']=$quotation_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			//cek product ada tidak
			$cek=$this->db
			->where("quotation_id",$this->input->post("quotation_id"))
			->get("quotationproduct");
			if($cek->num_rows()>0){
				$data["message"]="Delete Failed.<br/>Please remove the product first";
			}else{
				$input["quotation_no"]="";
				$input["quotation_id"]="0";
				$where["quotation_no"]=$this->input->post("quotation_no");
				$where["quotation_id"]=$this->input->post("quotation_id");
				$this->db->update("poc",$input,$where);
				$this->db->delete("quotation",array("quotation_id"=>$this->input->post("quotation_id")));
				$data["message"]="Delete Success";
			}
		}
		
		 //kirimemail
		if($this->input->post("sendemail")=="OK"){			
			$quotation_no=$this->input->post("quotation_no");
			if($data["identity_kirimemail"]=="1"){		
			
				//send email			
				
				$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://';
				$domainName = $_SERVER['HTTP_HOST'] . '/';
				
				//$userweb_email=$event->userweb_email;
				
				$customer_id=explode(",",$this->input->post("customer_id"));
				for($x=0;$x<count($customer_id);$x++ ){
					$message=file_get_contents(site_url("quotationprint?quotation_no=".$quotation_no)."&customer_id=".$customer_id[$x]);
								
					//email 
					$this->load->library('email');
					$this->email->set_newline("\r\n");
					$this->email->from($data["identity_email"]);
					$list = array($customer_id[$x]);
					$this->email->to($list);
					$this->email->subject('Quotation');
					$this->email->message($message);
					if($this->email->send())
					{
						$data['message']="Email sent";
					}
					else
					{
						$data['message']=$this->email->print_debugger();
					}
					
				}			
			} 
		}
	
		//insert
		if($this->input->post("create")=="OK"){	
			if($this->input->post("pilihcustomer")=="banyak"){
				foreach($this->input->post("customer_id") as $a=>$b){
					$data["message"]=$this->ulang($b);
				}		
			}else{
				$data["message"]=$this->ulang('');
			}
		}
		
		//update
		if($this->input->post("change")=="OK"){						
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='quotation_picture'){$input[$e]=$this->input->post($e);}}
			$this->db->update("quotation",$input,array("quotation_id"=>$this->input->post("quotation_id")));
			//echo $this->db->last_query();
			$data["message"]="Update Success";
		}
		
		//revisi
		if($this->input->post("revisi")=="OK"){						
			foreach($this->input->post() as $e=>$f){if($e!='revisi'){$input[$e]=$this->input->post($e);}}
			$quotation=$this->db
			->order_by("quotation_rev","DESC")
			->limit(1)
			->get_where("quotation",$input);
			
			$revnum=$this->db
			->where("quotation_no",$this->input->post("quotation_no"))
			->order_by("quotation_rev","DESC")
			->limit(1)
			->get("quotation")
			->row()
			->quotation_rev;
			
			foreach($quotation->result() as $quotation){
				foreach($this->db->list_fields('quotation') as $field)
				{
					$isi[$field]=$quotation->$field;
				}
				$quotation_idlama=$quotation->quotation_id;
				$isi["quotation_rev"]=$revnum+1;
				$isi["quotation_id"]="";
				
			}
			$this->db->insert("quotation",$isi);
			$insertid=$this->db->insert_id();
			if($insertid>0){
				$quotationproduct=$this->db
				->where("quotation_id",$quotation_idlama)
				->get("quotationproduct");
				//echo $this->db->last_query();
				foreach($quotationproduct->result() as $quotationproduct){
					foreach($this->db->list_fields('quotationproduct') as $field)
					{
						$prod[$field]=$quotationproduct->$field;
					}	
					$prod["quotationproduct_id"]="";
					$prod["quotation_id"]=$insertid;
					$this->db->insert("quotationproduct",$prod);
					//echo $this->db->last_query();die;
				}
			}
			
			//echo $this->db->last_query();
			
		}
		
		return $data;
	}
	
}
