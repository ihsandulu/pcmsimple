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
				<li class="active">WO/SPK</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-8">
				<h1 class="page-header"> WO/SPK</h1>
			</div>
			<?php if(!isset($_POST['new'])&&!isset($_POST['edit'])&&!isset($_GET['report'])){?>
			<form method="post" class="col-md-4">							
				<h1 class="page-header col-md-12"> 						
				<button name="new" class="btn btn-info btn-lg" value="OK" style=" float:right;margin:2px;">New</button>
				<input type="hidden" name="wo_id" value="0"/>
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
							<?php if(isset($_POST['edit'])){$namabutton='name="change"';$judul="Update WO/SPK";}else{$namabutton='name="create"';$judul="New WO/SPK";}?>	
							<div class="lead"><h3><?=$judul;?></h3></div>
							<form class="form-horizontal" method="post" enctype="multipart/form-data">
							  <div class="form-group">
								<label class="control-label col-sm-2" for="wo_no">WO/SPK No.:</label>
								<div class="col-sm-10">
									<input class="form-control" value="<?=$wo_no;?>" id="wo_no" name="wo_no">	
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="wo_date">Date:</label>
								<div class="col-sm-10">
									<input class="form-control date" value="<?=$wo_date;?>" id="wo_date" name="wo_date">	
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="wo_remarks">Remarks:</label>
								<div class="col-sm-10">
									<input class="form-control" value="<?=$wo_remarks;?>" id="wo_remarks" name="wo_remarks">	
								</div>
							  </div>
							  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="wo_picture">Picture:</label>
								<div class="col-sm-10" align="left"> 
								  <input type="file" class="" id="wo_picture" name="wo_picture"><br/>
								<?php if($wo_picture!=""){$user_image="assets/images/wo_picture/".$wo_picture;}else{$user_image="assets/img/user.gif";}?>
								  <img id="wo_picture_image" width="100" height="100" src="<?=base_url($user_image);?>"/>
								  <script>
								  	function readURL(input) {
										if (input.files && input.files[0]) {
											var reader = new FileReader();
								
											reader.onload = function (e) {
												$('#wo_picture_image').attr('src', e.target.result);
											}
								
											reader.readAsDataURL(input.files[0]);
										}
									}
								
									$("#wo_picture").change(function () {
										readURL(this);
									});
								  </script>
								</div>
							  </div>
							 
							  <input type="hidden" name="wo_id" value="<?=$wo_id;?>"/>					  					  
							  <div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" id="submit" class="btn btn-primary col-md-5" <?=$namabutton;?> value="OK">Submit</button>
									<button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?=site_url("wo");?>">Back</button>
								</div>
							  </div>
							</form>
						</div>
						<?php }else{?>	
							<?php if($message!=""){?>
							<div class="alert alert-info alert-dismissable">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong><?=$message;?></strong><br/><?=$uploadwo_picture;?>
							</div>
							<?php }?>
							<div class="box">
								<div id="collapse4" class="body table-responsive">				
								<table id="dataTable" class="table table-condensed table-hover">
									<thead>
										<tr>
											<th>No.</th>
										  <th>Date</th>
										  <th>WO/SPK No. </th>
										  <th>Remarks</th>
											<th>Picture</th>											
											<?php if(!isset($_GET['report'])){?>
											<th class="col-md-1">Action</th>
											<?php }?>
										</tr>
									</thead>
									<tbody> 
										<?php $usr=$this->db
										->order_by("wo_id","desc")
										->get("wo");
										//echo $this->db->last_query();
										$no=1;
										foreach($usr->result() as $wo){
										
										?>
										<tr style="">
											<td><?=$no++;?></td>
										  <td><?=$wo->wo_date;?></td>
										  <td><?=$wo->wo_no;?></td>
										  <td><?=$wo->wo_remarks;?></td>
											
											<td><?php if($wo->wo_picture==""){$wo_picture="noimage.png";}else{$wo_picture=$wo->wo_picture;}?>
                                                <img src="<?=base_url("assets/images/wo_picture/".$wo_picture);?>" alt="a" style="width:25px; height:25px; cursor:pointer; border:grey solid 1px;" onClick="tampilimg(this)"/>
                                                <?php if($wo->wo_picture!=""){?>
											  &nbsp;<a class="btn btn-sm btn-warning fa fa-download" href="<?=base_url("assets/images/wo_picture/".$wo->wo_picture);?>" target="_blank"></a>
											  <?php }?>											
											  </td>
											<?php if(!isset($_GET['report'])){?>
												<td style="padding-left:0px; padding-right:0px;">
											
												<form method="post" class="col-md-6" style="padding:0px;">
													<button class="btn btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
													<input type="hidden" name="wo_id" value="<?=$wo->wo_id;?>"/>
												</form>			
											
												<form method="post" class="col-md-6" style="padding:0px;">
													<button class="btn btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
													<input type="hidden" name="wo_id" value="<?=$wo->wo_id;?>"/>
												</form>												</td>					
											<?php }?>
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
	</div>
	<!-- /#wrap -->
	<?php require_once("footer.php");?>
</body>

</html>
