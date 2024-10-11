<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class input_schedule extends CI_Controller {


	public function index()
	{
		$this->tt = $this->load->database('tt', true);
		$message="Update Failed";
		if($this->input->get("param")=="parameter_id"){
			$this->db->update("parameter",array("parameter_schedule"=>$this->input->get("schedule")),array($this->input->get("param")=>$this->input->get("paramv")));
			$message="Update Success";
		}
		if($this->input->get("param")=="subparameter_id"){
			$this->db->update("subparameter",array("subparameter_schedule"=>$this->input->get("schedule")),array($this->input->get("param")=>$this->input->get("paramv")));
			$message="Update Success";
		}
		echo $message;
		//echo $this->db->last_query();
		
	}
}
