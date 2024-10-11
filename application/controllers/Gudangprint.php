<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class gudangprint extends CI_Controller {


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
		->join("branch","branch.branch_id=gudang.branch_id","left")
		->join("product","product.product_id=gudang.product_id","left")
		->join("sjmasuk","sjmasuk.sjmasuk_no=gudang.sjmasuk_no","left")
		->join("supplier","supplier.supplier_id=sjmasuk.supplier_id","left")
		->join("sjkeluar","sjkeluar.sjkeluar_no=gudang.sjkeluar_no","left")
		->join("customer","customer.customer_id=sjkeluar.customer_id","left")
		->order_by("gudang_id","desc")
		->get("gudang");
		//echo $this->db->last_query();
		foreach($in->result() as $gudang){	
			foreach($this->db->list_fields('branch') as $field){
				 $data[$field]=$gudang->$field;	
			}		
			foreach($this->db->list_fields('product') as $field){
				$data[$field]=$gudang->$field;			
			}
			foreach($this->db->list_fields('sjmasuk') as $field){
				$data[$field]=$gudang->$field;			
			}
			foreach($this->db->list_fields('supplier') as $field){
				$data[$field]=$gudang->$field;			
			}
			foreach($this->db->list_fields('sjkeluar') as $field){
				$data[$field]=$gudang->$field;			
			}
			foreach($this->db->list_fields('customer') as $field){
				$data[$field]=$gudang->$field;			
			}
		
			
		}
		$this->load->view('gudangprint_v',$data);
		
	}
}
