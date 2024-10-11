<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Acess-Control-Allow-Origin: *');

class crud extends CI_Controller {


	public function create()
	{
		foreach($_POST as $e=>$f){if($e!='logo'&&$e!='npwp'&&$e!='ttd'){$input[$e]=$this->input->post($e);}}
		$input["customer_date"]=date("Y-m-d");
		$this->db->insert('customer',$input);
		echo $data['sukses']="Inserting Data Successfully";
	}
	
	public function update()
	{
		foreach($_POST as $e=>$f){if($e!='logo'&&$e!='npwp'&&$e!='ttd'){$input[$e]=$this->input->post($e);}}
		$this->db->update('customer',$input,array("customer_id"=>$input["customer_id"]));
		echo $data['sukses']="Updating Data Successfully";
	}
	
	public function delete()
	{
		$where["customer_id"]=$this->input->post("customer_id");
		$this->db->delete('customer',$where);
		echo $data['sukses']="Deleting Data Successfully";
	}
	
	public function read()
	{
		
		$emplo=$this->db->get("customer");
		if($emplo->num_rows()>0){
			foreach($emplo->result() as $customer){
				foreach($this->db->list_fields('customer') as $field)
				{
					$data[$field]=$customer->$field;
				}
				$data1["data"][]=$data;
			}
			echo json_encode($data1);
		}else{
		//echo '{"data":[{"customer_id":"0","customer_name":"","customer_no":"","customer_address":"","customer_picture":"","customer_date":""}]}';
		}
	}
	
	public function readpartial()
	{
		$emplo=$this->db
		->where("customer_id",$this->input->get("customer_id"))
		->get("customer");
		foreach($emplo->result() as $customer){
			foreach($this->db->list_fields('customer') as $field)
			{
				$data[$field]=$customer->$field;
			}			
		}
		echo json_encode($data);
	}
}
