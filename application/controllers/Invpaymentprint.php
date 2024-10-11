<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class invpaymentprint extends CI_Controller {


	public function index()
	{	
		
		$iden=$this->db->get("identity");
		foreach($iden->result() as $identity){
			foreach($this->db->list_fields('identity') as $field){
				$data[$field]=$identity->$field;
			}
		}
		
		
		
		
		$in=$this->db
		->select("*,invpayment.invpayment_no As ino")
		->join("inv","inv.inv_no=invpayment.inv_no","left")
		->join("customer","customer.customer_id=inv.customer_id","left")
		->join("poc","poc.poc_id=inv.poc_id","left")
		->join("invpaymentproduct","invpaymentproduct.invpayment_no=invpayment.invpayment_no","left")
		->join("methodpayment","methodpayment.methodpayment_id=invpayment.methodpayment_id","left")
		->where("invpayment.invpayment_no",$this->input->get("invpayment_no"))
		->get("invpayment");
		//echo $this->db->last_query();die;
		foreach($in->result() as $invs){	
			foreach($this->db->list_fields('invpaymentproduct') as $field){
				$data[$field]=$invs->$field;			
			}
			foreach($this->db->list_fields('methodpayment') as $field){
				$data[$field]=$invs->$field;			
			}			
			foreach($this->db->list_fields('invpayment') as $field){
				 $data[$field]=$invs->$field;	
			}				
			foreach($this->db->list_fields('poc') as $field){
				 $data[$field]=$invs->$field;	
			}			
			foreach($this->db->list_fields('customer') as $field){
				 $data[$field]=$invs->$field;	
			}
			$data["invpayment_no"]=$invs->ino;
		}
		$this->load->view('invpaymentprint_v',$data);
		
	}
}
