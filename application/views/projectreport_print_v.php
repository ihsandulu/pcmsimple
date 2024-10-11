<!DOCTYPE html>
<html>
	<head>
		<title>Print Project Report</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="<?=base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet">	
		<script src="<?=base_url("assets/js/jquery-1.11.1.min.js");?>"></script>
		<script src="<?=base_url('assets/js/bootstrap-datepicker.js');?>"></script>
		<style>
		.border{border:black solid 1px;}
		td,th{padding:5px;}
		tr{border:black solid 1px;}
		th{text-align:center;}
		</style>
	</head>
	<body>
	
    <h1>Project Report</h1>
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
										$pemasukan=0;	
										$pengeluaran=0;									
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
														//echo $this->db->last_query();													
														foreach($usr->result() as $kas){																																		
														?>														
														<tr>											
															<td><?=$kas->kas_date;?></td>
															<td style="text-align:left;"><?=$kas->kas_remarks;?></td>
															<td style="text-align:right;"><?=number_format($kas->kas_count,0,",",".");$pemasukan+=$kas->kas_count;?></td>
														</tr>
														<?php }?>
														<?php 
														$usr=$this->db
														->select("*,petty.customer_id AS cid")
														->join("project","project.project_id=petty.project_id","left")
														->where("petty.project_id",$project->project_id)
														->where("petty.petty_inout","in")
														->order_by("petty_id","asc")
														->get("petty");	
														//echo $this->db->last_query();													
														foreach($usr->result() as $petty){																																		
														?>														
														<tr>											
															<td><?=$petty->petty_date;?></td>
															<td style="text-align:left;"><?=$petty->petty_remarks;?></td>
															<td style="text-align:right;"><?=number_format($petty->petty_amount,0,",",".");$pemasukan+=$petty->petty_amount;?></td>
														</tr>
														<?php }?>
													</tbody>
													<tfoot>																												
														<tr>											
															<td colspan="2" style="text-align:right; font-weight:bold;">Total : </td>
															<td style="text-align:right;"><?=number_format($pemasukan,0,",",".");?></td>
														</tr>
													</tfoot>
												</table>                                
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
														->where("kas.kas_inout","out")
														->order_by("kas_id","asc")
														->get("kas");
														foreach($usr->result() as $kas){																																		
														?>														
														<tr>											
															<td><?=$kas->kas_date;?></td>
															<td style="text-align:left;"><?=$kas->kas_remarks;?></td>
															<td style="text-align:right;"><?=number_format($kas->kas_count,0,",",".");$pengeluaran+=$kas->kas_count;?></td>
														</tr>
														<?php }?>
														<?php 
														$usr=$this->db
														->select("*,petty.customer_id AS cid")
														->join("project","project.project_id=petty.project_id","left")
														->where("petty.project_id",$project->project_id)
														->where("petty.petty_inout","out")
														->order_by("petty_id","asc")
														->get("petty");	
														//echo $this->db->last_query();													
														foreach($usr->result() as $petty){																																		
														?>														
														<tr>											
															<td><?=$petty->petty_date;?></td>
															<td style="text-align:left;"><?=$petty->petty_remarks;?></td>
															<td style="text-align:right;"><?=number_format($petty->petty_amount,0,",",".");$pengeluaran+=$petty->petty_amount;?></td>
														</tr>
														<?php }?>
													</tbody>
													<tfoot>																												
														<tr>											
															<td colspan="2" style="text-align:right; font-weight:bold;">Total : </td>
															<td style="text-align:right;"><?=number_format($pengeluaran,0,",",".");?></td>
														</tr>
													</tfoot>
												</table>                                                
                                              	</td>
                                                <?php 
												$keuntunganproject=$pemasukan-$pengeluaran;
												$profit=$projectterbayar-$pengeluaran;
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
											</tr>
									<?php 
									$no++;
									}?>
									</tbody>
								</table>		
	
	</body>
</html>
<script>
window.print();
setTimeout(function(){ this.close(); }, 500);
</script>