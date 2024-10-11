<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class permintaan_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		//cek permintaan
		if(isset($_POST['permintaan_id'])){
		$permintaand["permintaan_id"]=$this->input->post("permintaan_id");
		$us=$this->db
		->get_where('permintaan',$permintaand);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $permintaan){		
				foreach($this->db->list_fields('permintaan') as $field)
				{
					$data[$field]=$permintaan->$field;
				}				
			}
		}else{	
			 		
			
			foreach($this->db->list_fields('permintaan') as $field)
			{
				$data[$field]="";
			}		
			
		}
		}
		
		//upload image
		$data['uploadpermintaan_picture']="";
		if(isset($_FILES['permintaan_picture'])&&$_FILES['permintaan_picture']['name']!=""){
		$permintaan_picture=str_replace(' ', '_',$_FILES['permintaan_picture']['name']);
		$permintaan_picture = date("H_i_s_").$permintaan_picture;
		if(file_exists ('assets/images/permintaan_picture/'.$permintaan_picture)){
		unlink('assets/images/permintaan_picture/'.$permintaan_picture);
		}
		$config['file_name'] = $permintaan_picture;
		$config['upload_path'] = 'assets/images/permintaan_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('permintaan_picture'))
		{
			$data['uploadpermintaan_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadpermintaan_picture']="Upload Success !";
			$input['permintaan_picture']=$permintaan_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("permintaan",array("permintaan_no"=>$this->input->post("permintaan_no")));
			$this->db->delete("permintaanproduct",array("permintaan_no"=>$this->input->post("permintaan_no")));
			$data["message"]="Delete Success";
		}
		
		//bulan romawi		
		$array_bulan = array(1=>"I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
		$bulan = $array_bulan[date('n')];
		
		//insert
		if($this->input->post("create")=="OK"){	
		
		$nosura=$this->db
		->where("nomor_name","Permintaan Barang")
		->get("nomor");
		if($nosura->num_rows()>0){
			$nosurat=$nosura->row()->nomor_no."-";
		}else{
			$nosurat="PMB-";
		}
		
			
		$sjno=$this->db
		->order_by("permintaan_id","desc")
		->limit("1")
		->get("permintaan");
		if($sjno->num_rows()>0){
			//caribulan
			$terakhir=$sjno->row()->permintaan_no;
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
			$input["permintaan_no"]=$sno;
			foreach($this->input->post() as $e=>$f){
			if($e!='create'){
				$input[$e]=$this->input->post($e);				
				}
			}
			$this->db->insert("permintaan",$input);			
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
			$this->db->update("permintaan",$input,array("permintaan_id"=>$this->input->post("permintaan_id")));
			$data["message"]="Insert Data Success";
		}
		
		return $data;
	}
	
}
