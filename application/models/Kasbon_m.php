<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class kasbon_M extends CI_Model
{

    public function data()
    {
        $data = array();
        $data["message"] = "";
        //cek kasbon
        if (isset($_POST['kasbon_id'])) {
            $kasbond["kasbon_id"] = $this->input->post("kasbon_id");
            $us = $this->db
                ->get_where('kasbon', $kasbond);
            //echo $this->db->last_query();die;	
            if ($us->num_rows() > 0) {
                foreach ($us->result() as $kasbon) {
                    foreach ($this->db->list_fields('kasbon') as $field) {
                        $data[$field] = $kasbon->$field;
                    }
                }
            } else {
                foreach ($this->db->list_fields('kasbon') as $field) {
                    $data[$field] = "";
                }
            }
        }

        //upload image
        $data['uploadkasbon_picture'] = "";
        if (isset($_FILES['kasbon_picture']) && $_FILES['kasbon_picture']['name'] != "") {
            $kasbon_picture = str_replace(' ', '_', $_FILES['kasbon_picture']['name']);
            $kasbon_picture = date("H_i_s_") . $kasbon_picture;
            if (file_exists('assets/images/kasbon_picture/' . $kasbon_picture)) {
                unlink('assets/images/kasbon_picture/' . $kasbon_picture);
            }
            $config['file_name'] = $kasbon_picture;
            $config['upload_path'] = 'assets/images/kasbon_picture/';
            $config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
            $config['max_size']    = '3000000000';
            $config['max_width']  = '5000000000';
            $config['max_height']  = '3000000000';

            $this->load->library('upload', $config);

            if (! $this->upload->do_upload('kasbon_picture')) {
                $data['uploadkasbon_picture'] = "Upload Gagal !<br/>" . $config['upload_path'] . $this->upload->display_errors();
            } else {
                $data['uploadkasbon_picture'] = "Upload Success !";
                $input['kasbon_picture'] = $kasbon_picture;
            }
        }

        //delete
        if ($this->input->post("delete") == "OK") {
            if ($this->input->post("kas_id") > 0) {
                $this->db->delete("kas", array("kas_id" => $this->input->post("kas_id")));
            }
            if ($this->input->post("petty_id") > 0) {
                $this->db->delete("petty", array("petty_id" => $this->input->post("petty_id")));
            }
            $this->db->delete("kasbon", array("kasbon_id" => $this->input->post("kasbon_id")));
            $data["message"] = "Delete Success";
        }

        //insert
        if ($this->input->post("create") == "OK") {
            foreach ($this->input->post() as $e => $f) {
                if ($e != 'create') {
                    $input[$e] = $this->input->post($e);
                }
            }

            //cek apakah diambil dari kas besar
            if (isset($input["kasbon_cash"])&&$input["kasbon_cash"] == "kas_id") {
                $inputkas["kas_count"] = $input["kasbon_amount"];
                $inputkas["kas_inout"] = "out";
                $inputkas["kas_remarks"] = $input["kasbon_remarks"];
                $inputkas["kas_date"] = $input["kasbon_date"];
                $this->db->insert("kas", $inputkas);
                $input["kas_id"] = $this->db->insert_id();
            }else {
                $inputpetty["petty_amount"] = $input["kasbon_amount"];
                $inputpetty["petty_inout"] = "out";
                $inputpetty["petty_remarks"] = $input["kasbon_remarks"];
                $inputpetty["petty_date"] = $input["kasbon_date"];
                $this->db->insert("petty", $inputpetty);
                $input["petty_id"] = $this->db->insert_id();
                $input["kasbon_cash"] = "petty_id";
            }
            $this->db->insert("kasbon", $input);
            //echo $this->db->last_query();die;

            $data["message"] = "Insert Data Success";
        }

        //update
        if ($this->input->post("change") == "OK") {

            foreach ($this->input->post() as $e => $f) {
                if ($e != 'change') {
                    $input[$e] = $this->input->post($e);
                }
            }
            // print_r( $input);die;
            //cek apakah diambil dari kas besar
            if (isset($input["kasbon_cash"])&&$input["kasbon_cash"] == "kas_id") {
                if ($this->input->post("petty_id") > 0) {
                    $this->db->delete("petty", array("petty_id" => $this->input->post("petty_id")));
                }
                $inputkas["kas_count"] = $input["kasbon_amount"];
                $inputkas["kas_inout"] = "out";
                $inputkas["kas_remarks"] = $input["kasbon_remarks"];
                $inputkas["kas_date"] = $input["kasbon_date"];
                if ($input["kas_id"] > 0) {
                    $this->db->update("kas", $inputkas, array("kas_id" => $this->input->post("kas_id")));
                } else {
                    $this->db->insert("kas", $inputkas);
                    $input["kas_id"] = $this->db->insert_id();
                    $input["petty_id"] = 0;
                }
            }else {                
                if ($this->input->post("kas_id") > 0) {
                    $this->db->delete("kas", array("kas_id" => $this->input->post("kas_id")));
                }
                $inputpetty["petty_amount"] = $input["kasbon_amount"];
                $inputpetty["petty_inout"] = "out";
                $inputpetty["petty_remarks"] = $input["kasbon_remarks"];
                $inputpetty["petty_date"] = $input["kasbon_date"];
                if ($input["petty_id"] > 0) {
                    $this->db->update("petty", $inputpetty, array("petty_id" => $this->input->post("petty_id")));
                    $input["kas_id"] = 0;
                } else {
                    $this->db->insert("petty", $inputpetty);
                    $input["petty_id"] = $this->db->insert_id();
                    $input["kas_id"] = 0;
                }
                $input["kasbon_cash"] = "petty_id";
            }
            $this->db->update("kasbon", $input, array("kasbon_id" => $this->input->post("kasbon_id")));
            $data["message"] = "Insert Data Success";
        }

        return $data;
    }
}
