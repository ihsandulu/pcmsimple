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
				<li class="active">SJ Masuk</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-10">
				<h1 class="page-header"> SJ Masuk</h1>
			</div>
			<?php if(!isset($_POST['new'])&&!isset($_POST['edit'])&&!isset($_GET['report'])){?>
			<form method="POST" class="col-md-2">							
				<h1 class="page-header col-md-12"> 
				<button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
				<input type="hidden" name="sjmasuk_id"/>
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
							<?php if(isset($_POST['edit'])){$namabutton='name="change"';$judul="Update SJ Masuk";}else{$namabutton='name="create"';$judul="Create SJ Masuk";}?>	
							<div class="lead"><h3><?=$judul;?></h3></div>
							<form class="form-horizontal" method="POST" enctype="multipart/form-data">
							  <div class="form-group">
								<label class="control-label col-sm-2" for="supplier_id">Supplier / Makloon:</label>
								<div class="col-sm-10">
								  <select name="supplier_id" class="form-control" required>
								  <option value="">Select Supplier / Makloon</option>
								  <?php 
								  $t=array("","Supplier","Makloon");
								  $prod=$this->db->get("supplier");
								  foreach($prod->result() as $supplier){?>
								  <option value="<?=$supplier->supplier_id;?>" <?php if($supplier_id==$supplier->supplier_id){?>selected="selected"<?php }?>>
								  	 <?=$supplier->supplier_name;?> ( <?=$t[$supplier->supplier_type];?> )
								  </option>
								  <?php }?>
								  </select>
								</div>
							  </div>
													  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="sjmasuk_no">SJ No:</label>
								<div class="col-sm-10">
								  <input type="text" class="form-control" name="sjmasuk_no" id="sjmasuk_no" value="<?=($sjmasuk_no!="")?$sjmasuk_no:"SJM".date("YmdHis");?>"/>
								</div>
							  </div>	
													  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="sjmasuk_pengirim">Pengirim:</label>
								<div class="col-sm-10">
								  <input type="text" class="form-control" name="sjmasuk_pengirim" id="sjmasuk_pengirim" value="<?=$sjmasuk_pengirim;?>"/>
								</div>
							  </div>	
							  				  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="sjmasuk_penerima">Penerima:</label>
								<div class="col-sm-10">
								  <input type="text" class="form-control" name="sjmasuk_penerima" id="sjmasuk_penerima" value="<?=$sjmasuk_penerima;?>"/>
								</div>
							  </div>
							  
							   <div class="form-group">
								<label class="control-label col-sm-2" for="sjmasuk_date">Date:</label>
								<div class="col-sm-10">
								  <input type="text" class="form-control date" name="sjmasuk_date" id="sjmasuk_date" value="<?=$sjmasuk_date;?>"/>
								</div>
							  </div>	
							  				  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="sjmasuk_ekspedisi">Ekspedisi:</label>
								<div class="col-sm-10">
								  <input type="text" class="form-control" name="sjmasuk_ekspedisi" id="sjmasuk_ekspedisi" value="<?=$sjmasuk_ekspedisi;?>"/>
								</div>
							  </div>
							 
							 <div class="form-group">
								<label class="control-label col-sm-2" for="sjmasuk_picture">Upload SJ:</label>
								<div class="col-sm-10" align="left"> 
								  <input type="file" id="sjmasuk_picture" name="sjmasuk_picture"><br/>
								<?php if($sjmasuk_picture!=""){$user_image="assets/images/sjmasuk_picture/".$sjmasuk_picture;}else{$user_image="assets/img/user.gif";}?>  
								</div>
							  </div>
							 
							 <input class="form-control" type="hidden" name="sjmasuk_id" id="sjmasuk_id" value="<?=$sjmasuk_id;?>"/>
							  <input class="form-control" type="hidden" name="branch_id" id="branch_id" value="<?=$this->session->userdata("branch_id");?>"/>					  					  
							  <div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" id="submit" class="btn btn-primary col-md-5" <?=$namabutton;?> value="OK">Submit</button>
									<button type="button" class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href='<?=site_url("sjmasuk");?>'">Back</button>
								</div>
							  </div>
							</form>
						</div>
						<?php }else{?>	
							<?php if($message!=""){?>
							<div class="alert alert-info alert-dismissable">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong><?=$message;?></strong><br/><?=$uploadsjmasuk_picture;?>
							</div>
							<?php }?>
							<div class="box">
								<div id="collapse4" class="body table-ressjmasuknsive">				
								<table id="dataTable" class="table table-condensed table-hover">
									<thead>
										<tr>
											<th>No.</th>
											<th>Date</th>
											<th>Branch</th>
											<th>SJ Masuk No. </th>
											<th>Supplier</th>
											<?php if(!isset($_GET['report'])){$col="col-md-3";}else{$col="col-md-1";}?>
											<th class="<?=$col;?>">Action</th>
										</tr>
									</thead>
									<tbody> 
										<?php $usr=$this->db
										->join("branch","branch.branch_id=sjmasuk.branch_id","left")
										->join("supplier","supplier.supplier_id=sjmasuk.supplier_id","left")
										->order_by("sjmasuk_id","desc")
										->get("sjmasuk");
										$no=1;
										foreach($usr->result() as $sjmasuk){?>
										<tr>	
											<td><?=$no++;?></td>										
											<td><?=$sjmasuk->sjmasuk_date;?></td>					
											<td><?=$sjmasuk->branch_name;?></td>
											<td><?=$sjmasuk->sjmasuk_no;?></td>
											<td><?=$sjmasuk->supplier_name;?></td>
											<td style="text-align:center; "> 
											<?php if(!isset($_GET['report'])){$float="float:right;";?>  									
												<form method="POST" class="" style="padding:0px; margin:2px; float:right;">
													<button data-toggle="tooltip" title="Delete" class="btn btn-sm btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
													<input type="hidden" name="sjmasuk_no" value="<?=$sjmasuk->sjmasuk_no;?>"/>
													<input type="hidden" name="sjmasuk_id" value="<?=$sjmasuk->sjmasuk_id;?>"/>
												</form>	                                      											
												<form method="POST" class="" style="padding:0px; margin:2px; float:right;">
													<button data-toggle="tooltip" title="Edit" class="btn btn-sm btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
													<input type="hidden" name="sjmasuk_id" value="<?=$sjmasuk->sjmasuk_id;?>"/>
												</form>	
											<?php }else{$float="";}?>										
												<form method="POST" class="" style="padding:0px; margin:2px; <?=$float;?>">
												  <a data-toggle="tooltip" title="Print SJ Masuk" target="_blank" href="<?=site_url("printpdf?type=image&url=".site_url("assets/images/sjmasuk_picture/".$sjmasuk->sjmasuk_picture));?>" class="btn btn-sm btn-success " name="edit" value="OK"> 
												  <span class="fa fa-print" style="color:white;"></span> 
												  </a>
												</form>  
											<?php if(!isset($_GET['report'])){?>  
												<form method="POST" class="" style="padding:0px; margin:2px; float:right;">
												  <a data-toggle="tooltip" title="List Product" target="_blank" href="<?=site_url("sjmasukproduct?sjmasuk_no=".$sjmasuk->sjmasuk_no)."&supplier_id=".$sjmasuk->supplier_id;?>" class="btn btn-sm btn-info " name="edit" value="OK">
												  <span class="fa fa-shopping-bag" style="color:white;"></span>											  </a>
												</form> 
												<form method="POST" class="" style="padding:0px; margin:2px; float:right;">
												   <a href="<?=base_url("assets/images/sjmasuk_picture/".$sjmasuk->sjmasuk_picture);?>" target="_blank" data-toggle="tooltip" title="Scan Invoice"  type="button" class="btn btn-default" id="myBtn"><span class="fa fa-file-image-o" style="color:white;"></span></a>
												</form> 
											<?php }?>		
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
