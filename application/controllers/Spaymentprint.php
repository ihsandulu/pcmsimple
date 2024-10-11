<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class spaymentprint extends CI_Controller {


	public function index()
	{	$custo=$this->db
		->where("supplier_id",$this->input->get("supplier_id"))
		->get("supplier");
		foreach($custo->result() as $supplier){
			foreach($this->db->list_fields('supplier') as $field){
				$data[$field]=$supplier->$field;
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
		->join("invsproduct","invsproduct.invs_no=invs.invs_no","left")
		->join("product","product.product_id=invsproduct.product_id","left")
		->where("invs.invs_no",$this->input->get("invs_no"))
		->get("invs");
		//echo $this->db->last_query();
		foreach($in->result() as $invs){	
			foreach($this->db->list_fields('invs') as $field){
				 $data[$field]=$invs->$field;	
			}		
			foreach($this->db->list_fields('product') as $field){
				$data[$field]=$invs->$field;			
			}
			foreach($this->db->list_fields('invsproduct') as $field){
				$data[$field]=$invs->$field;			
			}
		
			
		}
		$this->load->view('spaymentprint_v',$data);
		
	}
}
