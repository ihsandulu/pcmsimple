<!doctype html>
<html>

<head>
    <?php 	
	require_once("meta.php");
	if(!isset($_GET["inv_no"])){
		$listjudul="Pemasukan";
		$judul="Pemasukan";
	}else{
		$listjudul="Payment Invoice Customer";
		$judul="Payment Invoice Customer No. ".$this->input->get("inv_no");
	}
	?>
</head>

<body class="  " >
	<?php require_once("header.php");?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active"><?=$listjudul;?></li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-8">
				<h1 class="page-header"> <?=$judul;?></h1>
			</div>
			<?php if(!isset($_POST['new'])&&!isset($_POST['edit'])){?>
			<form method="post" class="col-md-4">							
				<h1 class="page-header col-md-12"> 				
				<button name="new" class="btn btn-info btn-lg" value="OK" style=" float:right;margin:2px;">New</button>
				<?php if(isset($_GET["inv_no"])){?>
				<button type="button" onClick="window.close()" class="btn btn-warning btn-lg" style=" float:right; margin:2px;"> Back</button>
				<?php }?>
				<input type="hidden" name="invpayment_id" value="0"/>
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
                            <?php 
							if(isset($_GET['inv_no'])){$invno="inv_no=".$_GET['inv_no'];}else{$invno="";}
							if(isset($_GET['customer_id'])){$customerid="&customer_id=".$_GET['customer_id'];}else{$customerid="";}
							?>
							<form action="<?=site_url("invpayment?".$invno.$customerid);?>" class="form-horizontal" method="post" enctype="multipart/form-data">
								
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
								<label class="control-label col-sm-2" for="invpayment_payfrom">Pay From :</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control" id="invpayment_payfrom" name="invpayment_payfrom"  value="<?=$invpayment_payfrom;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="invpayment_prepareby">Prepared By :</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control" id="invpayment_prepareby" name="invpayment_prepareby"  value="<?=$invpayment_prepareby;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="invpayment_receivedby">Received By :</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control" id="invpayment_receivedby" name="invpayment_receivedby"  value="<?=$invpayment_receivedby;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="invpayment_approvedby">Approve By :</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control" id="invpayment_approvedby" name="invpayment_approvedby"  value="<?=$invpayment_approvedby;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="invpayment_faktur">Faktur Pajak :</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control" id="invpayment_faktur" name="invpayment_faktur"  value="<?=$invpayment_faktur;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="invpayment_date">Date:</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control date" id="invpayment_date" name="invpayment_date" placeholder="Enter Date" value="<?=$invpayment_date;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="invpayment_picture">Picture:</label>
								<div class="col-sm-10" align="left"> 
								  <input type="file" class="form-control" id="invpayment_picture" name="invpayment_picture"><br/>
								<?php if($invpayment_picture!=""){$user_image="assets/images/invpayment_picture/".$invpayment_picture;}else{$user_image="assets/img/user.gif";}?>
								  <img id="invpayment_picture_image" width="100" height="100" src="<?=base_url($user_image);?>"/>
								  <script>
								  	function readURL(input) {
										if (input.files && input.files[0]) {
											var reader = new FileReader();
								
											reader.onload = function (e) {
												$('#invpayment_picture_image').attr('src', e.target.result);
											}
								
											reader.readAsDataURL(input.files[0]);
										}
									}
								
									$("#invpayment_picture").change(function () {
										readURL(this);
									});
								  </script>
								</div>
							  </div>
							  <input type="hidden" name="invpayment_id" value="<?=$invpayment_id;?>"/>	
							  <input type="hidden" name="inv_no" value="<?=$this->input->get("inv_no");?>"/>					  					  
							  <div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" id="submit" class="btn btn-primary col-md-5" <?=$namabutton;?> value="OK">Submit</button>
									<button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?=site_url("invpayment");?>">Back</button>
								</div>
							  </div>
							</form>
						</div>
						<?php }else{?>	
							<?php if($message!=""){?>
							<div class="alert alert-info alert-dismissable">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong><?=$message;?></strong><br/><?=$uploadinvpayment_picture;?>
							</div>
							<?php }?>
							<div class="box">
								<div id="collapse4" class="body table-responsive">				
								<table id="dataTable" class="table table-condensed table-hover">
									<thead>
										<tr>
											<th>No.</th>
										  	<th>Date</th>
											<th>Payment No. </th>
											<th>Faktur Pajak</th>
											<th>Payment</th>
											<th>Amount</th>
											<th>Cost</th>
											<th>Picture</th>
											<th class="col-md-2">Action</th>
										</tr>
									</thead>
									<tbody> 
										<?php 
										if(isset($_GET['inv_no'])){											
											$this->db->where("inv_no",$this->input->get("inv_no"));
										}else{
											$this->db->where("inv_no","");
										}
										$usr=$this->db
										->join("methodpayment","methodpayment.methodpayment_id=invpayment.methodpayment_id","left")		
										->order_by("invpayment_date","asc")
										->order_by("invpayment_id","asc")						
										->get("invpayment");
										//echo $this->db->last_query();
										$no=1;
										foreach($usr->result() as $invpayment){
											$invppro_amount=0;
											$pr=$this->db
											->select("*,SUM(invpaymentproduct_amount*invpaymentproduct_qty)As invppro_amount")
											->where("invpayment_no",$invpayment->invpayment_no)
											->group_by("invpayment_no")
											->get("invpaymentproduct");
											//echo $this->db->last_query();die();
											if($pr->num_rows()>0){$invppro_amount=$pr->row()->invppro_amount;}
											
											//cost
											$cost=$this->db
											->select("SUM(invcost_amount)AS invcostamount")
											->where("invpayment_no",$invpayment->invpayment_no)
											->group_by("invpayment_no")
											->get("invcost");
											//echo $this->db->last_query();
											if($cost->num_rows()>0){$invcostamount=$cost->row()->invcostamount;}else{$invcostamount=0;}
										?>
										<tr>
											<td><?=$no;?></td>
										  	<td><?=$invpayment->invpayment_date;?></td>											
											<td><?=$invpayment->invpayment_no;?></td>									
											<td><?=$invpayment->invpayment_faktur;?></td>
											<td><?=$invpayment->methodpayment_name;?></td>
											<td><?=number_format($invppro_amount,0,",",".");?></td>
											<td><?=number_format($invcostamount,0,",",".");?></td>
											<td>
											<?php if($invpayment->invpayment_picture==""){$invpayment_picture="noimage.png";}else{$invpayment_picture=$invpayment->invpayment_picture;}?>
											<img onClick="tampilimg(this)" src="<?=base_url("assets/images/invpayment_picture/".$invpayment_picture);?>" style="width:25px; height:25px; cursor:pointer; border:grey solid 1px;"/>
											<?php if($invpayment->invpayment_picture!=""){?>
											&nbsp;<a class="btn btn-sm btn-warning fa fa-download" href="<?=base_url("assets/images/invpayment_picture/".$invpayment->invpayment_picture);?>" target="_blank"></a>
											<?php }?>											</td>
											<td style="padding-left:0px; padding-right:0px;">	 
												<form method="POST" class="col-md-2" style="padding:0px;">
												<?php if(isset($_GET['inv_no'])){$inv_no=$_GET['inv_no'];}else{$inv_no="";}?>
												<?php if(isset($_GET['customer_id'])){$customer_id=$_GET['customer_id'];}else{$customer_id="";}?>
												  <a data-toggle="tooltip" title="List Payment" target="_blank" href="<?=site_url("invpaymentproduct?invpayment_no=".$invpayment->invpayment_no."&inv_no=".$inv_no."&customer_id=".$customer_id);?>" class="btn btn-sm btn-info" style="margin:0px;">
												  <span class="fa fa-shopping-bag" style="color:white;"></span>											  </a>
												</form> 
												<form method="POST" class="col-md-2" style="padding:0px;">
												  <a data-toggle="tooltip" title="Cost" target="_blank" href="<?=site_url("invcost?invpayment_no=".$invpayment->invpayment_no."&inv_no=".$inv_no."&customer_id=".$customer_id);?>" class="btn btn-sm btn-info" style="margin:0px;">
												  <span class="fa fa-dollar" style="color:white;"></span>											  </a>
												</form> 		 
												<form method="POST" class="col-md-2" style="padding:0px;">
												  <a data-toggle="tooltip" title="Print Kwitansi" target="_blank" href="<?=site_url("invpaymentprint?nom=".$no++."&invpayment_no=".$invpayment->invpayment_no);?>" class="btn btn-sm btn-success" style="margin:0px;">
												  <span class="fa fa-print" style="color:white;"></span>											  </a>
												</form> 	
												<form method="post" class="col-md-2" style="padding:0px;">
													<button class="btn btn-sm btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;margin:0px;"></span> </button>
													<input type="hidden" name="invpayment_id" value="<?=$invpayment->invpayment_id;?>"/>
												</form>
											
												<form method="post" class="col-md-2" style="padding:0px;">
													<button class="btn btn-sm btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;margin:0px;"></span> </button>
													<input type="hidden" name="invpayment_id" value="<?=$invpayment->invpayment_id;?>"/>
													<input type="hidden" name="invpayment_no" value="<?=$invpayment->invpayment_no;?>"/>
												</form>											</td>
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
