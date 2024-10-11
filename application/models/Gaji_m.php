<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class gaji_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		//cek gaji
		if(isset($_POST['gaji_id'])){
		$gajid["gaji_id"]=$this->input->post("gaji_id");
		$us=$this->db
		->get_where('gaji',$gajid);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $gaji){		
				foreach($this->db->list_fields('gaji') as $field)
				{
					$data[$field]=$gaji->$field;
				}				
			}
		}else{	
			 		
			
			foreach($this->db->list_fields('gaji') as $field)
			{
				$data[$field]="";
			}		
			
		}
		}
		
		//upload image
		$data['uploadgaji_picture']="";
		if(isset($_FILES['gaji_picture'])&&$_FILES['gaji_picture']['name']!=""){
		$gaji_picture=str_replace(' ', '_',$_FILES['gaji_picture']['name']);
		$gaji_picture = date("H_i_s_").$gaji_picture;
		if(file_exists ('assets/images/gaji_picture/'.$gaji_picture)){
		unlink('assets/images/gaji_picture/'.$gaji_picture);
		}
		$config['file_name'] = $gaji_picture;
		$config['upload_path'] = 'assets/images/gaji_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('gaji_picture'))
		{
			$data['uploadgaji_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadgaji_picture']="Upload Success !";
			$input['gaji_picture']=$gaji_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			if($this->input->post("gaji_source")=="kas_id"){
				$this->db->delete("kas",array("kas_id"=>$this->input->post("kas_id")));
			}else{
				$this->db->delete("petty",array("petty_id"=>$this->input->post("petty_id")));
			}
			$this->db->delete("gaji",array("gaji_id"=>$this->input->post("gaji_id")));
			$data["message"]="Delete Success";
		}
		
		//bulan romawi		
		$array_bulan = array(1=>"I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
		$bulan = $array_bulan[date('n')]; 
		$bulan_array = array(0=>"Bulan","Januari","Februari","Maret", "April", "Mei","Juni","Juli","Agustus","September","Oktober", "November","Desember");
		
		//insert
		if($this->input->post("create")=="OK"){
			
			foreach($this->input->post() as $e=>$f){
			if($e!='create'){
				$input[$e]=$this->input->post($e);				
				}
			}	
			if($this->input->post("gaji_description")==""){$input["gaji_description"]="Payroll ".$input["gaji_name"]." ".$bulan_array[$input["gaji_month"]]." Periode".$input["gaji_period"];}
			if($input["gaji_source"]=="kas_id"){
				$inputkas["kas_count"]=($input["gaji_rate"]*$input["gaji_numday"])-$input["gaji_deduction_amount"];
				$inputkas["kas_inout"]="out";
				$inputkas["project_id"]=$input["project_id"];
				$inputkas["kas_remarks"]=$input["gaji_description"];
				$inputkas["kas_date"]=date("Y-").$input["gaji_month"].date("-d");
				$this->db->insert("kas",$inputkas);	
				$input["kas_id"]=$this->db->insert_id();
			}
			
			if($input["gaji_source"]=="petty_id"){
				$inputpetty["petty_amount"]=($input["gaji_rate"]*$input["gaji_numday"])-$input["gaji_deduction_amount"];
				$inputpetty["petty_inout"]="out";
				$inputpetty["project_id"]=$input["project_id"];
				$inputpetty["petty_remarks"]=$input["gaji_description"];
				$inputpetty["petty_date"]=date("Y-").$input["gaji_month"].date("-d");
				$this->db->insert("petty",$inputpetty);	
				$input["petty_id"]=$this->db->insert_id();
			}
		
			$nosura=$this->db
			->where("nomor_name","Payroll")
			->get("nomor");
			if($nosura->num_rows()>0){
				$nosurat=$nosura->row()->nomor_no."-";
			}else{
				$nosurat="PYR-";
			}
				
			$sjno=$this->db
			->order_by("gaji_id","desc")
			->limit("1")
			->get("gaji");
			if($sjno->num_rows()>0){
				//caribulan
				$terakhir=$sjno->row()->gaji_no;
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
			$input["gaji_no"]=$sno;
			
			$input['gaji_year']=date("Y");
			$input['branch_id']=$this->session->userdata("branch_id");
			$this->db->insert("gaji",$input);			
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
			if($this->input->post("gaji_description")==""){$input["gaji_description"]="Payroll ".$input["gaji_name"]." ".$bulan_array[$input["gaji_month"]]." Periode".$input["gaji_period"];}
			if($input["gaji_source"]=="kas_id"){
				$inputkas["kas_count"]=($input["gaji_rate"]*$input["gaji_numday"])-$input["gaji_deduction_amount"];
				$inputkas["kas_inout"]="out";
				$inputkas["project_id"]=$input["project_id"];
				$inputkas["kas_remarks"]=$input["gaji_description"];
				$inputkas["kas_date"]=date("Y-").$input["gaji_month"].date("-d");
				if($input["kas_id"]!="0"){
					$this->db->update("kas",$inputkas,array("kas_id"=>$input["kas_id"]));	
				}else{
					$this->db->insert("kas",$inputkas);	
					$input["kas_id"]=$this->db->insert_id();
				}
			}
			
			if($input["gaji_source"]=="petty_id"){
				$inputpetty["petty_amount"]=($input["gaji_rate"]*$input["gaji_numday"])-$input["gaji_deduction_amount"];
				$inputpetty["petty_inout"]="out";
				$inputpetty["project_id"]=$input["project_id"];
				$inputpetty["petty_remarks"]=$input["gaji_description"];
				$inputpetty["petty_date"]=date("Y-").$input["gaji_month"].date("-d");
				if($input["petty_id"]!="0"){
				$this->db->update("petty",$inputpetty,array("petty_id"=>$input["petty_id"]));	
				}else{
				$this->db->insert("petty",$inputpetty);	
				$input["petty_id"]=$this->db->insert_id();
				}
			}
						
			$input['gaji_year']=date("Y");
			$input['branch_id']=$this->session->userdata("branch_id");		
			$this->db->update("gaji",$input,array("gaji_id"=>$this->input->post("gaji_id")));
			//echo $this->db->last_query();die;
			$data["message"]="Insert Data Success";
		}
		
		return $data;
	}
	
}
