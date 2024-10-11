<!DOCTYPE html>
<html>
	<head>
		<title>Print Task</title>
		<meta charset="utf-8">
		<meta name="viewtaskrt" content="width=device-width, initial-scale=1">
		<link href="<?=base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet">	
		<script src="<?=base_url("assets/js/jquery-1.11.1.min.js");?>"></script>
		<script src="<?=base_url('assets/js/bootstrap-datepicker.js');?>"></script>
	<body>
	<div class="container">
	<div class="row">      
	<?php 
	$identity=$this->db->get("identity")->row();
	if($identity->identity_kop==1){
		require_once("kop.php");
	}
	?>
		<div class="col-md-12 col-sm-12 col-xs-12" style="border-bottom: black solid 1px; margin-bottom:5px;"><h2 style="">All Task</h2></div>
		<div class="col-md-12">
		<table id="dataTable" class="table table-condensed table-hover">
									<thead>
										<tr>
											<th>No.</th>
											<?php if($this->session->userdata("position_id")!=6){?>
											<th>Date</th>
											<th>Due Date  </th>
											<?php }?>
											<th>Finished Date </th>
											<?php if($this->session->userdata("position_id")!=6){?>
											<th>INV No.</th>
											<?php }?>
											<th>Task No. </th>
											<th>Customer</th>
											<?php if($this->session->userdata("position_id")!=6){?>
											<th>Teknisi</th>
											<?php }?>
											<th>Task</th>
											<th>Status</th>
											<th class="col-md-1">Proof </th>
											<?php if(!isset($_GET['report'])){$col="col-md-3";}else{$col="col-md-1";}?>
										</tr>
									</thead>
									<tbody> 
										<?php 
										if(isset($_GET['inv_no'])){$this->db->where("inv_no",$_GET['inv_no']);}
										
										if($this->session->userdata("position_id")==2){
											$this->db->where("task.user_id",$this->session->userdata("user_id"));
										}
										if($this->session->userdata("position_id")==6){
											$this->db->where("task.customer_id",$this->session->userdata("customer_id"));
										}
										if(isset($_GET['user_id'])&& $_GET['user_id']!=""){
											$this->db->where("task.user_id",$this->input->get("user_id"));
										}
										$usr=$this->db
										->join("user","user.user_id=task.user_id","left")
										->join("customer","customer.customer_id=task.customer_id","left")
										->order_by("task_id","desc")
										->get("task");
										//echo $this->db->last_query();
										$no=1;
										foreach($usr->result() as $task){
										$warna="background-color:#BAFFC9;"; $status="Done";										
										if($task->task_finished=="0000-00-00"){
											$warna="background-color:#FFB3BA;"; $status="";
										}
										?>
										<tr style="<?=$warna;?>">
											<td><?=$no++;?></td>
											<?php if($this->session->userdata("position_id")!=6){?>											
											<td><?=$task->task_date;?></td>
											<td><?=($task->task_due=="0000-00-00")?"":$task->task_due;?></td>
											<?php }?>
											<td><?=($task->task_finished=="0000-00-00")?"":$task->task_finished;?></td>
											<?php if($this->session->userdata("position_id")!=6){?>
											<td><?=$task->inv_no;?></td>
											<?php }?>
											<td><?=$task->task_no;?></td>
											<td><?=$task->customer_name;?></td>
											<?php if($this->session->userdata("position_id")!=6){?>
											<td><?=$task->user_name;?></td>
											<?php }?>
											<td><?=$task->task_content;?></td>
											<td><?=$status;?></td>																					
											<td><?php if($task->task_picture!=""){$gambar=$task->task_picture;}else{$gambar="noimage.png";}?>
                                                <img src="<?=base_url("assets/images/task_picture/".$gambar);?>" alt="approve" style="width:20px; height:20px;" onClick="tampil(this)">
                                                <script>
											function tampil(a){
												var gambar=$(a).attr("src");
												$("#imgumum").attr("src",gambar);
												$("#myImage").modal("show");
											}
											  </script>                                            </td>
										</tr>
										<?php }?>
									</tbody>
								</table>
		</div>
	</div>
	</div>
	</body>
</html>
<script>
window.print();
setTimeout(function(){ this.close(); }, 500);
</script>