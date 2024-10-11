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
				<li class="active">Sales Access</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-10">
				<h1 class="page-header"> Sales Access</h1>
			</div>
			<?php if(!isset($_POST['new'])&&!isset($_POST['edit'])){?>
			<form method="post" class="col-md-2">							
				<h1 class="page-header col-md-12"> 
				<button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
				<input type="hidden" name="access_id"/>
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
							<?php if(isset($_POST['edit'])){$namabutton='name="change"';$judul="Update Sales Access";}else{$namabutton='name="create"';$judul="New Sales Access";}?>	
							<div class="lead"><h3><?=$judul;?></h3></div>
							<form class="form-horizontal" method="post" enctype="multipart/form-data">		
							  <div class="form-group">
								<label class="control-label col-sm-2" for="customer_id">Customer:</label>
								<div class="col-sm-10"><?=($customer_id!="")?$customer_id:"";?>
								  <select class="form-control" id="customer_id" name="customer_id" >
								  <option value="" <?=($customer_id=="")?"selected":"";?>>Pilih Customer</option>
								  <?php $customer=$this->db->get("customer");
								  foreach($customer->result() as $customer){
								  ?>
								  <option value="<?=$customer->customer_id;?>" <?=($customer_id==$customer->customer_id)?"selected":"";?>><?=$customer->customer_name;?></option>
								  <?php }?>
								  </select>
								</div>
							  </div>	
							  <div class="form-group">
								<label class="control-label col-sm-2" for="user_id">Sales:</label>
								<div class="col-sm-10">
								  <select class="form-control" id="user_id" name="user_id" >
								  <option value="" <?=($user_id=="")?"selected":"";?>>Pilih Sales</option>
								  <?php $user=$this->db
								  ->where("position_id",3)
								  ->get("user");
								  foreach($user->result() as $user){
								  ?>
								  <option value="<?=$user->user_id;?>" <?=($user_id==$user->user_id)?"selected":"";?>><?=$user->user_name;?></option>
								  <?php }?>
								  </select>
								</div>
							  </div>	
							  <div class="form-group">
								<label class="control-label col-sm-2" for="product_id">Product:</label>
								<div class="col-sm-10">
								  <select class="form-control" id="product_id" name="product_id" >
								  <option value="" <?=($product_id=="")?"selected":"";?>>Pilih Produk</option>
								  <?php $product=$this->db->get("product");
								  foreach($product->result() as $product){
								  ?>
								  <option value="<?=$product->product_id;?>" <?=($product_id==$product->product_id)?"selected":"";?>><?=$product->product_name;?></option>
								  <?php }?>
								  </select>
								</div>
							  </div>
							  
							  <input type="hidden" name="access_id" value="<?=$access_id;?>"/>					  					  
							  <div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" id="submit" class="btn btn-primary col-md-5" <?=$namabutton;?> value="OK">Submit</button>
									<button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?=site_url("access");?>">Back</button>
								</div>
							  </div>
							</form>
						</div>
						<?php }else{?>	
							<?php if($message!=""){?>
							<div class="alert alert-info alert-dismissable">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong><?=$message;?></strong><br/><?=$uploadaccess_picture;?>
							</div>
							<?php }?>
							<div class="box">
								<div id="collapse4" class="body table-responsive">				
								<table id="dataTable" class="table table-condensed table-hover">
									<thead>
										<tr>
											<th>No.</th>
											<th>Customer</th>
											<th>Sales</th>
											<th>Product</th>
											<th class="col-md-2">Action</th>
										</tr>
									</thead>
									<tbody> 
										<?php $usr=$this->db
										->join("customer","customer.customer_id=access.customer_id","left")
										->join("user","user.user_id=access.user_id","left")
										->join("product","product.product_id=access.product_id","left")
										->order_by("access_id","desc")
										->get("access");
										$no=1;
										foreach($usr->result() as $access){?>
										<tr>			
											<td><?=$no++;?></td>				
											<td><?=$access->customer_name;?></td>
											<td><?=$access->user_name;?></td>
											<td><?=$access->product_name;?></td>
											<td style="padding-left:0px; padding-right:0px;">
												<form method="post" class="col-md-4" style="padding:0px;float:left;">
													<button class="btn  btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
													<input type="hidden" name="access_id" value="<?=$access->access_id;?>"/>
												</form>
											
												<form method="post" class="col-md-4" style="padding:0px;float:left;">
													<button class="btn  btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
													<input type="hidden" name="access_id" value="<?=$access->access_id;?>"/>
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
	</div>
<!-- /#wrap -->
	<?php require_once("footer.php");?>
</body>

</html>
