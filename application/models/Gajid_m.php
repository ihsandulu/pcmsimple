<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class gajid_M extends CI_Model
{

	public function data()
	{
		$data = array();
		$data["message"] = "";
		//cek gajid
		if (isset($_POST['gajid_id'])) {
			$gajidd["gajid_id"] = $this->input->post("gajid_id");
			$us = $this->db
				->get_where('gajid', $gajidd);
			//echo $this->db->last_query();die;	
			if ($us->num_rows() > 0) {
				foreach ($us->result() as $gajid) {
					foreach ($this->db->list_fields('gajid') as $field) {
						$data[$field] = $gajid->$field;
					}
				}
			} else {


				foreach ($this->db->list_fields('gajid') as $field) {
					$data[$field] = "";
				}
			}
		}

		//upload image
		$data['uploadgajid_picture'] = "";
		if (isset($_FILES['gajid_picture']) && $_FILES['gajid_picture']['name'] != "") {
			$gajid_picture = str_replace(' ', '_', $_FILES['gajid_picture']['name']);
			$gajid_picture = date("H_i_s_") . $gajid_picture;
			if (file_exists('assets/images/gajid_picture/' . $gajid_picture)) {
				unlink('assets/images/gajid_picture/' . $gajid_picture);
			}
			$config['file_name'] = $gajid_picture;
			$config['upload_path'] = 'assets/images/gajid_picture/';
			$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
			$config['max_size']	= '3000000000';
			$config['max_width']  = '5000000000';
			$config['max_height']  = '3000000000';

			$this->load->library('upload', $config);

			if (! $this->upload->do_upload('gajid_picture')) {
				$data['uploadgajid_picture'] = "Upload Gagal !<br/>" . $config['upload_path'] . $this->upload->display_errors();
			} else {
				$data['uploadgajid_picture'] = "Upload Success !";
				$input['gajid_picture'] = $gajid_picture;
			}
		}

		//delete
		if ($this->input->post("delete") == "OK") {
			$this->db->delete("gajid", array("gajid_id" => $this->input->post("gajid_id")));
			$data["message"] = "Delete Success";
		}


		//insert
		if ($this->input->post("create") == "OK") {

			foreach ($this->input->post() as $e => $f) {
				if ($e != 'create' && $e != 'gajid_biayades' && $e != 'gajid_biaya' && $e != 'gajidnominal') {
					$input[$e] = $this->input->post($e);
				}
			}
			$this->db->insert("gajid", $input);
			$gajid_id = $this->db->insert_id();
			//echo $this->db->last_query();die;

			$nominal = $this->input->post("gajid_nominal");
			$type = array("out", "in");
			if ($this->input->get("gaji_source") == "kas_id") {
				$kas = $this->db->where("kas_id", $this->input->get("kas_id"))->get("kas");
				$saldo = $kas->row()->kas_count;
				$saldoakhir = 0;
				if ($this->input->post("gajid_type") == "0") {
					$saldoakhir = $saldo + $nominal;
				} else {
					$saldoakhir = $saldo - $nominal;
				}
				$inputkas["kas_count"] = $saldoakhir;
				$this->db->where("kas_id", $this->input->get("kas_id"))->update("kas", $inputkas);
			}

			if ($this->input->get("gaji_source") == "petty_id") {
				$petty = $this->db->where("petty_id", $this->input->get("petty_id"))->get("petty");
				$saldo = $petty->row()->petty_amount;
				$saldoakhir = 0;
				if ($this->input->post("gajid_type") == "0") {
					$saldoakhir = $saldo + $nominal;
				} else {
					$saldoakhir = $saldo - $nominal;
				}
				$inputpetty["petty_amount"] = $saldoakhir;
				$this->db->where("petty_id", $this->input->get("petty_id"))->update("petty", $inputpetty);
			}


			$data["message"] = "Insert Data Success";
		}

		//update
		if ($this->input->post("change") == "OK") {

			foreach ($this->input->post() as $e => $f) {
				if ($e != 'change' && $e != 'gajidnominal') {
					$input[$e] = $this->input->post($e);
				}
			}
			$this->db->update("gajid", $input, array("gajid_id" => $this->input->post("gajid_id")));
			//echo $this->db->last_query();die;
			$data["message"] = "Insert Data Success";

			$nominal = $this->input->post("gajid_nominal");
			$type = array("out", "in");
			if ($this->input->get("gaji_source") == "kas_id") {
				$kas = $this->db->where("kas_id", $this->input->get("kas_id"))->get("kas");
				$saldo = 0;
				$saldoakhir = 0;
				foreach ($kas->result() as $kas) {
					$saldo = $kas->kas_count;
					$saldo -= $this->input->post("gajidnominal");
					$saldoakhir = $saldo + $nominal;
				}

				$inputkas["kas_count"] = $saldoakhir;
				$this->db->where("kas_id", $this->input->get("kas_id"))->update("kas", $inputkas);
			}

			if ($this->input->get("gaji_source") == "petty_id") {
				$petty = $this->db->where("petty_id", $this->input->get("petty_id"))->get("petty");
				$saldo = 0;
				$saldoakhir = 0;
				foreach ($petty->result() as $petty) {
					$saldo = $petty->petty_amount;
					$saldo -= $this->input->post("gajidnominal");
					$saldoakhir = $saldo + $nominal;
				}
				$inputpetty["petty_amount"] = $saldoakhir;
				$this->db->where("petty_id", $this->input->get("petty_id"))->update("petty", $inputpetty);
			}
		}

		return $data;
	}
}
