<!doctype html>
<html>

<head>
    <?php 
	session_start();
	require_once("meta.php");?>
</head>

<body class="  " onLoad="getposition()">
		<?php require_once("header.php");?>
		<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">Grouping</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-10">
				<h1 class="page-header"> Grouping</h1>
			</div>
			<?php if(!isset($_POST['new'])&&!isset($_POST['edit'])){?>
			<form method="post" class="col-md-2">							
				<h1 class="page-header col-md-12"> 
				<button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
				<input type="hidden" name="equip_id"/>
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
							<?php if(isset($_POST['edit'])){$namabutton='name="change"';$judul="Update Module";}else{$namabutton='name="create"';$judul="New Module";}?>	
							<div class="lead"><h3><?=$judul;?></h3></div>
							<form class="form-horizontal" method="post" enctype="multipart/form-data">
							  <div class="form-group">
								<label class="control-label col-sm-2" for="vendor_id">Header:</label>
								<div class="col-sm-10">
								
								  <select id="vendor_id" name="vendor_id"  class="form-control">
								  	<option>Enter Brand</option>
									 <?php $vendo=$this->tt->get("vendor");
									foreach($vendo->result() as $vendor){?>
									<option value="<?=$vendor->vendor_id;?>" <?=$vendor_id==$vendor->vendor_id?"selected":"";?>>
										<?=$vendor->vendor_name;?>
									</option>
									<?php }?>
								  </select>
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="equip_name">Equipment:</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control" id="equip_name" name="equip_name" placeholder="Enter Equipment" value="<?=$equip_name;?>">
								</div>
							  </div>
							  <input type="hidden" name="equip_id" value="<?=$equip_id;?>"/>					  					  
							  <div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" class="btn btn-primary col-md-5" <?=$namabutton;?> value="OK">Submit</button>
									<button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?=site_url("equipment");?>">Back</button>
								</div>
							  </div>
							</form>
						</div>
						<?php }else{?>	
							<?php if($message!=""){?>
							<div class="alert alert-info alert-dismissable">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong><?=$message;?></strong><br/><?=$uploadequipment_picture;?>
							</div>
							<?php }?>
							<div class="box">								
								<div id="collapse4" class="body table-responsive">				
								<table id="dataTable" class="table table-condensed table-hover ">
									<thead>
										<tr>
											<th class="col-md-1">Delete</th>
											<th class="col-md-1">Update</th>
											<th>Brand</th>
											<th>Equipment</th>
										</tr>
									</thead>
									<tbody> 
										<?php $usr=$this->tt
										->join("vendor","vendor.vendor_id=equipment.vendor_id","left")
										->get("equipment");
										foreach($usr->result() as $equipment){?>
										<tr>
											<td>
												<form method="post">
													<button class="btn btn-default delete" name="delete" value="OK">
													<span class="fa fa-window-close"></span> 
													Delete</button>
													<input type="hidden" name="equip_id" value="<?=$equipment->equip_id;?>"/>
												</form>											</td>
											<td>
												<form method="post">
													<button class="btn btn-default" name="edit" value="OK">
													<span class="fa fa-edit"></span> 
													Update</button>
													<input type="hidden" name="equip_id" value="<?=$equipment->equip_id;?>"/>
												</form>											</td>
											<td><?=$equipment->vendor_name;?></td>
											<td><?=$equipment->equip_name;?></td>
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
