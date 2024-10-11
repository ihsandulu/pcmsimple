<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class po_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		//cek po
		//if(isset($_POST['po_no'])){
		$pod["po_no"]=$this->input->post("po_no");
		$us=$this->db
		->get_where('po',$pod);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $po){		
				foreach($this->db->list_fields('po') as $field)
				{
					$data[$field]=$po->$field;
				}					
			}
		}else{	
			 		
			
			foreach($this->db->list_fields('po') as $field)
			{
				$data[$field]="";
			}		
			
		}
		//}
		
		//upload image
		$data['uploadpo_picture']="";
		if(isset($_FILES['po_picture'])&&$_FILES['po_picture']['name']!=""){
		$po_picture=str_replace(' ', '_',$_FILES['po_picture']['name']);
		$po_picture = date("H_i_s_").$po_picture;
		if(file_exists ('assets/images/po_picture/'.$po_picture)){
		unlink('assets/images/po_picture/'.$po_picture);
		}
		$config['file_name'] = $po_picture;
		$config['upload_path'] = 'assets/images/po_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('po_picture'))
		{
			$data['uploadpo_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadpo_picture']="Upload Success !";
			$input['po_picture']=$po_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			//cek ada produk g
			$cek=$this->db
			->where("po_no",$this->input->post("po_no"))
			->get("poproduct");
			//echo $this->db->last_query();die;
			if($cek->num_rows()>0){
				$data["message"]="Delete Failed.<br/>Please remove product!";			
			}else{
				$this->db->delete("po",array("po_no"=>$this->input->post("po_no")));
				$data["message"]="Delete Success";
			}
		}
		
		//bulan romawi		
		$array_bulan = array(1=>"I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
		$bulan = $array_bulan[date('n')];  
		
		//insert
		if($this->input->post("create")=="OK"){
		
			$nosura=$this->db
			->where("nomor_name","PO Supplier")
			->get("nomor");
			if($nosura->num_rows()>0){
				$nosurat=$nosura->row()->nomor_no."-";
			}else{
				$nosurat="POS-";
			}
			
			$quno=$this->db
			->order_by("po_id","desc")
			->limit("1")
			->get("po");
			if($quno->num_rows()>0&&$quno->row()->po_no!=""){
				//caribulan
				$terakhir=$quno->row()->po_no;
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
		 
			$input["po_no"]=$nosurat.$bulan.date("-Y-").str_pad($inno,5,"0",STR_PAD_LEFT);
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			
			$this->db->insert("po",$input);
			//echo $this->db->last_query();die;
			
			$data["message"]="Insert Data Success";
		}
		
		//update
		if($this->input->post("change")=="OK"){
		

			foreach($this->input->post() as $e=>$f){if($e!='change'){$input[$e]=$this->input->post($e);}}
			//die;
				
			$where["po_no"]=$this->input->post("po_no");	
			$this->db->update("po",$input,$where);
			//echo $this->db->last_query();die;
			$data["message"]="Insert Data Success";
		}
		
		return $data;
	}
	
}
