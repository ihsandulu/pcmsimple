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
				<li class="active">Follow Up</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-8">
				<h2 class="page-header"> Follow Up for Quotation No. <?=$this->input->get("quotation_no");?></h2>
			</div>
			<?php if(!isset($_POST['new'])&&!isset($_POST['edit'])){?>
			<form method="post" class="col-md-4">							
				<h1 class="page-header col-md-12"> 				
				<button name="new" class="btn btn-info btn-lg" value="OK" style=" float:right;margin:2px;">New</button>
				<a type="button" href="<?=site_url("quotation");?>" class="btn btn-warning btn-lg" style=" float:right; margin:2px; border-radius:0px;"> Back</a>
				<input type="hidden" name="followup_id" value="0"/>
				</h1>
			</form>
			<?php }?>
		</div><!--/.row-->
		
		
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
					<div class="well">
					<form target="_blank" method="get" class="form-inline" action="https://wa.me/<?=$this->input->get("customer_wa");?>">
					<div class="form-group">
						<label>Whatsapp : </label>
						<input style="background-color:#00DF38; color:#FFFFFF; border-radius:5px; padding:15px; font-weight:bold; float:left; margin-right:10px;" id="text" name="text" type="text" class="form-control" value=""/>
					</div>
					<button type="submit" class="btn btn-success fa fa-whatsapp"></button>
					</form>
					</div>
					<?php if(isset($_POST['new'])||isset($_POST['edit'])){?>
						<div class="">
							<?php if(isset($_POST['edit'])){$namabutton='name="change"';$judul="Update Follow Up";}else{$namabutton='name="create"';$judul="New Follow Up";}?>	
							<div class="lead"><h3><?=$judul;?></h3></div>
							<form class="form-horizontal" method="post" enctype="multipart/form-data">
							  <div class="form-group">
								<label class="control-label col-sm-2" for="followup_status">Status:</label>
								<div class="col-sm-10">
								  <select class="form-control" id="followup_status" name="followup_status">
								  	<option value="Cool" <?=($followup_status=="Cool")?"selected":"";?>>Cool</option>
								  	<option value="Warm" <?=($followup_status=="Cool")?"selected":"";?>>Warm</option>
								  	<option value="Hot" <?=($followup_status=="Cool")?"selected":"";?>>Hot</option>
								  </select>
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="followup_picture">Picture:</label>
								<div class="col-sm-10" align="left"> 
								  <input type="file"  id="followup_picture" name="followup_picture"><br/>
								<?php if($followup_picture!=""){$user_image="assets/images/followup_picture/".$followup_picture;}else{$user_image="assets/images/followup_picture/image.gif";}?>
								  <img id="followup_picture_image" width="100" height="100" src="<?=base_url($user_image);?>"/>
								  <script>
									function readURL(input) {
										if (input.files && input.files[0]) {
											var reader = new FileReader();
								
											reader.onload = function (e) {
												$('#followup_picture_image').attr('src', e.target.result);
											}
								
											reader.readAsDataURL(input.files[0]);
										}
									}
								
									$("#followup_picture").change(function () {
										readURL(this);
									});
								  </script>
								</div>
							  </div>
							  <input type="hidden" name="followup_id" value="<?=$followup_id;?>"/>	
							  <input type="hidden" name="customer_id" value="<?=($customer_id==0)?$this->input->get("customer_id"):$customer_id;?>"/>	
							  <input type="hidden" name="user_id" value="<?=($user_id==0)?$this->session->userdata("user_id"):$user_id;?>"/>	
							  <input type="hidden" name="quotation_no" value="<?=$this->input->get("quotation_no");?>"/>					  					  
							  <div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" id="submit" class="btn btn-primary col-md-5" <?=$namabutton;?> value="OK">Submit</button>
									<button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?=site_url("followup");?>">Back</button>
								</div>
							  </div>
							</form>
						</div>
						<?php }else{?>	
							<?php if($message!=""){?>
							<div class="alert alert-info alert-dismissable">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong><?=$message;?></strong><br/><?=$uploadfollowup_picture;?>
							</div>
							<?php }?>
							<div class="box">
								<div id="collapse4" class="body table-responsive">				
								<table id="dataTable" class="table table-condensed table-hover">
									<thead>
										<tr>
											<th>No.</th>
											<th>Date</th>
											<th>Quotation</th>
											<th>Customer</th>
											<th>Sales</th>
											<th>Status</th>
											<th>Picture</th>
											<th class="col-md-1">Action</th>
										</tr>
									</thead>
									<tbody> 
										<?php $usr=$this->db
										->join("customer","customer.customer_id=followup.customer_id","left")
										->join("user","user.user_id=followup.user_id","left")
										->where("quotation_no",$this->input->get("quotation_no"))
										->order_by("followup_id","desc")
										->get("followup");
										$no=1;
										foreach($usr->result() as $followup){?>
										<tr>		
											<td><?=$no++;?></td>									
											<td><?=$followup->followup_date;?></td>					
											<td><?=$followup->quotation_no;?></td>			
											<td><?=$followup->customer_name;?></td>
											<td><?=$followup->user_name;?></td>
											<td><?=$followup->followup_status;?></td>
											<td>
											<?php if($followup->followup_picture!=""){$gambar=$followup->followup_picture;}else{$gambar="noimage.png";}?>
											<img onClick="tampil(this)" src="<?=base_url("assets/images/followup_picture/".$gambar);?>" style="width:20px; height:20px;">
											<script>
											function tampil(a){
												var gambar=$(a).attr("src");
												$("#imgumum").attr("src",gambar);
												$("#myImage").modal("show");
											}
											</script>
											</td>
											<td style="padding-left:0px; padding-right:0px;">
												<form method="post" class="col-md-6" style="padding:0px;">
													<button class="btn btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
													<input type="hidden" name="followup_id" value="<?=$followup->followup_id;?>"/>
												</form>
											
												<form method="post" class="col-md-6" style="padding:0px;">
													<button class="btn btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
													<input type="hidden" name="followup_id" value="<?=$followup->followup_id;?>"/>
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
