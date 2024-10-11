<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class equipid extends CI_Controller {
	
	
	
	public function index()
	{
		$this->tt = $this->load->database('tt', true);
		$vendor_id=$this->input->get("vendor_id");
		?>
		<option></option>
		<?php $eq=$this->db
		->where("vendor_id",$vendor_id)
		->get("equipment");
		foreach($eq->result() as $equ){?>
		<option value="<?=$equ->equip_id;?>" ><?=$equ->equip_name;?></option>
		<?php }?>
		
		<?php
		
	}
}
