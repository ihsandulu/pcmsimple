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
				<li class="active">Customer Group</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<?php if(isset($_GET['daurulang'])&&!isset($_POST['new'])&&!isset($_POST['edit'])){$coltitle="col-md-8";}else{$coltitle="col-md-10";}?>
			<div class="<?=$coltitle;?>">
				<h1 class="page-header"> Customer Group</h1>
			</div>
			<?php if(isset($_GET['daurulang'])){?>
			<form method="post" class="col-md-2">							
				<h1 class="page-header col-md-12"> 
				<button onClick="tutup()" class="btn btn-danger btn-block btn-lg" value="OK" style="">Close</button>
				<script>
				function tutup(){
					window.opener.location.reload();
					window.close();
				}
				</script>
				</h1>
			</form>
			<?php }?>
			<?php if(!isset($_POST['new'])&&!isset($_POST['edit'])){?>
			<form method="post" class="col-md-2">							
				<h1 class="page-header col-md-12"> 
				<button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
				<input type="hidden" name="grup_id"/>
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
							<?php if(isset($_POST['edit'])){$namabutton='name="change"';$judul="Update Group";}else{$namabutton='name="create"';$judul="Add Group";}?>	
							<div class="lead"><h3><?=$judul;?></h3></div>
							<form class="form-horizontal" method="post" enctype="multipart/form-data">
								
							<div class="form-group">
								<label class="control-label col-sm-2" for="unit_id">Group:</label>
								<div class="col-sm-10">
									 <input type="text" autofocus class="form-control" id="grup_name" name="grup_name" placeholder="" value="<?=$grup_name;?>">
								  
								</div>
							  </div>
							  
							  
							  <input type="hidden" name="grup_id" value="<?=$grup_id;?>"/>					  					  
							  <div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" id="submit" class="btn btn-primary col-md-5" <?=$namabutton;?> value="OK">Submit</button>
									<button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?=site_url("grup");?>">Back</button>
								</div>
							  </div>
							</form>
						</div>
						<?php }else{?>	
							<?php if($message!=""){?>
							<div class="alert alert-info alert-dismissable">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong><?=$message;?></strong><br/><?=$uploadgrup_picture;?>
							</div>
							<?php }?>
							<div class="box">
								<div id="collapse4" class="body table-responsive">				
								<table id="dataTable" class="table table-condensed table-hover">
									<thead>
										<tr>
											<th>No.</th>
											<th>Group</th>
											<th class="col-md-2">Action</th>
										</tr>
									</thead>
									<tbody> 
										<?php $usr=$this->db
										->order_by("grup_id","desc")
										->get("grup");
										$no=1;
										foreach($usr->result() as $grup){?>
										<tr>			
											<td><?=$no++;?></td>								
											<td><?=$grup->grup_name;?></td>
											<td style="padding-left:0px; padding-right:0px;">																			
												<form method="POST" class="" style="padding:0px; margin:2px; float:left;">
												  <a data-toggle="tooltip" title="Group Members" target="_blank" href="<?=site_url("grupd?grup_id=".$grup->grup_id);?>" class="btn btn-sm btn-info " name="edit" value="OK">
												  <span class="fa fa-address-book" style="color:white;"></span>												  </a>
												</form> 
												
												<form method="post" class="" style="padding:0px; margin:2px; float:left;">
													<button class="btn btn-sm btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
													<input type="hidden" name="grup_id" value="<?=$grup->grup_id;?>"/>
												</form>
											
												<form method="post" class="" style="padding:0px; margin:2px; float:left;">
													<button class="btn btn-sm btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
													<input type="hidden" name="grup_id" value="<?=$grup->grup_id;?>"/>
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
