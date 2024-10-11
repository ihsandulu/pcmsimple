<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

date_default_timezone_set("Asia/Bangkok");
/*
* sebelum update script mohon synch code dulu
*/
class apiw extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->djson(array("connect"=>"ok"));
    }
	
	public function login() {
    	$username = $this->input->post("username");
    	$password = $this->input->post("password");
    	$token = "";
    	$message = ""; 
		$ar = "";
		$result = ""; 
		
    	if(empty($username) && empty($password)){
    		$status = "failed";
    		$message = "Username or Password Failed";
    	}
    	else{
	    	$check = $this->db->get_where("user", array("user_name"=>$username, "user_password"=>$password))->num_rows();
	    	if(!empty($check)){
				$query = "SELECT 
							u.user_id, u.user_name, u.user_email, u.position_id, p.position_name, b.branch_name 
						FROM 
							USER u INNER JOIN POSITION p ON u.position_id = p.position_id 
							INNER JOIN branch b ON u.branch_id = b.branch_id 
						WHERE u.user_name='". $username ."' AND user_password='".$password."'";
	    		// $r = $this->db->get_where("user", array("user_name"=>$username))->row();
				$r = $this->db->query($query)->row();
	    		if($r->position_id!="99"){
		    		$status = "success";
    				$message = "Login Berhasil";
		    		$ar = array(
		    			"user_id"=>trim($r->user_id),
		    			"user_name"=>trim($r->user_name),
						"user_email"=>trim($r->user_email),
						"position_name"=>trim($r->position_name),
						"branch_name"=>trim($r->branch_name)
		    		);
	    		}
	    		else{
	    			$status = "access";
	    			$message = "Akses Anda Tidak Di ijinkan";
	    		}
	    	}
	    	else{
	    		$status = "failed";
    			$message = "Username or Password Failed";
	    	}
    	}
		
		$result['status'] = trim($status);
		$result['message'] = trim($message);
		if(!empty($ar)) {
			$result['user_id'] = $ar['user_id'];
			$result['user_name'] = $ar['user_name'];
			$result['user_email'] = $ar['user_email'];
			$result['position_name'] = $ar['position_name'];
			$result['branch_name'] = $ar['branch_name'];
		}
			// $result['data'] = $ar;
		
		$this->djson($result);
		
    	// $this->djson(array(
    		// "status"=>trim($status),
    		// "message"=>trim($message),
    		// "data"=>$ar
    	// ));

   }
   
   
   public function login2() {
    	$username = $this->input->post("username");
    	$password = $this->input->post("password");
    	$token = $this->input->post("token");
    	$message = "";
		$ar = "";
		$initialSuspects= "";
		$stations = "";
		$result = "";
		
		$ticketSummaries = null;
		$ticketSeveritySummaries = null;
		$ticketSeverityTypeSummaries = null;
		
    	if(empty($username) && empty($password)){
    		$status = "failed";
    		$message = "Username or Password Failed";
    	}
    	else{
	    	$check = $this->db->get_where("user", array("user_name"=>$username, "user_password"=>$password))->num_rows();
	    	if(!empty($check)){
				$qUpdateToken = "UPDATE user SET fcm_registered_id='".$token."' WHERE user_name = '".$username."'";
				if($this->db->query($qUpdateToken)) {
					// $query = "SELECT 
							// u.user_id, u.user_name, u.user_email, u.position_id, p.position_name, u.station_id, u.fcm_registered_id, st.station_name, rg.region_id, rg.region_name, u.user_picture 
						// FROM 
							// USER u INNER JOIN POSITION p ON u.position_id = p.position_id 
							// INNER JOIN station st ON u.station_id=st.station_id
							// INNER JOIN region rg ON u.region_id=rg.region_id
						// WHERE u.user_name='". $username ."' AND user_password='".$password."'";
						$query = "SELECT 
							u.user_id, u.user_name, u.user_email, u.position_id, p.position_name, u.station_id, u.fcm_registered_id, st.station_name, rg.region_id, rg.region_name, u.user_picture, u.department_id, d.department_name  
						FROM 
							USER u INNER JOIN POSITION p ON u.position_id = p.position_id 
							LEFT JOIN station st ON u.station_id=st.station_id
							LEFT JOIN region rg ON u.region_id=rg.region_id
							LEFT JOIN department d ON u.department_id = d.department_id
						WHERE u.user_name='". $username ."' AND user_password='".$password."'";
						// echo $query;exit;
					$r = $this->db->query($query)->row();
					$pos = $r->position_id;
					if($pos!='9'){
						$status = "success";
						$message = "Login Berhasil";
						$ar = array(
							"user_id"=>$r->user_id,
							"user_name"=>trim($r->user_name),
							"user_email"=>trim($r->user_email),
							"position_id"=>trim($pos),
							"position_name"=>trim($r->position_name),
							"fcm_registered_id"=>trim($r->fcm_registered_id),
							"station_id"=>trim($r->station_id),
							"station_name"=>trim($r->station_name),
							"region_id"=>trim($r->region_id),
							"region_name"=>trim($r->region_name),
							"user_picture"=>trim($r->user_picture),
							"department_id"=>trim($r->department_id),
							"department_name"=>trim($r->department_name)
						);
						
						$initialSuspects = $this->db->query('SELECT suspect_id, suspect_module, suspect_name FROM initial_suspect')->result_array();
						$stations = $this->db->query('SELECT station_id, station_name FROM station')->result_array();
						$downtimesuspects1= $this->db->query('SELECT isuspect1_id as suspect_id, isuspect1_name as suspect_name FROM isuspect1 WHERE suspect_module=1')->result_array();
						$severitytime= $this->db->query('SELECT severity_name, severity_time FROM severity')->result_array();
						
						
						if($pos=='2'){
							$ticketSummaries = $this->countsummariesbystation($r->station_id);
							$ticketSeveritySummaries = $this->countseveritysummariesbystation($r->station_id);
							$ticketSeverityTypeSummaries = $this->countseveritysummariesbystationandtype($r->station_id);
						}
						
						if($pos=='3' || $pos=='4'){
							$ticketSummaries = $this->countsummariesbyregion($r->region_id);
							$ticketSeveritySummaries = $this->countseveritysummariesbyregion($r->region_id);
							$ticketSeverityTypeSummaries = $this->countseveritysummariesbyregionandtype($r->region_id);
						}
						
					} else{
						$status = "access";
						$message = "Akses Anda Tidak Di ijinkan";
					}
				}
				
	    	} else{
	    		$status = "failed";
    			$message = "Username or Password Failed";
	    	}
    	}
		
		$result['status'] = trim($status);
		$result['message'] = trim($message);
		if(!empty($ar)) {
			$result['userlogin'] = $ar;
			$result['initialsuspects'] = $initialSuspects;
			$result['stations'] = $stations;
			$result['ticketsummaries'] = $ticketSummaries;
			$result['ticketseveritysummaries'] = $ticketSeveritySummaries;
			$result['ticketseveritytypesummaries'] = $ticketSeverityTypeSummaries;
			$result['downtimesuspects1'] = $downtimesuspects1;
			$result['severitytime'] = $severitytime;
		}
			// $result['data'] = $ar;
		
		$this->djson($result);
		
   }
   
   public function refresh_token() {
    	$from = $this->input->post("token_from");
    	$user_id= $this->input->post("user_id");
    	$token = $this->input->post("token_data");
		$status = "";
		$message = "";
		
		$query = "UPDATE user SET fcm_registered_id='".$token."' WHERE user_id=".$user_id;
		if($this->db->query($query)) {
			$status = "success";
			$message = "Token saved successfully";
		} else {
			$status = "failed";
			$message = "Token saved failed";
		}
		$this->djson(array(
			"status"=>$status,
			"message"=>$message
		));
		
		

   }
   
   
	public function equipments() {
		$res = $this->db->query('SELECT equip_id, equip_name FROM equipment')->result_array();
		$this->djson(array(
    		"data"=>$res
    	));
	}
	
	public function initialsuspects() {
		$res = $this->db->query('SELECT suspect_id, suspect_module, suspect_name FROM initial_suspect')->result_array();
		$this->djson(array(
			"status"=>"success",
			"message"=>"data found",
    		"data"=>$res
    	));
		// $this->djson($res);
	}
	
	public function downtime_suspect_1() {
		$res = $this->db->query('SELECT isuspect1_id as suspect_id, isuspect1_name as suspect_name FROM isuspect1 WHERE suspect_module=1')->result_array();
		$this->djson(array(
			"status"=>"success",
			"message"=>"data found",
    		"data"=>$res
    	));
		// $this->djson($res);
	}
	
	public function downtime_suspect_2() {
		$id = $this->input->post("id");
		$res = $this->db->query('SELECT isuspect2_id as suspect_id, isuspect2_name as suspect_name, isuspect1_id as parent_id FROM isuspect2 WHERE isuspect1_id='.$id)->result_array();
		$this->djson(array(
			"status"=>"success",
			"message"=>"data found",
    		"data"=>$res
    	));
		// $this->djson($res);
	}
	
	public function downtime_suspect_3() {
		$id = $this->input->post("id");
		$res = $this->db->query('SELECT isuspect3_id as suspect_id, isuspect3_name as suspect_name, isuspect2_id as parent_id FROM isuspect3 WHERE isuspect2_id='.$id)->result_array();
		$this->djson(array(
			"status"=>"success",
			"message"=>"data found",
    		"data"=>$res
    	));
		// $this->djson($res);
	}
	
	public function stations() {
		$res = $this->db->query('SELECT station_id, station_name FROM station')->result_array();
		$this->djson(array(
			"status"=>"success",
			"message"=>"data found",
    		"data"=>$res
    	));
		// $this->djson($res);
	}
	
	public function downtimedd() {
		$resIS = $this->db->query('SELECT suspect_id, suspect_module, suspect_name FROM initial_suspect')->result_array();
		$resST = $this->db->query('SELECT station_id, station_name FROM station')->result_array();
		$this->djson(array(
			"status"=>"success",
			"message"=>"data found",
    		"initialsuspects"=>$resIS,
			"stations"=>$resST
    	));
		// $this->djson($res);
	}
	
	public function new_ticket() {
		$ticket_type= $this->input->post("ticket_type");
		$ticket_station_id= $this->input->post("ticket_station_id");
		$ticket_suspect_id= $this->input->post("ticket_suspect_id");
		$ticket_creator_id= $this->input->post("ticket_creator_id");
		$ticket_remarks= $this->input->post("ticket_remarks");
		$ticket_photo_1= empty($this->input->post("ticket_photo_1")) ? null : $this->input->post("ticket_photo_1");
		$ticket_photo_2= empty($this->input->post("ticket_photo_2")) ? null : $this->input->post("ticket_photo_2");
		$ticket_photo_3= empty($this->input->post("ticket_photo_3")) ? null : $this->input->post("ticket_photo_3");
		$ticket_severity = $this->input->post("ticket_severity");
		$ticket_status= $this->input->post("ticket_status");
		$query = "INSERT INTO ticket(ticket_type, ticket_station_id, ticket_suspect_id, ticket_creator_id, ticket_remarks, ticket_photo_1, ticket_photo_2, ticket_photo_3, ticket_severity, ticket_status) 
					VALUES(".$ticket_type.", ".$ticket_station_id.", ".$ticket_suspect_id.", ".$ticket_creator_id.", '".$ticket_remarks."', '".$ticket_photo_1."', '".$ticket_photo_2."', '".$ticket_photo_3."', ".$ticket_severity.", ".$ticket_status.")";
		if($this->db->query($query)) {
			$id = $this->db->insert_id();
			$sQuery = "SELECT 
				t.ticket_id, t.ticket_date, t.ticket_type, t.ticket_station_id, s.station_name, t.ticket_suspect_id, iss.suspect_name, t.ticket_creator_id, u.user_name, t.ticket_remarks, t.ticket_severity, t.ticket_status 
				FROM ticket t 
				INNER JOIN station s ON t.ticket_station_id=s.station_id 
				INNER JOIN initial_suspect iss ON t.ticket_suspect_id = iss.suspect_id
				INNER JOIN USER u ON t.ticket_creator_id = u.user_id
				WHERE t.ticket_id=".$id;
			$result = $this->db->query($sQuery)->row();
			$this->djson(array(
				"status"=>"success",
				"message"=>"new ticket has been saved",
				"data"=>$result
			));
		} else {
			$this->djson(array(
				"status"=>"failed",
				"message"=>"new ticket not have been saved"
			));
		}
	
	}
	
	public function new_ticket2() {
		$uploadstatus_1 = "";
		$file_1 = "";
		$uploadstatus_2 = "";
		$file_2 = "";
		$uploadstatus_3 = "";
		$file_3 = "";
				
		$ticket_type= $this->input->post("ticket_type");
		$ticket_station_id= $this->input->post("ticket_station_id");
		$ticket_suspect_id= $this->input->post("ticket_suspect_id");
		$ticket_creator_id= $this->input->post("ticket_creator_id");
		$ticket_remarks= $this->input->post("ticket_remarks");
		$ticket_severity = $this->input->post("ticket_severity");
		$ticket_status= $this->input->post("ticket_status");
		
		$isuspect1= $this->input->post("suspect1");
		$isuspect2= $this->input->post("suspect2");
		$isuspect3= $this->input->post("suspect3");
		
		
		$ticket_no = $this->get_ticket_no($ticket_type);
		
		$cekdouble=$this->db
			->where("ticket_remarks",$ticket_remarks)
			->where("ticket_creator_id",$ticket_creator_id)
			->where("ticket_severity",$ticket_severity)
			->where("SUBSTR(ticket_date,1,13)",date("Y-m-d H"))
			->get("ticket")->num_rows();
		if($cekdouble==0){
		$target_path = "assets/images/ticket/";
		if(!empty(@basename($_FILES['ticket_photo_1']['name']))){
			$filename = basename($_FILES['ticket_photo_1']['name']);
			$target_paths = $target_path . $filename;
			if (!move_uploaded_file($_FILES['ticket_photo_1']['tmp_name'], $target_paths)) {
				$uploadstatus_1 .= "gagal";
			} else{
				$file_1 = $target_paths;
				$uploadstatus_1 .= "sukses,";
			}
		}
		if(!empty(@basename($_FILES['ticket_photo_2']['name']))){
			$filename = basename($_FILES['ticket_photo_2']['name']);
			$target_paths = $target_path . $filename;
			if (!move_uploaded_file($_FILES['ticket_photo_2']['tmp_name'], $target_paths)) {
				$uploadstatus_2 .= "gagal";
			} else{
				$file_2 = $target_paths;
				$uploadstatus_2 .= "sukses,";
			}
		}
		if(!empty(@basename($_FILES['ticket_photo_3']['name']))){
			$filename = basename($_FILES['ticket_photo_3']['name']);
			$target_paths = $target_path . $filename;
			if (!move_uploaded_file($_FILES['ticket_photo_3']['tmp_name'], $target_paths)) {
				$uploadstatus_3 .= "gagal";
			} else{
				$file_3 = $target_paths;
				$uploadstatus_3 .= "sukses,";
			}
		}
		
		
		$query = "INSERT INTO ticket(
				ticket_type, ticket_station_id, ticket_suspect_id, ticket_creator_id, ticket_remarks, 
				ticket_photo_1, ticket_photo_2, ticket_photo_3, ticket_severity, ticket_status, 
				ticket_no, isuspect1_id, isuspect2_id, isuspect3_id) 
					VALUES(".$ticket_type.", ".$ticket_station_id.", ".$ticket_suspect_id.", ".$ticket_creator_id.", '".$ticket_remarks."', 
					'".$file_1."', '".$file_2."', '".$file_3."', ".$ticket_severity.", ".$ticket_status.", 
					'".$ticket_no."', '".$isuspect1."', '".$isuspect2."', '".$isuspect3."')";
		if($this->db->query($query)) {
			$id = $this->db->insert_id();
			$this->db->delete("ticket",array("ticket_id >"=>$ticket_id,"ticket_remarks"=>$ticket_remarks,"ticket_creator_id"=>$ticket_creator_id));			
			
			$sQuery = "SELECT 
				t.ticket_id, t.ticket_date, t.ticket_type, t.ticket_station_id, s.station_name, t.ticket_suspect_id, iss.suspect_name, t.ticket_creator_id, u.user_name, t.ticket_remarks, t.ticket_severity, t.ticket_status, t.ticket_no, t.isuspect1_id,t.isuspect2_id,t.isuspect3_id 
				FROM ticket t 
				INNER JOIN station s ON t.ticket_station_id=s.station_id 
				LEFT JOIN initial_suspect iss ON t.ticket_suspect_id = iss.suspect_id
				INNER JOIN USER u ON t.ticket_creator_id = u.user_id
				WHERE t.ticket_id=".$id;
			$result = $this->db->query($sQuery)->row();
			
			$desc = "Ticket ".$result->ticket_no." created by ".$result->user_name." on ".$result->ticket_date;
			
			//insert ticket_id to table ticket_log
			$this->save_ticket_log2($result->ticket_no, $result->ticket_date, $desc, 'Done', $result->ticket_id, 0, 0, 0, 0, 0);
			
			
			$this->djson(array(
				"status"=>"success",
				"message"=>"new ticket has been saved",
				"uploadstatus_1"=> $uploadstatus_1,
				"uploadstatus_2"=> $uploadstatus_2,
				"uploadstatus_3"=> $uploadstatus_3,
				"data"=>$result
			));
		} else {
			$this->djson(array(
				"status"=>"failed",
				"message"=>"new ticket not have been saved",
				"uploadstatus_1"=> $uploadstatus_1,
				"uploadstatus_2"=> $uploadstatus_2,
				"uploadstatus_3"=> $uploadstatus_3
			));
		}
		}
	}
	
	/*public function new_ticket2() {
		$uploadstatus_1 = "";
		$file_1 = "";
		$uploadstatus_2 = "";
		$file_2 = "";
		$uploadstatus_3 = "";
		$file_3 = "";
				
		$ticket_type= $this->input->post("ticket_type");
		$ticket_station_id= $this->input->post("ticket_station_id");
		$ticket_suspect_id= $this->input->post("ticket_suspect_id");
		$ticket_creator_id= $this->input->post("ticket_creator_id");
		$ticket_remarks= $this->input->post("ticket_remarks");
		$ticket_severity = $this->input->post("ticket_severity");
		$ticket_status= $this->input->post("ticket_status");
		
		
		$ticket_no = $this->get_ticket_no($ticket_type);
		
		$target_path = "assets/images/ticket/";
		if(!empty(@basename($_FILES['ticket_photo_1']['name']))){
			$filename = basename($_FILES['ticket_photo_1']['name']);
			$target_paths = $target_path . $filename;
			if (!move_uploaded_file($_FILES['ticket_photo_1']['tmp_name'], $target_paths)) {
				$uploadstatus_1 .= "gagal";
			} else{
				$file_1 = $target_paths;
				$uploadstatus_1 .= "sukses,";
			}
		}
		if(!empty(@basename($_FILES['ticket_photo_2']['name']))){
			$filename = basename($_FILES['ticket_photo_2']['name']);
			$target_paths = $target_path . $filename;
			if (!move_uploaded_file($_FILES['ticket_photo_2']['tmp_name'], $target_paths)) {
				$uploadstatus_2 .= "gagal";
			} else{
				$file_2 = $target_paths;
				$uploadstatus_2 .= "sukses,";
			}
		}
		if(!empty(@basename($_FILES['ticket_photo_3']['name']))){
			$filename = basename($_FILES['ticket_photo_3']['name']);
			$target_paths = $target_path . $filename;
			if (!move_uploaded_file($_FILES['ticket_photo_3']['tmp_name'], $target_paths)) {
				$uploadstatus_3 .= "gagal";
			} else{
				$file_3 = $target_paths;
				$uploadstatus_3 .= "sukses,";
			}
		}
		
		
		$query = "INSERT INTO ticket(ticket_type, ticket_station_id, ticket_suspect_id, ticket_creator_id, ticket_remarks, ticket_photo_1, ticket_photo_2, ticket_photo_3, ticket_severity, ticket_status, ticket_no) 
					VALUES(".$ticket_type.", ".$ticket_station_id.", ".$ticket_suspect_id.", ".$ticket_creator_id.", '".$ticket_remarks."', '".$file_1."', '".$file_2."', '".$file_3."', ".$ticket_severity.", ".$ticket_status.", '".$ticket_no."')";
		if($this->db->query($query)) {
			$id = $this->db->insert_id();
			
			$sQuery = "SELECT 
				t.ticket_id, t.ticket_date, t.ticket_type, t.ticket_station_id, s.station_name, t.ticket_suspect_id, iss.suspect_name, t.ticket_creator_id, u.user_name, t.ticket_remarks, t.ticket_severity, t.ticket_status, t.ticket_no 
				FROM ticket t 
				INNER JOIN station s ON t.ticket_station_id=s.station_id 
				INNER JOIN initial_suspect iss ON t.ticket_suspect_id = iss.suspect_id
				INNER JOIN USER u ON t.ticket_creator_id = u.user_id
				WHERE t.ticket_id=".$id;
			$result = $this->db->query($sQuery)->row();
			$desc = "Ticket ".$result->ticket_no." created by ".$result->user_name." on ".$result->ticket_date;
			$this->save_ticket_log($result->ticket_no, $result->ticket_date, $desc, 'Done');
			$this->djson(array(
				"status"=>"success",
				"message"=>"new ticket has been saved",
				"uploadstatus_1"=> $uploadstatus_1,
				"uploadstatus_2"=> $uploadstatus_2,
				"uploadstatus_3"=> $uploadstatus_3,
				"data"=>$result
			));
		} else {
			$this->djson(array(
				"status"=>"failed",
				"message"=>"new ticket not have been saved",
				"uploadstatus_1"=> $uploadstatus_1,
				"uploadstatus_2"=> $uploadstatus_2,
				"uploadstatus_3"=> $uploadstatus_3
			));
		}
	
	}*/
	
	public function close_ticket() {
		$ticket_id= $this->input->post("ticket_id");
		$ticket_closedby = $this->input->post("ticket_closedby");
		$addInfo = $this->input->post("additional_info");
		$query = "UPDATE ticket SET ticket_status=2, ticket_closedby='".$ticket_closedby."' WHERE ticket_id=".$ticket_id;
		if($this->db->query($query)) {
			// $sQuery = "SELECT 
				// t.ticket_id, t.ticket_date, t.ticket_no, t.ticket_type, t.ticket_station_id, s.station_name, t.ticket_suspect_id, iss.suspect_name, t.ticket_creator_id, u.user_name, t.ticket_remarks, t.ticket_severity, t.ticket_status 
				// FROM ticket t 
				// INNER JOIN station s ON t.ticket_station_id=s.station_id 
				// INNER JOIN initial_suspect iss ON t.ticket_suspect_id = iss.suspect_id
				// INNER JOIN USER u ON t.ticket_creator_id = u.user_id
				// WHERE t.ticket_id=".$ticket_id;
				$sQuery = "SELECT 
				t.ticket_id, t.ticket_date, t.ticket_no, t.ticket_type, t.ticket_station_id, s.station_name, t.ticket_suspect_id, iss.suspect_name, t.ticket_creator_id, u.user_name, t.ticket_remarks, t.ticket_severity, t.ticket_status, c.closett_userid, c.closett_datetime, cu.user_name AS closett_username
				FROM ticket t 
				INNER JOIN station s ON t.ticket_station_id=s.station_id 
				INNER JOIN initial_suspect iss ON t.ticket_suspect_id = iss.suspect_id
				INNER JOIN USER u ON t.ticket_creator_id = u.user_id
				INNER JOIN closett c ON t.ticket_id=c.ticket_id
				INNER JOIN USER cu ON c.closett_userid = cu.user_id
				WHERE t.ticket_id=".$ticket_id;
				
			// $this->save_closett("Close", $ticket_closedby, $ticket_id);
			$this->save_closett($addInfo, $ticket_closedby, $ticket_id);
			$result = $this->db->query($sQuery)->row();
			$desc = "Ticket ".$result->ticket_no." closed by ".$result->closett_username." on ".$result->closett_datetime." and need confirmation";
			$date = new DateTime();
			
			//$this->save_ticket_log($result->ticket_no, $date->format('Y-m-d H:i:sP'), $desc, 'Done');
			$this->save_ticket_log5($result->ticket_no, $date->format('Y-m-d H:i:sP'), $desc, 'Done', $ticket_id);
			$this->djson(array(
				"status"=>"success",
				"message"=>"Ticket closed successfully",
				"data"=>$result
			));
		} else {
			$this->djson(array(
				"status"=>"failed",
				"message"=>"Ticket closed failed"
			));
		} 
	
	}
	
	/*public function close_ticket() {
		$ticket_id= $this->input->post("ticket_id");
		$ticket_closedby = $this->input->post("ticket_closedby");
		// $addInfo = $this->input->post("additional_info");
		$query = "UPDATE ticket SET ticket_status=2, ticket_closedby='".$ticket_closedby."' WHERE ticket_id=".$ticket_id;
		if($this->db->query($query)) {
			// $sQuery = "SELECT 
				// t.ticket_id, t.ticket_date, t.ticket_no, t.ticket_type, t.ticket_station_id, s.station_name, t.ticket_suspect_id, iss.suspect_name, t.ticket_creator_id, u.user_name, t.ticket_remarks, t.ticket_severity, t.ticket_status 
				// FROM ticket t 
				// INNER JOIN station s ON t.ticket_station_id=s.station_id 
				// INNER JOIN initial_suspect iss ON t.ticket_suspect_id = iss.suspect_id
				// INNER JOIN USER u ON t.ticket_creator_id = u.user_id
				// WHERE t.ticket_id=".$ticket_id;
				$sQuery = "SELECT 
				t.ticket_id, t.ticket_date, t.ticket_no, t.ticket_type, t.ticket_station_id, s.station_name, t.ticket_suspect_id, iss.suspect_name, t.ticket_creator_id, u.user_name, t.ticket_remarks, t.ticket_severity, t.ticket_status, c.closett_userid, c.closett_datetime, cu.user_name AS closett_username
				FROM ticket t 
				INNER JOIN station s ON t.ticket_station_id=s.station_id 
				INNER JOIN initial_suspect iss ON t.ticket_suspect_id = iss.suspect_id
				INNER JOIN USER u ON t.ticket_creator_id = u.user_id
				INNER JOIN closett c ON t.ticket_id=c.ticket_id
				INNER JOIN USER cu ON c.closett_userid = cu.user_id
				WHERE t.ticket_id=".$ticket_id;
				
			$this->save_closett("Close", $ticket_closedby, $ticket_id);
			$result = $this->db->query($sQuery)->row();
			$desc = "Ticket ".$result->ticket_no." closed by ".$result->closett_username." on ".$result->closett_datetime." and need confirmation";
			$date = new DateTime();
			
			$this->save_ticket_log($result->ticket_no, $date->format('Y-m-d H:i:sP'), $desc, 'Done');
			$this->djson(array(
				"status"=>"success",
				"message"=>"Ticket closed successfully",
				"data"=>$result
			));
		} else {
			$this->djson(array(
				"status"=>"failed",
				"message"=>"Ticket closed failed"
			));
		} 
	
	}*/
	
	public function escalated_ticket() {
		$msg="";
		$status="";
		$ticket_id = $this->input->post('ticket_id');
		$from_user_id = $this->input->post('from_user_id');
		$from_station_id = $this->input->post('from_station_id');
		$from_position_id = $this->input->post('from_position_id');
		$action = $this->input->post('action');
		$require = $this->input->post('require');
		
		$qTargetUser = "SELECT u.user_id, u.user_name, u.position_id, u.station_id, u.fcm_registered_id 
		FROM USER u WHERE u.station_id = ".$from_station_id." AND position_id > ".$from_position_id." 
		ORDER BY position_id ASC LIMIT 1";
		$rTargetUser = $this->db->query($qTargetUser)->row();
		$to_user_id = $rTargetUser->user_id;
		$to_position_id = $rTargetUser->position_id;
		
		$qTicketDetail = "SELECT * FROM ticket WHERE ticket_id=".$ticket_id;
		$ticketDetail = $this->db->query($qTicketDetail)->row();
		
		
		$query = "INSERT INTO escalation(ticket_id, escalation_fromuserid, escalation_touserid, escalation_action, escalation_require) VALUES(".$ticket_id.", ".$from_user_id.", ".$to_user_id.", '".$action."', '".$require."')";
		
		if($this->db->query($query)) {
			$nTarget = $rTargetUser->fcm_registered_id;
			$nTitle = "Escalation-1 Ticket ".$ticketDetail->ticket_no;
			$nMessage = "Escalation-1 Ticket ".$ticketDetail->ticket_no;
			$this->send_notification($nTarget, $nTitle, $nMessage, null, null);
			$id = $this->db->insert_id();
			$qLastInsert = "SELECT e.escalation_id, e.ticket_id, t.ticket_no, e.escalation_datetime, e.escalation_fromuserid, u.user_name AS from_user, e.escalation_touserid, u2.user_name AS to_user FROM escalation e 
			INNER JOIN ticket t ON t.ticket_id=e.ticket_id 
			INNER JOIN USER u ON e.escalation_fromuserid=u.user_id 
			INNER JOIN USER u2 ON e.escalation_touserid=u2.user_id WHERE escalation_id=".$id;
			$rLastInsert = $this->db->query($qLastInsert)->row();
			$qUpdate = "UPDATE ticket SET ticket_position=".$to_position_id." WHERE ticket_id=".$ticket_id;
			if($this->db->query($qUpdate)) {
				$desc = "Ticket ".$rLastInsert->ticket_no." escalation-1 from ".$rLastInsert->from_user." to ".$rLastInsert->to_user." on ".$rLastInsert->escalation_datetime;
				$this->save_ticket_log2($rLastInsert->ticket_no, $rLastInsert->escalation_datetime, $desc, 'Done', 0, $rLastInsert->escalation_id,0, 0,0, 0);
				$returnData = $this->getReturnTicket($ticket_id);

				$status = "success";
				$msg = "ticket escalation successfully";
			} else {
				$status = "failed";
				$msg = "ticket escalation failed";
				$returnData = null;
			}
		}
		$this->djson(array(
			"status"=>$status,
			"message"=>$msg,
			"return"=>$returnData
		));
	}
	
	public function escalated_ticket_lv2() {
		$msg="";
		$status="";
		
		$ticket_id = $this->input->post('ticket_id');
		$from_user_id = $this->input->post('from_user_id');
		$from_station_id = $this->input->post('from_station_id');
		$from_position_id = $this->input->post('from_position_id');
		$action = $this->input->post('action');
		$require = $this->input->post('require');
		
		$qTargetUser = "SELECT u.user_id, u.user_name, u.position_id, u.station_id, u.fcm_registered_id, s.region_id 
		FROM USER u INNER JOIN station s ON u.station_id = s.station_id
		WHERE u.station_id = ".$from_station_id." AND u.position_id > ".$from_position_id." LIMIT 1 ";
		$rTargetUser = $this->db->query($qTargetUser)->row();
		$to_user_id = $rTargetUser->user_id;
		$to_position_id = $rTargetUser->position_id;
		
		$qTicketDetail = "SELECT * FROM ticket WHERE ticket_id=".$ticket_id;
		$ticketDetail = $this->db->query($qTicketDetail)->row();
		
		
		$query = "INSERT INTO escalation(ticket_id, escalation_fromuserid, escalation_touserid, escalation_action, escalation_require) VALUES(".$ticket_id.", ".$from_user_id.", ".$to_user_id.", '".$action."', '".$require."')";
		
		if($this->db->query($query)) {
			$nTarget = $rTargetUser->fcm_registered_id;
			$nTitle = "Escalation-2 Ticket ".$ticketDetail->ticket_no;
			$nMessage = "Escalation-2 Ticket ".$ticketDetail->ticket_no;
			$this->send_notification($nTarget, $nTitle, $nMessage, null, null);
			$id = $this->db->insert_id();
			$qLastInsert = "SELECT e.escalation_id, e.ticket_id, t.ticket_no, e.escalation_datetime, e.escalation_fromuserid, u.user_name AS from_user, e.escalation_touserid, u2.user_name AS to_user FROM escalation e 
			INNER JOIN ticket t ON t.ticket_id=e.ticket_id 
			INNER JOIN USER u ON e.escalation_fromuserid=u.user_id 
			INNER JOIN USER u2 ON e.escalation_touserid=u2.user_id WHERE escalation_id=".$id;
			$rLastInsert = $this->db->query($qLastInsert)->row();
			$qUpdate = "UPDATE ticket SET ticket_position=".$to_position_id." WHERE ticket_id=".$ticket_id;
			if($this->db->query($qUpdate)) {
				$desc = "Ticket ".$rLastInsert->ticket_no." escalation-2 from ".$rLastInsert->from_user." to ".$rLastInsert->to_user." on ".$rLastInsert->escalation_datetime;
				$this->save_ticket_log($rLastInsert->ticket_no, $rLastInsert->escalation_datetime, $desc, 'Done');
				$status = "success";
				$msg = "ticket escalation successfully";
			} else {
				$status = "failed";
				$msg = "ticket escalation failed";
			}
		}
		$this->djson(array(
			"status"=>$status,
			"message"=>$msg
		));
	}
	
	public function escalated_ticket_lv3() {
		$msg="";
		$status="";
		
		$ticket_id = $this->input->post('ticket_id');
		$from_user_id = $this->input->post('from_user_id');
		$from_region_id = $this->input->post('from_station_id');
		$from_position_id = $this->input->post('from_position_id');
		$action = $this->input->post('action');
		$require = $this->input->post('require');
		
		$qTargetUser = "SELECT u.user_id, u.user_name, u.position_id, u.station_id, u.fcm_registered_id, s.region_id 
		FROM USER u INNER JOIN station s ON u.station_id = s.station_id
		WHERE s.region_id = ".$from_region_id." AND u.position_id > ".$from_position_id." LIMIT 1 ";
		$rTargetUser = $this->db->query($qTargetUser)->row();
		$to_user_id = $rTargetUser->user_id;
		$to_position_id = $rTargetUser->position_id;
		
		$qTicketDetail = "SELECT * FROM ticket WHERE ticket_id=".$ticket_id;
		$ticketDetail = $this->db->query($qTicketDetail)->row();
		
		
		$query = "INSERT INTO escalation(ticket_id, escalation_fromuserid, escalation_touserid, escalation_action, escalation_require) VALUES(".$ticket_id.", ".$from_user_id.", ".$to_user_id.", '".$action."', '".$require."')";
		
		if($this->db->query($query)) {
			$nTarget = $rTargetUser->fcm_registered_id;
			$nTitle = "Escalation-3 Ticket ".$ticketDetail->ticket_no;
			$nMessage = "Escalation-3 Ticket ".$ticketDetail->ticket_no;
			$this->send_notification($nTarget, $nTitle, $nMessage, null, null);
			$id = $this->db->insert_id();
			$qLastInsert = "SELECT e.escalation_id, e.ticket_id, t.ticket_no, e.escalation_datetime, e.escalation_fromuserid, u.user_name AS from_user, e.escalation_touserid, u2.user_name AS to_user FROM escalation e 
			INNER JOIN ticket t ON t.ticket_id=e.ticket_id 
			INNER JOIN USER u ON e.escalation_fromuserid=u.user_id 
			INNER JOIN USER u2 ON e.escalation_touserid=u2.user_id WHERE escalation_id=".$id;
			$rLastInsert = $this->db->query($qLastInsert)->row();
			$qUpdate = "UPDATE ticket SET ticket_position=".$to_position_id." WHERE ticket_id=".$ticket_id;
			if($this->db->query($qUpdate)) {
				$desc = "Ticket ".$rLastInsert->ticket_no." escalation-3 from ".$rLastInsert->from_user." to ".$rLastInsert->to_user." on ".$rLastInsert->escalation_datetime;
				$this->save_ticket_log($rLastInsert->ticket_no, $rLastInsert->escalation_datetime, $desc, 'Done');
				$status = "success";
				$msg = "ticket escalation successfully";
			} else {
				$status = "failed";
				$msg = "ticket escalation failed";
			}
		}
		$this->djson(array(
			"status"=>$status,
			"message"=>$msg
		));
	}
	
	public function escalated_ticket_lv4() {
		$msg="";
		$status="";
		
		$ticket_id = $this->input->post('ticket_id');
		$from_user_id = $this->input->post('from_user_id');
		$from_region_id = $this->input->post('from_station_id');
		$from_position_id = $this->input->post('from_position_id');
		$action = $this->input->post('action');
		$require = $this->input->post('require');
		
		$qTargetUser = "SELECT u.user_id, u.user_name, u.position_id, u.station_id, u.fcm_registered_id, s.region_id 
		FROM USER u INNER JOIN station s ON u.station_id = s.station_id
		WHERE u.position_id = 5 LIMIT 1 ";
		$rTargetUser = $this->db->query($qTargetUser)->row();
		$to_user_id = $rTargetUser->user_id;
		$to_position_id = $rTargetUser->position_id;
		
		$qTicketDetail = "SELECT * FROM ticket WHERE ticket_id=".$ticket_id;
		$ticketDetail = $this->db->query($qTicketDetail)->row();
		
		
		$query = "INSERT INTO escalation(ticket_id, escalation_fromuserid, escalation_touserid, escalation_action, escalation_require) VALUES(".$ticket_id.", ".$from_user_id.", ".$to_user_id.", '".$action."', '".$require."')";
		
		if($this->db->query($query)) {
			$nTarget = $rTargetUser->fcm_registered_id;
			$nTitle = "Escalation-4 Ticket ".$ticketDetail->ticket_no;
			$nMessage = "Escalation-4 Ticket ".$ticketDetail->ticket_no;
			$this->send_notification($nTarget, $nTitle, $nMessage, null, null);
			$id = $this->db->insert_id();
			$qLastInsert = "SELECT e.escalation_id, e.ticket_id, t.ticket_no, e.escalation_datetime, e.escalation_fromuserid, u.user_name AS from_user, e.escalation_touserid, u2.user_name AS to_user FROM escalation e 
			INNER JOIN ticket t ON t.ticket_id=e.ticket_id 
			INNER JOIN USER u ON e.escalation_fromuserid=u.user_id 
			INNER JOIN USER u2 ON e.escalation_touserid=u2.user_id WHERE escalation_id=".$id;
			$rLastInsert = $this->db->query($qLastInsert)->row();
			$qUpdate = "UPDATE ticket SET ticket_position=".$to_position_id." WHERE ticket_id=".$ticket_id;
			if($this->db->query($qUpdate)) {
				$desc = "Ticket ".$rLastInsert->ticket_no." escalation-4 from ".$rLastInsert->from_user." to ".$rLastInsert->to_user." on ".$rLastInsert->escalation_datetime;
				$this->save_ticket_log($rLastInsert->ticket_no, $rLastInsert->escalation_datetime, $desc, 'Done');
				$status = "success";
				$msg = "ticket escalation successfully";
			} else {
				$status = "failed";
				$msg = "ticket escalation failed";
			}
		}
		$this->djson(array(
			"status"=>$status,
			"message"=>$msg
		));
	}
	
	
	/*public function ticketbystation() {
		$param = $this->input->post('station_id');
		$queryCount = "SELECT ticket_station_id, ticket_severity, ticket_status, COUNT(*) AS total FROM ticket WHERE ticket_station_id=".$param." GROUP BY ticket_severity, ticket_status";
		$query = "SELECT t.ticket_id, t.ticket_date, t.ticket_type, t.ticket_station_id, s.station_name, t.ticket_suspect_id, su.suspect_name, t.ticket_remarks, t.ticket_severity, t.ticket_status, t.ticket_creator_id, u.user_name, t.ticket_photo_1, t.ticket_photo_2, t.ticket_photo_3, t.ticket_no 
					FROM ticket t INNER JOIN station s ON t.ticket_station_id = s.station_id
					INNER JOIN USER u ON t.ticket_creator_id = u.user_id
					INNER JOIN initial_suspect su ON t.ticket_suspect_id = su.suspect_id
					WHERE t.ticket_station_id = ".$param;
		$resultCount = $this->db->query($queryCount)->result_array();
		$result = $this->db->query($query)->result_array();
		$this->djson(array(
			"status"=>"success",
			"message"=>"data found",
			"counter"=>$resultCount,
    		"tickets"=>$result,
			"close_tickets"=>$this->ticketbystationandstatus(0, $param),
			"open_tickets"=>$this->ticketbystationandstatus(1, $param),
			"confirm_tickets"=>$this->ticketbystationandstatus(2, $param),
			"ticketseveritytypesummaries"=>$this->countseveritysummariesbystationandtype($param),
			"ticketstatussummaries"=>$this->countstatussummariesbystation($param)
    	));
		
	}*/
	public function ticketbystation() {
		$param = $this->input->post('station_id');
		$queryCount = "SELECT ticket_station_id, ticket_severity, ticket_status, COUNT(*) AS total FROM ticket WHERE ticket_station_id=".$param." GROUP BY ticket_severity, ticket_status";
		$query = "SELECT t.ticket_id, t.ticket_date, t.ticket_type, t.ticket_station_id, s.station_name, 
					t.ticket_suspect_id, su.suspect_name, t.ticket_remarks, t.ticket_severity, t.ticket_status, 
					t.ticket_creator_id, u.user_name, t.ticket_photo_1, t.ticket_photo_2, t.ticket_photo_3, 
					t.ticket_no, t.isuspect1_id, s1.isuspect1_name, t.isuspect2_id, s2.isuspect2_name, t.isuspect3_id, s3.isuspect3_name 
					FROM ticket t INNER JOIN station s ON t.ticket_station_id = s.station_id
					INNER JOIN USER u ON t.ticket_creator_id = u.user_id
					INNER JOIN initial_suspect su ON t.ticket_suspect_id = su.suspect_id
					LEFT JOIN isuspect1 s1 ON t.isuspect1_id = s1.isuspect1_id
					LEFT JOIN isuspect2 s2 ON t.isuspect2_id = s2.isuspect2_id
					LEFT JOIN isuspect3 s3 ON t.isuspect3_id = s3.isuspect3_id
					WHERE t.ticket_station_id = ".$param;
		$resultCount = $this->db->query($queryCount)->result_array();
		$result = $this->db->query($query)->result_array();
		$this->djson(array(
			"status"=>"success",
			"message"=>"data found",
			"counter"=>$resultCount,
    		"tickets"=>$result,
			"close_tickets"=>$this->ticketbystationandstatus(0, $param),
			"open_tickets"=>$this->ticketbystationandstatus(1, $param),
			"confirm_tickets"=>$this->ticketbystationandstatus(2, $param),
			"ticketseveritytypesummaries"=>$this->countseveritysummariesbystationandtype($param),
			"ticketstatussummaries"=>$this->countstatussummariesbystation($param)
    	));
		
	}
	
	public function ticketbycreator() {
		$param = $this->input->post('creator_id');
		
		$this->djson(array(
			"status"=>"success",
			"message"=>"data found",
			"open_tickets"=>$this->ticketbycreatorandstatus(1, $param),
			"confirm_tickets"=>$this->ticketbycreatorandstatus(2, $param)
    	));
		
	}
	
	public function getrequestapproval() {
		$station_id = $this->input->post("station_id");
		$query = "SELECT t.ticket_id, t.ticket_date, t.ticket_type, t.ticket_station_id, s.station_name, t.ticket_suspect_id, su.suspect_name, t.ticket_remarks, t.ticket_severity, t.ticket_status, t.ticket_creator_id, u.user_name, t.ticket_photo_1, t.ticket_photo_2, t.ticket_photo_3, t.ticket_no, c.closett_info  
					FROM ticket t INNER JOIN station s ON t.ticket_station_id = s.station_id
					INNER JOIN USER u ON t.ticket_creator_id = u.user_id
					INNER JOIN initial_suspect su ON t.ticket_suspect_id = su.suspect_id 
					LEFT JOIN closett c ON t.ticket_id = c.ticket_id 
					WHERE t.ticket_status = 2 AND t.ticket_station_id = ".$station_id;
		$result = $this->db->query($query)->result_array();
		$this->djson(array(
			"status"=>"success",
			"message"=>"data found",
    		"tickets"=>$result
    	));
	}
	
	/*public function getrequestapproval() {
		$station_id = $this->input->post("station_id");
		$query = "SELECT t.ticket_id, t.ticket_date, t.ticket_type, t.ticket_station_id, s.station_name, t.ticket_suspect_id, su.suspect_name, t.ticket_remarks, t.ticket_severity, t.ticket_status, t.ticket_creator_id, u.user_name, t.ticket_photo_1, t.ticket_photo_2, t.ticket_photo_3, t.ticket_no 
					FROM ticket t INNER JOIN station s ON t.ticket_station_id = s.station_id
					INNER JOIN USER u ON t.ticket_creator_id = u.user_id
					INNER JOIN initial_suspect su ON t.ticket_suspect_id = su.suspect_id
					WHERE t.ticket_status = 2 AND t.ticket_station_id = ".$station_id;
		$result = $this->db->query($query)->result_array();
		$this->djson(array(
			"status"=>"success",
			"message"=>"data found",
    		"tickets"=>$result
    	));
	}*/
	
	// public function getrequestapproval() {
		// $station_id = $this->input->post("station_id");
		// $position_id = $this->input->post("position_id");
		// $query = "SELECT t.ticket_id, t.ticket_date, t.ticket_type, t.ticket_station_id, s.station_name, t.ticket_suspect_id, su.suspect_name, t.ticket_remarks, t.ticket_severity, t.ticket_status, t.ticket_creator_id, u.user_name, t.ticket_photo_1, t.ticket_photo_2, t.ticket_photo_3, t.ticket_no 
					// FROM ticket t INNER JOIN station s ON t.ticket_station_id = s.station_id
					// INNER JOIN USER u ON t.ticket_creator_id = u.user_id
					// INNER JOIN initial_suspect su ON t.ticket_suspect_id = su.suspect_id
					// WHERE t.ticket_status = 2 AND t.ticket_station_id = ".$station_id." AND t.ticket_position=".$position_id;
		// $result = $this->db->query($query)->result_array();
		// $this->djson(array(
			// "status"=>"success",
			// "message"=>"data found",
    		// "tickets"=>$result
    	// ));
	// }
	
	public function getrequestapprovalregion() {
		$region_id = $this->input->post("region_id");
		$position_id = $this->input->post("position_id");
		$query = "SELECT t.ticket_id, t.ticket_date, t.ticket_type, t.ticket_station_id, s.station_name, t.ticket_suspect_id, su.suspect_name, t.ticket_remarks, t.ticket_severity, t.ticket_status, t.ticket_creator_id, u.user_name, t.ticket_photo_1, t.ticket_photo_2, t.ticket_photo_3, t.ticket_no 
					FROM ticket t INNER JOIN station s ON t.ticket_station_id = s.station_id
					INNER JOIN USER u ON t.ticket_creator_id = u.user_id
					INNER JOIN initial_suspect su ON t.ticket_suspect_id = su.suspect_id
					WHERE t.ticket_status = 2 AND s.region_id = ".$region_id." AND t.ticket_position=".$position_id;
		$result = $this->db->query($query)->result_array();
		$this->djson(array(
			"status"=>"success",
			"message"=>"data found",
    		"tickets"=>$result
    	));
	}
	
	public function submitapproval() {
		$ticket_id = $this->input->post("ticket_id");
		$ticket_confirmby = $this->input->post("ticket_confirmby");
		$query = "UPDATE ticket SET ticket_status=0, ticket_confirmby='".$ticket_confirmby."', ticket_confirmby_datetime=now() WHERE ticket_id=".$ticket_id;
		if($this->db->query($query)) {
			$sQuery = "SELECT 
				t.ticket_id, t.ticket_date, cb.user_name as closer, t.ticket_confirmby_datetime, t.ticket_no, t.ticket_type, t.ticket_station_id, s.station_name, t.ticket_suspect_id, iss.suspect_name, t.ticket_creator_id, u.user_name, t.ticket_remarks, t.ticket_severity, t.ticket_status 
				FROM ticket t 
				INNER JOIN station s ON t.ticket_station_id=s.station_id 
				INNER JOIN initial_suspect iss ON t.ticket_suspect_id = iss.suspect_id
				INNER JOIN USER u ON t.ticket_creator_id = u.user_id
				INNER JOIN USER cb ON t.ticket_confirmby = cb.user_id
				WHERE t.ticket_id=".$ticket_id;
				// echo $sQuery;exit;
			// $this->save_closett("Close", $ticket_closedby, $ticket_id);
			$result = $this->db->query($sQuery)->row();
			$desc = "Confirm ticket ".$result->ticket_no." closed by ".$result->closer." on ".$result->ticket_confirmby_datetime;
			
			$this->save_ticket_log6($result->ticket_no, $result->ticket_confirmby_datetime, $desc, 'Done', $ticket_id);
			$this->djson(array(
				"status"=>"success",
				"message"=>"Confirm ticket closed successfully",
				"data"=>$result
			));
		} else {
			$this->djson(array(
				"status"=>"failed",
				"message"=>"Confirm ticket closed failed"
			));
		} 
	}
	
	function ticketbystationandstatus($ticket_status, $station_id) {
		$query = "SELECT t.ticket_id, t.ticket_date, t.ticket_type, t.ticket_station_id, s.station_name, t.ticket_suspect_id, su.suspect_name, t.ticket_remarks, t.ticket_severity, t.ticket_status, t.ticket_creator_id, u.user_name, t.ticket_photo_1, t.ticket_photo_2, t.ticket_photo_3, 
		t.ticket_no, t.isuspect1_id, s1.isuspect1_name, t.isuspect2_id, s2.isuspect2_name, t.isuspect3_id, s3.isuspect3_name 
					FROM ticket t INNER JOIN station s ON t.ticket_station_id = s.station_id
					INNER JOIN USER u ON t.ticket_creator_id = u.user_id
					INNER JOIN initial_suspect su ON t.ticket_suspect_id = su.suspect_id
					LEFT JOIN isuspect1 s1 ON t.isuspect1_id = s1.isuspect1_id
					LEFT JOIN isuspect2 s2 ON t.isuspect2_id = s2.isuspect2_id
					LEFT JOIN isuspect3 s3 ON t.isuspect3_id = s3.isuspect3_id
					WHERE t.ticket_status = ".$ticket_status." AND t.ticket_station_id = ".$station_id;
		$result = $this->db->query($query)->result_array();
		return $result;
		
	}
	
	function ticketbycreatorandstatus($ticket_status, $creator_id) {
		$query = "SELECT t.ticket_id, t.ticket_date, t.ticket_type, t.ticket_station_id, s.station_name, t.ticket_suspect_id, su.suspect_name, t.ticket_remarks, t.ticket_severity, t.ticket_status, t.ticket_creator_id, u.user_name, t.ticket_photo_1, t.ticket_photo_2, t.ticket_photo_3, 
		t.ticket_no, t.isuspect1_id, s1.isuspect1_name, t.isuspect2_id, s2.isuspect2_name, t.isuspect3_id, s3.isuspect3_name 
					FROM ticket t INNER JOIN station s ON t.ticket_station_id = s.station_id
					INNER JOIN USER u ON t.ticket_creator_id = u.user_id
					INNER JOIN initial_suspect su ON t.ticket_suspect_id = su.suspect_id
					LEFT JOIN isuspect1 s1 ON t.isuspect1_id = s1.isuspect1_id
					LEFT JOIN isuspect2 s2 ON t.isuspect2_id = s2.isuspect2_id
					LEFT JOIN isuspect3 s3 ON t.isuspect3_id = s3.isuspect3_id
					WHERE t.ticket_status = ".$ticket_status." AND t.ticket_creator_id = ".$creator_id;
		$result = $this->db->query($query)->result_array();
		return $result;
		
	}
	
	public function getescalationticket() {
		$param = $this->input->post('id');
		$param2 = $this->input->post('position_id');
		$query = "SELECT t.ticket_id, t.ticket_date, t.ticket_type, t.ticket_station_id, s.station_name, t.ticket_suspect_id, su.suspect_name, t.ticket_remarks, t.ticket_severity, t.ticket_status, t.ticket_creator_id, u.user_name, t.ticket_photo_1, t.ticket_photo_2, t.ticket_photo_3, t.ticket_no 
					FROM ticket t INNER JOIN station s ON t.ticket_station_id = s.station_id
					INNER JOIN USER u ON t.ticket_creator_id = u.user_id
					INNER JOIN initial_suspect su ON t.ticket_suspect_id = su.suspect_id
					INNER JOIN escalation e ON e.ticket_id = t.ticket_id
					WHERE t.ticket_status = 1 AND t.ticket_position=".$param2." AND e.escalation_touserid=".$param;
		$result = $this->db->query($query)->result_array();
		$this->djson(array(
			"status"=>"success",
			"message"=>"data found",
			"tickets"=>$result
		));
	}
	
	public function getescalationticketforkst() {
		$kst_id = $this->input->post('kst_id');
		$query = "SELECT t.ticket_id, t.ticket_date, t.ticket_type, t.ticket_station_id, s.station_name, t.ticket_suspect_id, su.suspect_name, t.ticket_remarks, t.ticket_severity, t.ticket_status, t.ticket_creator_id, u.user_name, t.ticket_photo_1, t.ticket_photo_2, t.ticket_photo_3, t.ticket_no 
					FROM ticket t INNER JOIN station s ON t.ticket_station_id = s.station_id
					INNER JOIN USER u ON t.ticket_creator_id = u.user_id
					INNER JOIN initial_suspect su ON t.ticket_suspect_id = su.suspect_id
					INNER JOIN escalation e ON e.ticket_id = t.ticket_id
					WHERE t.ticket_status = 1 AND e.escalation_touserid=".$kst_id;
		$result = $this->db->query($query)->result_array();
		$this->djson(array(
			"status"=>"success",
			"message"=>"data found",
			"tickets"=>$result
		));
	}
	
	public function getescalationticketforkorwil() {
		$param= $this->input->post('korwil_id');
		$query = "SELECT t.ticket_id, t.ticket_date, t.ticket_type, t.ticket_station_id, s.station_name, t.ticket_suspect_id, su.suspect_name, t.ticket_remarks, t.ticket_severity, t.ticket_status, t.ticket_creator_id, u.user_name, t.ticket_photo_1, t.ticket_photo_2, t.ticket_photo_3, t.ticket_no 
					FROM ticket t INNER JOIN station s ON t.ticket_station_id = s.station_id
					INNER JOIN USER u ON t.ticket_creator_id = u.user_id
					INNER JOIN initial_suspect su ON t.ticket_suspect_id = su.suspect_id
					INNER JOIN escalation e ON e.ticket_id = t.ticket_id
					WHERE t.ticket_status = 1 AND e.escalation_touserid=".$param;
		$result = $this->db->query($query)->result_array();
		$this->djson(array(
			"status"=>"success",
			"message"=>"data found",
			"tickets"=>$result
		));
	}
	
	function ticketbystationandstatus2($ticket_status, $station_id, $ticket_position_id) {
		$query = "SELECT t.ticket_id, t.ticket_date, t.ticket_type, t.ticket_station_id, s.station_name, t.ticket_suspect_id, su.suspect_name, t.ticket_remarks, t.ticket_severity, t.ticket_status, t.ticket_creator_id, u.user_name, t.ticket_photo_1, t.ticket_photo_2, t.ticket_photo_3, t.ticket_no 
					FROM ticket t INNER JOIN station s ON t.ticket_station_id = s.station_id
					INNER JOIN USER u ON t.ticket_creator_id = u.user_id
					INNER JOIN initial_suspect su ON t.ticket_suspect_id = su.suspect_id
					WHERE t.ticket_status = ".$ticket_status." AND t.ticket_station_id = ".$station_id." AND t.ticket_position=".$ticket_position_id;
		$result = $this->db->query($query)->result_array();
		return $result;
		
	}
	
	
	
	public function ticketbyregion() {
		$param = $this->input->post('region_id');
		$queryCount = "SELECT s.region_id, t.ticket_severity ,t.ticket_status, COUNT(*) AS total FROM ticket t INNER JOIN station s ON t.ticket_station_id = s.station_id INNER JOIN region r ON s.region_id = r.region_id WHERE s.region_id = ".$param." GROUP BY s.region_id, t.ticket_severity, t.ticket_status";
		$query = "SELECT s.region_id, r.region_name, s.station_id, s.station_name,
		SUM(CASE WHEN ticket_status = 0 THEN 1 ELSE 0 END) close_ticket,
		SUM(CASE WHEN ticket_status = 1 THEN 1 ELSE 0 END) open_ticket,
		SUM(CASE WHEN ticket_status = 2 THEN 1 ELSE 0 END) confirm_ticket,
		SUM(CASE WHEN ticket_severity = 1 THEN 1 ELSE 0 END) critical_ticket,
		SUM(CASE WHEN ticket_severity = 2 THEN 1 ELSE 0 END) major_ticket,
		SUM(CASE WHEN ticket_severity = 3 THEN 1 ELSE 0 END) minor_ticket,
		COUNT(*) total
		FROM ticket t 
		INNER JOIN station s ON t.ticket_station_id = s.station_id 
		INNER JOIN region r ON s.region_id = r.region_id
		WHERE s.region_id = ".$param." 
		GROUP BY s.station_id";
		$resultCount = $this->db->query($queryCount)->result_array();
		$result = $this->db->query($query)->result_array();
		$this->djson(array(
			"status"=>"success",
			"message"=>"data found",
			"counter"=>$resultCount,
    		"tickets"=>$result,
			"total"=>$this->count_by_region($param)
    	));
		
	}
	
	// count by region_id
	function count_by_region($region_id) {
		$query = "SELECT 
			(CASE WHEN ticket_severity = 1 THEN 'Critical' ELSE (CASE WHEN ticket_severity = 2 THEN 'Major' ELSE (CASE WHEN ticket_severity = 3 THEN 'Minor' ELSE 'Undefined' END) END) END) ticket_severity, 
			SUM(CASE WHEN ticket_status = 0 THEN 1 ELSE 0 END) close_ticket, 
			SUM(CASE WHEN ticket_status = 1 THEN 1 ELSE 0 END) open_ticket, 
			SUM(CASE WHEN ticket_status = 2 THEN 1 ELSE 0 END) confirm_ticket 
			FROM ticket t 
			INNER JOIN station s ON t.ticket_station_id = s.station_id 
			INNER JOIN region r ON s.region_id = r.region_id 
			WHERE r.region_id = ".$region_id." 
			GROUP BY r.region_id, t.ticket_severity";
		$result = $this->db->query($query)->result_array();
		return $result;
	}
	
	// summaries
	public function countsummariesbystation($id) {
		$query = "SELECT (CASE WHEN ticket_status=0 THEN 'Closed' ELSE (CASE WHEN ticket_status=1 THEN 'Open' ELSE 'Confirm' END) END) ticket_status, COUNT(ticket_status) total FROM ticket 
			WHERE ticket_station_id = ".$id."
			GROUP BY ticket_station_id, ticket_status";
		$result = $this->db->query($query)->result_array();
		return $result;
	}
	// public function countsummariesbystation() {
		// $id = $this->input->post('station_id');
		// $query = "SELECT (CASE WHEN ticket_status=0 THEN 'Closed' ELSE (CASE WHEN ticket_status=1 THEN 'Open' ELSE 'Confirm' END) END) ticket_status, COUNT(ticket_status) total FROM ticket 
			// WHERE ticket_station_id = ".$id."
			// GROUP BY ticket_station_id, ticket_status";
		// $result = $this->db->query($query)->result_array();
		// $this->djson(array(
			// "status"=>"success",
			// "message"=>"total",
			// "result"=>$result
		// ));
	// }
	
	public function countsummariesbyregion($id) {
		// $id = $this->input->post('region_id');
		$query = "SELECT (CASE WHEN t.ticket_status=0 THEN 'Closed' ELSE (CASE WHEN t.ticket_status=1 THEN 'Open' ELSE 'Confirm' END) END) ticket_status, COUNT(t.ticket_status) total 
		FROM ticket t 
		INNER JOIN station s ON t.ticket_station_id = s.station_id 
		WHERE s.region_id = ".$id." 
		GROUP BY s.region_id, t.ticket_status";
		// echo $query;exit;
		$result = $this->db->query($query)->result_array();
		return $result;
		// $this->djson(array(
			// "status"=>"success",
			// "message"=>"total",
			// "result"=>$result
		// ));
	}
	
	public function countstatussummariesbystation($id) {
		$query = "SELECT (CASE WHEN ticket_status= 0 THEN 'Close' ELSE (CASE WHEN ticket_status = 1 THEN 'Open' ELSE 'Confirm' END) END) ticket_severity, 
			SUM(CASE WHEN ticket_severity = 1 THEN 1 ELSE 0 END) critical, 
			SUM(CASE WHEN ticket_severity = 2 THEN 1 ELSE 0 END) major, 
			SUM(CASE WHEN ticket_severity = 3 THEN 1 ELSE 0 END) minor
			FROM ticket 
			WHERE ticket_station_id = ".$id."
			GROUP BY ticket_station_id, ticket_status";
		$result = $this->db->query($query)->result_array();
		return $result;
	}
	
	public function countseveritysummariesbystation($id) {
		$query = "SELECT (CASE WHEN ticket_severity = 1 THEN 'Critical' ELSE (CASE WHEN ticket_severity = 2 THEN 'Major' ELSE (CASE WHEN ticket_severity = 3 THEN 'Minor' ELSE 'Undefined' END) END) END) ticket_severity, 
			SUM(CASE WHEN ticket_status = 0 THEN 1 ELSE 0 END) close_ticket, 
			SUM(CASE WHEN ticket_status = 1 THEN 1 ELSE 0 END) open_ticket, 
			SUM(CASE WHEN ticket_status = 2 THEN 1 ELSE 0 END) confirm_ticket 
			FROM ticket 
			WHERE ticket_station_id = ".$id."
			GROUP BY ticket_station_id, ticket_severity";
		$result = $this->db->query($query)->result_array();
		return $result;
	}
	
	public function countseveritysummariesbystationandtype($id) {
		$query = "SELECT (CASE WHEN ticket_type = 1 THEN 'Down Time' ELSE 'Kerusakan' END) ticket_type, (CASE WHEN ticket_severity = 1 THEN 'Critical' ELSE (CASE WHEN ticket_severity = 2 THEN 'Major' ELSE (CASE WHEN ticket_severity = 3 THEN 'Minor' ELSE 'Undefined' END) END) END) ticket_severity, 
			SUM(CASE WHEN ticket_status = 0 THEN 1 ELSE 0 END) close_ticket,
			SUM(CASE WHEN ticket_status = 1 THEN 1 ELSE 0 END) open_ticket,
			SUM(CASE WHEN ticket_status = 2 THEN 1 ELSE 0 END) confirm_ticket
			FROM ticket 
			WHERE ticket_station_id = ".$id."
			GROUP BY ticket_station_id, ticket_type, ticket_severity";
		$result = $this->db->query($query)->result_array();
		return $result;
	}
	// public function countseveritysummariesbystation() {
		// $id = $this->input->post('station_id');
		// $query = "SELECT (CASE WHEN ticket_severity = 1 THEN 'Critical' ELSE (CASE WHEN ticket_severity = 2 THEN 'Major' ELSE (CASE WHEN ticket_severity = 3 THEN 'Minor' ELSE 'Undefined' END) END) END) ticket_severity, 
			// SUM(CASE WHEN ticket_status = 0 THEN 1 ELSE 0 END) close_ticket, 
			// SUM(CASE WHEN ticket_status = 1 THEN 1 ELSE 0 END) open_ticket, 
			// SUM(CASE WHEN ticket_status = 2 THEN 1 ELSE 0 END) confirm_ticket 
			// FROM ticket 
			// WHERE ticket_station_id = ".$id."
			// GROUP BY ticket_station_id, ticket_severity";
		// $result = $this->db->query($query)->result_array();
		// $this->djson(array(
			// "status"=>"success",
			// "message"=>"total",
			// "result"=>$result
		// ));
	// }
	
	public function countseveritysummariesbyregion($id) {
		// $id = $this->input->post('region_id');
		$query = "SELECT (CASE WHEN ticket_severity = 1 THEN 'Critical' ELSE (CASE WHEN ticket_severity = 2 THEN 'Major' ELSE (CASE WHEN ticket_severity = 3 THEN 'Minor' ELSE 'Undefined' END) END) END) ticket_severity, 
			SUM(CASE WHEN ticket_status = 0 THEN 1 ELSE 0 END) close_ticket, 
			SUM(CASE WHEN ticket_status = 1 THEN 1 ELSE 0 END) open_ticket, 
			SUM(CASE WHEN ticket_status = 2 THEN 1 ELSE 0 END) confirm_ticket 
			FROM ticket t 
			INNER JOIN station s ON t.ticket_station_id = s.station_id 
			WHERE s.region_id = ".$id."
			GROUP BY s.region_id, t.ticket_severity";
		$result = $this->db->query($query)->result_array();
		return $result;
		// $this->djson(array(
			// "status"=>"success",
			// "message"=>"total",
			// "result"=>$result
		// ));
	}
	
	public function countseveritysummariesbyregionandtype($id) {
		$query = "SELECT (CASE WHEN t.ticket_type = 1 THEN 'Down Time' ELSE 'Kerusakan' END) ticket_type, (CASE WHEN t.ticket_severity = 1 THEN 'Critical' ELSE (CASE WHEN t.ticket_severity = 2 THEN 'Major' ELSE (CASE WHEN t.ticket_severity = 3 THEN 'Minor' ELSE 'Undefined' END) END) END) ticket_severity, 
			SUM(CASE WHEN t.ticket_status = 0 THEN 1 ELSE 0 END) close_ticket,
			SUM(CASE WHEN t.ticket_status = 1 THEN 1 ELSE 0 END) open_ticket,
			SUM(CASE WHEN t.ticket_status = 2 THEN 1 ELSE 0 END) confirm_ticket
			FROM ticket t 
			INNER JOIN station s ON t.ticket_station_id = s.station_id
			WHERE s.region_id = ".$id."
			GROUP BY s.region_id, t.ticket_type, t.ticket_severity";
		$result = $this->db->query($query)->result_array();
		return $result;
	}
	
	
	
	public function get_ticket_log() {
		$ticket_no = $this->input->post('ticket_no');
		$query = "SELECT * FROM ticket_log WHERE ticket_no='".$ticket_no."' ORDER BY log_id ASC";
		$result = $this->db->query($query)->result_array();
		$this->djson(array(
				"status"=>"success",
				"message"=>"ticket log",
				"data"=>$result
		));
	}
	
	function save_ticket_log($ticket_no, $ticket_date, $log_desc, $log_status) {
		$query = "INSERT INTO ticket_log(ticket_no, ticket_date, log_desc, log_status) VALUES('".$ticket_no."', '".$ticket_date."','".$log_desc."', '".$log_status."')";
		if($this->db->query($query)) {
			return true;
		}
		return false;
	}
	
	//opentt log
	function save_ticket_log2($ticket_no, $ticket_date, $log_desc, $log_status, $ticket_id, $escalation_id, $assignment_id, $closett_id, $confirm_id, $ticket_confirmby) {
		$query = "INSERT INTO ticket_log(ticket_no, ticket_date, log_desc, log_status, ticket_id, escalation_id, assignment_id, closett_id, confirm_id, ticket_confirmby) VALUES('".$ticket_no."', '".$ticket_date."','".$log_desc."', '".$log_status."',".$ticket_id.",".$escalation_id.",".$assignment_id.",".$closett_id.",".$confirm_id.",".$ticket_confirmby.")";
		if($this->db->query($query)) {
			$this->db->delete("ticket",array("ticket_id >"=>$ticket_id,"ticket_no"=>$ticket_no));
			$this->db->delete("escalation",array("escalation_id >"=>$escalation_id,"ticket_id"=>$ticket_id));
			$this->db->delete("ticket_log",array("escalation_id >"=>$escalation_id,"ticket_no"=>$ticket_no));
			return true;
		}
		return false;
	}
	
	//escalation log
	function save_ticket_log3($ticket_no, $ticket_date, $log_desc, $log_status, $ticket_id, $escalation_id) {
		$query = "INSERT INTO ticket_log(ticket_no, ticket_date, log_desc, log_status, escalation_id) VALUES('".$ticket_no."', '".$ticket_date."','".$log_desc."', '".$log_status."', ".$escalation_id.")";
		if($this->db->query($query)) {
			$this->db->delete("escalation",array("escalation_id >"=>$escalation_id,"ticket_id"=>$ticket_id));
			$this->db->delete("ticket_log",array("escalation_id >"=>$escalation_id,"ticket_no"=>$ticket_no));
			return true;
		}
		return false;
	}
	
	//assigntment log
	function save_ticket_log4($ticket_no, $ticket_date, $log_desc, $log_status, $ticket_id, $escalation_id) {
		$query = "INSERT INTO ticket_log(ticket_no, ticket_date, log_desc, log_status, escalation_id) VALUES('".$ticket_no."', '".$ticket_date."','".$log_desc."', '".$log_status."', ".$escalation_id.")";
		if($this->db->query($query)) {
			$this->db->delete("escalation",array("escalation_id >"=>$escalation_id,"ticket_id"=>$ticket_id));
			$this->db->delete("ticket_log",array("escalation_id >"=>$escalation_id,"ticket_no"=>$ticket_no));
			return true;
		}
		return false;
	}
	
	//close tt log
	function save_ticket_log5($ticket_no, $ticket_date, $log_desc, $log_status, $ticket_id) {
		$closett_id=$this->db->get_where("closett",array("ticket_id"=>$ticket_id))->row()->closett_id;
		$query = "INSERT INTO ticket_log(ticket_no, ticket_date, log_desc, log_status, closett_id) VALUES('".$ticket_no."', '".$ticket_date."','".$log_desc."', '".$log_status."', ".$closett_id.")";
		if($this->db->query($query)) {
			$this->db->delete("closett",array("closett_id >"=>$closett_id,"ticket_id"=>$ticket_id));
			$this->db->delete("ticket_log",array("closett_id >"=>$closett_id,"ticket_no"=>$ticket_no));
			return true;
		}
		return false;
	}
	
	//confirm tt log
	function save_ticket_log6($ticket_no, $ticket_date, $log_desc, $log_status, $ticket_id) {
		$input["confirm_datetime"]=date("Y-m-d H:i:s");
		$input["confirm_info"]=$this->input->post("confirm_info");
		$input["confirm_userid"]=$this->input->post("confirm_userid");
		$input["ticket_id"]=$ticket_id;
		$this->db->insert("confirm",$input);
		$id=$this->db->insert_id();
		$query = "INSERT INTO ticket_log(ticket_no, ticket_date, log_desc, log_status, confirm_id, ticket_confirmby) VALUES('".$ticket_no."', '".$ticket_date."','".$log_desc."', '".$log_status."', ".$id.", ".$input["confirm_userid"].")";
		if($this->db->query($query)) {
			$this->db->delete("confirm",array("confirm_id >"=>$confirm_id,"ticket_id"=>$ticket_id));
			$this->db->delete("ticket_log",array("confirm_id >"=>$confirm_id,"ticket_no"=>$ticket_no));
			return true;
		}
		return false;
	}
	
	
	function save_closett($addInfo, $userId, $ticketId) {
		$query = "INSERT INTO closett(closett_info, closett_userid, ticket_id) VALUES('".$addInfo."', ".$userId.", ".$ticketId.")";
			
		if($this->db->query($query)) {
			return true;
		}
		return false;
	}
		
	function get_ticket_no($type) {
		$prefix = "";
		$date = intval(date("y"));
		if($type == 1)
			$prefix = "D";
		else 
			$prefix = "K";
		
		$query = "SELECT ticket_no FROM ticket WHERE LOWER(ticket_no) LIKE LOWER('%".$prefix."%') ORDER BY ticket_no DESC LIMIT 1";
		$qResult = $this->db->query($query)->row();
		$sNumber = substr($qResult->ticket_no, 3, 4);
		$number = (int) $sNumber;
		$number++;
		$nextNum = sprintf( "%04d", $number);
		$result = $prefix.$date.$nextNum;
		return $result;
		// $this->djson(array(
			// "result"=>$result
		// ));
	}
	
	public function get_ticket_number() {
		$type = $this->input->post('type');
		$prefix = "";
		$date = intval(date("y"));
		if($type == 1)
			$prefix = "D";
		else 
			$prefix = "K";
		
		$query = "SELECT ticket_no FROM ticket WHERE LOWER(ticket_no) LIKE LOWER('%".$prefix."%') ORDER BY ticket_no DESC LIMIT 1";
		$qResult = $this->db->query($query)->row();
		$sNumber = substr($qResult->ticket_no, 3, 4);
		$number = (int) $sNumber;
		$number++;
		$nextNum = sprintf( "%04d", $number);
		$result = $prefix.$date.$nextNum;
		$this->djson(array(
			"result"=>$result
		));
	}
	
	public function get_engineer() {
		$query = "SELECT 
							u.user_id, u.user_name, u.user_email, u.position_id, p.position_name, u.station_id, u.fcm_registered_id, st.station_name, rg.region_id, rg.region_name, u.user_picture, u.department_id, d.department_name  
						FROM 
							USER u INNER JOIN POSITION p ON u.position_id = p.position_id 
							LEFT JOIN station st ON u.station_id=st.station_id
							LEFT JOIN region rg ON u.region_id=rg.region_id
							LEFT JOIN department d ON u.department_id = d.department_id
						WHERE u.position_id=7";
		$status;
		$message;
		$result = $this->db->query($query)->result_array();
		$this->djson(array(
				"status"=>"success",
				"message"=>"data engineer",
				"data"=>$result
		));
	}
	
	//jangan lupa comment 'notification'
	function send_notification($reg_id, $title, $message, $img_url, $tag) {
		define("GOOGLE_API_KEY", "AIzaSyBrXSuFmmKUO8dz6AQcdzCRCmHFIcnMk-s");
		define("GOOGLE_GCM_URL", "https://fcm.googleapis.com/fcm/send");
	
        $fields = array(
			'to'  						=> $reg_id ,
			'priority'					=> "high",
            // 'notification'              => array( "title" => $title, "body" => $message, "tag" => $tag ),
			'data'						=> array( "title" => $title, "body" => $message, "tag" => $tag )
        );
		
        $headers = array(
			GOOGLE_GCM_URL,
			'Content-Type: application/json',
            'Authorization: key=' . GOOGLE_API_KEY 
        );
		
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, GOOGLE_GCM_URL);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Problem occurred: ' . curl_error($ch));
        }
		
        curl_close($ch);
        // echo $result;
    }
	
	function send_notification2() {
		$reg_id = $this->input->post('to');
		$title = $this->input->post('title');
		$message = $this->input->post('message');
		$img_url = $this->input->post('img_url');
		$tag = $this->input->post('tag');
		define("GOOGLE_API_KEY", "AIzaSyBrXSuFmmKUO8dz6AQcdzCRCmHFIcnMk-s");
		// define("GOOGLE_API_KEY", "AIzaSyDvq9gDKlTGYT4dI_UucxMga-TDyyHd4oI");
		define("GOOGLE_GCM_URL", "https://fcm.googleapis.com/fcm/send");
	
	// 'notification'              => array( "title" => $title, "body" => $message, "tag" => $tag ),
        $fields = array(
			'to'  						=> $reg_id ,
			'priority'					=> "high",
            'data'              => array( "title" => $title, "body" => $message, "tag" => $tag )
        );
		
        $headers = array(
			GOOGLE_GCM_URL,
			'Content-Type: application/json',
            'Authorization: key=' . GOOGLE_API_KEY 
        );
		
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, GOOGLE_GCM_URL);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Problem occurred: ' . curl_error($ch));
        }
		
        curl_close($ch);
        echo $result;
    }
	
	private function djson($value=array()) {
		$json = json_encode($value);
		$this->output->set_header("Access-Control-Allow-Origin: *");
		$this->output->set_header("Access-Control-Expose-Headers: Access-Control-Allow-Origin");
		$this->output->set_status_header(200);
		$this->output->set_content_type('application/json');
		$this->output->set_output($json);
	}
	
	function send_gcm_notify($reg_id, $title, $message, $img_url, $tag) {
		define("GOOGLE_API_KEY", "AIzaSyDbabv_NlcyoxwaOedLjlimcZS9drjA5uE");
		define("GOOGLE_GCM_URL", "https://fcm.googleapis.com/fcm/send");
	
        $fields = array(
			'to'  						=> $reg_id ,
			'priority'					=> "high",
            'notification'              => array( "title" => $title, "body" => $message, "tag" => $tag ),
			'data'						=> array("message" =>$message, "image"=> $img_url),
        );
		
        $headers = array(
			GOOGLE_GCM_URL,
			'Content-Type: application/json',
            'Authorization: key=' . GOOGLE_API_KEY 
        );
		
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, GOOGLE_GCM_URL);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Problem occurred: ' . curl_error($ch));
        }
		
        curl_close($ch);
        echo $result;
    }
	
	
	public function sendMessage($data,$target){
		//FCM api URL
		$url = 'https://fcm.googleapis.com/fcm/send';
		//api_key available in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
		$server_key = 'AIzaSyANqvKPEr9XQ5-bXTS9m93DYMLwBCY5_Yc';
					
		$fields = array();
		$fields['data'] = $data;
		if(is_array($target)){
			$fields['registration_ids'] = $target;
		}else{
			$fields['to'] = $target;
		}
		//header with content_type api key
		$headers = array(
			'Content-Type:application/json',
		  'Authorization:key='.$server_key
		);
					
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		$result = curl_exec($ch);
		if ($result === FALSE) {
			die('FCM Send Error: ' . curl_error($ch));
		}
		curl_close($ch);
		return $result;
	}
	
	function send_android_notification($registration_ids, $message) {
		$fields = array(
		'registration_ids' => array($registration_ids),
		'data'=> $message,
		);
		$headers = array(
		'Authorization: key=AIzaSyANqvKPEr9XQ5-bXTS9m93DYMLwBCY5_Yc', // FIREBASE_API_KEY_FOR_ANDROID_NOTIFICATION
		'Content-Type: application/json'
		);
		// Open connection
		$ch = curl_init();
		 
		// Set the url, number of POST vars, POST data
		curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		 
		// Disabling SSL Certificate support temporarly
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
		 
		// Execute post
		$result = curl_exec($ch );
		if($result === false){
		die('Curl failed:' .curl_errno($ch));
		}
		 
		// Close connection
		curl_close( $ch );
		return $result;
		}
		
		
		
		//alert open ticket
		//parameter: ticket_id
		public function alert_open_tt() {
			$ticke=$this->db
			->join("user","user.user_id=ticket.ticket_creator_id","left")
			->where("ticket_id",$this->input->get("ticket_id"))
			->get("ticket");
			foreach($ticke->result() as $ticket){
			
				//kst					
				$useraler=$this->db
				->where("region_id",$ticket->region_id)
				->where("station_id",$ticket->station_id)
				->where("position_id",2)
				->get("user");
				foreach($useraler->result() as $useralert){	
					$data["fcm_registered_id"]=$useralert->fcm_registered_id;
					$data1["data"][]=$data;	
				}	//echo $this->db->last_query();
				
				//korwil					
				$useraler=$this->db
				->where("region_id",$ticket->region_id)
				->where("position_id",3)
				->get("user");
				foreach($useraler->result() as $useralert){	
					$data["fcm_registered_id"]=$useralert->fcm_registered_id;
					$data1["data"][]=$data;	
				}	//echo $this->db->last_query();
				
				//kadepwil				
				$useraler=$this->db
				->where("department_id	",$ticket->department_id)
				->where("position_id",4)
				->get("user");
				foreach($useraler->result() as $useralert){	
					$data["fcm_registered_id"]=$useralert->fcm_registered_id;
					$data1["data"][]=$data;	
				}	
				
				//kadepts				
				$useraler=$this->db
				->where("position_id",5)
				->get("user");
				foreach($useraler->result() as $useralert){	
					$data["fcm_registered_id"]=$useralert->fcm_registered_id;
					$data1["data"][]=$data;	
				}	
				$this->djson(array(
					"data"=>$data1
				));
				// echo json_encode($data1);					  						  	
			}
		}
		
		//alert escalation ticket
		//parameter: ticket_id, user_id(user yg melakukan eskalasi)
		public function alert_escalation_tt() {
			$ticke=$this->db
			->join("user","user.user_id=escalation.escalation_fromuserid","left")
			->where("ticket_id",$this->input->get("ticket_id"))
			->where("escalation_fromuserid",$this->input->get("user_id"))
			->get("escalation");
			//echo $this->db->last_query();
			foreach($ticke->result() as $ticket){
			
				//kst		
				if($ticket->position_id<2){				
					$useraler=$this->db
					->where("region_id",$ticket->region_id)
					->where("station_id",$ticket->station_id)
					->where("position_id",2)
					->get("user");
					foreach($useraler->result() as $useralert){	
						$data["fcm_registered_id"]=$useralert->fcm_registered_id;
						$data1["data"][]=$data;	
					}	//echo $this->db->last_query();
				}
				
				//korwil
				if($ticket->position_id<3){					
					$useraler=$this->db
					->where("region_id",$ticket->region_id)
					->where("position_id",3)
					->get("user");
					foreach($useraler->result() as $useralert){	
						$data["fcm_registered_id"]=$useralert->fcm_registered_id;
						$data1["data"][]=$data;	
					}	//echo $this->db->last_query();
				}
				
				//kadepwil	
				if($ticket->position_id<4){				
					$useraler=$this->db
					->where("department_id	",$ticket->department_id)
					->where("position_id",4)
					->get("user");
					foreach($useraler->result() as $useralert){	
						$data["fcm_registered_id"]=$useralert->fcm_registered_id;
						$data1["data"][]=$data;	
					}
				}	
				
				//kadepts
				if($ticket->position_id<5){					
					$useraler=$this->db
					->where("position_id",5)
					->get("user");
					foreach($useraler->result() as $useralert){	
						$data["fcm_registered_id"]=$useralert->fcm_registered_id;
						$data1["data"][]=$data;	
					}
				}	
				echo json_encode($data1);					  						  	
			}
		}
		
		public function stop_clock() {
			$input["ticket_no"]=$this->input->post("ticket_no");
			$input["log_desc"]="Stop Clock";
			$input["log_status"]="Done";
			$input["ticket_date"]=date("Y-m-d H:i:s");
			$input["stop_clock"]=1;
			$this->db->insert("ticket_log",$input);
			if($this->db->insert_id()>0) {
				$this->djson(array(
					"status"=>"success",
					"message"=>"Stopping Clock Success"
				));
				} else {
				$this->djson(array(
					"status"=>"failed",
					"message"=>"Stopping Clock Failed"
				));
			} 
		}
		
		public function resume_clock() {
			$input["ticket_no"]=$this->input->post("ticket_no");
			$input["log_desc"]="Resume Clock";
			$input["log_status"]="Done";
			$input["ticket_date"]=date("Y-m-d H:i:s");
			
			//idle time
			$clock=$this->db
			->where("ticket_no",$input["ticket_no"])
			->where("stop_clock","1")
			->order_by("log_id","desc")
			->get("ticket_log");
			if($clock->num_rows()>0){$stopclock=$clock->row()->ticket_date;}else{$stopclock=date("Y-m-d H:i:s");}		
			$resumeclock=date("Y-m-d H:i:s");
			$second=(strtotime($resumeclock)-strtotime($stopclock));			
			$input["resume_clock"]=$second;
			
			$this->db->insert("ticket_log",$input);
			if($this->db->insert_id()>0) {
				$this->djson(array(
					"status"=>"success",
					"message"=>"Resuming Clock Success"
				));
				} else {
				$this->djson(array(
					"status"=>"failed",
					"message"=>"Resuming Clock Failed"
				));
			} 
		}
		
		function getReturnTicket($id) {
		$query = "SELECT t.ticket_id, t.ticket_date, t.ticket_type, t.ticket_station_id, s.station_name, t.ticket_suspect_id, su.suspect_name, t.ticket_remarks, t.ticket_severity, t.ticket_status, t.ticket_creator_id, u.user_name, t.ticket_photo_1, t.ticket_photo_2, t.ticket_photo_3, 
		t.ticket_no, t.isuspect1_id, s1.isuspect1_name, t.isuspect2_id, s2.isuspect2_name, t.isuspect3_id, s3.isuspect3_name 
					FROM ticket t INNER JOIN station s ON t.ticket_station_id = s.station_id
					INNER JOIN USER u ON t.ticket_creator_id = u.user_id
					LEFT JOIN initial_suspect su ON t.ticket_suspect_id = su.suspect_id
					LEFT JOIN isuspect1 s1 ON t.isuspect1_id = s1.isuspect1_id
					LEFT JOIN isuspect2 s2 ON t.isuspect2_id = s2.isuspect2_id
					LEFT JOIN isuspect3 s3 ON t.isuspect3_id = s3.isuspect3_id 
					WHERE t.ticket_id=".$id;
		return $this->db->query($query)->row();
	}
	
		//tt activity list
		public function activityList() {
			
			//parameter input
			$user_id=$this->input->post("user_id");			
			
			
			$user1=$this->db
			->where("user_id",$user_id)
			->get("user");
			if($user1->num_rows()>0){
			foreach($user1->result() as $user){
			
				if($user->position_id==1||$user->position_id==2){
				$this->db->where("station_id",$user->station_id);
				}
				
				if($user->position_id==3){
				$this->db->where("region_id",$user->region_id);
				}
				
				if($user->position_id==4){
				$this->db->where("department_id",$user->department_id);
				}
			
				$statio=$this->db				
				->get("station");
				foreach($statio->result() as $station){
					$data1["station"][]=$station->station_name;
					$usr=$this->db
					->join("(SELECT user_id as userclose_id, user_name as userclose_name FROM user)AS userclose","userclose.userclose_id=ticket.ticket_closedby","left")
					->join("user","user.user_id=ticket.ticket_creator_id","left")
					->join("position","position.position_id=ticket.ticket_position","left")
					->join("suspect_module","suspect_module.suspect_module=ticket.ticket_type","left")
					->join("initial_suspect","initial_suspect.suspect_id=ticket.ticket_suspect_id","left")
					->join("station","station.station_id=ticket.ticket_station_id","left")
					->where("ticket_station_id",$station->station_id)
					->order_by("ticket_status", "DESC")
					->get("ticket");
					//echo $this->db->last_query();
					if($usr->num_rows()>0){
						foreach($usr->result() as $ticket){
						$data["ticket_id"]=$ticket->ticket_id;
						$data["ticket_no"]=$ticket->ticket_no;
						if($ticket->ticket_status==1){
							$data["status"]="Open";
						}elseif($ticket->ticket_status==2){
							$data["status"]="Confirm";
						}else{
							$data["status"]="Closed";
						}
						$data["ticket_date"]=date("Y-m-d",strtotime($ticket->ticket_date));
						$data["creator"]=$ticket->user_name;
						$data["suspect_module_name"]=$ticket->suspect_module_name;
						$data["station_name"]=$ticket->station_name;
						$data["position_name"]=$ticket->position_name;
						$data1["tickets"][]=$data;
					}
						
						$data1["keterangan"][]= $usr->num_rows()." Tickets";
					}else{
						$data1["keterangan"][]="No Ticket";
					}
					
				}
				$data2["data"][]=$data1;
				$data2["message"][]="Success";
			}
			}else{$data2["message"][]="Failed";}
			$this->djson($data2);								
			
		}
		
		//tt activity detail
		public function activityDetail() {
			
			//parameter input
			$input["ticket_id"]=$this->input->post("ticket_id");			
			$noeskalasi=1;
			$tick=$this->db
			->get_where('ticket',$input);	
			if($tick->num_rows()>0)
			{
				foreach($tick->result() as $ticket){
					$insuspe=$this->db
					->join("Isuspect1","Isuspect1.Isuspect1_id=ticket.Isuspect1_id","left")
					->join("Isuspect2","Isuspect2.Isuspect2_id=ticket.Isuspect2_id","left")
					->join("Isuspect3","Isuspect3.Isuspect3_id=ticket.Isuspect3_id","left")
					->join("Isuspect4","Isuspect4.Isuspect4_id=ticket.Isuspect4_id","left")
					->where("ticket_id",$ticket->ticket_id)
					->get("ticket");
					$insuspect="";
					foreach($insuspe->result() as $insuspec){$insuspect=$insuspec->isuspect1_name." > ".$insuspec->isuspect2_name." > ".$insuspec->isuspect3_name." > ".$insuspec->isuspect4_name;}
					
					$data2["judul"]="Ticket ".$ticket->ticket_no;
					$data2["isuspect"]=$insuspect;					
					//$n=1;
					
					$lo=$this->db
					->where("ticket_no",$ticket->ticket_no)
					->order_by("ticket_date", "ASC")
					->get("ticket_log");
					$rown=$lo->num_rows();					
					foreach($lo->result() as $log){
					//$data2["urutan".$n]=$log->ticket_date;$n++;
					
						//open tt
						if($log->ticket_id!=0){
							$tick=$this->db
							->join("severity","severity.severity_id=ticket.ticket_severity","left")
							->join("user","user.user_id=ticket.ticket_creator_id","left")
							->join("position","position.position_id=user.position_id","left")
							->join("station","station.station_id=user.station_id","left")
							->where("ticket_id",$log->ticket_id)
							->get("ticket");
							
							foreach($tick->result() as $tic){
								$station_name=$tic->station_name;
								$severity_name=$tic->severity_name;
								$opentt["opentt_date"]=date("Y-m-d H:i:s",strtotime($tic->ticket_date));
								$opentt["user_name"]=$tic->user_name;
								$opentt["position_name"]=$tic->position_name;
								$opentt["ticket_remarks"]=$tic->ticket_remarks;
								
								//aging						
								$aw=$tic->ticket_date;
								$akh=$tic->ticket_date;
								$second=(strtotime($aw)-strtotime($akh));								
								
								$awal  = date_create($aw);
								$akhir = date_create($akh); 
								$diff  = date_diff( $awal, $akhir );								
																
								if($diff->m > 0){echo $diff->m . ' months ';}else{		
									$days=floor($second/60/60/24);
									$second=$second-($days*60*60*24);											
									
									$hours=floor($second/60/60);
									$second=$second-($hours*60*60);
									
									$minutes=floor($second/60);
									$second=$second-($minutes*60);
									
									if($days>0){$duration=$days." d ".$hours." h ".$minutes." m ".$second." s ";}
									elseif($hours>0){$duration=$hours." h ".$minutes." m ".$second." s ";}
									elseif($minutes>0){$duration=$minutes." m ".$second." s ";}
									else{$duration=$second." second ";}
									
											
									$status_now="Open TT";
									
								}
																	
							
							}
							$data1["opentt"][]=$opentt;
						}
						
						//eskalasi tt
						if($log->escalation_id!=0){
							$esca=$this->db
							->join("ticket","ticket.ticket_id=escalation.ticket_id","left")
							->join("user","user.user_id=escalation.escalation_fromuserid","left")
							->join("position","position.position_id=user.position_id","left")
							->join("station","station.station_id=user.station_id","left")
							->where("escalation_id",$log->escalation_id)
							->get("escalation");
							foreach($esca->result() as $esc){
								if($noeskalasi==1){
								$eskalasi1["escalation_date"]=date("Y-m-d H:i:s",strtotime($log->ticket_date));
								$eskalasi1["user_name"]=$esc->user_name;
								$eskalasi1["position_name"]=$esc->position_name;
								$eskalasi1["escalation_action"]=$esc->escalation_action;
								$eskalasi1["escalation_require"]=$esc->escalation_require;
								$data1["eskalasitt1"][]=$eskalasi1;
								$status_now="Eskalasi TT 1";
								}
								if($noeskalasi==2){
								$eskalasi2["escalation_date"]=date("Y-m-d H:i:s",strtotime($log->ticket_date));
								$eskalasi2["user_name"]=$esc->user_name;
								$eskalasi2["position_name"]=$esc->position_name;
								$eskalasi2["escalation_action"]=$esc->escalation_action;
								$eskalasi2["escalation_require"]=$esc->escalation_require;
								$data1["eskalasitt2"][]=$eskalasi2;
								$status_now="Eskalasi TT 2";
								}
								if($noeskalasi==3){
								$eskalasi3["escalation_date"]=date("Y-m-d H:i:s",strtotime($log->ticket_date));
								$eskalasi3["user_name"]=$esc->user_name;
								$eskalasi3["position_name"]=$esc->position_name;
								$eskalasi3["escalation_action"]=$esc->escalation_action;
								$eskalasi3["escalation_require"]=$esc->escalation_require;
								$data1["eskalasitt3"][]=$eskalasi3;
								$status_now="Eskalasi TT 3";
								}
								if($noeskalasi==4){
								$eskalasi4["escalation_date"]=date("Y-m-d H:i:s",strtotime($log->ticket_date));
								$eskalasi4["user_name"]=$esc->user_name;
								$eskalasi4["position_name"]=$esc->position_name;
								$eskalasi4["escalation_action"]=$esc->escalation_action;
								$eskalasi4["escalation_require"]=$esc->escalation_require;
								$data1["eskalasitt4"][]=$eskalasi4;
								$status_now="Eskalasi TT 4";
								}
								
								//aging						
								$aw=$esc->escalation_datetime;
								$akh=$esc->ticket_date;
								$second=(strtotime($aw)-strtotime($akh));								
								
								$awal  = date_create($aw);
								$akhir = date_create($akh); 
								$diff  = date_diff( $awal, $akhir );								
																
								if($diff->m > 0){echo $diff->m . ' months ';}else{		
									$days=floor($second/60/60/24);
									$second=$second-($days*60*60*24);											
									
									$hours=floor($second/60/60);
									$second=$second-($hours*60*60);
									
									$minutes=floor($second/60);
									$second=$second-($minutes*60);
									
									if($days>0){$duration=$days." d ".$hours." h ".$minutes." m ".$second." s ";}
									elseif($hours>0){$duration=$hours." h ".$minutes." m ".$second." s ";}
									elseif($minutes>0){$duration=$minutes." m ".$second." s ";}
									else{$duration=$second." second ";}
								}
																	
							
							}
							$noeskalasi++;
						}
						
						//assignment tt
						if($log->assignment_id!=0&&$log->stop_clock==0&&$log->resume_clock==0){
							$asgn=$this->db
							->join("assignment_action","assignment_action.assignment_action_id=assignment.assignment_action_id","left")
							->join("ticket","ticket.ticket_id=assignment.ticket_id","left")
							->join("user","user.user_id=assignment.assignment_fromuserid","left")
							->join("position","position.position_id=user.position_id","left")
							->join("(SELECT user_id AS userto_id, user_name AS userto_name, position_id AS positionto_id FROM user)
							AS userto","userto.userto_id=assignment.assignment_touserid","left")
							->join("(SELECT position_id AS positionto_id, position_name AS positionto_name FROM position)
							AS positionto","positionto.positionto_id=userto.positionto_id","left")
							->join("station","station.station_id=user.station_id","left")
							->where("assignment_id",$log->assignment_id)
							->where("assignment_onsite !=",1)
							->where("assignment_onsite !=",3)
							->get("assignment");
							foreach($asgn->result() as $asg){
								
								$assignment["assignment_date"]=date("Y-m-d H:i:s",strtotime($asg->assignment_datetime));
								$assignment["user_name"]=$asg->user_name;
								$assignment["position_name"]=$asg->position_name;
								$assignment["assign_to"]=ucfirst($asg->userto_name).", ".$asg->positionto_name;
								$assignment["action"]=$asg->assignment_action_name;
								if($asg->assignment_action_id==2){
									$assignment["ditugaskan_tgl"]=date("M d,Y",strtotime($asg->assignment_onsite_date));
									$assignment["catatan"]=$asg->assignment_info;
								}
								$data1["assignment"][]=$assignment;
								$status_now="Assignment TT";
								
								
								//aging						
								$aw=$asg->assignment_datetime;
								$akh=$asg->ticket_date;
								$second=(strtotime($aw)-strtotime($akh));								
								
								$awal  = date_create($aw);
								$akhir = date_create($akh); 
								$diff  = date_diff( $awal, $akhir );								
																
								if($diff->m > 0){echo $diff->m . ' months ';}else{		
									$days=floor($second/60/60/24);
									$second=$second-($days*60*60*24);											
									
									$hours=floor($second/60/60);
									$second=$second-($hours*60*60);
									
									$minutes=floor($second/60);
									$second=$second-($minutes*60);
									
									if($days>0){$duration=$days." d ".$hours." h ".$minutes." m ".$second." s ";}
									elseif($hours>0){$duration=$hours." h ".$minutes." m ".$second." s ";}
									elseif($minutes>0){$duration=$minutes." m ".$second." s ";}
									else{$duration=$second." second ";}
								}
																	
							
							}
							$noeskalasi++;
						}
						
						//request onsite
						if($log->assignment_id!=0){
							$asgn=$this->db
							->join("ticket","ticket.ticket_id=assignment.ticket_id","left")
							->join("user","user.user_id=assignment.assignment_touserid","left")
							->join("position","position.position_id=user.position_id","left")
							->join("(SELECT user_id AS userto_id, user_name AS userto_name, position_id AS positionto_id FROM user)
							AS userto","userto.userto_id=assignment.assignment_touserid","left")
							->join("(SELECT position_id AS positionto_id, position_name AS positionto_name FROM position)
							AS positionto","positionto.positionto_id=userto.positionto_id","left")
							->join("station","station.station_id=user.station_id","left")
							->where("assignment_id",$log->assignment_id)
							->where("assignment_onsite",1)
							->get("assignment");
							foreach($asgn->result() as $asg){
								
								$request["request_date"]=date("Y-m-d H:i:s",strtotime($asg->assignment_datetime));
								$request["user_name"]=$asg->user_name;
								$request["position_name"]=$asg->position_name;
								$request["keterangan"]=ucfirst($asg->assignment_request_remaks);
								
								$data1["request_onsite"][]=$request;
								$status_now="Request Onsite";
								
								
								//aging						
								$aw=$asg->assignment_datetime;
								$akh=$asg->ticket_date;
								$second=(strtotime($aw)-strtotime($akh));								
								
								$awal  = date_create($aw);
								$akhir = date_create($akh); 
								$diff  = date_diff( $awal, $akhir );								
																
								if($diff->m > 0){echo $diff->m . ' months ';}else{		
									$days=floor($second/60/60/24);
									$second=$second-($days*60*60*24);											
									
									$hours=floor($second/60/60);
									$second=$second-($hours*60*60);
									
									$minutes=floor($second/60);
									$second=$second-($minutes*60);
									
									if($days>0){$duration=$days." d ".$hours." h ".$minutes." m ".$second." s ";}
									elseif($hours>0){$duration=$hours." h ".$minutes." m ".$second." s ";}
									elseif($minutes>0){$duration=$minutes." m ".$second." s ";}
									else{$duration=$second." second ";}
								}
																	
							
							}
							
						}
						
						//reject request onsite
						if($log->assignment_id!=0){
							$asgn=$this->db
							->join("ticket","ticket.ticket_id=assignment.ticket_id","left")
							->join("user","user.user_id=assignment.assignment_fromuserid","left")
							->join("position","position.position_id=user.position_id","left")
							->join("(SELECT user_id AS userto_id, user_name AS userto_name, position_id AS positionto_id FROM user)AS userto","userto.userto_id=assignment.assignment_touserid","left")
							->join("(SELECT position_id AS positionto_id, position_name AS positionto_name FROM position)AS positionto","positionto.positionto_id=userto.positionto_id","left")
							->join("station","station.station_id=user.station_id","left")
							->where("assignment_id",$log->assignment_id)
							->where("assignment_onsite",3)
							->get("assignment");
							foreach($asgn->result() as $asg){
								
								$reject["reject_date"]=date("Y-m-d H:i:s",strtotime($asg->assignment_datetime));
								$reject["rejected_by"]=ucfirst($asg->user_name).", ".$asg->position_name;
								
								$data1["reject_request"][]=$reject;
								$status_now="Reject Request Onsite";
								
								
								//aging						
								$aw=$asg->assignment_datetime;
								$akh=$asg->ticket_date;
								$second=(strtotime($aw)-strtotime($akh));								
								
								$awal  = date_create($aw);
								$akhir = date_create($akh); 
								$diff  = date_diff( $awal, $akhir );								
																
								if($diff->m > 0){echo $diff->m . ' months ';}else{		
									$days=floor($second/60/60/24);
									$second=$second-($days*60*60*24);											
									
									$hours=floor($second/60/60);
									$second=$second-($hours*60*60);
									
									$minutes=floor($second/60);
									$second=$second-($minutes*60);
									
									if($days>0){$duration=$days." d ".$hours." h ".$minutes." m ".$second." s ";}
									elseif($hours>0){$duration=$hours." h ".$minutes." m ".$second." s ";}
									elseif($minutes>0){$duration=$minutes." m ".$second." s ";}
									else{$duration=$second." second ";}
								}
																	
							
							}
							
						}
						
						//stop clock
						if($log->stop_clock==1){
							$awalclock="0000-00-00 00:00:00";	
							$tic=$this->db
								->where("ticket_no",$log->ticket_no)
								->get("ticket");
							foreach($tic->result() as $tick){$awalclock=$tick->ticket_date; $tickid=$tick->ticket_id;};
							?>
								<?php if ($h==1){?>											
								<script>
								$(document).ready(function(){
									$("#status").html("Stop Clock TT");
									$("#statusdate").html("Stop Clock Date: <?=date("M d,Y",strtotime($log->ticket_date));?>");
									$.get("<?=site_url("durasi");?>",{awal:'<?=$log->ticket_date;?>',akhir:'<?=$awalclock;?>'})
									.done(function(data){												
										$("#aging").html(data);
									});
								});
								</script>
								<?php }
								$as=$this->db
								->join("user","user.user_id=assignment.assignment_touserid","left")
								->join("position","position.position_id=user.position_id","left")
								->join("station","station.station_id=user.station_id","left")
								->where("ticket_id",$tickid)
								->where("assignment_action_id",2)
								->where("assignment_id",$log->assignment_id)
								->get("assignment");
								foreach($as->result() as $asg){
								
								$stopclock["stopclock_date"]=date("Y-m-d H:i:s",strtotime($log->ticket_date));
								$stopclock["engineer_onsite"]=ucfirst($asg->user_name).", ".$asg->position_name;
								
								$data1["stop_clock"][]=$stopclock;
								$status_now="Stop Clock";
								
								
								//aging						
								$aw=$log->ticket_date;
								$akh=$awalclock;
								$second=(strtotime($aw)-strtotime($akh));								
								
								$awal  = date_create($aw);
								$akhir = date_create($akh); 
								$diff  = date_diff( $awal, $akhir );								
																
								if($diff->m > 0){echo $diff->m . ' months ';}else{		
									$days=floor($second/60/60/24);
									$second=$second-($days*60*60*24);											
									
									$hours=floor($second/60/60);
									$second=$second-($hours*60*60);
									
									$minutes=floor($second/60);
									$second=$second-($minutes*60);
									
									if($days>0){$duration=$days." d ".$hours." h ".$minutes." m ".$second." s ";}
									elseif($hours>0){$duration=$hours." h ".$minutes." m ".$second." s ";}
									elseif($minutes>0){$duration=$minutes." m ".$second." s ";}
									else{$duration=$second." second ";}
								}
																	
							
							}
							
						}
						
						//resume clock
						if($log->resume_clock!=0){	
							$awalclock="0000-00-00 00:00:00";
							$stopclock="0000-00-00 00:00:00";
							$tic=$this->db
								->where("ticket_no",$log->ticket_no)
								->get("ticket");
							foreach($tic->result() as $tick){$awalclock=$tick->ticket_date;};
							$stopcloc=$this->db
							->where("stop_clock","1")
							->where("ticket_no",$log->ticket_no)
							->get("ticket_log");
							
							foreach($stopcloc->result() as $stopclock){$stopclock=$stopclock->ticket_date; $tickid=$tick->ticket_id;}
							$as=$this->db
								->join("user","user.user_id=assignment.assignment_touserid","left")
								->join("position","position.position_id=user.position_id","left")
								->join("station","station.station_id=user.station_id","left")
								->where("ticket_id",$tickid)
								->where("assignment_action_id",2)
								->get("assignment");
								foreach($as->result() as $asg){
								
								$resumeclock["resumeclock_date"]=date("Y-m-d H:i:s",strtotime($log->ticket_date));
								$resumeclock["engineer_onsite"]=ucfirst($asg->user_name).", ".$asg->position_name;
								
								
								//aging						
								$aw=$stopclock;
								$akh=$awalclock;
								$second=(strtotime($aw)-strtotime($akh));								
								
								$awal  = date_create($aw);
								$akhir = date_create($akh); 
								$diff  = date_diff( $awal, $akhir );								
																
								if($diff->m > 0){echo $diff->m . ' months ';}else{		
									$days=floor($second/60/60/24);
									$second=$second-($days*60*60*24);											
									
									$hours=floor($second/60/60);
									$second=$second-($hours*60*60);
									
									$minutes=floor($second/60);
									$second=$second-($minutes*60);
									
									if($days>0){$idletime=$days." d ".$hours." h ".$minutes." m ".$second." s ";}
									elseif($hours>0){$idletime=$hours." h ".$minutes." m ".$second." s ";}
									elseif($minutes>0){$idletime=$minutes." m ".$second." s ";}
									else{$idletime=$second." second ";}
								}
								
								
								$resumeclock["idle_time"]=$idletime;
								
								$data1["resume_clock"][]=$resumeclock;
								$status_now="Resume Clock TT";									
							
							}
							
						}
						
						//closed tiket
						if($log->closett_id!=0){
							$clos=$this->db
							->join("ticket","ticket.ticket_id=closett.ticket_id","left")
							->join("user","user.user_id=closett.closett_userid","left")
							->join("position","position.position_id=user.position_id","left")
							->join("station","station.station_id=user.station_id","left")
							->where("closett_id",$log->closett_id)
							->get("closett");
							foreach($clos->result() as $clo){
								
								$closed["closed_date"]=date("Y-m-d H:i:s",strtotime($clo->closett_datetime));
								$closed["user_name"]=ucfirst($clo->user_name).", ".$clo->position_name;
								$closed["info"]=$clo->closett_info;
								
								$data1["closing_ticket"][]=$closed;
								$status_now="Closing Ticket";
								
								$idl=$this->db
								->where("ticket_no",$clo->ticket_no)
								->where("resume_clock >","0")
								->get("ticket_log");
								if($idl->num_rows()>0){
								foreach($idl->result() as $idle){
									
									$idle = $idle->resume_clock;
								}
								}else{
									$idle = 0;
								}
								//aging						
								$aw=$clo->closett_datetime;
								$akh=$clo->ticket_date;
								
								if(isset($_GET['idle'])){
									$second=(strtotime($aw)-strtotime($akh))-$idle;
								}else{
									$second=(strtotime($aw)-strtotime($akh));
								}
																
								
								$awal  = date_create($aw);
								$akhir = date_create($akh); 
								$diff  = date_diff( $awal, $akhir );								
																
								if($diff->m > 0){echo $diff->m . ' months ';}else{		
									$days=floor($second/60/60/24);
									$second=$second-($days*60*60*24);											
									
									$hours=floor($second/60/60);
									$second=$second-($hours*60*60);
									
									$minutes=floor($second/60);
									$second=$second-($minutes*60);
									
									if($days>0){$duration=$days." d ".$hours." h ".$minutes." m ".$second." s ";}
									elseif($hours>0){$duration=$hours." h ".$minutes." m ".$second." s ";}
									elseif($minutes>0){$duration=$minutes." m ".$second." s ";}
									else{$duration=$second." second ";}
								}
																	
							
							}
							
						}
						
						//confirm tiket
						if($log->ticket_confirmby!=0){
							$conf=$this->db											
							->join("ticket","ticket.ticket_id=confirm.ticket_id","left")
							->join("user","user.user_id=confirm.confirm_userid","left")
							->join("position","position.position_id=user.position_id","left")
							->join("station","station.station_id=user.station_id","left")
							->where("confirm_id",$log->confirm_id)
							->get("confirm");
							//echo $this->db->last_query();
							foreach($conf->result() as $con){
								
								$confirm["confirm_date"]=date("Y-m-d H:i:s",strtotime($con->confirm_datetime));
								$confirm["user_name"]=ucfirst($con->user_name).", ".$con->position_name;
								$confirm["info"]=$con->confirm_info;
								
								$data1["confirm_ticket"][]=$confirm;
								$status_now="Confirm Closing Ticket";
								
								$idl=$this->db
								->where("ticket_no",$con->ticket_no)
								->where("resume_clock >","0")
								->get("ticket_log");
								if($idl->num_rows()>0){
								foreach($idl->result() as $idle){
									
									$idle = $idle->resume_clock;
								}
								}else{
									$idle = 0;
								}
								//aging						
								$aw=$con->ticket_confirmby_datetime;
								$akh=$con->ticket_date;
								
								if(isset($_GET['idle'])){
									$second=(strtotime($aw)-strtotime($akh))-$idle;
								}else{
									$second=(strtotime($aw)-strtotime($akh));
								}
																
								
								$awal  = date_create($aw);
								$akhir = date_create($akh); 
								$diff  = date_diff( $awal, $akhir );								
																
								if($diff->m > 0){echo $diff->m . ' months ';}else{		
									$days=floor($second/60/60/24);
									$second=$second-($days*60*60*24);											
									
									$hours=floor($second/60/60);
									$second=$second-($hours*60*60);
									
									$minutes=floor($second/60);
									$second=$second-($minutes*60);
									
									if($days>0){$duration=$days." d ".$hours." h ".$minutes." m ".$second." s ";}
									elseif($hours>0){$duration=$hours." h ".$minutes." m ".$second." s ";}
									elseif($minutes>0){$duration=$minutes." m ".$second." s ";}
									else{$duration=$second." second ";}
								}
																	
							
							}
							
						}
						
					$data2["tahapan"]=$data1;
											
					}
					$data2["station_name"]=$station_name;
					$data2["severity_name"]=$severity_name;
					$data2["aging"]=$duration;
					$data2["open_tt_date"]=$opentt["opentt_date"];
					$data2["status_now"]=$status_now;

				}
				$data2["message"][]="Success";
			}else{
				$data2["message"][]="Failed";
			}
			$this->djson($data2);								
			
		}
		
		//list user escalation to
		public function escalationto() {
		
			//parameter input
			$ticket_id=$this->input->post("ticket_id");	
			$position_id=$this->input->post("position_id");	
			
			$ti=$this->db
			->join("station","station.station_id=ticket.ticket_station_id","left")
			->join("region","region.region_id=station.region_id","left")
			->join("department","department.department_id=region.department_id","left")
			->where("ticket_id",$ticket_id)
			->get("ticket");
			if($ti->num_rows()>0){
				foreach($ti->result() as $tic){
				if($position_id==1){
					$us=$this->db		
					->join("position","position.position_id=user.position_id","left")								
					->where("user.position_id",2)
					->where("station_id",$tic->station_id)
					->get("user");
					foreach($us->result() as $user){
						$data["user_id"]=$user->user_id;
						$data["user_name"]=$user->user_name." - ".$user->position_name." - ".$tic->station_name." - ".$tic->region_name." , ".$tic->department_name;
						$data1["escalation_to"][]=$data;
					}
				}
				if($position_id==1||$position_id==2){
					$us=$this->db
					->join("position","position.position_id=user.position_id","left")	
					->where("user.position_id",3)
					->where("region_id",$tic->region_id)
					->get("user");
					foreach($us->result() as $user){
						$data["user_id"]=$user->user_id;
						$data["user_name"]=$user->user_name." - ".$user->position_name." - ".$tic->region_name." , ".$tic->department_name;	
						$data1["escalation_to"][]=$data;				
					}
				}
				if($position_id==1||$position_id==2||$position_id==3){
					$us=$this->db
					->join("position","position.position_id=user.position_id","left")	
					->where("user.position_id",4)
					->where("department_id",$tic->department_id)
					->get("user");
					foreach($us->result() as $user){
						$data["user_id"]=$user->user_id;
						$data["user_name"]=$user->user_name." - ".$user->position_name." , ".$tic->department_name;	
						$data1["escalation_to"][]=$data;
					}
				}				
				if($position_id==1||$position_id==2||$position_id==3||$position_id==4){
					$us=$this->db
					->join("position","position.position_id=user.position_id","left")	
					->where("user.position_id",5)
					->get("user");
					foreach($us->result() as $user){
						$data["user_id"]=$user->user_id;
						$data["user_name"]=$user->user_name." - ".$user->position_name;	
						$data1["escalation_to"][]=$data;
					}
				}
				
				
			}
			$data1["message"]="success";
			}
			else{
			$data1["message"]="failed";
			}
			$this->djson($data1);			
		}

	
}