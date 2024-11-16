<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");

// Pastikan PhpSpreadsheet di-autoload dengan benar
require_once FCPATH . 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class customer_M extends CI_Model
{
	public function data()
	{
		$data = array();
		$data["message"] = "";

		// Cek customer
		$customerd["customer_id"] = $this->input->post("customer_id");
		$us = $this->db->get_where('customer', $customerd);

		if ($us->num_rows() > 0) {
			foreach ($us->result() as $customer) {
				foreach ($this->db->list_fields('customer') as $field) {
					$data[$field] = $customer->$field;
				}
			}
		} else {
			foreach ($this->db->list_fields('customer') as $field) {
				$data[$field] = "";
			}
		}

		// Upload image
		$data['uploadcustomer_picture'] = "";
		if (isset($_FILES['customer_picture']) && $_FILES['customer_picture']['name'] != "") {
			$customer_picture = str_replace(' ', '_', $_FILES['customer_picture']['name']);
			$customer_picture = date("H_i_s_") . $customer_picture;
			if (file_exists('assets/images/customer_picture/' . $customer_picture)) {
				unlink('assets/images/customer_picture/' . $customer_picture);
			}
			$config['file_name'] = $customer_picture;
			$config['upload_path'] = 'assets/images/customer_picture/';
			$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
			$config['max_size']	= '3000000000';
			$config['max_width']  = '5000000000';
			$config['max_height']  = '3000000000';

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('customer_picture')) {
				$data['uploadcustomer_picture'] = "Upload Gagal !<br/>" . $config['upload_path'] . $this->upload->display_errors();
			} else {
				$data['uploadcustomer_picture'] = "Upload Success !";
				$input['customer_picture'] = $customer_picture;
			}
		}

		// Import file Excel
		if (isset($_POST['import'])) {
			if ($_FILES['filecustomer']['name'] != "") {
				$file = $_FILES['filecustomer']['tmp_name'];
				$spreadsheet = IOFactory::load($file);
				$sheet = $spreadsheet->getActiveSheet();
				$rows = $sheet->toArray();
				$gagal = 0;
				$sukses = 0;
				$rowsFilled = array_filter($rows, function ($row) {
					return array_filter($row); // Menghapus baris jika semua kolom kosong
				});
				// echo count($rowsFilled);die;
				for ($x = 1; $x < count($rowsFilled); $x++) {
					$arr_data = $rowsFilled[$x];
					$customer = $this->db
						->where("customer.customer_wa", $arr_data[7])
						->get("customer");
					$customer_id = 0;
					$customernumrows = $customer->num_rows();
					foreach ($customer->result() as $cust) {
						$customer_id = $cust->customer_id;
					}

					$branch = $this->db->where("branch_name", $arr_data[1])->get("branch");
					$branch_id = 0;
					foreach ($branch->result() as $br) {
						$branch_id = $br->branch_id;
					}

					$hunian = $this->db->where("hunian_name", $arr_data[2])->get("hunian");
					$hunian_id = 0;
					foreach ($hunian->result() as $hn) {
						$hunian_id = $hn->hunian_id;
					}

					$input = array(
						"customer_date" => $arr_data[0],
						"branch_id" => $branch_id,
						"hunian_id" => $hunian_id,
						"customer_name" => $arr_data[3],
						"customer_email" => $arr_data[4],
						"customer_address" => $arr_data[5],
						"customer_phone" => $arr_data[6],
						"customer_wa" => $arr_data[7],
						"customer_cp" => $arr_data[8],
						"customer_ktp" => $arr_data[9],
						"customer_npwp" => $arr_data[10],
						"customer_fax" => $arr_data[11]
					);
					// print_r($input);
					if ($customernumrows > 0) {
						$where1["customer_id"] = $customer_id;
						$this->db->update("customer", $input, $where1);
						$sukses++;
					} else {
						$this->db->insert("customer", $input);
						// echo $this->db->last_query();
						// die;
						$sukses++;
					}
				}
				$data["sukses"] = $sukses;
				$data["gagal"] = $gagal;
				$data["message"] = "Import Excel Success = " . $sukses . ", Failed = " . $gagal;
			}
		}

		// Delete
		if ($this->input->post("delete") == "OK") {
			$this->db->delete("customer", array("customer_id" => $this->input->post("customer_id")));
			$data["message"] = "Delete Success";
		}

		// Insert
		if ($this->input->post("create") == "OK") {
			$input = array();
			foreach ($this->input->post() as $e => $f) {
				if ($e != 'create') {
					$input[$e] = $this->input->post($e);
				}
			}
			$input["customer_date"] = date("Y-m-d");
			$this->db->insert("customer", $input);
			$data["message"] = "Insert Data Success";
		}

		// Update
		if ($this->input->post("change") == "OK") {
			$input = array();
			foreach ($this->input->post() as $e => $f) {
				if ($e != 'change' && $e != 'customer_picture') {
					$input[$e] = $this->input->post($e);
				}
			}
			$input["customer_name"] = htmlentities($input["customer_name"], ENT_QUOTES);
			$this->db->update("customer", $input, array("customer_id" => $this->input->post("customer_id")));
			$data["message"] = "Update Success";
		}

		return $data;
	}
}
