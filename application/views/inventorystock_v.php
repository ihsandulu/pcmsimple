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
				<li class="active">Inventory Stock</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-10">
				<h1 class="page-header"> Inventory Stock</h1>
			</div>
			<?php if(!isset($_POST['new'])&&!isset($_POST['edit'])){?>
			<form target="_blank" method="get" class="col-md-2" action="<?=site_url("printinventorystock");?>">							
				<h1 class="page-header col-md-12"> 
				<button name="new" class="btn btn-warning btn-block btn-lg fa fa-print" value="OK" style=""> Print</button>
				<input type="hidden" name="inventorylog_id"/>
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
							<?php if(isset($_POST['edit'])){$namabutton='name="change"';$judul="Update Stock";}else{$namabutton='name="create"';$judul="Add Stock";}?>	
							<div class="lead"><h3><?=$judul;?></h3></div>
							<form class="form-horizontal" method="post" enctype="multipart/form-data">
							  <div class="form-group">
								<label class="control-label col-sm-2" for="inventorylog_name">inventory:</label>
								<div class="col-sm-10">
								  <select name="inventory_id" class="form-control">
								  <option>Select inventory</option>
								  <?php $prod=$this->db->get("inventory");
								  foreach($prod->result() as $inventory){?>
								  <option value="<?=$inventory->inventory_id;?>" <?php if($inventory_id==$inventory->inventory_id){echo"selected";}?>>
								  	<?=$inventory->inventory_name;?>
								  </option>
								  <?php }?>
								  </select>
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="inventorylog_qty">Qty:</label>
								<div class="col-sm-10">
								  <input type="number" autofocus class="form-control" id="inventorylog_qty" name="inventorylog_qty" placeholder="" value="<?=$inventorylog_qty;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="inventorylog_inout">In / Out:</label>
								<div class="col-sm-10">
								<div class="radio">
									<label><input value="in" type="radio" <?php if($inventorylog_inout=="in"){echo'checked="checked"';}?> name="inventorylog_inout">In</label>
								</div>
								<div class="radio">
									<label><input value="out" type="radio" <?php if($inventorylog_inout=="out"){echo'checked="checked"';}?> name="inventorylog_inout">Out</label>
								</div>
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="inventorylog_keterangan">Remarks:</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control" id="inventorylog_keterangan" name="inventorylog_keterangan" placeholder="" value="<?=$inventorylog_keterangan;?>">
								</div>
							  </div>
							  
							  
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
											<th>Product</th>
											<th>Qty</th>
											<th class="col-md-2">Info</th>
										</tr>
									</thead>
									<tbody> 
										<?php 
										$no=0;
										$usr=$this->db	
										->order_by("inventory_id","desc")									
										->order_by("inventory_name","asc")
										->get("inventory");
										$no=1;
										foreach($usr->result() as $inventory){
										$jml=0;
										$inventorylog=$this->db								
										->where("inventory_id",$inventory->inventory_id)
										->get("inventorylog");
										foreach($inventorylog->result() as $inventorylog){
											if($inventorylog->inventorylog_inout=="in"){$jml+=$inventorylog->inventorylog_qty;}else{$jml-=$inventorylog->inventorylog_qty;}
										}
										?>
										<tr>	
											<td><?=$no++;?></td>										
											<td><?=$inventory->inventory_name;?></td>
											<td><?=$jml;?></td>
											<?php 
												if($jml<$inventory->inventory_minimal){
													$pesan="Need to re-order"; 
													$css="background-color:red; color:white";
												}else{$pesan="";$css="";}
											?>
											<td style="<?=$css;?>">
												<?=$pesan;?>											</td>
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
