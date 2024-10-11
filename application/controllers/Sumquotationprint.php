<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sumquotationprint extends CI_Controller {


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
		->select("*,quotation.quotation_no as qno")
		->join("quotationproduct","quotationproduct.quotation_no=quotation.quotation_no","left")
		->join("product","product.product_id=quotationproduct.product_id","left")
		->where("quotation.quotation_no",$this->input->get("quotation_no"))
		->get("quotation");
		//echo $this->db->last_query();
		foreach($in->result() as $quotation){	
			foreach($this->db->list_fields('quotation') as $field){
				 $data[$field]=$quotation->$field;	
			}		
			foreach($this->db->list_fields('product') as $field){
				$data[$field]=$quotation->$field;			
			}
			foreach($this->db->list_fields('quotationproduct') as $field){
				$data[$field]=$quotation->$field;			
			}
			$data['quotation_no']=$quotation->qno;
			
		}
		$this->load->view('sumquotationprint_v',$data);
		
	}
}
