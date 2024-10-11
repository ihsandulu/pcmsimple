<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class input_site extends CI_Controller {


	public function index()
	{
		$this->tt = $this->load->database('tt', true);
		$message="Insert Failed";
		if($this->input->get("ket")=="Insert"){
			$this->db->insert("site",array("station_id"=>$this->input->get("station_id"),"vendor_id"=>$this->input->get("vendor_id")));
			$message="Insert Success";
		}else{
			$this->db->delete("site",array("station_id"=>$this->input->get("station_id"),"vendor_id"=>$this->input->get("vendor_id")));
			$message="Delete Success";
		
		}
		echo $message;
		//echo $this->db->last_query();
		
	}
}
