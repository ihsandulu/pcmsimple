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
				<li class="active">Header</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-10">
				<h1 class="page-header"> Header</h1>
			</div>
			<?php if(!isset($_POST['new'])&&!isset($_POST['edit'])){?>
			<form method="post" class="col-md-2">							
				<h1 class="page-header col-md-12"> 
				<button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
				<input type="hidden" name="header_id"/>
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
							<?php if(isset($_POST['edit'])){$namabutton='name="change"';$judul="Update Header";}else{$namabutton='name="create"';$judul="New Header";}?>	
							<div class="lead"><h3><?=$judul;?></h3></div>
							<form class="form-horizontal" method="post" encheader="multipart/form-data">
							<div class="form-group">
								<label class="control-label col-sm-2" for="type_id">Type:</label>
								<div class="col-sm-10"> 
								 <select class="form-control" id="type_id" name="type_id">
								 <option></option>
								 	<?php $typ=$this->db->get("type");
									foreach($typ->result() as $type){?>
									<option value="<?=$type->type_id;?>" <?=$type_id==$type->type_id?"selected":"";?>><?=$type->type_name;?></option>
									<?php }?>
								  </select>
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="header_name">Name:</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control" id="header_name" name="header_name" placeholder="Enter header" value="<?=$header_name;?>">
								</div>
							  </div>
							  <div class="col-md-offset-2 col-md-10 alert alert-danger alert-dismissable fade in" id="cekemail" style="display:none;">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								<strong>Perhatian!</strong> Email telah digunakan.
							</div>

							  <script>
							  $("#header_email").keyup(function(){
								  $.get("<?=site_url("cekheader");?>",{id:$("#header_email").val()})
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
							  <input type="hidden" name="header_id" value="<?=$header_id;?>"/>					  					  
							  <div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
									<button header="submit" id="submit" class="btn btn-primary col-md-5" <?=$namabutton;?> value="OK">Submit</button>
									<button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?=site_url("header");?>">Back</button>
								</div>
							  </div>
							</form>
						</div>
						<?php }else{?>	
							<?php if($message!=""){?>
							<div class="alert alert-info alert-dismissable">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong><?=$message;?></strong><br/><?=$uploadheader_picture;?>
							</div>
							<?php }?>
							<div class="col-md-6" style="padding:0px; margin-top:20px;">
							<?php $lis=$this->db->get("type");
							$n=0;
							foreach($lis->result() as $list){
							if($n==0){
							?>
							<div class="col-md-12"  style="margin:0px;">
							
								<div id="collapse4" class="body table-responsive border-grey">	
								<h3><?=$list->type_name;?></h3>			
								<table id="" class="table table-condensed table-hover">
									<thead>
										<tr>
											<!--<th>Type</th>-->
											<th>Name</th>
											<th class="col-md-2">Action</th>
										</tr>
									</thead>
									<tbody> 
										<?php $usr=$this->db
										->join("type","type.type_id=header.type_id","left")
										->where("header.type_id",$list->type_id)
										->get("header");
										foreach($usr->result() as $header){?>
										<tr>
											<!--<td><?=$header->type_name;?></td>-->
											<td><?=$header->header_name;?></td>
											<td style="padding-left:0px; padding-right:0px;">
											
												<form method="post" class="col-md-6" style="padding:0px;">
													<button class="btn btn-warning" name="edit" value="OK"><span class="fa fa-edit"></span> </button>
													<input type="hidden" name="header_id" value="<?=$header->header_id;?>"/>
												</form>
												
												<form method="post" class="col-md-6" style="padding:0px;">
													<button class="btn btn-danger delete" name="delete" value="OK"><span class="fa fa-window-close" style=" color:white;"></span> </button>
													<input type="hidden" name="header_id" value="<?=$header->header_id;?>"/>
												</form>
												
											</td>
										</tr>
										<?php }?>
									</tbody>
								</table>
								</div>
							</div>
							<?php 
							}
							$n++;
							if($n==2){$n=0;}
							}?>
							</div>
							<div class="col-md-6" style="padding:0px; margin-top:20px;">
							<?php $lis=$this->db->get("type");
							$n=0;
							foreach($lis->result() as $list){
							if($n==1){
							?>
							<div class="col-md-12" style="margin:0px;">
							
								<div id="collapse4" class="body table-responsive border-grey">	
								<h3><?=$list->type_name;?></h3>			
								<table id="" class="table table-condensed table-hover">
									<thead>
										<tr>
											<!--<th>Type</th>-->
											<th>Name</th>
											<th class="col-md-2">Action</th>
										</tr>
									</thead>
									<tbody> 
										<?php $usr=$this->db
										->join("type","type.type_id=header.type_id","left")
										->where("header.type_id",$list->type_id)
										->get("header");
										foreach($usr->result() as $header){?>
										<tr>
											<!--<td><?=$header->type_name;?></td>-->
											<td><?=$header->header_name;?></td>
											<td style="padding-left:0px; padding-right:0px;">											
												<form method="post" class="col-md-6" style="padding:0px;">
													<button class="btn btn-warning" name="edit" value="OK"><span class="fa fa-edit"></span> </button>
													<input type="hidden" name="header_id" value="<?=$header->header_id;?>"/>
												</form>												
												<form method="post" class="col-md-6" style="padding:0px;">
													<button class="btn btn-danger delete" name="delete" value="OK"><span class="fa fa-window-close" style=" color:white;"></span> </button>
													<input type="hidden" name="header_id" value="<?=$header->header_id;?>"/>
												</form>												
											</td>
										</tr>
										<?php }?>
									</tbody>
								</table>
								</div>
							</div>
							<?php 
							}
							$n++;
							if($n==2){$n=0;}
							}?>
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
