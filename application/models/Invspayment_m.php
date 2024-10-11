<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class invspayment_M extends CI_Model {
	
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
		$data['uploadinvspaymentpicture_name']="";
		if(isset($_FILES['invspaymentpicture_name'])&&$_FILES['invspaymentpicture_name']['name']!=""){
		$without_extension = pathinfo($_FILES['invspaymentpicture_name']['name'], PATHINFO_FILENAME);
		$extension = pathinfo($_FILES['invspaymentpicture_name']['name'], PATHINFO_EXTENSION);
		$invspaymentpicture_name=str_replace(' ', '_',$without_extension);
		$invspaymentpicture_name=str_replace('.', '_',$invspaymentpicture_name);
		$invspaymentpicture_name = date("H_i_s_").$invspaymentpicture_name.".".$extension;
		if(file_exists ('assets/images/invspaymentpicture/'.$invspaymentpicture_name)){
		unlink('assets/images/invspaymentpicture/'.$invspaymentpicture_name);
		}
		$config['file_name'] = $invspaymentpicture_name;
		$config['upload_path'] = 'assets/images/invspaymentpicture/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('invspaymentpicture_name'))
		{
			$data['uploadinvspaymentpicture_name']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadinvspaymentpicture_name']="Upload Success !";
			$input['invspaymentpicture_name']=$invspaymentpicture_name;
			$input['invspayment_id']=$this->input->post("invspayment_id");
			$this->db->insert("invspaymentpicture",$input);
			//echo $this->db->last_query();die;
		}
	
	}
	
	//delete gambar
		if($this->input->post("deletegambar")!=""){
			//cek ada data produk nggak
			$this->db->delete("invspaymentpicture",array("invspaymentpicture_id"=>$this->input->post("deletegambar")));
			$data["message"]="Delete Picture Success";
			
		}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			//cek ada data produk nggak
			$c=$this->db
			->where("invspayment_no",$this->input->post("invspayment_no"))
			->get("invspaymentproduct");
			if($c->num_rows()>0){
			$data["message"]="Please delete the product data first!";
			}else{
			$this->db->delete("invspayment",array("invspayment_id"=>$this->input->post("invspayment_id")));
			$data["message"]="Delete Success";
			}
		}
			
		//bulan romawi		
		$array_bulan = array(1=>"I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
		$bulan = $array_bulan[date('n')];
		
		//insert
		if($this->input->post("create")=="OK"){
			if(isset($_GET['invs_no'])){
				$namanomor="Payment Invoice Supplier";
				$inisial="PIS-";
			}else{
				$namanomor="Cash Advance";
				$inisial="CA-";
			}
			
			$nosura=$this->db
			->where("nomor_name",$namanomor)
			->get("nomor");
			if($nosura->num_rows()>0){
				$nosurat=$nosura->row()->nomor_no."-";
			}else{
				$nosurat=$inisial;
			}
			
			$quno=$this->db
			->order_by("invspayment_id","desc")
			->limit("1")
			->get("invspayment");
			if($quno->num_rows()>0){
				//caribulan
				$terakhir=$quno->row()->invspayment_no;
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
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$input["invspayment_no"]=$sno;
			$this->db->insert("invspayment",$input);
			//header("Location:".current_url());
			//echo $this->db->last_query();die;
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='invspaymentpicture_name'){$input[$e]=$this->input->post($e);}}
			//cek nomor payment ada nggak
			$cp=$this->db
			->where("invspayment_id",$this->input->post("invspayment_id"))
			->get("invspayment");
			if($cp->row()->invspayment_no==""){$input["invspayment_no"]=$invspayment_no;}
			$this->db->update("invspayment",$input,array("invspayment_id"=>$this->input->post("invspayment_id")));			
			
		
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		//ca back
		if($this->input->post("caback")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='caback'&&$e!='invspaymentpicture_name'){$input[$e]=$this->input->post($e);}}
			$project_id=0;
			$petty_id=0;
			$invspayment_no="";
			//payment
			$cp=$this->db
			->where("invspayment_id",$this->input->post("invspayment_id"))
			->get("invspayment");
			foreach($cp->result() as $cp){
				$project_id=$cp->project_id;
				$petty_id=$cp->petty_id;
				$invspayment_no=$cp->invspayment_no;
			}
			
			$inputpetty["petty_amount"]=$input["invspayment_back"];
			$inputpetty["petty_inout"]="in";
			$inputpetty["petty_remarks"]="CA Payment Back ".$invspayment_no;
			$inputpetty["project_id"]=$project_id;
			if($petty_id!="0"){
			$this->db->update("petty",$inputpetty,array("petty_id"=>$petty_id));	
			}else{
			$inputpetty["petty_date"]=date("Y-m-d");			
			$this->db->insert("petty",$inputpetty);	
			$input["petty_id"]=$this->db->insert_id();
			}
			//echo $this->db->last_query();die;
			$this->db->update("invspayment",$input,array("invspayment_id"=>$this->input->post("invspayment_id")));			
			
		
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		//Approve
		if($this->input->post("approve")=="OK"){
			$input["invspayment_status"]="CA Request Approved";			
			$this->db->update("invspayment",$input,array("invspayment_id"=>$this->input->post("invspayment_id")));			
			
		
			$data["message"]="Approving Successed";
			//echo $this->db->last_query();die;
		}
		//CA Out
		if($this->input->post("caout")=="OK"){
			$input["invspayment_status"]="CA Out";			
			$this->db->update("invspayment",$input,array("invspayment_id"=>$this->input->post("invspayment_id")));			
			
		
			$data["message"]="Paying CA Successed";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
