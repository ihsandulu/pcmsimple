<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class task_M extends CI_Model
{

	public function data()
	{
		$data = array();
		$data["message"] = "";
		//cek task
		if (isset($_POST['task_id'])) {
			$taskd["task_id"] = $this->input->post("task_id");
			$us = $this->db
				->get_where('task', $taskd);
			//echo $this->db->last_query();die;	
			if ($us->num_rows() > 0) {
				foreach ($us->result() as $task) {
					foreach ($this->db->list_fields('task') as $field) {
						$data[$field] = $task->$field;
					}
				}
			} else {


				foreach ($this->db->list_fields('task') as $field) {
					$data[$field] = "";
				}
			}
		}

		//upload image
		$data['uploadtask_picture'] = "";
		if (isset($_FILES['task_picture']) && $_FILES['task_picture']['name'] != "") {
			// Ambil nama asli file
			$original_name = $_FILES['task_picture']['name'];

			// Pisahkan nama file dan ekstensi
			$file_parts = pathinfo($original_name);
			$file_name = str_replace(' ', '_', $file_parts['filename']); // Ganti spasi jadi underscore
			$file_name = str_replace('.', '_', $file_name); // Ganti spasi jadi underscore
			$file_extension = $file_parts['extension']; // Dapatkan ekstensi file

			// Buat nama baru untuk file dengan timestamp
			$task_picture = date("H_i_s_") . $file_name . '.' . $file_extension;

			// Cek apakah file sudah ada, jika ada hapus
			if (file_exists('assets/images/task_picture/' . $task_picture)) {
				unlink('assets/images/task_picture/' . $task_picture);
			}

			// Konfigurasi upload
			$config['file_name'] = $task_picture;
			$config['upload_path'] = 'assets/images/task_picture/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size'] = '3000000000';
			$config['max_width'] = '5000000000';
			$config['max_height'] = '3000000000';

			$this->load->library('upload', $config);

			// Proses upload file
			if (!$this->upload->do_upload('task_picture')) {
				$data['uploadtask_picture'] = "Upload Gagal !<br/>" . $config['upload_path'] . $this->upload->display_errors();
			} else {
				$data['uploadtask_picture'] = "Upload Success !";
				$input['task_picture'] = $task_picture;
			}
		}


		//delete
		if ($this->input->post("delete") == "OK") {
			$this->db->delete("task", array("task_id" => $this->input->post("task_id")));
			//$this->db->delete("taskproduct",array("task_no"=>$this->input->post("task_no")));
			$data["message"] = "Delete Success";
		}

		//bulan romawi		
		$array_bulan = array(1 => "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
		$bulan = $array_bulan[date('n')];

		//insert
		if ($this->input->post("create") == "OK") {

			$nosura = $this->db
				->where("nomor_name", "Assignment")
				->get("nomor");
			if ($nosura->num_rows() > 0) {
				$nosurat = $nosura->row()->nomor_no . "-";
			} else {
				$nosurat = "ASG-";
			}

			$sjno = $this->db
				->order_by("task_id", "desc")
				->limit("1")
				->get("task");
			if ($sjno->num_rows() > 0) {
				//caribulan
				$terakhir = $sjno->row()->task_no;
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
			$input["task_no"] = $sno;
			foreach ($this->input->post() as $e => $f) {
				if ($e != 'create') {
					$input[$e] = $this->input->post($e);
				}
			}
			$this->db->insert("task", $input);
			//echo $this->db->last_query();die;

			$data["message"] = "Insert Data Success";
		}

		//update
		if ($this->input->post("change") == "OK") {

			foreach ($this->input->post() as $e => $f) {
				if ($e != 'change' && $e != 'user_name' && $e != 'customer_name' && $e != 'bantuan') {
					$input[$e] = $this->input->post($e);
				}
			}
			if(isset($input["task_picture"])){
				$input["task_done"] = date("Y-m-d H:i:s");
				$input["task_finished"] = date("Y-m-d");
			}
			$this->db->update("task", $input, array("task_id" => $this->input->post("task_id")));
			// print_r(($input));
			// echo $this->db->last_query();die;
			$data["message"] = "Update Data Success";

			if (isset($_POST["user_id"]) && $_POST["user_id"] == "0") {
				$identity = $this->db->get("identity");

				foreach ($identity->result() as $identity) {
					$server = $identity->identity_serverwa;
					$email = $identity->identity_emailwa;
					$password = $identity->identity_passwordwa;
					$user_name = $this->input->post("user_name");
					$customer_name = $this->input->post("customer_name");

					// Dapatkan token dari API
					$uri = "https://qithy.my.id/api/token?email=" . urlencode($email) . "&password=" . urlencode($password);

					$user = @file_get_contents($uri);

					if ($user === false) {
						echo "Gagal mendapatkan token. Periksa API.";
						continue;
					}

					$user = json_decode($user);

					if (!isset($user->token)) {
						echo "Gagal mendapatkan token. Respon API tidak valid.";
						continue;
					}

					$token = $user->token;

					// Ambil nomor telepon dari tabel user
					$telp = $this->db->where("position_id", "1")->get("user");

					foreach ($telp->result() as $telepon) {
						$message = "Petugas " . $user_name . " menolak tugas kunjungan ke customer " . $customer_name . ". Silahkan pilih petugas lain!";

						// Siapkan URL untuk mengirim pesan
						$urimessage = "https://qithy.my.id:8000/send-message?email=" . urlencode($email) .
							"&token=" . urlencode($token) .
							"&id=" . urlencode($server) .
							"&message=" . urlencode($message) .
							"&number=" . urlencode($telepon->user_wa);

						// Opsi untuk file_get_contents dengan User-Agent dan Timeout
						$options = [
							"http" => [
								"header" => "User-Agent: PHP\r\n", // Menambahkan User-Agent ke header
								"timeout" => 30                    // Timeout 30 detik
							]
						];

						$context = stream_context_create($options);

						$uripesan = @file_get_contents($urimessage, false, $context);

						if ($uripesan === false) {
							echo "Gagal mengirim pesan ke " . $telepon->user_wa . ".";
						} else {
							echo "Pesan berhasil dikirim ke " . $telepon->user_wa . ".";
						}
					}
				}
			}
		}

		return $data;
	}
}
