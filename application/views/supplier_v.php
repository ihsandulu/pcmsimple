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
				<li class="active">Supplier</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-10">
				<h1 class="page-header"> Supplier</h1>
			</div>
			<?php if(!isset($_POST['new'])&&!isset($_POST['edit'])){?>
			<form method="post" class="col-md-2">							
				<h1 class="page-header col-md-12"> 
				<button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
				<input type="hidden" name="supplier_id"/>
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
							<?php if(isset($_POST['edit'])){$namabutton='name="change"';$judul="Update supplier";}else{$namabutton='name="create"';$judul="New supplier";}?>	
							<div class="lead"><h3><?=$judul;?></h3></div>
							<form class="form-horizontal" method="post" enctype="multipart/form-data">
							  <div class="form-group">
								<label class="control-label col-sm-2" for="supplier_type">Type:</label>
								<div class="col-sm-10">
								  <select required autofocus class="form-control" id="supplier_type" name="supplier_type">
								  	<option value="0" <?=($supplier_type=="0")?"selected":"";?>>Choose Type</option>
								  	<option value="1" <?=($supplier_type=="1")?"selected":"";?>>Supplier</option>
								  	<option value="2" <?=($supplier_type=="2")?"selected":"";?>>Makloon</option>
								  </select>
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="supplier_name">Name:</label>
								<div class="col-sm-10">
								  <input type="text"  class="form-control" id="supplier_name" name="supplier_name" placeholder="Enter Name" value="<?=$supplier_name;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="supplier_email">Email:</label>
								<div class="col-sm-10">
								  <input type="text"  class="form-control" id="supplier_email" name="supplier_email" placeholder="Enter Email" value="<?=$supplier_email;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="supplier_address">Address:</label>
								<div class="col-sm-10">
								  <input type="text"  class="form-control" id="supplier_address" name="supplier_address" placeholder="Enter Address" value="<?=$supplier_address;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="supplier_phone">Phone:</label>
								<div class="col-sm-10">
								  <input type="text"  class="form-control" id="supplier_phone" name="supplier_phone" placeholder="Enter Phone" value="<?=$supplier_phone;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="supplier_fax">Fax:</label>
								<div class="col-sm-10">
								  <input type="text"  class="form-control" id="supplier_fax" name="supplier_fax" placeholder="Enter Fax" value="<?=$supplier_fax;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="supplier_cp">Contact Person:</label>
								<div class="col-sm-10">
								  <input type="text"  class="form-control" id="supplier_cp" name="supplier_cp" placeholder="Enter CP" value="<?=$supplier_cp;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="supplier_npwp">NPWP:</label>
								<div class="col-sm-10">
								  <input type="text"  class="form-control" id="supplier_npwp" name="supplier_npwp" placeholder="Enter NPWP" value="<?=$supplier_npwp;?>">
								</div>
							  </div>
							  
							  <input type="hidden" name="supplier_id" value="<?=$supplier_id;?>"/>					  					  
							  <div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" id="submit" class="btn btn-primary col-md-5" <?=$namabutton;?> value="OK">Submit</button>
									<button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?=site_url("supplier");?>">Back</button>
								</div>
							  </div>
							</form>
						</div>
						<?php }else{?>	
							<?php if($message!=""){?>
							<div class="alert alert-info alert-dismissable">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong><?=$message;?></strong><br/><?=$uploadsupplier_picture;?>
							</div>
							<?php }?>
							<div class="box">
								<div id="collapse4" class="body table-responsive">				
								<table id="dataTable" class="table table-condensed table-hover">
									<thead>
										<tr>
											<th>No.</th>
											<th>Type</th>
											<th>Name</th>
											<th>Email</th>
											<th>Address</th>
											<th>Phone</th>
											<th>CP</th>
											<th class="col-md-2">Action</th>
										</tr>
									</thead>
									<tbody> 
										<?php 
										$t=array("","Supplier","Makloon");
										$usr=$this->db
										->order_by("supplier_id","desc")
										->get("supplier");
										$no=1;
										foreach($usr->result() as $supplier){?>
										<tr>	
											<td><?=$no++;?></td>										
											<td><?=$t[$supplier->supplier_type];?></td>					
											<td style="text-align:left;"><?=$supplier->supplier_name;?></td>
											<td style="text-align:left;"><?=$supplier->supplier_email;?></td>
											<td style="text-align:left;"><?=$supplier->supplier_address;?></td>
											<td><?=$supplier->supplier_phone;?></td>
											<td><?=$supplier->supplier_cp;?></td>
											<td style="padding-left:0px; padding-right:0px;">
												
											
												<form method="post" class="" style="padding:0px; margin:2px; float:right;">
													<button class="btn btn-sm btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
													<input type="hidden" name="supplier_id" value="<?=$supplier->supplier_id;?>"/>
												</form>
												<form method="post" class="" style="padding:0px; margin:2px; float:right;">
													<button class="btn btn-sm btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
													<input type="hidden" name="supplier_id" value="<?=$supplier->supplier_id;?>"/>
												</form>
												<form target="_blank" action="supplierproduct" method="get" class="" style="padding:0px; margin:2px; float:right;">
													<button class="btn btn-sm btn-primary " data-toggle="tooltip" title="Product Supplier" name="supplier_id" value="<?=$supplier->supplier_id;?>"><span class="fa fa-shopping-bag" style="color:white;"></span> </button>
													<input type="hidden" name="supplier_id" value="<?=$supplier->supplier_id;?>"/>
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
