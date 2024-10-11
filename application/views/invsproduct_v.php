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
				<li class="active">Product Invoice Supplier</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-8">
				<h1 class="page-header"> Product Invoice Supplier No. <?=$this->input->get("invs_no");?></h1>
			</div>
			<?php if(!isset($_POST['new'])&&!isset($_POST['edit'])){?>
			<form method="post" class="col-md-4">							
				<h1 class="page-header col-md-12"> 				
				<button name="new" class="btn btn-info btn-lg" value="OK" style=" float:right;margin:2px;">New</button>
				<button type="button" onClick="window.close()" class="btn btn-warning btn-lg" style=" float:right; margin:2px;"> Back</button>
				<input type="hidden" name="invsproduct_id" value="0"/>
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
							<?php if(isset($_POST['edit'])){$namabutton='name="change"';$judul="Update Product";}else{$namabutton='name="create"';$judul="New Product";}?>	
							<div class="lead"><h3><?=$judul;?></h3></div>
							<form class="form-horizontal" method="post" enctype="multipart/form-data">
							  <div class="form-group">
								<label class="control-label col-sm-2" for="unit_id">Product:</label>
								<div class="col-sm-10">
									<datalist id="product">
										<?php 
										if($identity->identity_productsupplier==1){
											$uni=$this->db
											  ->join("product","product.product_id=supplierproduct.product_id","left")
											  ->where("supplier_id",$this->input->get("supplier_id"))
											  ->get("supplierproduct");
											  $price="supplierproduct_price";
										}else{
											$uni=$this->db->get("product");
											  $price="product_buy";
										}
										$a= $this->db->last_query();
										  foreach($uni->result() as $cusprod){?>											
										  <option id="<?=$cusprod->product_id;?>" value="<?=$cusprod->product_name;?> (Rp.<?=number_format($cusprod->$price,0,",",".");?>)">
										<?php }?>
									</datalist>
									<input id="productid" onChange="change(this)" class="form-control" list="product" value="<?=$product_name;?>" autocomplete="off">	
									<input type="hidden" list="product" id="product_id" name="product_id" value="<?=$product_id;?>">
									<script>
										function productid(a){
											var opt = $('option[value="'+$(a).val()+'"]');
											$("#product_id").val(opt.attr('id'));
											hargasupplier(opt.attr('id'));
											
										}
										function hargasupplier(a){
											$.get("<?=site_url("api/hargasupplier");?>",{product_id:a,supplier_id:'<?=$this->input->get("supplier_id");?>'})
											.done(function(data){
												$("#invsproduct_price").val(data);
											});
										}
										
										function change(a){
											productid(a);
											stoptime();
										}
										
										var timeout;
										function doStuff() {
											timeout = setInterval(function(){productid('#productid');},100);
										}
										
										function stoptime(){
											clearTimeout(timeout);
										}
									</script>	
								  
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="invsproduct_price">Price:</label>
								<div class="col-sm-10">
								  <input onClick="stoptime()" onFocus="stoptime()" type="text" autofocus class="form-control" id="invsproduct_price" name="invsproduct_price" placeholder="Enter Price" value="<?=$invsproduct_price;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="invsproduct_qty">Qty:</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control" id="invsproduct_qty" name="invsproduct_qty" placeholder="Enter Qty" value="<?=$invsproduct_qty;?>">
								</div>
							  </div>
							  <input type="hidden" name="invsproduct_id" value="<?=$invsproduct_id;?>"/>	
							  <input type="hidden" name="invs_no" value="<?=$this->input->get("invs_no");?>"/>	
							  <input type="hidden" name="gudang_id" value="<?=$gudang_id;?>"/>									  					  
							  <div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" id="submit" class="btn btn-primary col-md-5" <?=$namabutton;?> value="OK">Submit</button>
									<button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?=site_url("invsproduct");?>">Back</button>
								</div>
							  </div>
							</form>
						</div>
						<?php }else{?>	
							<?php if($message!=""){?>
							<div class="alert alert-info alert-dismissable">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong><?=$message;?></strong><br/><?=$uploadinvsproduct_picture;?>
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
											<th>Price</th>
											<th>Total</th>
											<th class="col-md-1">Action</th>
										</tr>
									</thead>
									<tbody> 
										<?php $usr=$this->db
										->join("product","product.product_id=invsproduct.product_id","left")
										->where("invs_no",$this->input->get("invs_no"))
										->order_by("invsproduct_id","desc")
										->get("invsproduct");
										$no=1;
										//echo $this->db->last_query();
										foreach($usr->result() as $invsproduct){?>
										<tr>											
											<td><?=$no++;?></td>	
											<td><?=$invsproduct->product_name;?></td>
											<td><?=$invsproduct->invsproduct_qty;?></td>
											<td><?=number_format($invsproduct->invsproduct_price,0,",",".");?></td>
											<td><?=number_format($invsproduct->invsproduct_price*$invsproduct->invsproduct_qty,0,",",".");?></td>
											<td style="padding-left:0px; padding-right:0px;">
												<form method="post" class="col-md-6" style="padding:0px;">
													<button class="btn btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
													<input type="hidden" name="invsproduct_id" value="<?=$invsproduct->invsproduct_id;?>"/>
												</form>
											
												<form method="post" class="col-md-6" style="padding:0px;">
													<button class="btn btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
													<input type="hidden" name="invsproduct_id" value="<?=$invsproduct->invsproduct_id;?>"/>
													<input type="hidden" name="gudang_id" value="<?=$invsproduct->gudang_id;?>"/>
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
