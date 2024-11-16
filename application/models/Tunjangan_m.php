<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class tunjangan_M extends CI_Model {
	
		
		function kuren_url()
		{
			$CI =& get_instance();
		
			$url = $CI->config->site_url($CI->uri->uri_string());
			return $_SERVER['QUERY_STRING'] ? $url.'?'.$_SERVER['QUERY_STRING'] : $url;
		}
		
	public function data()
	{
	
		require_once("meta_m.php");
			
		$data=array();	
		$data["message"]="";
		//cek tunjangan
		if(isset($_POST['tunjangan_id'])){
		$tunjangand["tunjangan_id"]=$this->input->post("tunjangan_id");
		$us=$this->db
		->get_where('tunjangan',$tunjangand);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $tunjangan){		
			foreach($this->db->list_fields('tunjangan') as $field)
			{
				$data[$field]=$tunjangan->$field;
			}	
		}
		}else{	
			 		
			
			foreach($this->db->list_fields('tunjangan') as $field)
			{
				$data[$field]="";
			}		
			
		}
		}
		
		//upload image
		$data['uploadtunjangan_picture']="";
		if(isset($_FILES['tunjangan_picture'])&&$_FILES['tunjangan_picture']['name']!=""){
		$tunjangan_picture=str_replace(' ', '_',$_FILES['tunjangan_picture']['name']);
		$tunjangan_picture = date("H_i_s_").$tunjangan_picture;
		if(file_exists ('assets/images/tunjangan_picture/'.$tunjangan_picture)){
		unlink('assets/images/tunjangan_picture/'.$tunjangan_picture);
		}
		$config['file_name'] = $tunjangan_picture;
		$config['upload_path'] = 'assets/images/tunjangan_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('tunjangan_picture'))
		{
			$data['uploadtunjangan_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadtunjangan_picture']="Upload Success !";
			$input['tunjangan_picture']=$tunjangan_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("tunjangan",array("tunjangan_id"=>$this->input->post("tunjangan_id")));
			if($identity->identity_stok==1){
				$this->db->delete("gudang",array("gudang_id"=>$this->input->post("gudang_id")));
			}
			$data["message"]="Delete Success";
		}
		
		
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$this->db->insert("tunjangan",$input);
			//echo $this->db->last_query();die;
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='tunjangan_picture'){$input[$e]=$this->input->post($e);}}
			$this->db->update("tunjangan",$input,array("tunjangan_id"=>$this->input->post("tunjangan_id")));
			$data["message"]="Update Success";
			// echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
