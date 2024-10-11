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
				<li class="active">Product</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-10">
				<h1 class="page-header"> Product</h1>
			</div>
			<?php if(!isset($_POST['new'])&&!isset($_POST['edit'])){?>
			<form method="post" class="col-md-2">							
				<h1 class="page-header col-md-12"> 
				<button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
				<input type="hidden" name="product_id"/>
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
								<label class="control-label col-sm-2" for="product_name">Product Name:</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control" id="product_name" name="product_name" placeholder="Enter Name" value="<?=$product_name;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="unit_id">Unit:</label>
								<div class="col-sm-10">
									
								  <select class="form-control" id="unit_id" name="unit_id">
								  <?php $uni=$this->db->get("unit");
								  foreach($uni->result() as $unit){?>
								  <option value="<?=$unit->unit_id;?>" <?php if($unit->unit_id==$unit_id){echo"selected";}?> ><?=$unit->unit_name;?></option>
								  <?php }?>
								  </select>
								</div>
							  </div>
							  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="product_minimal">Minimum:</label>
								<div class="col-sm-10">
								  <input type="number" autofocus class="form-control" id="product_minimal" name="product_minimal" placeholder="Enter Minimum Count" value="<?=$product_minimal;?>">
								</div>
							  </div>
							  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="product_description">Description:</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control" id="product_description" name="product_description" placeholder="Enter Description" value="<?=$product_description;?>">
								</div>
							  </div>
							  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="product_buy">Buy:</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control" id="product_buy" name="product_buy" placeholder="Enter Price" value="<?=$product_buy;?>">
								</div>
							  </div>
							  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="product_sell">Sell:</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control" id="product_sell" name="product_sell" placeholder="Enter Price" value="<?=$product_sell;?>">
								</div>
							  </div>
							  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="product_type">Type:</label>
								<div class="col-sm-10">								  
								<div class="radio">
								  <label><input value="0" type="radio" name="product_type" <?php if($product_type=="0"){?>checked="checked"<?php }?>>Product</label>
								</div>
								<div class="radio">
								  <label><input value="1" type="radio" name="product_type" <?php if($product_type=="1"){?>checked="checked"<?php }?>>Jasa</label>
								</div>
								</div>
							  </div>
							  
							  <div class="form-group">
                                        <label class="control-label col-sm-2" for="product_picture">Picture:</label>
                                        <div class="col-sm-10" align="left"> 
                                          <input type="file"  id="product_picture" name="product_picture"><br/>
                                        <?php if($product_picture!=""){$user_image="assets/images/product_picture/".$product_picture;}else{$user_image="assets/images/product_picture/noimage.png";}?>
                                          <img id="product_picture_image" width="100" height="100" src="<?=base_url($user_image);?>"/>
                                          <script>
                                            function readURL(input) {
                                                if (input.files && input.files[0]) {
                                                    var reader = new FileReader();
                                        
                                                    reader.onload = function (e) {
                                                        $('#product_picture_image').attr('src', e.target.result);
                                                    }
                                        
                                                    reader.readAsDataURL(input.files[0]);
                                                }
                                            }
                                        
                                            $("#product_picture").change(function () {
                                                readURL(this);
                                            });
                                          </script>
                                        </div>
                                      </div>

							  
							  <input type="hidden" name="product_id" value="<?=$product_id;?>"/>					  					  
							  <div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" id="submit" class="btn btn-primary col-md-5" <?=$namabutton;?> value="OK">Submit</button>
									<button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?=site_url("product");?>">Back</button>
								</div>
							  </div>
							</form>
						</div>
						<?php }else{?>	
							<?php if($message!=""){?>
							<div class="alert alert-info alert-dismissable">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong><?=$message;?></strong><br/><?=$uploadproduct_picture;?>
							</div>
							<?php }?>
							<div class="box">
								<div id="collapse4" class="body table-responsive">				
								<table id="dataTable" class="table table-condensed table-hover">
									<thead>
										<tr>
											<th>No.</th>
											<th>Product</th>
											<th>Unit</th>
											<th>Description</th>
											<th>Buy</th>
											<th>Sell</th>
											<th class="col-md-1">Minimum</th>
											<th class="col-md-1">Picture</th>
											<th class="col-md-1">Action</th>
										</tr>
									</thead>
									<tbody> 
										<?php $usr=$this->db
										->join("unit","unit.unit_id=product.unit_id","left")
										->order_by("product_id","desc")
										->get("product");
										$no=1;
										foreach($usr->result() as $product){?>
										<tr>						
											<td><?=$no++;?></td>					
											<td style="text-align:left;"><?=$product->product_name;?></td>
											<td><?=$product->unit_name;?></td>
											<td><?=$product->product_description;?></td>
											<td style="text-align:right;"><?=number_format($product->product_buy,2,",",".");?></td>
											<td style="text-align:right;"><?=number_format($product->product_sell,2,",",".");?></td>
											<td><?=$product->product_minimal;?></td>
											<td>
											<?php if($product->product_picture!=""){$gambar=$product->product_picture;}else{$gambar="noimage.png";}?>
											<img onClick="tampil(this)" src="<?=base_url("assets/images/product_picture/".$gambar);?>" style="width:20px; height:20px;">
											<script>
											function tampil(a){
												var gambar=$(a).attr("src");
												$("#imgumum").attr("src",gambar);
												$("#myImage").modal("show");
											}
											</script>
											</td>
											<td style="padding-left:0px; padding-right:0px;">
												<form method="post" class="col-md-6" style="padding:0px;">
													<button class="btn btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
													<input type="hidden" name="product_id" value="<?=$product->product_id;?>"/>
												</form>
											
												<form method="post" class="col-md-6" style="padding:0px;">
													<button class="btn btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
													<input type="hidden" name="product_id" value="<?=$product->product_id;?>"/>
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
