<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class parameterid extends CI_Controller {
	
	
	
	public function index()
	{
		//$this->tt = $this->load->database('tt', true);
		$equip_id=$this->input->get("equip_id");
		?>
		<option></option>
		<?php $param=$this->db
		->where("equip_id",$equip_id)
		->get("parameter");
		foreach($param->result() as $parameter){?>
		<option value="<?=$parameter->parameter_id;?>" ><?=$parameter->parameter_name;?></option>
		<?php }?>
		
		<?php
		
	}
}
