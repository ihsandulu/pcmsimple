<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class taskproduct_M extends CI_Model
{

	public function data()
	{
		$data = array();
		$data["message"] = "";
		$s = 1;
		//cek invproduct
		if (isset($_POST['invproduct_id'])) {
			$invproductd["invproduct_id"] = $this->input->post("invproduct_id");
			$us = $this->db
				->join("product", "product.product_id=invproduct.product_id", "left")
				->get_where('invproduct', $invproductd);
			//echo $this->db->last_query();die;	
			if ($us->num_rows() > 0) {
				foreach ($us->result() as $invproduct) {
					foreach ($this->db->list_fields('invproduct') as $field) {
						$data[$field] = $invproduct->$field;
					}
					foreach ($this->db->list_fields('product') as $field) {
						$data[$field] = $invproduct->$field;
					}
				}
			} else {


				foreach ($this->db->list_fields('invproduct') as $field) {
					$data[$field] = "";
				}
				foreach ($this->db->list_fields('product') as $field) {
					$data[$field] = "";
				}
			}
		}

		//upload image
		$data['uploadinvproduct_picture'] = "";
		if (isset($_FILES['invproduct_picture']) && $_FILES['invproduct_picture']['name'] != "") {
			$invproduct_picture = str_replace(' ', '_', $_FILES['invproduct_picture']['name']);
			$invproduct_picture = str_replace('.', '_', $invproduct_picture);
			$invproductpicture = explode('.', $invproduct_picture, -1);
			$invproduct_picture = implode("", $invproductpicture) . ".jpg";
			$invproduct_picture = date("H_i_s_") . $invproduct_picture;
			if (file_exists('assets/images/invproduct_picture/' . $invproduct_picture)) {
				unlink('assets/images/invproduct_picture/' . $invproduct_picture);
			}
			$config['file_name'] = $invproduct_picture;
			$config['upload_path'] = 'assets/images/invproduct_picture/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
			$config['max_size']	= '3000000000';
			$config['max_width']  = '5000000000';
			$config['max_height']  = '3000000000';

			$this->load->library('upload', $config);

			if (! $this->upload->do_upload('invproduct_picture')) {
				$data['uploadinvproduct_picture'] = "Upload Gagal !<br/>" . $config['upload_path'] . $this->upload->display_errors();
				$s = 0;
			} else {
				$data['uploadinvproduct_picture'] = "Upload Success !";
				$input['invproduct_picture'] = $invproduct_picture;
				$s = 1;
			}
		}

		//delete
		if ($this->input->post("delete") == "OK") {
			$this->db->delete("invproduct", array("invproduct_id" => $this->input->post("invproduct_id")));
			$data["message"] = "Delete Success";
		}

		//insert
		if ($this->input->post("create") == "OK") {
			foreach ($this->input->post() as $e => $f) {
				if ($e != 'create') {
					$input[$e] = $this->input->post($e);
				}
			}
			if ($s == 1) {
				$this->db->insert("invproduct", $input);
			}


			//echo $this->db->last_query();die;
			$data["message"] = "Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if ($this->input->post("change") == "OK") {
			foreach ($this->input->post() as $e => $f) {
				if ($e != 'change' && $e != 'invproduct_picture') {
					$input[$e] = $this->input->post($e);
				}
			}

			$this->db->update("invproduct", $input, array("invproduct_id" => $this->input->post("invproduct_id")));


			$data["message"] = "Update Success";
			//echo $this->db->last_query();die;

		}
		return $data;
	}
}
