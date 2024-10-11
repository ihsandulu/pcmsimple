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
				<li class="active">Permintaan Barang</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-10">
				<h1 class="page-header"> Permintaan Barang</h1>
			</div>
			<?php if(!isset($_POST['new'])&&!isset($_POST['edit'])){?>
			<form method="POST" class="col-md-2">							
				<h1 class="page-header col-md-12"> 
				<button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
				<input type="hidden" name="permintaan_id"/>
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
							<?php if(isset($_POST['edit'])){$namabutton='name="change"';$judul="Update Permintaan Barang";}else{$namabutton='name="create"';$judul="Create Permintaan Barang";}?>	
							<div class="lead"><h3><?=$judul;?></h3></div>
							<form class="form-horizontal" method="POST" enctype="multipart/form-data">
								<?php if(isset($_POST['edit'])){?>
								<div class="form-group">
								<label class="control-label col-sm-2" for="permintaan_no1">No.:</label>
                                <div class="col-sm-10" align="left">
									  <input type="text" id="permintaan_no" name="permintaan_no" class="form-control" value="<?=$permintaan_no;?>">
								</div>
                              </div>
							  <?php }?>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="branch_id">Branch:</label>
								<div class="col-sm-10">
								  <select name="branch_id" class="form-control" required>
								  <option value="">Select Branch</option>
								  <?php $prod=$this->db->get("branch");
								  foreach($prod->result() as $branch){?>
								  <option value="<?=$branch->branch_id;?>" <?php if($branch_id==$branch->branch_id){?>selected="selected"<?php }?>>
								  	<?=$branch->branch_name;?>
								  </option>
								  <?php }?>
								  </select>
								</div>
							  </div>
													  
							  	
													  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="permintaan_catatan">Note:</label>
								<div class="col-sm-10">
								  <textarea type="text" class="form-control" name="permintaan_catatan" id="permintaan_catatan" /><?=$permintaan_catatan;?></textarea>	
								  <script>
									var roxyFileman = '<?=site_url("fileman/index.html");?>'; 
									  CKEDITOR.replace(
										'permintaan_catatan',{filebrowserBrowseUrl:roxyFileman,
																	filebrowserImageBrowseUrl:roxyFileman+'?type=image',
																	removeDialogTabs: 'link:upload;image:upload',
																	height: '200px',
																	stylesSet: 'my_custom_style'}
									); 
									</script>
								</div>
							  </div>	
							  				  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="permintaan_pengerjaan">Processing Time:</label>
								<div class="col-sm-10">
								  <input type="text" class="form-control" name="permintaan_pengerjaan" id="permintaan_pengerjaan" value="<?=$permintaan_pengerjaan;?>"/>
								</div>
							  </div>
							  
							   <div class="form-group">
								<label class="control-label col-sm-2" for="permintaan_date">Date:</label>
								<div class="col-sm-10">
								  <input type="text" class="form-control date" name="permintaan_date" id="permintaan_date" value="<?=$permintaan_date;?>"/>
								</div>
							  </div>	
							  				  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="permintaan_tukang">Worker:</label>
								<div class="col-sm-10">
								  <input type="text" class="form-control" name="permintaan_tukang" id="permintaan_tukang" value="<?=$permintaan_tukang;?>"/>
								</div>
							  </div>
							  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="permintaan_pemakaian">Actual Usage of Goods:</label>
								<div class="col-sm-10">
								  <textarea type="text" class="form-control" name="permintaan_pemakaian" id="permintaan_pemakaian" /><?=$permintaan_pemakaian;?></textarea>	
								  <script>
									var roxyFileman = '<?=site_url("fileman/index.html");?>'; 
									  CKEDITOR.replace(
										'permintaan_pemakaian',{filebrowserBrowseUrl:roxyFileman,
																	filebrowserImageBrowseUrl:roxyFileman+'?type=image',
																	removeDialogTabs: 'link:upload;image:upload',
																	height: '200px',
																	stylesSet: 'my_custom_style'}
									); 
									</script>
								</div>
							  </div>	
							  
							  
							  				  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="permintaan_retensi">Retention Time:</label>
								<div class="col-sm-10">
								  <input type="text" class="form-control" name="permintaan_retensi" id="permintaan_retensi" value="<?=$permintaan_retensi;?>"/>
								</div>
							  </div>
							 
							 
							 
							 <input class="form-control" type="hidden" name="permintaan_id" id="permintaan_id" value="<?=$permintaan_id;?>"/>	
							 <input class="form-control" type="hidden" name="branch_id" id="branch_id" value="<?=$this->session->userdata("branch_id");?>"/>					  					  				  					  
							  <div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" id="submit" class="btn btn-primary col-md-5" <?=$namabutton;?> value="OK">Submit</button>
									<a type="button" class="btn btn-warning col-md-offset-1 col-md-5" href="<?=site_url("permintaan");?>">Back</a>
								</div>
							  </div>
							</form>
						</div>
						<?php }else{?>	
							<?php if($message!=""){?>
							<div class="alert alert-info alert-dismissable">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong><?=$message;?></strong><br/><?=$uploadpermintaan_picture;?>
							</div>
							<?php }?>
							<div class="box">
								<div id="collapse4" class="body table-respermintaannsive">				
								<table id="dataTable" class="table table-condensed table-hover">
									<thead>
										<tr>
											<th>No.</th>
											<th>Date</th>
											<th>Aimed For</th>
											<th>No. Request</th>
											<th>Processing Time</th>
											<th>Retensi</th>
											<?php if(!isset($_GET['report'])){$col="col-md-3";}else{$col="col-md-1";}?>
											<th class="<?=$col;?>">Action</th>
										</tr>
									</thead>
									<tbody> 
										<?php $usr=$this->db
										->join("branch","branch.branch_id=permintaan.branch_id","left")
										->order_by("permintaan_id","desc")
										->get("permintaan");
										$no=1;
										foreach($usr->result() as $permintaan){?>
										<tr>	
											<td><?=$no++;?></td>										
											<td><?=$permintaan->permintaan_date;?></td>		
											<td><?=$permintaan->branch_name;?></td>	
											<td><?=$permintaan->permintaan_no;?></td>
											<td><?=$permintaan->permintaan_pengerjaan;?></td>
											<td><?=$permintaan->permintaan_retensi;?></td>
											<td style="text-align:center; ">  
											<?php if(!isset($_GET['report'])){$float="float:right;";?>   									
												<form method="POST" class="" style="padding:0px; margin:2px; float:right;">
													<button data-toggle="tooltip" title="Delete" class="btn btn-sm btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
													<input type="hidden" name="permintaan_no" value="<?=$permintaan->permintaan_no;?>"/>
												</form>	                                      											
												<form method="POST" class="" style="padding:0px; margin:2px; float:right;">
													<button data-toggle="tooltip" title="Edit" class="btn btn-sm btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
													<input type="hidden" name="permintaan_id" value="<?=$permintaan->permintaan_id;?>"/>
												</form>	
											<?php }else{$float="";}?>											
												<form method="POST" class="" style="padding:0px; margin:2px; <?=$float;?>">
												  <a data-toggle="tooltip" title="Print Invoice" target="_blank" href="<?=site_url("permintaanprint?permintaan_id=".$permintaan->permintaan_id."&permintaan_no=".$permintaan->permintaan_no)."&branch_id=".$permintaan->branch_id;?>" class="btn btn-sm btn-success " name="edit" value="OK"> 
												  <span class="fa fa-print" style="color:white;"></span> 
												  </a>
												</form>  
											<?php if(!isset($_GET['report'])){?>  
												<form method="POST" class="" style="padding:0px; margin:2px; float:right;">
												  <a data-toggle="tooltip" title="List Product" target="_blank" href="<?=site_url("permintaanproduct?permintaan_id=".$permintaan->permintaan_id."&permintaan_no=".$permintaan->permintaan_no)."&branch_id=".$permintaan->branch_id;?>" class="btn btn-sm btn-info " name="edit" value="OK">
												  <span class="fa fa-shopping-bag" style="color:white;"></span>											  </a>
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
