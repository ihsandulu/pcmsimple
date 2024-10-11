<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class poprint extends CI_Controller {


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
		->join("poproduct","poproduct.po_no=po.po_no","left")
		->join("product","product.product_id=poproduct.product_id","left")
		->where("po.po_no",$this->input->get("po_no"))
		->get("po");
		//echo $this->db->last_query();
		foreach($in->result() as $po){	
			foreach($this->db->list_fields('po') as $field){
				 $data[$field]=$po->$field;	
			}		
			foreach($this->db->list_fields('product') as $field){
				$data[$field]=$po->$field;			
			}
			foreach($this->db->list_fields('poproduct') as $field){
				$data[$field]=$po->$field;			
			}
		}
		$this->load->view('poprint_v',$data);
		
	}
}
