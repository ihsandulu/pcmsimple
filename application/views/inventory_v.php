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
				<li class="active">Inventory</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-10">
				<h1 class="page-header"> Inventory</h1>
			</div>
			<?php if(!isset($_POST['new'])&&!isset($_POST['edit'])){?>
			<form method="post" class="col-md-2">							
				<h1 class="page-header col-md-12"> 
				<button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
				<input type="hidden" name="inventory_id"/>
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
							<?php if(isset($_POST['edit'])){$namabutton='name="change"';$judul="Update Inventory";}else{$namabutton='name="create"';$judul="New Inventory";}?>	
							<div class="lead"><h3><?=$judul;?></h3></div>
							<form class="form-horizontal" method="post" enctype="multipart/form-data">
							  <div class="form-group">
								<label class="control-label col-sm-2" for="inventory_name">Inventory Name:</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control" id="inventory_name" name="inventory_name" placeholder="Enter Name" value="<?=$inventory_name;?>">
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
								<label class="control-label col-sm-2" for="inventory_minimal">Minimum:</label>
								<div class="col-sm-10">
								  <input type="number" min="1" autofocus class="form-control" id="inventory_minimal" name="inventory_minimal" placeholder="Enter Minimum Count" value="<?=($inventory_minimal>0)?$inventory_minimal:"1";?>">
								</div>
							  </div>							  
							  
							  <div class="form-group">
                                        <label class="control-label col-sm-2" for="inventory_picture">Picture:</label>
                                        <div class="col-sm-10" align="left"> 
                                          <input type="file"  id="inventory_picture" name="inventory_picture"><br/>
                                        <?php if($inventory_picture!=""){$user_image="assets/images/inventory_picture/".$inventory_picture;}else{$user_image="assets/images/inventory_picture/noimage.png";}?>
                                          <img id="inventory_picture_image" width="100" height="100" src="<?=base_url($user_image);?>"/>
                                          <script>
                                            function readURL(input) {
                                                if (input.files && input.files[0]) {
                                                    var reader = new FileReader();
                                        
                                                    reader.onload = function (e) {
                                                        $('#inventory_picture_image').attr('src', e.target.result);
                                                    }
                                        
                                                    reader.readAsDataURL(input.files[0]);
                                                }
                                            }
                                        
                                            $("#inventory_picture").change(function () {
                                                readURL(this);
                                            });
                                          </script>
                                        </div>
                                      </div>

							  
							  <input type="hidden" name="inventory_id" value="<?=$inventory_id;?>"/>					  					  
							  <div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" id="submit" class="btn btn-primary col-md-5" <?=$namabutton;?> value="OK">Submit</button>
									<button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?=site_url("inventory");?>">Back</button>
								</div>
							  </div>
							</form>
						</div>
						<?php }else{?>	
							<?php if($message!=""){?>
							<div class="alert alert-info alert-dismissable">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong><?=$message;?></strong><br/><?=$uploadinventory_picture;?>
							</div>
							<?php }?>
							<div class="box">
								<div id="collapse4" class="body table-responsive">				
								<table id="dataTable" class="table table-condensed table-hover">
									<thead>
										<tr>
											<th>No.</th>
											<th>Inventory</th>
											<th>Unit</th>
											<th class="col-md-1">Minimum</th>
											<th class="col-md-1">Picture</th>
											<th class="col-md-1">Action</th>
										</tr>
									</thead>
									<tbody> 
										<?php $usr=$this->db
										->join("unit","unit.unit_id=inventory.unit_id","left")
										->order_by("inventory_id","desc")
										->get("inventory");
										$no=1;
										foreach($usr->result() as $inventory){?>
										<tr>						
											<td><?=$no++;?></td>					
											<td><?=$inventory->inventory_name;?></td>
											<td><?=$inventory->unit_name;?></td>
											<td><?=$inventory->inventory_minimal;?></td>
											<td>
											<?php if($inventory->inventory_picture!=""){$gambar=$inventory->inventory_picture;}else{$gambar="noimage.png";}?>
											<img onClick="tampil(this)" src="<?=base_url("assets/images/inventory_picture/".$gambar);?>" style="width:20px; height:20px;">
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
													<input type="hidden" name="inventory_id" value="<?=$inventory->inventory_id;?>"/>
												</form>
											
												<form method="post" class="col-md-6" style="padding:0px;">
													<button class="btn btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
													<input type="hidden" name="inventory_id" value="<?=$inventory->inventory_id;?>"/>
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
