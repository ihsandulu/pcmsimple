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
				<li class="active">Group Members</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<?php if(isset($_GET['daurulang'])&&!isset($_POST['new'])&&!isset($_POST['edit'])){$coltitle="col-md-8";}else{$coltitle="col-md-8";}?>
			<div class="<?=$coltitle;?>">
				<h1 class="page-header"> Group Members</h1>
			</div>
			<?php if(isset($_GET['daurulang'])){?>
			<form method="post" class="col-md-2">							
				<h1 class="page-header col-md-12"> 
				<button onClick="tutup()" class="btn btn-danger btn-block btn-lg" value="OK" style="">Close</button>
				<script>
				function tutup(){
					window.opener.location.reload();
					window.close();
				}
				</script>
				</h1>
			</form>
			<?php }?>
			<?php if(!isset($_POST['new'])&&!isset($_POST['edit'])){?>
			<form method="post" class="col-md-2">							
				<h1 class="page-header col-md-12"> 
				<button type="button" onClick="window.close()" class="btn btn-warning btn-block btn-lg" style=""> Back</button>
				</h1>
			</form>
			<form method="post" class="col-md-2">							
				<h1 class="page-header col-md-12"> 
				<button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
				<input type="hidden" name="grupd_id"/>
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
							<?php if(isset($_POST['edit'])){$namabutton='name="change"';$judul="Update Member";}else{$namabutton='name="create"';$judul="Add Member";}?>	
							<div class="lead"><h3><?=$judul;?></h3></div>
							<form class="form-horizontal" method="post" enctype="multipart/form-data">
								
								<div class="form-group">
								<label class="control-label col-sm-2" for="unit_id">Customer:</label>
								<div class="col-sm-10">
									<?php if(isset($_POST['new'])){?>
									<input required type="radio" name="pilihcustomer" onClick="pilih('satu')" value="satu"> Single Customer
									<input required type="radio" name="pilihcustomer" onClick="pilih('banyak')" value="banyak"> Multiple Customer (Press CTRL + Left Click)
									<script>
									function pilih(a){
										$.get("<?=site_url("api/pilihcustomer");?>",{pilih:a})
										.done(function(data){
											$("#pilihcustomer").html(data);
										});
									}
									</script>
									<?php }?>
									
									<?php if(isset($_POST['edit'])){?>
									<datalist id="customer">
										<?php $uni=$this->db
										  ->get("customer");
										  foreach($uni->result() as $customer){?>	
										  <?php if($identity_project=="2"){$ktp=$customer->customer_ktp;}else{$ktp="";}?>										
										  <option id="<?=$customer->customer_id;?>" value="<?=$customer->customer_name;?> <?="( ".$ktp." )";?>">
										<?php }?>
									</datalist>	  
									<input id="customerid" onChange="rubah(this)" autofocus class="form-control" list="customer" value="<?=$customer_name;?>" autocomplete="off">	
									<input type="hidden" list="customer" id="customer_id" name="customer_id" value="<?=$customer_id;?>">
									<script>
										function rubah(a){
											var opt = $('option[value="'+$(a).val()+'"]');
											$("#customer_id").val(opt.attr('id'));											
										}
										var b = $('option[id="<?=$customer_id;?>"]').val();
										$("#customerid").val(b);
																					
									</script>	
									<?php }?>
									<div id="pilihcustomer">
									
									</div>								  
								</div>
							  </div>
							  
							  
							  <input type="hidden" name="grup_id" value="<?=$_GET["grup_id"];?>"/>
							  <input type="hidden" name="grupd_id" value="<?=$grupd_id;?>"/>					  					  
							  <div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" id="submit" class="btn btn-primary col-md-5" <?=$namabutton;?> value="OK">Submit</button>
									<button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?=site_url("grupd");?>">Back</button>
								</div>
							  </div>
							</form>
						</div>
						<?php }else{?>	
							<?php if($message!=""){?>
							<div class="alert alert-info alert-dismissable">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong><?=$message;?></strong><br/><?=$uploadgrupd_picture;?>
							</div>
							<?php }?>
							<div class="box">
								<div id="collapse4" class="body table-responsive">				
								<table id="dataTable" class="table table-condensed table-hover">
									<thead>
										<tr>
											<th>No.</th>
											<th>Customer</th>
											<th class="col-md-1">Action</th>
										</tr>
									</thead>
									<tbody> 
										<?php $usr=$this->db
										->join("customer","customer.customer_id=grupd.customer_id","left")
										->where("grup_id",$this->input->get("grup_id"))
										->order_by("grupd_id","desc")
										->get("grupd");
										$no=1;
										foreach($usr->result() as $grupd){?>
										<tr>			
											<td><?=$no++;?></td>	
											<td><?=$grupd->customer_name;?></td>
											<td style="padding-left:0px; padding-right:0px;">
												<form method="post" class="" style="padding:0px; margin:2px; float:left;">
													<button class="btn btn-sm btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
													<input type="hidden" name="grupd_id" value="<?=$grupd->grupd_id;?>"/>
												</form>
											
												<form method="post" class="" style="padding:0px; margin:2px; float:left;">
													<button class="btn btn-sm btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
													<input type="hidden" name="grupd_id" value="<?=$grupd->grupd_id;?>"/>
												</form>																			
											</td>
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
