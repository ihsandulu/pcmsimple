<!doctype html>
<html>

<head>
    <?php 	
	require_once("meta.php");?>
  	<script>
	$(document).ready( function () {
		
	} );
	</script>
</head>

<body class="  " >
	<?php require_once("header.php");?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">Project Report</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-10">
				<h1 class="page-header"> Project Report</h1>
			</div>	
            <form method="post" class="col-md-2">							
				<h1 class="page-header col-md-12"> 
				<a target="_blank" href="<?=site_url("projectreport_print");?>" class="btn btn-warning btn-block btn-lg fa fa-print"> Print</a>
				</h1>
			</form>		
		</div><!--/.row-->
		
		
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
						
							<?php if($message!=""){?>
							<div class="alert alert-info alert-dismissable">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong><?=$message;?></strong><br/><?=$uploadproject_picture;?>
							</div>
							<?php }?>
							<div class="box">
								<div id="collapse4" class="body table-responsive" style="overflow-x:auto;">				
								<table id="dataTable" class="table table-condensed table-hover table-bordered" border="0" style="cursor:pointer;">
									<thead>
										<tr>
											<th>No.</th>
										  	<th>Project</th>
											<th>Customer</th>
											<th>Invoice (Pemasukan)</th>
											<th>Outlay (Pengeluaran)</th>
										  <th>Keuntungan Project (Budget-Biaya)</th>
										  <th>Estimates (Perencanaan Awal)</th>
										  <th>Pencapaian (%)</th>
										  <th>Profit (Terbayar-Biaya)</th>
											<?php if(!isset($_GET['report'])){$col="col-md-2";}else{$col="col-md-1";}?>
										</tr>
									</thead>
									<tbody> 
										<?php $usr=$this->db
										->join("customer","customer.customer_id=project.customer_id","left")
										->order_by("project_datetime", "desc")
										->order_by("project_id","desc")
										->get("project");
										
										$tnumproj=$usr->num_rows();
										$no=1;
										
										foreach($usr->result() as $project){
										$totalproject=0;	
										$projectterbayar=0;	
										$totalpay=0;
										$profit=0;
										$nopip=1;
										$noppap=1;										
											?>
											<tr>
												<td><?=$no;?></td>
											  	<td><?="(".$project->project_code.") ".$project->project_name;?><br/><br/>Budget :<br/><strong>Rp <?=number_format($project->project_budget,2,",",".");?></strong></td>
												<td><?=$project->customer_name;?></td>
												<td style="padding:0px;">
                                                
                                                <table id="dataTable" class="table table-condensed table-hover">
													<thead>
														<tr>
															<th>Date</th>
															<th>Description</th>
															<th>Amount</th>
														</tr>
													</thead>
													<tbody> 
														<?php 
														$usr=$this->db
														->select("*,kas.customer_id AS cid")
														->join("project","project.project_id=kas.project_id","left")
														->where("kas.project_id",$project->project_id)
														->where("kas.kas_inout","in")
														->order_by("kas_id","asc")
														->get("kas");
														$no=2;
														
														foreach($usr->result() as $kas){																																		
														?>														
														<tr>											
															<td><?=$kas->kas_date;?></td>
															<td style="text-align:left;"><?=$kas->kas_remarks;?></td>
															<td style="text-align:right;"><?=number_format($kas->kas_count,0,",",".");?></td>
														</tr>
														<?php }?>
													</tbody>
												</table> 
												
												<!--<table border="0"> 
                                                <thead>
                                                <tr>
                                                  <th  style="width:10px;">Date</th  style="width:10px;">
                                                  <th  style="width:20px;">Inv No.</th  style="width:10px;">
                                                  <th  style="width:10px;">Description</th  style="width:10px;">
                                                  <th  style="width:10px;">Qty</th  style="width:10px;">
                                                  <th  style="width:10px;">Amount</th  style="width:10px;">
                                                  <th  style="width:10px;">Sub Total</th  style="width:10px;">
                                                  <th  style="width:10px;">Discount</th  style="width:10px;">
                                                  <th  style="width:10px;">Total</th  style="width:10px;">
                                                  <th  style="width:10px;">PPN</th  style="width:10px;">
                                                  <th  style="width:10px;">PPH</th  style="width:10px;">
                                                  <th  style="width:10px;">Total INV</th  style="width:10px;">
                                                  <th  style="width:10px;">Terbayar</th  style="width:10px;">
                                                  <th  style="width:10px;">Sisa</th  style="width:10px;">
                                                  <th  style="width:30px !important;">Invoice Project</th>
                                                  <th  style="width:30px !important;">Project Terbayar</th>
                                                  <th  style="width:30px !important;">Sisa Project</th>
                                                </tr>
                                                </thead>                                                 
                                                  <tbody>
                                                  <?php
												  $in=$this->db
												  	->join("project","project.project_id=inv.project_id","left")
													->where("inv.project_id",$project->project_id)
													->get("inv");
													//echo $this->db->last_query();
													foreach($in->result() as $inv){
														$discount=$inv->inv_discount;
														
														//cek pembayaran
														$bayar=0;
														$payment=$this->db
														->join("invpaymentproduct","invpaymentproduct.invpayment_no=invpayment.invpayment_no","left")
														->where("inv_no",$inv->inv_no)
														->get("invpayment");
														foreach($payment->result() as $payment){$bayar+=$payment->invpaymentproduct_qty*$payment->invpaymentproduct_amount;}
													
														$totalpay=0;
													
														$cekppn=$inv->inv_ppn;
														
														$cekpph=$inv->inv_pph;
														if($cekppn>0){$ppn=10/100;}else{$ppn=0;}
														if($cekpph>0){$pph=2/100;}else{$pph=0;}
														
														
														if($identity->identity_project==1&&$inv->inv_showproduct==1){
														
															$inp=$this->db
															->join("product","product.product_id=invproduct.product_id","left")
															->where("inv_no",$inv->inv_no)
															->get("invproduct");
															
															$inpnr=$inp->num_rows();
															$subinv=0;
															$numinv=1;
															$noip=1;
															$totalinv=0;
															$tin=0;
															foreach($inp->result() as $sinvp){
															$ssubinv=$sinvp->invproduct_qty*$sinvp->invproduct_price;
															$totalinv+=$ssubinv;
															}
															$totalinv-=$discount;
															//echo $this->db->last_query();
														
															foreach($inp->result() as $invp){												
																$subinv=$invp->invproduct_qty*$invp->invproduct_price;														
																?>
																<tr style="border:black solid 1px;">
																<?php if($noip==1){?>
																  <td style="border:#CCCCCC solid 1px;" rowspan="<?=$inpnr;?>"><?=($numinv==1)?$inv->inv_date:"";?></td>
																  <td style="border:#CCCCCC solid 1px;" rowspan="<?=$inpnr;?>"><?=($numinv==1)?$inv->inv_no:"";?></td>
																  <?php }?>
																  <td style="border:#CCCCCC solid 1px;"><?=$invp->product_name;?></td>
																  <td style="border:#CCCCCC solid 1px;"><?=$invp->invproduct_qty;?></td>
																  <td style="border:#CCCCCC solid 1px;"><?=number_format($invp->invproduct_price,2,",",".");?></td>
																  <td style="border:#CCCCCC solid 1px;"><?=number_format($subinv,2,",",".");?></td>
																  <?php if($noip==1){?>
																  <td style="border:#CCCCCC solid 1px;" rowspan="<?=$inpnr;?>"><?=number_format($discount,2,",",".");?></td>
																  <td style="border:#CCCCCC solid 1px;" rowspan="<?=$inpnr;?>"><?=number_format($totalinv,2,",",".");?></td>
																  <td style="border:#CCCCCC solid 1px;" rowspan="<?=$inpnr;?>"><?=number_format($tppn=$totalinv*$ppn,2,",",".");?></td>
																  <td style="border:#CCCCCC solid 1px;" rowspan="<?=$inpnr;?>"><?=number_format($tpph=$totalinv*$pph,2,",",".");?></td>
																  <td style="border:#CCCCCC solid 1px;" rowspan="<?=$inpnr;?>"><?=number_format($tin=$totalinv+$tppn-$tpph,2,",",".");$totalproject+=$totalinv+$tppn-$tpph;?></td>
																  <td style="border:#CCCCCC solid 1px;" rowspan="<?=$inpnr;?>"><?=number_format($bayar,2,",",".");$projectterbayar+=$bayar;?></td> 
																  <td style="border:#CCCCCC solid 1px;" rowspan="<?=$inpnr;?>"><?=number_format($tin-$bayar,2,",",".");?></td>
																  <?php }?>
																  <?php if($nopip==1){?>
																  <td class="span<?=$no;?>" id="nopip<?=$no;?>" style="border:#CCCCCC solid 1px;" rowspan="<?=$nopip;?>"></td> 
																  <td class="span<?=$no;?>" id="terbayar<?=$no;?>" style="border:#CCCCCC solid 1px;" rowspan="<?=$nopip;?>"></td> 
																  <td class="span<?=$no;?>" id="sisa<?=$no;?>" style="border:#CCCCCC solid 1px;" rowspan="<?=$nopip;?>"></td> 
																  <?php }?>
																</tr>													   
																<?php 
																$noip++;
																$nopip++;
															 }
													 	}elseif($identity->identity_project==1&&$inv->inv_showproduct==2){
														
															$inpnr=1;
															$subinv=$inv->project_budget;
															$numinv=1;
															$noip=1;
															$totalinv=0;
															$tin=0;
															$ssubinv=$inv->project_budget;
															$totalinv+=$ssubinv;
															$totalinv-=$discount;
															//echo $this->db->last_query();	
														?>
														<tr style="border:black solid 1px;">
														<?php if($noip==1){?>
														  <td style="border:#CCCCCC solid 1px;" rowspan="<?=$inpnr;?>"><?=($numinv==1)?$inv->inv_date:"";?></td>
														  <td style="border:#CCCCCC solid 1px;" rowspan="<?=$inpnr;?>"><?=($numinv==1)?$inv->inv_no:"";?></td>
														  <?php }?>
														  <td style="border:#CCCCCC solid 1px;"><?=$inv->project_name;?></td>
														  <td style="border:#CCCCCC solid 1px;">1</td>
														  <td style="border:#CCCCCC solid 1px;"><?=number_format($inv->project_budget,2,",",".");?></td>
														  <td style="border:#CCCCCC solid 1px;"><?=number_format($subinv,2,",",".");?></td>
														  <?php if($noip==1){?>
														  <td style="border:#CCCCCC solid 1px;" rowspan="<?=$inpnr;?>"><?=number_format($discount,2,",",".");?></td>
														  <td style="border:#CCCCCC solid 1px;" rowspan="<?=$inpnr;?>"><?=number_format($totalinv,2,",",".");?></td>
														  <td style="border:#CCCCCC solid 1px;" rowspan="<?=$inpnr;?>"><?=number_format($tppn=$totalinv*$ppn,2,",",".");?></td>
														  <td style="border:#CCCCCC solid 1px;" rowspan="<?=$inpnr;?>"><?=number_format($tpph=$totalinv*$pph,2,",",".");?></td>
														  <td style="border:#CCCCCC solid 1px;" rowspan="<?=$inpnr;?>"><?=number_format($tin=$totalinv+$tppn-$tpph,2,",",".");$totalproject+=$totalinv+$tppn-$tpph;?></td>
														  <td style="border:#CCCCCC solid 1px;" rowspan="<?=$inpnr;?>"><?=number_format($bayar,2,",",".");$projectterbayar+=$bayar;?></td> 
														  <td style="border:#CCCCCC solid 1px;" rowspan="<?=$inpnr;?>"><?=number_format($tin-$bayar,2,",",".");?></td>
														  <?php }?>
														  <?php if($nopip==1){?>
														  <td class="span<?=$no;?>" id="nopip<?=$no;?>" style="border:#CCCCCC solid 1px;" rowspan="<?=$nopip;?>"></td> 
														  <td class="span<?=$no;?>" id="terbayar<?=$no;?>" style="border:#CCCCCC solid 1px;" rowspan="<?=$nopip;?>"></td> 
														  <td class="span<?=$no;?>" id="sisa<?=$no;?>" style="border:#CCCCCC solid 1px;" rowspan="<?=$nopip;?>"></td> 
														  <?php }?>
														</tr>
                                                   
                                                 		<?php 
														 $noip++;
														 $nopip++;
													 
													 	}
												 }?>
                                                    <script>
													$(".span<?=$no;?>").attr("rowspan","<?=$nopip;?>");
													$("#nopip<?=$no;?>").text("<?=number_format($totalproject,2,",",".");?>");
													$("#terbayar<?=$no;?>").text("<?=number_format($projectterbayar,2,",",".");?>");
													$("#sisa<?=$no;?>").text("<?=number_format($project->project_budget-$projectterbayar,2,",",".");?>");
													</script>
                                                  </tbody>
                                                </table>-->
                                                                                             
                                                </td>
												<td style="padding:0px;">
                                                <table id="dataTable" class="table table-condensed table-hover">
													<thead>
														<tr>
															<th>Date</th>
															<th>Description</th>
															<th>Amount</th>
														</tr>
													</thead>
													<tbody> 
														<?php 
														$usr=$this->db
														->select("*,kas.customer_id AS cid")
														->join("project","project.project_id=kas.project_id","left")
														->where("kas.project_id",$project->project_id)
														->where("kas.kas_inout","in")
														->order_by("kas_id","asc")
														->get("kas");
														$no=2;
														
														foreach($usr->result() as $kas){																																		
														?>														
														<tr>											
															<td><?=$kas->kas_date;?></td>
															<td style="text-align:left;"><?=$kas->kas_remarks;?></td>
															<td style="text-align:right;"><?=number_format($kas->kas_count,0,",",".");?></td>
														</tr>
														<?php }?>
													</tbody>
												</table>
                                                <!--<table border="0" style="margin:0px;">
                                                  <thead>
                                                    <tr>
                                                      <th  style="width:10px;">Date</th  style="width:10px;">
                                                      <th  style="width:10px;">Description</th  style="width:10px;">
                                                      <th  style="width:10px;">Qty</th  style="width:10px;">
                                                      <th  style="width:10px;">Amount</th  style="width:10px;">
                                                      <th  style="width:10px;">Total Amount</th  style="width:10px;">
                                                      <th  style="width:10px;">Total Outlay</th  style="width:10px;">
                                                      <th  style="width:10px;">OutlayProject</th  style="width:10px;">
                                                    </tr>
                                                  </thead>
                                                  <tbody>
                                                    <?php
												  $pa=$this->db
													->where("project_id",$project->project_id)
													->get("invspayment");
													foreach($pa->result() as $pay){
														
														$pap=$this->db
														->where("invspayment_no",$pay->invspayment_no)
														->get("invspaymentproduct");
														//echo $this->db->last_query();
														$papnr=$pap->num_rows();
														$subpa=0;
														$numpa=1;
														$nopp=1;
														$totalpa=0;
														foreach($pap->result() as $spap){
														$ssubpa=$spap->invspaymentproduct_qty*$spap->invspaymentproduct_amount;
														$totalpa+=$ssubpa;
														}
														foreach($pap->result() as $payp){												
														$subpa=$payp->invspaymentproduct_qty*$payp->invspaymentproduct_amount;														
														?>
                                                    <tr>
                                                      <?php if($nopp==1){?>
                                                      <td style="border:#CCCCCC solid 1px;" rowspan="<?=$papnr;?>"><?=($numpa==1)?$pay->invspayment_date:"";?></td>
                                                      <?php }?>
                                                      <td style="border:#CCCCCC solid 1px;"><?=$payp->invspaymentproduct_description;?></td>
                                                      <td style="border:#CCCCCC solid 1px;"><?=$payp->invspaymentproduct_qty;?></td>
                                                      <td style="border:#CCCCCC solid 1px;"><?=number_format($payp->invspaymentproduct_amount,2,",",".");?></td>
                                                      <td style="border:#CCCCCC solid 1px;"><?=number_format($subpa,2,",",".");?></td>
                                                      <?php if($nopp==1){?>
                                                      <td style="border:#CCCCCC solid 1px;" rowspan="<?=$papnr;?>"><?=number_format($totalpa,2,",",".");$totalpay+=$totalpa;?></td>
                                                      <?php }?>
                                                      <?php if($noppap==1){?>
                                                      <td id="noppap<?=$no;?>" style="border:#CCCCCC solid 1px;" rowspan="">&nbsp;</td>
                                                      <?php }?>
                                                    </tr>
                                                   		
                                                    <script>
													$("#noppap<?=$no;?>").attr("rowspan","<?=$noppap;?>");
													$("#noppap<?=$no;?>").text("<?=number_format($totalpay,2,",",".");?>");
													</script>
                                                    <?php $nopp++;$noppap++;}}?>
                                                  </tbody>
                                                </table>-->
                                                
                                              	</td>
                                                <?php 
												$keuntunganproject=$project->project_budget-$totalpay;
												$profit=$projectterbayar-$totalpay;
												if($profit<0){$bgcolor="background-color:#FF6600;";}else{$bgcolor="";}
												
												
												$esdebet=$this->db
												->select("SUM(estimasi_mount)AS totdeb")
												->where("estimasi_type","Debet")
												->where("project_id",$project->project_id)
												->get("estimasi");
												$esdeb=0;
												foreach($esdebet->result() as $esdebet){$esdeb=$esdebet->totdeb;}
												
												$eskredit=$this->db
												->select("SUM(estimasi_mount)AS totkre")
												->where("estimasi_type","Kredit")
												->where("project_id",$project->project_id)
												->get("estimasi");
												$eskre=0;
												foreach($eskredit->result() as $eskredit){$eskre=$eskredit->totkre;}
												
												$estotal=$esdeb-$eskre;
												if($estotal==0){
													$stotal=1;
													$pencapaian=100;
												}else{
													$stotal=$estotal;
													$pencapaian=($keuntunganproject/$stotal)*100;
												}
												?>
												<td style="<?=$bgcolor;?>"><?=number_format($keuntunganproject,2,",",".");?></td>
												<td style="<?=$bgcolor;?>"><?=number_format($estotal,2,",",".");?></td>
												<td style="<?=$bgcolor;?>"><?=number_format($pencapaian,2,",",".");?> %</td>
												<td style="<?=$bgcolor;?>"><?=number_format($profit,2,",",".");?></td>
											</tr>
									<?php 
									$no++;
									}?>
									</tbody>
								</table>
							  </div>
							</div>
						
					</div>
				</div>
			</div>
		</div>
	
	<!-- /#wrap -->
	<?php require_once("footer.php");?>
</body>

</html>
