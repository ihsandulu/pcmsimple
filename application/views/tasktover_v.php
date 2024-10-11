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
				<h1 class="page-header"> Task</h1>
			</div>
			<?php if(!isset($_POST['new'])&&!isset($_POST['edit'])){?>
			
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
										  if($uni->num_rows()>0){
										  foreach($uni->result() as $cusprod){?>											
										  <option id="<?=$cusprod->product_id;?>" value="<?=$cusprod->product_name;?> (Rp.<?=number_format($cusprod->customerproduct_price,0,",",".");?>)">
										<?php }
										}else{?>
										<option value="Tidak ada product jasa, harap isi product jasa pada menu master > customer ">
										<?php }?>
									</datalist>	
									
									<input onChange="productid(this)" class="form-control" list="product" value="<?=$product_name;?>">	
									<input type="hidden" list="product" id="product_id" name="product_id" value="<?=$product_id;?>">
									<script>
										function productid(a){
											var opt = $('option[value="'+$(a).val()+'"]');
											$("#product_id").val(opt.attr('id'));
											if($("#product_id").val()!=""){$("#submit").removeAttr("disabled")}
										}
									</script>	
								  
								</div>
							  </div>
							 
							  <input type="hidden" name="taskproduct_id" value="<?=$taskproduct_id;?>"/>					  					  
							  <div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" id="submit" disabled="disabled" class="btn btn-primary col-md-5" <?=$namabutton;?> value="OK">Submit</button>
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
								<table id="dataTable" class="table table-condensed table-hover">
									<thead>
										<tr>
											<th>No.</th>
										  <th>Date</th>
										  <th>Task No. </th>
											<th class="text-left">Task</th>
											<th class="col-md-1">Status</th>
										</tr>
									</thead>
									<tbody> 
										<?php 
										if(isset($_GET['r'])){
											$this->db->where("taskproduct_qty","1");
										}
										if(isset($_GET['nr'])){
											$this->db->where("taskproduct_qty","0");
										}
										$usr=$this->db
										->join("task","task.task_no=taskproduct.task_no","left")
										->join("product","product.product_id=taskproduct.product_id","left")
										->where("user_id",$this->session->userdata("user_id"))
										->order_by("taskproduct_id","desc")
										->get("taskproduct");
										//echo $this->db->last_query();
										$no=1;
										foreach($usr->result() as $taskproduct){
										if($taskproduct->taskproduct_qty==1){$warna="background-color:#BAFFC9;"; $status="Done";}else{$warna="background-color:#FFB3BA;"; $status="";}?>
										<tr style="<?=$warna;?>">
											<td><?=$no++;?></td>
										  <td class="col-md-1"><?=$taskproduct->task_date;?></td>
										  <td class="col-md-1"><?=$taskproduct->task_no;?></td>											
											<td class="text-left"><?=$taskproduct->product_name;?></td>
											<td style="padding-left:0px; padding-right:0px;">
											
											<?php if($taskproduct->taskproduct_qty==0){?>
														
											<?php if(!isset($_GET['report'])){?>
												
												<?php }?>	
												<?php }else{?>	
												<form method="post" class="" style="padding:0px; margin:2px; float:right;">
													<label class="label label-defaultsuccess" style="font-size:14px; padding:15px; text-shadow:#00CC00 1px 1px 3px;"><span class="fa fa-check-square-o" style="color:white;"></span> Done</label>
												</form>	
												<?php }?>											</td>
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
