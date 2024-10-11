<!doctype html>
<html>

<head>
    <?php 	
	require_once("meta.php");
	$dari=date("Y-m-d");
	$ke=date("Y-m-d");
	if(isset($_REQUEST["dari"])){
		$dari=$_REQUEST["dari"];
		$ke=$_REQUEST["ke"];
	}
	?>
</head>

<body class="  " >
	<?php require_once("header.php");?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">Out Mail</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-10">
				<h1 class="page-header"> Out Mail</h1>
			</div>
			<?php if(!isset($_POST['new'])&&!isset($_POST['edit'])&&!isset($_GET['report'])){?>
			<form method="post" class="col-md-2">							
				<h1 class="page-header col-md-12"> 
				<button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
				<input type="hidden" name="suratkeluar_id"/>
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
							<?php if(isset($_POST['edit'])){$namabutton='name="change"';$judul="Update Out Mail";}else{$namabutton='name="create"';$judul="New Out Mail";}?>	
							<div class="lead"><h3><?=$judul;?></h3></div>
							<form class="form-horizontal" method="post" enctype="multipart/form-data">
							  <div class="form-group">
								<label class="control-label col-sm-2" for="suratkeluar_title">Out Mail Title:</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control" id="suratkeluar_title" name="suratkeluar_title" placeholder="Enter Title" value="<?=$suratkeluar_title;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="suratkeluar_user">User:</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control" id="suratkeluar_user" name="suratkeluar_user" placeholder="Enter User" value="<?=$suratkeluar_user;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="suratkeluar_remarks">Remarks:</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control" id="suratkeluar_remarks" name="suratkeluar_remarks" placeholder="Enter Remarks" value="<?=$suratkeluar_remarks;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="suratkeluar_date">Date:</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control date" id="suratkeluar_date" name="suratkeluar_date" placeholder="YYYY-mm-dd" value="<?=$suratkeluar_date;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="suratkeluar_content">Content:</label>
								<div class="col-sm-10">
								  <textarea type="text" autofocus class="form-control" id="suratkeluar_content" name="suratkeluar_content" ><?=$suratkeluar_content;?></textarea>
                                  <script>
								   CKEDITOR.replace( 'suratkeluar_content' );
								  </script>
								</div>
							  </div>
							 							  
							  <input type="hidden" name="suratkeluar_id" value="<?=$suratkeluar_id;?>"/>					  					  
							  <div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" id="submit" class="btn btn-primary col-md-5" <?=$namabutton;?> value="OK">Submit</button>
									<button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?=site_url("suratkeluar");?>">Back</button>
								</div>
							  </div>
							</form>
						</div>
						<?php }else{?>	
							<?php if($message!=""){?>
							<div class="alert alert-info alert-dismissable">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong><?=$message;?></strong><br/><?=$uploadsuratkeluar_picture;?>
							</div>
							<?php }?>
							<div class="box">
                                <div style="margin-bottom:30px; border-radius:5px; background-color:#FEEFC2; padding:15px;">
                                <form class="form-inline">
                                  <div class="form-group">
                                    <label for="email">From:</label>
                                    <input type="text" class="form-control date" name="dari" value="<?=$dari;?>">
                                  </div>
                                  <div class="form-group">
                                    <label for="pwd">To:</label>
                                    <input type="text" class="form-control date" name="ke" value="<?=$ke;?>">
                                  </div>
                                  <?php if(isset($_GET['report'])){?>
                                    <input type="hidden" name="report" value="ok">
                                 <?php }?>
                                  <button style="margin-right:30px;" type="submit" class="btn btn-default">Search</button>
                                  <?php if(isset($_GET['report'])){?>
                                  <a target="_blank" href="<?=site_url("suratkeluar_list_print?&dari=".$dari."&ke=".$ke);?>" class="btn btn-success fa fa-print"></a>                <?php }?>               
                                </form>
                            
                                </div>
								<div id="collapse4" class="body table-responsive">				
								<table id="dataTable" class="table table-condensed table-hover">
									<thead>
										<tr>
											<th>No.</th>
											<th>Date</th>
											<th>Branch</th>
											<th>Title</th>
											<th>User</th>
											<th>Remarks</th>
                                            <?php if(!isset($_GET['report'])){?>
											<th class="col-md-2">Action</th>
                                            <?php }?>
										</tr>
									</thead>
									<tbody> 
										<?php $usr=$this->db
										->join("branch","branch.branch_id=suratkeluar.branch_id","left")
										->where("suratkeluar_date >=",$dari)
										->where("suratkeluar_date <=",$ke)
										->order_by("suratkeluar_id","desc")
										->get("suratkeluar");
										$no=1;
										foreach($usr->result() as $suratkeluar){?>
										<tr>			
											<td><?=$no++;?></td>								
											<td><?=$suratkeluar->suratkeluar_date;?></td>
											<td><?=$suratkeluar->branch_name;?></td>
											<td><?=$suratkeluar->suratkeluar_title;?></td>
											<td><?=$suratkeluar->suratkeluar_user;?></td>
											<td><?=$suratkeluar->suratkeluar_remarks;?></td>
                                             <?php if(!isset($_GET['report'])){?>
											<td style="padding-left:0px; padding-right:0px;">
												
												<form method="post" class="col-md-4" style="padding:0px;">
													<a target="_blank" href="<?=site_url("suratkeluar_print?suratkeluar_no=".$suratkeluar->suratkeluar_no);?>" class="btn  btn-success"><span class="fa fa-print" style="color:white;"></span> </a>													
												</form>
                                                
                                                <form method="post" class="col-md-4" style="padding:0px;">
													<button class="btn  btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
													<input type="hidden" name="suratkeluar_id" value="<?=$suratkeluar->suratkeluar_id;?>"/>
												</form>
											
												<form method="post" class="col-md-4" style="padding:0px;">
													<button class="btn  btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
													<input type="hidden" name="suratkeluar_id" value="<?=$suratkeluar->suratkeluar_id;?>"/>
												</form>											
                                            </td>
                                            <?php }?>
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
