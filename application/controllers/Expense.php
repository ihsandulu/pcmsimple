<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class expense extends CI_Controller {


	public function index()
	{	
		
		$iden=$this->db->get("identity");
		foreach($iden->result() as $identity){
			foreach($this->db->list_fields('identity') as $field){
				$data[$field]=$identity->$field;
			}
		}
		
		
		if(isset($_GET['dari'])){
			$this->db->where("invspayment_date >=",$this->input->get("dari"));
		}else{
			$this->db->where("invspayment_date >=",date("Y-m-d"));
		}
		
		if(isset($_GET['ke'])){
			$this->db->where("invspayment_date <=",$this->input->get("ke"));
		}else{
			$this->db->where("invspayment_date <=",date("Y-m-d"));
		}
		/*
		if(isset($_GET['cap'])){											
			switch($this->input->get("cap")){
				case "Project":
				$this->db->where("invspayment.project_id >",0);
				break;
				case "Office":
				$this->db->where("invspayment.project_id",0);
				break;
				default:
				break;
			}
		}		
		*/
		$in=$this->db
		->select("*,invspayment.invspayment_no As ino")
		->join("project","project.project_id=invspayment.project_id","left")
		->join("invspaymentproduct","invspaymentproduct.invspayment_no=invspayment.invspayment_no","left")
		->join("methodpayment","methodpayment.methodpayment_id=invspayment.methodpayment_id","left")
		->get("invspayment");
		//echo $this->db->last_query();die;
		if($in->num_rows()>0){
			foreach($in->result() as $invs){	
				foreach($this->db->list_fields('invspaymentproduct') as $field){
					$data[$field]=$invs->$field;			
				}
				foreach($this->db->list_fields('methodpayment') as $field){
					$data[$field]=$invs->$field;			
				}			
				foreach($this->db->list_fields('invspayment') as $field){
					 $data[$field]=$invs->$field;	
				}			
				foreach($this->db->list_fields('project') as $field){
					 $data[$field]=$invs->$field;	
				}	
				$data["invspayment_no"]=$invs->ino;
			}
		}else{
			foreach($this->db->list_fields('invspaymentproduct') as $field){
					$data[$field]="";			
				}
				foreach($this->db->list_fields('methodpayment') as $field){
					$data[$field]="";			
				}			
				foreach($this->db->list_fields('invspayment') as $field){
					 $data[$field]="";	
				}			
				foreach($this->db->list_fields('project') as $field){
					 $data[$field]="";	
				}	
				$data["invspayment_no"]="";
		}
		
		$this->load->view('expense_v',$data);
		
	}
}
