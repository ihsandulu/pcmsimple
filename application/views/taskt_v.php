<!doctype html>
<html>

<head>
    <?php 	
	require_once("meta.php");?>
  
</head>

<body class="  " >
	<?php require_once("header.php");?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">Task</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-10">
				<h1 class="page-header"> Task</h1>
			</div>
			<?php if(!isset($_POST['new'])&&!isset($_POST['edit'])){?>
			<!--<form method="POST" class="col-md-2">							
				<h1 class="page-header col-md-12"> 
				<button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
				<input type="hidden" name="task_id"/>
				</h1>
			</form>-->
			<?php }?>
		</div>
		
		
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
					<?php if(isset($_POST['new'])||isset($_POST['edit'])){?>
						<div class="">
							<?php if(isset($_POST['edit'])){$namabutton='name="change"';$judul="Update Task";}else{$namabutton='name="create"';$judul="Create Task";}?>	
							<div class="lead"><h3><?=$judul;?></h3></div>
							<form class="form-horizontal" method="POST" enctype="multipart/form-data">
							  <div class="form-group">
								<label class="control-label col-sm-2" for="customer_id">Customer:</label>
								<div class="col-sm-10">
								  <select name="customer_id" class="form-control" required>
								  <option value="">Select Customer</option>
								  <?php $prod=$this->db->get("customer");
								  foreach($prod->result() as $customer){?>
								  <option value="<?=$customer->customer_id;?>" <?php if($customer_id==$customer->customer_id){?>selected="selected"<?php }?>>
								  	<?=$customer->customer_name;?>
								  </option>
								  <?php }?>
								  </select>
								</div>
							  </div>
													  
							  	
													  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="task_pengirim">Teknisi:</label>
								<div class="col-sm-10">
								 <select name="user_id" class="form-control" required>
								  <option value="">Select Teknisi</option>
								  <?php $tek=$this->db
								  ->where("position_id","2")
								  ->get("user");
								  foreach($tek->result() as $teknisi){?>
								  <option value="<?=$teknisi->user_id;?>" <?php if($user_id==$teknisi->user_id){?>selected="selected"<?php }?>>
								  	<?=$teknisi->user_name;?>
								  </option>
								  <?php }?>
								  </select>
								</div>
							  </div>	
							  
							   <div class="form-group">
								<label class="control-label col-sm-2" for="task_pengirim">Penugasan:</label>
								<div class="col-sm-10">
									<input class="form-control date" type="text" name="task_date" id="task_date" value="<?=$task_date;?>"/>	
								</div>
							  </div>	
							 
							 <input class="form-control" type="hidden" name="task_id" id="task_id" value="<?=$task_id;?>"/>					  					  
							  <div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" id="submit" class="btn btn-primary col-md-5" <?=$namabutton;?> value="OK">Submit</button>
									<button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?=site_url("task");?>">Back</button>
								</div>
							  </div>
							</form>
						</div>
						<?php }else{?>	
							<?php if($message!=""){?>
							<div class="alert alert-info alert-dismissable">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong><?=$message;?></strong><br/><?=$uploadtask_picture;?>
							</div>
							<?php }?>
							<div class="box">
								<div id="collapse4" class="body table-restasknsive">				
								<table id="dataTable" class="table table-condensed table-hover">
									<thead>
										<tr>
											<th>No.</th>
											<th>Date</th>
											<th>Inv No. </th>
											<th>Task No. </th>
											<th>Customer</th>
											<th>Teknisi</th>
											<th>Status</th>
											<th class="col-md-1">Detail</th>
										</tr>
									</thead>
									<tbody> 
										<?php $usr=$this->db
										->join("user","user.user_id=task.user_id","left")
										->join("customer","customer.customer_id=task.customer_id","left")
										->order_by("task_id","desc")
										->get("task");
										$no=1;
										foreach($usr->result() as $task){
										$warna="background-color:#BAFFC9;"; $status="Done";
										$stat=$this->db
										->where("task_no", $task->task_no)
										->get("taskproduct");
										if($stat->num_rows()>0){
											foreach($stat->result() as $statu){
											if($statu->taskproduct_qty=="0"){
												$warna="background-color:#FFB3BA;"; $status="";
											}
											}
										}else{
											$warna="background-color:#FFB3BA;"; $status="";
										}
										?>
										<tr style="<?=$warna;?>">
											<td><?=$no++;?></td>											
											<td><?=$task->task_date;?></td>
											<td><?=$task->inv_no;?></td>
											<td><?=$task->task_no;?></td>
											<td><?=$task->customer_name;?></td>
											<td><?=$task->user_name;?></td>
											<td><?=$status;?></td>
											<td style="text-align:center; ">  	
												<form method="POST" class="" style="padding:0px; margin:2px; ">
                                                <?php if(isset($_GET["report"])){$report="&report=ok";}else{$report="";}?>
												  <a data-toggle="tooltip" title="List Task" target="_blank" href="<?=site_url("tasktproduct?task_no=".$task->task_no)."&customer_id=".$task->customer_id.$report;?>" class="btn btn-sm btn-info " name="edit" value="OK">
												  <span class="fa fa-tags" style="color:white;"></span>											  </a>
												</form>											</td>
										</tr>
										<?php }?>
									</tbody>
								</table>
								</div>
							</div>
						<?php }?>
					</div>
				</div>
			</div>
		</div>
	
	<!-- /#wrap -->
	<?php require_once("footer.php");?>
</body>

</html>
