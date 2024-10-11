<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class test extends CI_Controller {


	public function index()
	{
		$gudang=$this->db
		->join("(SELECT inv_no AS invno,invproduct_id FROM invproduct)AS invproduct1","invproduct1.invproduct_id=gudang.invproduct_id","left")
		->get("gudang");
		//echo $this->db->last_query();
		foreach($gudang->result() as $gudang){
			$update["inv_no"]=$gudang->invno;
			$where["gudang_id"]=$gudang->gudang_id;
			if($gudang->invno!=""){$this->db->update("gudang",$update,$where);}
		}
		$this->load->view('test_v');
		
	}
}
