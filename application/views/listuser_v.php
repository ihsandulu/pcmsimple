<!doctype html>
<html>

<head>
    <?php 
	session_start();
	require_once("meta.php");?>
</head>

<body class="  " >
	<?php require_once("header.php");?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">User</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-10">
				<h1 class="page-header"> User</h1>
			</div>
			
		</div><!--/.row-->
		
		
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
					<?php if(isset($_POST['new'])||isset($_POST['edit'])){?>
						<div class="">
							<?php if(isset($_POST['edit'])){$namabutton='name="change"';$judul="Update User";}else{$namabutton='name="create"';$judul="New User";}?>	
							<div class="lead"><h3><?=$judul;?></h3></div>
							<form class="form-horizontal" method="post" enctype="multipart/form-data">
							  <div class="form-group">
								<label class="control-label col-sm-2" for="user_name">Name:</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control" id="user_name" name="user_name" placeholder="Enter Name" value="<?=$user_name;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="user_email">Email:</label>
								<div class="col-sm-10">
								  <input type="user_email" class="form-control" id="user_email" name="user_email" placeholder="Enter email" value="<?=$user_email;?>">
								</div>							  
							</div>
							<div class="col-md-offset-2 col-md-10 alert alert-danger alert-dismissable fade in" id="cekemail" style="display:none;">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								<strong>Perhatian!</strong> Email telah digunakan.
							</div>

							  <script>
							  $("#user_email").keyup(function(){
								  $.get("<?=site_url("cekuser");?>",{id:$("#user_email").val()})
								  .done(function(data){
								  	if(data>0){
								  		$("#cekemail").fadeIn();$("#submit").prop("disabled","disabled");
									}else{
										$("#cekemail").fadeOut();$("#submit").prop("disabled","");
									}
								  });
							  });
							  </script>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="user_password">Password:</label>
								<div class="col-sm-10"> 
								  <input type="password" class="form-control" id="user_password" name="user_password" placeholder="Enter password" value="<?=$user_password;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="position_id">Position:</label>
								<div class="col-sm-10"> 
								 <select class="form-control" id="position_id" name="position_id">
								 <option></option>
								 	<?php $positio=$this->db->get("position");
									foreach($positio->result() as $position){?>
									<option value="<?=$position->position_id;?>" <?=$position_id==$position->position_id?"selected":"";?>><?=$position->position_name;?></option>
									<?php }?>
								  </select>
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="department_id">Department:</label>
								<div class="col-sm-10"> 
								 <select class="form-control" id="department_id" name="department_id" onChange="getregion();">
								 <option></option>
								 	<?php $bran=$this->db->get("department");
									foreach($bran->result() as $department){?>
									<option value="<?=$department->department_id;?>" <?=$department_id==$department->department_id?"selected":"";?>><?=$department->department_name;?></option>
									<?php }?>
								  </select>
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="region_id">Region:</label>
								<div class="col-sm-10"> 
								 <select class="form-control" id="region_id" name="region_id" onChange="getstation()">
								 <option></option>
								 	<?php $divisio=$this->db->get("region");
									foreach($divisio->result() as $region){?>
									<option value="<?=$region->region_id;?>" <?=$region_id==$region->region_id?"selected":"";?>><?=$region->region_name;?></option>
									<?php }?>
								  </select>
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="station_id">Station:</label>
								<div class="col-sm-10"> 
								 <select class="form-control" id="station_id" name="station_id">
								 <option></option>
								 	<?php $statio=$this->db->get("station");
									foreach($statio->result() as $station){?>
									<option value="<?=$station->station_id;?>" <?=$station_id==$station->station_id?"selected":"";?>><?=$station->station_name;?></option>
									<?php }?>
								  </select>								 
								</div>
							  </div>	
							  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="user_picture">Picture:</label>
								<div class="col-sm-10" align="left"> 
								  <input type="file" class="form-control" id="user_picture" name="user_picture"><br/>
								<?php if($user_picture!=""){$user_image="assets/images/user_picture/".$user_picture;}else{$user_image="assets/img/user.gif";}?>
								  <img id="user_picture_image" width="100" height="100" src="<?=base_url($user_image);?>"/>
								  <script>
								  	function readURL(input) {
										if (input.files && input.files[0]) {
											var reader = new FileReader();
								
											reader.onload = function (e) {
												$('#user_picture_image').attr('src', e.target.result);
											}
								
											reader.readAsDataURL(input.files[0]);
										}
									}
								
									$("#user_picture").change(function () {
										readURL(this);
									});
								  </script>
								</div>
							  </div>
							  <script>
								  function getregion(){
								  	$.get("<?=site_url("regionshow");?>",{department_id:$("#department_id").val()}).done(function(data){
											$("#region_id").html(data);
											getstation();
										});
									}
								  function getstation(){
								  	$.get("<?=site_url("stationshow");?>",{region_id:$("#region_id").val()}).done(function(data){
											$("#station_id").html(data);
										});
									}
								  $(document).ready(function(){
								  <?php if($region_id==0){echo "getregion();";}?>
								  <?php if($station_id==0){echo "getstation();";}?>
								  });
								  </script>									  
							  <input type="hidden" name="user_id" value="<?=$user_id;?>"/>					  					  
							  <div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" id="submit" class="btn btn-primary col-md-5" <?=$namabutton;?> value="OK">Submit</button>
									<button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?=site_url("user");?>">Back</button>
								</div>
							  </div>
							</form>
						</div>
						<?php }else{?>	
							<?php if($message!=""){?>
							<div class="alert alert-info alert-dismissable">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong><?=$message;?></strong><br/><?=$uploaduser_picture;?>
							</div>
							<?php }?>
							<div class="box">
								<div id="collapse4" class="body table-responsive">				
								<table id="dataTable" class="table table-condensed table-hover">
									<thead>
										<tr>
											<th>No.</th>
											<th>Name</th>
											<th>Email</th>
											<th>Position</th>
										</tr>
									</thead>
									<tbody> 
										<?php $usr=$this->db
										->join("position","position.position_id=user.position_id","left")
										->order_by("user_id","desc")
										->get("user");
										$no=1;
										foreach($usr->result() as $user){?>
										<tr>
											<td><?=$no++;?></td>
											<td><?=$user->user_name;?></td>
											<td><?=$user->user_email;?></td>
											<td><?=$user->position_name;?></td>
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
