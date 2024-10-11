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
				<li class="active">parameter</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-10">
				<h1 class="page-parameter"> Parameter</h1>
			</div>
			<?php if(!isset($_POST['new'])&&!isset($_POST['edit'])){?>
			<form method="post" class="col-md-2">							
				<h1 class="page-parameter col-md-12"> 
				<button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
				<input type="hidden" name="parameter_id"/>
				</h1>
			</form>
			<?php }?>
		</div><!--/.row-->
		
		
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
					<?php if(isset($_POST['new'])||isset($_POST['edit'])){?>
						<div class="">
							<?php if(isset($_POST['edit'])){$namabutton='name="change"';$judul="Update parameter";}else{$namabutton='name="create"';$judul="New parameter";}?>	
							<div class="lead"><h3><?=$judul;?></h3></div>
							<form class="form-horizontal" method="post" encparameter="multipart/form-data">
							<div class="form-group">
								<label class="control-label col-sm-2" for="equip_id">Equipment:</label>
								<div class="col-sm-10"> 
								 <select class="form-control" id="equip_id" name="equip_id">
								 <option></option>
								 	<?php $typ=$this->db->get("equipment");
									foreach($typ->result() as $equip){?>
									<option value="<?=$equip->equip_id;?>" <?=$equip_id==$equip->equip_id?"selected":"";?>><?=$equip->equip_name;?></option>
									<?php }?>
								  </select>
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="parameter_name">Name:</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control" id="parameter_name" name="parameter_name" placeholder="Enter parameter" value="<?=$parameter_name;?>">
								</div>
							  </div>
							  <div class="col-md-offset-2 col-md-10 alert alert-danger alert-dismissable fade in" id="cekemail" style="display:none;">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								<strong>Perhatian!</strong> Email telah digunakan.
							</div>

							  <script>
							  $("#parameter_email").keyup(function(){
								  $.get("<?=site_url("cekparameter");?>",{id:$("#parameter_email").val()})
								  .done(function(data){
								  	if(data>0){
								  		$("#cekemail").fadeIn();$("#submit").prop("disabled","disabled");
									}else{
										$("#cekemail").fadeOut();$("#submit").prop("disabled","");
									}
								  });
							  });
							  </script>
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
							  <input type="hidden" name="parameter_id" value="<?=$parameter_id;?>"/>					  					  
							  <div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
									<button parameter="submit" id="submit" class="btn btn-primary col-md-5" <?=$namabutton;?> value="OK">Submit</button>
									<button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?=site_url("parameter");?>">Back</button>
								</div>
							  </div>
							</form>
						</div>
						<?php }else{?>	
							<?php if($message!=""){?>
							<div class="alert alert-info alert-dismissable">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong><?=$message;?></strong><br/><?=$uploadparameter_picture;?>
							</div>
							<?php }?>
							<div class="box">
								<div id="collapse4" class="body table-responsive">				
								<table id="dataTable" class="table table-condensed table-hover">
									<thead>
										<tr>
											<th class="col-md-1">Delete</th>
											<th class="col-md-1">Update</th>
											<th>Equipment</th>
											<th>Parameter</th>
										</tr>
									</thead>
									<tbody> 
										<?php $usr=$this->db
										->get("equipment");
										foreach($usr->result() as $parameter){?>
										<tr>
											<td>
												<form method="post">
													<button class="btn btn-default delete" name="delete" value="OK"><span class="fa fa-window-close"></span> Delete</button>
													<input type="hidden" name="parameter_id" value="<?=$parameter->parameter_id;?>"/>
												</form>
											</td>
											<td>
												<form method="post">
													<button class="btn btn-default" name="edit" value="OK"><span class="fa fa-edit"></span> Update</button>
													<input type="hidden" name="parameter_id" value="<?=$parameter->parameter_id;?>"/>
												</form>
											</td>
											<td><?=$parameter->equip_name;?></td>
											<td>
											<?php $param=$this->db
											->where("equip_id",$parameter->equip_id)
											->get("equipment");
											foreach($param->result() as $par){?>
											<?=$par->parameter_name;?></td>
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
