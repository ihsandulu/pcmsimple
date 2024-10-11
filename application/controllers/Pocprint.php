<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class pocprint extends CI_Controller {


	public function index()
	{	$custo=$this->db
		->where("customer_id",$this->input->get("customer_id"))
		->get("customer");
		foreach($custo->result() as $customer){
			foreach($this->db->list_fields('customer') as $field){
				$data[$field]=$customer->$field;
			}
		}
		
		$iden=$this->db->get("identity");
		foreach($iden->result() as $identity){
			foreach($this->db->list_fields('identity') as $field){
				$data[$field]=$identity->$field;
			}
		}
		
		
		$identit=$this->db
		->get("identity");
		foreach($identit->result() as $identity){
			foreach($this->db->list_fields('identity') as $field){
				$data[$field]=$identity->$field;
			}
		}
		
		$in=$this->db
		->select("*,poc.poc_no as pocno")
		->join("pocproduct","pocproduct.poc_no=poc.poc_no","left")
		->join("product","product.product_id=pocproduct.product_id","left")
		->where("poc.poc_no",$this->input->get("poc_no"))
		->get("poc");
		//echo $this->db->last_query();
		foreach($in->result() as $poc){	
			foreach($this->db->list_fields('product') as $field){
				$data[$field]=$poc->$field;			
			}
			foreach($this->db->list_fields('pocproduct') as $field){
				$data[$field]=$poc->$field;			
			}
			foreach($this->db->list_fields('poc') as $field){
				 $data[$field]=$poc->$field;	
			}
			 $data["poc_no"]=$poc->pocno;		
		
			
		}
		$this->load->view('pocprint_v',$data);
		
	}
}
