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
				<li class="active">Product</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-8">
				<h1 class="page-header"> Product</h1>
			</div>
		</div><!--/.row-->
		
		
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
				
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
											<th>Picture</th>
											<th class="col-md-1">Action</th>
										</tr>
									</thead>
									<tbody> 
										<?php 										
										$usr=$this->db															
										->get("product");
										//echo $this->db->last_query();
										$no=1;
										foreach($usr->result() as $product){										
										?>
										<tr>
											<td><?=$no;?></td>
										  	<td><?=$product->product_name;?></td>
											<td>
											<?php if($product->product_picture==""){$product_picture="noimage.png";}else{$product_picture=$product->product_picture;}?>
											<img onClick="tampilimg(this)" src="<?=base_url("assets/images/product_picture/".$product_picture);?>" style="width:25px; height:25px; cursor:pointer; border:grey solid 1px;"/>
											<?php if($product->product_picture!=""){?>
											&nbsp;<a class="btn btn-sm btn-warning fa fa-download" href="<?=base_url("assets/images/product_picture/".$product->product_picture);?>" target="_blank"></a>
											<?php }?>											</td>
											<td style="padding-left:0px; padding-right:0px;">	 
												<form method="POST" class="col-md-3" style="padding:0px;">
												  <a data-toggle="tooltip" title="Quotation" target="_blank" href="<?=site_url("quotation?product_id=".$product->product_id);?>" class="btn btn-sm btn-info" style="margin:0px;">
												  <span class="fa fa-clipboard" style="color:white;"></span>											  </a>
												</form> 		 
												<!--<form method="POST" class="col-md-3" style="padding:0px;">
												  <a data-toggle="tooltip" title="Print Payment" target="_blank" href="<?=site_url("productprint?nom=".$no++."&product_id=".$product->product_id);?>" class="btn btn-sm btn-success" style="margin:0px;">
												  <span class="fa fa-print" style="color:white;"></span>											  </a>
												</form> -->	
											</td>
										</tr>
										<?php }?>
									</tbody>
								</table>
								</div>
							</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /#wrap -->
	<?php require_once("footer.php");?>
</body>

</html>
