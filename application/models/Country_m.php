<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class country_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		//cek country
		$countryd["country_id"]=$this->input->post("country_id");
		$us=$this->db
		->get_where('country',$countryd);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $country){		
				foreach($this->db->list_fields('country') as $field)
				{
					$data[$field]=$country->$field;
				}				foreach($this->db->list_fields('country') as $field)
				{
					$data[$field]=$country->$field;
				}		
			}
		}else{	
			foreach($this->db->list_fields('country') as $field)
			{
				$data[$field]="";
			}	
		}
		
		//upload image
		$data['uploadcountry_picture']="";
		if(isset($_FILES['country_picture'])&&$_FILES['country_picture']['name']!=""){
		$array = explode('.', $_FILES['country_picture']['name']);
		$extension = end($array);
		$country_picture=str_replace(' ', '_',$_FILES['country_picture']['name']);
		$country_picture=str_replace('.', '_',$country_picture);
		$country_picture=$country_picture.".".$extension;
		$country_picture = date("H_i_s_").$country_picture;
		if(file_exists ('assets/images/country_picture/'.$country_picture)){
		unlink('assets/images/country_picture/'.$country_picture);
		}
		$config['file_name'] = $country_picture;
		$config['upload_path'] = 'assets/images/country_picture/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('country_picture'))
		{
			$data['uploadcountry_picture']="Upload Gagal !<br/>".$config['upload_path'].$country_picture. $this->upload->display_errors();
		}
		else
		{
			$data['uploadcountry_picture']="Upload Success !";
			$input['country_picture']=$country_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("country",array("country_id"=>$this->input->post("country_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$this->db->insert("country",$input);
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='country_picture'){$input[$e]=$this->input->post($e);}}
			$input["country_name"]=htmlentities($input["country_name"], ENT_QUOTES);
			$this->db->update("country",$input,array("country_id"=>$this->input->post("country_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
