<!doctype html>
<html>

<head>
    <?php 	
	require_once("meta.php");
	$month=date("n");
	if(isset($_REQUEST["month"])){
		$month=$_REQUEST["month"];
	}
	
	//bulan		
	$bulan_array = array(0=>"Bulan","Januari","Februari","Maret", "April", "Mei","Juni","Juli","Agustus","September","Oktober", "November","Desember");
	?>
</head>

<body class="  " >
	<?php require_once("header.php");?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">Payroll</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-10">
				<h1 class="page-header">Payroll</h1>
			</div>
			<?php if(!isset($_POST['new'])&&!isset($_POST['edit'])&&!isset($_GET['report'])){?>
			<form method="post" class="col-md-2">							
				<h1 class="page-header col-md-12"> 
				<button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
				<input type="hidden" name="gaji_id"/>
				</h1>
			</form>
			<?php }?>
		</div><!--/.row-->
		
		
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
					<?php if(isset($_POST['new'])||isset($_POST['edit'])&&!isset($_GET['report'])){?>
						<div class="">
							<?php if(isset($_POST['edit'])){$namabutton='name="change"';$judul="Update Payroll";}else{$namabutton='name="create"';$judul="New Payroll";}?>	
							<div class="lead"><h3><?=$judul;?></h3></div>
							<form class="form-horizontal" method="post" enctype="multipart/form-data">
							  <div class="form-group">
								<label class="control-label col-sm-2" for="gaji_name">User:</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control" id="gaji_name" name="gaji_name" placeholder="Enter User" value="<?=$gaji_name;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="gaji_month">Month:</label>
								<div class="col-sm-10">
                                    <select name="gaji_month" class="form-control">
                                        <option <?=($gaji_month==0)?"selected":"";?>>Select Month</option>
                                        <?php for($x=1;$x<=12;$x++){?>
											<option value="<?=$x;?>" <?=($gaji_month==$x) ? "selected" : ((date("m")==$x) ? "selected" : "");?>>
											<?=$bulan_array[$x];?>
										</option>
                                        <?php }?>
                                    </select>
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="gaji_period">Period:</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control" id="gaji_period" name="gaji_period" placeholder="Enter Period" value="<?=$gaji_period;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="gaji_remarks_payment">Payment Remarks:</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control" id="gaji_remarks_payment" name="gaji_remarks_payment" placeholder="Enter Remarks for Payment" value="<?=$gaji_remarks_payment;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="gaji_deduction_name">Deduction For:</label>
								<div class="col-sm-10">
								 <input type="text" autofocus class="form-control" id="gaji_deduction_name" name="gaji_deduction_name" placeholder="Enter Deduction" value="<?=$gaji_deduction_name;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="gaji_deduction_amount">Deduction Amount:</label>
								<div class="col-sm-10">
								 <input type="number" autofocus class="form-control" id="gaji_deduction_amount" name="gaji_deduction_amount" placeholder="Enter Deduction Amount" value="<?=$gaji_deduction_amount;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="gaji_bank">Bank:</label>
								<div class="col-sm-10">
								 <input type="text" autofocus class="form-control" id="gaji_bank" name="gaji_bank" placeholder="Enter Bank" value="<?=$gaji_bank;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="gaji_rek">Bank Account (Rekening):</label>
								<div class="col-sm-10">
								 <input type="text" autofocus class="form-control" id="gaji_rek" name="gaji_rek" placeholder="Enter Account" value="<?=$gaji_rek;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="gaji_remarks_bank">Remarks for Bank:</label>
								<div class="col-sm-10">
								 <input type="text" autofocus class="form-control" id="gaji_remarks_bank" name="gaji_remarks_bank" placeholder="Enter Remarks" value="<?=$gaji_remarks_bank;?>">
								</div>
							  </div>
                              <hr/>
                              <h2>Detail</h2>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="gaji_description">Description:</label>
								<div class="col-sm-10">
								 <input type="text" autofocus class="form-control" id="gaji_description" name="gaji_description" placeholder="Enter Description" value="<?=$gaji_description;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="gaji_basic">Basic (IDR):</label>
								<div class="col-sm-10">
								 <input type="text" autofocus class="form-control" id="gaji_basic" name="gaji_basic" placeholder="Enter Basic" value="<?=$gaji_basic;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="gaji_rate">Rate (IDR):</label>
								<div class="col-sm-10">
								 <input type="text" autofocus class="form-control" id="gaji_rate" name="gaji_rate" placeholder="Enter Rate" value="<?=$gaji_rate;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="gaji_numday">Day of work:</label>
								<div class="col-sm-10">
								 <input type="number" autofocus class="form-control" id="gaji_numday" name="gaji_numday" value="<?=$gaji_numday;?>">
								</div>
							  </div>
                              <hr/>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="gaji_jenis">Employee type:</label>
								<div class="col-sm-10">
								  <select name="gaji_jenis" class="form-control">
                                    <option value="Tetap">Tetap</option>
                                    <option value="Sementara">Sementara</option>
                                  </select>
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="gaji_prepare">Prepared By:</label>
								<div class="col-sm-10">
								 <input type="text" autofocus class="form-control" id="gaji_prepare" name="gaji_prepare"  value="<?=($gaji_prepare!="")?$gaji_prepare:$this->session->userdata("user_name");?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="gaji_approve">Approved By:</label>
								<div class="col-sm-10">
								 <input type="text" autofocus class="form-control" id="gaji_approve" name="gaji_approve"  value="<?=$gaji_approve;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="gaji_receive">Received By:</label>
								<div class="col-sm-10">
								 <input type="text" autofocus class="form-control" id="gaji_receive" name="gaji_receive" value="<?=$gaji_receive;?>">
								</div>
							  </div>
                              <hr/>
                             <div class="form-group">
                                <label class="control-label col-sm-2" for="gaji_source">Pay from:</label>
                                <div class="col-sm-10">
                                    <?php if(isset($_POST['edit'])){$disabled="disabled";?>
                                        <input type="hidden" name="gaji_source" value="<?=$gaji_source;?>"/>
                                        <?php }else{$disabled="";}?>
                                    <select name="gaji_source" class="form-control" <?=$disabled;?>>
                                        <option value="kas_id" <?=($gaji_source=="kas_id")?'selected':"";?> >Big Cash</option>
                                        <option value="petty_id" <?=($gaji_source=="petty_id")?'selected':"";?>>Petty Cash</option>
                                    </select>
                                </div>
                              </div>
                             <?php if($identity->identity_project==1){?>
                             <div class="form-group">
                                <label class="control-label col-sm-2" for="project_id">Project:</label>
                                <div class="col-sm-10">
                                    <select name="project_id" class="form-control">
                                        <option value="0" <?=($project_id=="0")?'selected':"";?> >Choose Project</option>
										<?php $project=$this->db
										->where("project_selesai !=","Selesai")
										->get("project");
										foreach($project->result() as $project){?>
                                        <option value="<?=$project->project_id;?>" <?=($project_id==$project->project_id)?'selected':"";?>><?=$project->project_name;?></option>
										<?php }?>
                                    </select>
                                </div>
                              </div>
                              <?php }?>
							 							  
							  <input type="hidden" name="gaji_id" value="<?=$gaji_id;?>"/>		
							  <input type="hidden" name="petty_id" value="<?=$petty_id;?>"/>	
							  <input type="hidden" name="kas_id" value="<?=$kas_id;?>"/>					  														  					  
							  <div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" id="submit" class="btn btn-primary col-md-5" <?=$namabutton;?> value="OK">Submit</button>
									<button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?=site_url("gaji");?>">Back</button>
								</div>
							  </div>
							</form>
						</div>
						<?php }else{?>	
							<?php if($message!=""){?>
							<div class="alert alert-info alert-dismissable">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong><?=$message;?></strong><br/><?=$uploadgaji_picture;?>
							</div>
							<?php }?>
							<div class="box">
                                <div style="margin-bottom:30px; border-radius:5px; background-color:#FEEFC2; padding:15px;">
                                <form class="form-inline">
                                  <div class="form-group">
                                    <label for="email">From:</label>                                   
                                    <select name="month" class="form-control">
                                    	<?php for($x=1;$x<=12;$x++){?>
                                        <option value="<?=$x;?>" <?=($month==$x)?"selected":"";?>><?=$bulan_array[$x];?></option>
                                        <?php }?>
                                    </select>
                                  </div>                                  
                                 
                                  <?php if(isset($_GET['report'])){?>
                                    <input type="hidden" name="report" value="ok">
                                 <?php }?>
                                  <button style="margin-right:30px;" type="submit" class="btn btn-default">Search</button>
                                  <?php if(isset($_GET['report'])){?>
                                  <a target="_blank" href="<?=site_url("gaji_list_print?report=ok&month=".$month);?>" class="btn btn-success fa fa-print"></a>                                <?php }?>
                                </form>
                            
                                </div>
								<div id="collapse4" class="body table-responsive">				
								<table id="dataTable" class="table table-condensed table-hover">
									<thead>
										<tr>
											<th>No.</th>
											<th>Month</th>
											<th>Branch</th>
											<th>Project</th>
											<th>User</th>
											<th>Payment</th>
											<th>Deduction</th>
											<th>Total Payment</th>
                                            <?php if(!isset($_GET['report'])){?>
											<th class="col-md-2">Action</th>
                                            <?php }?>
										</tr>
									</thead>
									<tbody> 
										<?php 	
										$usr=$this->db
										->join("project","project.project_id=gaji.project_id","left")
										->join("branch","branch.branch_id=gaji.branch_id","left")
										->where("gaji_month",$month)
										->where("gaji_year",date("Y"))
										->order_by("gaji_id","desc")
										->get("gaji");
										//echo $this->db->last_query();
										$no=1;
										foreach($usr->result() as $gaji){
											$bulan = $bulan_array[$gaji->gaji_month];
										?>
										<tr>	
											<td><?=$no++;?></td>										
											<td><?=$bulan;?></td>
											<td><?=$gaji->branch_name;?></td>
											<td><?=$gaji->project_name;?></td>
											<td><?=$gaji->gaji_name;?></td>
											<td><?=number_format($pay=$gaji->gaji_rate*$gaji->gaji_numday,0,",",".");?></td>
											<td><?=number_format($deduction=$gaji->gaji_deduction_amount,0,",",".");?></td>
											<td><?=number_format($pay-$deduction,0,",",".");?></td>
                                             <?php if(!isset($_GET['report'])){?>
											<td style="padding-left:0px; padding-right:0px;">
												
												<form method="post" class="col-md-4" style="padding:0px;">
													<a target="_blank" href="<?=site_url("gaji_print?gaji_no=".$gaji->gaji_no);?>" class="btn  btn-success"><span class="fa fa-print" style="color:white;"></span> </a>													
												</form>
                                                
                                                <form method="post" class="col-md-4" style="padding:0px;">
													<button class="btn  btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
													<input type="hidden" name="gaji_id" value="<?=$gaji->gaji_id;?>"/>
												</form>
											
												<form method="post" class="col-md-4" style="padding:0px;">
													<button class="btn  btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
													<input type="hidden" name="gaji_id" value="<?=$gaji->gaji_id;?>"/>
													<input type="hidden" name="gaji_source" value="<?=$gaji->gaji_source;?>"/>
													<input type="hidden" name="kas_id" value="<?=$gaji->kas_id;?>"/>
													<input type="hidden" name="petty_id" value="<?=$gaji->petty_id;?>"/>
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
