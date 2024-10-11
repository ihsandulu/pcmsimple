<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class quotationprint extends CI_Controller {


	public function index()
	{	$custo=$this->db
		->where("customer_id",$this->input->get("customer_id"))
		->get("customer");
		foreach($custo->result() as $customer){
			foreach($this->db->list_fields('customer') as $field){
				 $data[$field]=$customer->$field;
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
		->join("project","project.project_id=quotation.project_id","left")
		->join("quotationproduct","quotationproduct.quotation_id=quotation.quotation_id","left")
		->join("product","product.product_id=quotationproduct.product_id","left")
		->where("quotation.quotation_id",$this->input->get("quotation_id"))
		->get("quotation");
		//echo $this->db->last_query();
		if($in->num_rows()>0){
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
			if($data["identity_project"]==1){
				foreach($this->db->list_fields('project') as $field){
					$data[$field]=$quotation->$field;			
				}
			}else{
				foreach($this->db->list_fields('project') as $field){
					$data[$field]="";			
				}
			}
		
			
		}
		}else{
			foreach($this->db->list_fields('quotation') as $field){
				 $data[$field]="";	
			}		
			foreach($this->db->list_fields('product') as $field){
				$data[$field]="";			
			}
			foreach($this->db->list_fields('quotationproduct') as $field){
				$data[$field]="";			
			}
			foreach($this->db->list_fields('project') as $field){
					$data[$field]="";			
			}
		}
		$this->load->view('quotationprint_v',$data);
		
	}
}
