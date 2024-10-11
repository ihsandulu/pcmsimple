<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class sjkeluar_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		$identity=$this->db->get("identity")->row();
		//cek sjkeluar
		if(isset($_POST['sjkeluar_id'])){
		$sjkeluard["sjkeluar_id"]=$this->input->post("sjkeluar_id");
		$us=$this->db
		->get_where('sjkeluar',$sjkeluard);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $sjkeluar){		
				foreach($this->db->list_fields('sjkeluar') as $field)
				{
					$data[$field]=$sjkeluar->$field;
				}				
			}
		}else{	
			 		
			
			foreach($this->db->list_fields('sjkeluar') as $field)
			{
				$data[$field]="";
			}		
			
		}
		}
		
		//upload image
		$data['uploadsjkeluar_picture']="";
		if(isset($_FILES['sjkeluar_picture'])&&$_FILES['sjkeluar_picture']['name']!=""){
		$sjkeluar_picture=str_replace(' ', '_',$_FILES['sjkeluar_picture']['name']);
		$sjkeluar_picture = date("H_i_s_").$sjkeluar_picture;
		if(file_exists ('assets/images/sjkeluar_picture/'.$sjkeluar_picture)){
		unlink('assets/images/sjkeluar_picture/'.$sjkeluar_picture);
		}
		$config['file_name'] = $sjkeluar_picture;
		$config['upload_path'] = 'assets/images/sjkeluar_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('sjkeluar_picture'))
		{
			$data['uploadsjkeluar_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadsjkeluar_picture']="Upload Success !";
			$input['sjkeluar_picture']=$sjkeluar_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("sjkeluar",array("sjkeluar_no"=>$this->input->post("sjkeluar_no")));
			if(isset($_GET['inv_no'])){
				$this->db->delete("sjkeluarproduct",array("sjkeluar_no"=>$this->input->post("sjkeluar_no")));
				if($identity->identity_stok==0){
					$gudang["sjkeluar_no"]=$this->input->post("sjkeluar_no");
					$this->db->delete("gudang",$gudang);
				}
			}
			$data["message"]="Delete Success";
		}
		
		//bulan romawi		
		$array_bulan = array(1=>"I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
		$bulan = $array_bulan[date('n')];
		
		//insert
		if($this->input->post("create")=="OK"){	
		
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
			$input["sjkeluar_no"]=$sno;
			foreach($this->input->post() as $e=>$f){
			if($e!='create'){
				$input[$e]=$this->input->post($e);				
				}
			}
			$this->db->insert("sjkeluar",$input);	
			
			//membuat product seperti invoice product
			if(isset($_GET['inv_no'])){
				$inv=$this->db
				->where("inv_no",$_GET['inv_no'])
				->get("invproduct");
				foreach($inv->result() as $inv){
					$invi['sjkeluarproduct_panjang']=$inv->invproduct_panjang;
					$invi['sjkeluarproduct_lebar']=$inv->invproduct_lebar;
					$invi['sjkeluarproduct_tinggi']=$inv->invproduct_tinggi;
					$invi['sjkeluarproduct_unit']=$inv->invproduct_unit;
					$invi['product_id']=$inv->product_id;
					$invi['sjkeluarproduct_qty']=$inv->invproduct_qty;
					$invi['sjkeluar_no']=$input["sjkeluar_no"];
					$this->db->insert("sjkeluarproduct",$invi);	
					
					if($identity->identity_stok==0){
						$gudang["product_id"]=$inv->product_id;
						$gudang["gudang_qty"]=$inv->invproduct_qty;
						$gudang["gudang_inout"]="out";
						$gudang["branch_id"]=$this->session->userdata("branch_id");
						$gudang["sjkeluarproduct_id"]=$this->db->insert_id();
						$gudang["sjkeluar_no"]=$input["sjkeluar_no"];
						$gudang["inv_no"]=$this->input->get("inv_no");
						$this->db->insert("gudang",$gudang);
					}
				}
			}		
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
			$this->db->update("sjkeluar",$input,array("sjkeluar_id"=>$this->input->post("sjkeluar_id")));
			$data["message"]="Insert Data Success";
		}
		
		return $data;
	}
	
}
