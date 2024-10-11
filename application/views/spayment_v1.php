<!doctype html>
<html>

<head>
    <?php 	
	require_once("meta.php");
	$dari=date("Y-m-d");
	$ke=date("Y-m-d");
	if(isset($_GET['from'])){$dari=$_GET['from'];}
	if(isset($_GET['to'])){$ke=$_GET['to'];}
	?>
</head>

<body class="  " >
	<?php require_once("header.php");?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">Payment Invoice Supplier</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-8">
				<h1 class="page-header"> Payment Invoice Supplier <strong style="color:#003399;"><?=date("d M Y",strtotime($dari));?></strong> to <strong style="color:#003399;"><?=date("d M Y",strtotime($ke));?></strong></h1>
			</div>
			<?php if(!isset($_POST['new'])&&!isset($_POST['edit'])){?>
			<form method="post" class="col-md-4">							
				<h1 class="page-header col-md-12"> 				
				<!--<button name="new" class="btn btn-info btn-lg" value="OK" style=" float:right;margin:2px;">New</button>
				<button type="button" onClick="window.close()" class="btn btn-warning btn-lg" style=" float:right; margin:2px;"> Back</button>-->
				<input type="hidden" name="invspayment_id" value="0"/>
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
							<?php if(isset($_POST['edit'])){$namabutton='name="change"';$judul="Update Payment";}else{$namabutton='name="create"';$judul="New Payment";}?>	
							<div class="lead"><h3><?=$judul;?></h3></div>
							<form class="form-horizontal" method="post" enctype="multipart/form-data">
							  <div class="form-group">
								<label class="control-label col-sm-2" for="unit_id">Payment:</label>
								<div class="col-sm-10">
									<select name="methodpayment_id" class="form-control">
									<?php $met=$this->db->get("methodpayment");
									foreach($met->result() as $meth){?>
										<option value="<?=$meth->methodpayment_id;?>" <?=($meth->methodpayment_id==$methodpayment_id)?"selected":"";?>>
											<?=$meth->methodpayment_name;?>
										</option>
									<?php }?>
								  	</select>
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="invspayment_amount">Amount:</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control" id="invspayment_amount" name="invspayment_amount" placeholder="Enter Amount" value="<?=$invspayment_amount;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="invspayment_date">Date:</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control date" id="invspayment_date" name="invspayment_date" placeholder="Enter Date" value="<?=$invspayment_date;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="invspayment_picture">Picture:</label>
								<div class="col-sm-10" align="left"> 
								  <input type="file" class="form-control" id="invspayment_picture" name="invspayment_picture"><br/>
								<?php if($invspayment_picture!=""){$user_image="assets/images/invspayment_picture/".$invspayment_picture;}else{$user_image="assets/img/user.gif";}?>
								  <img id="invspayment_picture_image" width="100" height="100" src="<?=base_url($user_image);?>"/>
								  <script>
								  	function readURL(input) {
										if (input.files && input.files[0]) {
											var reader = new FileReader();
								
											reader.onload = function (e) {
												$('#invspayment_picture_image').attr('src', e.target.result);
											}
								
											reader.readAsDataURL(input.files[0]);
										}
									}
								
									$("#invspayment_picture").change(function () {
										readURL(this);
									});
								  </script>
								</div>
							  </div>
							  <input type="hidden" name="invspayment_id" value="<?=$invspayment_id;?>"/>	
							  <input type="hidden" name="invs_no" value="<?=$this->input->get("invs_no");?>"/>					  					  
							  <div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" id="submit" class="btn btn-primary col-md-5" <?=$namabutton;?> value="OK">Submit</button>
									<button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?=site_url("invspayment");?>">Back</button>
								</div>
							  </div>
							</form>
						</div>
						<?php }else{?>	
							<?php if($message!=""){?>
							<div class="alert alert-info alert-dismissable">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong><?=$message;?></strong><br/><?=$uploadinvspayment_picture;?>
							</div>
							<?php }?>
							<div class="well">
								<form class="form-inline">
								  <div class="form-group">
									<label for="from">From:</label>
									<input type="text" class="form-control date" id="from" name="from" value="<?=$dari;?>">
								  </div>
								  <div class="form-group">
									<label for="to">To:</label>
									<input type="text" class="form-control date" id="to" name="to" value="<?=$ke;?>">
								  </div>
								 
								  <button type="submit" class="btn btn-default fa fa-search"> Search</button>
								  <a target="_blank" href="<?=site_url("spaymentprint?from=".$dari."&to=".$ke);?>" type="submit" class="btn btn-warning fa fa-print"> Print</a>
								</form>
							</div>
							<div class="box">
								<div id="collapse4" class="body table-responsive">				
								<table id="dataTable" class="table table-condensed table-hover table-bordered">
									<thead>
										<tr>
											<th rowspan="2">No.</th>
										  	<th colspan="2">Project</th>
											<th colspan="3">Invoice</th>
											<th colspan="5">Payment</th>
											<th rowspan="2">Debt</th>
										</tr>
										<tr>
										  <th>Name</th>
										  <th>Customer</th>
										  <th>Date</th>
										  <th>No.</th>
									      <th>Amount</th>
									      <th>Method</th>
									      <th>Date</th>
									      <th>Amount</th>
									      <th>Picture</th>
									      <th>Total</th>
									  </tr>
									</thead>
									<tbody> 
										<?php $usr=$this->db
										->join("invspayment","invspayment.invs_no=invs.invs_no","left")
										->join("methodpayment","methodpayment.methodpayment_id=invspayment.methodpayment_id","left")
										->join("project","project.project_id=invs.project_id","left")
										->join("customer","customer.customer_id=project.customer_id","left")
										->where("invspayment_date >=",$dari)
										->where("invspayment_date <=",$ke)
										->order_by("invs_id","desc")
										->order_by("invs_date","asc")
										->order_by("invspayment_date","asc")
										->get("invs");
										//echo $this->db->last_query();
										$no=1;
										foreach($usr->result() as $invspayment){
										//payment
										$rspan=0;
										$invs_pamount=0;
										$pa=$this->db
										->select("*,SUM(invspayment_amount)As invs_pamount, COUNT(invs_no)As rspan")
										->where("invs_no",$invspayment->invs_no)
										->get("invspayment");
										if($pa->num_rows()>0){$rspan=$pa->row()->rspan; $invs_pamount=$pa->row()->invs_pamount;}
										
										//invoice
										$invs_amount=0;
										$inv=$this->db
										->select("*,SUM(invsproduct_price*invsproduct_qty)As invs_amount")
										->where("invs_no",$invspayment->invs_no)
										->group_by("invsproduct_price")
										->get("invsproduct");
										if($inv->num_rows()>0){$invs_amount=$inv->row()->invs_amount;}
										if($no==1){
										?>
										<tr>
											<td><?=$no++;?></td>
										  	<td rowspan="<?=$rspan;?>"><?=$invspayment->project_name;?></td>
											<td rowspan="<?=$rspan;?>"><?=$invspayment->customer_name;?></td>
											<td rowspan="<?=$rspan;?>"><?=$invspayment->invs_date;?></td>
											<td rowspan="<?=$rspan;?>"><?=$invspayment->invs_no;?></td>
											<td rowspan="<?=$rspan;?>"><?=number_format($invs_amount,0,",",".");?></td>
											<td><?=$invspayment->methodpayment_name;?></td>
											<td><?=$invspayment->invspayment_date;?></td>
											<td><?=number_format($invspayment->invspayment_amount,0,",",".");?></td>
											<td>
											<?php if($invspayment->invspayment_picture==""){$invspayment_picture="noimage.png";}else{$invspayment_picture=$invspayment->invspayment_picture;}?>
											<img onClick="tampilimg(this)" src="<?=base_url("assets/images/invspayment_picture/".$invspayment_picture);?>" style="width:25px; height:25px; cursor:pointer; border:grey solid 1px;"/> &nbsp;<a class="btn btn-sm btn-warning fa fa-download" href="<?=base_url("assets/images/invspayment_picture/".$invspayment->invspayment_picture);?>" target="_blank"></a>											</td>
											<td rowspan="<?=$rspan;?>"><?=number_format($invs_pamount,0,",",".");?></td>
											<td rowspan="<?=$rspan;?>"><?=number_format($invs_amount-$invs_pamount,0,",",".");?></td>
										</tr>
										<?php }else{?>
										<tr>
										  <td><?=$invspayment->methodpayment_name;?></td>
										  <td><?=$invspayment->invspayment_date;?></td>
										  <td><?=number_format($invspayment->invspayment_amount,0,",",".");?></td>
										  <td>
											<?php if($invspayment->invspayment_picture==""){$invspayment_picture="noimage.png";}else{$invspayment_picture=$invspayment->invspayment_picture;}?>
											<img onClick="tampilimg(this)" src="<?=base_url("assets/images/invspayment_picture/".$invspayment_picture);?>" style="width:25px; height:25px; cursor:pointer; border:grey solid 1px;"/> &nbsp;<a class="btn btn-sm btn-warning fa fa-download" href="<?=base_url("assets/images/invspayment_picture/".$invspayment->invspayment_picture);?>" target="_blank"></a>											</td>
									  	 
										</tr>
										<?php 
										}
										if($no==$rspan){$no=1;}else{$no++;}
										}?>
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
