<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class suratkeluar_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		//cek suratkeluar
		if(isset($_POST['suratkeluar_id'])){
		$suratkeluard["suratkeluar_id"]=$this->input->post("suratkeluar_id");
		$us=$this->db
		->get_where('suratkeluar',$suratkeluard);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $suratkeluar){		
				foreach($this->db->list_fields('suratkeluar') as $field)
				{
					$data[$field]=$suratkeluar->$field;
				}				
			}
		}else{	
			 		
			
			foreach($this->db->list_fields('suratkeluar') as $field)
			{
				$data[$field]="";
			}		
			
		}
		}
		
		//upload image
		$data['uploadsuratkeluar_picture']="";
		if(isset($_FILES['suratkeluar_picture'])&&$_FILES['suratkeluar_picture']['name']!=""){
		$suratkeluar_picture=str_replace(' ', '_',$_FILES['suratkeluar_picture']['name']);
		$suratkeluar_picture = date("H_i_s_").$suratkeluar_picture;
		if(file_exists ('assets/images/suratkeluar_picture/'.$suratkeluar_picture)){
		unlink('assets/images/suratkeluar_picture/'.$suratkeluar_picture);
		}
		$config['file_name'] = $suratkeluar_picture;
		$config['upload_path'] = 'assets/images/suratkeluar_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('suratkeluar_picture'))
		{
			$data['uploadsuratkeluar_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadsuratkeluar_picture']="Upload Success !";
			$input['suratkeluar_picture']=$suratkeluar_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("suratkeluar",array("suratkeluar_id"=>$this->input->post("suratkeluar_id")));
			$data["message"]="Delete Success";
		}
		
		//bulan romawi		
		$array_bulan = array(1=>"I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
		$bulan = $array_bulan[date('n')];  
		
		//insert
		if($this->input->post("create")=="OK"){	
		
		$nosura=$this->db
		->where("nomor_name","Surat Keluar")
		->get("nomor");
		if($nosura->num_rows()>0){
			$nosurat=$nosura->row()->nomor_no."-";
		}else{
			$nosurat="SK-";
		}
			
		$sjno=$this->db
		->order_by("suratkeluar_id","desc")
		->limit("1")
		->get("suratkeluar");
		if($sjno->num_rows()>0){		
			//caribulan
			$terakhir=$sjno->row()->suratkeluar_no;
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
			$input["suratkeluar_no"]=$sno;
			foreach($this->input->post() as $e=>$f){
			if($e!='create'){
				$input[$e]=$this->input->post($e);				
				}
			}
			$input['branch_id']=$this->session->userdata("branch_id");
			$this->db->insert("suratkeluar",$input);			
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
			$input['branch_id']=$this->session->userdata("branch_id");		
			$this->db->update("suratkeluar",$input,array("suratkeluar_id"=>$this->input->post("suratkeluar_id")));
			$data["message"]="Insert Data Success";
		}
		
		return $data;
	}
	
}
