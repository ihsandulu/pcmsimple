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
				<li class="active">Task</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-8">
				<h1 class="page-header"> Task No. <?=$this->input->get("task_no");?></h1>
			</div>
			<?php if(!isset($_POST['new'])&&!isset($_POST['edit'])){?>
			<form method="post" class="col-md-4">							
				<h1 class="page-header col-md-12"> 				
				<?php if($_SESSION['position_id']==1){?>
                <button name="new" class="btn btn-info btn-lg" value="OK" style=" float:right;margin:2px;">New</button>
                <?php }?>
				<button type="button" onClick="window.opener.location.reload(); window.close(); " class="btn btn-warning btn-lg" style=" float:right; margin:2px;"> Back</button>
				<input type="hidden" name="taskproduct_id" value="0"/>
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
							<?php if(isset($_POST['edit'])){$namabutton='name="change"';$judul="Update Task";}else{$namabutton='name="create"';$judul="New Task";}?>	
							<div class="lead"><h3><?=$judul;?></h3></div>
							<form class="form-horizontal" method="post" enctype="multipart/form-data">
							  <div class="form-group">
								<label class="control-label col-sm-2" for="unit_id">Task:</label>
								<div class="col-sm-10">
									<datalist id="product">
										<?php $uni=$this->db
										  ->join("product","product.product_id=customerproduct.product_id","left")
										  ->where("product.product_type","1")
										  ->where("customer_id",$this->input->get("customer_id"))
										  ->get("customerproduct");
										  //$t= $this->db->last_query();
										  foreach($uni->result() as $cusprod){?>											
										  <option id="<?=$cusprod->product_id;?>" value="<?=$cusprod->product_name;?> (Rp.<?=number_format($cusprod->customerproduct_price,0,",",".");?>)">
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
							 
							  <input type="hidden" name="taskproduct_id" value="<?=$taskproduct_id;?>"/>	
							  <input type="hidden" name="task_no" value="<?=$this->input->get("task_no");?>"/>					  					  
							  <div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" id="submit" class="btn btn-primary col-md-5" <?=$namabutton;?> value="OK">Submit</button>
									<button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?=site_url("taskproduct");?>">Back</button>
								</div>
							  </div>
							</form>
						</div>
						<?php }else{?>	
							<?php if($message!=""){?>
							<div class="alert alert-info alert-dismissable">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong><?=$message;?></strong><br/><?=$uploadtaskproduct_picture;?>
							</div>
							<?php }?>
							<div class="box">
								<div id="collapse4" class="body table-responsive">				
								<table id="dataTable" class="table table-condensed table-hover table-bordered">
									<thead>
										<tr>
											<th>No.</th>
										  <th>Date Task Done</th>
											<th>Task</th>
											<th>Picture</th>
                                            <?php if(!isset($_GET["report"])){?> 
											<th class="col-md-5">Action</th>
                                            <?php }?>
										</tr>
									</thead>
									<tbody> 
										<?php $usr=$this->db
										->join("product","product.product_id=taskproduct.product_id","left")
										->where("task_no",$this->input->get("task_no"))
										->order_by("taskproduct_id","desc")
										->get("taskproduct");
										$no=1;
										//echo $this->db->last_query();
										foreach($usr->result() as $taskproduct){
										if($taskproduct->taskproduct_qty==1){$warna="background-color:#BAFFC9;"; $status="Done";}else{$warna="background-color:#FFB3BA;"; $status="";}?>
										<tr style="<?=$warna;?>">
											<td><?=$no++;?></td>
										  <td><?=$taskproduct->taskproduct_date;?></td>											
											<td><?=$taskproduct->product_name;?></td>
											<td>
                                            
											<?php if($taskproduct->taskproduct_picture==""){$taskproduct_picture="noimage.png";}else{$taskproduct_picture=$taskproduct->taskproduct_picture;}?>
											<img onClick="tampilimg(this)" src="<?=base_url("assets/images/taskproduct_picture/".$taskproduct_picture);?>" style="width:25px; height:25px; cursor:pointer; border:grey solid 1px;"/>
											<?php if($taskproduct->taskproduct_picture!=""){?>
											&nbsp;<a class="btn btn-sm btn-warning fa fa-download" href="<?=base_url("assets/images/taskproduct_picture/".$taskproduct->taskproduct_picture);?>" target="_blank"></a>
											<?php }?> 
                                            </td>
                                            <?php if(!isset($_GET["report"])){?> 
											<td style="padding-left:5px; padding-right:10px;">												
											<?php if($taskproduct->taskproduct_qty==0){?>
												<form enctype="multipart/form-data" method="post" class="col-md-12" style="padding:0px;">
                                                	<input type="file" name="taskproduct_picture" class="col-md-4" style="height:32px; border:groove 1px;"/>
                                                    <input type="text" name="taskproduct_date" class=" col-md-offset-1 col-md-4 date" placeholder="Date" style="height:32px;"/>
													<button class="btn btn-success col-md-offset-1 col-md-2" name="change" value="OK"><span class="fa fa-check-square-o" style="color:white;"></span> </button>
													<input type="hidden" name="taskproduct_qty" value="1"/>
													<input type="hidden" name="taskproduct_id" value="<?=$taskproduct->taskproduct_id;?>"/>
												</form>		
												<?php }else{?>	
												Done
												<?php }?>											</td>
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
