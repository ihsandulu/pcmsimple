<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class beritaacaraprint extends CI_Controller {


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
		->join("sjkeluarproduct","sjkeluarproduct.sjkeluar_no=sjkeluar.sjkeluar_no","left")
		->join("product","product.product_id=sjkeluarproduct.product_id","left")
		->where("sjkeluar.sjkeluar_no",$this->input->get("sjkeluar_no"))
		->get("sjkeluar");
		//echo $this->db->last_query();
		foreach($in->result() as $sjkeluar){	
			foreach($this->db->list_fields('sjkeluar') as $field){
				 $data[$field]=$sjkeluar->$field;	
			}		
			foreach($this->db->list_fields('product') as $field){
				$data[$field]=$sjkeluar->$field;			
			}
			foreach($this->db->list_fields('sjkeluarproduct') as $field){
				$data[$field]=$sjkeluar->$field;			
			}
		
			
		}
		$this->load->view('beritaacaraprint_v',$data);
		
	}
}
