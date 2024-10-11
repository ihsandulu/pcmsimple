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
				<li class="active">Product PO Customer</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-8">
				<h1 class="page-header"> Product PO Customer No. <?=$this->input->get("poc_no");?></h1>
			</div>
			<?php if(!isset($_POST['new'])&&!isset($_POST['edit'])){?>
			<form method="post" class="col-md-4">							
				<h1 class="page-header col-md-12"> 				
				<button name="new" class="btn btn-info btn-lg" value="OK" style=" float:right;margin:2px;">New</button>
				<button type="button" onClick="window.close()" class="btn btn-warning btn-lg" style=" float:right; margin:2px;"> Back</button>
				<input type="hidden" name="pocproduct_id" value="0"/>
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
										if($identity->identity_productcustomer==3 && $identity->identity_project==1){
											$input["project_id"]=$this->input->get("project_id");
											$product = $this->db
											->join("product","product.product_id=projectproduct.product_id","left")
											->get_where("projectproduct",$input);
											$price = "projectproduct_price";
										}elseif($identity->identity_productcustomer==1){
											$input["customer_id"]=$this->input->get("customer_id");
											$product = $this->db
											->join("product","product.product_id=customerproduct.product_id","left")
											->get_where("customerproduct",$input);
											$price = "customerproduct_price";
										}elseif($identity->identity_productcustomer==2){
											$input["vendor_id"]=$this->input->get("vendor_id");
											$product = $this->db
											->join("product","product.product_id=vendorproduct.product_id","left")
											->get_where("vendorproduct",$input);
											$price = "vendorproduct_price";
										}else{
											$product = $this->db->get("product");
											$price = "product_sell";
										}
										$a=$this->db->last_query();
										  foreach($product->result() as $cusprod){?>											
										  <option id="<?=$cusprod->product_id;?>" price="<?=$cusprod->$price;?>" value="<?=$cusprod->product_name;?> (Rp.<?=number_format($cusprod->$price,0,",",".");?>)">
										<?php }?>
									</datalist>	 
									<input onChange="productid(this)" class="form-control" list="product" value="<?=$product_name;?>">	
									<input type="hidden" list="product" id="product_id" name="product_id" value="<?=$product_id;?>">
									<script>
										function productid(a){
											var opt = $('option[value="'+$(a).val()+'"]');
											$("#product_id").val(opt.attr('id'));
											$("#pocproduct_price").val(opt.attr('price'));
										}
									</script>	
								  
								</div>
							  </div>
							  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="pocproduct_price">Price:</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control" id="pocproduct_price" name="pocproduct_price" placeholder="Enter Price" value="<?=$pocproduct_price;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="pocproduct_qty">Qty:</label>
								<div class="col-sm-10">
								  <input required type="number" min="1" autofocus class="form-control" id="pocproduct_qty" name="pocproduct_qty" placeholder="Enter Qty" value="<?=$pocproduct_qty;?>">
								</div>
							  </div>
							  <input type="hidden" name="pocproduct_id" value="<?=$pocproduct_id;?>"/>	
							  <input type="hidden" name="poc_no" value="<?=$this->input->get("poc_no");?>"/>					  					  
							  <div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" id="submit" class="btn btn-primary col-md-5" <?=$namabutton;?> value="OK">Submit</button>
									<button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?=site_url("pocproduct");?>">Back</button>
								</div>
							  </div>
							</form>
						</div>
						<?php }else{?>	
							<?php if($message!=""){?>
							<div class="alert alert-info alert-dismissable">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong><?=$message;?></strong><br/><?=$uploadpocproduct_picture;?>
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
										->join("product","product.product_id=pocproduct.product_id","left")
										->where("poc_no",$this->input->get("poc_no"))
										->order_by("pocproduct_id","desc")
										->get("pocproduct");
										$no=1;
										//echo $this->db->last_query();
										foreach($usr->result() as $pocproduct){?>
										<tr>		
											<td><?=$no++;?></td>									
											<td><?=$pocproduct->product_name;?></td>
											<td><?=$pocproduct->pocproduct_qty;?></td>
											<td><?=number_format($pocproduct->pocproduct_price,0,",",".");?></td>
											<td><?=number_format($pocproduct->pocproduct_price*$pocproduct->pocproduct_qty,0,",",".");?></td>
											<td style="padding-left:0px; padding-right:0px;">
												<form method="post" class="col-md-6" style="padding:0px;">
													<button class="btn btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
													<input type="hidden" name="pocproduct_id" value="<?=$pocproduct->pocproduct_id;?>"/>
												</form>
											
												<form method="post" class="col-md-6" style="padding:0px;">
													<button class="btn btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
													<input type="hidden" name="pocproduct_id" value="<?=$pocproduct->pocproduct_id;?>"/>
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
