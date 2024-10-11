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
				<li class="active">Product Permintaan</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-8">
				<h1 class="page-header"> Product Permintaan No. <?=$this->input->get("permintaan_no");?></h1>
			</div>
			<?php if(!isset($_POST['new'])&&!isset($_POST['edit'])){?>
			<form method="post" class="col-md-4">							
				<h1 class="page-header col-md-12"> 				
				<button name="new" class="btn btn-info btn-lg" value="OK" style=" float:right;margin:2px;">New</button>
				<button type="button" onClick="window.close()" class="btn btn-warning btn-lg" style=" float:right; margin:2px;"> Back</button>
				<input type="hidden" name="permintaanproduct_id" value="0"/>
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
							
							<?php if($identity->identity_project==1){?>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="unit_id">Project:</label>
								<div class="col-sm-10">
									<datalist id="project">
										<?php $project=$this->db
										  ->get("project");
										  foreach($project->result() as $project){?>											
										  <option id="<?=$project->project_id;?>" value="<?=$project->project_name;?>">
										<?php }?>
									</datalist>	  
									<input onChange="projectid(this)" class="form-control" list="project" value="<?=$project_name;?>">	
									<input type="hidden" list="project" id="project_id" name="project_id" value="<?=$project_id;?>">
									<script>
										function projectid(a){
											var opt = $('option[value="'+$(a).val()+'"]');
											$("#project_id").val(opt.attr('id'));
										}
									</script>	
								  
								</div>
							  </div>
							  <?php }?>
							  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="unit_id">Product:</label>
								<div class="col-sm-10">
									<datalist id="product">
										<?php $uni=$this->db
										  ->get("product");
										  foreach($uni->result() as $cusprod){?>											
										  <option id="<?=$cusprod->product_id;?>" value="<?=$cusprod->product_name;?>">
										<?php }?>
									</datalist>	  
									<input onChange="productid(this)" class="form-control" list="product" value="<?=$product_name;?>">	
									<input type="hidden" list="product" id="product_id" name="product_id" value="<?=$product_id;?>">
									<script>
										function productid(a){
											var opt = $('option[value="'+$(a).val()+'"]');
											$("#product_id").val(opt.attr('id'));
										}
									</script>	
								  
								</div>
							  </div>
							  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="permintaanproduct_qty">Qty:</label>
								<div class="col-sm-10">
								  <input type="number" min="0"  class="form-control" id="permintaanproduct_qty" name="permintaanproduct_qty" placeholder="Enter Qty" value="<?=$permintaanproduct_qty;?>">
								</div>
							  </div>
							  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="permintaanproduct_nama">Name:</label>
								<div class="col-sm-10">
								  <input type="text"  class="form-control" id="permintaanproduct_nama" name="permintaanproduct_nama" placeholder="Enter Name" value="<?=$permintaanproduct_nama;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="permintaanproduct_tlp">Telp:</label>
								<div class="col-sm-10">
								  <input type="text"  class="form-control" id="permintaanproduct_tlp" name="permintaanproduct_tlp" placeholder="Enter Telp. Number" value="<?=$permintaanproduct_tlp;?>">
								</div>
							  </div>
							  <input type="hidden" name="permintaanproduct_id" value="<?=$permintaanproduct_id;?>"/>	
							  <input type="hidden" name="permintaan_id" value="<?=$this->input->get("permintaan_id");?>"/>					  					  
							  <div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" id="submit" class="btn btn-primary col-md-5" <?=$namabutton;?> value="OK">Submit</button>
									<button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?=site_url("permintaanproduct");?>">Back</button>
								</div>
							  </div>
							</form>
						</div>
						<?php }else{?>	
							<?php if($message!=""){?>
							<div class="alert alert-info alert-dismissable">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong><?=$message;?></strong><br/><?=$uploadpermintaanproduct_picture;?>
							</div>
							<?php }?>
							<div class="box">
								<div id="collapse4" class="body table-responsive">				
								<table id="dataTable" class="table table-condensed table-hover">
									<thead>
										<tr>
											<th>No.</th>
											<?php if($identity->identity_project==1){?>
											<th>Project</th>
											<?php }?>
											<th>Product</th>
											<th>Qty</th>
											<th>Name</th>
											<th>Tlp.</th>
											<th class="col-md-1">Action</th>
										</tr>
									</thead>
									<tbody> 
										<?php $usr=$this->db
										->join("project","project.project_id=permintaanproduct.project_id","left")
										->join("product","product.product_id=permintaanproduct.product_id","left")
										->where("permintaan_id",$this->input->get("permintaan_id"))
										->order_by("permintaanproduct_id","desc")
										->get("permintaanproduct");
										//echo $this->db->last_query();
										$no=1;
										foreach($usr->result() as $permintaanproduct){?>
										<tr>		
											<td><?=$no++;?></td>	
											<?php if($identity->identity_project==1){?>								
											<td><?=$permintaanproduct->project_name;?></td>		
											<?php }?>
											<td><?=$permintaanproduct->product_name;?></td>
											<td><?=$permintaanproduct->permintaanproduct_qty;?></td>
											<td><?=$permintaanproduct->permintaanproduct_nama;?></td>
											<td><?=$permintaanproduct->permintaanproduct_tlp;?></td>
											<td style="padding-left:0px; padding-right:0px;">
												<form method="post" class="col-md-6" style="padding:0px;">
													<button class="btn btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
													<input type="hidden" name="permintaanproduct_id" value="<?=$permintaanproduct->permintaanproduct_id;?>"/>
												</form>
											
												<form method="post" class="col-md-6" style="padding:0px;">
													<button class="btn btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
													<input type="hidden" name="permintaanproduct_id" value="<?=$permintaanproduct->permintaanproduct_id;?>"/>
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
