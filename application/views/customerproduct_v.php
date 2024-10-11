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
				<li class="active">Customer Product</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-10">
				<h1 class="page-header"> <?=$this->input->get("customer_name");?> Product</h1>
			</div>
			<?php if(!isset($_POST['new'])&&!isset($_POST['edit'])){?>
			
			<form method="post" class="col-md-2">							
				<h1 class="page-header col-md-12"> 
				<button type="button" onClick="window.close()" class="btn btn-warning   " style=""> Back</button>
				<button type="submit" name="new" class="btn btn-info  " value="OK" style="">New</button>
				<input type="hidden" name="customerproduct_id"/>
				<input type="hidden" name="customer_id" value="<?=$this->input->post("customer_id");?>"/>
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
							<?php if(isset($_POST['edit'])){$namabutton='name="change"';$judul="Update Customer Product";}else{$namabutton='name="create"';$judul="New Customer Product";}?>	
							<div class="lead"><h3><?=$judul;?></h3></div>
							<form class="form-horizontal" method="post" enctype="multipart/form-data">
							  <div class="form-group">
								<label class="control-label col-sm-2" for="product_id">Product:</label>
								<div class="col-sm-10">
									<datalist id="product">
										<?php $produc=$this->db->get("product");foreach($produc->result() as $product){?>
											<option id="<?=$product->product_id;?>" value="<?=$product->product_name;?> (Rp.<?=number_format($product->product_sell,0,",",".");?>)">
										<?php }?>
									</datalist>	  
									<?php if($product_name==""){$product_name="";}else{$product_name=$product_name." (Rp.".number_format($product_sell,0,",",".").")";} ?>
									<input autocomplete="off"  id="productid" onChange="change1(this)" class="form-control" list="product" value="<?=$product_name;?>">	
									<input type="hidden" list="product" id="product_id" name="product_id" value="<?=$product_id;?>">
									<script>
										function productid(a){
											var opt = $('option[value="'+$(a).val()+'"]');
											$("#product_id").val(opt.attr('id'));
											hargadasar(opt.attr('id'));
											
										}
										
										function hargadasar(a){
											$.get("<?=site_url("api/hargadasar");?>",{product_id:a,field:'product_sell'})
											.done(function(data){
												$("#customerproduct_price").val(data);
											});
										}
										
										function change1(a){
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
								<label class="control-label col-sm-2" for="customerproduct_price">Price:</label>
								<div class="col-sm-10">
								  <input onFocus="stoptime()" type="text" autofocus class="form-control" id="customerproduct_price" name="customerproduct_price" placeholder="Enter Price" value="<?=$customerproduct_price;?>">
								</div>
							  </div>
							  <input type="hidden" name="customer_id" value="<?=$this->input->get("customer_id");?>"/>
							  <input type="hidden" name="customerproduct_id" value="<?=$customerproduct_id;?>"/>					  					  
							  <div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" id="submit" class="btn btn-primary col-md-5" <?=$namabutton;?> value="OK">Submit</button>
									<button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?=site_url("customerproduct");?>">Back</button>
								</div>
							  </div>
							</form>
						</div>
						<?php }else{?>	
							<?php if($message!=""){?>
							<div class="alert alert-info alert-dismissable">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong><?=$message;?></strong><br/><?=$uploadcustomerproduct_picture;?>
							</div>
							<?php }?>
							<div class="box">
								<div id="collapse4" class="body table-responsive">				
								<table id="dataTable" class="table table-condensed table-hover">
									<thead>
										<tr>
											<th>No.</th>
											<th>Product</th>
											<th>Price</th>
											<th class="col-md-1">Action</th>
										</tr>
									</thead>
									<tbody> 
										<?php $usr=$this->db
										->join("product","product.product_id=customerproduct.product_id","left")
										->join("customer","customer.customer_id=customerproduct.customer_id","left")
										->where("customerproduct.customer_id",$this->input->get("customer_id"))
										->order_by("customerproduct_id","desc")
										->get("customerproduct");
										$no=1;
										foreach($usr->result() as $customerproduct){?>
										<tr>		
											<td><?=$no++;?></td>									
											<td><?=$customerproduct->product_name;?></td>
											<td style="padding-left:0px; padding-right:0px;"><?=number_format($customerproduct->customerproduct_price,0,",",".");?></td>
											<td style="padding-left:0px; padding-right:0px;">
												<form method="post" class="col-md-6" style="padding:0px;">
													<button class="btn btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>								
													<input type="hidden" name="customerproduct_id" value="<?=$customerproduct->customerproduct_id;?>"/>
												</form>
											
												<form method="post" class="col-md-6" style="padding:0px;">
													<button class="btn btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
													<input type="hidden" name="customerproduct_id" value="<?=$customerproduct->customerproduct_id;?>"/>
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
