<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class taskprint extends CI_Controller {


	public function index()
	{	$custo=$this->db
		->where("customer_id",$this->input->get("customer_id"))
		->get("customer");
		if($custo->num_rows()>0){
		foreach($custo->result() as $customer){
			foreach($this->db->list_fields('customer') as $field){
				$data[$field]=$customer->$field;
			}
		}
		}else{
			foreach($this->db->list_fields('customer') as $field){
				$data[$field]="";
			}
		}
		
		$iden=$this->db->get("identity");
		foreach($iden->result() as $identity){
			foreach($this->db->list_fields('identity') as $field){
				$data[$field]=$identity->$field;
			}
		}
		
		$in=$this->db
		->join("user","user.user_id=task.user_id","left")
		//->join("taskproduct","taskproduct.task_no=task.task_no","left")
		//->join("product","product.product_id=taskproduct.product_id","left")
		->where("task.task_no",$this->input->get("task_no"))
		->get("task");
		//echo $this->db->last_query();
		foreach($in->result() as $task){	
			foreach($this->db->list_fields('task') as $field){
				 $data[$field]=$task->$field;	
			}	
			foreach($this->db->list_fields('user') as $field){
				 $data[$field]=$task->$field;	
			}		
			/*foreach($this->db->list_fields('product') as $field){
				$data[$field]=$task->$field;			
			}
			foreach($this->db->list_fields('taskproduct') as $field){
				$data[$field]=$task->$field;			
			}*/
		
			
		}
		$this->load->view('taskprint_v',$data);
		
	}
}
