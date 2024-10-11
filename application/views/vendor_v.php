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
				<li class="active">Vendor</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-10">
				<h1 class="page-header"> Vendor</h1>
			</div>
			<?php if(!isset($_POST['new'])&&!isset($_POST['edit'])){?>
			<form method="post" class="col-md-2">							
				<h1 class="page-header col-md-12"> 
				<button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
				<input type="hidden" name="vendor_id"/>
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
							<?php if(isset($_POST['edit'])){$namabutton='name="change"';$judul="Update vendor";}else{$namabutton='name="create"';$judul="New vendor";}?>	
							<div class="lead"><h3><?=$judul;?></h3></div>
							<form class="form-horizontal" method="post" enctype="multipart/form-data">
								
							   <div class="form-group">
								<label class="control-label col-sm-2" for="vendor_name">Vendor Name:</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control" id="vendor_name" name="vendor_name" placeholder="Enter Name" value="<?=$vendor_name;?>">
								</div>
							  </div>
							  
							   <div class="form-group">
								<label class="control-label col-sm-2" for="vendor_services">Services:</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control" id="vendor_services" name="vendor_services" placeholder="Enter Services" value="<?=$vendor_services;?>">
								</div>
							  </div>
							  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="vendor_email">Vendor Email:</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control" id="vendor_email" name="vendor_email" placeholder="Enter Email" value="<?=$vendor_email;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="vendor_country">Country:</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control" id="vendor_country" name="vendor_country" placeholder="Enter Country" value="<?=$vendor_country;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="vendor_address">Vendor Address:</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control" id="vendor_address" name="vendor_address" placeholder="Enter Address" value="<?=$vendor_address;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="vendor_phone">Phone:</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control" id="vendor_phone" name="vendor_phone" placeholder="Enter Phone" value="<?=$vendor_phone;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="vendor_fax">Fax:</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control" id="vendor_fax" name="vendor_fax" placeholder="Enter Fax" value="<?=$vendor_fax;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="vendor_cp">Contact Person:</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control" id="vendor_cp" name="vendor_cp" placeholder="Enter CP" value="<?=$vendor_cp;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="vendor_ktp">Identity Number (KTP):</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control" id="vendor_ktp" name="vendor_ktp" placeholder="Enter Identity Number (KTP)" value="<?=$vendor_ktp;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="vendor_npwp">NPWP:</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control" id="vendor_npwp" name="vendor_npwp" placeholder="Enter NPWP" value="<?=$vendor_npwp;?>">
								</div>
							  </div>
							  
							  <div class="form-group">
                                        <label class="control-label col-sm-2" for="vendor_picture">Logo:</label>
                                        <div class="col-sm-10" align="left"> 
                                          <input type="file"  id="vendor_picture" name="vendor_picture"><br/>
                                        <?php if($vendor_picture!=""){$user_image="assets/images/vendor_picture/".$vendor_picture;}else{$user_image="assets/images/vendor_picture/image.gif";}?>
                                          <img id="vendor_picture_image" width="100" height="100" src="<?=base_url($user_image);?>"/>
                                          <script>
                                            function readURL(input) {
                                                if (input.files && input.files[0]) {
                                                    var reader = new FileReader();
                                        
                                                    reader.onload = function (e) {
                                                        $('#vendor_picture_image').attr('src', e.target.result);
                                                    }
                                        
                                                    reader.readAsDataURL(input.files[0]);
                                                }
                                            }
                                        
                                            $("#vendor_picture").change(function () {
                                                readURL(this);
                                            });
                                          </script>
                                        </div>
                                      </div>
							  
							  <input type="hidden" name="vendor_id" value="<?=$vendor_id;?>"/>					  					  
							  <div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" id="submit" class="btn btn-primary col-md-5" <?=$namabutton;?> value="OK">Submit</button>
									<button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?=site_url("vendor");?>">Back</button>
								</div>
							  </div>
							</form>
						</div>
						<?php }else{?>	
							<?php if($message!=""){?>
							<div class="alert alert-info alert-dismissable">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong><?=$message;?></strong><br/><?=$uploadvendor_picture;?>
							</div>
							<?php }?>
							<div class="box">
								<div id="collapse4" class="body table-responsive">				
								<table id="dataTable" class="table table-condensed table-hover">
									<thead>
										<tr>
											<th>No.</th>
											<th>Vendor</th>
											<th>Email</th>
											<th>Address</th>
											<th>Phone</th>
											<th>CP</th>
											<th class="col-md-2">Action</th>
										</tr>
									</thead>
									<tbody> 
										<?php $usr=$this->db
										->order_by("vendor_id","desc")
										->get("vendor");
										$no=1;
										foreach($usr->result() as $vendor){?>
										<tr>			
											<td><?=$no++;?></td>								
											<td><?=$vendor->vendor_name;?></td>
											<td><?=$vendor->vendor_email;?></td>
											<td><?=$vendor->vendor_address;?></td>
											<td><?=$vendor->vendor_phone;?></td>
											<td><?=$vendor->vendor_cp;?></td>
											<td style="padding-left:0px; padding-right:0px;">
												<?php if($identity->identity_productcustomer==2){?>
												<form target="_blank" action="vendorproduct" method="get" class="col-md-4" style="padding:0px; float:left;">
													<button class="btn  btn-primary " data-toggle="tooltip" title="Product vendor" name="vendor_id" value="<?=$vendor->vendor_id;?>"><span class="fa fa-shopping-bag" style="color:white;"></span> </button>
													<input type="hidden" name="vendor_name" value="<?=$vendor->vendor_name;?>"/>
												</form>
												<?php }?>
												<form method="post" class="col-md-4" style="padding:0px;float:left;">
													<button class="btn  btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
													<input type="hidden" name="vendor_id" value="<?=$vendor->vendor_id;?>"/>
												</form>
											
												<form method="post" class="col-md-4" style="padding:0px;float:left;">
													<button class="btn  btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
													<input type="hidden" name="vendor_id" value="<?=$vendor->vendor_id;?>"/>
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
	</div>
<!-- /#wrap -->
	<?php require_once("footer.php");?>
</body>

</html>
