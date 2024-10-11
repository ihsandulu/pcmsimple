<!doctype html>
<html>

<head>
    <?php 	
	require_once("meta.php");
	?>
</head>

<body class="  " >
	<?php require_once("header.php");?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">Inventory Log</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<?php if(isset($_GET['daurulang'])&&!isset($_POST['new'])&&!isset($_POST['edit'])){$coltitle="col-md-8";}else{$coltitle="col-md-10";}?>
			<div class="<?=$coltitle;?>">
				<h1 class="page-header"> Inventory Log</h1>
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
			<?php if(!isset($_GET['report'])){?>
			<form method="post" class="col-md-2">							
				<h1 class="page-header col-md-12"> 
				<button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
				<input type="hidden" name="inventorylog_id"/>
				</h1>
			</form>
			<?php }?>
			<?php }?>
		</div><!--/.row-->
		
		
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
					<?php if(isset($_POST['new'])||isset($_POST['edit'])){?>
						<div class="">
							<?php if(isset($_POST['edit'])){$namabutton='name="change"';$judul="Update Stock Inventory";}else{$namabutton='name="create"';$judul="Add Stock Inventory";}?>	
							<div class="lead"><h3><?=$judul;?></h3></div>
							<form class="form-horizontal" method="post" enctype="multipart/form-data">
								<?php if(isset($_GET['daurulang'])){
									$inventorylog_qty=$this->input->get("inventorylog_qty");
									$inventorylog_inout=$this->input->get("inventorylog_inout");
									$inventorylog_keterangan=$this->input->get("inventorylog_keterangan");
								}?>
								<div class="form-group">
								<label class="control-label col-sm-2" for="unit_id">Inventory:</label>
								<div class="col-sm-10">
									<datalist id="inventory">
										<?php $uni=$this->db->get("inventory");
										  foreach($uni->result() as $cusprod){?>											
										  <option id="<?=$cusprod->inventory_id;?>" value="<?=$cusprod->inventory_name;?>">
										<?php }?>
									</datalist>	  
									<input autofocus onChange="inventoryid(this)" class="form-control" list="inventory" value="<?=$inventory_name;?>">	
									<input type="hidden" list="inventory" id="inventory_id" name="inventory_id" value="<?=$inventory_id;?>">
									<script>
										function inventoryid(a){
											var opt = $('option[value="'+$(a).val()+'"]');
											$("#inventory_id").val(opt.attr('id'));
										}
									</script>	
								  
								</div>
							  </div>
							  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="inventorylog_qty">Qty:</label>
								<div class="col-sm-10">
								  <input type="text" class="form-control" id="inventorylog_qty" name="inventorylog_qty" placeholder="" value="<?=$inventorylog_qty;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="inventorylog_inout">In / Out:</label>
								<div class="col-sm-10">
								<div class="radio">
									<label><input required value="in" type="radio" <?php if($inventorylog_inout=="in"){echo'checked="checked"';}?> name="inventorylog_inout">In</label>
								</div>
								<div class="radio">
									<label><input required value="out" type="radio" <?php if($inventorylog_inout=="out"){echo'checked="checked"';}?> name="inventorylog_inout">Out</label>
								</div>
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="inventorylog_keterangan">Remarks:</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control" id="inventorylog_keterangan" name="inventorylog_keterangan" placeholder="" value="<?=$inventorylog_keterangan;?>">
								</div>
							  </div>
							  
							  <?php if(isset($_GET['daurulang'])){?>							  
							  <input type="hidden" name="inventorylog_return" value="1"/>	
							  <?php }?>
							  <input type="hidden" name="inventorylog_id" value="<?=$inventorylog_id;?>"/>					  					  
							  <div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" id="submit" class="btn btn-primary col-md-5" <?=$namabutton;?> value="OK">Submit</button>
									<button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?=site_url("inventorylog");?>">Back</button>
								</div>
							  </div>
							</form>
						</div>
						<?php }else{?>	
							<?php if($message!=""){?>
							<div class="alert alert-info alert-dismissable">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong><?=$message;?></strong><br/><?=$uploadinventorylog_picture;?>
							</div>
							<?php }?>
							<div class="box">
								<div id="collapse4" class="body table-responsive">				
								<table id="dataTable" class="table table-condensed table-hover">
									<thead>
										<tr>
											<th>No.</th>
											<th>Date</th>
											<th>Branch</th>
											<th>Product</th>
											<th>In / Out</th>
											<th>Qty</th>
											<th class="col-md-1">Info</th>
											<th class="col-md-1">Picture</th>
											<?php if(!isset($_GET['report'])){?>
											<th class="col-md-1">Action</th>
											<?php }?>
										</tr>
									</thead>
									<tbody> 
										<?php 										
										$usr=$this->db
										->join("branch","branch.branch_id=inventorylog.branch_id","left")
										->join("inventory","inventory.inventory_id=inventorylog.inventory_id","left")
										->order_by("inventorylog_id","desc")
										->get("inventorylog");
										$no=1;
										foreach($usr->result() as $inventorylog){?>
										<tr>			
											<td><?=$no++;?></td>								
											<td><?=substr($inventorylog->inventorylog_datetime,0,10);?></td>
											<td><?=$inventorylog->branch_name;?></td>
											<td><?=$inventorylog->inventory_name;?></td>
											<td><?=strtoupper($inventorylog->inventorylog_inout);?></td>
											<td><?=$inventorylog->inventorylog_qty;?></td>
											<td><?=$inventorylog->inventorylog_keterangan;?></td>
											<td>
											<?php if($inventorylog->inventory_picture!=""){$gambar=$inventorylog->inventory_picture;}else{$gambar="noimage.png";}?>
											<img onClick="tampil(this)" src="<?=base_url("assets/images/inventory_picture/".$gambar);?>" style="width:20px; height:20px;">
											<script>
											function tampil(a){
												var gambar=$(a).attr("src");
												$("#imgumum").attr("src",gambar);
												$("#myImage").modal("show");
											}
											</script>											</td>
											<?php if(!isset($_GET['report'])){?>
											<td style="padding-left:0px; padding-right:0px;">
											<?php if($this->session->userdata("branch_id")==$inventorylog->branch_id){?>												
												<form method="post" class="" style="padding:0px; margin:2px; float:left;">
													<button class="btn btn-sm btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
													<input type="hidden" name="inventorylog_id" value="<?=$inventorylog->inventorylog_id;?>"/>
												</form>
											
												<form method="post" class="" style="padding:0px; margin:2px; float:left;">
													<button class="btn btn-sm btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
													<input type="hidden" name="inventorylog_id" value="<?=$inventorylog->inventorylog_id;?>"/>
												</form>	
											<?php }?>											</td>
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
	
	<!-- /#wrap -->
	<?php require_once("footer.php");?>
</body>

</html>
