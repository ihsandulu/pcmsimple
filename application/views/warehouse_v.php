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
				<li class="active">Warehouse Inventory</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-10">
				<h1 class="page-header"> Warehouse Inventory</h1>
			</div>
			<?php if(!isset($_POST['new'])&&!isset($_POST['edit'])){?>
			<form target="_blank" method="get" class="col-md-2" action="<?=site_url("printwarehouse");?>">							
				<h1 class="page-header col-md-12"> 
				<button name="new" class="btn btn-warning btn-block btn-lg fa fa-print" value="OK" style=""> Print</button>
				<input type="hidden" name="gudang_id"/>
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
								<label class="control-label col-sm-2" for="gudang_name">Product:</label>
								<div class="col-sm-10">
								  <select name="product_id" class="form-control">
								  <option>Select Product</option>
								  <?php $prod=$this->db->get("product");
								  foreach($prod->result() as $product){?>
								  <option value="<?=$product->product_id;?>" <?php if($product_id==$product->product_id){echo"selected";}?>>
								  	<?=$product->product_name;?>
								  </option>
								  <?php }?>
								  </select>
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="gudang_qty">Qty:</label>
								<div class="col-sm-10">
								  <input type="number" autofocus class="form-control" id="gudang_qty" name="gudang_qty" placeholder="" value="<?=$gudang_qty;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="gudang_inout">In / Out:</label>
								<div class="col-sm-10">
								<div class="radio">
									<label><input value="in" type="radio" <?php if($gudang_inout=="in"){echo'checked="checked"';}?> name="gudang_inout">In</label>
								</div>
								<div class="radio">
									<label><input value="out" type="radio" <?php if($gudang_inout=="out"){echo'checked="checked"';}?> name="gudang_inout">Out</label>
								</div>
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="gudang_keterangan">Remarks:</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control" id="gudang_keterangan" name="gudang_keterangan" placeholder="" value="<?=$gudang_keterangan;?>">
								</div>
							  </div>
							  
							  
							  <input type="hidden" name="gudang_id" value="<?=$gudang_id;?>"/>					  					  
							  <div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" id="submit" class="btn btn-primary col-md-5" <?=$namabutton;?> value="OK">Submit</button>
									<button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?=site_url("gudang");?>">Back</button>
								</div>
							  </div>
							</form>
						</div>
						<?php }else{?>	
							<?php if($message!=""){?>
							<div class="alert alert-info alert-dismissable">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong><?=$message;?></strong><br/><?=$uploadgudang_picture;?>
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
										->order_by("product_id","desc")									
										->order_by("product_name","asc")
										->get("product");
										$no=1;
										foreach($usr->result() as $product){
										$jml=0;
										$gudang=$this->db								
										->where("product_id",$product->product_id)
										->get("gudang");
										foreach($gudang->result() as $gudang){
											if($gudang->gudang_inout=="in"){$jml+=$gudang->gudang_qty;}else{$jml-=$gudang->gudang_qty;}
										}
										?>
										<tr>	
											<td><?=$no++;?></td>										
											<td><?=$product->product_name;?></td>
											<td><?=$jml;?></td>
											<?php 
												if($jml<$product->product_minimal){
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
