<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class login_M extends CI_Model
{

	public function data()
	{
		$data = array();

		//cek identity
		$us = $this->db
			->get('identity');
		//echo $this->db->last_query();die;	
		if ($us->num_rows() > 0) {
			foreach ($us->result() as $identity) {
				foreach ($this->db->list_fields('identity') as $field) {
					$data[$field] = $identity->$field;
				}
			}
		} else {
			foreach ($this->db->list_fields('identity') as $field) {
				$data[$field] = "";
			}
		}

		$data["hasil"] = "";
		if (isset($_POST["user_email"]) && isset($_POST["user_password"])) {
			foreach ($this->input->post() as $e => $f) {
				if ($e != '') {
					$input[$e] = $this->input->post($e);
				}
			}
			$user1 = $this->db
				->join("branch", "branch.branch_id=user.branch_id", "left")
				->get_where('user', $input);
			if ($user1->num_rows() > 0) {
				foreach ($user1->result() as $user) {
					foreach ($this->db->list_fields('user') as $field) {
						$this->session->set_userdata($field, $user->$field);
						//echo $this->session->userdata($field);
					}
					$this->session->set_userdata("branch_name", $user->branch_name);
				}
				redirect(site_url("utama"));
			} else {
				$data["hasil"] = " Access Denied !";
			}
		}

		return $data;
	}
}
