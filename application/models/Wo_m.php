<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class wo_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		$s=1;
		//cek wo
		if(isset($_POST['wo_id'])){
			$wod["wo_id"]=$this->input->post("wo_id");
			$us=$this->db
			->get_where('wo',$wod);	
			//echo $this->db->last_query();die;	
			if($us->num_rows()>0)
			{
				foreach($us->result() as $wo){		
					foreach($this->db->list_fields('wo') as $field)
					{
						$data[$field]=$wo->$field;
					}
				}
			}else{	
				foreach($this->db->list_fields('wo') as $field)
				{
					$data[$field]="";
				}	
			}
		}
		
		//upload image
		$data['uploadwo_picture']="";
		if(isset($_FILES['wo_picture'])&&$_FILES['wo_picture']['name']!=""){
		$wo_picture=str_replace(' ', '_',$_FILES['wo_picture']['name']);
		$wo_picture=str_replace('.', '_',$wo_picture);
		$wopicture=explode('.',$wo_picture,-1);
		$wo_picture=implode("",$wopicture).".jpg";
		$wo_picture = date("H_i_s_").$wo_picture;
		if(file_exists ('assets/images/wo_picture/'.$wo_picture)){
		unlink('assets/images/wo_picture/'.$wo_picture);
		}
		$config['file_name'] = $wo_picture;
		$config['upload_path'] = 'assets/images/wo_picture/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('wo_picture'))
		{
			$data['uploadwo_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
			$s=0;
		}
		else
		{
			$data['uploadwo_picture']="Upload Success !";
			$input['wo_picture']=$wo_picture;
			$s=1;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("wo",array("wo_id"=>$this->input->post("wo_id")));
			$this->db->delete("gudang",array("wo_id"=>$this->input->post("wo_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			if($s==1){
				$this->db->insert("wo",$input);
			}
			
			
			//echo $this->db->last_query();die;
			if($this->db->insert_id()>0){
			$data["message"]="Insert Data Success";
			}else{
			$data["message"]="Insert Data Failed";
			}
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='wo_picture'){$input[$e]=$this->input->post($e);}}
			if($s==1 && $input["wo_date"]!="0000-00-00" && $input["wo_date"]!=""){
				$this->db->update("wo",$input,array("wo_id"=>$this->input->post("wo_id")));
			
			
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
			}else{
				$data["message"]="Update Failed";
			}
		}
		return $data;
	}
	
}
