<!doctype html>
<html>

<head>
    <?php 	
	require_once("meta.php");
	$dari=date("Y-m-d");
	$ke=date("Y-m-d");
	$customer_id=0;
	$branch_id=0;
	if(isset($_GET['from'])){$dari=$_GET['from'];}
	if(isset($_GET['to'])){$ke=$_GET['to'];}
	if(isset($_GET['customer_id'])){$customer_id=$_GET['customer_id'];}
	if(isset($_GET['branch_id'])){$branch_id=$_GET['branch_id'];}
	?> 
</head>

<body class="  " >
	<?php require_once("header.php");?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">Payment Invoice Customer</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-8">
				<h1 class="page-header"> Payment Invoice Customer <strong style="color:#003399;"><?=date("d M Y",strtotime($dari));?></strong> to <strong style="color:#003399;"><?=date("d M Y",strtotime($ke));?></strong></h1>
			</div>
			<?php if(!isset($_POST['new'])&&!isset($_POST['edit'])){?>
			<form method="post" class="col-md-4">							
				<h1 class="page-header col-md-12"> 				
				<!--<button name="new" class="btn btn-info btn-lg" value="OK" style=" float:right;margin:2px;">New</button>
				<button type="button" onClick="window.close()" class="btn btn-warning btn-lg" style=" float:right; margin:2px;"> Back</button>-->
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
								<label class="control-label col-sm-2" for="invpayment_amount">Amount:</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control" id="invpayment_amount" name="invpayment_amount" placeholder="Enter Amount" value="<?=$invpayment_amount;?>">
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
							<div class="well">
								<form class="form-inline">
								  <div class="form-group">
									<label for="from">From:</label>
									<input onChange="listinv()" type="text" class="form-control date" id="from" name="from" value="<?=$dari;?>" style="width:100px;">
								  </div>
								  <div class="form-group">
									<label for="to">To:</label>
									<input onChange="listinv()" type="text" class="form-control date" id="to" name="to" value="<?=$ke;?>" style="width:100px;">
								  </div>
								  <div class="form-group">
									<label for="to">&nbsp;</label>
									<select name="customer_id" class="form-control">
                                    	<option value="0">Select Customer</option>
                                    <?php $cus=$this->db->get("customer");
									foreach($cus->result() as $customer){?>
                                    	<option value="<?=$customer->customer_id;?>" <?=(isset($_GET['customer_id'])&&$_GET['customer_id']==$customer->customer_id)?"selected":"";?>><?=$customer->customer_name;?></option>
                                    <?php }	?>
                                    </select>
								  </div>
                                  <div class="form-group">
									<label for="to">&nbsp;</label>
									<select name="branch_id" class="form-control">
                                    	<option value="0">Select Branch</option>
                                    <?php $branc=$this->db->get("branch");
									foreach($branc->result() as $branch){?>
                                    	<option value="<?=$branch->branch_id;?>" <?=(isset($_GET['branch_id'])&&$_GET['branch_id']==$branch->branch_id)?"selected":"";?>><?=$branch->branch_name;?></option>
                                    <?php }	?>
                                    </select>
								  </div>
								  <button type="submit" class="btn btn-default fa fa-search"> Search</button>
								  <a target="_blank" href="<?=site_url("cpaymentprint?from=".$dari."&to=".$ke."&customer_id=".$customer_id);?>" type="submit" class="btn btn-warning fa fa-print"> Print</a>
								  <a id="listinv" target="_blank" href="<?=site_url("listinvoiceprint?from=".$dari."&to=".$ke);?>" type="submit" class="btn btn-info fa fa-print"> List Invoice</a>
								  <script>
								function listinv(){
									$("#listinv").attr("href","<?=site_url("listinvoiceprint?from=");?>"+$("#from").val()+"&to="+$("#to").val());
								}
								</script>  
								</form>
							</div>
							<div class="box">
								<div id="box" class="body " style="overflow-x:scroll;">
									<table id="dataTable" class="table table-condensed table-hover table-bordered">
										<thead>
											<tr>
												<th rowspan="2">No.</th>
												<th colspan="2">Project</th>
												<th colspan="8">Invoice</th>
												<th colspan="6">Payment</th>
												<th rowspan="2">Debt</th>
											</tr>
											<tr>
												<th>Name</th>
												<th>Customer</th>
												<th>Branch</th>
												<th>Date</th>
												<th>Due Date</th>
												<th>No.</th>
												<th>Amount</th>
												<th>PPN 10%</th>
												<th>PPH 2%</th>
												<th>Total</th>
												<th>Method</th>
												<th>Date</th>
												<th>Amount</th>
												<th>Cost</th>
												<th>Picture</th>
												<th>Total</th>
										  </tr>
										</thead>
										<tbody> 
											<?php 
											if(isset($_GET['customer_id'])&&$_GET['customer_id']>0){
												$this->db->where("project.customer_id",$customer_id);
											}
											if(isset($_GET['branch_id'])&&$_GET['branch_id']>0){
												$this->db->where("inv.branch_id",$branch_id);
											}
											$usr=$this->db
											->join("branch","branch.branch_id=inv.branch_id","left")
											->join("project","project.project_id=inv.project_id","left")
											->join("customer","customer.customer_id=project.customer_id","left")
											->join("invpayment","invpayment.inv_no=inv.inv_no","left")
											->join("methodpayment","methodpayment.methodpayment_id=invpayment.methodpayment_id","left")
											->where("invpayment_date >=",$dari)
											->where("invpayment_date <=",$ke)
											->group_by("invpayment_no")
											->order_by("inv_id","desc")
											->order_by("invpayment_date","asc")
											->get("inv");
											
											//echo $this->db->last_query();
											$no=1;
											foreach($usr->result() as $invpayment){
											
											//cost
											$cost=$this->db
											->select("SUM(invcost_amount)AS invcostamount")
											->where("invpayment_no",$invpayment->invpayment_no)
											->group_by("invpayment_no")
											->get("invcost");
											//echo $this->db->last_query();
											if($cost->num_rows()>0){$invcostamount=$cost->row()->invcostamount;}else{$invcostamount=0;}
											
											
											 $project=$invpayment->project_name;
											 $customer=$invpayment->customer_name;
											 $dateinv=$invpayment->inv_date;
											 $branch=$invpayment->branch_name;
											 $duedateinv=$invpayment->inv_duedate;
											 $invno=$invpayment->inv_no;	
											 
											 $inppn=$this->db
											 ->where("inv_no",$invno)
											 ->where("inv_customize",2)
											 ->get("inv");
											 if($inppn->num_rows()>0){$invppn="ok";}else{$invppn="";}
											 
											 
											  $inpph=$this->db
											 ->where("inv_no",$invno)
											 ->where("inv_customize",3)
											 ->get("inv");
											 if($inpph->num_rows()>0){$invpph="ok";}else{$invpph="";}	
											
											
											//payment
											$inv_pamount=0;
											$rspan=0;
											$pa=$this->db->select("*,SUM(invpaymentproduct_amount*invpaymentproduct_qty)As inv_pamount,")
											->where("invpayment_no",$invpayment->invpayment_no)
											->group_by("invpayment_no")
											->get("invpaymentproduct");
											//echo $this->db->last_query();
											if($pa->num_rows()>0){$inv_pamount=$pa->row()->inv_pamount;}
											
											//total payment
											$tpamount=0;
											$tp=$this->db
											->select("*, SUM(inv_pamount)As tinv_pamount")
											->join("(SELECT *,SUM(invpaymentproduct_amount*invpaymentproduct_qty)As inv_pamount FROM invpaymentproduct GROUP BY invpayment_no)As invpaymentproduct","invpaymentproduct.invpayment_no=invpayment.invpayment_no","left")
											->where("inv_no",$invno)
											//->group_by("invpayment_no")
											->order_by("invpayment_date","asc")
											->get("invpayment");
											foreach($tp->result() as $tpa){$tpamount=$tpa->tinv_pamount;}
											
											
											//invoice
											$inv_amount=0;
											$inv=$this->db
											->select("*,SUM(invproduct_price*invproduct_qty)As inv_amount")
											->where("inv_no",$invpayment->inv_no)
											->group_by("invproduct_price")
											->get("invproduct");
											if($inv->num_rows()>0){
												if($invppn=="ok"){
													$ppn=$inv->row()->inv_amount*10/100;
												}else{
													$ppn=0;
												}
												if($invpph=="ok"){
													$pph=$inv->row()->inv_amount*2/100;
												}else{
													$pph=0;
												}
												$amount=$inv->row()->inv_amount;
												$inv_amount=$amount+$ppn-$pph;
											}
											
											$rowspan=$this->db
											->where("inv_no",$invno)
											->get("invpayment");
											$rspan=$rowspan->num_rows();
											if($no==1){
											?>
											<tr>
												<td><?=$no++;?></td>
												<td rowspan="<?=$rspan;?>"><?=$project;?></td>
												<td rowspan="<?=$rspan;?>"><?=$customer;?></td>
												<td rowspan="<?=$rspan;?>"><?=$branch;?></td>
												<td rowspan="<?=$rspan;?>"><?=$dateinv;?></td>
												<td rowspan="<?=$rspan;?>"><?=$duedateinv;?></td>
												<td rowspan="<?=$rspan;?>"><?=$invno;?></td>
												<td rowspan="<?=$rspan;?>"><?=number_format($amount,0,",",".");?></td>
												<td rowspan="<?=$rspan;?>"><?=number_format($ppn,0,",",".");?></td>
												<td rowspan="<?=$rspan;?>"><?=number_format($pph,0,",",".");?></td>
												<td rowspan="<?=$rspan;?>"><?=number_format($inv_amount,0,",",".");?></td>
												<td><?=$invpayment->methodpayment_name;?></td>
												<td><?=$invpayment->invpayment_date;?></td>
												<td><?=number_format($inv_pamount,0,",",".");?></td>
												<td><?=number_format($invcostamount,0,",",".");?></td>
												<td>
												<?php if($invpayment->invpayment_picture==""){$invpayment_picture="noimage.png";}else{$invpayment_picture=$invpayment->invpayment_picture;}?>
												<img onClick="tampilimg(this)" src="<?=base_url("assets/images/invpayment_picture/".$invpayment_picture);?>" style="width:25px; height:25px; cursor:pointer; border:grey solid 1px;"/> &nbsp;<a class="btn btn-sm btn-warning fa fa-download" href="<?=base_url("assets/images/invpayment_picture/".$invpayment->invpayment_picture);?>" target="_blank"></a>											</td>
												<td rowspan="<?=$rspan;?>"><?=number_format($tpamount,0,",",".");?></td>
												<td rowspan="<?=$rspan;?>"><?=number_format($inv_amount-$tpamount,0,",",".");?></td>
											</tr>
											<?php }else{?>
											<tr>
											  <td><?=$invpayment->methodpayment_name;?></td>
											  <td><?=$invpayment->invpayment_date;?></td>
											  <td><?=number_format($inv_pamount,0,",",".");?></td>
											  <td>
												<?php if($invpayment->invpayment_picture==""){$invpayment_picture="noimage.png";}else{$invpayment_picture=$invpayment->invpayment_picture;}?>
												<img onClick="tampilimg(this)" src="<?=base_url("assets/images/invpayment_picture/".$invpayment_picture);?>" style="width:25px; height:25px; cursor:pointer; border:grey solid 1px;"/> &nbsp;<a class="btn btn-sm btn-warning fa fa-download" href="<?=base_url("assets/images/invpayment_picture/".$invpayment->invpayment_picture);?>" target="_blank"></a>											</td>
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
	</div>
	<!-- /#wrap -->
	<?php require_once("footer.php");?>
</body>

</html>
