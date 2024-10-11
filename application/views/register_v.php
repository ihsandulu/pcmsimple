<!doctype html>
<html>

<head>
    <?php 
	require_once("meta.php");?>
</head>

<body class="  " >
	
	<div class="col-sm-12  col-lg-12 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="<?=site_url("login");?>"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">Register</li>
			</ol>
		</div><!--/.row-->
		
		
		
		
		<div class="container">
			<div class="col-xs-12 col-md-12 col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<?php if($message!=""){?>
							<div class="alert alert-info alert-dismissable">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong><?=$message;?></strong><br/><?=$uploadcustomer_picture;?>
							</div>
							<?php }?>
						<div class="">
							<?php if(isset($_POST['edit'])){$namabutton='name="change"';$judul="Update Member";}else{$namabutton='name="create"';$judul="New Member";}?>	
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
							  	if($("#user_email").val()!="<?=$this->session->userdata("user_email");?>")
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
							  
							  <hr/>
							  
							   <div class="form-group">
								<label class="control-label col-sm-2" for="customer_country">Country:</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control" id="customer_country" name="customer_country" placeholder="Enter Country" value="">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="customer_address">Customer Address:</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control" id="customer_address" name="customer_address" placeholder="Enter Address" value="">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="customer_phone">Phone:</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control" id="customer_phone" name="customer_phone" placeholder="Enter Phone" value="">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="customer_fax">Fax:</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control" id="customer_fax" name="customer_fax" placeholder="Enter Fax" value="">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="customer_cp">Contact Person:</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control" id="customer_cp" name="customer_cp" placeholder="Enter CP" value="">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="customer_ktp">Identity Number (KTP):</label>
								<div class="col-sm-10">
								  <input required type="text" autofocus class="form-control" id="customer_ktp" name="customer_ktp" placeholder="Enter Identity Number (KTP)" value="">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="customer_npwp">NPWP:</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control" id="customer_npwp" name="customer_npwp" placeholder="Enter NPWP" value="">
								</div>
							  </div>
							  									  
							
							 
							  <input type="hidden" name="user_id" value="<?=$user_id;?>"/>					  					  
							  <div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" id="submit" class="btn btn-primary col-md-5" <?=$namabutton;?> value="OK">Submit</button>
									<button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?=site_url("login");?>">Back</button>
								</div>
							  </div>
							</form>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /#wrap -->
	<?php require_once("footer.php");?>
</body>

</html>
