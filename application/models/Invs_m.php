<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class invs_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		//cek invs
		if(isset($_POST['invs_id'])){
		$invsd["invs_id"]=$this->input->post("invs_id");
		$us=$this->db
		->get_where('invs',$invsd);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $invs){		
				foreach($this->db->list_fields('invs') as $field)
				{
					$data[$field]=$invs->$field;
				}				
			}
		}else{	
			 		
			
			foreach($this->db->list_fields('invs') as $field)
			{
				$data[$field]="";
			}
			$data["invs_no"]=date("YmdHis");		
			
		}
		}
		
		
		
		//upload image
		$data['uploadinvs_picture']="";
		if(isset($_FILES['invs_picture'])&&$_FILES['invs_picture']['name']!=""){
			$invs_picture=str_replace('.', '_',$_FILES['invs_picture']['name']);
			$invs_picture=str_replace(' ', '_',$_FILES['invs_picture']['name']);
			$invs_picture = date("H_i_s_").$invs_picture;
			$array=explode(".",$invs_picture);
			$akhir=end($array);
			//echo $akhir;die;
			$invs_picture=substr($invs_picture,0,(strlen($invs_picture)-strlen($akhir)-1)).".".$akhir;
			$invs_faktur=substr($invs_picture,0,(strlen($invs_picture)-strlen($akhir)-1))."1.".$akhir;
			if(file_exists ('assets/images/invs_picture/'.$invs_picture)){
			unlink('assets/images/invs_picture/'.$invs_picture);
			}
			$config['file_name'] = $invs_picture;
			$config['upload_path'] = 'assets/images/invs_picture/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size']	= '3000000000';
			$config['max_width']  = '5000000000';
			$config['max_height']  = '3000000000';
	
			$this->load->library('upload', $config);
	
			if ( ! $this->upload->do_upload('invs_picture'))
			{
				$data['uploadinvs_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
			}
			else
			{
				$data['uploadinvs_picture']="Upload Success !";
				$input['invs_picture']=$invs_picture;
			}
			
			if ( ! $this->upload->do_upload('invs_faktur'))
			{
				$data['uploadinvs_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
			}
			else
			{
				$data['uploadinvs_picture']="Upload Success !";
				$input['invs_faktur']=$invs_faktur;
			}
	
		}
		
		
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("invs",array("invs_no"=>$this->input->post("invs_no")));
			$this->db->delete("invsproduct",array("invs_no"=>$this->input->post("invs_no")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){				
			foreach($this->input->post() as $e=>$f){
			if($e!='create'&&substr($e,0,5)!='price'){
				$input[$e]=$this->input->post($e);				
				}
			}
			if(isset($_SESSION['branch_id'])){
				$input["branch_id"]=$_SESSION['branch_id'];		
			}	
			if(isset($_SESSION['user_id'])){
				$input["user_id"]=$_SESSION['user_id'];		
			}		
			$this->db->insert("invs",$input);			
			//echo $this->db->last_query();die;
			
			$data["message"]="Insert Data Success";
		}
		
		//update
		if($this->input->post("change")=="OK"){
		
			foreach($this->input->post() as $e=>$f){
			if($e!='change'&&substr($e,0,5)!='price'){
				$input[$e]=$this->input->post($e);				
				}
			}
			$input["branch_id"]=$_SESSION['branch_id'];			
			$this->db->update("invs",$input,array("invs_id"=>$this->input->post("invs_id")));
			$data["message"]="Insert Data Success";
			//echo $this->db->last_query();die;
		}
		
		if(isset($_POST)){
			foreach($_POST as $a=>$b){
				if(substr($a,0,5)=="price"){
					$price=substr($a,5);
					$inputp["invsproduct_price"]=$b;
					$wherep["product_id"]=$price;
					$this->db->update("invsproduct",$inputp,$wherep);
					//echo $this->db->last_query();die;
				}
			}
		}
		
		return $data;
	}
	
}
