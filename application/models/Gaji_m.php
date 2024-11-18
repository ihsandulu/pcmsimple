<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class gaji_M extends CI_Model
{

	public function data()
	{
		$data = array();
		$data["message"] = "";
		//cek gaji
		if (isset($_POST['gaji_id'])) {
			$gajid["gaji_id"] = $this->input->post("gaji_id");
			$us = $this->db
				->get_where('gaji', $gajid);
			//echo $this->db->last_query();die;	
			if ($us->num_rows() > 0) {
				foreach ($us->result() as $gaji) {
					foreach ($this->db->list_fields('gaji') as $field) {
						$data[$field] = $gaji->$field;
					}
				}
			} else {
				foreach ($this->db->list_fields('gaji') as $field) {
					$data[$field] = "";
				}
			}
		}

		//upload image
		$data['uploadgaji_picture'] = "";
		if (isset($_FILES['gaji_picture']) && $_FILES['gaji_picture']['name'] != "") {
			$gaji_picture = str_replace(' ', '_', $_FILES['gaji_picture']['name']);
			$gaji_picture = date("H_i_s_") . $gaji_picture;
			if (file_exists('assets/images/gaji_picture/' . $gaji_picture)) {
				unlink('assets/images/gaji_picture/' . $gaji_picture);
			}
			$config['file_name'] = $gaji_picture;
			$config['upload_path'] = 'assets/images/gaji_picture/';
			$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
			$config['max_size']	= '3000000000';
			$config['max_width']  = '5000000000';
			$config['max_height']  = '3000000000';

			$this->load->library('upload', $config);

			if (! $this->upload->do_upload('gaji_picture')) {
				$data['uploadgaji_picture'] = "Upload Gagal !<br/>" . $config['upload_path'] . $this->upload->display_errors();
			} else {
				$data['uploadgaji_picture'] = "Upload Success !";
				$input['gaji_picture'] = $gaji_picture;
			}
		}

		//delete
		if ($this->input->post("delete") == "OK") {
			$gaji = $this->db->where("gaji_id", $this->input->post("gaji_id"))->get("gajid");
			if ($gaji->num_rows() > 0) {
				$data["message"] = "Hapus data detail gaji terlebih dahulu!";
			} else {
				if ($this->input->post("gaji_source") == "kas_id") {
					$this->db->delete("kas", array("kas_id" => $this->input->post("kas_id")));
				} else {
					$this->db->delete("petty", array("petty_id" => $this->input->post("petty_id")));
				}
				$this->db->delete("gaji", array("gaji_id" => $this->input->post("gaji_id")));
				$data["message"] = "Delete Success";
			}
		}

		//bulan romawi		
		$array_bulan = array(1 => "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
		$bulan = $array_bulan[date('n')];
		$bulan_array = array(0 => "Bulan", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

		//insert
		if ($this->input->post("create") == "OK") {

			foreach ($this->input->post() as $e => $f) {
				if ($e != 'create' && $e != 'gaji_biayades' && $e != 'gaji_biaya') {
					$input[$e] = $this->input->post($e);
				}
			}

			$nosura = $this->db
				->where("nomor_name", "Payroll")
				->get("nomor");
			if ($nosura->num_rows() > 0) {
				$nosurat = $nosura->row()->nomor_no . "-";
			} else {
				$nosurat = "PYR-";
			}

			$sjno = $this->db
				->order_by("gaji_id", "desc")
				->limit("1")
				->get("gaji");
			if ($sjno->num_rows() > 0) {
				//caribulan
				$terakhir = $sjno->row()->gaji_no;
				$blno = explode("-", $terakhir);
				$blnno = $blno[1];
				$noterakhir = end($blno);
				$identity_number = $this->db->get("identity")->row()->identity_number;
				if ($identity_number == "Monthly") {
					if ($blnno != $bulan) {
						$inno = 1;
					} else {
						$inno = $noterakhir + 1;
						//$inno=1;
					}
				}
				if ($identity_number == "Yearly") {
					if ($blno[2] != date("Y")) {
						$inno = 1;
					} else {
						$inno = $noterakhir + 1;
						//$inno=1;
					}
				}
			} else {
				$inno = 1;
			}
			$sno = $nosurat . $bulan . date("-Y-") . str_pad($inno, 5, "0", STR_PAD_LEFT);
			$input["gaji_no"] = $sno;

			$input['branch_id'] = $this->session->userdata("branch_id");
			$this->db->insert("gaji", $input);
			$gaji_id = $this->db->insert_id();
			//echo $this->db->last_query();die;


			if ($this->input->post("gajitype_id") == -1) {
				$tanggal_awal = $this->input->post("gaji_from");
				$tanggal_akhir = $this->input->post("gaji_to");
			} else {
				$gajitype = $this->db->where("gajitype_id", $input["gajitype_id"])->get("gajitype");
				foreach ($gajitype->result() as $gajitype) {
					if ($gajitype->gajitype_description == "Month") {
						$tanggal_awal = date("Y-m-01");
						$tanggal_akhir = date("Y-m-t");
					} else {
						$tanggal_awal = date("Y-m-" . $gajitype->gajitype_awaldate, strtotime("first day of -1 month"));
						$tanggal_akhir = date("Y-m-" . $gajitype->gajitype_akhirdate);
					}
				}
			}
			
			if ($this->input->post("gaji_description") == "") {
				$input["gaji_description"] = "Payroll " . $input["gaji_name"] . " Bulan:" . date("M") . " Periode" . $tanggal_awal . " s/d " . $tanggal_akhir;
			}

			/* //biaya
			$gajidb["user_id"] = $input["user_id"];
			$gajidb["gajid_name"] = $this->input->post("gaji_biayades");
			$gajidb["gaji_id"] = $gaji_id;
			$gajidb["gajid_type"] = 1;
			$gajidb["gajid_nominal"] = $this->input->post("gaji_biaya");
			$this->db->insert("gajid", $gajidb); */

			$nominaltotal = 0;
			//upah
			$tunjangan = $this->db->where("user_id", $input["user_id"])->get("tunjangan");
			foreach ($tunjangan->result() as $tunjangan) {
				$tunjangan_nominal = 0;
				$gajid["gajid_name"] = $tunjangan->tunjangan_name;
				$gajid["gaji_id"] = $gaji_id;
				$gajid["gajid_type"] = 0;
				if ($tunjangan->tunjangan_type == "harian") {
					$hari = 0;
					$basic = $tunjangan->tunjangan_nominal;
					$tunjangan_nominal = $hari * $basic;
				} else if ($tunjangan->tunjangan_type == "bulanan") {
					$tunjangan_nominal = $tunjangan->tunjangan_nominal;
				} else if ($tunjangan->tunjangan_type == "project") {
					if ($tunjangan->tunjangan_persen == "1") {
						$pengali = $tunjangan->tunjangan_nominal / 100;
					} else {
						$pengali = 1;
					}
					
					$inv = $this->db
						->select("SUM(invproduct_qty*invproduct_price)AS jml, task.task_bantuan")
						->join("invproduct", "invproduct.inv_no=inv.inv_no", "left")
						->join("task", "task.inv_no=inv.inv_no", "left")
						->where("inv_date>=", $tanggal_awal)
						->where("inv_date<=", $tanggal_akhir)
						->where("task.user_id", $input["user_id"])
						->get("inv");
					$total = 0;
					foreach ($inv->result() as $inv) {
						$total = $inv->jml;
						if ($inv->task_bantuan == 1) {
							$tunjangan_nominal = $total * 50 / 100;
						} else {
							$tunjangan_nominal = $total * $pengali;
						}
					}
				} else if ($tunjangan->tunjangan_type == "bonusomzet") {
					$inv = $this->db
						->select("SUM(invproduct_qty*invproduct_price)AS jml")
						->join("invproduct", "invproduct.inv_no=inv.inv_no", "left")
						->where("inv_date>=", $tanggal_awal)
						->where("inv_date<=", $tanggal_akhir)
						->get("inv");
					$total = 0;
					foreach ($inv->result() as $inv) {
						$total = $inv->jml;
					}


					$operator = $tunjangan->tunjangan_operator;
					$omzetawal = $tunjangan->tunjangan_omzet;
					$omzetakhir = $tunjangan->tunjangan_omzetakhir;
					if ($tunjangan->tunjangan_omzetakhir > 0) {
						if (eval("return \$total $operator \$omzetawal;") && $total <= $omzetakhir) {
							if ($tunjangan->tunjangan_persen == "1") {
								$tunjangan_nominal = $total * $tunjangan->tunjangan_nominal / 100;
							} else {
								$tunjangan_nominal = $tunjangan->tunjangan_nominal;
							}
						}
					} else {
						if (eval("return \$total $operator \$omzetawal;")) {
							if ($tunjangan->tunjangan_persen == "1") {
								$tunjangan_nominal = $total * $tunjangan->tunjangan_nominal / 100;
							} else {
								$tunjangan_nominal = $tunjangan->tunjangan_nominal;
							}
						}
					}
				}
				if ($tunjangan_nominal > 0) {
					$gajid["gajid_nominal"] = $tunjangan_nominal;
					$this->db->insert("gajid", $gajid);
					$nominaltotal += $tunjangan_nominal;
				}
			}
			if ($input["gaji_source"] == "kas_id") {
				$inputkas["kas_count"] = $nominaltotal;
				$inputkas["kas_inout"] = "out";
				$inputkas["kas_remarks"] = $input["gaji_description"];
				$inputkas["kas_date"] = date("Y-m-d");
				$this->db->insert("kas", $inputkas);
				$update["kas_id"] = $this->db->insert_id();
			}

			if ($input["gaji_source"] == "petty_id") {
				$inputpetty["petty_amount"] = $nominaltotal;
				$inputpetty["petty_inout"] = "out";
				$inputpetty["petty_remarks"] = $input["gaji_description"];
				$inputpetty["petty_date"] = date("Y-m-d");
				$this->db->insert("petty", $inputpetty);
				$update["petty_id"] = $this->db->insert_id();
			}


			$wupdate["gaji_id"] = $gaji_id;
			$this->db->where($wupdate);
			$this->db->update("gaji", $update);



			$data["message"] = "Insert Data Success";
		}

		//update
		if ($this->input->post("change") == "OK") {

			foreach ($this->input->post() as $e => $f) {
				if ($e != 'change') {
					$input[$e] = $this->input->post($e);
				}
			}
			if ($this->input->post("gaji_description") == "") {
				$input["gaji_description"] = "Payroll " . $input["gaji_name"] . " " . $bulan_array[$input["gaji_month"]] . " Periode" . $input["gaji_period"];
			}
			if ($input["gaji_source"] == "kas_id") {
				$inputkas["kas_count"] = ($input["gaji_rate"] * $input["gaji_numday"]) - $input["gaji_deduction_amount"];
				$inputkas["kas_inout"] = "out";
				$inputkas["project_id"] = $input["project_id"];
				$inputkas["kas_remarks"] = $input["gaji_description"];
				$inputkas["kas_date"] = date("Y-") . $input["gaji_month"] . date("-d");
				if ($input["kas_id"] != "0") {
					$this->db->update("kas", $inputkas, array("kas_id" => $input["kas_id"]));
				} else {
					$this->db->insert("kas", $inputkas);
					$input["kas_id"] = $this->db->insert_id();
				}
			}

			if ($input["gaji_source"] == "petty_id") {
				$inputpetty["petty_amount"] = ($input["gaji_rate"] * $input["gaji_numday"]) - $input["gaji_deduction_amount"];
				$inputpetty["petty_inout"] = "out";
				$inputpetty["project_id"] = $input["project_id"];
				$inputpetty["petty_remarks"] = $input["gaji_description"];
				$inputpetty["petty_date"] = date("Y-") . $input["gaji_month"] . date("-d");
				if ($input["petty_id"] != "0") {
					$this->db->update("petty", $inputpetty, array("petty_id" => $input["petty_id"]));
				} else {
					$this->db->insert("petty", $inputpetty);
					$input["petty_id"] = $this->db->insert_id();
				}
			}

			$input['gaji_year'] = date("Y");
			$input['branch_id'] = $this->session->userdata("branch_id");
			$this->db->update("gaji", $input, array("gaji_id" => $this->input->post("gaji_id")));
			//echo $this->db->last_query();die;
			$data["message"] = "Insert Data Success";
		}

		return $data;
	}
}
