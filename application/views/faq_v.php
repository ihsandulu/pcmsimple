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
				<li class="active">Faq</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<?php if(isset($_GET['daurulang'])&&!isset($_POST['new'])&&!isset($_POST['edit'])){$coltitle="col-md-8";}else{$coltitle="col-md-10";}?>
			<div class="<?=$coltitle;?>">
				<h1 class="page-header"> Faq</h1>
			</div>
			<?php if(isset($_GET['report'])){?>
			<form method="post" class="col-md-2">							
				<h1 class="page-header col-md-12"> 
				<a href="<?=site_url("saran");?>" class="btn btn-danger btn-block btn-lg" value="OK" style="">Suggestion</a>
				
				</h1>
			</form>
			<?php }?>
			<?php if(!isset($_POST['new'])&&!isset($_POST['edit'])&&!isset($_GET['report'])){?>
			<form method="post" class="col-md-2">							
				<h1 class="page-header col-md-12"> 
				<button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
				<input type="hidden" name="faq_id"/>
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
							<?php if(isset($_POST['edit'])){$namabutton='name="change"';$judul="Update Faq";}else{$namabutton='name="create"';$judul="Add Faq";}?>	
							<div class="lead"><h3><?=$judul;?></h3></div>
							<form class="form-horizontal" method="post" enctype="multipart/form-data">
								
							<div class="form-group">
								<label class="control-label col-sm-2" for="faq_tanya">Question:</label>
								<div class="col-sm-10">
									 <input type="text" autofocus class="form-control" id="faq_tanya" name="faq_tanya" placeholder="" value="<?=$faq_tanya;?>">
								  
								</div>
							  </div>
								
							<div class="form-group">
								<label class="control-label col-sm-2" for="faq_jawab">Answer:</label>
								<div class="col-sm-10">
									 <input type="text" autofocus class="form-control" id="faq_jawab" name="faq_jawab" placeholder="" value="<?=$faq_jawab;?>">
								  
								</div>
							  </div>
							  
							  
							  <input type="hidden" name="faq_id" value="<?=$faq_id;?>"/>					  					  
							  <div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" id="submit" class="btn btn-primary col-md-5" <?=$namabutton;?> value="OK">Submit</button>
									<button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?=site_url("faq");?>">Back</button>
								</div>
							  </div>
							</form>
						</div>
						<?php }else{?>	
							<?php if($message!=""){?>
							<div class="alert alert-info alert-dismissable">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong><?=$message;?></strong><br/><?=$uploadfaq_picture;?>
							</div>
							<?php }?>
							<div class="box">
								<div id="collapse4" class="body table-responsive">				
								<table id="dataTable" class="table table-condensed table-hover">
									<thead>
										<tr>
											<th>No.</th>
											<th>Question</th>
											<th>Answer</th>
											<?php if(!isset($_GET["report"])){?>
											<th class="col-md-2">Action</th>
											<?php }?>
										</tr>
									</thead>
									<tbody> 
										<?php $usr=$this->db
										->order_by("faq_id","desc")
										->get("faq");
										$no=1;
										foreach($usr->result() as $faq){?>
										<tr>			
											<td><?=$no++;?></td>								
											<td><?=$faq->faq_tanya;?></td>						
											<td><?=$faq->faq_jawab;?></td>
											<?php if(!isset($_GET["report"])){?>
											<td style="padding-left:0px; padding-right:0px;">																			
												
												<form method="post" class="" style="padding:0px; margin:2px; float:left;">
													<button class="btn btn-sm btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
													<input type="hidden" name="faq_id" value="<?=$faq->faq_id;?>"/>
												</form>
											
												<form method="post" class="" style="padding:0px; margin:2px; float:left;">
													<button class="btn btn-sm btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
													<input type="hidden" name="faq_id" value="<?=$faq->faq_id;?>"/>
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
	
	<!-- /#wrap -->
	<?php require_once("footer.php");?>
</body>

</html>
