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
				<li class="active">Payment Method</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-10">
				<h1 class="page-header"> Payment Method</h1>
			</div>
			<?php if(!isset($_POST['new'])&&!isset($_POST['edit'])){?>
			<form method="POST" class="col-md-2">							
				<h1 class="page-header col-md-12"> 
				<button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
				<input type="hidden" name="methodpayment_id"/>
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
							<?php if(isset($_POST['edit'])){$namabutton='name="change"';$judul="Update Payment Method";}else{$namabutton='name="create"';$judul="Create Payment Method";}?>	
							<div class="lead"><h3><?=$judul;?></h3></div>
							<form class="form-horizontal" method="POST" enctype="multipart/form-data">
							  <div class="form-group">
								<label class="control-label col-sm-2" for="methodpayment_name">Method :</label>
								<div class="col-sm-10">
								  <input type="text" class="form-control" name="methodpayment_name" id="methodpayment_name" value="<?=$methodpayment_name;?>"/>
								</div>
							  </div>	
							  				  
							  <input class="form-control" type="hidden" name="methodpayment_id" id="methodpayment_id" value="<?=$methodpayment_id;?>"/>					  					  
							  <div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" id="submit" class="btn btn-primary col-md-5" <?=$namabutton;?> value="OK">Submit</button>
									<button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?=site_url("methodpayment");?>">Back</button>
								</div>
							  </div>
							</form>
						</div>
						<?php }else{?>	
							<?php if($message!=""){?>
							<div class="alert alert-info alert-dismissable">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong><?=$message;?></strong><br/><?=$uploadmethodpayment_picture;?>
							</div>
							<?php }?>
							<div class="box">
								<div id="collapse4" class="body table-resmethodpaymentnsive">				
								<table id="dataTable" class="table table-condensed table-hover">
									<thead>
										<tr>
											<th>No.</th>
											<th>Method</th>
											<?php if(!isset($_GET['report'])){$col="col-md-2";}else{$col="col-md-1";}?>
											<th class="<?=$col;?>">Action</th>
										</tr>
									</thead>
									<tbody> 
										<?php $usr=$this->db
										->order_by("methodpayment_id","desc")
										->get("methodpayment");
										$no=1;
										foreach($usr->result() as $methodpayment){?>
										<tr>											
											<td><?=$no++;?></td>
											<td><?=$methodpayment->methodpayment_name;?></td>
											<td style="text-align:center; ">  
											<?php if(!isset($_GET['report'])){$float="display:inline;";?>  							
												<form method="POST" class="" style="padding:0px; margin:2px; <?=$float;?>">
													<button data-toggle="tooltip" title="Edit" class="btn btn-sm btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
													<input type="hidden" name="methodpayment_id" value="<?=$methodpayment->methodpayment_id;?>"/>
												</form>	 									
												<form method="POST" class="" style="padding:0px; margin:2px; <?=$float;?>">
													<button data-toggle="tooltip" title="Delete" class="btn btn-sm btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
													<input type="hidden" name="methodpayment_id" value="<?=$methodpayment->methodpayment_id;?>"/>
												</form>	                                      				
											<?php }else{$float="";}?>											
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
